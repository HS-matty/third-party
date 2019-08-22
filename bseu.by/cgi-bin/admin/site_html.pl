#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: site_html.pl
#  Description: This library contains all the HTML that will be generated in
#               the finished directory.
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

# ----------------------------------------------------------------------
# The HTML in this file and the style sheet (links.css) have been authored
# by Chris Croome of webarchitects. 
#
#        Email: chris@atomism.demon.co.uk
#          Web: http://www.webarchitects.co.uk/
# ----------------------------------------------------------------------

##########################################################
##                    Globals                        ##
##########################################################
# You can put variables here that you would like to use throughout
# the site.

$date = &get_date;
$time = &get_time;

# The default DTD is HTML 4 strict. You can check this using the W3's validator
# http://validator.w3.org/
#
# HTML 4.0 strict results in a very plain look in NN 2/3 and MSIE 2 as the 
# style sheet which controls the layout, fonts and colours only works with 
# CSS browsers - NN 4/5 and MSIE 3/4/5 and Opera 3.5.
# 
# If you use font tags (and other HTML 4 depreciated tags) then set to DTD to:
#$dtd   = '!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"';
#
# If you use frames then set the DTD to:
#$dtd   = '!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Frameset//EN" "http://www.w3.org/TR/REC-html40/frameset.dtd"';
#
$dtd    = '!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN" "http://www.w3.org/TR/REC-html40/strict.dtd"';

# Set the address for the style sheet using this variable.
# If you want to check the validity of the style sheet you can use this validator
# - http://jigsaw.w3.org/css-validator/
#
$css    = qq~link rel=stylesheet href="$build_css_url" type="text/css" title="webarchitects links style sheet"~;

# If you set any colours or a background image using the body tag then you 
# should use transitional DTD (MSIE3 does not use the CSS background and can cause the site
# to look strange it the browser default background color is set left as the default grey)
#$site_body = 'body bgcolor="#FFFFFF" text="#000000"';
$site_body = 'body';

$site_title = $build_site_title;

$site_menu = qq~
<p><small class="menu">|
    <a class="menulink" href="$build_root_url">Home</a> |
    <a class="menulink" href="$build_add_url">Add a Resource</a> |
    <a class="menulink" href="$build_modify_url">Modify a Resource</a> |
    <a class="menulink" href="$build_new_url">What's New</a> |
    <a class="menulink" href="$build_cool_url">What's Cool</a> |
    <a class="menulink" href="$build_ratings_url">Top Rated</a> |
    <a class="menulink" href="$build_email_url">Email Updates</a> | 
    <a class="menulink" href="$build_jump_url?ID=random">Random Link</a> |
    <a class="menulink" href="$build_search_url">Search</a> |
</small></p>
~;

# This is for the search facility at the bottom of all pages apart from the search page.
$site_search = qq~
    <form action="$build_search_url" method="GET">
        <h2>Search</h2>
            <div class="margin">
                <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><strong class="search">Looking for something in particular?</strong></td></tr>
                <tr><td><input type="text" size=15 name="query"> <input type=submit value="Search!"></td></tr>
                <tr><td><small class="more"><a href="$build_search_url">More search options</a></small></td></tr>
                </table>
        </div>
    </form>
~;

# You must keep a link back to Gossamer Threads unless you purchase a license. Please see the 
# Readme for details.
$site_footer = qq~
        <p><small class="update">Pages Updated On: $date - $time<br>
        Links Engine Powered By: <a href="http://www.gossamer-threads.com/">Gossamer Threads Inc.</a></small></p>       
~;

##########################################################
##                    A Link                          ##
##########################################################

