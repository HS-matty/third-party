#               -------------
#                   Links
#               -------------
#               Links Manager
#
#        File: db.pl
#  Description: Contains the heart of the admin program. All the database 
#              routines are stored here.
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

sub add_record {
# --------------------------------------------------------
# Adds a record to the database. First, validate_record is called
# to make sure the record is ok to add. If it is, then the record is
# encoded and added to the database and the user is sent to 
# html_add_success, otherwise the user is sent to html_add_failure with
# an error message explaining why. The counter file is also updated to the
# next number.

    my ($output, $status, $counter);    

# First we validate the record to make sure the addition is ok. 
    $status = &validate_record (%in);

# We keep checking for the next available key, or until we've tried 50 times
# after which we give up.
    while ($status eq "duplicate key error" and $db_key_track) {
        return "duplicate key error" if ($counter++ > 50);
        $in{$db_key}++;
        $status = &validate_record (%in);
    }
    if ($status eq "ok") {
        open (DB, ">>$db_file_name") or &cgierr("error in add_record. unable to open database: $db_file_name.\nReason: $!");
            if ($db_use_flock) {
                flock(DB, 2)  or &cgierr("unable to get exclusive lock on $db_file_name.\nReason: $!");
            }
            print DB &join_encode(%in); 
        close DB;       # automatically removes file lock
        if ($db_key_track) {
            open (ID, ">$db_id_file_name") or &cgierr("error in get_defaults. unable to open id file: $db_id_file_name.\nReason: $!");
                if ($db_use_flock) {
                    flock(ID, 2)  or &cgierr("unable to get exclusive lock on $db_id_file_name.\nReason: $!");
                }
                print ID $in{$db_key};      # update counter.
            close ID;       # automatically removes file lock
        }
        &html_add_success;
    }
    else {
        &html_add_failure($status);
    }
}

