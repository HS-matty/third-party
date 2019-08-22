#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: Template.pm 
#  Description: Template parser package lossely based off of CGI::FastTemplate
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

package Template;
# ===============================================================
    use strict;
    use vars qw($VERSION $error @ISA @EXPORT);  # Globals.
    @ISA    = ();                               # Not inhereited.
    @EXPORT = qw();
    $Template::VERSION = '1.0';

sub error {
# ---------------------------------------------------------------
# Handles error messages.
#
    my ($errtype, $e1, $e2) = @_;
    my %errors = (
                    'CANTINIT'    => "Template: Can't init, no root defined, or not a hash ref: '$e1'",
                    'NOTEMPLATE'  => "Template: Can't find template: $e1",
                    'CANTOPEN'    => "Template: Can't open template: $e1. Reason: $e2",
                    'NONAMESPACE' => "Tempalte: You haven't loaded a namespace yet!",
                    'NONAME'      => "Template: No name was defined for this template!",
                    'NOSTRING'    => "Template: No text was defined for template: $e1"
    );
    $Template::error = $errors{$errtype};
    die $Template::error;
}

sub new {
# ---------------------------------------------------------------
# Initilizes a new instance of the template parser.
#
    my $this  = shift;
    my $class = ref($this) || $this;
    my $self  = {};
    bless  $self, $class;   
    
    my $opt   = shift;
    unless ((ref $opt eq 'HASH') and (exists ${$opt}{'ROOT'})) {
        &error ('CANTINIT', $opt);
        return undef;
    }
    $self->{'ROOT'}  = ${$opt}{'ROOT'};
    $self->{'CHECK'} = ${$opt}{'CHECK'};

    return $self;
}

sub load_template {
# ---------------------------------------------------------------
# Loads a template either from a file or from a string.
#
    my $self      = shift;
    my ($name, $text) = @_;

    if (!$self->{'CHECK'} and exists $self->{'templates'}{$name}) { return 1; } 
    if (!defined $text) {
        my $file = $self->{'ROOT'} . "/$name";
        -e $file             or (&error('NOTEMPLATE', $file)     and return undef);
        open (TPL, "<$file") or (&error('CANTOPEN', $file, $!)   and return undef);
        $text = join ("", <TPL>);
        close TPL;
    }
    $self->{'templates'}{$name} = $text;
    return 1;
}

sub load_vars {
# ---------------------------------------------------------------
# Sets the variables (all the search and replaces).
#
    my $self = shift;
    my $vars = shift;

    my ($name, $value);
    while (($name, $value) = each %{$vars}) {     
        $self->{'vars'}{$name} = $value;
    }
    return 1;   
}

sub clear_vars {
# ---------------------------------------------------------------
# Clears the namespace.
#
    my $self = shift;
    $self->{'vars'} = {};
    return 1;
}
    
sub parse {
# ---------------------------------------------------------------
# Parses a template.
#
    my $self     = shift;
    my $template = shift;
    my $begin    = $self->{'begin'} || quotemeta('<%');
    my $end      = $self->{'end'}   || quotemeta('%>');
    
    exists $self->{'templates'}{$template} or ($self->load_template($template) or return undef);
    exists $self->{'vars'}                 or (&error ('NONAMESPACE') and return undef);
    $self->{'parsed'}{$template} = '';

    my @lines = split /\n/, $self->{'templates'}{$template};
    my $go    = 1;

    foreach (@lines) {
        /$begin\s*if\s*(.+)?\s*$end/o and ($self->{'vars'}{$1} !~ /^\s*$/) ? ($go = 1) : ($go = 0) and next;
        /$begin\s*endif\s*$end/o      and ($go = 1) and next;
        $go or next;
        s/$begin\s*(.+?)\s*$end/
            if (exists $self->{'vars'}{$1}) {
                ref ($self->{'vars'}{$1}) eq 'CODE' ? &{$self->{'vars'}{$1}} : $self->{'vars'}{$1};
            }
            else {
                return "Unkown Tag: $1";
            }
        /goe;
        $self->{'parsed'}{$template} .= $_ . "\n";
    }
    return $self->{'parsed'}{$template};
}

sub DESTROY {
# ---------------------------------------------------------------

}

1;