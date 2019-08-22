#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: Mailer.pm
#  Description: A SMTP/Sendmail mailer module.
#       Author: Alex Krohn
#        Email: alex@gossamer-threads.com
#          Web: http://www.gossamer-threads.com/
#      Version: 2.01
#
# (c) 1998 Gossamer Threads Inc. 
#
# This script is not freeware! Please read the README for full details
# on registration and terms of use. 
# =====================================================================

package Mailer;
# ===============================================================
    use strict;
    use Socket;
    use FileHandle; 
    use vars qw($VERSION $error $CRLF @ISA @EXPORT);    # Globals.
    @ISA    = ();                                       # Not inhereited.
    @EXPORT = qw();
    $Mailer::VERSION = '1.0';
    $CRLF            = "\015\012"; 

sub new {
# ---------------------------------------------------------------
# Class constructor.
#
    my $this  = shift;
    my $class = ref($this) || $this;
    my $self  = {};
    bless  $self, $class;
    return $self->initialize(@_);
}

sub error {
# ---------------------------------------------------------------
# Sets possible error messages.
#   
    my ($errtype, $e1, $e2) = @_;
    my %errors = (
                HOSTNOTFOUND     => "SMTP: server '$e1' was not found.",
                SOCKFAILED       => "SMTP: socket() failed. reason: $e1",
                CONNFAILED       => "SMTP: connect() failed. reason: $e1",
                SERVNOTAVAIL     => "SMTP: Service not available.",
                COMMERROR        => "SMTP: Unspecified communications error.",
                USERUNKOWN       => "SMTP: Local user '$e1' unkown on host '$e2'.",
                TRANSFAILED      => "SMTP: Transmission of message failed.",
                TOEMPTY          => "No To: field specified.",
                NOMSG            => "No message body specified",
                SENDMAILNOTFOUND => "Sendmail was not defined or not found: $e1",
                NOOPTIONS        => "No options were specified. Be sure to pass a hash ref to send()",
                NOTRANSPORT      => "Neither sendmail nor SMTP were specified!",
                BADLOG           => "Unable to write to logfile '$e1'. Reason: $e2"
    );
    $Mailer::error = $errors{$errtype};

    return -1;
}

