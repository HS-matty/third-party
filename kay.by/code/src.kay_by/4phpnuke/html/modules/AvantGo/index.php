<?php

######################################################################
# PHP-NUKE: Web Portal System: AvantGo Add-on
# ===========================================
#
# This module is to view your last news items via Palm or Windows CE
# devices, using AvantGo software or compatible palm device browsers
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
#
# Copyright (c) 2000 by Tim Litwiller - http://linux.made-to-order.net
######################################################################

if (!eregi("modules.php", $PHP_SELF)) {
	die ("You can't access this file directly...");
}

header("Content-Type: text/html");
echo "<html>\n"
    ."<head>\n"
    ."<title>$sitename</title>\n"
    ."<meta name=\"HandheldFriendly\" content=\"True\">\n"
    ."</head>\n"
    ."<body>\n\n\n"
    ."<div align=\"center\">\n";
$result = sql_query("SELECT sid, title, time FROM $prefix"._stories." ORDER BY sid DESC limit 10", $dbi);
if (!result) {
    echo "An error occured";
} else {
    echo "\t<a href=\"$nuke_url\"><img src=\"images/logo.gif\" alt=\"$slogan\" border=\"0\"></a><br>\r\n"
	."\t<h1>$sitename</h1>\r\n"
	."\t<table border=\"0\" align=\"center\">\r\n"
	."\t\t<tr>\r\n"
	."\t\t\t<td bgcolor=\"#efefef\">Article</td>\r\n"
	."\t\t\t<td bgcolor=\"#efefef\">Date</td>\r\n"
	."\t\t</tr>\r\n";
    for ($m=0; $m < sql_num_rows($result, $dbi); $m++) {
	list($sid, $title, $time) = sql_fetch_row($result, $dbi);
	echo "\t\t<tr>\r\n"
	    ."\t\t\t<td><a href=\"$nuke_url/print.php?sid=$sid\">$title</a></td>\r\n"
	    ."\t\t\t<td>$time</td>\r\n"
	    ."\t\t</tr>\r\n";
    }
    echo"\t</table>\r\n";
}
echo "</body>\n"
    ."</html>";
include ("counter.php");

?>