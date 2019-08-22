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

# You can put variables here that you would like to use in any
# of your templates.

    %globals = (
                    date           => &get_date,
                    time           => &get_time,
                    db_cgi_url     => $db_cgi_url,
                    build_root_url => $build_root_url,
                    site_title     => $build_site_title,
                    css            => $build_css_url,
                    banner         => ''
        );


sub site_html_link {
# --------------------------------------------------------
# This routine is used to display what a link should look
# like. 

    my %rec = @_;

# Set new and pop to either 1 or 0 for templates.
    ($rec{'isNew'} eq 'Yes')     ? ($rec{'isNew'} = 1)     : (delete $rec{'isNew'});
    ($rec{'isPopular'} eq 'Yes') ? ($rec{'isPopular'} = 1) : (delete $rec{'isPopular'});

    return &load_template ('link.html', { 
                                            detailed_url => "$db_detailed_url/$rec{'ID'}$build_extension",                                          
                                            %rec,
                                            %globals
                                    });
}

sub site_html_home {
# --------------------------------------------------------
# This routine will build a home page. It is not meant to have any 
# links on it, only subcategories.

    return &load_template ('home.html', { 
                                      category => $category, 
                                      grand_total => $grand_total,
                                      %globals
                            });
}

sub site_html_new {
# --------------------------------------------------------
# This routine will build a what's new page. 

    return &load_template ('new.html', {
                                        total => $total,
                                        grand_total => $grand_total,
                                        link_results => $link_results,
                                        title_linked => $title_linked,
                                        %globals
                                    } );
}

sub site_html_cool {
# --------------------------------------------------------
# This routine will build a what's new page. 

    return &load_template ('cool.html', {
                                        total => $total,
                                        grand_total => $grand_total,
                                        percent => $percent,
                                        link_results => $link_results,
                                        title_linked => $title_linked,
                                        %globals
                                    } );
}

sub site_html_detailed {
# --------------------------------------------------------
# This routine will build a single page per link. It's only
# really useful if you have a long review for each link --
# or more information then can be displayed in a summary.
#
    my %rec = @_;
    return &load_template ('detailed.html', {
                                        total => $total,
                                        grand_total => $grand_total,
                                        title_linked => $title_linked,
                                        %rec,
                                        %globals
                                    } );
}

sub site_html_category {
# --------------------------------------------------------
# This rountine will build a page based for the current category.

    return &load_template ( 'category.html', {
                                        date => $date,
                                        time => $time,
                                        category => $category,
                                        links => $links,
                                        title_linked => $title_linked,
                                        title => $title,
                                        total => $total,
                                        grand_total => $grand_total,
                                        category_name => $category_name,
                                        category_name_escaped => $category_name_escaped,
                                        category_clean => $category_clean,
                                        description => $description,
                                        meta_name => $meta_name,
                                        meta_keywords => $meta_keywords,
                                        header => $header,
                                        footer => $footer,
                                        prev => $prev,
                                        next => $next,
                                        related => $related,
                                        build_links_per_page => $build_links_per_page,
                                        %globals
                                    } );
}

sub site_html_ratings {
# --------------------------------------------------------
# This routine determines how the top rated page will look like.

    return &load_template ( 'rate_top.html', {
                                                top_rated => $top_rated,
                                                top_votes => $top_votes,
                                                %globals
                                            });
}

########################################################################################
# THE FOLLOWING ARE CGI GENERATED PAGES AND THE TEMPLATE MUST BE PRINTED, NOT RETURNED!#
########################################################################################

sub site_html_add_form {
# --------------------------------------------------------
# This routine determines how the add form page will look like. 
#
    &html_print_headers;

    my $category = shift;
    $category ?
        ($category = qq~$category <input type=hidden name="Category" value="$category">~) :
        ($category = &build_select_field ("Category", "$in{'Category'}"));
    
    print &load_template ('add.html', { 
                                        Category => $category,
                                        %globals
                                    });
}

sub site_html_add_success {
# --------------------------------------------------------
# This routine determines how the add success page will look like. 

    &html_print_headers;

    print &load_template ('add_success.html', { 
                                        %in,
                                        %globals
                                    });
}

sub site_html_add_failure {
# --------------------------------------------------------
# This routine determines how the add failure page will look like. 

    my ($errormsg) = shift;
    $in{'Category'} ? 
        ($in{'Category'} = qq~<input type=hidden name="Category" value="$in{'Category'}">$in{'Category'}~) :
        ($in{'Category'} = &build_select_field ("Category"));
    
    &html_print_headers;    
    print &load_template ('add_error.html', { 
                                        error => $errormsg,
                                        %in,
                                        %globals
                                    });

}