sub site_html_link {
# --------------------------------------------------------
# This routine is used to display what a link should look
# like. It's a little complex looking just because we have to 
# check for blank entries..

my (%rec) = @_;

$build_detailed ?
    ($output = qq~<ul><li><a class="link" href="$build_detail_url/$rec{$db_key}$build_extension">$rec{'Title'}</a>~) :
    ($output = qq~<ul><li><a class="link" href="$build_jump_url?$db_key=$rec{$db_key}">$rec{'Title'}</a>~);

if ($rec{'Description'})        { $output .= qq~ <span class="descript">- $rec{'Description'}</span>\n~; }
if ($rec{'isNew'} eq "Yes")     { $output .= qq~ <small><sup class="new">new</sup></small>~; }
if ($rec{'isPopular'} eq "Yes") { $output .= qq~ <small><sup class="pop">pop</sup></small>~; }

$output .= qq~ <small class="date">(Добавлено: $rec{'Date'} Hits: $rec{'Hits'} Rating: $rec{'Rating'} Votes: $rec{'Votes'}) <a href="$build_rate_url?ID=$rec{'ID'}">Rate It</a></small>
    </ul>
~;

return $output;
}

##########################################################
##                    Home Page                    ##
##########################################################

sub site_html_home {
# --------------------------------------------------------
# This routine will build a home page. It is not meant to have any 
# links on it, only subcategories.
#
#   $category       : The list of subcategories.
#   $time           : The current time.
#   $date           : The current date.
#   $grand_total    : The total number of links.
#

my ($output);

$output = qq~ 
<$dtd>
<html>

<head>
<title>$site_title</title>
<meta name="description" content="put your description here">
<meta name="keywords" content="put your keywords here">
<$css>
</head>

<$site_body>

<h1 class="home">$site_title</h1>

    $site_menu

    <p>Site description</p>

        <h2>Categories:</h2>
        
        $category
        
        <p class="grandtotal">There are <strong>$grand_total</strong> links for you to choose from!</p>

    $site_search
    $site_footer

</body>
</html>
~;

return $output;
}

##########################################################
##                    What's New Page                ##
##########################################################

sub site_html_new {
# --------------------------------------------------------
# This routine will build a what's new page. You can use the following
# variables
#
#   $time           : The current time.
#   $date           : The current date.
#   $total          : The total number of new links.
#   $grand_total    : The total number of links.
#   $link_results   : The list of new links.
#   $title_linked
#

$output = qq~ 
<$dtd>
<html>

<head>
<title>$site_title: What's New</title>
<meta name="description" content="put your description here">
<meta name="keywords" content="put your keywords here">
<$css>
</head>

<$site_body>

    <p><strong class="title">$title_linked</strong></p>

<h1>$site_title: What's New</h1>

        $site_menu

        <h2>$total New Links:</h2>

            $link_results

        $site_search
        $site_footer

</body>
</html>
~;

return $output;
}

##########################################################
##                    What's Cool Page              ##
##########################################################

sub site_html_cool {
# --------------------------------------------------------
# This routine will build a what's new page. You can use the following
# variables
#
#   $time           : The current time.
#   $date           : The current date.
#   $total          : The total number of new links.
#   $grand_total    : The total number of links.
#   $percent        : The cool percent cutoff (top 3%, etc).
#   $link_results   : The list of cool links.
#

# Your Title and Header.
$output = qq~ 
<$dtd>
<html>

<head>
<title>$site_title: What's Cool</title>
<meta name="description" content="put your description here">
<meta name="keywords" content="put your keywords here">
<$css>
</head>

<$site_body>

<p><strong class="title">$title_linked</strong></p>

<h1>$site_title: What's Cool - The Top $percent!</h1>

    $site_menu

    <h2>$total Cool Links:</h2>

    $link_results

    $site_search
    $site_footer

</body>
</html>
~;

return $output;
}

##########################################################
##                    Detailed View                     ##
##########################################################