sub initialize {
# ---------------------------------------------------------------
# Initilize object.
#
    my $self = shift;

# Load the parameters.  
    ($#_ < 0) and return $self;
    if (ref $_[0] eq 'HASH') {
        my $key; my $hash = $_[0];
        foreach $key (keys %$hash) {
            $self->{lc $key} = $hash->{$key};
        }
    }
    else { &error ('NOOPTIONS'); return undef; }

# Make sure the email addresses are clean.
    $self->{'from'}  = &clean_email ($self->{'from'});
    $self->{'reply'} = &clean_email ($self->{'reply'});
    $self->{'to'}    = &clean_email ($self->{'to'});

# Determine if we are using SMTP or Sendmail.   
    if (exists $self->{'smtp'} and ($self->{'smtp'} =~ /\w+/)) {
        $self->{'mode'}  = 'SMTP';
        $self->{'proto'} = (getprotobyname('tcp'))[2];          # Get protocol and port values if we are using SMTP to send mail.
        $self->{'port'}  = getservbyname('smtp', 'tcp');        # Get the ip address of the SMTP server.
        $self->{'smtp'} =~ s/^\s+//g; 
        $self->{'smtp'} =~ s/\s+$//g;
        $self->{'smtpaddr'} = ($self->{'smtp'} =~ /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/) ? 
            pack('C4',$1,$2,$3,$4) : (gethostbyname($self->{'smtp'}))[4];
        unless (defined $self->{'smtpaddr'}) {
            &error ('HOSTNOTFOUND', $self->{'smtp'});
            return undef;
        }
    }
    elsif (exists $self->{'sendmail'} and ($self->{'sendmail'} =~ /\w+/)) { 
# If we don't have parameters for sendmail, just check if it exists and
# then add default -oeq -odq -t. Otherwise, strip them off and check to make
# sure sendmail exists.
        if ($self->{'sendmail'} =~ /^\S+$/) {
            unless (-e $self->{'sendmail'}) {
                &error ('SENDMAILNOTFOUND', $self->{'sendmail'});
                return undef; 
            }
            $self->{'sendmail'} = $self->{'sendmail'} . " -oeq -t";
        }
        else {
            if ($self->{'sendmail'} =~ /^(.+)\s+.+$/) {
                unless (-e $1) {
                    &error ('SENDMAILNOTFOUND', $1);
                    return undef; 
                }
            }
        }
        $self->{'mode'} = 'SENDMAIL';       
    }
    else {
        &error ('NOTRANSPORT'); return undef;
    }
    return $self;
}

sub send {
# ---------------------------------------------------------------
# Sets any options passed in, then sends an email
# either via SMTP or Sendmail.
#
    my $self = shift;

    $self->set_options(@_) or return undef;

    if ($self->{'mode'} eq 'SMTP') {
        return $self->send_smtp();
    }
    elsif ($self->{'mode'} eq 'SENDMAIL') {
        return $self->send_sendmail();
    }
    else {
        &error ('NOTRANSPORT');
        return undef;
    }
}

sub send_smtp {
# ---------------------------------------------------------------
# Opens a smtp port and sends the message headers.
#
    my $self = shift;

# Get a filehandle, and connect to it.
    my $s = &FileHandle::new('FileHandle');
    socket($s, AF_INET, SOCK_STREAM, $self->{'proto'}) 
        or (&error('SOCKFAILED', $!) and return undef);
    connect($s, pack('Sna4x8', AF_INET, $self->{'port'}, $self->{'smtpaddr'}))
        or (&error('CONNFAILED', $!) and return undef);

# Don't buffer output to file handle.       
    my($oldfh) = select($s); $| = 1; select($oldfh);

# Contact the SMTP server and set the recipients.   
    $_ = <$s>; if (/^[45]/) { close $s; &error('SERVNOTAVAIL'); return undef; } 
    
    print $s "helo localhost$CRLF"; 
    $_ = <$s>; if (/^[45]/) { close $s; &error('COMMERROR');    return undef; }
    
    print $s "mail from: <", $self->{'from'}, ">$CRLF"; 
    $_ = <$s>; if (/^[45]/) { close $s; &error('COMMERROR');    return undef; }
 
    foreach (split(/,/, $self->{'to'})) {
        (/<(.*)>/) ?
            print $s "rcpt to: $1$CRLF" :
            print $s "rcpt to: <$_>$CRLF";          
        $_ = <$s>; if (/^[45]/) { close $s; &error('USERUNKNOWN', $self->{'to'}, $self->{'smtp'}); return undef; }
    }
    
    print $s "data$CRLF";
    $_ = <$s>; if (/^[45]/) { close $s; &error('COMMERROR'); return undef; }

# Print the mail headers.
    print $s "To: ",       $self->{'to'},      $CRLF;
    print $s "From: ",     $self->{'from'},    $CRLF;
    print $s "Reply-to: ", $self->{'reply'},   $CRLF        if $self->{'reply'};
    print $s $self->{'headers'},               $CRLF        if $self->{'headers'};
    print $s "X-Mailer: Mailer::$VERSION (http://www.gossamer-threads.com/scripts/)$CRLF";
    print $s "Subject: ",  $self->{'subject'}, $CRLF, $CRLF;

# Print the mail body.
    $self->{'msg'}  =~ s/\r//g;
    $self->{'msg'}  =~ s/\n/$CRLF/g;
    
    print $s $self->{'msg'};

# Close the connection.
    print $s $CRLF, '.', $CRLF;
    $_ = <$s>; if (/^[45]/) { close $s; &error('TRANSFAILED'); return undef; }
 
    print $s "quit", $CRLF;
    $_ = <$s>;

    close $s;
    
    $self->log_msg() or return undef;
    
    return 1;
}

sub send_sendmail {
# ---------------------------------------------------------------
# Sends a message using sendmail.
#
    my $self = shift;

# Get a filehandle, and open pipe to sendmail.
    my $s = &FileHandle::new('FileHandle');
    open  ($s, "|$self->{'sendmail'}");
    print $s "To: ",       $self->{'to'},      "\n";
    print $s "From: ",     $self->{'from'},    "\n";
    print $s "Reply-to: ", $self->{'reply'},   "\n"         if $self->{'reply'};
    print $s $self->{'headers'},               "\n"     if $self->{'headers'};
    print $s "X-Mailer: Mailer::$VERSION (http://www.gossamer-threads.com/scripts/)\n";     
    print $s "Subject: ",  $self->{'subject'}, "\n\n";
    print $s $self->{'msg'};
    close $s;
    
    $self->log_msg() or return undef;
    
    return 1;
}

sub set_options {
# ---------------------------------------------------------------
# Sets and verifies options on an initilized object before
# sending a message.
#
    my $self = shift;
    
# Set up the headers depending on whether or not we were passed a hash or 
# a array.
    my %changed;
    if (ref $_[0] eq 'HASH') {
        my $key; my $hash=$_[0];
        foreach $key (keys %$hash) {
            $self->{lc $key} = $hash->{$key};
            $changed{$key}   = 1;
        }
    } 

# Set the from and reply to address.
    $self->{'from'}  = &clean_email ($self->{'from'})   if ($changed{'from'});
    $self->{'reply'} = &clean_email ($self->{'reply'})  if ($changed{'reply'});
    $self->{'to'}    = &clean_email ($self->{'to'})     if ($changed{'to'});

# If we have changed our SMTP server or our SENDMAIL server, update it:
    if ($changed{'smtp'} and $self->{'mode'} eq 'SMTP') {
        $self->{'smtp'} =~ s/^\s+//g; 
        $self->{'smtp'} =~ s/\s+$//g;
        $self->{'smtpaddr'} = ($self->{'smtp'} =~ /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/) ? 
            pack('C4',$1,$2,$3,$4) : (gethostbyname($self->{'smtp'}))[4];
        defined($self->{'smtpaddr'}) or &error ('HOSTNOTFOUND', $self->{'smtp'});
    }   
# If we have changed our sendmail server, let's update it.  
    if ($changed{'sendmail'} and $self->{'mode'} eq 'SENDMAIL') {
# If we don't have parameters for sendmail, just check if it exists and
# then add default -oeq -t. Otherwise, strip them off and check to make
# sure sendmail exists.
        if ($self->{'sendmail'} =~ /^\S+$/) {
            unless (-e $self->{'sendmail'}) {
                &error ('SENDMAILNOTFOUND', $self->{'sendmail'});
                return undef; 
            }
            $self->{'sendmail'} = $self->{'sendmail'} . " -oeq -t";
        }
        else {
            if ($self->{'sendmail'} =~ /^(.+)\s+.+$/) {
                unless (-e $1) {
                    &error ('SENDMAILNOTFOUND', $1);
                    return undef; 
                }
            }
        }
    }
# Make sure we have a mode, a to address and a message. 
    $self->{'mode'}       or (&error ('NOTRANSPORT') and return undef);
    $self->{'to'}         or (&error ('TOEMPTY')     and return undef);
    $self->{'msg'}        or (&error ('NOMSG')       and return undef);

    return 1;
}

sub clean_email {
# ---------------------------------------------------------------
# Remove extraneous spaces in the email address.
#
    my $address = shift;
    $address =~ s/^\s+//g;  # Remove leading spaces.
    $address =~ s/\s+$//g;  # Remove trailing spaces.
    $address =~ s/,,/,/g;   # Remove double commas.
    return $address;
}

sub log_msg {
# ---------------------------------------------------------------
# Logs the current message to the logfile.
#
    my $self    = shift;
    my $logfile = $self->{'log'};
    
    return 1 unless $logfile;
    
    my $to   = $self->{'to'};
    my $from = $self->{'from'};
    my $mode = $self->{'mode'};
    my $smtp = $self->{'smtp'};
    my $send = $self->{'sendmail'};
    my $sub  = $self->{'subject'};
    my $msg  = $self->{'msg'};
    my $time = scalar(localtime);
    my $ip   = $ENV{'REMOTE_HOST'};
    my $ref  = $ENV{'HTTP_REFERER'};
    my $app  = $0;

    (-e $logfile) ?
        (open (LOG, ">>$logfile") or (&error('BADLOG', $logfile, $!) and return undef)) :
        (open (LOG, ">$logfile")  or (&error('BADLOG', $logfile, $!) and return undef));
    
    print LOG qq~
-------------------------------------------
Message sent on $time:

To: $to
From: $from
Subject: $sub

$msg
--------------------
Mode: $mode
SMTP: $smtp
Sendmail: $send
Remote Host: $ip
Remote Ref: $ref
Program: $app

        ~;
        close LOG;
    return 1;
}

1;