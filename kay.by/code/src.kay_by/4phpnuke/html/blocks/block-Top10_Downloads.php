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

if (eregi("block-Top10_Downloads.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

global $prefix, $dbi;

$a = 1;
$result = sql_query("select lid, title from $prefix"._downloads_downloads." order by hits DESC limit 0,10", $dbi);
while(list($lid, $title) = sql_fetch_row($result, $dbi)) {
    $title2 = ereg_replace("_", " ", $title);
    $content .= "<strong><big>&middot;</big></strong>&nbsp;$a: <a href=\"modules.php?name=Downloads&amp;d_op=viewdownloaddetails&amp;lid=$lid&amp;title=$title\">$title2</a><br>";
    $a++;
}

?>