#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: search.cgi
#  Description: Searches the database and produces a list of results. If no options are
#               given, the script will produce a search form found in site_html.pl.
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
#   Form Input: 
#       'type'  : can be either 'keyword' or 'phrase'. 
#       'bool'  : can be either 'and' or 'or'.
#       'mh'    : the maximum number of hits, can be either 10, 25, 50, 100.
#       'nh'    : the page hit we are on.
#
#   Setup:
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
    %in = &parse_form(); 

# Display the form if called with no input. 
    (keys %in <= 0) and &site_html_search_form() and return;

# Set maximum hits -- default to 25.
    local $maxhits = 25;
    if ($in{'mh'} && (($in{'mh'} == 10) || ($in{'mh'} == 25) || ($in{'mh'} == 50) || ($in{'mh'} = 100))) {
        $maxhits = $in{'mh'};
    }

# Set search type -- either phrase or keyword. Also build keyword list to search on.
    my @search_terms = ();
    ($in{'type'} eq 'phrase') ?
        (@search_terms = ($in{'query'})) :
        (@search_terms = split (/\s/, $in{'query'}));

# Set boolean connector and next hits page.
    my $bool = $in{'bool'} || 'and';
    my $nh   = $in{'nh'}   || 1;

# Store the search results here.        
    local (%link_results, @category_results);

# Do the actual search.
    my $status = &search (\@search_terms, $bool);
    if ($status ne "ok") { &site_html_search_failure ($status); return; }

