#               -------------
#                   Links
#               -------------
#               Links Manager
#
#        File: db_utils.pl
# Description: Database support routines.
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

sub get_record {
# --------------------------------------------------------
# Given an ID as input, get_record returns a hash of the 
# requested record or undefined if not found.

    my ($key, $found, @data, $field);
    $key   = shift;  $found = 0;

    open (DB, "<$db_file_name") or &cgierr("error in get_records. unable to open db file: $db_file_name.\nReason: $!");
    if ($db_use_flock) { flock(DB, 1); }    
    LINE: while (<DB>) {
        (/^#/)      and next LINE;
        (/^\s*$/)   and next LINE;
        chomp;      
        @data = &split_decode($_);
        if ($data[$db_key_pos] eq $key) {
            $found = 1;
            %rec = &array_to_hash (0, @data);
            last LINE;
        }
    }
    close DB;   
    $found ? (return %rec) : (return undef);
}

sub get_defaults {
# --------------------------------------------------------
# Returns a hash of the defaults used for a new record.

    my %default;
    
    foreach $field (keys %db_defaults) {
        $db_defaults{$field} =~ /^\s*$/ and ($default{$field} = $in{$field}) and next;
        (ref $db_defaults{$field} eq 'CODE') ?
            ($default{$field} = &{$db_defaults{$field}}) : ($default{$field} =  $db_defaults{$field});
    }   
    if ($db_key_track) {
        open (ID, "<$db_id_file_name") or &cgierr("error in get_defaults. unable to open id file: $db_id_file_name.\nReason: $!");
        if ($db_use_flock) { flock(ID, 1);  }   
        $default{$db_key} = <ID> + 1;   # Get next ID number
        close ID;
    }
    return %default;
}

sub validate_record {
# --------------------------------------------------------
# Verifies that the information passed through the form and stored
# in %in matches a valid record. It checks first to see that if 
# we are adding, that a duplicate ID key does not exist. It then
# checks to see that fields specified as not null are indeed not null,
# finally it checks against the reg expression given in the database
# definition.
#
    my ($col, @input_err, $errstr, $err, $line, @lines, @data); 
    my (%rec) = @_;

    if ($rec{'add_record'})     {       # don't need to worry about duplicate key if modifying  
        open (DB, "<$db_file_name") or &cgierr("error in validate_records. unable to open db file: $db_file_name.\nReason: $!");        
        if ($db_use_flock) { flock(DB, 1); }        
        LINE: while (<DB>) {
            (/^#/)      and next LINE;
            (/^\s*$/)   and next LINE;
            chomp;      
            @data = &split_decode($_);
            ($data[$db_key_pos] eq $rec{$db_key}) and return "duplicate key error";
        }
        close DB;
    }   
    foreach $col (@db_cols) {
        if ($rec{$col} =~ /^\s*$/) {            # entry is null or only whitespace
            ($db_not_null{$col}) and            # entry is not allowed to be null.
                push(@input_err, "$col (Can not be left blank)");  # so let's add it as an error
        }
        else {                                  # else entry is not null.
            ($db_valid_types{$col} && !($rec{$col} =~ /$db_valid_types{$col}/)) and
                push(@input_err, "$col (Invalid format)");  # but has failed validation.
            (length($rec{$col}) > $db_lengths{$col}) and
                push (@input_err, "$col (Too long. Max length: $db_lengths{$col})");
            if ($db_sort{$col} eq "date") {     
                push (@input_err, "$col (Invalid date format)") unless &date_to_unix($rec{$col});
            }
        }
    }   
    if ($#input_err+1 > 0) {                    # since there are errors, let's build
        foreach $err (@input_err) {             # a string listing the errors
            $errstr .= "<li>$err";              # and return it.
        }
        return "<ul>$errstr</ul>";
    }
    else {
        return "ok";                            # no errors, return ok.
    }
}

sub build_email_list {
# --------------------------------------------------------
# Build a list of all subscribers to mail to.
#
    my ($name, $email, $output);
    $output = qq~<select name="mailto" multiple size=5>~;
    
    open (DB, "<$db_email_name ") or &cgierr("unable to open db file: $db_email_name .\nReason: $!");       
    if ($db_use_flock) { flock(DB, 1); }        
    LINE: while (<DB>) {
        (/^#/)      and next LINE;
        (/^\s*$/)   and next LINE;
        chomp;
        ($email, $name) = split /\Q$db_delim\E/;
        $output .= "<option selected>$email</option>\n";
    }
    $output .= "</select>";
    close DB;
    return $output;
}

sub build_new_links {
# --------------------------------------------------------
# Returns a text string used in the email newsletter of all
# new links.
#
    my $output = '';
    my (@data, %rec);
    
    open (DB, "<$db_file_name") or &cgierr("unable to open db file: $db_file_name.\nReason: $!");       
    if ($db_use_flock) { flock(DB, 1); }        
    LINE: while (<DB>) {
        (/^#/)      and next LINE;
        (/^\s*$/)   and next LINE;
        chomp;      
        @data = &split_decode($_);
        if ($data[$db_isnew] eq 'Yes') {
            %rec = &array_to_hash(0, @data);
            my $des_q = &linewrap ($rec{'Description'});
            $output .= qq~
-------------------------------------------------------------------         
$rec{'Title'} (added: $rec{'Date'})
$rec{'URL'}
$des_q
~;
        }
    }
    close DB;
    return $output; 
}

sub build_select_field {
# --------------------------------------------------------
# Builds a SELECT field based on information found
# in the database definition.
#
    my ($column, $value, $name, $mult) = @_;    
    my ($size, %values);
        
    $name || ($name = $column);
    $size || ($size = 1);   
    
    if (! exists $db_select_fields{$column}) { 
        $db_select_fields{$db_cols[$db_category]} = $db_select_fields{'Mult-Related'} = join (",", &category_list); 
    }
    if ($mult) {
        @fields = split (/\,/, $db_select_fields{"Mult-$column"});
        %values = map { $_ => 1 } split (/\Q$db_delim\E/, $value); 
    }
    else {
        @fields = split (/\,/, $db_select_fields{$column});
        $values{$value}++;
    }
    ($#fields >= 0) or return "error building select field: no select fields specified in config for field '$column'!"; 

    $output = qq|<SELECT NAME="$name" $mult SIZE=$size><OPTION>---|;
    foreach $field (@fields) {
        $values{$field} ?
            ($output .= "<OPTION SELECTED>$field\n") :
            ($output .= "<OPTION>$field");
    }
    $output .= "</SELECT>";
    return $output;
}

sub build_select_field_from_db {
# --------------------------------------------------------
# Builds a SELECT field from the database. 
#
    my ($column, $value, $name) = @_;
    my (@fields, $field, %selectfields, $ouptut, $fieldnum, $found);

# Make sure this is a valid field.
    (grep $_ eq $column, @db_cols) or return "error building select field: no fields specified!";

    $fieldnum = $db_def{$column}[0];
    $name   ||= $column;

# Go through the database and get each unique name in that column.
    open (DB, "<$db_file_name") or &cgierr("unable to open $db_file_name. Reason: $!");
    if ($db_use_flock) { flock(DB, 1); }
    LINE: while (<DB>) {        
        /^\s*$/  and next LINE;   # Skip blank lines
        /^#/     and next LINE;   # Comment Line
        @fields = &split_decode ($_);
        $selectfields{$fields[$fieldnum]}++;
    }
    close DB;

# Make a select list out of those names.    
    $output = qq|<SELECT NAME="$name"><OPTION>---|;
    foreach $field (sort keys %selectfields) {
        ($field eq $value) ?
            ($output .= "<OPTION SELECTED>$field\n") :
            ($output .= "<OPTION>$field\n");
    }
    $output .= "</SELECT>\n";
    return $output;
}

sub build_checkbox_field {
# --------------------------------------------------------
# Builds a CHECKBOX field based on information found
# in the database definition. Parameters are the column to build
# whether it should be checked or not and a default value (optional).

    my ($column, $values, $name) = @_;

    $db_checkbox_fields{$column} or return "error building checkboxes: no checkboxes specified in config for field '$column'";
    $name ||= $column;
    
    my @values = split (/\Q$db_delim\E/, $values);
    my @boxes  = split (/,/, $db_checkbox_fields{$column});
    my ($output, $box);
    
    foreach $box (@boxes) {
        (grep $_ eq $box, @values) ?
            ($output .= qq!<INPUT TYPE="CHECKBOX" NAME="$name" VALUE="$box" CHECKED> $box\n!) :
            ($output .= qq!<INPUT TYPE="CHECKBOX" NAME="$name" VALUE="$box"> $box\n!);
    }
    return $output;
}

sub build_radio_field {
# --------------------------------------------------------
# Builds a RADIO Button field based on information found
# in the database definition. Parameters are the column to build
# and a default value (optional).
#
    my ($column, $value, $name) = @_;
    my (@buttons, $button, $output);

    $db_radio_fields{$column} or return "error building radio buttons: no radio fields specified in config for field '$column'!";
    $name ||= $column;

    @buttons = split (/,/, $db_radio_fields{$column});
    
    foreach $button (@buttons) {
        ($value eq $button) ?
            ($output .= qq|<INPUT TYPE="RADIO" NAME="$name" VALUE="$button" CHECKED> $button \n|) :
            ($output .= qq|<INPUT TYPE="RADIO" NAME="$name" VALUE="$button"> $button \n|);
    }
    return $output;
}

sub build_html_record {
# --------------------------------------------------------
# Builds a record based on the config information.
#
    my (%rec) = @_;
    my ($output, $field);
    
    $output = "<p><table border=1 width=450>\n";
    foreach $field (@db_cols) {
        next if ($db_form_len{$field} == -1);
        $output .= qq~
            <tr><td align=right valign=top width=20%><$font>$field:</font></td>
                <td width=80%><$font>$rec{$field}</font></td></tr>
        ~;
    }
    $output .= "</table></p>\n";
    return $output;
}

sub build_html_record_form {
# --------------------------------------------------------
# Builds a record form based on the config information.
#
    my ($output, $field, $multiple, $name);
    ($_[0] eq "multiple") and ($multiple = 1) and shift;
    my (%rec) = @_;

    $output = "<p><table border=1>";

# Go through a little hoops to only load category list when absolutely neccessary.
    if ($in{'db'} eq 'links') {
        exists $db_select_fields{$db_cols[$db_category]}
            or ($db_select_fields{$db_cols[$db_category]} = join (",", &category_list));
    }
    else {
        $db_select_fields{'Related'} or
            ($db_select_fields{'Related'} = $db_select_fields{'Mult-Related'} = join ",", &category_list);
    }           

    foreach $field (@db_cols) {     
# Set the field name to field-key if we are doing multiple forms.
        $multiple ? ($name = "$field-$rec{$db_key}") : ($name = $field);
        if    ($db_select_fields{"Mult-$field"}) { $output .= "<tr><td align=right valign=top width=20%><$font>$field:</font></td><td width=80%>" . &build_select_field($field, $rec{$field}, $name, "MULTIPLE SIZE=3") . "</td></tr>\n"; }
        elsif ($db_select_fields{$field})   { $output .= "<tr><td align=right valign=top width=20%><$font>$field:</font></td><td width=80%>"      . &build_select_field($field, $rec{$field}, $name)    . "</td></tr>\n"; }
        elsif ($db_radio_fields{$field})    { $output .= "<tr><td align=right valign=top width=20%><$font>$field:</font></td><td width=80%>"      . &build_radio_field($field, $rec{$field}, $name)     . "</td></tr>\n"; }
        elsif ($db_checkbox_fields{$field}) { $output .= "<tr><td align=right valign=top width=20%><$font>$field:</font></td><td width=80%>"      . &build_checkbox_field ($field, $rec{$field}, $name) . "</td></tr>\n"; }
        elsif ($db_form_len{$field} =~ 
                             /(\d+)x(\d+)/) { $output .= qq~<tr><td align=right valign=top width=20%><$font>$field:</font></td><td width=80%><textarea wrap="virtual" name="$name" cols="$1" rows="$2">$rec{$field}</textarea></td></tr>\n~; }
        elsif ($db_form_len{$field} == -1)  { $output  = qq~<input type=hidden name="$field" value="$rec{$field}">\n$output~; }
        else                                { $output .= qq~<tr><td align=right valign=top width=20%><$font>$field:</font></td><td width=80%><input type=text name="$name" value="$rec{$field}" size="$db_form_len{$field}" maxlength="$db_lengths{$field}"></td></tr>\n~; }
    }
    $output .= "</table></p>\n";
    return $output;
}       

sub category_list {
# --------------------------------------------------------
# Returns a list of all categories in the database.
#
    my (%categories, @fields);  

# If we've already loaded this, return it.
    defined @db_category_list and return @db_category_list;

# Otherwise pull the list from the database.
    open (DB, "<$db_category_name") or &cgierr("unable to open $db_file_name. Reason: $!");
    if ($db_use_flock) { flock(DB, 1); }    
    LINE: while (<DB>) {
        (/^#/)      and next LINE;
        (/^\s*$/)   and next LINE;
        @fields = &split_decode ($_);
        $categories{$fields[$db_main_category]}++;
    }
    close DB;

# Cache the output in case we use this again.   
    @db_category_list = sort keys %categories;  

    return @db_category_list;
}

sub build_clean {
# --------------------------------------------------------
# Formats a category name for displaying.
#
    my ($input) = shift;
    $input =~ s/_/ /g;      # Change '_' to spaces.
    $input =~ s,/, : ,g;    # Change '/' to ' : '.
    return $input;
}

sub build_sorthit {
# --------------------------------------------------------
# This function sorts a list of links. It has been modified to sort
# new links first, then cool links, then the rest alphabetically. By modifying
# the sort function below, you can sort the links however you like (by date,
# or random, etc.).
#
     my (@unsorted) = @_;
     my ($num) = ($#unsorted+1) / ($#db_cols+1);
     my (%sortby, %isnew, %iscool, $hit, $i, @sorted);

     for ($i = 0; $i < $num; $i++) {
         $sortby{$i} = $unsorted[$db_sort_links + ($i * ($#db_cols+1))];
         ($unsorted[$db_isnew + ($i * ($#db_cols+1))] eq "Yes")  and ($isnew{$i}  = 1); 
         ($unsorted[$db_ispop + ($i * ($#db_cols+1))] eq "Yes")  and ($iscool{$i} = 1); 
     }
     foreach $hit (sort { 
                             ($isnew{$b}  and !$isnew{$a})  and return 1; 
                             ($isnew{$a}  and !$isnew{$b})  and return -1; 
                             ($iscool{$b} and !$iscool{$a}) and return 1; 
                             ($iscool{$a} and !$iscool{$b}) and return -1; 
                             ($isnew{$a}  and  $isnew{$b})  and return lc($sortby{$a}) cmp lc($sortby{$b}); 
                             ($iscool{$a} and  $iscool{$b}) and return lc($sortby{$a}) cmp lc($sortby{$b}); 
                             return lc($sortby{$a}) cmp lc($sortby{$b});
                        } (keys %sortby)) {
         $first = ($hit * $#db_cols) + $hit;
         $last  = ($hit * $#db_cols) + $#db_cols + $hit;          
         push (@sorted, @unsorted[$first .. $last]);
     }   
     return @sorted;
 }

sub urlencode {
# --------------------------------------------------------
# Escapes a string to make it suitable for printing as a URL.
#
    my($toencode) = shift;
    $toencode =~ s/([^a-zA-Z0-9_\-.])/uc sprintf("%%%02x",ord($1))/eg;
    $toencode =~ s/\%2F/\//g;
    return $toencode;
}

sub get_date {
# --------------------------------------------------------
# Returns the current date.
#
    my ($time) = shift;
    $time    ||= time();
    
    exists $DATE_CACHE{$time} or ($DATE_CACHE{$time} = &unix_to_date($time));
    return $DATE_CACHE{$time};
}

sub get_time {
# --------------------------------------------------------
# Returns the time in the format "hh-mm-ss".
#   
    my $time = shift;
    $time  ||= time();
    my ($sec, $min, $hour, @junk) = localtime ($time);
    ($sec < 10)  and ($sec  = "0$sec");
    ($min < 10)  and ($min  = "0$min");
    ($hour < 10) and ($hour = "0$hour");
    
    return "$hour:$min:$sec";
}

sub days_old {
# --------------------------------------------------------
# Returns the number of days from a given day to today (number of days 
# old.
#   
    exists $DATE_CACHE{$_[0]} or ($DATE_CACHE{$_[0]} = &date_to_unix($_[0]));
    return int ((time() - $DATE_CACHE{$_[0]}) / 86400);
}

sub compare_dates {
# --------------------------------------------------------
# Returns 1 if date a is greater then date b, otherwise returns 0.
#
    exists $DATE_CACHE{$_[0]} or ($DATE_CACHE{$_[0]} = &date_to_unix($_[0]));
    exists $DATE_CACHE{$_[1]} or ($DATE_CACHE{$_[1]} = &date_to_unix($_[1]));
    return $DATE_CACHE{$_[0]} > $DATE_CACHE{$_[1]};
}

sub array_to_hash {
# --------------------------------------------------------
# Converts an array to a hash using db_cols as the field names.
#
    my ($hit, @array) = @_;
    my ($i);    
    return map { $db_cols[$i] => $array[$hit * ($#db_cols+1) + $i++] } @_;
}

sub linewrap {
# --------------------------------------------------------
# Wraps a line into 60 char chunks. Modified from code by
# Tim Gim Yee <tgy@chocobo.org>.
#
    my $line = shift; defined $line or return '';
    my @data = split /\t/, $line;
    my $columns = 60;
    my $tabstop = 1;
    my $frag = '';
    my $col  = $columns - 1;

    for (@data) {
        $_ = "$frag$_";
        $frag = '';
        s/(.{1,$columns}$)|(.{1,$col}(?:\S\s+|-(?=\w)))|(.{$col})/
            $3 ? "$3-\n" :
            $2 ? "$2\n" :
            (($frag = $1), '')
        /ge;
        $frag .= (' ' x ($tabstop - length($frag) % $tabstop));
    }

    local $_ = join '', @data, $frag;
    s/\s+$//gm;
    return $_;
}

sub load_template {
# --------------------------------------------------------
# Loads and parses a template. Expects to find as input a 
# template file name, and a hash ref and optionally template text.
# If text is defined, then no file is loaded, but rather the template
# is taken from $text.
#
    my ($tpl, $vars, $string) = @_;
    (ref $vars eq 'HASH') or &cgierr ("Not a hash ref: $vars in load_template!");
    
    if (!defined $db_template) {
        require "$db_lib_path/Template.pm";
        $db_template = new Template ( { ROOT => $db_template_path, CHECK => 0 } );
    }
    $db_template->clear_vars;
    $db_template->load_template ($tpl, $string) or &cgierr ("Can't load template. Reason: $Template::error");
    $db_template->load_vars     ($vars)         or &cgierr ("Can't load variables. Reason: $Template::error");
    return $db_template->parse  ($tpl)          or &cgierr ("Can't parse template. Reason: $Template::error");  
}

sub join_encode {
# --------------------------------------------------------
# Takes a hash (ususally from the form input) and builds one 
# line to output into the database. It changes all occurrences
# of the database delimeter to '~~' and all newline chars to '``'.

    my %hash = @_;
    my ($tmp, $col, $output);   

    foreach $col (@db_cols) {               
        $tmp = $hash{$col};
        $tmp =~ s/^\s+//g;              # Trim leading blanks...
        $tmp =~ s/\s+$//g;              # Trim trailing blanks...
        $tmp =~ s/\Q$db_delim\E/~~/og;  # Change delimeter to ~~ symbol.
        $tmp =~ s/\n/``/g;              # Change newline to `` symbol.
        $tmp =~ s/\r//g;                # Remove Windows linefeed character.
        $output .= $tmp . $db_delim;    # Build Output.
    }
    chop $output;       # remove extra delimeter.
    $output .= "\n";    # add linefeed char.
    return $output;
}

sub split_decode {
# --------------------------------------------------------
# Takes one line of the database as input and returns an
# array of all the values. It replaces special mark up that 
# join_encode makes such as replacing the '``' symbol with a 
# newline and the '~~' symbol with a database delimeter.

    my ($input) = shift;    
    my (@array) = split (/\Q$db_delim\E/o, $input, $#db_cols+1);
    foreach (@array) {
        s/~~/$db_delim/g;   # Retrieve Delimiter..
        s/``/\n/g;          # Change '' back to newlines..
    }   
    return @array;
}

sub html_print_headers {
# --------------------------------------------------------
# Print out the headers if they haven't already been printed.
#
    if (!$html_headers_printed) {   
        print "HTTP/1.0 200 OK\n"               if ($db_iis or $nph);
        print "Pragma: no-cache\n"              if ($db_nocache);
        print "Content-type: text/html\n\n";
        $html_headers_printed = 1;
    }
}

sub parse_form {
# --------------------------------------------------------
# Parses the form input and returns a hash with all the name
# value pairs. Removes any field with "---" as a value 
# (as this denotes an empty SELECT field.
#
    my (@pairs, %in);
    my ($buffer, $pair, $name, $value); 
        
    if ($ENV{'REQUEST_METHOD'} eq 'GET') {
        @pairs = split(/&/, $ENV{'QUERY_STRING'});
    }
    elsif ($ENV{'REQUEST_METHOD'} eq 'POST') {
        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
        @pairs = split(/&/, $buffer);
    }
    else {
        &cgierr('You cant run this script from telnet/shell.');
    }
    
    PAIR: foreach $pair (@pairs) {
        ($name, $value) = split(/=/, $pair);
         
        $name =~ tr/+/ /;
        $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

        ($value eq "---") and next PAIR; 
        exists $in{$name} ? ($in{$name} .= "~~$value") : ($in{$name}  = $value);
    }
    return %in;
}

sub cgierr {
# --------------------------------------------------------
# Displays any errors and prints out FORM and ENVIRONMENT 
# information. Useful for debugging.
#
    if (!$html_headers_printed) {
        print "Content-type: text/html\n\n";
        $html_headers_printed = 1;
    }
    print "<PRE>\n\nCGI ERROR\n==========================================\n";
    $_[0]      and print "Error Message       : $_[0]\n";   
    $0         and print "Script Location     : $0\n";
    $]         and print "Perl Version        : $]\n";  
    
    print "\nForm Variables\n-------------------------------------------\n";
    foreach $key (sort keys %in) {
        my $space = " " x (20 - length($key));
        print "$key$space: $in{$key}\n";
    }
    print "\nEnvironment Variables\n-------------------------------------------\n";
    foreach $env (sort keys %ENV) {
        my $space = " " x (20 - length($env));
        print "$env$space: $ENV{$env}\n";
    }
    print "\n</PRE>";
    exit -1;
}

1;