sub delete_records {
# --------------------------------------------------------
# Deletes a single or multiple records. First the routine goes thrrough
# the form input and makes sure there are some records to delete. It then goes
# through the database deleting each entry and marking it deleted. If there
# are any keys not deleted, an error message will be returned saying which keys
# were not found and not deleted, otherwise the user will go to the success page.

    my ($key, %delete_list, $rec_to_delete, @data, $errstr, $succstr, $output);
    $rec_to_delete = 0;
    foreach $key (keys %in) {               # Build a hash of keys to delete.
        if ($in{$key} eq "delete") {
            $delete_list{$key} = 1;
            $rec_to_delete = 1;
        }
    }
    $rec_to_delete or (&html_generic("Error: $html_object(s) Not Deleted", "no records specified.") and return);

# Search the database for a record to delete.
    open (DB, "<$db_file_name") or &cgierr("error in delete_records. unable to open db file: $db_file_name.\nReason: $!");
    if ($db_use_flock) { flock(DB, 1); }
    LINE: while (<DB>) {
        (/^#/)      and ($output .= $_ and next LINE);
        (/^\s*$/)   and next LINE;
        chomp;      
        @data = &split_decode($_);

        $delete_list{$data[$db_key_pos]} ?              # if this id is one we want to delete
            ($delete_list{$data[$db_key_pos]} = 0) :    # then mark it deleted and don't print it to the new database.
            ($output .= "$_\n");                        # otherwise print it.
    }
    close DB;
    
# Reprint out the database.
    open (DB, ">$db_file_name") or &cgierr("error in delete_records. unable to open db file: $db_file_name.\nReason: $!");
        if ($db_use_flock) {
            flock(DB, 2) or &cgierr("unable to get exclusive lock on $db_file_name.\nReason: $!");
        }
        print DB $output;
    close DB;       # automatically removes file lock           

# Build success/error messages.
    foreach $key (keys %delete_list) {
        $delete_list{$key} ?                # Check to see if any items weren't deleted
            ($errstr .= "$key,") :          # that should have been.
            ($succstr .= "$key,");          # For logging, we'll remember the one's we deleted.
    }
    chop($succstr);     # Remove trailing delimeter
    chop($errstr);      # Remove trailing delimeter
    
    $errstr ?                               # Do we have an error?
        &html_generic("Error: $html_object(s) Not Deleted", qq|The records with the following keys were not found in the database: <FONT COLOR="red">'$errstr'</FONT>.|) :      # If so, then let's report go to the failure page
        &html_generic("$html_object(s) Deleted", "The following records were deleted from the database: '$succstr'");       # else, everything went fine.
}   

sub modify_record {
# --------------------------------------------------------
# This routine does the actual modification of a record. It expects
# to find in %in a record that is already in the database, and will
# rewrite the database with the new entry. First it checks to make
# sure that the modified record is ok with validate record.
# It then goes through the database looking for the right record to
# modify, if found, it prints out the modified record, and returns
# the user to a success page. Otherwise the user is returned to an error
# page with a reason why.

    my ($status, @data, $output, $found);
    
    $status = &validate_record (%in);       # Check to make sure the modifications are ok!

    if ($status eq "ok") {
        $found = 0;     # Make sure the record is in here!
        open (DB, "<$db_file_name") or &cgierr("error in modify_records. unable to open db file: $db_file_name.\nReason: $!");
        if ($db_use_flock) { flock(DB, 1); }
        LINE: while (<DB>) {
            (/^#/)      and ($output .= $_ and next LINE);
            (/^\s*$/)   and next LINE;
            chomp;      
            @data = &split_decode($_);

            if ($data[$db_key_pos] eq $in{$db_key}) {
                $output .= &join_encode(%in);           
                $found = 1;                             
            }
            else {
                $output .= "$_\n";              # else print regular line.
            }
        }
        close DB;
        
        if ($found) {
            open (DB, ">$db_file_name") or &cgierr("error in modify_records. unable to open db file: $db_file_name.\nReason: $!");
                if ($db_use_flock) {
                    flock(DB, 2)  or &cgierr("unable to get exclusive lock on $db_file_name.\nReason: $!");
                }
                print DB $output;               
            close DB;           # automatically removes file lock
            &html_modify_success;
        }
        else {
            &html_modify_failure("$in{$db_key} (can't find requested record)");
        }
    }
    else {
        &html_modify_failure($status);      # Validation Error
    }
}

sub modify_mult_record {
# --------------------------------------------------------
# This routine will update multiple records at once. It expects
# to find in %in a series of records to update. They will be of the
# form field_name-key.
#
    my ($key, %modify_list, %modify_rec, $rec_to_modify, @data, $key,
        $errstr, $succstr, $output, %errors);
        
# First let's pick which records to modify and then separate them and store
# them in their own hashes.
    $rec_to_modify = 0;
    foreach $key (keys %in) {               # Build a hash of keys to modify.
        if ($in{$key} eq "modify") {
            $modify_list{$key} = 1;
            $rec_to_modify     = 1;
        }
        ($key =~ /^(.*)-(.+)$/) and (${$modify_rec{$2}}{$1} = $in{$key});
    }
# Choke if we don't have anything to do.
    $rec_to_modify or (&html_modify_failure("no records specified.") and return);

    open (DB, "<$db_file_name") or &cgierr("error in modify_records. unable to open db file: $db_file_name.\nReason: $!");
    if ($db_use_flock) { flock(DB, 1); }
    LINE: while (<DB>) {
        (/^#/)      and ($output .= $_ and next LINE);
        (/^\s*$/)   and next LINE;
        chomp;      
        @data = &split_decode($_);
        $key  = $data[$db_key_pos];

# Now we check if this record is something we want to modify. If so, then
# we make sure the new record is ok, if so we replace it.
        if ($modify_list{$key}) {
            $status = &validate_record(%{$modify_rec{$key}});
            if ($status eq "ok") {
                $output .= &join_encode(%{$modify_rec{$key}});          
                $modify_list{$key} = 0;
            }
            else {
                $errors{$key} = $status;
                $output .= "$_\n";
            }
        }
        else {
            $output .= "$_\n";
        }
    }
    close DB;

# Reprint out the database.
    open (DB, ">$db_file_name") or &cgierr("error in modify_records. unable to open db file: $db_file_name.\nReason: $!");
        if ($db_use_flock) {
            flock(DB, 2) or &cgierr("unable to get exclusive lock on $db_file_name.\nReason: $!");
        }
        print DB $output;
    close DB;       # automatically removes file lock

# Let's display an error message if we were unable to modify a record
# for some reason.
    foreach $key (keys %modify_list) {
        if ($modify_list{$key}) {
            ($errors{$key}) ?
                ($errstr .= "$key: $errors{$key}") :
                ($errstr .= "$key: not found");
        }
        else {
            $succstr .= qq~<a href="$db_script_link_url&view_records=1&$db_key=$key&ww=1">$key</a>,~; 
        }           
    }
    chop($succstr);     # Remove trailing delimeter
    
    &html_modify_mult_results($succstr, $errstr);
}

sub view_records {
# --------------------------------------------------------
# This is called when a user is searching the database for 
# viewing. All the work is done in query() and the routines just
# checks to see if the search was successful or not and returns
# the user to the appropriate page.

    my ($status, @hits) = &query("view");
    if ($status eq "ok") {
        &html_view_success(@hits);
    }
    else {
        &html_view_failure($status);
    }
}

sub query {
# --------------------------------------------------------
# First let's get a list of database fields we want to search on and 
# store it in @search_fields

    my ($i, $column, @search_fields, @search_gt_fields, @search_lt_fields, $maxhits, $numhits, $nh,
        $field, @regexp, @values, $key_match, @hits, @sortedhits, $next_url, $next_hit, $prev_hit,
        $first, $last, $upper, $lower, $left, $right);  
    my ($mode) = shift;
    local (%sortby);
    
# First thing we do is find out what we are searching for. We build a list of fields
# we want to search on in @search_fields.
    if ($in{'keyword'}) {       # If this is a keyword search, we are searching the same
        $i = 0;                 # thing in all fields. Make sure "match any" option is 
        $in{'ma'} = "on";       # on, otherwise this will almost always fail.
        foreach $column (@db_cols) {        
            if (($db_sort{$column} eq 'date') and !&date_to_unix($in{'keyword'})) { $i++; next; }
            push (@search_fields, $i);      # Search every column           
            $in{$column} = $in{'keyword'};  # Fill %in with keyword we are looking for.
            $i++;
        }
    }
    else {                      # Otherwise this is a regular search, and we only want records
        $i = 0;                 # that match everything the user specified for.     
        foreach $column (@db_cols) {
            if ($in{$column}   =~ /^\>(.+)$/) { ($db_sort{$column} eq 'date') and (&date_to_unix($1) or return "Invalid date format: '$1'");
                                                push (@search_gt_fields, $i); $in{"$column-gt"} = $1; $i++; next; }
            if ($in{$column}   =~ /^\<(.+)$/) { ($db_sort{$column} eq 'date') and (&date_to_unix($1) or return "Invalid date format: '$1'");
                                                push (@search_lt_fields, $i); $in{"$column-lt"} = $1; $i++; next; }
            if ($in{$column}      !~ /^\s*$/) { ($db_sort{$column} eq 'date') and (&date_to_unix($in{$column}) or return "Invalid date format: '$in{$column}'");
                                                push(@search_fields, $i); $i++; next; }
            if ($in{"$column-gt"} !~ /^\s*$/) { ($db_sort{$column} eq 'date') and (&date_to_unix($in{$column}) or return "Invalid date format: '$in{$column}'");
                                                push(@search_gt_fields, $i); }
            if ($in{"$column-lt"} !~ /^\s*$/) { ($db_sort{$column} eq 'date') and (&date_to_unix($in{$column}) or return "Invalid date format: '$in{$column}'");
                                                push(@search_lt_fields, $i); }
            $i++;
        }
    }
# If we don't have anything to search on, let's complain.
    if (!@search_fields and !@search_gt_fields and !@search_lt_fields) {
        return "no search terms specified";
    }
    
# Define the maximum number of hits we will allow, and the next hit counter.    
    $in{'mh'} ? ($maxhits = $in{'mh'}) : ($maxhits = $db_max_hits);
    $in{'nh'} ? ($nh      = $in{'nh'}) : ($nh      = 1);
    $numhits = 0;

# Now let's build up all the regexpressions we will use. This saves the program
# from having to recompile the same regular expression every time.
    foreach $field (@search_fields) {
        my $tmpreg = "$in{$db_cols[$field]}";
        (!$in{'re'}) and ($tmpreg = "\Q$tmpreg\E");
        ($in{'ww'})  and ($tmpreg = "\\b$tmpreg\\b");
        (!$in{'cs'}) and ($tmpreg = "(?i)$tmpreg");
        ($in{$db_cols[$field]} eq "*") and ($tmpreg = ".*");    # A "*" matches anything.
        
        $regexp_func[$field] = eval "sub { m/$tmpreg/o }";
        $regexp_bold[$field] = $tmpreg;
    }

# Now we go through the database and do the actual searching.   
# First figure out which records we want:
    $first = ($maxhits * ($nh - 1));
    $last  =  $first + $maxhits - 1;
    
    open (DB, "<$db_file_name") or &cgierr("error in search. unable to open database: $db_file_name.\nReason: $!");
    if ($db_use_flock) { flock(DB, 1); }    
    LINE: while (<DB>) {
        /^#/      and next LINE;        # Skip comment Lines.
        /^\s*$/   and next LINE;        # Skip blank lines.
        chomp;                          # Remove trailing new line.
        @values = &split_decode($_);
        
# Normal searches.      
        $key_match = 0;
        foreach $field (@search_fields) {
            $_ = $values[$field];   # Reg function works on $_.
            $in{'ma'} ?
                ($key_match = ($key_match or &{$regexp_func[$field]})) :
                (&{$regexp_func[$field]} or next LINE);
        }
# Greater then searches.
        foreach $field (@search_gt_fields) {        
            $term = $in{"$db_cols[$field]-gt"};                     
            if ($db_sort{$db_cols[$field]} eq "date") {
                $in{'ma'} ?
                    ($key_match = ($key_match or (&date_to_unix($values[$field])) > &date_to_unix($term))) :
                    (&date_to_unix($values[$field]) > (&date_to_unix($term)) or next LINE);
            }
            elsif ($db_sort{$db_cols[$field]} eq 'alpha') {
                $in{'ma'} ?
                    ($key_match = ($key_match or ($values[$field] > $term))) :
                    ((lc($values[$field]) gt lc($term)) or next LINE);          
            }
            else {;         
                $in{'ma'} ?
                    ($key_match = ($key_match or ($values[$field] > $term))) :
                    (($values[$field] > $term) or next LINE);
            }
        }
# Less then searches.
        foreach $field (@search_lt_fields) {
            $term = $in{"$db_cols[$field]-lt"};
            if ($db_sort{$db_cols[$field]} eq "date") {
                $in{'ma'} ?
                    ($key_match = ($key_match or (&date_to_unix($values[$field]) < &date_to_unix($term)))) :
                    (&date_to_unix($values[$field]) < (&date_to_unix($term)) or next LINE);
            }
            elsif ($db_sort{$db_cols[$field]} eq 'alpha') {
                $in{'ma'} ?
                    ($key_match = ($key_match or ($values[$field] < $term))) :
                    ((lc($values[$field]) lt lc($term)) or next LINE);          
            }
            else {
                $in{'ma'} ?
                    ($key_match = ($key_match or ($values[$field] < $term))) :
                    (($values[$field] < $term) or next LINE);
            }
        }
# Did we find a match? We only add the hit to the @hits array if we need it. We can
# skip it if we are not sorting and it's not in our first < > last range.
        if ($key_match || (!($in{'keyword'}) && !($in{'ma'}))) {            
            if (exists $in{'sb'}) {
                $sortby{(($#hits+1) / ($#db_cols+1))} = $values[$in{'sb'}];             
                push (@hits, @values); 
            }
            else {
                (($numhits >= $first) and ($numhits <= $last)) and push (@hits, @values);
            }
            $numhits++;     # But we always count it!
        }
    }
    close DB;
    
# Now we've stored all our hits in @hits, and we've got a sorting values stored
# in %sortby indexed by their position in @hits.
    $numhits ? ($db_total_hits = $numhits) : ($db_total_hits = 0);
    ($db_total_hits == 0) and return ("no matching records.");

# Sort the array @hits in order if we are meant to sort.
    if (exists $in{'sb'}) { # Sort hits on $in{'sb'} field.
        my ($sort_order, $sort_func);
        $in{'so'} ? ($sort_order = $in{'so'}) : ($sort_order = "ascend");
        $sort_func = "$db_sort{$db_cols[$in{'sb'}]}_$sort_order";       
        
        foreach $hit (sort $sort_func (keys %sortby)) {
            $first = ($hit * $#db_cols) + $hit; $last = ($hit * $#db_cols) + $#db_cols + $hit;          
            push (@sortedhits, @hits[$first .. $last]);
        }
        @hits = @sortedhits;
    }   

# If we have to many hits, let's build the next toolbar, and return only the hits we want.
    if ($numhits > $maxhits) {  
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
        ($right > 7) ? ($upper = $nh + 7)   : ($upper = int($numhits/$maxhits) + 1);
# Finally, adjust those page numbers if we are near an endpoint.        
        (7 - $nh >= 0) and ($upper = $upper + (8 - $nh));
        ($nh > ($numhits/$maxhits - 7)) and ($lower = $lower - ($nh - int($numhits/$maxhits - 7) - 1));
        $db_next_hits = "";

# Then let's go through the pages and build the HTML.       
        ($nh > 1) and ($db_next_hits .= qq~<a href="$db_script_url?$next_url&nh=$prev_hit">[<<]</a> ~);
        for ($i = 1; $i <= int($numhits/$maxhits) + 1; $i++) {
            if ($i < $lower) { $db_next_hits .= " ... "; $i = ($lower-1); next; }           
            if ($i > $upper) { $db_next_hits .= " ... "; last; }
            ($i == $nh) ?
                ($db_next_hits .= qq~$i ~) :
                ($db_next_hits .= qq~<a href="$db_script_url?$next_url&nh=$i">$i</a> ~);
            (($i * $maxhits) >= $numhits) and last;  # Special case if we hit exact.
        }
        $db_next_hits .= qq~<a href="$db_script_url?$next_url&nh=$next_hit">[>>]</a> ~ unless ($nh == $i);
        
# Slice the @hits to only return the ones we want, only have to do this if the results are sorted.
        if (exists $in{'sb'}) {         
            $first = ($maxhits * ($nh - 1)) * ($#db_cols+1);
            $last  =  $first + (($#db_cols+1) * $maxhits) - 1;      
            $last = $#hits if ($last > $#hits);
            @hits = @hits[$first .. $last];
        }
    }
    
# Bold the results 
    if ($db_bold and $in{'view_records'}) {
        for $i (0 .. (($#hits+1) / ($#db_cols+1)) - 1) {
            $offset = $i * ($#db_cols+1);
            foreach $field (@search_fields) {               
                $hits[$field + $offset] =~ s,(<[^>]+>)|($regexp_bold[$field]),defined($1) ? $1 : "<B>$2</B>",ge;
            }
        }
    }
    return ("ok", @hits);
}

sub validate_records {
# --------------------------------------------------------
# This routine takes a list of records to either delete, validate
# or modify and does the appropriate action.

    my ($rec_to_delete, $rec_to_validate, $rec_to_modify, 
        %delete_list, %validate_list, %modify_list, %links,
        @lines, @data, $id, $first, $last, $errstr, $output);

# First let's go through %in and see what we have to delete, modify
# and/or validate. We also store all the links in easy to get at hashes.
# We know what fields go with what records as they should all be of the form
# ID-Field_Name. For instance: 12-URL is the URL field for record number 12.

    $rec_to_delete = $rec_to_validate = $rec_to_modify = 0;
    foreach $key (keys %in) { # Build a hash of keys to delete, validate and modify.
        ($in{$key} eq "delete")     and $delete_list{$key} = 1      and $rec_to_delete = 1;
        ($in{$key} eq "validate")   and $validate_list{$key} = 1    and $rec_to_validate = 1;
        ($in{$key} eq "modify")     and $modify_list{$key} = 1      and $rec_to_modify = 1;
        ($key =~ /^(.*)-(\d+)$/)    and $links{$2}{$1} = $in{$key};
    }

# If there isn't anything to do, let's complain.
    if (!$rec_to_validate and !$rec_to_delete and !$rec_to_modify) {
        &html_generic ("Problems Validating $html_objects", "<font color=red><b>Error: No records specified.</b></font>"); return;
    }

# Let's go through the validation file and remove all the ones
# we want to validate as well as all the ones we want to delete.
    if ($rec_to_validate or $rec_to_delete) {
        open  (VAL, "<$db_valid_name") or &cgierr("error in validate_records. unable to open validate file: $db_valid_name. Reason: $!");
        if ($db_use_flock) { flock (VAL, 1); }
        LINE: while (<VAL>) {
            (/^#/)      and ($output .= $_ and next LINE);
            (/^\s*$/)   and next LINE;
            chomp;      
            @data = &split_decode($_);
            $id   = $data[$db_key_pos];

            if    ($delete_list{$id})   { $delete_list{$id}   = 0; }
            elsif ($validate_list{$id}) { $validate_list{$id} = 2; }
            else                        { $output .= "$_\n";    }
        }
        close VAL;
        open (VAL, ">$db_valid_name") or &cgierr("error in validate_records. unable to open validate file: $db_valid_name. Reason: $!");
            flock(VAL, 2) unless (!$db_use_flock);  
            print VAL $output;
        close VAL;    # automatically removes file lock
        undef $output;
    }

# Now if we have something to delete from the modify list, let's get rid of it.
    if ($rec_to_modify or $rec_to_delete) {
        open  (MOD, "<$db_modified_name") or &cgierr("error in validate_records. unable to open modified database: $db_modified_name. Reason: $!");
        if ($db_use_flock) { flock (MOD, 1); }
        LINE: while (<MOD>) {
            (/^#/)      and ($output .= $_ and next LINE);
            (/^\s*$/)   and next LINE;
            chomp;      
            @data = &split_decode($_);
            $id   = $data[$db_key_pos];

            if    ($delete_list{$id}) { $delete_list{$id} = 0; }
            elsif ($modify_list{$id}) { $modify_list{$id} = 2; } 
            else                      { $output .= "$_\n";  }
        }
        close MOD;

        open (MOD, ">$db_modified_name") or &cgierr("error in validate_records. unable to open modified database: $db_modified_name. Reason: $!");
            flock(MOD, 2) unless (!$db_use_flock);     
            print MOD $output;
        close MOD;    # automatically removes file lock
        undef $output;      
    }

# Now we update any modifications to the database.
    if ($rec_to_modify) {
        $found = 0;  # Make sure the record is in here!
        open (DB, "<$db_file_name") or &cgierr("error in validate_records. unable to open db file: $db_file_name. Reason: $!");
        if ($db_use_flock) { flock (DB, 1); }
        LINE: while (<DB>) {
            (/^#/)      and ($output .= $_ and next LINE);
            (/^\s*$/)   and next LINE;
            chomp;      
            @data = &split_decode($_);
            $id   = $data[$db_key_pos];
            
            if ($modify_list{$id} == 2) {                   # If this is the one we are looking for
                $output .= &join_encode(%{$links{$id}}); 
                $modify_list{$id} = 0;  $found = 1;                         
            }
            else {
                $output .= "$_\n";                      # else print regular line.
            }
        }
        close DB;
        if ($found) {
            open (DB, ">$db_file_name") or &cgierr("error in validate_records. unable to open db file: $db_file_name. Reason: $!");
                flock(DB, 2) unless (!$db_use_flock);
                print DB $output;
            close DB;          # automatically removes file lock
        }
        undef $output;
    }
    
# Now let's see if we have something to add to the real database, then
# let's do it.
    if ($rec_to_validate) {  
        open (DB, ">>$db_file_name") or &cgierr("error in validate_records, unable to open db file: $db_file_name. Reason: $!");
        flock(DB, 2) if ($db_use_flock);            
        
        foreach $id (keys %validate_list) {
            if ($validate_list{$id} == 2) {
                print DB &join_encode(%{$links{$id}});
                $validate_list{$id} = 0;
            }
        }
        close DB;
    }

# Now let's check to make sure everything that was asked to be val/del/mod
# actually happend. If not, let's complain.
    foreach $key (keys %validate_list) {
        if   ($validate_list{$key}) { $errstr .= "<li>Validate Error: <strong>$key</strong>. Couldn't find record in validation database.";   }
        else                        { $valsuc .= "$key,"; }
    }
    foreach $key (keys %delete_list) {
        if ($delete_list{$key})     { $errstr .= "<li>Delete Error: <strong>$key</strong>. Couldn't find record in validation/modified database."; }
        else                        { $delsuc .= "$key,"; }
    }
    foreach $key (keys %modify_list) {
        if ($modify_list{$key})     { $errstr .= "<li>Modify Error: <strong>$key</strong>. Couldn't find record in modified/links database."; }
        else                        { $modsuc .= "$key,"; }
    }
    chop($errstr); chop($valsuc); chop ($delsuc); chop ($modsuc);
    
# Before we display the HTML, let's fire off some validate/modify/delete emails
# lettings visitors know we've added their link. We only send the mail
# if $modify_list{$id} = 0 (if it's still 1, that means there was an error).

# NOTE: You can modify the text of the email in the email templates.
    &html_print_headers; # Just in case sendmail coughs up an error.
    
    if ($db_email_modify) {
        ID: foreach $id (keys %modify_list) {
            if ($modify_list{$id}) { next ID; } 
            elsif (${$links{$id}}{'Contact Email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ ||
                ${$links{$id}}{'Contact Email'} !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
                    $errstr .= ($errstr, "<li>Email Error: <strong>$id</strong>. Record validated, but couldn't send auto email. Reason: Bad Email addres: '${$links{$id}}{'Contact Email'}'.");
            }
            else { &html_modify_email (%{$links{$id}}); }
        }
    }
    if ($db_email_add) {
        ID: foreach $id (keys %validate_list) {
            if ($validate_list{$id}) { next ID; }
            elsif (${$links{$id}}{'Contact Email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ ||
                ${$links{$id}}{'Contact Email'} !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
                    $errstr .= ($errstr, "<li>Email Error: <strong>$id</strong>. Record validated, but couldn't send auto email. Reason: Bad Email addres: '${$links{$id}}{'Contact Email'}'.");
            }
            else { &html_validate_email (%{$links{$id}}); }
        }
    }
    ID: foreach $id (keys %delete_list) {
        if ($delete_list{$id})     { next ID; }
        elsif (!$in{"reason-$id"}) { next ID; }
        elsif (${$links{$id}}{'Contact Email'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ ||
            ${$links{$id}}{'Contact Email'} !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/) {
                $errstr .= ($errstr, "<li>Email Error: <strong>$id</strong>. Record deleted, but couldn't send rejection letter. Reason: Bad Email addres: '${$links{$id}}{'Contact Email'}'.");
        }
        else { &html_reject_email (%{$links{$id}}); }
    }
    
# Now let's go to the error page or the success page depending on
# what $errstr is. 
    $errstr ?
        &html_generic ("Validate Links", "Error validating links: <ul>$errstr</ul>") :
        &html_validate_success($valsuc, $modsuc, $delsuc);
}   

sub check_links {
# --------------------------------------------------------
# This routine makes sure that there is an entry in the category 
# database for every category in the links database.
#
    my %category_hash = map { $_ => 1 } &category_list;
    my (@values, %missing_categories, $category_out, $category, $count);
    
    open (DB, "<$db_links_name") or &cgierr("error in check_links. unable to open db file: $db_links_name. Reason: $!");
    LINE: while (<DB>) {
        (/^#/)      and next LINE;
        (/^\s*$/)   and next LINE;
        chomp;      
        @values = &split_decode($_);
        
# Check to see if this link is in a valid category.     
        $category_hash{$values[$db_category]} and next LINE;

# Otherwise, mark it missed, and add the link as a bad link.
        $missing_categories{$values[$db_category]}++;       
    }
    close DB;

# Create the HTML Output.
    if (%missing_categories) {
        $category_out = qq~<table border=1><tr><td><$font><b>Add</b></font></td>
                                           <td><$font><b>Delete</b></font></td>
                                           <td><$font><b>Category</b></font></td>
                                           <td colspan=2><$font><b>Move links to this existing Category</b></font></td></tr>~;
        foreach $category (keys %missing_categories) {
            $category_out .= qq|
                <tr><td><input type=radio name="$category" value="add"></td>
                    <td><input type=radio name="$category" value="delete"></td>
                    <td><$font>$category</font></td>
                    <td><input type=radio name="$category" value="move"></td><td>| . &build_select_field ("Category", "", "Move-$category") . qq|</tr>|;
            last if $count++ > 10;
        }
        $category_out .= qq| </table>|;
    }   
    &html_check_links ($category_out);
}

sub fix_links {
# --------------------------------------------------------
# This routine fixes up category structure problems identified in
# &check_links.
#
    my (@add_cats, %del_links, %mov_links, %move_to, @values, $category, $count);

# First figure out what to do.
    foreach (keys %in) {
        ($in{$_} eq 'add')    and push @add_cats, $_;
        ($in{$_} eq 'delete') and $del_links{$_}++;
        ($in{$_} eq 'move')   and $mov_links{$_}++;
        (/^Move-(.+)/)        and $move_to{$1} = $in{$_};
    }
    if (!@add_cats and !%del_links and !%mov_links) {
        &html_check_links (undef, "No categories were selected!");
        return;
    }
# If we have to move or delete links, then update the database. 
    if (keys %mov_links or keys %del_links) {   
        open (DB,    "$db_file_name")      or &cgierr ("Unable to open $db_file_name. Reason: $!");
        open (DBTMP, ">$db_file_name.bak") or &cgierr ("Unable to open $db_file_name.bak. Reason: $!");
        LINE: while (<DB>) {
            /^#/      and next LINE;        # Skip comment Lines.
            /^\s*$/   and next LINE;        # Skip blank lines.
            chomp;                          # Remove trailing new line.
            @values   = &split_decode($_);
            $category = $values[$db_category];
            exists $del_links{$category} and next LINE;
            exists $mov_links{$category} and ($values[$db_category] = $move_to{$category});       
            print DBTMP &join_encode (&array_to_hash (0, @values));
        }
        close DB;
        close DBTMP;
        if (-s "$db_file_name.bak" > 0) {
            if (! rename ("$db_file_name.bak", $db_file_name)) {
                print "\tCouldn't rename! Had to copy. Strange: $!\n";
                open (DBTMP, ">$db_file_name")    or &cgierr ("unable to open links database: $db_file_name. Reason: $!");
                open (DB,    "$db_file_name.bak") or &cgierr ("unable to open temp links database: $db_file_name.bak. Reason: $!");
                while (<DB>) { print DBTMP; }
                close DB;
                close DBTMP;
            }
        }
        else {
            &cgierr ("Error building! Links database is 0 bytes!");
        }       
    }
    
# If we are adding categories, load the category.def and update the database.
    if ($#add_cats >= 0) {
        require "$db_lib_path/category.def";
        $in{'db'} = 'category';
        
        open (CATID, "<$db_category_id_file_name") or &cgierr ("Unable to open category id file: $db_category_id_file_name. Reason: $!");
        $count = int <CATID>;
        close CATID;
        
        open (CAT, ">>$db_category_name") or &cgierr ("Unable to open category file: $db_category_name. Reason: $!");       
        foreach $category (@add_cats) {
            %tmp = ( $db_key => $count++, Name => $category );
            print CAT &join_encode (%tmp);
        }
        close CAT;

        open (CATID, ">$db_category_id_file_name") or &cgierr ("Unable to open category id file: $db_category_id_file_name. Reason: $!");
        print CATID $count;
        close CATID;
    }
    &html_check_links (undef, "The database was successfully updated!");
}

sub check_duplicates {
# --------------------------------------------------------
# This routine searches through the database and pulls up sets
# of links that have the same domain.
#
    my (@values, %seen, %doubles, $url, $count);

    open (DB, "<$db_links_name") or &cgierr("error in check_duplicates. unable to open db file: $db_links_name. Reason: $!");
    LINE: while (<DB>) {
        (/^#/)      and next LINE;
        (/^\s*$/)   and next LINE;
        chomp;      
        @values = &split_decode($_);
        $values[$db_url] =~ s,/$,,;
        $seen{$values[$db_url]}++;
        push (@{$doubles{$values[$db_url]}}, $values[$db_key_pos], $values[$db_title], $values[$db_category]);
    }
    close DB;
    while (($url, $count) = each %seen) {
        ($count < 2) and delete $doubles{$url};
    }
    &html_check_duplicates (%doubles);
}

sub save_template {
# --------------------------------------------------------
# This routine will save a modified template.
#
    my $tpl_name = $in{'save_tpl'};
    my $tpl      = $in{'tpl'};
    $tpl =~ s,</text-area>,</textarea>,ig;
    $tpl_name =~ /^[\w\d_\-]+\.[\w\d_\-]+$/ or &cgierr ("Invalid template name: $tpl_name. Can only contain letters, numbers, underscore and dash.");
    open (TPL, ">$db_template_path/$tpl_name") or &cgierr ("Can't open template: $db_template_path/$tpl_name for writing. Reason: $!");
    print TPL $tpl;
    close TPL;
    
    $in{'edit_tpl'} = $in{'save_tpl'};
    &html_edit_template ("The template $tpl_name has been updated.");
}

sub get_template_list {
# --------------------------------------------------------
# Returns a list of all the templates (select list).
#
    my $default = shift;
    
    opendir (TPL, "$db_template_path") or &cgierr ("Invalid template directory: $db_template_path. Reason: $!");
    my @tpls = grep $_ !~ /^\.\.?$/, readdir(TPL);
    closedir (TPL);
    
    my $output = '<select name="edit_tpl">';
    foreach (sort @tpls) {
        ($default eq $_) ? ($output .= qq~<option value="$_" SELECTED>$_~) :
                           ($output .= qq~<option value="$_">$_~);
    }
    $output .= '</select>';
    return $output;
}

# These are the sorting functions used in &query.
# --------------------------------------------------------
sub alpha_ascend  { lc($sortby{$a}) cmp lc ($sortby{$b}) }
sub alpha_descend { lc($sortby{$b}) cmp lc ($sortby{$a}) }
sub numer_ascend  { $sortby{$a} <=> $sortby{$b} }
sub numer_descend { $sortby{$b} <=> $sortby{$a} }
sub date_ascend   { &date_to_unix($sortby{$a}) <=> &date_to_unix($sortby{$b}) }
sub date_descend  { &date_to_unix($sortby{$b}) <=> &date_to_unix($sortby{$a}) }

1;