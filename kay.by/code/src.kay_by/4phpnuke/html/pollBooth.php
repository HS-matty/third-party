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

if(!isset($pollID)) {
  include ('header.php');
  pollList();
  include ('footer.php');
} elseif(isset($forwarder)) {
  pollCollector($pollID, $voteID, $forwarder);
} elseif($op == "results" && $pollID > 0) {
    include ("header.php");
    OpenTable();
    echo "<center><font class=\"title\"><b>"._CURRENTPOLLRESULTS."</b></font></center>";
    CloseTable();
    echo "<br>";
    OpenTable2();
    pollResults($pollID);
    CloseTable2();
    cookiedecode($user);
    if (($pollcomm) AND ($mode != "nocomments")) {
	echo "<br><br>";
	include("pollcomments.php");
    }
    include ("footer.php");
} elseif($voteID > 0) {
    pollCollector($pollID, $voteID);
} elseif($pollID != pollLatest()) {
    include ('header.php');
    OpenTable();
    echo "<center><font class=\"option\"><b>"._SURVEY."</b></font></center>";
    CloseTable();
    echo "<br><br>";
    echo "<table border=\"0\" align=\"center\"><tr><td>";
    pollMain($pollID);
    echo "</td></tr></table>";
    include ('footer.php');
} else {
    include ('header.php');
    OpenTable();
    echo "<center><font class=\"option\"><b>"._CURRENTSURVEY."</b></font></center>";
    CloseTable();
    echo "<br><br><table border=\"0\" align=\"center\"><tr><td>";
    pollNewest();
    echo "</td></tr></table>";
    include ('footer.php');
}

?>