# Return unless we have results.
    ((keys %link_results > 0) or ($#category_results >= 0)) or
        &site_html_search_failure ("no matching records") and return;

# The HTML used in the output is stored here.
    local ($cat_hits, $link_hits, $category_results, $link_results, $next);         

# Build the HTML for the category results and store it in "$category_results". Only build the html
# if we are on the first set of link results.
    foreach $category (@category_results) {
        if ($nh == 1) {
            $cat_clean         = &build_clean($category);
            $linked_title      = &build_linked_title ($category);
            $category_results .= qq|<li>$linked_title\n|;
        }
        $cat_hits++;
    }
    $cat_hits ||= 0;
    $lowrange  = ($nh-1) * $maxhits + 1;
    $highrange = $nh * $maxhits;

# Go through each category of links returned, and build the HTML. Store in hash %link_output.
    SETOFLINKS: foreach $setoflinks (sort keys %link_results) {
        my $hits = ($#{$link_results{$setoflinks}} + 1) / ($#db_cols+1);
        LINK: for ($i = 0; $i < $hits; $i++) {                  
            $link_hits++;
            if (($link_hits <= $highrange) && ($link_hits >= $lowrange)) {
                %tmp = &array_to_hash ($i, @{$link_results{$setoflinks}});                          
                $link_output{$setoflinks} .= &site_html_link (%tmp) . "\n";
            }                      
        }
    }
    
# Go through the hash just built, and build the complete link output. Store in $link_results.               
    foreach $setoflinks (sort keys %link_output) {
        $cat_clean = &build_clean ($setoflinks);
        $title_linked = &build_linked_title ($setoflinks);
        $link_results .= qq|<P>$title_linked\n|;
        $link_results .= $link_output{$setoflinks};
    }
# If we want to bold the search terms...
    if ($search_bold) {
        foreach $term (@search_terms) {
# This reg expression will do the trick, and doesn't bold things inside <> tags such as 
# URL's.
            $link_results     =~ s,(<[^>]+>)|(\Q$term\E),defined($1) ? $1 : "<STRONG>$2</STRONG>",gie;
            $category_results =~ s,(<[^>]+>)|(\Q$term\E),defined($1) ? $1 : "<STRONG>$2</STRONG>",gie;
        }
    }

# If we have to many hits, let's build the next toolbar, and return only the hits we want.
    my ($next_hit, $prev_hit, $next_url, $left, $right, $lower, $upper, $i);
    
    if ($link_hits > $maxhits) {

# Remove the nh= from the query string.     
        $next_url = $ENV{'QUERY_STRING'};
        $next_url =~ s/\&nh=\d+//;
        $next_hit = $nh + 1; $prev_hit = $nh - 1;

# Build the next hits toolbar. It seems really complicated as we have to do
# some number crunching to keep track of where we are on the toolbar, and so
# that the toolbar stays centred.       

# First, set how many pages we have on the left and the right.
        $left  = $nh; $right = int($numhits/$maxhits) - $nh;        
# Then work out what page number we can go above and below.     
        ($left > 7)  ? ($lower = $left - 7) : ($lower = 1);
        ($right > 7) ? ($upper = $nh + 7)   : ($upper = int($link_hits/$maxhits) + 1);
# Finally, adjust those page numbers if we are near an endpoint.        
        (7 - $nh >= 0) and ($upper = $upper + (8 - $nh));
        ($nh > ($link_hits/$maxhits - 7)) and ($lower = $lower - ($nh - int($link_hits/$maxhits - 7) - 1));
        $next = "";

# Then let's go through the pages and build the HTML.       
        ($nh > 1) and ($next .= qq~<a href="$build_search_url?$next_url&nh=$prev_hit">[<<]</a> ~);
        for ($i = 1; $i <= int($link_hits/$maxhits) + 1; $i++) {
            if ($i < $lower) { $next .= " ... "; $i = ($lower-1); next; }           
            if ($i > $upper) { $next .= " ... "; last; }
            ($i == $nh) ?
                ($next .= qq~$i ~) :
                ($next .= qq~<a href="$build_search_url?$next_url&nh=$i">$i</a> ~);
            (($i * $maxhits) >= $link_hits) and last;  # Special case if we hit exact.
        }
        $next .= qq~<a href="$build_search_url?$next_url&nh=$next_hit">[>>]</a> ~ unless ($nh == $i);
    }
# Print out the HTML results.                  
    &site_html_search_results;          
}

sub search {
# --------------------------------------------------------
# This routine does the actual search of the database.  
#
    my ($search_terms, $bool) = @_;
    my ($regexp, @values, $grand_total, $match, $andmatch, $field, $or_match, %seen, $link, $tmp);

# Save the reg expressions to avoid rebuilding.
    $or_match   = $bool ne 'and';  
    if ($or_match) {
        for (0 .. $#{$search_terms}) {
            next if (length ${$search_terms}[$_] < 2);  # Skip single letter words.
            $tmp .= "m/\Q${$search_terms}[$_]\E/io ||";
        }
    }
    else {
        for (0 .. $#{$search_terms}) {
            next if (length ${$search_terms}[$_] < 2);  # Skip single letter words.     
            $tmp .= "m/\Q${$search_terms}[$_]\E/io &&";
        }
    }
    chop ($tmp); chop ($tmp);

# We can also search by field names.
    my @field_search;
    for (0 .. $#db_cols) {
        exists $in{$db_cols[$_]} and (push (@field_search, $_));
    }
    if (!$tmp and !@field_search) { return ("Please enter one or more keywords."); }
    if ($tmp) { $regexp = eval "sub { $tmp }";  $@ and &cgierr ("Can't compile reg exp: $tmp! Reason: $@");}

# Go through the database.
    open (DB, "<$db_file_name") or &cgierr("error in search. unable to open database: $db_file_name. Reason: $!");
    flock (DB, 1) if ($db_use_flock);
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;                          # Remove trailing new line.
        @values = &split_decode($_);
        $grand_total++;

# Check to see if the link matches.        
        $match = 0; $andmatch = 1;
        if ($regexp) {
            FIELD: foreach $field (@search_fields) { 
                $_ = $values[$field];
                $or_match ?
                    ($match = $match || &{$regexp}) :
                    ($match = &{$regexp});
                last FIELD if ($match);
            }
        }

# Check to see if the link matches any database fields. Only exact matches
# here.
        if ($or_match || $match || !$regexp) {
            FIELD: foreach $field (@field_search) {
                if ($or_match) {
                    $match = $match || ($in{$db_cols[$field]} eq $values[$field]);
                    $match and last FIELD;
                }
                else {
                    $match = ($in{$db_cols[$field]} eq $values[$field]);
                    $match or last FIELD;
                }
            }
        }
        $andmatch = $andmatch && $match;

# If we have a hit, add it in!
        if (($or_match && $match) or $andmatch) {  
            push (@{$link_results{$values[$db_category]}}, @values);
            $numhits++;     # We have a match!      
        }       

# Check to see if the category matches.         
        if ($regexp and !$seen{$values[$db_category]}++) {
            $match=0; $andmatch = 1;
            $_ = $values[$db_category];
            $or_match ? 
                ($match = $match || &{$regexp}) :
                ($match = &{$regexp});
            $andmatch = $andmatch && $match;

            if (($or_match && $match) or $andmatch) {
                $numcat++;
                push (@category_results, $values[$db_category]);
            }       
        }
    }
    close DB;

# Word is too common, don't try and sort it, can cause problems.    
    if (($numhits > 50) and (($grand_total * 0.75) < $numhits)) {
        return "Search term is too common.";
    }

# Sort the results using build_sorthit found in db.pl.
    foreach $link ( keys %link_results ) {
        @{$link_results{$link}} = &build_sorthit (@{$link_results{$link}});
    }
    @category_results = sort @category_results;
    return "ok";
}

sub build_linked_title {
# --------------------------------------------------------
# A little different then the one found in nph-build.cgi as it also
# links up the last field as well.

    my ($input) = shift;

    my ($dir, $output, $path, $last);
    foreach $dir ((split m!/!, $input)) {
        $path   .= "/$dir";
        $dir     = &build_clean ($dir);
        $output .= qq|<A HREF="$build_root_url$path/">$dir</A>:|;
    }
    chop ($output);
    return $output;
}