<?php

########################################################################
# PHP-Nuke Block: Total Hits v0.1                                      #
#                                                                      #
# Copyright (c) 2001 by C. Verhoef (cverhoef@gmx.net)                  #
#                                                                      #
########################################################################
# This program is free software. You can redistribute it and/or modify #
# it under the terms of the GNU General Public License as published by #
# the Free Software Foundation; either version 2 of the License.       # 
######################################################################## 

if (eregi("block-Total_Hits.php", $PHP_SELF)) {
    Header("Location: index.php");
    die();
}

global $nukeurl, $prefix, $startdate, $dbi;

$result = sql_query("SELECT count FROM $prefix"._counter." WHERE type='total' AND var='hits'", $dbi);
$result = sql_fetch_row($result, $dbi);
$content = "<center><small>"._WERECEIVED."</small><br><b><a href=\"$nukeurl/stats.php\">$result[0]</a></b><br><small>"._PAGESVIEWS." $startdate</small></center>";

?>