sub site_html_detailed {
# --------------------------------------------------------
# This routine will build a single page per link. It's only
# really useful if you have a long review for each link --
# or more information then can be displayed in a summary.
#

    my %rec = @_;

$output = qq~ 
<$dtd>
<html>

<head>
<title>$site_title: $rec{'Title'}</title>
<$css>
</head>

<$site_body>

<p><strong class="title">$title_linked</strong></p>

<h1>$site_title: Detailed View!</h1>

    $site_menu

    <h2>$rec{'Title'}</h2>
    <p>$rec{'Description'}</p>
    <p><small>Submitted by: $rec{'Contact Name'} -- <a href="mailto:$rec{'Contact Email'}">$rec{'Contact Email'}</a><br>Hits: $rec{'Hits'}</small></p>
    <p><a class="link" href="$build_jump_url?$db_key=$rec{$db_key}">Visit this link</a>.
    $site_search
    $site_footer

</body>
</html>
~;

    return $output;
}

##########################################################
##                    Category Pages                  ##
##########################################################

sub site_html_category {
# --------------------------------------------------------
# This rountine will build a page based for the current category.
# Insert the following variables in the appropriate place.
#
#   $category       : The list of subcategories.
#   $links          : The list of links in this category.
#   $time           : The current time.
#   $date           : The current date.
#   $title_linked   : A linked version of the title bar.
#   $title          : An unlinked version of the title bar.
#   $total          : The total number of links in this category.
#   $grand_total    : The total number of links.
#   $category_name  : The category name.
#   $category_name_escaped  : The category name URL escaped (used for the Add function)
#   $category_clean : The category name with _ and / removed.
#
# The following will work assuming you haven't changed the order of the
# category database. If you have, or have added new fields, you can access
# any of the information by using $category{$category_name}[field_num] where 
# field number is the number (indexed from 0) of the field you want. Otherwise
# you can just use the following:
#
#   $description    : Category Description
#   $meta_name      : Meta Description Tag
#   $meta_keywords  : Meta Keywords Tag
#   $header         : Custom Header
#   $footer         : Custom Footer
#   $related        : A <li> list of related categories.
#

my ($output);

$output = qq~
<$dtd>
<html>

<head>
<title>$site_title: $category_clean</title>
<meta name="description" content="$meta_name">
<meta name="keywords" content="$meta_keywords">
<$css>
</head>

<$site_body>

<p><strong class="title">$title_linked</strong></p>

<h1>$site_title: $category_clean</h1>

        $site_menu

<p>$category_name_escaped</p>

~; if ($header) { $output .= qq~<h2>$header</h2>
~; }
if ($category) { $output .= qq~
                    <h2>Categories:</h2>
                    $category
~; } 
if ($links) {$output .= qq~          
                    <h2>Links:</h2>
                    $links
~; }
if ($related) {
$output .= qq~
                    <h2>Related Categories:</h2>
                    <ul>$related</ul>
~; }

if ($prev or $next) { $output .= qq~<p>~; }
if ($prev)   { $output .= qq~<strong><a href="$prev">Prev $build_links_per_page</a></strong> ~; }
if ($next)   { $output .= qq~<strong><a href="$next">Next $build_links_per_page</a></strong> ~; }
if ($prev or $next) { $output .= qq~</p>~; }

if ($footer) { $output .= qq~<p>$footer</p>~; }

$output .= qq~

        $site_search
        $site_footer

</body>
</html>
~;

return $output;
}

##########################################################
##                    Category Listings               ##
##########################################################

