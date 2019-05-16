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

if (eregi("block-Ephemerids.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

global $prefix, $multilingual, $currentlang, $dbi;

if ($multilingual == 1) {
    $querylang = "AND elanguage='$currentlang'";
} else {
    $querylang = "";
}

$today = getdate();
$eday = $today[mday];
$emonth = $today[mon];
$result = sql_query("select yid, content from $prefix"._ephem." where did='$eday' AND mid='$emonth' $querylang", $dbi);
$title = ""._EPHEMERIDS."";
$content = "<b>"._ONEDAY."</b><br>";
while(list($yid, $e_content) = sql_fetch_row($result, $dbi)) {
    if ($cnt==1) {
	$boxstuff .= "<br><br>";
    }
    $content .= "<b>$yid</b><br>";
    $content .= "$e_content";
    $cnt = 1;
}

?>