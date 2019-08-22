#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: modify.cgi
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

# We are processing the form..  
    if (keys %in != 0) {
        &process_form;
    }
# Otherwise we are displaying the form (in site_html.pl).
    else {
        &site_html_modify_form;
    }
}

sub process_form {
# --------------------------------------------------------          
    my ($key, $status, @values, $found);
    local (%original);
    
# Make sure we have a link to modify.   
    !$in{'Current URL'} and &site_html_modify_failure ("did not specify link to modify") and return;
    
# Let's check to make sure the link we want to update is actually
# in the database.
    open (DB, "<$db_file_name") or &cgierr("error in validate_records. unable to open db file: $db_file_name. Reason: $!");
    $found = 0;
    LINE: while (<DB>) {
        (/^#/)      and next LINE;
        (/^\s*$/)   and next LINE;
        chomp;      
        @data = &split_decode($_);
        if ($data[$db_url] eq $in{'Current URL'}) {
            $in{$db_key} = $data[0];
            $found = 1; 
            %original = &array_to_hash (0, @data);
            last LINE;
        }
    }
    close DB;
    !$found and &site_html_modify_failure ("link was not found in the database") and return;
    
# Since we have a valid link, let's make sure the system fields are set to their
# proper values. We will simply copy over the original field values. This is to stop
# people from trying to modify system fields like number of hits, etc.
    foreach $key (keys %add_system_fields) {
        $in{$key} = $original{$key};
    }

# Set date variable to today's date.
    $in{$db_cols[$db_modified]} = &get_date;
    
# Validate the form input.. 
    $status = &validate_record(%in);
    if ($status eq "ok") {
# First make sure the link isn't already in there.
        open (MOD, "<$db_modified_name") or &cgierr ("error opening modified database: $db_modified_name. Reason: $!");
        while (<MOD>) {
            chomp;
            @values = split /\|/;
            if ($values[0] eq $in{$db_key}) {
                close MOD;
                &site_html_modify_failure("A request to modify this record has already been received. Please try again later.");
                return;
            }
        }
        close MOD;

# Print out the modified record to a "modified database" where it is stored until
# the admin decides to add it into the real database.
        open (MOD, ">>$db_modified_name") or &cgierr("error in modify.cgi. unable to open modification database: $db_modified_name. Reason: $!");
            flock(MOD, $LOCK_EX) unless (!$db_use_flock);       
            print MOD &join_encode(%in);    
        close MOD;      # automatically removes file lock

# Send the admin an email message notifying of new addition.
        &send_email;
# Send the visitor to the success page.     
        &site_html_modify_success;
    }
    else {
# Let's change that error message from a comma delimted list to an html
# bulleted list.
        &site_html_modify_failure($status);
    }       
}

sub send_email {
# --------------------------------------------------------
# Sends an email to the admin, letting him know that there is
# a new link waiting to be validated.

# Check to make sure that there is an admin email address defined.
    $db_admin_email or &cgierr("Admin Email Address Not Defined in config file!");
    my $to = $db_admin_email;
    my $from = $in{$db_cols[$db_contact_email]};
    my $subject = "Modification to Database: $in{'Title'}";
    my $msg = qq|
The following link was modified and is awaiting validation:

ORIGINAL LINK:
===============================================
          Title:  $original{'Title'}
            URL:  $original{'URL'}
    Description:  $original{'Description'}
        Country:  $original{'Country'}
           Type:  $original{'Type'}
   Contact Name:  $original{'Contact Name'}
  Contact Email:  $original{'Contact Email'}
       Category:  $original{'Category'}
       
NEW LINK:
===============================================
          Title:  $in{'Title'}
            URL:  $in{'URL'}
    Description:  $in{'Description'}
        Country:  $in{'Country'}
           Type:  $in{'Type'}
   Contact Name:  $in{'Contact Name'}
  Contact Email:  $in{'Contact Email'}
       Category:  $in{'Category'}

    Remote Host: $ENV{'REMOTE_HOST'}
        Referer: $ENV{'HTTP_REFERER'}
       
To update, please go to:
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
                            } ) or return undef;
    $mailer->send or return undef;
}