sub site_html_print_cat {
# --------------------------------------------------------
# This routine determines how the list of categories will look.
# We now use a table to split the category name up into two columns.
# For each category you can use the following variables:
#
#   $url        : The URL to go to that category
#   $category_name : The category name with _ and / removed.
#   $category_descriptions{$subcat}: The category description (if any).
#   $numlinks   : The number of links inside that category (and subcategories).
#   $mod        : The newest link inside of that category.
#

    my (@subcat) = @_; 
    my ($url, $numlinks, $mod, $subcat, $category_name, $description, $output, $i);
    my ($half) = int (($#subcat+2) / 2);
    
    # Print Header.
    $output = qq~<div class="margin"><table width="80%" border="0" cellspacing="0" cellpadding="0"><tr><td class="catlist" valign="top">\n~;
    
    foreach $subcat (sort @subcat) { 
        ($description) = @{$category{$subcat}}[2];
        
# First let's get the name, number of links, and last modified date...  
        $url = "$build_root_url/" . &urlencode($subcat) . "/";
        if ($subcat =~ m,.*/([^/]+)$,) { $category_name = &build_clean($1); } else { $category_name = &build_clean($subcat); }
        $numlinks = $stats{"$subcat"}[0]; 
        $mod = $stats{"$subcat"}[1];

# We check to see if we are half way through, if so we stop this table cell
# and begin a new one (this lets us have category names in two columns).        
        if ($i == $half) {
            $output .= qq~</td><td class="catlist" valign="top">\n~;
        }
        $i++;
        
        
# Then we print out the name linked, new if it's new, and popular if its popular.
        $output .= qq~<dl><dt><strong><a class="link" href="$url">$category_name</a></strong> <small class="numlinks">($numlinks)</small> ~;
        $output .= qq~<small><sup class="new">new</sup></small>~ if (&days_old($mod) < $db_new_cutoff);
        $output .= qq~</dt>~;
        $output .= qq~<dd><span class="descript">$description </span></dd>~ if (!($description =~ /^[\s\n]*$/));
        $output .= qq~</dl>~;
        
    }

# Don't forget to end the unordered list..
    $output .= "</td></tr></table></div>\n";
    return $output;
}

##########################################################
##                    Add Resources                     ##
##########################################################

sub site_html_add_form {
# --------------------------------------------------------
# This routine determines how the add form page will look like. 
#
    my $category = shift;
    $category ?
        ($category = qq~$category <input type=hidden name="Category" value="$category">~) :
        ($category = &build_select_field ("Category", "$in{'Category'}"));

    &html_print_headers;    
    print qq~   
<$dtd>
<html>

<head>
<title>$site_title: Add a Resource</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Add a Resource</h1>

    $site_menu

    <form action="$build_add_url" method="POST">
        <p>Please fill out the form completely, and we'll add your resource as soon as possible.</p>
        <div class="margin">
            <table border ="0" cellspacing="0" cellpadding="0">
                <tr><td align="right" valign="top">Title:</td>
                    <td><input name="Title" value="$in{'Title'}" size="50"></td></tr>
                <tr><td align="right" valign="top">URL:</td>
                    <td><input name="URL" value="$in{'URL'}" size="50"></td></tr>
                <tr><td align="right" valign="top">Category:</td>
                    <td>$category</td></tr>
                <tr><td align="right" valign="top">Description:</td>
                    <td><textarea wrap="virtual" name="Description" value="$in{'Description'}" rows="3" cols="42">$in{'Description'}</textarea></td></tr>
                <tr><td align="right" valign="top">Contact Name:</td>
                    <td><input name="Contact Name" value="$in{'Contact Name'}" size="40"></td></tr>                            
                <tr><td align="right" valign="top">Contact Email:</td>
                    <td><input name="Contact Email" value="$in{'Contact Email'}" size="40"></td></tr>                              
                <tr><td></td><td><input type="SUBMIT" value="Add Resource"></td></tr>
            </table>
        </div>
    </form>

    $site_search
    $site_footer

</body>
</html>
~;
}

sub site_html_add_success {
# --------------------------------------------------------
# This routine determines how the add failure page will look like. You have
# access to the following variables:
#
#   %in     : the variables used to add the link, useful in confirming what was
#             added.
#

    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Resource Added</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Resource Added</h1>

    $site_menu

    <p>We have received the following link:</p>

<pre><strong>          Title:  $in{'Title'}
            URL:  $in{'URL'}
    Description:  $in{'Description'}
   Contact Name:  $in{'Contact Name'}
  Contact Email:  $in{'Contact Email'}
       Category:  $in{'Category'}
</strong></pre>

    <p>Thank you! We will send you an email once your link has been validated.</p>
    
    $site_search
    $site_footer

</body>
</html>
~;
}

sub site_html_add_failure {
# --------------------------------------------------------
# This routine determines how the add failure page will look like. You have
# access to the following variables:
#
#   $errormsg       : A bulleted list of the problems.
#   %in             : variables used in adding the form. Useful for recreating
#                    the form
#

    my ($errormsg) = $_[0];

    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Error Adding Resource.</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Error Adding Resource</h1>

    $site_menu

    <form action="$build_add_url" method="POST">                        

        <p>There were the following errors trying to add your resource:</p>
        <p><strong class="error">
            $errormsg
        </strong></p>
        <p>Please make any changes and try again!</p>
        <div class="margin">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr><td align="right" valign="top">Title:</td>
                <td><input name="Title" value="$in{'Title'}" size="50"></td></tr>
            <tr><td align="right" valign="top">URL:</td>
                <td><input name="URL" value="$in{'URL'}" size="50"></td></tr>
            <tr><td align="right" valign="top">Category:</td>
                <td>~; $db_select_fields{'Category'} = join (",", &category_list); print &build_select_field ("Category", "$in{'Category'}"); print qq~</td></tr>
            <tr><td align="right" valign="top">Description:</td>
                <td><textarea wrap="virtual" name="Description" value="$in{'Description'}" rows="3" cols="42">$in{'Description'}</textarea></td></tr>
            <tr><td align="right" valign="top">Contact Name:</td>
                <td><input name="Contact Name" value="$in{'Contact Name'}" size="40"></td></tr>                            
            <tr><td align="right" valign="top">Contact Email:</td>
                <td><input name="Contact Email" value="$in{'Contact Email'}" size="40"></td></tr>                              
            <tr><td></td><td><input type="SUBMIT" value="Add Resource"></td></tr>
        </table>
        </div>
    </form>

    $site_search
    $site_footer

</body>
</html>
~;

}

##########################################################
##                    Modify Resources                 ##
##########################################################

sub site_html_modify_form {
# --------------------------------------------------------
# This routine determines how the modify form page will look like. 
# You should include a text field for the URL to be modified as well
# as a new form for the new link information.
#
    &html_print_headers;
    
    print qq~   
<$dtd>
<html>

<head>
<title>$site_title: Modify a Resource</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Modify a Resource</h1>

    $site_menu

    <form action="$build_modify_url" method="POST">
        <p>Please enter the URL of the link you wish to update. Make sure it is identical to the one already in the database:</p>
        <div class="margin"><input name="Current URL" size="30"></div>
        <p>Now enter the new information (all of it, not just the changes) below:</p>
        <div class="margin">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td align="right" valign="top">Title:</td>
                    <td><input name="Title" value="$in{'Title'}" size="50"></td></tr>
                <tr><td align="right" valign="top">URL:</td>
                    <td><input name="URL" value="$in{'URL'}" size="50"></td></tr>
                <tr><td align="right" valign="top">Category:</td>
                    <td>~; $db_select_fields{'Category'} = join (",", &category_list); print &build_select_field ("Category", "$in{'Category'}"); print qq~</td></tr>
                <tr><td align="right" valign="top">Description:</td>
                    <td><textarea wrap="virtual" name="Description" value="$in{'Description'}" rows="3" cols="42">$in{'Description'}</textarea></td></tr>
                <tr><td align="right" valign="top">Contact Name:</td>
                    <td><input name="Contact Name" value="$in{'Contact Name'}" size="40"></td></tr>                            
                <tr><td align="right" valign="top">Contact Email:</td>
                    <td><input name="Contact Email" value="$in{'Contact Email'}" size="40"></td></tr>                                              
                <tr><td></td><td><input type="SUBMIT" value="Modify Resource"></td></tr>
            </table>
        </div>
        </form>

    $site_search
    $site_footer

</body>
</html>
~;
}

sub site_html_modify_success {
# --------------------------------------------------------
# This routine determines how the modify failure page will look like. You have
# access to the following variables:
#
#   %in     : the variables used to modify the link, useful in confirming what was
#             modified.
#

    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Resource Modified</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Resource Modified</h1>

    $site_menu

    <p>We have received the following link:</p>
<pre>          Title:  $in{'Title'}
            URL:  $in{'URL'}
    Description:  $in{'Description'}
   Contact Name:  $in{'Contact Name'}
  Contact Email:  $in{'Contact Email'}
       Category:  $in{'Category'}
</pre>              
    <p>Thank you! We will send you an email once your record has been validated.</p>

    $site_search
    $site_footer

</body>
</html>
~;
}

sub site_html_modify_failure {
# --------------------------------------------------------
# This routine determines how the modify failure page will look like. You have
# access to the following variables:
#
#   $errormsg       : A bulleted list of the problems.
#   %in             : variables used in modifying the form. Useful for recreating
#                    the form
#

    my ($errormsg) = $_[0];

    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Error Modifying Resource.</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Error Modifying Resource</h1>

    $site_menu

    <form action="$build_modify_url" method="POST">
        <p>There were the following errors trying to modify your resource:<br>
            <p><strong class="error">
                $errormsg
            </strong></p>
        <p>Please make any changes and try again!</p>
        <p>Please enter the URL of the link you wish to update. Make sure it is identical to the one already in the database:</p>
        <div class="margin">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><input name="Current URL" value="$in{'Current URL'}" size="30"></td></tr>
            </table>
        </div>
        <p>Now enter the new information (all of it, not just the changes) below:</p>
        <div class="margin">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td align="right" valign="top">Title:</td>
                    <td><input name="Title" value="$in{'Title'}" size="50"></td></tr>
                <tr><td align="right" valign="top">URL:</td>
                    <td><input name="URL" value="$in{'URL'}" size="50"></td></tr>
                <tr><td align="right" valign="top">Category:</td>
                    <td>~; $db_select_fields{'Category'} = join (",", &category_list); print &build_select_field ("Category", "$in{'Category'}"); print qq~</td></tr>
                <tr><td align="right" valign="top">Description:</td>
                    <td><textarea wrap="virtual" name="Description" value="$in{'Description'}" rows="3" cols="42">$in{'Description'}</textarea></td></tr>
                <tr><td align="right" valign="top">Contact Name:</td>
                    <td><input name="Contact Name" value="$in{'Contact Name'}" size="40"></td></tr>                            
                <tr><td align="right" valign="top">Contact Email:</td>
                    <td><input name="Contact Email" value="$in{'Contact Email'}" size="40"></td></tr>                          
                <tr><td></td><td><input type="SUBMIT" value="Modify Resource"></td></tr>
            </table>
        </div>
    </form>

    $site_search
    $site_footer

</body>
</html>
~;

}

##########################################################
##                    Search Results                  ##
##########################################################

sub site_html_search_results {
# --------------------------------------------------------
# This routine displays the search results.
# 

    my (@hits) = @_;
    my $term    = &urlencode ($in{'query'});
    
    &html_print_headers;    
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Search Results</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Search Results</h1>

    $site_menu

    <p>Your search returned <strong>$cat_hits</strong> categories and <strong>$link_hits</strong> Links.</p>

~;
if ($next) {    
    print qq~<p>Pages: $next</p>
~;
}
if ($category_results) {
    print qq~
        <h2>Categories:</h2>
        <ul>$category_results</ul>
~;
}
if ($link_results) {
    print qq~   
        <h2>Links</h2>

        $link_results

~;
}
if ($next) {
    print qq~
        <p>Pages: $next</p>
~;
    }   
    print qq~

    $site_search

<p><small>
<b>Try your search on other Search Engines</b><br>
<a target="_blank" href="http://www.altavista.digital.com/cgi-bin/query?pg=q&what=web&q=$term">Alta Vista</a> - 
<a target="_blank" href="http://www.hotbot.com/?MT=$term&DU=days&SW=web">HotBot</a> -
<a target="_blank" href="http://www.infoseek.com/Titles?qt=$term">Infoseek</a> - 
<a target="_blank" href="http://www.dejanews.com/dnquery.xp?QRY=$term">Deja News</a> -
<a target="_blank" href="http://www.lycos.com/cgi-bin/pursuit?query=$term&maxhits=20">Lycos</a> - 
<a target="_blank" href="http://search.yahoo.com/bin/search?p=$term">Yahoo</a>
</small></p>
    
    $site_footer

</body>
</html>
~;
}

sub site_html_search_failure {
# --------------------------------------------------------
# This routine displays a failed search page with error in $error.
#
    my ($error) = shift;
    my $term    = &urlencode ($in{'query'});
    &html_print_headers;
    
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Search Failed</title>
<$css>
</head>

<$site_body>
<h1>$site_title: Search Failed</h1>

    $site_menu

    <p>Error: <strong class="error">$error</strong></p>

        <form action="$build_search_url" method="GET">                    
            <div class="margin">
                <table border="0" cellspacing="0" cellpadding="0">
                <tr><td><strong class="search">Search again?</strong></td></tr>
                <tr><td><input type="text" size=15 name="query"> <input type=submit value="Search!"></td></tr>
                <tr><td><small class="more"><a href="$build_search_url">More search options</a></small></td></tr>
                </table>
            </div>
        </form>

<p><small>
<b>Try your search on other Search Engines</b><br>
<a target="_blank" href="http://www.altavista.digital.com/cgi-bin/query?pg=q&what=web&q=$term">Alta Vista</a> - 
<a target="_blank" href="http://www.hotbot.com/?MT=$term&DU=days&SW=web">HotBot</a> -
<a target="_blank" href="http://www.infoseek.com/Titles?qt=$term">Infoseek</a> - 
<a target="_blank" href="http://www.dejanews.com/dnquery.xp?QRY=$term">Deja News</a> -
<a target="_blank" href="http://www.lycos.com/cgi-bin/pursuit?query=$term&maxhits=20">Lycos</a> - 
<a target="_blank" href="http://search.yahoo.com/bin/search?p=$term">Yahoo</a>
</small></p>

    $site_footer

</body>
</html>
~;
}
    

sub site_html_search_form {
# --------------------------------------------------------
# This routine displays the search form.

    my $action = shift;
    
    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Search Options</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Search Options</h1>

    $site_menu

    <form action="$build_search_url" method="GET">

        <div class="margin">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr><td>Search: <input type="TEXT" name="query" size="30"> <input type="Submit" value="Search"></td></tr>
                <tr><td>Number of Results: <SELECT name="mh"><OPTION>10<OPTION SELECTED>25<OPTION>50<OPTION>100</SELECT></td></tr>
                <tr><td>As Keywords: <input type="RADIO" name="type" value="keyword" CHECKED> As Phrase: <input type="RADIO" name="type" value="phrase"></td></tr>
                <tr><td>AND connector: <input type="RADIO" name="bool" value="and" CHECKED> OR connector: <input type="RADIO" name="bool" value="or"></td></tr>
            </table>
        </div>
    </form>

    $site_footer

</body>
</html>
~;
}

##########################################################
##                    Email Updates                   ##
##########################################################

sub site_html_mailing {
# --------------------------------------------------------
# This routine displays your mailing list subscribe/unsubscribe form.
#
    my $action = shift;
    my $message;
    ($action eq 'subscribe')   and ($message = qq~You've been successfully subscribed to the mailing list!~);
    ($action eq 'unsubscribe') and ($message = qq~You've been successfully removed from the mailing list!~);
    
    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Email Updates</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Email Updates</h1>

    $site_menu
    
    <form action="$build_email_url" method="POST">
        <div class="margin">        
            <p><strong class="error">$message</strong></p>
            <p>Keep informed of new additions to $site_title, by subscribing to our low-volume
               newsletter that will deliver new listings straight to your inbox!<br><br>        
              <select name="action"><option value="subscribe">Subscribe<option value="unsubscribe">Unsubscribe</select> to the list<br>
               Name: <input name="name" size=15> Email: <input name="email" size=15> <input type="submit" value="Subscribe">
            </p>
        </div>
    </form>
    
    $site_footer

</body>
</html>
    ~;  
}

sub site_html_mailing_error {
# --------------------------------------------------------
# This routine is displayed if there was a problem subscribing.
#
    my $error = shift;
    
    &html_print_headers();
    print qq~
<$dtd>
<html>
<head>
<title>User Error</title>
<$css>
</head>
<body>
<h1>Oops, there was a problem!</h1>
<p>Error: <strong class="error">$error</strong></p>
   
<p>Please <a href="javascript:history.go(-1)">go back</a> to fix the
problem.</p>

</body>
</html>     
    ~;
}

##########################################################
##                    Rate Resources                    ##
##########################################################

sub site_html_ratings {
# --------------------------------------------------------
# This routine determines how the top rated page will look like.
# You can use:
#       $top_rated : a three column table without <table> and </table> tags.
#       $top_votes : a three column table without <table> and </table> tags.
#
#
    my %rec = @_;
    
    &html_print_headers;    
    my $output = qq~   
<$dtd>
<html>

<head>
<title>$site_title: Top Rated</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Top Rated</h1>

    $site_menu
    
    <p><strong>Top 10 Resources (by Rating)</strong></p>

    <div class=margin>
        <table border=0>
            <tr><th><strong>Rating</strong></th><th><strong># Votes</strong></th><th align=left><strong>Resource</strong></th></tr>
            $top_rated
        </table>
    </div>
    
    <p><strong>Top 10 Resources (by Votes)</strong></p>
    <div class=margin>
        <table border=0>
        <tr><th><strong>Rating</strong></th><th><strong># Votes</strong></th><th align=left><strong>Resource</strong></th></tr>
        $top_votes
        </table>
    </div>

    $site_search
    $site_footer

</body>
</html>
~;
    return $output;

}

sub site_html_rate_form {
# --------------------------------------------------------
# This routine determines how the rate form page will look like. 
#
    my %rec = @_;
    
    &html_print_headers;    
    print qq~   
<$dtd>
<html>

<head>
<title>$site_title: Rate a Resource</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Rate a Resource</h1>

    $site_menu

    <form action="$build_rate_url" method="POST">   
        <input type=hidden name="$db_key" value="$in{$db_key}">
        <p>Please rate the link <strong><a href="$rec{'URL'}">$rec{'Title'}</a></strong> between one and ten, with ten being tops.</p>
        <div class="margin">    
            <p><select name=rate>
                <option>---
                <option>1
                <option>2
                <option>3
                <option>4
                <option>5
                <option>6
                <option>7
                <option>8
                <option>9
                <option>10
               </select>
               <input type=submit value="Rate this Link">
            </p>
        </div>
    </form>

    $site_search
    $site_footer

</body>
</html>
~;

}

sub site_html_rate_success {
# --------------------------------------------------------
# This routine determines how the add failure page will look like. You have
# access to the following variables:
#
#   %in     : the variables used to add the link, useful in confirming what was
#             added.
#

    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Resource Rated</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Resource Rated</h1>

    $site_menu

    <p>Thank you for your vote.</p>
    
    $site_search
    $site_footer

</body>
</html>
~;
}

sub site_html_rate_failure {
# --------------------------------------------------------
# This routine determines how the rate failure page will look like. You have
# access to the following variables:
#
#   $errormsg       : A bulleted list of the problems.
#

    my $errormsg = shift;

    &html_print_headers;
    print qq~
<$dtd>
<html>

<head>
<title>$site_title: Error Rating Resource.</title>
<$css>
</head>

<$site_body>

<h1>$site_title: Error Rating Resource</h1>

    $site_menu

        <p>Sorry, but we were unable to rate the resource for the following reason:
        <p><strong class="error">
            $errormsg
        </strong></p>
        <p>Please contact the site administrator if you have any questions.</p>

    $site_search
    $site_footer

</body>
</html>
~;

}
1;