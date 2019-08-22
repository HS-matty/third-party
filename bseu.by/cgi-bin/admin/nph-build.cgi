#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#        File: nph-build.cgi
#  Description: Builds a set of HTML pages from the template directory. This is a
#              non parsed header script, and should display the output directly as it may
#              take quite a while to perform. It can also be called from the
#              command line or via a cron routine. Read the README for more details.
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
eval {
    ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");    # Get the script location: UNIX /
    ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");    # Get the script location: Windows \

    require "links.cfg";                # Change this to full path to links.cfg if you have problems.
    require "$db_lib_path/db_utils.pl";
    require "$db_lib_path/links.def";
    $build_use_templates ?
        require "$db_lib_path/site_html_templates.pl" :
        require "$db_lib_path/site_html.pl";    
    use vars qw(%category %subcategories @links @new_links @cool_links %stats $grand_total $use_html $nph $date $time);
};
if ($@) {
    print "HTTP/1.0 200 OK\n";
    print "Content-type: text/plain\n\n";
    print "Error including libraries: $@\n";
    print "Make sure they exist, permissions are set properly, and paths are set correctly.";
    exit;
}
# ========================================================

eval    { &main; };                      # Trap any fatal errors so the program hopefully 
if ($@) { &cgierr("fatal error: $@"); }  # never produces that nasty 500 server error page.
exit;   # There are only two exit calls in the script, here and in in &cgierr. 

sub main {
# --------------------------------------------------------  
#
    $|++;       
    
    $use_html = 0;
    $ENV{'REQUEST_METHOD'} and $use_html++;
    
    $use_html and (%in = &parse_form);

# Either build the whole directory, parts of it, or just the new/popular section.   
    if ($use_html) {
        if    ($in{'staggered'}) { &build_staggered; }
        else                     { &build_all; }
    }
    else { &build_all; }
}

