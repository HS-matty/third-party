#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: add.cgi
#  Description: Adds a record marked unvalidated to the database and 
#               optionally emails someone.
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
#   Setup Notes:
#       Make sure the require statement below points to the config file.    

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
    local (%in) = &parse_form;

# We are processing the form. 
    if (keys %in != 0) {
        &process_form;
    }
# Otherwise we are displaying the form (in site_html.pl).
    else {
        if ($db_single_category) {
            my %is_valid = map { $_ => 1 } &category_list;
            $ENV{'HTTP_REFERER'} =~ s,/[^/]+\.[^/]+$,,; 
            $ENV{'HTTP_REFERER'} =~ m,$build_root_url/(.+?)/?$,;
            $is_valid{$1} ? &site_html_add_form ($1) : &site_html_add_form ();
        }
        else {
            &site_html_add_form ();
        }
    }
}

sub process_form {
# --------------------------------------------------------          
    my ($key, $status, $line, $output);

# Check the referer.
    if (@db_referers and $ENV{'HTTP_REFERER'}) {
        $found = 0;
        foreach (@db_referers) {
            $ENV{'HTTP_REFERER'} =~ /$_/i and $found++ and last;
        }
        if (!$found) {
            &site_html_add_failure ("Auto submission is not allowed in this directory. Please visit the site to add your entry.");
            return;
        }
    }

# This will set system fields like Validated to their proper values.    
    foreach $key (keys %add_system_fields) {
        $in{$key} = $add_system_fields{$key};
    }
    
# Set date variable to today's date.
    $in{$db_cols[$db_modified]} = &get_date;
    
    open (ID, "<$db_links_id_file_name") or &cgierr("error in process_form. unable to open id file: $db_links_id_file_name. Reason: $!");
        $in{$db_key} = <ID> + 1;                # Get next ID number
    close ID;

# Validate the form input.. 
    $status = &validate_record(%in);
    if ($status eq "ok") {

# Update the counter.
        open (ID, ">$db_links_id_file_name") or &cgierr("error in get_defaults. unable to open id file: $db_links_id_file_name. Reason: $!");
            flock(ID, 2) unless (!$db_use_flock);
            print ID $in{$db_key};     # update counter.
        close ID;       # automatically removes file lock

# Print out the validate input to a "validation database" where it is stored until
# the admin decides to add it into the real database.
        open (VAL, ">>$db_valid_name") or &cgierr("error in add_record. unable to open validate file: $db_valid_name. Reason: $!");
            flock(VAL, 2) unless (!$db_use_flock);       
            print VAL &join_encode(%in);    
        close VAL;      # automatically removes file lock

# Send the admin an email message notifying of new addition.
        &send_email;
# Send the visitor to the success page.     
        &site_html_add_success;
    }
    else {
        &site_html_add_failure($status);
    }       
}

sub send_email {
# --------------------------------------------------------
# Sends an email to the admin, letting him know that there is
# a new link waiting to be validated. No error checking as we don't
# want users to see the informative &cgierr output. 

# Check to make sure that there is an admin email address defined.
    $db_admin_email or &cgierr("Admin Email Address Not Defined in config file!");

    my $to      = $db_admin_email;
    my $from    = $in{$db_cols[$db_contact_email]};
    my $subject = "Addition to Database: $in{'Title'}\n";
    my $msg     = qq|
The following link is awaiting validation:

          Title:  $in{'Title'}
            URL:  $in{'URL'}
       Category:  $in{'Category'}           
    Description:  $in{'Description'}
   Contact Name:  $in{'Contact Name'}
  Contact Email:  $in{'Contact Email'}
  
    Remote Host:  $ENV{'REMOTE_HOST'}
        Referer:  $ENV{'HTTP_REFERER'}
       
To validate, please go to:
    $db_script_url
    
Sincerely,

Links Manager.
    |;

# Then mail it away!    
    require "$db_lib_path/Mailer.pm";
    my $mailer = new Mailer ( { smtp => $db_smtp_server, 
                                sendmail => $db_mail_path, 
                                from => $from, 
                                subject => $subject,
                                to => $to,
                                msg => $msg,
                                log => $db_mailer_log
                            } ) or return;
    $mailer->send or return;
}