<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* =========================                                            */
/* Part of phpBB integration                                            */
/* Copyright (c) 2001 by                                                */
/*    Richard Tirtadji AKA King Richard (rtirtadji@hotmail.com)         */
/*    Hutdik Hermawan AKA hotFix (hutdik76@hotmail.com)                 */
/* http://www.phpnuke.web.id                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (eregi("auth.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

/* Make a database connection */

require_once("mainfile.php");

/* Code for the LastVisit cookie */

if(isset($HTTP_COOKIE_VARS["LastVisit"])) {
    $userdata["lastvisit"] = $HTTP_COOKIE_VARS["LastVisit"];
} else {
    $value = date("Y-m-d H:i");
    /* one year 'til expiry */
    $time = (time() + 3600 * 24 * 7 * 52);
    setcookie("LastVisit", $value, $time);
}

list($day, $time) = split(" ", $userdata[lastvisit]);
list($hour, $min) = split(":", $time);
$this_min = date("i");
$this_hour = date("H");
$this_day = date("Y-m-d");

/* Only set the last visit cookie if 10 mins have gone by, or its the next day or hour or something... */
/* This is kinda ugly but it works :) */
if( ($this_day > $day) || ($this_hour > $hour) || (($this_min - 10) > $min) ) {
    $value = date("Y-m-d H:i");
    $time = (time() + 3600 * 24 * 7 * 52);
    setcookie("LastVisit", $value, $time);
}

$sql = "SELECT * FROM config";

if($result = sql_query($sql, $dbi)) {
	if($myrow = sql_fetch_array($result, $dbi)) {
		$allow_html = $myrow["allow_html"]; 
		$allow_bbcode = $myrow["allow_bbcode"]; 
		$allow_sig = $myrow["allow_sig"]; 
		$posts_per_page = $myrow["posts_per_page"];
		$hot_threshold = $myrow["hot_threshold"];
		$topics_per_page = $myrow["topics_per_page"];
	}
}

?>