sub site_html_modify_form {
# --------------------------------------------------------
# This routine determines how the modify form page will look like. 

    my $category = &build_select_field ("Category", "$in{'Category'}");    

    &html_print_headers;
    print &load_template ('modify.html', { 
                                        Category => $category,
                                        %globals
                                    });
}    

sub site_html_modify_success {
# --------------------------------------------------------
# This routine determines how the modify success page will look like. 

    &html_print_headers;
    print &load_template ('modify_success.html', {
                                        %in,
                                        %globals
                                });
}

sub site_html_modify_failure {
# --------------------------------------------------------
# This routine determines how the modify failure page will look like. 

    my $errormsg    = shift;
    $in{'Category'} = &build_select_field ("Category", $in{'Category'}); 

    &html_print_headers;
    print &load_template ('modify_error.html', {
                                        error => $errormsg,
                                        %in,
                                        %globals
                                });
}

sub site_html_search_results {
# --------------------------------------------------------
# This routine displays the search results.
# 
    my $term    = &urlencode ($in{'query'});
    &html_print_headers;
    print &load_template ('search_results.html', {
                                        term => $term,
                                        link_results => $link_results,
                                        category_results => $category_results,
                                        next => $next,
                                        cat_hits => $cat_hits,
                                        link_hits => $link_hits,
                                        %in,
                                        %globals
                                    });
}

sub site_html_search_failure {
# --------------------------------------------------------
# This routine displays a failed search page with error in $error.
#
    my $error = shift;
    my $term    = &urlencode ($in{'query'});
    &html_print_headers;

    print &load_template ('search_error.html', {
                                        term => $term,
                                        error => $error,
                                        %in,
                                        %globals
                                    });
}    

sub site_html_search_form {
# --------------------------------------------------------
# This routine displays the search form.

    &html_print_headers;
    print &load_template ('search.html', {
                                        term => $term,
                                        error => $error,
                                        %in,
                                        %globals
                                    });
}

sub site_html_mailing {
# --------------------------------------------------------
# This routine displays your mailing list subscribe/unsubscribe form.
#
    my $action = shift;
    my $message;
    ($action eq 'subscribe')   and ($message = qq~You've been successfully subscribed to the mailing list!~);
    ($action eq 'unsubscribe') and ($message = qq~You've been successfully removed from the mailing list!~);

    &html_print_headers;
    print &load_template ('email.html', {
                                        message => $message,
                                        %in,
                                        %globals
                                    });
}

sub site_html_mailing_error {
# --------------------------------------------------------
# This routine is displayed if there was a problem subscribing.
#
    my $error = shift;

    &html_print_headers();
    print &load_template ('email_error.html', {
                                        error => $error,
                                        %in,
                                        %globals
                                    });
}

sub site_html_rate_form {
# --------------------------------------------------------
# This routine determines how the rate form page will look like. 
#
    my %rec = @_;
    
    &html_print_headers;
    print &load_template ('rate.html', { 
                                        %rec,
                                        %globals
                                    });
}

sub site_html_rate_success {
# --------------------------------------------------------
# This routine determines how the rate success page will look like. 

    &html_print_headers;
    print &load_template ('rate_success.html', { 
                                        %in,
                                        %globals
                                    });
}

sub site_html_rate_failure {
# --------------------------------------------------------
# This routine determines how the rate failure page will look like. 

    my ($errormsg) = shift;

    &html_print_headers;    
    print &load_template ('rate_error.html', { 
                                        error => $errormsg,
                                        %in,
                                        %globals
                                    });

}

########################################################################################
# THE FOLLOWING DETERMINES YOUR CATEGORY LISTING, IT'S NOT TEMPLATE BASED (YET)!       #
########################################################################################

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
    $output = qq|<div class="margin"><table width="80%" border="0" cellspacing="0" cellpadding="0"><tr><td class="catlist" valign="top">\n|;
    
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
            $output .= qq|</td><td class="catlist" valign="top">\n|;
        }
        $i++;
        
# Then we print out the name linked, new if it's new, and popular if its popular.
        $output .= qq|<dl><dt><strong><a class="link" href="$url">$category_name</a></strong> <small class="numlinks">($numlinks)</small> |;
        $output .= qq|<small><sup class="new">new</sup></small>| if (&days_old($mod) < $db_new_cutoff);
        $output .= qq|</dt>|;
        $output .= qq|<dd><span class="descript">$description </span></dd>| if (!($description =~ /^[\s\n]*$/));
        $output .= qq|</dl>|;        
    }

# Don't forget to end the unordered list..
    $output .= "</td></tr></table></div>\n";
    return $output;
}

1;