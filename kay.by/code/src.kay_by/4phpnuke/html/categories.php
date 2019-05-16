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

$index = 1;
$categories = 1;
$cat = $catid;
automated_news();

function theindex($catid) {
    global $storyhome, $httpref, $httprefmax, $topicname, $topicimage, $topictext, $datetime, $user, $cookie, $nukeurl, $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
	    $querylang = "AND (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
    } else {
	    $querylang = "";
    }
    include("header.php");
    if (isset($cookie[3])) {
	$storynum = $cookie[3];
    } else {
	$storynum = $storyhome;
    }
    sql_query("update $prefix"._stories."_cat set counter=counter+1 where catid='$catid'", $dbi);
    $result = sql_query("SELECT sid, aid, title, time, hometext, bodytext, comments, counter, topic, informant, notes FROM $prefix"._stories." where catid='$catid' $querylang ORDER BY sid DESC limit $storynum", $dbi);
    while (list($s_sid, $aid, $title, $time, $hometext, $bodytext, $comments, $counter, $topic, $informant, $notes) = sql_fetch_row($result, $dbi)) {
	$printP = "<a href=\"print.php?sid=$s_sid\"><img src=\"images/print.gif\" border=\"0\" Alt=\"".PRINTER."\" width=\"15\" height=\"11\"></a>&nbsp;";
	$sendF = "<a href=\"friend.php?op=FriendSend&sid=$s_sid\"><img src=\"images/friend.gif\" border=\"0\" Alt=\""._FRIEND."\" width=\"15\" height=\"11\"></a>";
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
	$morelink = "( ";
	$morelink .= "$story_link<b>"._READMORE."</b></a>";
	if (fullcount > 0) { $morelink .= " | $totalcount "._BYTESMORE.""; }
	if ($articlecomm == 1 AND $acomm == 0) {
	    if ($c_count == 0) { $morelink .= " | $story_link"._COMMENTSQ."</a>"; } elseif ($c_count == 1) { $morelink .= " | $story_link$c_count "._COMMENT."</a>"; } elseif ($c_count > 1) { $morelink .= " | $story_link$c_count "._COMMENTS."</a>"; }
	}
	$morelink .= " | $printP $sendF";
	$morelink .= " )";
	$sid = $s_sid;
	$selcat = sql_query("select title from $prefix"._stories."_cat where catid='$catid'", $dbi);
	list($title1) = sql_fetch_row($selcat, $dbi);
	$title = "$title1: $title";
	themeindex($aid, $informant, $datetime, $title, $counter, $topic, $hometext, $notes, $morelink, $topicname, $topicimage, $topictext);
    }
    if ($httpref==1) {
	$referer = getenv("HTTP_REFERER");
	if ($referer=="" OR ereg("unknown", $referer) OR eregi($nukeurl,$referer)) {
	} else {
    	    sql_query("insert into $prefix"._referer." values (NULL, '$referer')", $dbi);
	}
	$result = sql_query("select * from $prefix"._referer."", $dbi);
	$numrows = sql_num_rows($result, $dbi);
	if($numrows==$httprefmax) {
    	    sql_query("delete from $prefix"._referer."", $dbi);
	}
    }
    include("footer.php");
}

switch ($op) {

    case "newindex":
	if ($catid == 0 OR $catid == "") {
	    Header("Location: index.php");
	}
	theindex($catid);
    break;

    default:
    Header("Location: index.php");

}

?>