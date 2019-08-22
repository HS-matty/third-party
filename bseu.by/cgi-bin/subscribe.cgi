#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: subscribe.cgi
#  Description: Adds a user to the mailing list.
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
#

# Required Librariers
# --------------------------------------------------------
eval {
    ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");    # Get the script location: UNIX /
    ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");    # Get the script location: Windows \

    require "admin/links.cfg";              # Change this to full path to links.cfg if you have problems.    
    require "$db_lib_path/db_utils.pl";
    require "$db_lib_path/links.def";       
    $build_use_templates ?
        require "$db_lib_path/site_html_templates.pl" :
        require "$db_lib_path/site_html.pl";
};
if ($@) {
    print "Content-type: text/plain\n\n";
    print "Error including libraries: $@\n";
    print "Make sure they exist, permissions are set properly, and paths are set correctly.";
    exit;
}

# ========================================================

eval { &main; };                            # Trap any fatal errors so the program hopefully 
if ($@) { &cgierr("fatal error: $@"); }     # never produces that nasty 500 server error page.
exit;   # There are only two exit calls in the script, here and in in &cgierr. 

sub main {
# --------------------------------------------------------  
    $|++;                                   # Flush Output.
    my %in     = &parse_form;
    my $action = $in{'action'};
    
    CASE: {
            ($action eq "subscribe")    and do { &subscribe  (%in); last CASE; };
            ($action eq "unsubscribe")  and do { &unsubscribe(%in); last CASE; };
            
            &site_html_mailing();           
    };
}

sub subscribe {
# -----------------------------------------------------------
# Adds a user into a mailing list.
#
    my %in = @_;    
    my $list = $db_email_name;
    
# Make sure the email address at least looks like an email address.
    my $email      = $in{'email'};
    my $name       = $in{'name'};   
    ($email =~ /.+@.+\..+/) or &site_html_mailing_error ("The email address: '$email' doesn't look like a real email address.") and return;
    ($name  =~ /[A-Za-z]+/) or &site_html_mailing_error ("Please enter a name as well as an email address.") and return;

# Check that the user is not already subscribed.    
    my $users_r    = &get_users ($list);
    ${$users_r}{$email}    and &site_html_mailing_error ("The email address: $email is already subscribed to this list.") and return;

# Made it this far, so let's add the user in.
    ${$users_r}{$email} = $name;
    
    open  (LIST, ">$list") or &cgierr ("Unable to open list: $list. Reason: $!");
    if ($db_use_flock) { flock (LIST, 2) or &cgierr ("Unable to get exlusive lock! Reason: $!"); }
    foreach (sort keys %{$users_r}) {
        print LIST "$_$db_delim${$users_r}{$_}\n";
    }
    close LIST;

# Go to the success page.
    &site_html_mailing ('subscribe');
}

sub unsubscribe {
# -----------------------------------------------------------
# Removes a user from a mailing list.
#
    my %in = @_;    
    my $list = $db_email_name;
    
# Check that the user is already subscribed.    
    my $email      = $in{'email'};
    my $name       = $in{'name'};   
    my $users_r    = &get_users ($list);    
    ${$users_r}{$email} or &site_html_mailing_error ("The email address: $email is not subscribed to this list.") and return;

# Made it this far, so let's remove the user.
    delete ${$users_r}{$email};
    
    open  (LIST, ">$list") or &cgierr ("Unable to open list: $list. Reason: $!");
    if ($db_use_flock) { flock (LIST, 2) or &cgierr ("Unable to get exlusive lock! Reason: $!"); }
    foreach (sort keys %{$users_r}) {
        print LIST "$_$db_delim${$users_r}{$_}\n";
    }
    close LIST;

# Go to the success page.
    &site_html_mailing ('unsubscribe');
}

sub get_users {
# -----------------------------------------------------------
# Returns a hash ref of a list of all users in a list.
#
    my ($list) = shift;
    my $users_r;
    my $delim  = quotemeta ($db_delim);
    open (LIST, "<$list") or &cgierr ("Unable to open list: $config{'list_dir'}/$list. Reason: $!");
    if ($db_use_flock) { flock (LIST, 1); }
    while (<LIST>) {
        chomp;
        (/(.*)$delim(.*)/o) and (${$users_r}{$1} = $2);
    }
    close LIST;
    return $users_r;
}