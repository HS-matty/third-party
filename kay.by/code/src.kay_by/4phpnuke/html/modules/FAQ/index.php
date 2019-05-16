<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* ======================                                               */
/* Based on Automated FAQ                                               */
/* Copyright (c) 2001 by                                                */
/*    Richard Tirtadji AKA King Richard (rtirtadji@hotmail.com)         */
/*    Hutdik Hermawan AKA hotFix (hutdik76@hotmail.com)                 */
/* http://www.phpnuke.web.id                                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (!eregi("modules.php", $PHP_SELF)) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");

function ShowFaq($id_cat, $categories) {
    global $bgcolor2, $sitename, $prefix, $dbi;
    OpenTable();
    echo"<center><font class=\"content\"><b>$sitename "._FAQ2."</b></font></center><br><br>"
	."<a name=\"top\"></a><br>" /* Bug fix : added missing closing hyperlink tag messes up display */
	.""._CATEGORY.": <a href=\"modules.php?op=modload&amp;name=FAQ&amp;file=index\">"._MAIN."</a> -> $categories"
	."<br><br>"
	."<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">"
	."<tr bgcolor=\"$bgcolor2\"><td colspan=\"2\"><font class=\"option\"><b>"._QUESTION."</b></font></td></tr><tr><td colspan=\"2\">";
    $result = sql_query("select id, id_cat, question, answer from $prefix"._faqAnswer." where id_cat='$id_cat'", $dbi);
    while(list($id, $id_cat, $question, $answer) = sql_fetch_row($result, $dbi)) {
	echo"<strong><big>&middot;</big></strong>&nbsp;&nbsp;<a href=\"#$id\">$question</a><br>";
    }
    echo "</td></tr></table>
    <br>";
}

function ShowFaqAll($id_cat) {
    global $bgcolor2, $prefix, $dbi;
    echo "<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">"
	."<tr bgcolor=\"$bgcolor2\"><td colspan=\"2\"><font class=\"option\"><b>"._ANSWER."</b></font></td></tr>";
    $result = sql_query("select id, id_cat, question, answer from $prefix"._faqAnswer." where id_cat='$id_cat'", $dbi);
    while(list($id, $id_cat, $question, $answer) = sql_fetch_row($result, $dbi)) {
	echo"<tr><td><a name=\"$id\"></a>"
	    ."<strong><big>&middot;</big></strong>&nbsp;&nbsp;<b>$question</b>"
	    ."<p align=\"justify\">$answer</p>"
	    ."[ <a href=\"#top\">"._BACKTOTOP."</a> ]"
	    ."<br><br>"
	    ."</td></tr>";
    }
    echo "</table><br><br>"
	."<div align=\"center\"><b>[ <a href=\"modules.php?op=modload&amp;name=FAQ&amp;file=index\">"._BACKTOFAQINDEX."</a> ]</b></div>";
}

if (!$myfaq) {
    global $currentlang, $multilingual;
    if ($multilingual == 1) {
    	$querylang = "WHERE flanguage='$currentlang'";
    } else {
    	$querylang = "";
    }
    include("header.php");
    OpenTable();
    echo "<center><font class=\"option\">"._FAQ2."</font></center><br><br>"
	."<table width=\"100%\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\">"
	."<tr><td bgcolor=\"$bgcolor2\"><font class=\"option\"><b>"._CATEGORIES."</b></font></td></tr><tr><td>";
    $result = sql_query("select id_cat, categories from $prefix"._faqCategories." $querylang", $dbi);
    while(list($id_cat, $categories) = sql_fetch_row($result, $dbi)) {
	$catname = urlencode($categories);
	echo"<strong><big>&middot;</big></strong>&nbsp;&nbsp;<a href=\"modules.php?op=modload&amp;name=FAQ&amp;file=index&amp;myfaq=yes&amp;id_cat=$id_cat&amp;categories=$catname\">$categories</a>";
    }
    echo "</td></tr></table>";
    CloseTable();
    include("footer.php");
} else {
    include("header.php");
    ShowFaq($id_cat, $categories);
    ShowFaqAll($id_cat);
    CloseTable();
    include("footer.php");
}

?>