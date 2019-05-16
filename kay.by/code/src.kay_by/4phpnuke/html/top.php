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

global $multilingual, $currentlang;
    if ($multilingual == 1) {
    $queryalang = "WHERE (alanguage='$currentlang' OR alanguage='')"; /* top stories */
    $queryslang = "WHERE slanguage='$currentlang' "; /* top section articles */
    $queryplang = "WHERE planguage='$currentlang' "; /* top polls */
    $queryrlang = "WHERE rlanguage='$currentlang' "; /* top reviews */
    } else {
    $queryalang = "";
    $queryslang = "";
    $queryplang = "";
    $queryrlang = "";
    }

include("header.php");
OpenTable();
echo "<center><font class=\"title\"><b>"._TOPWELCOME." $sitename!</b></font></center>";
CloseTable();
echo "<br>\n\n";
OpenTable();

/* Top 10 read stories */

$result = sql_query("select sid, title, time, counter from $prefix"._stories." $queryalang order by counter DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
        ."<font class=\"option\"><b>$top "._READSTORIES."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($sid, $title, $time, $counter) = sql_fetch_row($result, $dbi)) {
        if($counter>0) {
    	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"article.php?sid=$sid\">$title</a> - ($counter "._READS.")<br>\n";
	    $lugar++;
	}
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 commented stories */

$result = sql_query("select sid, title, comments from $prefix"._stories." $queryalang order by comments DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._COMMENTEDSTORIES."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($sid, $title, $comments) = sql_fetch_row($result, $dbi)) {
	if($comments>0) {
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"article.php?sid=$sid\">$title</a> - ($comments "._COMMENTS.")<br>\n";
	    $lugar++;
	}
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 categories */

$result = sql_query("select catid, title, counter from $prefix"._stories."_cat order by counter DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._ACTIVECAT."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($catid, $title, $counter) = sql_fetch_row($result, $dbi)) {
	if($counter>0) {
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"categories.php?op=newindex&amp;catid=$catid\">$title</a> - ($counter "._HITS.")<br>\n";
	    $lugar++;
	}
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 articles in special sections */

$result = sql_query("select artid, secid, title, content, counter from $prefix"._seccont." $queryslang order by counter DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._READSECTION."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($artid, $secid, $title, $content, $counter) = sql_fetch_row($result, $dbi)) {
        echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"sections.php?op=viewarticle&amp;artid=$artid\">$title</a> - ($counter "._READS.")<br>\n";
	$lugar++;
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 users submitters */

$result = sql_query("select uname, counter from $prefix"._users." where counter > '0' order by counter DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._NEWSSUBMITTERS."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($uname, $counter) = sql_fetch_row($result, $dbi)) {
	if($counter>0) {
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"user.php?op=userinfo&amp;uname=$uname\">$uname</a> - ($counter "._NEWSSENT.")<br>\n";
	    $lugar++;
	}
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 Polls */

$result = sql_query("select * from $prefix"._poll_desc." $queryplang", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._VOTEDPOLLS."</b></font><br><br><font class=\"content\">\n";
    $lugar = 1;
    $result = sql_query("select pollID, pollTitle, voters from $prefix"._poll_desc." $queryplang order by voters DESC limit 0,$top", $dbi);
    while(list($pollID, $pollTitle, $voters) = sql_fetch_row($result, $dbi)) {
	for($i = 0; $i < 12; $i++) {
	    $result2 = sql_query("SELECT optionCount FROM $prefix"._poll_data." WHERE (pollID=$pollID) AND (voteID=$i)", $dbi);
	    $object = sql_fetch_object($result2, $dbi);
	    $optionCount = $object->optionCount;
	    $sum = (int)$sum+$optionCount;
	}
	if($sum>0) {
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"pollBooth.php?op=results&amp;pollID=$pollID\">$pollTitle</a> - ("._VOTES." $voters)<br>\n";
	    $lugar++;
	}
	$sum = 0;
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 authors */

$result = sql_query("select aid, counter from $prefix"._authors." order by counter DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._MOSTACTIVEAUTHORS."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($aid, $counter) = sql_fetch_row($result, $dbi)) {
	if($counter>0) {
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"search.php?query=&amp;author=$aid\">$aid</a> - ($counter "._NEWSPUBLISHED.")<br>\n";
	    $lugar++;
	}
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 reviews */

$result = sql_query("select id, title, hits from $prefix"._reviews." $queryrlang order by hits DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._READREVIEWS."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($id, $title, $hits) = sql_fetch_row($result, $dbi)) {
	if($hits>0) {
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"reviews.php?op=showcontent&amp;id=$id\">$title</a> - ($hits "._READS.")<br>\n";
	    $lugar++;
	}
    }
    echo "</font></td></tr></table><br>\n";
}

/* Top 10 downloads */

$result = sql_query("select lid, cid, title, hits from $prefix"._downloads_downloads." order by hits DESC limit 0,$top", $dbi);
if (sql_num_rows($result, $dbi)>0) {
    echo "<table border=\"0\" cellpadding=\"10\" width=\"100%\"><tr><td align=\"left\">\n"
	."<font class=\"option\"><b>$top "._DOWNLOADEDFILES."</b></font><br><br><font class=\"content\">\n";
    $lugar=1;
    while(list($lid, $cid, $title, $hits) = sql_fetch_row($result, $dbi)) {
	if($hits>0) {
	    $res = sql_query("select title from $prefix"._downloads_categories." where cid='$cid'", $dbi);
	    list($ctitle) = sql_fetch_row($res, $dbi);
	    $utitle = ereg_replace(" ", "_", $title);
	    echo "<strong><big>&middot;</big></strong>&nbsp;$lugar: <a href=\"modules.php?name=Downloads&amp;d_op=viewdownloaddetails&amp;lid=$lid&amp;ttitle=$utitle\">$title</a> ("._CATEGORY.": $ctitle) - ($hits "._DOWNLOADS.")<br>\n";
	    $lugar++;
	}
    }
    echo "</font></td></tr></table>\n\n";
}

CloseTable();
include("footer.php");

?>