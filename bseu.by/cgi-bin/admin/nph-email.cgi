#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#        File: nph-mail.cgi
# Description: Massmails updates.
#      Author: Alex Krohn
#       Email: alex@gossamer-threads.com
#         Web: http://www.gossamer-threads.com/
#     Version: 2.01
#
# (c) 1998 Gossamer Threads Inc. 
#
# This script is not freeware! Please read the README for full details
# on registration and terms of use. 
# =====================================================================


# Required Librariers
# --------------------------------------------------------
BEGIN {
    eval {
        ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");    # Get the script location: UNIX /
        ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");    # Get the script location: Windows \

        require "links.cfg";                # Change this to full path to links.cfg if you have problems.
        require "$db_lib_path/db_utils.pl";
        require "$db_lib_path/links.def";   
        require "$db_lib_path/Mailer.pm";
    };
    if ($@) {
        print "HTTP 1.0/200 OK\n";
        print "Content-type: text/plain\n\n";
        print "Error including libraries: $@\n";
        print "Make sure they exist, permissions are set properly, and paths are set correctly.";
        exit;
    }
}

# ========================================================
eval    { &main; };                         # Trap any fatal errors so the program hopefully 
$@  and &cgierr("Fatal error: $@");         # never produces that nasty 500 server error page.
exit;   

sub main {
# --------------------------------------------------------  
    $|++;

# Print full header.    
    my $use_html = 0;
    $ENV{'REQUEST_METHOD'}  and $use_html++;
    $nph++;
    &html_print_headers()   if $use_html;

# Get form contents.
    my (%in) = &parse_form() if $use_html;
    my $start = time();
    
# Print a header.   
    $use_html and
        print qq|
        <html><head><tittle>Links Manager: Mailing Users</title></head>
        <BODY BGCOLOR=#FFFFFF><H2><TT>Mailing Users</TT></H2>
        <PRE>|;
    print qq|Mailing started on |, scalar localtime($start), "\n";

# Make sure we have everything we need.
    my (@data, $mod_msg);
    my $message = $in{'message'};
    my $subject = $in{'subject'};   
    my %seen;
    $message =~ s/\r//g;
    
    $message or (print "No message defined! Aborting!" and exit);
    $subject or (print "No subject defined! Aborting!" and exit);
    $db_admin_email or 
        (print "An admin email has not been set in the config. Aborting!" and exit);
    ($db_smtp_server or $db_mail_path) or 
        (print "No SMTP server or Sendmail has been defiend in the config. Aborting!" and exit);

# Let's initilize a mailer.
    my $mailer = new Mailer ( { smtp => $db_smtp_server, sendmail => $db_mail_path, from => $db_admin_email, subject => $subject, msg => $message, log => $db_mailer_log } ) or 
        &cgierr("Unable to init mailer! Reeason: $Mailer::error");

    print qq~
Mailing Message:
--------------------------------------------------------
From: $db_admin_email
Subject: $subject

$message
--------------------------------------------------------
~;

# And begin mailing!    
    my ($email_q, $email_n, $href, $msg_mod);

# We are either mailing from the links database, or from the email
# update (via form input).
#
    if ($in{'db'} eq 'email') {
        my @address = split /~~/, $in{'mailto'};        
        my ($unsub, $email_q);

# If from newsletter, we go through the form input, and mail to each user.
        foreach $address (@address) {
            $email_q = &urlencode ($address);
            $unsub = qq~<small>[<a href="$build_email_url?action=unsubscribe&email=$email_q" target="_blank">unsubscribe</a>]</small>~;         

# Make sure the address looks ok, and we haven't already mailed to this email address.
            ($address =~ /.+@.+\..+/) or (print qq~Invalid email address: $address $unsub. Skipping.\n~ and next);      
            ($seen{$address}++)     and  (print qq~Already mailed to: $address $unsub!\n~ and next);

# If in debug mode, then just print a message, otherwise actually mail it.
            if ($in{'debug'}) {
                print qq~Message would have been sent to '$address' $unsub\n~;
            }
            else {
                $msg_mod = &load_template('email', { 'Contact Email' => $address }, $message);
                $mailer->send ( { to => $address, msg => $msg_mod } ) ?
                    (print qq~Message sent succesfully to '$address' $unsub\n~) :
                    (print qq~Unable to mail to '$address' $unsub. Reason: $Mailer::error\n~);
            }
        }   
    }
    else {

# Otherwise, open the database and go through and mail requested/all users.
        open (DB, "<$db_links_name") or &cgierr("unable to open database: $db_links_name. Reason: $!");
        while (<DB>) {
            /^#/      and next;     # Skip comment Lines.
            /^\s*$/   and next;     # Skip blank lines.
            chomp;
            @data = &split_decode($_);

# If this is the one we want to mail..
            if ($in{'all'} or ($in{$data[$db_key_pos]} eq 'mail')) {            
                
# We escape the URL and Name so we can provide a link to modify this email address.
                $email_q = &urlencode ($data[$db_contact_email]);
                $email_n = &urlencode ($db_cols[$db_contact_email]);
                $href    = qq~$db_script_url?db=links&$email_n=$email_q&view_records=1&ww=1~;

# Make sure the address looks ok and that we haven't emailed to this person before.             
                ($data[$db_mail] eq 'No') and print qq~<a href="$href" target="_blank">$data[$db_key_pos]</a> - Address set to not receive emails. Skipping\n~ and next;
                ($data[$db_contact_email] =~ /.+@.+\..+/) or (print qq~<a href="$href" target="_blank">$data[$db_key_pos]</a> - Invalid email address: $data[$db_contact_email]. Skipping.\n~ and next);        
                ($seen{$data[$db_contact_email]}++) and (print qq~<a href="$href" target="_blank">$data[$db_key_pos]</a> - Already mailed to: '$data[$db_contact_email]'!\n~ and next);

# If in debug mode, only print a message. 
                if ($in{'debug'}) {
                    print qq~<a href="$href" target="_blank">$data[$db_key_pos]</a> - Message would have been sent to '$data[$db_contact_email]'\n~;
                }
                else {
# Otherwise let's personalise the message using our template and mail it away!              
                    %link    = &array_to_hash (0, @data);
                    $msg_mod = &load_template('email', \%link, $message);
                    $mailer->send ( { to => $data[$db_contact_email], msg => $msg_mod  } ) ?
                        (print qq~<a href="$href" target="_blank">$data[$db_key_pos]</a> - Message sent succesfully to '$data[$db_contact_email]'\n~) :
                        (print qq~<a href="$href" target="_blank">$data[$db_key_pos]</a> - Unable to mail to '$data[$db_contact_email]'. Reason: $Mailer::error\n~);
                }
            }
        }
        close DB;
    }

# All done, print summary stats.
    my $finish  = time();
    my $elapsed = $finish - $start;
    print "--------------------------------------------------------\n";
    print "Mailing finished at: ", scalar localtime($finish), ".\nElapsed: $elapsed s.\n";          
}
