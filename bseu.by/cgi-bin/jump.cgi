#!e:/work/root/usr/local/bin/perl
#               -------------
#                   Links
#               -------------
#               Links Manager
#
#        File: jump.cgi
#  Description: Increments the number of hits for the specified link, 
#              and sends the user off to the appropriate page.
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
#
#   Form Input: 
#      '$db_key'   = key number     # Send as form input the key name and key value
#                                     # of the link you want to go to.
#
#   Setup:
#      Make sure the require statement below points to the config file. 

# Required Librariers
# --------------------------------------------------------
eval {
    ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");    # Get the script location: UNIX /
    ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");    # Get the script location: Windows \

    require "admin/links.cfg";            # Change this to full path to links.cfg if you have problems.
    require "$db_lib_path/db_utils.pl";
    require "$db_lib_path/links.def";
};
if ($@) {
    print "Content-type: text/plain\n\n";
    print "Error including libraries: $@\n";
    print "Make sure they exist, permissions are set properly, and paths are set correctly.";
}

# ========================================================

eval { &main; };                         # Trap any fatal errors so the program hopefully 
if ($@) { &cgierr("fatal error: $@"); }  # never produces that nasty 500 server error page.
exit;   # There are only two exit calls in the script, here and in in &cgierr. 

sub main {
# --------------------------------------------------------
    my %in = &parse_form(); 
    my ($goto, $id, $delim, $time); 
    
    $id    = $in{$db_key};  
    $delim = quotemeta($db_delim);
    $time  = time();
    
    if ($id eq "random") {
        my ($count, $rand, $find);      

# Pull out the total number of links.       
        open  (COUNT, "<$db_hits_path/index.count") or &error ("unable to open index count file: $db_hits_path/index.count. Reason: $!");
        $count = int <COUNT>;
        close COUNT;

# Get the random line from the url lookup database.     
        srand;
        $find = 0; $rand = int (rand ($count + 0.5)); ($rand == $count) and ($rand--);
        open (URL, "<$db_url_name") or &error ("unable to open url database: $db_url_name. Reason: $!");
        while (<URL>) {         
            $find++ == $rand  or next;
            /\d+$delim(.+)/o  or next;
            $goto = $1;
            last;
        }
        close URL;
        $goto or &error ("Can't find random line: $rand.");
    }
    elsif (exists $in{$db_key}) {
# Make sure this is a valid looking id. 
        ($id =~ /^\d+$/)  or &error ("Invalid id: $id");

# Let's get the URL.
        open (URL, "<$db_url_name") or &error ("unable to open url database: $db_url_name. Reason: $!");
        while (<URL>) {         
            (/^$id$delim(.+)/o) or next;
            chomp ($goto = $1); 
            last;
        }
        close URL;
        $goto or &error ("Can't find link id: $id");

# Bump the counter one.
        if (open (HIT, "<$db_hits_path/$id")) {
            my ($count, $old_time, @IP, $ip, $visited);         
            chomp ($count    = <HIT>);
            chomp ($old_time = <HIT>);
            chomp (@IP       = <HIT>);
            (($time - $old_time) > 21600) and (@IP = ());
            foreach $ip (@IP) {         
                $ip eq $ENV{'REMOTE_ADDR'} and ($visited++ and last);
            }
            if (!$visited) {
                push (@IP, $ENV{'REMOTE_ADDR'});
                $count = $count + 1;            
                open (HIT, ">$db_hits_path/$id") or &error ("Can't open for output counter file. Reason: $!");
                if ($db_use_flock) { flock (HIT, 2) or &error ("Can't get file lock. Reason: $!"); }
                local $" = "\n";
                print HIT "$count\n$time\n@IP";
                close HIT;
            }
        }
        else {
            open (HIT, ">$db_hits_path/$id") or &error ("Can't increment counter file. Reason: $!");        
            print HIT "1\n$time\n$ENV{'REMOTE_ADDR'}";
            close HIT;      
        }
    }
    else {
        &error ("No link specified!");
    }
    
# Now let's send the user to the url..
    $goto ?
        print "Location: $goto\n\n" :
        &error ("Record not found ($in{$db_key})");
}

sub error {
# ------------------------------------------
#
    print "Content-type: text/plain\n\n";
    print "Error: $_[0]\n";
    exit;
}
