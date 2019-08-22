#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: admin_html.pl
#  Description: This library contains all the html used in the admin 
#               interface.
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

##########################################################
##                      Globals                         ##
##########################################################

    $font       = 'font face="verdana,arial,helvetica" size="2"';
    $font_title = 'font face="verdana,arial,helvetica" size="4"';

##########################################################
##                      Home Page                       ##
##########################################################

sub html_home {
# --------------------------------------------------------
# Prints the database frame index page.
#
    &html_print_headers();
    print  qq|
<html>
<head>
<title>Links Manager: Administration</title>

<frameset rows="60,*"> 
  <frame src="$db_script_url?display=top" frameborder="NO" NORESIZE scrolling="NO" name="head">
  <frameset cols="155,*"> 
    <frame src="$db_script_url?display=navigation" name="nav">
    <frame src="$db_script_url?display=body" name="cgimain" scrolling="AUTO">
  </frameset>  
</frameset>

<noframes><body bgcolor="#FFFFFF">
Sorry, you need a frames capable browse to use this program.
</body></noframes>
</html>
    |;
}

sub html_top {
# --------------------------------------------------------
# Prints the top title bar.
#
    &html_print_headers();
    print qq|
<html>
<head>
<title>Links Manager: Administration</title>
</head>
<body bgcolor="#DDDDDD">
<table border=0 width="80%">
                    <tr><td valign=top><$font><font size=5><b>Links 2.0 Administration Menu</b></font></font></td>
                    <td valign=top><$font><b><a href="$build_root_url" target="_top">Home Page</a></b></font><br>
                                   <$font><b><a href="$db_script_url?display=body" target="cgimain">Help Page</a></b></font></td>
                    <td valign=top><$font><b><a href="http://www.gossamer-threads.com/scripts/faq/" target="_blank">FAQ</a><br>
                                          <b><a href="http://www.gossamer-threads.com/scripts/forum/" target="_blank">Forum</a></b></font></td>
</td></tr></table>
</body>
</html>
    |;
}

sub html_navigation {
# --------------------------------------------------------
# Prints the navigation links.
#
    &html_print_headers();      
    print qq|
<html>
<head>
    <title>$html_title: Main Menu.</title>  
    <base target="cgimain">
</head> 
<body bgcolor="#DDDDDD">

<p><$font><b>Links<br></b></font>
   <$font>
        <a href="$db_script_url?db=links&view_search=1">View</a><br>
        <a href="$db_script_url?db=links&add_form=1">Add</a><br>
        <a href="$db_script_url?db=links&delete_search=1">Delete</a><br>
        <a href="$db_script_url?db=links&modify_search=1">Modify</a><br>
        <a href="$db_script_url?db=links&validate_form=1">Validate</a><br>
        <a href="$db_script_url?db=links&check_duplicates=1">Check Dup.</a>
    </font>
</P>
<p> <$font><b>Categories<br></b></font>
    <$font>
        <a href="$db_script_url?db=category&view_search=1">View</a><br>
        <a href="$db_script_url?db=category&add_form=1">Add</a><br>
        <a href="$db_script_url?db=category&delete_search=1">Delete</a><br>
        <a href="$db_script_url?db=category&modify_search=1">Modify</a><br>
        <a href="$db_script_url?db=links&check_links=1">Check Cat.</a>
    </font>
</p>
<p><$font><b>Emailing</b><br></font>
    <$font>
        <a href="$db_script_url?db=links&html_mail_update=1">Newsletter</a><br>
        <a href="$db_script_url?db=links&html_mail_target=1">Link Owners</a><br>
    </font>
</p>
<p><$font><b>Building</b><br></font>
    <$font>
        <a href="nph-build.cgi">Build All</a><br>
        <a href="nph-build.cgi?staggered=1">Staggered</a><br>       
        <a href="nph-build.cgi?staggered=1&auto=1">Staggered (Auto)</a><br>     
        <a href="$db_script_url?db=links&html_edit_template=1">Edit Templates</a><br>       
    </font>
</p>

<p><$font><b>Verifying Links</b><br></font>
    <$font>
        <a href="nph-verify.cgi">Quick Check</a><br>
        <a href="nph-verify.cgi?detailed">Detailed</a>
    </font>
</p>

</body>
</html> 
    |;
}

