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

$index = 1;
require_once("mainfile.php");

function theindex() {
    global $dbi, $storyhome, $httpref, $httprefmax, $topicname, $topicimage, $topictext, $datetime, $user, $cookie, $nukeurl, $prefix, $multilingual, $currentlang, $articlecomm;
    if ($multilingual == 1) {
	$querylang = "AND (alanguage='$currentlang' OR alanguage='')";
    } else {
	$querylang = "";
    }
    include("header.php");
    automated_news();
    message_box();
    if (isset($cookie[3])) {
	$storynum = $cookie[3];
    } else {
	$storynum = $storyhome;
    }
    $result = sql_query("SELECT sid, catid, aid, title, time, hometext, bodytext, comments, counter, topic, informant, notes, acomm FROM $prefix"._stories." WHERE (ihome='0' OR catid='0') $querylang ORDER BY sid DESC limit $storynum", $dbi);
    while (list($s_sid, $catid, $aid, $title, $time, $hometext, $bodytext, $comments, $counter, $topic, $informant, $notes, $acomm) = sql_fetch_row($result, $dbi)) {
	if ($catid > 0) {
	    list($cattitle) = sql_fetch_row(sql_query("select title from $prefix"._stories_cat." where catid='$catid'", $dbi), $dbi);
	}
	$printP = "<a href=\"print.php?sid=$s_sid\"><img src=\"images/print.gif\" border=0 Alt=\""._PRINTER."\" width=\"15\" height=\"11\"></a>&nbsp;";
	$sendF = "<a href=\"friend.php?op=FriendSend&amp;sid=$s_sid\"><img src=\"images/friend.gif\" border=0 Alt=\""._FRIEND."\" width=\"15\" height=\"11\"></a>";
	getTopics($s_sid);
	formatTimestamp($time);
	$subject = stripslashes($subject);
	$hometext = stripslashes($hometext);
	$notes = stripslashes($notes);
	$introcount = strlen($hometext);
	$fullcount = strlen($bodytext);
	$totalcount = $introcount + $fullcount;
	$c_count = $comments;
	$r_options = "";
        if (isset($cookie[4])) { $r_options .= "&amp;mode=$cookie[4]"; }
        if (isset($cookie[5])) { $r_options .= "&amp;order=$cookie[5]"; }
        if (isset($cookie[6])) { $r_options .= "&amp;thold=$cookie[6]"; }
	$story_link = "<a href=\"article.php?sid=$s_sid$options\">";
	$morelink = "(";
	if (($fullcount > 0) OR ($c_count > 0)) {
	    $morelink .= " $story_link<b>"._READMORE."</b></a> ";
	} else {
	    $morelink .= " ";
	}
	if ($fullcount > 0) { $morelink .= "| $totalcount "._BYTESMORE." | "; }
	if ($articlecomm == 1 AND $acomm == 0) {
	    if ($c_count == 0) { $morelink .= "$story_link"._COMMENTSQ."</a>"; } elseif ($c_count == 1) { $morelink .= " | $story_link$c_count "._COMMENT."</a>"; } elseif ($c_count > 1) { $morelink .= " | $story_link$c_count "._COMMENTS."</a>"; }
	}
	$morelink .= " | $printP $sendF";
	if ($catid > 0) { $morelink .= " | <a href=\"categories.php?op=newindex&amp;catid=$catid\">$cattitle</a>"; }
	$morelink .= " )";
	$sid = $s_sid;
	if ($catid != 0) {
	    $resultm = sql_query("select title from $prefix"._stories."_cat where catid='$catid'", $dbi);
	    list($title1) = sql_fetch_row($resultm, $dbi);
	    $title = "<a class =\"storycat\" href=\"categories.php?op=newindex&amp;catid=$catid\">$title1</a>: $title";
	}
	themeindex($aid, $informant, $datetime, $title, $counter, $topic, $hometext, $notes, $morelink, $topicname, $topicimage, $topictext);
    }
    if ($httpref==1) {
	$referer = getenv("HTTP_REFERER");
	if ($referer=="" OR eregi("^unknown", $referer) OR substr("$referer",0,strlen($nukeurl))==$nukeurl OR eregi("^bookmark",$referer)) {
	} else {
    	    sql_query("insert into $prefix"._referer." values (NULL, '$referer')", $dbi);
	}
	$result = sql_query("select * from $prefix"._referer."", $dbi);
	$numrows = sql_num_rows($result, $dbi);
	if($numrows>=$httprefmax) {
    	    sql_query("delete from $prefix"._referer."", $dbi);
	}
    }
    include("footer.php");
}

if ($file != "") {
    $index = 0;
    include("header.php");
    OpenTable();
    $file2 = substr($file,0,2);
    if (ereg("\.\.", $file2)) {
	$file = ereg_replace("\.\.", "", $file);
    }
    $file2 = substr($file,0,1);
    if ($file2 == "/") {
	$file = ereg_replace("/", "", $file);
    }
    if (!@file($file) OR (eregi("\.\.",$file))) {
	echo "<center><font class=\"title\">$sitename</font><br><br>"
	    ."<font class=\"content\">"._FILENOTEXIST."</font><br><br>"
	    .""._GOBACK."</center>";
    } else {
	include("counter.php");
	include("$file");
    }
    CloseTable();
    include("footer.php");
    die();
}

switch ($op) {

    default:
    theindex();

}

?>