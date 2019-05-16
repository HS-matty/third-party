<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

require_once("mainfile.php");

include("header.php");
$result = sql_query("select topicid, topicname, topicimage, topictext from $prefix"._topics." order by topicname", $dbi);
if (sql_num_rows($result, $dbi)==0) {
    include("header.php");
    include("footer.php");
}
if (sql_num_rows($result, $dbi)>0) {
    OpenTable();
    echo "<center><font class=\"option\"><b>"._ACTIVETOPICS."</b></font><br>\n"
	."<font class=\"content\">"._CLICK2LIST."</font></center><br>\n"
	."<table border=\"0\" width=\"100%\" align=\"center\" cellpadding=\"2\"><tr>\n";
    while(list($topicid, $topicname, $topicimage, $topictext) = sql_fetch_row($result, $dbi)) {
    	if ($count == 5) {
	    echo "<tr>\n";
	    $count = 0;
	}
	echo "<td align=\"center\">\n"
	    ."<a href=\"search.php?query=&amp;topic=$topicid\"><img src=\"images/topics/$topicimage\" border=\"0\" alt=\"$topictext\"></a><br>\n"
	    ."<font class=\"content\"><b>$topictext</b></font>\n"
	    ."</td>\n";
	/* Thanks to John Hoffmann from softlinux.org for the next 5 lines ;) */
	$count++;
	if ($count == 5) {
	    echo "</tr>\n";
	}
    }
    if ($count == 5) {
	echo "</table>\n";
    } else {
	echo "</tr></table>\n";
    }
} 
CloseTable();
include("footer.php");

?>