sub html_body {
# --------------------------------------------------------
# Prints the body of the links admin. Usually instructions.
#
    &html_print_headers();
    ($ENV{'REMOTE_USER'} or $ENV{'AUTH_USER'}) ?
        ($warning = '') :
        ($warning = '<h1><blink>WARNING: ADMIN Directory is not Password Protected!!</blink></h1>');
        
        
    print qq~
<html>
<head>
<title>Links Manager Help Page</title>
</head>
<body bgcolor="#DDDDDD">

<p><$font><b>Welcome to Links 2.0</b></font></p>

$warning

<p><$font>

    From your admin panel, you have full control over your link database. 
    
    Here's a brief summary of what you can do!
</font></p>

<p align=center><hr size=1 width=80% noshade><br><center><$font><a href="#menu">Menu Options</a> | <a href="#common">Common Questions</a></font></center></p>

<a name="menu"> </a>
<p><$font><b>Links Menu</b>
<blockquote>
<dl>
    <dt>View<dd>Search over the entire database using any field!
    <dt>Add<dd>Add a new link into your database.
    <dt>Delete<dd>Delete one or more links from your database. Simply search for the link, or links you
                         want to remove, then press delete.
    <dt>Modify<dd>Modify one or more links at a time. Again, just search for the link you want to update 
                         (select Modify Multiple at Once to edit several links at once) and make the changes.
    <dt>Validate<dd>Any links that have been suggested by the public will wait in this validation bin for
                           your approval. Click on Validate to either add them into your database, or reject them 
                           (even send a rejection notice with a reason!)
    <dt>Check Dup<dd>Make sure you don't duplicate things! This function will pull up a list of all your
                            duplicate links, allowing you to easily spot doubles!
</dl>
</blockquote>
</font></p>

<p><$font><b>Category Menu</b>
<blockquote>
<dl>
    <dt>View, Add, Delete, Modify<dd>You have the same control over your category list as you do your links!
    <dt>Check Cat.<dd>Make sure every link is in it's proper category. This function will quickly spot
                             any links in an invalid category. You can then either, move the bad links, erase them, or
                             create the missing category!
</dl>
</blockquote>
</font></p>

<p><$font><b>Emailing Menu</b>
<blockquote>
<dl>
    <dt>Newsletter<dd>Send email updates to users! This function will email everyone who has 
                                  subscribed to the newsletter a list of all your new links!
    <dt>Link Owners<dd>Send email to a targeted list, or everyone in your link database. All emails 
                              can be customized to the individual owner using simple tags.
</dl>
</blockquote>
</font></p>

<p><$font><b>Building Menu</b>
<blockquote>
<dl>
    <dt>Build All<dd>The preferred method of updating your database. Simply click here and all the HTML
                            pages will be regenerated.
    <dt>Staggered<dd>Database too big, and the build all is not working? Use the staggered build which
                            will build your pages bit by bit. It takes a little longer, but is more memory efficent.
    <dt>Staggered (Auto)<dd>Same as staggered, except with meta refresh tags so it will do it all by itself.
    <dt>Edit Templates<dd>Edit your templates online! You can quickly change the look of your site.
</dl>
</blockquote>
</font>
</p>

<p><$font><b>Verify Menu</b>
<blockquote>
<dl>
    <dt>Quick Check</dt><dd>Just checks the links response code, some servers disable this so you might get 
                            less accurate results.
    <dt>Detailed Check</dt><dd>Checks each link by downloading the entire page. Be sure to remove or fix 404 errors,
                               other errors might not be serious.
</dl>
</blockquote>
</p>

<p align=center><hr size=1 width=80% noshade><br><center><$font><a href="#menu">Menu Options</a> | <a href="#common">Common Questions</a></font></center></p>

<a name="common"> </a>
<p><$font><b>Common Questions</b><br>
These are questions I get asked <em>all</em> the time, so please read! 

<blockquote>
<dl>
            <dt>How do I create subcategories?
                <dd>Easy, just name your category appropriately. For instance, if you
                 have a category named 'Computers', to have a subcategory named Hardware
                 just click on Add Category, and name it 'Computers/Hardware'.<br>
                 You can have as many levels as you like 'Computers/Hardware/Video_Cards/Diamond' for
                 instance, but just make sure you have the appropriate categories before hand (i.e. in the 
                 above example, you would need to have 'Computers', 'Computers/Hardware' and 'Computers/Hardware/Video_Cards'
                 first.
                 
            <dt>How do I have spaces in my category names?
                <dd>Use the underscore '_' character. The script will replace it with a space when displaying
                that category.
            
            <dt>Why do no links show up in the Top 10 listings? 
                <dd>A link must have at least 10 votes before it will be placed in the top rated report.
                        
</dl>
</blockquote>
Please be sure to check out the <b><a href="http://www.gossamer-threads.com/scripts/faq/">Frequently Asked Questions</a></b> list for other common problems. If you are still
stuck or looking for more tips and tricks, stop by the <b><a href="http://www.gossamer-threads.com/scripts/forum/">Support Forum</a></b>!
</font></p>
                                                             
</body>
</html>
    
    ~;
}

sub html_footer {
# --------------------------------------------------------
# Print the menu and the footer and logo. It would be nice if you left
# the logo in. ;)
#
# We only print options that the user have permissions for.
#

    my $font       = 'Font face="Verdana, Arial, Helvetica" Size=2';
    print qq!<P align=center><$font><b>$html_object: </b> 
              <A HREF="$db_script_url?db=$in{'db'}&add_form=1">Add</A>
              <A HREF="$db_script_url?db=$in{'db'}&view_search=1">View</A>
              <A HREF="$db_script_url?db=$in{'db'}&delete_search=1">Delete</A> 
              <A HREF="$db_script_url?db=$in{'db'}&modify_search=1">Modify</A> 
              <A HREF="$db_script_url?db=$in{'db'}&view_records=1&$db_key=*">List All</A>
              </font></p>
    !;
}   

sub html_search_options {
# --------------------------------------------------------
# Search options to be displayed at the bottom of search forms.
#
    print qq~
    <P>
    <STRONG>Search Options:</STRONG> <br>
    <INPUT TYPE="CHECKBOX" NAME="ma"> Match Any 
    <INPUT TYPE="CHECKBOX" NAME="cs"> Match Case 
    <INPUT TYPE="CHECKBOX" NAME="ww"> Whole Words 
    <INPUT TYPE="CHECKBOX" NAME="re"> Reg. Expression<BR>
    <INPUT TYPE="TEXT" NAME="keyword" SIZE=15 MAXLENGTH=255> Keyword Search <FONT SIZE=-1> (will match against all fields)</FONT><BR>
    <INPUT TYPE="TEXT" NAME="mh" VALUE="$db_max_hits" SIZE=3 MAXLENGTH=3> Max. Returned Hits<BR>
    Sort By:
    <SELECT NAME="sb">
        <OPTION>---
    ~; for (my $i =0; $i <= $#db_cols; $i++) { print qq~<OPTION VALUE="$i">$db_cols[$i]</OPTION>\n~ if ($db_form_len{$db_cols[$i]} >= 0); } print qq~
    </SELECT>
    Sort Order:
    <SELECT NAME="so">
        <OPTION VALUE="ascend">Ascending
        <OPTION VALUE="descend">Descending
    </SELECT>
    ~;
}

##########################################################
##                      Adding                          ##
##########################################################

sub html_add_form {
# --------------------------------------------------------
# The add form page where the user fills out all the details
# on the new record he would like to add. You should use 
# &html_record_form to print out the form as it makes
# updating much easier. Feel free to edit &get_defaults
# to change the default values.

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Add a New $html_object.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="POST">
        <input type=hidden name="db" value="$in{'db'}"> 
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Add a New $html_object</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Add a New $html_object
                    </b></font></center><br>
                    <$font>
                        |; &html_record_form (&get_defaults); print qq|
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="add_record" VALUE="Add $html_object"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html> 
|;
}

sub html_add_success {
# --------------------------------------------------------
# The page that is returned upon a successful addition to
# the database. You should use &get_record and &html_record
# to verify that the record was inserted properly and to make
# updating easier.

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: $html_object Added.</title>
</head>

<body bgcolor="#DDDDDD">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: $html_object Added</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        $html_object Added
                    </b></font></center><br>
                    <$font>
                        <P><Font face="Verdana, Arial, Helvetica" Size=2>The following record was successfully added to the database:</FONT>
                        |; &html_record(&get_record($in{$db_key})); print qq|   
                    </font></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
</body>
</html>     
|;
}

sub html_add_failure {
# --------------------------------------------------------
# The page that is returned if the addition failed. An error message 
# is passed in explaining what happened in $message and the form is
# reprinted out saving the input (by passing in %in to html_record_form).

    my $message = shift;
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Error! Unable to Add $html_object.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="POST">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Error: Unable to Add $html_object</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Error: <font color=red>Unable to Add $html_object</font>
                    </b></font></center><br>
                    <$font>
                        There were problems with the following fields: <FONT COLOR="red"><B>$message</B></FONT>
                        <P>Please fix any errors and submit the record again.</p></font>
                        |; &html_record_form (%in); print qq|
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="add_record" VALUE="Add $html_object"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html> 
|;
}

##########################################################
##                      Viewing                         ##
##########################################################

sub html_view_search {
# --------------------------------------------------------
# This page is displayed when a user requests to search the 
# database for viewing. 
# Note: all searches must use GET method.
#
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Search the Database.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="GET">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Search the Database</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Search the Database
                    </b></font></center><br>
                    <$font>
                        |;  &html_record_form(); print qq|
                        |; &html_search_options; print qq|
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="view_records" VALUE="View $html_object"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html> 
|;
}

sub html_view_success {
# --------------------------------------------------------
# This page displays the results of a successful search. 
# You can use the following variables when displaying your 
# results:
#
#        $numhits - the number of hits in this batch of results.
#        $maxhits - the max number of hits displayed.
#        $db_total_hits - the total number of hits.
#        $db_next_hits  - html for displaying the next set of results.
#       
    
    my @hits = @_;
    my ($numhits) = ($#hits+1) / ($#db_cols+1);
    my ($maxhits); $in{'mh'} ? ($maxhits = $in{'mh'}) : ($maxhits = $db_max_hits);  
    
    &html_print_headers();  
    print qq|
<html>
<head>
    <title>$html_title: Search Results.</title>
</head>

<body bgcolor="#DDDDDD">
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy"><FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                   <b>$html_title: Search Results</b>
        </font></td></tr>
    </table>
    
    <blockquote>
    <p><$font>
        Your search returned <b>$db_total_hits</b> matches.</font>
|;
    if ($db_next_hits) {
        print "<br><$font>Pages: $db_next_hits</font>";
    }
    
# Go through each hit and convert the array to hash and send to 
# html_record for printing.
    for (0 .. $numhits - 1) {
        print "<P>";
        &html_record (&array_to_hash($_, @hits));
    }
    if ($db_next_hits) {
        print "<br><$font>Pages: $db_next_hits</font>";
    }
    
    print qq|
        <p>
        <table border=0 bgcolor="#DDDDDD" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td>|; &html_footer; print qq|</td></tr>
        </table>
    </blockquote>
</body>
</html>
|;
}

sub html_view_failure {
# --------------------------------------------------------
# The search for viewing failed. The reason is stored in $message
# and a new search form is printed out.

    my ($message) = $_[0];
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Search Failed.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="GET">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Search Failed</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Search Failed
                    </b></font></center><br>
                    <$font>
                        <P>There were problems with the search. Reason: <FONT COLOR="red"><B>$message</B></FONT>
                        <BR>Please fix any errors and submit the record again.</p>
                        |;  &html_record_form(%in); print qq|
                        |; &html_search_options; print qq|</p>
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="view_records" VALUE="View $html_objects"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html>
|;
}

##########################################################
##                      Deleting                        ##
##########################################################

sub html_delete_search {
# --------------------------------------------------------
# The page is displayed when a user wants to delete records. First
# the user has to search the database to pick which records to delete.
# That's handled by this form.

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Search the Database for Deletion.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="GET">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Search the Database for Deletion</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Search the Database for Deletion
                    </b></font></center><br>
                    <$font>
                        <P>Search the database for the records you wish to delete or 
                           <A HREF="$db_script_link_url&delete_form=1&$db_key=*">list all</a>:</p>
                        |;  &html_record_form(); print qq|
                        |; &html_search_options; print qq|</p>
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="delete_form" VALUE="Search"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html> 
|;
}

sub html_delete_form {
# --------------------------------------------------------
# The user has searched the database for deletion and must now
# pick which records to delete from the records returned. This page
# should produce a checkbox with name=ID value=delete for each record.
# We have to do a little work to convert the array @hits that contains
# the search results to a hash for printing.

    my ($status, @hits) = &query(); 
    my ($numhits) = ($#hits+1) / ($#db_cols+1);
    my ($maxhits); $in{'mh'} ? ($maxhits = $in{'mh'}) : ($maxhits = $db_max_hits);
    my (%tmp);
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Delete $html_object(s).</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" METHOD="POST">
        <input type=hidden name="db" value="$in{'db'}">
        
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                   <b>$html_title: Delete $html_object(s)</b>
        </td></tr>
    </table>
    
    <blockquote><p><$font>
        Check which records you wish to delete and then press "Delete $html_objects":<br>
        Your search returned <b>$db_total_hits</b> matches.</font>
|;
    if ($db_next_hits) {
        print "<br><$font>Pages: $db_next_hits</font>";
    }
# Go through each hit and convert the array to hash and send to 
# html_record for printing. Also add a checkbox with name=key and value=delete.

    if ($status ne "ok") {  # There was an error searching!
        print qq|<P><FONT COLOR="RED" SIZE=4>Error: $status</FONT></P>|;
    }
    else {
        print "<P>";
        for (0 .. $numhits - 1) {
            %tmp = &array_to_hash($_, @hits);
            print qq|<TABLE BORDER=0><TR><TD><INPUT TYPE=CHECKBOX NAME="$tmp{$db_key}" VALUE="delete"></TD><TD>|;
            &html_record (%tmp);
            print qq|</TD></TR></TABLE>\n|;         
        }
        if ($db_next_hits) {
            print "<br><$font>Pages: $db_next_hits</font>";
        }
    }
    print qq|
        <p>
    </blockquote>
    <table border=0 bgcolor="#DDDDDD" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td>
            <p><center><INPUT TYPE="SUBMIT" name="delete_records" VALUE="Delete Checked $html_object(s)"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
            |; &html_footer; print qq|
        </td></tr>
    </table>    
</body>
</html>
|;
}

##########################################################
##                      Modifying                       ##
##########################################################
sub html_modify_search {
# --------------------------------------------------------
# The page is displayed when a user wants to modify a record. First
# the user has to search the database to pick which record to modify.
# That's handled by this form.

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Search the Database for Modifying.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="GET">
        <input type=hidden name="db" value="$in{'db'}"> 
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Search the Database for Modifying</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Search the Database for Modifying
                    </b></font></center><br>
                    <$font>
                        <P>Search the database for the records you wish to modify or 
                           <A HREF="$db_script_link_url&modify_form=1&$db_key=*">list all</a>:</p>
                        |;  &html_record_form(); print qq|
                        <P><b>Modify Multiple $html_objects at Once: <input type=checkbox name="modify_mult_form" value="1"></b>
                        |; &html_search_options; print qq|</p>
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="modify_form" VALUE="Search"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html>     
|;
}

sub html_modify_mult_form {
# --------------------------------------------------------
# The user has searched the database and requested to modify multiple
# records at once. A form for each record is present along with a checkbox
# on which record to use.
#
    my ($status, @hits) = &query("mod");
    my ($numhits) = ($#hits+1) / ($#db_cols+1);
    if (($numhits == 1) and !$in{'nh'}) { $in{'modify'} = $hits[$db_key_pos]; &html_modify_form_record(); return; }
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Modify Multiple $html_objects.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" METHOD="POST">
        <input type=hidden name="db" value="$in{'db'}">
    <blockquote>
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                   <b>$html_title: Modify Multiple $html_objects</b>
        </td></tr>
    </table>
    <p><$font>
        Make any changes to the records and check off which records you want to save.<br>
        Your search returned <b>$db_total_hits</b> matches.</font>  
|;
    if ($db_next_hits) {
        print "<br><$font>Pages: $db_next_hits</font>";
    }

# Go through each hit and convert the array to hash and send to 
# html_record for printing. Also add a radio button with name=modify
# and value=key.
    if ($status ne "ok") {  # Error searching database!
        print qq|<P><FONT COLOR="RED" SIZE=4>Error: $status</FONT>|;
    }
    else {
        print "<P>";
        for (0 .. $numhits - 1) {
            %tmp = &array_to_hash($_, @hits);
            print qq|<TABLE BORDER=0><TR><TD><INPUT TYPE=CHECKBOX NAME="$tmp{$db_key}" VALUE="modify"></TD><TD>|;
            &html_record_form_mult (%tmp);
            print qq|</TD></TR></TABLE>\n|;         
        }
        if ($db_next_hits) {
            print "<br><$font>Pages: $db_next_hits</font>";
        }
    }
    print qq|
        <p>
        <table border=0 bgcolor="#DDDDDD" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td>
                <P><center><input type="SUBMIT" name="modify_mult_record" value="Modify $html_objects"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                |; &html_footer; print qq|
            </td></tr>
        </table>
    </blockquote>
</body>
</html>
    |;
}

sub html_modify_form {
# --------------------------------------------------------
# The user has searched the database for modification and must now
# pick which record to modify from the records returned. This page
# should produce a radio button with name=modify value=ID for each record.
# We have to do a little work to convert the array @hits that contains
# the search results to a hash for printing.

    my (%tmp);
    my ($status, @hits) = &query(); 
    my ($numhits) = ($#hits+1) / ($#db_cols+1);
    if (($numhits == 1) and !$in{'nh'}) { $in{'modify'} = $hits[$db_key_pos]; &html_modify_form_record(); return; }
    my ($maxhits); $in{'mh'} ? ($maxhits = $in{'mh'}) : ($maxhits = $db_max_hits);

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Modify $html_object.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" METHOD="POST">
        <input type=hidden name="db" value="$in{'db'}"> 
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                   <b>$html_title: Modify $html_object</b>
        </td></tr>
    </table>
    <blockquote><p><$font>
        Check which record you wish to modify and then press "Modify $html_objects":<br>
        Your search returned <b>$db_total_hits</b> matches.</font>
|;
    if ($db_next_hits) {
        print "<br><$font>Pages: $db_next_hits</font>";
    }

# Go through each hit and convert the array to hash and send to 
# html_record for printing. Also add a radio button with name=modify
# and value=key.
    if ($status ne "ok") {  # Error searching database!
        print qq|<P><FONT COLOR="RED" SIZE=4>Error: $status</FONT>|;
    }
    else {
        print "<P>";
        for (0 .. $numhits - 1) {
            %tmp = &array_to_hash($_, @hits);
            print qq|<TABLE BORDER=0><TR><TD><INPUT TYPE=RADIO NAME="modify" VALUE="$tmp{$db_key}"></TD><TD>|;
            &html_record (%tmp);
            print qq|</TD></TR></TABLE>\n|;         
        }
        if ($db_next_hits) {
            print "<br><$font>Pages: $db_next_hits</font>";
        }
    }
    print qq|
        <p>
    </blockquote>
    <table border=0 bgcolor="#DDDDDD" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td>
            <P><center><input type="SUBMIT" name="modify_form_record" value="Modify $html_object"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
            |; &html_footer; print qq|
        </td></tr>
    </table>
</body>
</html>
|;
}

sub html_modify_mult_results {
# --------------------------------------------------------
# This page let's the user know that the records were successfully
# modified.

    my ($success, $error) = @_;

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: $html_object(s) Modified.</title>
</head>

<body bgcolor="#DDDDDD">
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 align=center valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                <b>$html_title: $html_object(s) Modified.</b>
        </td></tr>
        <tr><td>
                <p><center><$font_title><b>
                    $html_object(s) Modified
                </b></font></center><br>
                <$font>
                |; print "The following records were successfully modified: $success" if ($success); print qq|
                |; print "The following records were <b>not</b> successfully modified: $error" if ($error); print qq|
                </font></p>
                |; &html_footer; print qq|
        </td></tr>
    </table>
</body>
</html> 
|;
}

sub html_modify_form_record {
# --------------------------------------------------------
# The user has picked a record to modify and it should appear
# filled in here stored in %rec. If we can't find the record,
# the user is sent to modify_failure.

    my (%rec) = &get_record($in{'modify'});
    if (!%rec) { &html_modify_failure("unable to find record/no record specified: $in{'modify'}"); return; }

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Modify a $html_object.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="POST">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Modify a $html_object</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Modify a $html_object
                    </b></font></center><br>
                    <$font>
                        |; &html_record_form (%rec); print qq|
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="modify_record" VALUE="Modify $html_object"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html> 
|;
}

sub html_modify_success {
# --------------------------------------------------------
# The user has successfully modified a record, and this page will 
# display the modified record as a confirmation.

    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: $html_object Modified.</title>
</head>

<body bgcolor="#DDDDDD">
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                <b>$html_title: $html_object Modified.</b>
        </td></tr>
        <tr><td>
                <p><center><$font_title><b>
                    $html_object Modified
                </b></font></center><br>
                <$font>
                    The following record was successfully modified:
                </font></p>
                |; &html_record(&get_record($in{$db_key})); print qq|
                |; &html_footer; print qq|
        </td></tr>
    </table>
</body>
</html> 
|;
}

sub html_modify_failure {
# --------------------------------------------------------
# There was an error modifying the record. $message contains
# the reason why.

    my ($message) = $_[0];
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Error! Unable to Modify $html_object.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="POST">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Error! Unable to Modify $html_object.</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Error: <font color=red>Unable to Modify $html_object</font>
                    </b></font></center><br>
                    <$font>
                        There were problems modifying the record: <FONT COLOR="red"><B>$message</B></FONT>
                        <BR>Please fix any errors and submit the record again.
                    </font></p>                 
                    |; &html_record_form (%in); print qq|
                    <p><center> <INPUT TYPE="SUBMIT" NAME="modify_record" VALUE="Modify $html_object"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html>
|;
}

##########################################################
##                    Validation                        ##
##########################################################
sub html_validate_form {
# --------------------------------------------------------
# This page produces a list of records waiting to be validated, 
# from which the admin can either delete, or validate the records.

# First let's just get a list of all the records to validate/modify.
    my (@lines, @valhits, @modhits, $numhits, $counter);
    
    open (VALIDATE, "<$db_valid_name") or &cgierr("unable to open validation file: $db_valid_name. Reason: $!");    
    LINE: while (<VALIDATE>) {
        (/^#/)    and next LINE;
        (/^\s*$/) and next LINE;
        chomp;
        push (@valhits, &split_decode($_));
    }
    close VAL;
    open (MODIFY, "<$db_modified_name") or &cgierr("unable to open validation file: $db_valid_name. Reason: $!");    
    LINE: while (<MODIFY>) {
        (/^#/)    and next LINE;
        (/^\s*$/) and next LINE;
        chomp;
        push (@modhits, &split_decode($_));
    }   
    $numhits = (($#valhits+1) + ($#modhits+1)) / ($#db_cols+1);

# Now let's print out the page:     
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Validate Links.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" METHOD="POST">
        <input type=hidden name="db" value="$in{'db'}"> 
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy"><FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                       <b>$html_title: Validate Links</b>
            </font></td></tr>
        </table>
    |;
    if ($numhits > 0) {
        print qq|
            <blockquote>
                <p><$font>Check which records ($numhits) you wish to validate and then press "Validate $html_objects". <br>
                  Only 10 records are displayed at a time.<br>
                  Click on the validate link to open a new window to preview the site.
            <p>
        |;
# Counter, we only want to display 10 at a time.
        my $counter = 0;
        
# Go through each validated hit and convert the array to hash and send to 
# html_record for printing. Also add a checkbox with name=key and value=delete.
        for ($i = 0; $i < ($#valhits+1) / ($#db_cols+1); $i++) {
            last if (++$counter > 10);
            %tmp = &array_to_hash ($i, @valhits);
            print qq|
        <table border=1><TR><TD colspan=2>|;
            &html_record_form_mult (%tmp);
            my $reason = &load_template ('email-del.txt', \%tmp);
            print qq|
                </TD></TR>
                <TR><TD VALIGN=TOP><INPUT TYPE="RADIO" NAME="$tmp{$db_key}" VALUE="validate"> <$font><a href="$tmp{'URL'}" target="_blank">Validate</a></font>                      
                    </TD>
                    <TD VALIGN=TOP ROWSPAN=2><INPUT TYPE="RADIO" NAME="$tmp{$db_key}" VALUE="delete"> <$font>Delete. Email Reason:</font><br> <textarea name="reason-$tmp{$db_key}" rows=4 cols=40>$reason</textarea></TD>
                </TR>
                <TR><TD VALIGN=TOP><$font><a href="$db_script_url?view_records=1&$db_cols[$db_url]=$tmp{$db_cols[$db_url]}" target="_blank">Duplicate Check</a></font></TD></TR>
                </TABLE>
            <hr width=550 bgcolor="black" size=4 align=left>
            |;
        }

# Go through each modified hit and convert the array to hash and send to 
# html_record for printing. Also add a checkbox with name=key and value=delete.
        for ($i = 0; $i < ($#modhits+1) / ($#db_cols+1); $i++) {
            last if (++$counter > 10);
            %tmp = &array_to_hash ($i, @modhits);
            print qq|
        <table border=1><TR><TD colspan=2>|;
            &html_record_form_mult (%tmp);
            print qq|
                </TD></TR>
                <TR><TD VALIGN=TOP><INPUT TYPE="RADIO" NAME="$tmp{$db_key}" VALUE="modify"> <$font><a href="$tmp{'URL'}" target="_blank">Modify</a></font></TD>
                    <TD VALIGN=TOP><INPUT TYPE="RADIO" NAME="$tmp{$db_key}" VALUE="delete"> <$font>Delete. Email Reason:</font><br> <textarea name="reason-$tmp{$db_key}" rows=4 cols=40>$db_email_reject</textarea></TD>
                </TR></TABLE>
            <hr width=550 bgcolor="black" size=4 align=left>
            |;
        }
        print qq|
    <p>
    </blockquote>
    <table border=0 bgcolor="#DDDDDD" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td>
            <p><center><INPUT TYPE="SUBMIT" name="validate_records" VALUE="Validate/Delete Selected $html_object(s)"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
            |; &html_footer; print qq|
        </td></tr>
    </table>    
        |;
    }
    else {
        print "<p><$font><b>No records to validate!</b></font></p>";
    }
    print qq|
</body>
</html>
    |;
}

sub html_validate_success {
# --------------------------------------------------------
# This page let's the user know that the records were successfully
# validated.
    my ($valsuc, $modsuc, $delsuc) = @_;
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_object(s) Validated/Deleted.</title>
</head>

<body bgcolor="#DDDDDD">
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                <b>$html_object(s) Validated/Deleted.</b>
        </td></tr>
        <tr><td>
                <p><center><$font_title><b>
                    $html_object(s) Validated/Deleted.
                </b></font></center><br>
                <$font>|;
print "The following records were successfully validated: $valsuc<br>" if ($valsuc);
print "The following records were successfully modified: $modsuc<br>" if ($modsuc);
print "The following records were successfully deleted: $delsuc<br>" if ($delsuc);
                &html_footer; print qq|
        </td></tr>
    </table>
</body>
</html> 
    |;

}

##########################################################
##                    Mass Mailing                      ##
##########################################################

sub html_mail_target {
# --------------------------------------------------------
# This form displays a search form to do a targeted mailing.
#
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Targeted Mailing.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="GET">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Targeted Mailing</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Targeted Mailing
                    </b></font></center><br>                    
                    <$font>
                    Search the database for which link owners you wish to mail to or <a href="$db_script_url?db=links&html_mail_form=1&all=1"><b>mail to all link owners</b></a>.<br>
                        |;  &html_record_form(); print qq|
                        |; &html_search_options; print qq|
                    </font></p>
                    <p><center> <INPUT TYPE="SUBMIT" NAME="html_mail_form" VALUE="Search"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                    |; &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html> 
    |;
}

sub html_mail_form {
# --------------------------------------------------------
# Figure out who we are mailing to.
#
    my $audience;
    if ($in{'all'}) {
        $audience = 'The entire database will be mailed. <input type=hidden name=all value=1>';
    }
    else {
        my (%tmp, %seen);
        my ($status, @hits) = &query(); 
        my ($numhits) = ($#hits+1) / ($#db_cols+1);
        for (0 .. $numhits - 1) {
            %tmp = &array_to_hash($_, @hits);
            ($seen{$tmp{$db_cols[$db_contact_email]}}++) ?
                ($audience .= qq!Owner of link ($tmp{$db_key}) is already being emailed.<br>!) :
                ($audience .= qq!<input type=checkbox name="$tmp{$db_key}" value="mail" checked> $tmp{$db_cols[$db_contact_name]} - $tmp{$db_cols[$db_contact_email]}<br>!);
        }
        $audience ? 
            ($audience = "<p>The following users will be emailed. You can uncheck users you don't want to mail to.</p><blockquote>$audience</blockquote>") :
            ($audience = "No users were found!");
    }
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Mass Mail.</title>
</head>
    
    <body bgcolor="#DDDDDD">
        <form action="$db_mail_url" METHOD="POST">
            <input type=hidden name="db" value="links">
        <blockquote>
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                       <b>$html_title: Mass Mail</b>
            </td></tr>
        </table>
        <p><$font>$audience</font></p>
        <p><$font>In your message you can put &lt;%field_name%&gt; tags which will be replaced by the users
                  link information. For instance, you could put:<br>
                  <em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Congratulations your link now has &lt;%Hits%&gt;!</em>
        <p>and hits would be replaced by each users number of hits. Be sure to do a targeted message first to only
                  yourself to make sure the system is working!
        <p><$font>Subject: <input name="subject"></font>
        <p><$font>Message:<br>
        <textarea name=message rows=40 cols=50></textarea>
        <p><input type=checkbox name=debug value=1 CHECKED> <$font><b>Debug Mode</b> - No messages will actually be sent!</font></p>
        <p><center> <INPUT TYPE="SUBMIT" NAME="mass_mail" VALUE="Send Mass Mail"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
        |; &html_footer; print qq| </center>       
    </form>
</body>
</html>     
    |;      
}

sub html_mail_update {
# --------------------------------------------------------
# Figure out who we are mailing to.
#
    my $new_links   = &build_new_links;
    my $subscribers = &build_email_list;
    my $subject     = "What's new for " . &get_date;
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Email Update.</title>
</head>
    
    <body bgcolor="#DDDDDD">
        <form action="$db_mail_url" METHOD="POST">
            <input type=hidden name="db" value="email">
        <blockquote>
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                       <b>$html_title: Email Update</b>
            </td></tr>
        </table>
        <p><$font>Mail to:<br>$subscribers</font></p>       
        <p><$font>Subject: <input name="subject" value="$subject"></font>
        <p><$font>Message:<br>
        <textarea name=message rows=40 cols=50>$new_links
--------------------------------------------------------------------
To unsubscribe from this mailing list, just visit:
   $build_email_url?action=unsubscribe&email=&lt;%Contact Email%&gt;</textarea>
        <p><$font><b>Note:</b> &lt;%Contact Email%&gt; will be replaced with the users email address.</font></p>
        <p><input type=checkbox name=debug value=1 CHECKED> <$font><b>Debug Mode</b> - No messages will actually be sent!</font></p>        
        <p><center> <INPUT TYPE="SUBMIT" NAME="mass_mail" VALUE="Send Mass Mail"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
        |; &html_footer; print qq| </center>       
    </form>
</body>
</html>     
    |;      
}
##########################################################
##                    Email Messages                    ##
##########################################################

sub html_validate_email {
# --------------------------------------------------------
# All the link information is stored in %link.
    my (%link) = @_;

# Set the to, from, subject and message to send.
    my $to      = $link{'Contact Email'};
    my $from    = $db_admin_email;
    my $subject = "Your link has been added!";
    my $msg     = &load_template ('email-add.txt', \%link);
    
# Then mail it away!
    require "$db_lib_path/Mailer.pm";
    my $mailer = new Mailer ( { smtp => $db_smtp_server, 
                                sendmail => $db_mail_path, 
                                from => $from, 
                                subject => $subject,
                                to => $to,
                                msg => $msg,
                                log => $db_mailer_log 
                            } ) or 
        &cgierr("Unable to init mailer! Reason: $Mailer::error");
    $mailer->send or &cgierr ("Unable to send addition message. Reason: $Mailer::error");   
}

sub html_modify_email {
# --------------------------------------------------------
# All the link information is stored in %link.
    my (%link) = @_;

# Set the to, from, subject and message to send.
    my $to      = $link{'Contact Email'};
    my $from    = $db_admin_email;
    my $subject = "Your link has been added!";  
    my $msg     = &load_template ('email-mod.txt', \%link);
    
# Then mail it away!    
    require "$db_lib_path/Mailer.pm";
    my $mailer = new Mailer ( { smtp => $db_smtp_server, 
                                sendmail => $db_mail_path, 
                                from => $from, 
                                subject => $subject,
                                to => $to,
                                msg => $msg,
                                log => $db_mailer_log 
                            } ) or 
        &cgierr("Unable to init mailer! Reason: $Mailer::error");
    $mailer->send or &cgierr ("Unable to send modification message. Reason: $Mailer::error");   
}

sub html_reject_email {
# --------------------------------------------------------
# All the link information is stored in %link.
    my (%link) = @_;

# The message subject is defined in the form.
    my $to      = $link{'Contact Email'};
    my $from    = $db_admin_email;
    my $subject = "Your link has been rejected.";
    my $msg     = $in{"reason-$link{$db_key}"}; 

# Mail it away!
    require "$db_lib_path/Mailer.pm";
    my $mailer = new Mailer ( { smtp => $db_smtp_server, 
                                sendmail => $db_mail_path, 
                                from => $from, 
                                subject => $subject,
                                to => $to,
                                msg => $msg,
                                log => $db_mailer_log 
                            } ) or 
        &cgierr("Unable to init mailer! Reeason: $Mailer::error");
    $mailer->send or &cgierr ("Unable to send rejection message. Reason: $Mailer::error");
}

##########################################################
##                    Misc                              ##
##########################################################

sub html_check_links {
# --------------------------------------------------------
# This routine checks to make sure that there are no links w/o
# associated categories.
#

    my $bad_category = shift;
    my $message      = shift;
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Check Categories.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" method="POST">
        <input type=hidden name="db" value="$in{'db'}">
        <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
            <tr><td colspan=2 bgcolor="navy">
                    <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                    <b>$html_title: Check Categories</b>
            </td></tr>
            <tr><td>
                    <p><center><$font_title><b>
                        Check Categories
                    </b></font></center><br>
                    <$font>|;
    if ($message) {
        print qq|<P><b>$message</b></p>|;
    }
    elsif (!$bad_category) {
        print qq|<P>There were no problems found!|;
    }
    else {
        print qq|<P align=center><font color=red><b>Warning!</b></font></p>
                 <p>You have some links in your links database that are associated with a category that does not exist!
                    You can <b>either</b>:
                        <ol>
                            <li><b>Add</b> this category to the database.
                            <li><b>Delete</b> all links with this non-existant category.
                            <li><b>Move</b> all links into a new existing category.
                        </ol>
                 <P>Note: a maximum of 10 listings are displayed at a time.</strong></p>
                 
                 $bad_category
                 
                </font></p>
                <p><center> <INPUT TYPE="SUBMIT" NAME="fix_links" VALUE="Update Categories"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
            |;
        }
        &html_footer; print qq|
            </td></tr>
        </table>
    </form>
</body>
</html> 
    |;
}

sub html_check_duplicates {
# --------------------------------------------------------
# This routine checks to see if there are any duplicate links.
#
    my %duplicates = @_;
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Check Duplicate Links.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" METHOD="POST">
        <input type=hidden name="db" value="$in{'db'}">
        
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                   <b>$html_title: Check Duplicate Links</b>
        </td></tr>
    </table>
    
    <blockquote><p><$font>
    |;
    if (!%duplicates) {
        print "No duplicates found.";
    }
    else {
        print qq~
                <p>To delete the offending links, click on the checkboxes and click delete:</p>
                <TABLE BORDER=1>
        ~;
        foreach (keys %duplicates) {
            print qq~<tr><td colspan=2><$font><b>$_</b></font></td></tr>
                     <tr><td>&nbsp; &nbsp;</td>
                         <td>
            ~;
            for ($i = 0; $i <= $#{$duplicates{$_}}; $i = $i + 3) {
                my $id    = ${$duplicates{$_}}[$i];
                my $title = ${$duplicates{$_}}[$i + 1];
                my $cat   = ${$duplicates{$_}}[$i + 2];
                print qq~<input type=checkbox name="$id" value="delete"> <$font>(<a href="$db_script_url?db=links&view_records=1&$db_key=$id&ww=1" target="_blank">$id</a>) $title in <em>$cat</em><br>~;
            }
            print qq~</td></tr>~;
        }
        print qq~
            </table>
            <p>
            </blockquote>
            <table border=0 bgcolor="#DDDDDD" cellpadding=5 cellspacing=3 width=500 valign=top>
                <tr><td>
                <p><center><INPUT TYPE="SUBMIT" name="delete_records" VALUE="Delete Checked $html_object(s)"> <INPUT TYPE="RESET" VALUE="Reset Form"></center></p>
                ~; &html_footer; print qq~
            </td></tr>
        </table>    
        ~;
    }
    print qq|
</body>
</html>
    |;
}

sub html_edit_template {
# --------------------------------------------------------
# Lets the user edit his templates.
#
    my $message   = shift;
    my $templates = &get_template_list($in{'edit_tpl'});    
    my $text      = '';
    if ($in{'edit_tpl'} =~ /^[\w\d_\-]+\.[\w\d_\-]+$/) { 
        open (TPL, "<$db_template_path/$in{'edit_tpl'}") or &cgierr ("Can't load template: $db_template_path/$in{'edit_tpl'}. Reason: $!");
        $text = join "", <TPL>;
        close TPL;      
        $text =~ s,</textarea>,</text-area>,ig;
    }
    my $save_as   = $in{'edit_tpl'};
    
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: Edit Templates.</title>
</head>

<body bgcolor="#DDDDDD">
    <form action="$db_script_url" METHOD="POST">
        <input type=hidden name="db" value="$in{'db'}">
        
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                   <b>$html_title: Edit Templates</b>
        </td></tr>
    </table>
    
    <p><$font color=red><b>$message</b></font></p>
    |; if ($in{'edit_tpl'}) { print qq~<p><$font><b><a href="$db_script_link_url&html_template_help=1&template=$in{'edit_tpl'}">Template Help and Codes you can use!</a></b></font></p>~; } print qq|   
    <p><$font>Available Templates: $templates <input type=submit name="html_edit_template" value="Edit!">   
    <p><textarea name=tpl rows=40 cols=60>$text</textarea>
    <p><$font>Save as: <input name="save_tpl" value="$save_as"></font>
    <p><INPUT TYPE="SUBMIT" NAME="save_template" VALUE="Save Template"> <INPUT TYPE="RESET" VALUE="Reset Form"></p>
</body>
</html>
    |;
}

sub html_template_help {
# --------------------------------------------------------
# Lists what you can use in what template.
#
    my $template = $in{'template'};
    my %fields   = (  'home.html' => qq~
                                        <li>&lt;%category%&gt; : Listing of all the main categories and category descriptions<br>
                                        <li>&lt;%grand_total%&gt; : The total number of links in the database.
                                    ~,
                      'new.html' => qq~                 
                                        <li>&lt;%total%&gt; : Total number of new links.
                                        <li>&lt;%grand_total%&gt; : The total number of links in the database.
                                        <li>&lt;%link_results%&gt; : List of new links.
                                        <li>&lt;%title_linked%&gt; : A linked title bar.
                                    ~,
                      'cool.html' => qq~
                                        <li>&lt;%total%&gt; : Total number of new links.
                                        <li>&lt;%grand_total%&gt; : The total number of links in the database.
                                        <li>&lt;%title_linked%&gt; : A linked title bar.                                        
                                        <li>&lt;%link_results%&gt; : List of new links.
                                        <li>&lt;%percent%&gt; : The top x % of links or the top n links.
                                    ~,
                      'category.html' => qq~
                                        <li>&lt;%total%&gt; : Total number of new links.
                                        <li>&lt;%grand_total%&gt; : The total number of links in the database.
                                        <li>&lt;%title%&gt; : The category title.                                       
                                        <li>&lt;%title_linked%&gt; : A linked title bar.                                        
                                        <li>&lt;%category%&gt; : The list of sub-categories.
                                        <li>&lt;%links%&gt; : The list of links in this category.
                                        <li>&lt;%category_name%&gt; : The category name including _ and / characters.
                                        <li>&lt;%category_clean%&gt; : The category name with _ and / converted.
                                        <li>&lt;%category_name_converted%&gt; : The category name url escaped.
                                        <li>&lt;%description%&gt; : The category description.
                                        <li>&lt;%meta_name%&gt; : Meta name information.
                                        <li>&lt;%meta_keywords%&gt; : The meta keywords information.
                                        <li>&lt;%header%&gt; : Custom header.
                                        <li>&lt;%footer%&gt; : Custom footer.
                                        <li>&lt;%prev%&gt; : Link to previous page (if build span pages turned on).
                                        <li>&lt;%next%&gt; : Link to next page (if build span pages turned on).
                                        <li>&lt;%related%&gt; : Related categories.
                                    ~,
                    'link.html' => qq~
                                        <li>&lt;$detailed_url%&gt; : Link to a detailed page if you have this option set.
                                        <li>You can use &lt;%Field Name%&gt; where Field Name is any field in your
                                        links database like: Title, URL, etc.
                                    ~,
                    'detailed.html' => qq~
                                        <li>&lt;%grand_total%&gt; - Total number of links in your database.
                                        <li>&lt;%title_linked%&gt; - A linked title bar.
                                    ~,
                    'search_results.html' => qq~
                                        <li>&lt;%term%&gt; - A URL escaped version of the search term.
                                        <li>&lt;%category_results%&gt; - A list of all the category matches.
                                        <li>&lt;%link_results%&gt; - A list of all the link matches.
                                        <li>&lt;%next%&gt; - A toolbar to go to the next search results page.
                                        <li>&lt;%cat_hits%&gt; - Total number of category hits.
                                        <li>&lt;%link_hits%&gt; - Total number of link hits.
                                    ~
                );  
    &html_print_headers;
    print qq~
<html>
<head>
    <title>$html_title: Template Help.</title>
</head>

<body bgcolor="#DDDDDD">
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                <b>$html_title: Template Help.</b>
        </td></tr>
        <tr><td>
                <p><center><$font_title><b>
                    Template Help
                </b></font></center><br>
                <$font>Templates are a powerful new feature of Links 2.0! They allow you to edit
                       the look and feel of your site without having to change any code, and all
                       from within your browser.<br><br>
                       
                       To use templates, make sure \$build_use_templates is turned on in links.cfg,
                       and then edit the templates using the admin control panel. In each template you
                       can use ceartain codes which Links will replace with the actual content. For
                       example, you can use &lt;%date%&gt; to put the date the pages were updated.<br><br>
                       
                       Links also supports simple conditional fields, where html will only be displayed if 
                       a field exists. For instance, you only want to display the meta keywords if your
                       current category has some meta keywords! You could use:<br><br>
                       
                       &lt;%if meta_keywords%&gt;<br>
                       &nbsp; &nbsp; &lt;meta name="keywords" value="&lt;%meta_keywords%&gt;"&gt; <br>
                       &lt;%endif%&gt;
                       
                       <br><Br>                    
                       When Links sees the 'if meta_keywords' it will print everything up to the endif
                       tag, if and only if, this template has something defined for meta_keywords.
                        
                       <br><br><b>Warning:</b> Links can not understand the &lt;%if variable%&gt; unless it appears
                       on a line by itself. Any other information found on the same line will be skipped, which 
                       may cause information not to be displayed.
                                                               
                       <br><br><b>Note:</b> the default templates are filled with &lt;%build_root_url%&gt; and
                       other URL information, there's no reason why you have to keep it! If it's clearer to you,
                       just hard code in your own paths. They are there just so a user does not have to edit 
                       every page to get going!
                       
                       <p>By default you can use the following codes:
                       <ul><li>&lt;%date%&gt; - Current date.
                           <li>&lt;%time%&gt; - Current time.
                           <li>&lt;%db_cgi_url%&gt; - URL to your user cgi directory.
                           <li>&lt;%build_root_url%&gt; - URL to your user home directory.
                           <li>&lt;%site_title%&gt; - Title of your Links directory.
                           <li>&lt;%css%&gt; - URL to your links.css file.
                       </ul>
                       
    ~; if (exists $fields{$template}) { print qq~<p> You can also use the following fields for this template: <b>$template</b><p><ul>$fields{$template}</ul></p>~; }
    print qq~
                        <p><$font>For dynamic pages (like add, search, modify, subscribe) you can generally use any term
                           that's submitted from a form, or passed in through the URL. i.e. in add_success.html, I can
                           access all the form fields by just using &lt;%Field Name%&gt;.</font></p>
            </td></tr>
    </table>
</body>
</html>
    ~;
}

sub html_generic  {
# --------------------------------------------------------
# Produce a standard html page.
#
    my ($title, $message) = @_;
    &html_print_headers();
    print qq|
<html>
<head>
    <title>$html_title: $title.</title>
</head>

<body bgcolor="#DDDDDD">
    <table border=1 bgcolor="#FFFFFF" cellpadding=5 cellspacing=3 width=500 valign=top>
        <tr><td colspan=2 bgcolor="navy">
                <FONT FACE="MS Sans Serif, arial,helvetica" size=1 COLOR="#FFFFFF">
                <b>$html_title: $title.</b>
        </td></tr>
        <tr><td>
                <p><center><$font_title><b>
                    $title
                </b></font></center><br>
                <$font>
                    $message
                </font>
                </p>
                |; &html_footer; print qq|
        </td></tr>
    </table>
</body>
</html>
    |;
}

##########################################################
##                      $html_object Layout             ##
##########################################################

sub html_record_form {
# --------------------------------------------------------
# These are now auto generated, but can be overridden by printing
# out your form/record here.
#
    my (%rec) = @_;
    print &build_html_record_form(%rec);
}

sub html_record_form_mult {
# --------------------------------------------------------
# These are now auto generated, but can be overridden by printing
# out your form/record here.
#
    my (%rec) = @_;
    print &build_html_record_form ('multiple', %rec);
}
    
sub html_record {
# --------------------------------------------------------
# These are now auto generated, but can be overridden by printing
# out your form/record here.
#
    my (%rec) = @_;     # Load any defaults to put in the VALUE field.
    print &build_html_record(%rec);
}

1;