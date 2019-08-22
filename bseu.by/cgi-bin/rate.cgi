#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#         File: rate.cgi
#  Description: Let's a user specify a 1-10 rating for a resource.
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
    
    if ($in{'rate'}) {
        &rate_it;
    }
    elsif ($in{$db_key} =~ /^\d+$/) {
        my (%rec) = &get_record ($in{$db_key});
        ($rec{$db_key} eq $in{$db_key}) ?
            &site_html_rate_form    (%rec) :
            &site_html_rate_failure ("Unkown Link ID: $in{$db_key}");
    }
    else {
        print "Location: $build_ratings_url/\n\n";
    }
}

sub rate_it {
# --------------------------------------------------------          
    my $id    = $in{$db_key};
    my $delim = quotemeta($db_delim);
    my $time  = time();
    my $rating = $in{'rate'};

# Make sure we have a valid rating. 
    unless (($rating =~ /^\d\d?/) and ($rating >= 1) and ($rating <= 10)) {
        &site_html_rate_failure ("Your rating '$rating' is invalid.");
        return;
    }
    
# Let's get the link information.
    my %rec = &get_record ($id);
    ($rec{$db_key} eq $id) or (&site_html_rate_failure ("Unable to find link with ID '$id'.") and return);

# Increase the rating.
    
    if (open (HIT, "<$db_rates_path/$id")) {        
        my $input = <HIT>; chomp $input;
        ($votes, $old_rating) = split /\s/, $input;     
        chomp ($old_time = <HIT>);
        chomp (@IP       = <HIT>);
        (($time - $old_time) > 21600) and (@IP = ());
        foreach $ip (@IP) {         
            $ip eq $ENV{'REMOTE_ADDR'} and ($visited++ and last);
        }
        close HIT;

        if (!$visited) {
            push (@IP, $ENV{'REMOTE_ADDR'});
            $votes  = $votes + 1;
            $rating = $rating + $old_rating;
            open (HIT, ">$db_rates_path/$id")   or &cgierr ("Can't open for output counter file. Reason: $!");
            if ($db_use_flock) { flock (HIT, 2) or &cgierr ("Can't get file lock. Reason: $!"); }
            local $" = "\n";
            print HIT "$votes $rating\n$time\n@IP";
            close HIT;
            &site_html_rate_success;
        }       
        else {
            &site_html_rate_failure ("Sorry, you've already rated for this resource once recently.");
        }
    }
    else {
        open (HIT, ">$db_rates_path/$id") or &cgierr ("Can't increment counter file '$db_rates_path/$id'. Reason: $!");     
        print HIT "1 $rating\n$time\n$ENV{'REMOTE_ADDR'}";
        close HIT;      
        &site_html_rate_success;
    }
}