sub build_staggered {
# --------------------------------------------------------  
# Builds the directory in steps.
#
    my %in = &parse_form;
    
    $nph++;
    &html_print_headers() if ($use_html);
    my %steps  = ( 1 => 'Updating New and Popular Records and rebuilding URL database',
                   2 => 'Rebuilding Category Pages',
                   3 => 'Building Detailed View Pages',
                   4 => 'Updating Home/New/Cool Pages'
                  );
    my $step   = $in{'step'}   || 1;
    my $limit  = $in{'limit'}  || 20;
    my $offset = $in{'offset'} || 0;
    my $auto   = $in{'auto'}   || 0;
    my $start  = time();
    my $date   = &get_date;
    my $time   = &get_time;
    
    my $header = qq~
<html>
<head>
<title>Rebuilding Directory -- Phase $phase</title>
    ~;
    
    my $sub_head = qq~
</head>

<body bgcolor=#FFFFFF>
<H2><TT>Building Pages</TT></H2>
<P><em>Step: $steps{$step}</em>
<PRE>
Pages built on $date at $time
--------------------------------------------------------

~;
    CASE: {
    
        ($step == 1) and do { 
                print $header;
                print qq~<meta http-equiv="Refresh" content="2; URL=nph-build.cgi?staggered=1&step=2&auto=$auto">~ if ($auto);
                print $sub_head;
                
                my $t1 = time();
                print "Backing up database . . .\n";
                    &build_backup;
                print "Done (", time - $t1, " s)\n\n";
                
                $t1 = time();
                print "Building URL Index . . .\n";
                    &build_url_index;
                print "Done (", time - $t1, " s)\n\n";

                print "Updating New and Popular Records . . .\n";
                $t1 = time();
                    &build_update_newpop;
                print "Done (", time - $t1, " s)\n\n";

                print "Updating ratings .. \n";
                    $t1 = time();
                    &build_update_ratings;
                print "Done (", time - $t1, " s)\n\n";

                my $elapsed = time() - $start;
                print "------------------------------------------------\n";
                print "Step 1 took $elapsed seconds.\n\n";
                print qq~</PRE><P><B><font face="Verdana" size=2><a href="nph-build.cgi?staggered=1&step=2&auto=$auto">On to Step 2</A></B></FONT></P>~;
                last CASE; 
            };
            
        ($step == 2) and do { 
                my @category_list = &category_list; my $i;
                print $header;
                if ($auto) {
                    ($offset > $#category_list) ?
                        (print qq~<meta http-equiv="Refresh" content="0; URL=nph-build.cgi?staggered=1&step=3&auto=$auto">~) :
                        (print qq~<meta http-equiv="Refresh" content="2; URL=nph-build.cgi?staggered=1&step=2&limit=$limit&offset=~, $offset + $limit, qq~&auto=$auto">~);
                }
                print $sub_head;                
                
                print "Rebuilding Categories $offset -> ", $offset + $limit - 1, ".\n\n";
                for ($i = $offset; $i <= $offset + $limit -1; $i++) {
                    last unless ($category_list[$i] =~ /\w+/);
                    %category      = ();
                    %subcategories = ();
                    @links         = ();
                    @new_links     = ();
                    @cool_links    = ();
                    %stats         = ();
                    $grand_total   = 0;
                    my $t1 = time();

                    print "** Building Category: $category_list[$i] ... \n";
                    &build_single_category ($category_list[$i]);
                    print "** Done (", time - $t1, " s)!\n\n";
                }       
                $offset = $offset + $limit; 
                
                my $elapsed = time() - $start;
                print "------------------------------------------------\n";
                print "This phase of step 2 took $elapsed seconds.\n\n";
                ($offset > $#categories) ?
                    print qq~</PRE><P><B><font face="Verdana" size=2><a href="nph-build.cgi?staggered=1&step=3">Go on to Step 3!</A></B></FONT></P>~ :
                    print qq~</PRE><P><B><font face="Verdana" size=2><a href="nph-build.cgi?staggered=1&step=2&limit=$limit&offset=$offset&auto=$auto">Next $limit Categories!</A></B></FONT></P>~;
                last CASE; 
            };

        ($step == 3) and do {
                print $header;
                print qq~<meta http-equiv="Refresh" content="2; URL=nph-build.cgi?staggered=1&step=4&auto=$auto">~ if ($auto);
                print $sub_head;

                if ($build_detailed) {
                    my $t1 = time();                
                    print "Generating detailed view pages . . . \n";
                    &build_detailed_view;
                    print "** Done (", time - $t1, " s)!\n";
                }
                else {
                    print "Detailed Building is not turned on -- Skipping!\n\n";
                }
                my $elapsed = time() - $start;

                print "------------------------------------------------\n";
                print "Step 3 took $elapsed seconds.\n\n";
                print qq~</PRE><P><B><font face="Verdana" size=2><a href="nph-build.cgi?staggered=1&step=4&auto=1">Go on to Step 4!</A></B></FONT></P>~;
                last CASE;
            };

        ($step == 4) and do {
                print $header, $sub_head;               

                my $t1 = time();
                print "** Loading Category information . . .\n";
                    &build_category_information;
                print "** Done (", time - $t1, " s)!\n\n";

                $t1 = time();
                print "** Loading Summary information . . .\n";
                    &build_stats (1);
                print "** Done (", time - $t1, " s)!\n\n";

                $t1 = time();
                print "** Creating Home Page . . .\n";
                    &build_home_page;
                print "** Done (", time - $t1, " s)!\n\n";

                $t1 = time();
                print "** Creating What's New Pages . . .\n";
                    &build_new_page;
                print "** Done (", time - $t1, " s)!\n\n";

                $t1 = time();
                print "** Creating What's Cool Page. . .\n";
                    &build_cool_page;
                print "** Done (", time - $t1, " s)!\n\n";

                $t1 = time();
                print "** Creating Top Rated Page. . .\n";
                    &build_rate_page;
                print "** Done (", time - $t1, " s)!\n\n";
                
                my $elapsed = time() - $start;
                print "------------------------------------------------\n";
                print qq~Step 4 took $elapsed seconds.\n\n<b><a href="$build_root_url" target="_top">Your site</a> is now up to date!</b>~;
                last CASE;
            };

        &cgierr("Unkown step: $step.");
    };
}

sub build_all {
# --------------------------------------------------------  
# Rebuild the entire directory.

# Determine if we are printing to command line, or to browser.
    $nph++;
    &html_print_headers() if ($use_html);
    
    my $start = time();
    my $date   = &get_date;
    my $time   = &get_time;
    
# Print HTML Header
    $use_html ?
        print qq|<html><head><tittle>Links Manager: Building Pages</title></head>
                 <BASE TARGET="_top">
                 <BODY BGCOLOR=#FFFFFF><H2><TT>Building Pages</TT></H2>
                 <PRE>| :
        print qq|Building Pages\n|;
    print "Pages built on " . $date . " at " . $time . "\n";
    print "--------------------------------------------------------\n\n";

# Backup the database.
    print "Backing up database . . .\n";
    &build_backup;
    print "Done.\n\n";

# Rebuild URL Index (This file is auto-generated, you will never need to touch it!  
    print "Building URL Index . . .\n";
    &build_url_index;
    print "Done.\n\n";

# Update New and Popular Records..
    print "Updating New and Popular Records . . .\n";
    &build_update_newpop;
    print "Done.\n\n";

# Update voting information .. 
    print "Updating ratings .. \n";
    &build_update_ratings;
    print "Done.\n\n";

# Load Category Information
    print "Loading Category Information . . .\n";
    &build_category_information;
    print "Done.\n\n";
    
# Generate some stats for future pages...   
    print "Gathering Category and Link information . . .\n";
    &build_stats;
    print "Done\n\n";

# Generate detailed view pages.
    if ($build_detailed) {
        print "Generating detailed view pages . . . \n";
        &build_detailed_view;
        print "Done\n\n";
    }
    
# Create Home Page
    $use_html ?
        print qq|Building <A HREF="$build_root_url/$build_index">Home Pages</A> . . .\n| :
        print qq|Building Home Page . . .\n|;
    &build_home_page;
    print "\tDone\n\n";
    
# Create What's New Page    
    $use_html ?
        print "Building <A HREF=\"$build_new_url/$build_index\">What's New</A> Page . . .\n" :
        print "Building What's New Page . . .\n";
    &build_new_page;
    print "Done\n\n";

# Create What's Cool Page
    $use_html ?
        print "Building <A HREF=\"$build_cool_url/$build_index\">What's Cool</A> Page . . .\n" :
        print "Building What's Cool Page . . .\n";
    &build_cool_page;
    print "Done\n\n";

# Create Top Rated Page
    $use_html ?
        print "Building <A HREF=\"$build_ratings_url/$build_index\">Top Rated</A> Page . . .\n" :
        print "Building Top Rated . . .\n";
    &build_rate_page;
    print "Done\n\n";
        
# Create Category Pages
    print "Building Category Pages . . .\n";
    &build_category_pages;
    print "Done\n\n";
    
# We are finished!  
    print "Pages Built (", time() - $start, " s)!";
    print "</PRE></BODY></HTML>" if ($use_html);
}

sub build_backup {
# --------------------------------------------------------
# Backs up important database files.
#
    my $date = &get_date;
    if (-e "$db_script_path/backup/$date.links.db") {
        print "\tBackup exists for today.. Skipping\n";
        return;
    }
    
# Try to do it the right way..  
    eval { require File::Copy; };
    if (!$@) {
        print "\tBacking up links, category and email database (File::Copy) ... \n";
        &File::Copy::copy ("$db_script_path/data/links.db", "$db_script_path/backup/$date.links.db") or &cgierr ("Unable to copy links backup. Reason: $!");
        &File::Copy::copy ("$db_script_path/data/categories.db", "$db_script_path/backup/$date.category.db") or &cgierr ("Unable to copy category backup. Reason: $!");
        &File::Copy::copy ("$db_script_path/data/email.db", "$db_script_path/backup/$date.email.db") or &cgierr ("Unable to copy email backup. Reason: $!");
    }
# Otherwise, the ugly way.  
    else {
        print "\tBacking up links, category and email database (Regular - $@) ... \n";
        foreach (qw!links categories email!) {
            open (TMP, "$db_script_path/data/$_.db") or &cgierr ("Unable to open $db_script_path/data/$_.db. Reason: $!");
            open (TMPOUT, ">$db_script_path/backup/$date.$_.db") or &cgierr ("Unable to open $db_script_path/$date.$_.db. Reason: $!");
            while (<TMP>) {
                print TMPOUT;
            }
            close TMP;
            close TMPOUT;
        }
    }
}

sub build_url_index {
# --------------------------------------------------------
# This routine builds a quick URL lookup database so the script
# does not have to search the links.db for every hit.

    my $time   = time();
    my @values = ();
    my $count  = 0;
    
    open (DB,  "<$db_file_name") or &cgierr("unable to open database: $db_file_name.\nReason: $!");
    open (URL, ">$db_url_name")  or &cgierr("unable to open url index: $db_url_name. Reason: $!");
    if ($db_use_flock) { flock (URL, 2) or &cgierr ("unable to get exclusive lock. Reason: $!"); }
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;                          # Remove trailing new line.
        @values = &split_decode($_);
        print URL "$values[$db_key_pos]$db_delim$values[$db_url]\n";
        $count++;
    }
    close DB;
    close URL;

# Build the count file used to do random links.
    open (CNT, ">$db_hits_path/index.count") or &cgierr("unable to open count file: '$db_hits_path/index.count'. Reason: $!");
    if ($db_use_flock) { flock (CNT, 2) or &cgierr ("unable to get exclusive lock on $db_hits_path/index.count. Reason: $!"); }
    print CNT $count;
    close CNT;
}   

sub build_update_ratings {
# --------------------------------------------------------
# Updates the ratings of each link.
#

# Let's collect the ratings.
    my ($id, %rating, %votes, @values, $input);
    opendir (HITS, $db_rates_path)       or &cgierr ("unable to open ratings directory: $db_rates_path. Reason: $!");
    while (defined ($id = readdir HITS)) {
        next unless ($id =~ /^\d+$/);
        open (HIT, "$db_rates_path/$id") or &cgierr ("unable to open rating counter: $db_rates_path/$id. Reason: $!");
        my $input = <HIT>;
        chomp $input;
        ($votes{$id}, $rating{$id}) = split /\s/, $input;
        close HIT;
    }
    closedir HITS;

# Update the links database.
    open (DB,    "$db_links_name")      or &cgierr ("unable to open links database: $db_links_name. Reason: $!");
    open (DBTMP, ">$db_links_name.bak") or &cgierr ("unable to open temp links database: $db_links_name.bak. Reason: $!");
    LINE: while (<DB>) {
        /^#/      and print OUT and next LINE;      # Skip comment Lines.
        /^\s*$/   and next LINE;                    # Skip blank lines.
        chomp;                                      # Remove trailing new line.
        @values = split /\Q$db_delim\E/;
        $id     = $values[0];
            
        if (exists $votes{$id}) {               
            $values[$db_rating] = (($values[$db_rating] * $values[$db_votes]) + $rating{$id}) /
                                       ($values[$db_votes] + $votes{$id});
            $values[$db_rating] = sprintf ("%.2f", $values[$db_rating]);
            $values[$db_votes]  = $values[$db_votes] + $votes{$id}; 
            print "\tUpdating rating to $values[$db_rating] for link id $id\n";                
        }
        print DBTMP &join_encode(&array_to_hash(0, @values));         
    }
    close DB;
    close DBTMP;
    
    if (-s "$db_links_name.bak" > 0) {
        if (! rename ("$db_links_name.bak", $db_links_name)) {
            print "\tCouldn't rename! Had to copy. Strange: $!\n";
            open (DBTMP, ">$db_links_name")    or &cgierr ("unable to open links database: $db_links_name. Reason: $!");
            open (DB,    "$db_links_name.bak") or &cgierr ("unable to open temp links database: $db_links_name.bak. Reason: $!");
            while (<DB>) { print DBTMP; }
            close DB;
            close DBTMP;
        }
    }
    else {
        &cgierr ("Error building! Links database is 0 bytes!");
    }

# Delete the ratings.
    foreach (keys %votes) {
        unlink ("$db_rates_path/$_") or &cgierr ("unable to remove rating: $db_rates_path/$_. Reason: $!");
    }
}

sub build_update_newpop {
# --------------------------------------------------------
# This routines updates the database, and marks new records new,
# old records old, popular records popular, and unpopular records,
# unpopular.

    my ($id, %hits, @values, $days, @popular, $cutoff);

# Let's collect how many hits we've gotten.
    opendir (HITS, $db_hits_path)       or &cgierr ("unable to open hits directory: $db_hits_path. Reason: $!");
    while (defined ($id = readdir HITS)) {
        next unless ($id =~ /^\d+$/);
        open (HIT, "$db_hits_path/$id") or &cgierr ("unable to open hit counter: $db_hits_path/$id. Reason: $!");
        $hits{$id} = int <HIT>;
        close HIT;
    }
    closedir HITS;

# Now go through the links database and update new links, and 
# add the hits.
    open (DB,  "<$db_file_name") or &cgierr("unable to open database: $db_file_name.\nReason: $!");
    if ($db_use_flock) { flock(DB, 1); }    
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;                          # Remove trailing new line.
        @values = &split_decode($_);
        $values[$db_modified] or print "Warning: No date for line: $_. Skipping..\n" and next LINE;

# Calculate days old and then mark new.
        $days = &days_old($values[$db_modified], $date);
        ($days <= $db_new_cutoff) and ($new_records{$values[$db_key_pos]}++);

# Build an array of popular hits.
        exists $hits{$id} ?
            push (@popular, $values[$db_hits] + $hits{$id}) :
            push (@popular, $values[$db_hits]);
    }
    close DB;

# Sort the popular list, and set the cutoff mark.
    @popular = sort { $b <=> $a } @popular;
    ($db_popular_cutoff < 1) ?
        ($cutoff  = $popular[int($db_popular_cutoff * $#popular)]) :
        ($cutoff  = $popular[$db_popular_cutoff - 1]);
    ($cutoff < 2) and ($cutoff = 2);

# Display our cutoffs.
    print "\tWhat's New Cutoff: $db_new_cutoff days\n";
    print "\tPopular Cutoff: $cutoff hits\n";

# Now update the New and Cool tags on the links.
    open (DB, "$db_links_name") or &cgierr ("unable to open links database: $db_links_name. Reason: $!");
    open (DBTMP, ">$db_links_name.bak") or &cgierr ("unable to open temp links database: $db_links_name.bak. Reason: $!");
    LINE: while (<DB>) {
        /^#/      and print OUT and next LINE;      # Skip comment Lines.
        /^\s*$/   and next LINE;                    # Skip blank lines.
        chomp;                                      # Remove trailing new line.
        @values = split /\Q$db_delim\E/;
        $id     = $values[0];

# Store the new number of hits.     
        exists $hits{$id} and ($values[$db_hits] = $values[$db_hits] + $hits{$id});

# Check to see if the record is popular...   
        if ($values[$db_hits] >= $cutoff) {
            print "\tUpdating record: $id, marking as popular ($values[$db_hits]).\n";
            $values[$db_ispop] = "Yes";
        }
        else {
            $values[$db_ispop] = "No";
        }

# Check to see if the record is new...    
        if ($new_records{$id}) {
            print "\tUpdating record: $id, marking as new.\n";   
            $values[$db_isnew] = "Yes";
        }
        else {
            $values[$db_isnew] = "No";
        }       
        print DBTMP &join_encode (&array_to_hash(0, @values));
    }
    close DB;
    close DBTMP;

    if (-s "$db_links_name.bak" > 0) {
        if (! rename ("$db_links_name.bak", $db_links_name)) {
            print "\tCouldn't rename! Had to copy. Strange: $!\n";
            open (DBTMP, ">$db_links_name") or &cgierr ("unable to open links database: $db_links_name. Reason: $!");
            open (DB, "$db_links_name.bak") or &cgierr ("unable to open temp links database: $db_links_name.bak. Reason: $!");
            while (<DB>) { print DBTMP; }
            close DB;
            close DBTMP;            
        }
    }
    else {
        &cgierr ("Error building! Links database is 0 bytes!");
    }
    
# Finally, clean out the hits directory.
    foreach (keys %hits) {
        next unless /^\d+$/;
        unlink ("$db_hits_path/$_") or &cgierr ("Can't remove hit file: '$db_hits_path/$_'. Reason: $!");
    }
}

sub build_category_information {
# --------------------------------------------------------
# This routine loads the category information into memory and
# does some grouping.

    my ($name, @values, @base, $base,);
    
    open (DB, "<$db_category_name") or &cgierr("unable to open database: $db_category_name. Reason: $!");
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;  
        @values = &split_decode ($_);       
        $name   = $values[$db_main_category];

# We store the category information in a globally accessable hash %category, indexed by category name.
        @{$category{$name}} = @values;
        
# We also initilize the days_old variable to Jan 1. 1990 so that if
# this category doesn't have any links, we still have a valid date
# for it.
        $stats{$name}[1] = "1-Jan-1990";
        $stats{$name}[0] = 0;

# We now figure out if this category is a subcategory of something,
# and if so, store it in the hash of arrays %subcategories.
        (@base) = split (/\//, $name);
        pop @base; $base = join ("/", @base);
        if ($base) {
            push (@{$subcategories{$base}}, $name);
        }
    }
    close DB;
}

sub build_stats {
# --------------------------------------------------------
# This routine does a lot of the messy work. It builds globally accessible
# arrays of new_links and cool_links. It finds out how many links are in each
# category, and whether a category contains a new/modified link.

    my (@values, $category, $cat, @alt_categories, @categorylist, $depth, $i, $cat);
    my $staggered_mode = shift || undef;

    open (DB, "<$db_file_name") or &cgierr("unable to open database: $db_file_name. Reason: $!");
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;  
        @values   = &split_decode ($_);     
        $category = $values[$db_category];
        
# Add the link to the list of links.        
        push (@{$links{$category}}, @values) if (!$staggered_mode);
        $grand_total++;

# Add the link to the alternate categories as well.
        if (defined $db_alt) {
            @alt_categories = split(/\Q$db_delim\E/, $values[$db_alt]);
            foreach (@alt_categories) {
                push (@{$links{$_}}, @values);
            }
        }
        
# Add the link to the list of new links if it is new.
        push (@{$new_links{$category}}, @values) if ($values[$db_isnew] eq "Yes");

# Add the link to the list of cool links if it is popular.
        push (@{$cool_links{$category}}, @values) if ($values[$db_ispop] eq "Yes");

# This adds one to the total of each category above the current category.
# We have to caluclate the affect of the link on each alt category as well as the main.
        foreach $cat ($category, @alt_categories) {

# Calculate the stats: the number of links and the newest link.                  
            @categorylist = split (/\//, $cat);
            $depth = $#categorylist;                                

# This adds one to the total of each category above the current category,
# and also marks any above categories new, if this link is new.
            for $i (0 .. $depth) {
                $stats{$cat}[0]++;
                if ((!$stats{$cat}[1]) || &compare_dates($values[$db_modified], $stats{$cat}[1])) {
                    $stats{$cat}[1] = $values[$db_modified];
                }
                pop (@categorylist);
                $cat = join("/", @categorylist);
            }                   
        }
    }   
    close DB;
    
# Now we have to sort the links and categories..
    if (!$staggered_mode) {
        foreach $link ( keys %links ) {
            @{$links{$link}} = &build_sorthit (@{$links{$link}});
        }
        foreach $cat ( keys %subcategories ) {
            @{$subcategories{$cat}} = sort @{$subcategories{$cat}};
        }   
    }
    $grand_total ||= 0;
}   

sub build_detailed_view {
# --------------------------------------------------------
# This routine build a single page for every link.
#
    my (@values, $id, %rec, $count);
    if ($build_detail_path =~ m,^$build_root_path/(.*)$,) {
        &build_dir ($1);
    }
    print "\t"; 
    open (DB, "<$db_file_name") or &cgierr("unable to open database: $db_file_name. Reason: $!");
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;  
        @values   = &split_decode ($_);     
        $id       = $values[$db_key_pos];
        %rec      = &array_to_hash (0, @values);
        $title_linked = &build_linked_title ("$rec{'Category'}/$rec{'Title'}");
        open (DETAIL, ">$build_detail_path/$id$build_extension") or &cgierr ("Unable to build detail page: $build_detail_path/$id$build_extension. Reason: $!");
        print DETAIL &site_html_detailed (%rec);
        close DETAIL;       
        $use_html ? 
            print qq~<a href="$build_detail_url/$id$build_extension" target="_blank">$id</a> ~ :
            print qq~$id ~;
        (++$count % 10) or print "\n\t";
    }
    close DB;
    print "\n"; 
}

sub build_category_pages {
# --------------------------------------------------------
# This routine builds all the category pages. Each category uses
# the same template which is defined in &site_html_category.
	
	my $build_single = shift;

    my ($cat, $url, $dir, @related, $relation, $page_num, $next_page, $numlinks);
    local ($category, $links, $title_linked, $title, $total, $category_name, $category_name_escaped);
    local ($description, $related, $meta_name, $meta_keywords, $header, $footer, $next, $prev);

# Go through each category and build the appropriate page.  
    CATEGORY: foreach $cat (sort keys %category) {
        next CATEGORY if ($cat =~ /^\s*$/);     # How'd that get in here? =)
		next CATEGORY if ($build_single and ($build_single ne $cat));

        $url = "$build_root_url/" . &urlencode($cat) . "/";     
        $use_html ?
            print qq|Building Category: <A HREF="$url" TARGET="_blank">$cat</A>\n| :
            print qq|Building Category: $cat\n|;
        print "\tSubcategories: " . ($#{$subcategories{$cat}} + 1)         . "\n";
        print "\tLinks: "         . (($#{$links{$cat}}+1) / ($#db_cols+1)) . "\n";

# Let's make sure the directory exists, build it if it doesn't.
        $dir = &build_dir ($cat);
        print "\tDirectory: $dir\n";
        print "\tFilename : $dir/$build_index\n";

# We set up all the variables people can use in &site_html.pl.          
        ($description, $related, $meta_name, $meta_keywords, $header, $footer) = @{$category{$cat}}[2..7];

# Calculate the related entries and put in a <LI> list.
        @related = split(/\Q$db_delim\E/, $related); $related = "";
        foreach $relation (@related) {
            $related .= qq|<li><a href="$build_root_url/|;
            $related .= &urlencode($relation);
            $related .= qq|/$build_index">|;
            $related .= &build_clean($relation);
            $related .= "</a></li>";
        }

# Get the header and footer from file if it exists, otherwise assume it is html.
        if ($header && (length($header) < 20) && ($header !~ /\s+/) && (-e "$db_header_path/$header")) {
            open (HEAD, "<$db_header_path/$header") or &cgierr ("Unable to open header file: $db_header_path/$header. Reason: $!");
            $header = "";            
            while (<HEAD>) {
                $header .= $_;
            }
            close HEAD;
        }
        if ($footer && (length($footer) < 20) && ($footer !~ /\s+/) && (-e "$db_footer_path/$footer")) {
            open (FOOT, "<$db_footer_path/$footer") or &cgierr ("Unable to open footer file: $db_footer_path/$footer. Reason: $!");
            $footer = "";
            while (<FOOT>) {
                $footer .= $_;
            }
            close FOOT;
        }           
        $title_linked           = &build_linked_title ($cat);
        $title                  = &build_unlinked_title ($cat);
        $total                  = ($#{$links{$cat}} + 1) / ($#db_cols + 1);
        $category_name          = $cat;
        $category_name_escaped  = &urlencode ($cat);
        $category_clean         = &build_clean ($cat);

# Store all the category html info in $category.
        if ($#{$subcategories{$cat}} >= 0) {
            $category = &site_html_print_cat (@{$subcategories{$cat}});
        }
        else {
            $category = "";
        }

# If we are spanning pages, we grab the first x number of links and build
# the main index page. We set $numlinks to the remaining links, and we remove
# the links from the list.
        $numlinks = ($#{$links{$cat}} + 1) / ($#db_cols + 1);
        $next = $prev = $links = "";
        if (($numlinks > $build_links_per_page) && $build_span_pages) {
            $page_num = 2;
            $next  = $url . "more$page_num$build_extension";        
            for ($i = 0; $i < $build_links_per_page; $i++) {
                %tmp = &array_to_hash ($i, @{$links{$cat}});        
                $links .= &site_html_link (%tmp);
            }
            @{$links{$cat}} = @{$links{$cat}}[(($#db_cols+1)*$build_links_per_page) .. $#{$links{$cat}}];
            $numlinks = ($#{$links{$cat}}+1) / ($#db_cols + 1);
        }
# Otherwise we either only have less then x number of links, or we are not
# splitting pages, so let's just build them all.
        else {
            for ($i = 0; $i < $numlinks; $i++) {
                %tmp = &array_to_hash ($i, @{$links{$cat}});        
                $links .= &site_html_link (%tmp);
            }
        }

# Create the main page.
        open (CAT, ">$dir/$build_index") or &cgierr ("unable to open category page: $dir/$build_index. Reason: $!");
            print CAT &site_html_category;
        close CAT;

# Then we go through the list of links and build on the remaining pages.
        $prev = $url if ($build_span_pages);        
        while ($next && $build_span_pages) {
            if ($numlinks > $build_links_per_page) {
                $next_page = $page_num+1;
                $next = $url . "more$next_page$build_extension";
            }
            else {
                $next = "";
            }
            $links = "";
            LINK: for ($i = 0; $i < $build_links_per_page; $i++) {
                %tmp = &array_to_hash ($i, @{$links{$cat}});
                last LINK if ($tmp{$db_key} eq "");
                $links .= &site_html_link (%tmp);
            }
            $title_linked           = &build_linked_title   ("$cat/Page_$page_num/");
            $title                  = &build_unlinked_title ("$cat/Page_$page_num/");
            
            $use_html ?
                print qq|\tSubpage  : <A HREF="|, $url, qq|more$page_num$build_extension" TARGET="_blank">$dir/more$page_num$build_extension</A>\n| :
                print qq|\tSubpage  : $dir/more$page_num$build_extension\n|;
                
            open (CAT, ">$dir/more$page_num$build_extension") or &cgierr ("unable to open category page: $dir/index$page_num$build_extension. Reason: $!");
                print CAT &site_html_category;
            close CAT;

            @{$links{$cat}} = @{$links{$cat}}[(($#db_cols+1)*$build_links_per_page) .. $#{$links{$cat}}];
            $numlinks = ($#{$links{$cat}}+1) / ($#db_cols + 1);
            
            $prev = $url . "more$page_num$build_extension";
            $page_num++;            
        }           
        print "\n";
    }
}

sub build_single_category {
# --------------------------------------------------------
# Builds a single category.
#
    my $category = shift;

    my ($name, @values, @base, $base,);

# Get category information for this one category.   
    open (DB, "<$db_category_name") or &cgierr("unable to open database: $db_category_name. Reason: $!");
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;  
        @values = &split_decode ($_);       
        $name   = $values[$db_main_category];
        
        if ($name eq $category) {
            @{$category{$name}} = @values;
            $stats{$name}[1] = "1-Jan-1990";
            $stats{$name}[0] = 0;
        }
        elsif ($name =~ m,^$category/([^/]+)$,) {
            @{$category{$name}} = @values;
            push @{$subcategories{$category}}, $name;
            $stats{$name}[1] = "1-Jan-1990";
            $stats{$name}[0] = 0;
        }
        else {
            next;
        }
    }
    close DB;

# Gather link information for just this one category.
    open (DB,  "<$db_file_name") or &cgierr("unable to open database: $db_file_name.\nReason: $!");
    if ($db_use_flock) { flock(DB, 1); }    
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;                          # Remove trailing new line.
        @values   = &split_decode($_);
        $link_cat = $values[$db_category];  
        next unless ($link_cat =~ /^$category/);

# This link is either in the category, or in a subcategory.
        if ($link_cat =~ m,^$category/([^/]+)/*,) {         
            $stats{$link_cat}[0]++;
            if ((!$stats{$link_cat}[1]) || &compare_dates($values[$db_modified], $stats{$link_cat}[1])) {
                $stats{$link_cat}[1] = $values[$db_modified];
            }
        }
        elsif ($link_cat eq $category) {
            push (@{$links{$category}}, @values);
        }
        else {
            &cgierr ("Unkown Category: $link_cat.");
        }
    }
    close DB;

# Sort the links.
    foreach $link ( keys %links ) {
        @{$links{$link}} = &build_sorthit (@{$links{$link}});
    }
    foreach $cat ( keys %subcategories ) {
        @{$subcategories{$cat}} = sort @{$subcategories{$cat}};
    }   
    
# Now let's build the category page.
    &build_category_pages($category);    
}

sub build_home_page {
# --------------------------------------------------------
    my ($subcat, @rootcat);
    local ($total);
        
# Check to see which categories are off of the root.
    foreach $subcat (sort keys %category) {
        if ($subcat =~ m,^([^/]*)$,) {
            push (@rootcat, $subcat);
        }
    }
    print "\tSubcategories: "; print $#rootcat+1; print "\n"; 
    print "\tTotal Links: $grand_total\n";
    print "\tOpening page: $build_root_path/$build_index\n";
            
    open (HOME, ">$build_root_path/$build_index") or &cgierr ("unable to open home page: $build_root_path/$build_index. Reason: $!");
        $category   = &site_html_print_cat (@rootcat) if ($#rootcat >= 0);
        $total      = $grand_total;
        print HOME &site_html_home;
    close HOME;
    print "\tClosing page.\n";  
}

sub build_new_page {
# --------------------------------------------------------
# Creates a "What's New" page. Set $build_span_pages to 1 in links.cfg
# and it will create a seperate page for each date.
#
    my (%link_output, $category_clean, $long_date, $category, $date, 
        $number_links, $main_link_results, $main_total, %span_totals);
    local ($total, $link_results, $title_linked);  

# Let's build the What's New directory. 
    if ($build_new_path =~ m,^$build_root_path/(.*)$,) {
        &build_dir ($1);
    }
    
# Now we go through all the new_links (which are organized by category), and
# build the html in array indexed by date then category. 
    $total = 0; 
    CATEGORY: foreach $category (sort keys %new_links) {            
        LINK: for ($i = 0; $i < ($#{$new_links{$category}}+1) / ($#db_cols + 1); $i++) {
            $total++;
            %tmp = &array_to_hash ($i, @{$new_links{$category}});
            ${$link_output{$tmp{'Date'}}}{$category} .= &site_html_link (%tmp) . "\n";
            $span_totals{$tmp{'Date'}}++;
        }
    }
    
# Then we go through each date, and build the links for that date. If we are spanning
# pages, we will create a seperate page for each date and need to set up a few other 
# variables (like title and total). We will also want to reset links_results each time.
    DATE: foreach $date (sort { &date_to_unix($b) <=> &date_to_unix($a) } keys %link_output) {
        $long_date    = &long_date ($date);
        if ($build_span_pages) {        
            $link_results = "";         
            $total        = $span_totals{$date};
            $title_linked = &build_linked_title ("New/$date");
        }
        else {
            $link_results .= "<p><strong>$long_date</strong>\n<blockquote>";
        }
        CATEGORY: foreach $category (sort keys %{$link_output{$date}}) {
            $category_clean = &build_clean ($category);
            $link_results .= qq|<P><A HREF="$build_root_url/$category/$build_index">$category_clean</A>\n|;
            $link_results .= ${$link_output{$date}}{$category};
        }

# Crete the new page, and do a bit of HTML work for the main page.
        if ($build_span_pages) {
            open (NEW, ">$build_new_path/$date$build_extension") or cgierr ("unable to open what's new page: $build_new_path/$build_index. Reason: $!");
                $use_html ?
                    print qq|\tNew Links for <a href="$build_new_url/$date$build_extension" TARGET="_blank">$date</a>: $total\n| :
                    print qq|\tNew Links for $date: $total\n|;
                print NEW &site_html_new;
            close NEW;
            $main_link_results .= qq|<li><a href="$build_new_url/$date$build_extension">$long_date</a> ($total).|;
            $main_total += $total;
        }
        else {
            $link_results .= "</blockquote>";
        }
    }
    
    if ($build_span_pages) {
        $link_results = "<ul>$main_link_results</ul>";      
        $total = $main_total;
    }
    $title_linked = &build_linked_title ("New");

# Build the main What's New page.
    open (NEW, ">$build_new_path/$build_index") or cgierr ("unable to open what's new page: $build_new_path/$build_index. Reason: $!");
        print "\tTotal New Links: $total\n";
        print NEW &site_html_new(@new_links);
    close NEW;
}

sub build_cool_page {
# --------------------------------------------------------
# Creates a "What's Cool" page.

    local ($total, $percent, $link_results, $title_linked);
    my (%link_output, $category_clean);
    
    if ($build_cool_path =~ m,^$build_root_path/(.*)$,) {
        &build_dir ($1);
    }
    
    $total = 0;
    CATEGORY: foreach $category (sort keys %cool_links) {          
        LINK: for ($i = 0; $i < ($#{$cool_links{$category}}+1) / ($#db_cols + 1); $i++) {
            $total++;
            %tmp = &array_to_hash ($i, @{$cool_links{$category}});
            $link_output{$category} .= &site_html_link (%tmp) . "\n";
        }
    }
    foreach $category (sort keys %cool_links) {
        $category_clean = &build_clean ($category);
        $link_results .= qq|<P><A HREF="$build_root_url/$category/$build_index">$category_clean</A>\n|;
        $link_results .= $link_output{$category};
    }
    $title_linked = &build_linked_title ("Cool");
    open (COOL, ">$build_cool_path/$build_index") or cgierr ("unable to open what's cool page: $build_cool_path/$build_index. Reason: $!");
        print "\tCool Links: $total\n";
        ($db_popular_cutoff < 1) ?
            ($percent = $db_popular_cutoff * 100 . "%") :
            ($percent = $db_popular_cutoff);
        print COOL &site_html_cool(@cool_links);
    close COOL;
}

sub build_rate_page {
# --------------------------------------------------------
# Creates a Top 10 ratings page.

    my (@values, $id, $votes, $rate, @top_votes, %top_votes, @top_rate, %top_rate); 
    local ($top_rated, $top_votes);
    
    if ($build_ratings_path =~ m,^$build_root_path/(.*)$,) {
        &build_dir ($1);
    }
    
    $total = 0;
    
    open (LINKS, $db_links_name) or &cgierr ("unable to open links database: $db_links_name. Reason: $!");
    LINE: while (<LINKS>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;  
        @values = &split_decode ($_);       
        $id     = $values[$db_key_pos];
        $votes  = $values[$db_votes];
        $rate   = $values[$db_rating];
        next if ($votes < 10);
        if (($#top_votes < 9) or ($votes > $top_votes[$#top_votes])) {
            push (@{$top_votes{$votes}}, @values);
            if ($#top_votes <= 10) {
                push (@top_votes, $votes);
                @top_votes = sort { $b <=> $a } @top_votes;
            }
            else {
                splice (@{$top_votes{$#top_votes}}, 0, $#db_cols);
                $#{$top_votes{$#top_votes}} or delete $top_votes{$#top_votes};
                delete $top_votes{$top_votes[$#top_votes]-$id};
                $top_votes[$#top_votes] = $votes;
                @top_votes = sort { $b <=> $a } @top_votes;
            }
        }
        if (($#top_rate < 9) or ($rate > $top_rate[$#top_rate])) {
            push (@{$top_rate{$rate}}, @values);
            if ($#top_rate <= 10) {
                push (@top_rate, $rate);
                @top_rate = sort { $b <=> $a } @top_rate;
            }
            else {
                splice (@{$top_rate{$#top_rate}}, 0, $#db_cols);
                $#{$top_rate{$#top_rate}} or delete $top_rate{$#top_rate};
                delete $top_rate{$top_rate[$#top_rate]-$id};
                $top_rate[$#top_rate] = $rate;
                @top_rate = sort { $b <=> $a } @top_rate;
            }
        }       
    }
    close LINKS;
    
    $top_rated = ''; $top_votes = '';
    
    foreach (sort { $b <=> $a } @top_votes) {
        $seen{$_}++;
        %link = &array_to_hash ($seen{$_} - 1, @{$top_votes{$_}});      
        $top_votes .= qq~<tr><td align=center>$link{'Rating'}</td><td align=center>$link{'Votes'}</td><td><a href="$link{'URL'}">$link{'Title'}</a></td></tr>\n~;
    }
    foreach (sort { $b <=> $a } @top_rate) {
        $seen{$_}++;
        %link = &array_to_hash ($seen{$_} - 1, @{$top_rate{$_}});
        $top_rated .= qq~<tr><td align=center>$link{'Rating'}</td><td align=center>$link{'Votes'}</td><td><a href="$link{'URL'}">$link{'Title'}</a></td></tr>\n~;
    }   
    open (RATE, ">$build_ratings_path/$build_index") or &cgierr ("unable to open top rated page: $build_ratings_path/$build_index. Reason: $!");
        print "\tVote Range: $top_votes[0] .. $top_votes[$#top_votes]\n";
        print "\tRate Range: $top_rate[0] .. $top_rate[$#top_rate]\n";
        print RATE &site_html_ratings;
    close RATE;
}

sub build_dir {
# --------------------------------------------------------
# Verifies that all neccessary directories have been created 
# before we create the category file. Takes as input, the category
# to verify, and returns the full directory path.

    my $input        = shift;
    my ($dir, $path) = '';
    my @dirs         = split /\//, $input;

    foreach $dir (@dirs) {
        $path .= "/$dir";
        &build_check_dir ($build_root_path, $path);
        if (! (-e "$build_root_path$path")) {
            print "\tMaking Directory ($build_dir_per): '$build_root_path$path' ...";
            if (mkdir ("$build_root_path$path", "$build_dir_per")) {;
                print "Made. CHMOD ($build_dir_per) ...";
                if (chmod ($build_dir_per, "$build_root_path$path")) {;
                    print "Done.";
                }
                else { print "CHMOD ($build_dir_per) failed! Reason: $!."; }
            }
            else { print "mkdir failed! Reason: $!."; }
            print "\n";
        }
    }
    return "$build_root_path$path";
}

sub build_linked_title {
# --------------------------------------------------------
# Returns a string of the current category broken up 
# by section, with each part linked to the respective section.

    my $input = shift;
    my (@dirs, $dir, $output, $path, $last);

    @dirs = split (/\//, $input);
    $last = &build_clean(pop @dirs);
    
    $output = qq| <A HREF="$build_root_url/">Top</A> :|;
    foreach $dir (@dirs) {
        $path .= "/$dir";
        $dir = &build_clean ($dir);
        $output .= qq| <A HREF="$build_root_url$path/">$dir</A> :|;
    }
    $output .= " $last";
    
    return $output;
}

sub build_unlinked_title {
# --------------------------------------------------------
# Returns a string of the current category broken up by section.
# Useful for printing in the title.

    my $input = shift;
    my (@dirs, $dir, $output);

    @dirs = split (/\//, $input);
    
    foreach $dir (@dirs) {
        $dir = &build_clean ($dir);
        $output .= " $dir:";
    }
    chop ($output);  
    return $output;
}

sub build_check_dir {
# --------------------------------------------------------
# Checks the directory before we create it to make sure there 
# are no funncy characters in it.

    my ($root, $dir) = @_;
    my $chrs = quotemeta ("/_-");
    
    if (! -e $root) {
        &cgierr ("Root directory: $root does not exist!");
    }
    if ($dir !~ m,^[\w\d$chrs]+$,) {
        &cgierr ("Invalid characters in category name: $dir. Must contain only letters, numbers, _, / and -.");
    }       
    return $input;
}

1;