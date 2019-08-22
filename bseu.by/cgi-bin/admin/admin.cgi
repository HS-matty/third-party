#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: admin.cgi
#  Description: This is the administrative interface for the links program.
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
    
    require 5.001;                          # Make sure we have at least perl 5.001.    
    require "links.cfg";                    # Change this to full path to links.cfg if you have problems.
    require "$db_lib_path/db.pl";           # Database Routines.
    require "$db_lib_path/db_utils.pl";     # Database Support utilities.
    require "$db_lib_path/admin_html.pl";   # Admin HTML routines.
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
# ========================================================

sub main {
# --------------------------------------------------------
    $| = 1;                                  # Flush Output Right Away

    # Main Menu. Check to see what the user requested, then if he has permission for that
    # request, do it. Otherwise send the user off to an unauthorized request page.
    %in = &parse_form;                      # Get form input so we know which database to load.

    # Load the database definition file and set the link url.
    $in{'db'} ?
        require "$db_lib_path/$in{'db'}.def" :
        require "$db_lib_path/links.def";
        
    $db_script_link_url = "$db_script_url?db=$in{'db'}";

    # The functions beginning with &html_ can be found in admin_html.pl, while the other
    # functions can be found in db.pl
    
    if    ($in{'add_form'})             { &html_add_form; }             # Display the Add Record Form.
    elsif ($in{'add_record'})           { &add_record; }                # Add the Actual Record.
    elsif ($in{'add_record_mult'})      { &add_record_mult; }           # Add Multiple Records at once (beta).
    elsif ($in{'view_search'})          { &html_view_search; }          # Display form to search database.
    elsif ($in{'view_records'})         { &view_records; }              # Search database and print results.
    elsif ($in{'delete_search'})        { &html_delete_search; }        # Display the form to search for records to delete.
    elsif ($in{'delete_form'})          { &html_delete_form; }          # Display the form to pick records to delete.
    elsif ($in{'delete_records'})       { &delete_records; }            # Delete records.
    elsif ($in{'modify_search'})        { &html_modify_search; }        # Display the form to search for records to modify.
    elsif ($in{'modify_mult_form'})     { &html_modify_mult_form; }     # Display multiple records to modify at one time.
    elsif ($in{'modify_form'})          { &html_modify_form; }          # Display the form to pick record to modify.
    elsif ($in{'modify_form_record'})   { &html_modify_form_record; }   # Display the form to modify a record.
    elsif ($in{'modify_record'})        { &modify_record;  }            # Modify the record.
    elsif ($in{'modify_mult_record'})   { &modify_mult_record; }        # Modify multiple records at once.
    elsif ($in{'validate_form'})        { &html_validate_form; }        # Display the Validation Form.
    elsif ($in{'validate_records'})     { &validate_records; }          # Validate records.
    elsif ($in{'check_links'})          { &check_links; }               # Display/Check to make sure links have matching catgories.
    elsif ($in{'fix_links'})            { &fix_links; }                 # Fixes up any errors found in check links.
    elsif ($in{'check_duplicates'})     { &check_duplicates; }          # Display/Check for duplicate links.
    elsif ($in{'html_mail_target'})     { &html_mail_target; }          # Form to do targeted mass mailing.
    elsif ($in{'html_mail_form'})       { &html_mail_form; }            # Form to do mass mailing.
    elsif ($in{'html_mail_update'})     { &html_mail_update; }          # Form to do email updates.
    elsif ($in{'html_edit_template'})   { &html_edit_template; }        # Edit Templates
    elsif ($in{'save_template'})        { &save_template; }             # Save templates.
    elsif ($in{'html_template_help'})   { &html_template_help; }        # Template Help.
    elsif ($in{'display'} eq 'navigation') { &html_navigation; }        # Display HTML Header
    elsif ($in{'display'} eq 'body')    { &html_body; }                 # Display HTML Body
    elsif ($in{'display'} eq 'top')     { &html_top; }                  # Display HTML Top
    else                                { &html_home; }                 # Display Frame Index page.

#   &cgierr("Done");        # Uncomment this line for Debugging...  Will tack on form variables and environment variables
                            # to the end of every page. Quite Useful.   
}
