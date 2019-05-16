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

require("auth.inc.php");
require_once("mainfile.php");
if(!isset($op)) { $op = "adminMain"; }
$adminpage = 1;

/*********************************************************/
/* Login Function                                        */
/*********************************************************/

function login() {
    include ("header.php");
    OpenTable();
    echo "<center><font class=\"title\"><b>"._ADMINLOGIN."</b></font></center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<form action=\"admin.php\" method=\"post\">"
        ."<table border=\"0\">"
	."<tr><td>"._ADMINID."</td>"
	."<td><input type=\"text\" NAME=\"aid\" SIZE=\"20\" MAXLENGTH=\"20\"></td></tr>"
	."<tr><td>"._PASSWORD."</td>"
	."<td><input type=\"password\" NAME=\"pwd\" SIZE=\"20\" MAXLENGTH=\"18\"></td></tr>"
	."<tr><td>"
	."<input type=\"hidden\" NAME=\"op\" value=\"login\">"
	."<input type=\"submit\" VALUE=\""._LOGIN."\">"
	."</td></tr></table>"
	."</form>";
    CloseTable();
    include ("footer.php");
}

function deleteNotice($id, $table, $op_back) {
    global $dbi;
    sql_query("delete from $table WHERE id = $id", $dbi);
    Header("Location: admin.php?op=$op_back");
}

/*********************************************************/
/* Administration Menu Function                          */
/*********************************************************/

function adminmenu($url, $title, $image) {
    global $counter, $admingraphic;
    if ($admingraphic == 1) {
	$img = "<img src=\"images/admin/$image\" border=\"0\" alt=\"\"></a><br>";
	$close = "";
    } else {
	$image = "";
	$close = "</a>";
    }
    echo "<td align=\"center\"><font class=\"content\"><a href=\"$url\">$img<b>$title</b>$close</font></td>";
    if ($counter == 5) {
	echo "</tr><tr>";
	$counter = 0;
    } else {
	$counter++;
    }
}

function GraphicAdmin($hlpfile) {
    global $aid, $admingraphic, $language, $admin, $banners, $prefix, $dbi;
    $result = sql_query("SELECT qid FROM $prefix"._queue."", $dbi);
    $newsubs = sql_num_rows($result, $dbi);
    $result = sql_query("select radminarticle,radmintopic,radminuser,radminsurvey,radminsection,radminlink,radminephem,radminfilem,radminfaq,radmindownload,radminreviews,radminsuper from $prefix"._authors." where aid='$aid'", $dbi);
    list($radminarticle,$radmintopic,$radminuser,$radminsurvey,$radminsection,$radminlink,$radminephem,$radminfilem,$radminfaq,$radmindownload,$radminreviews,$radminsuper) = sql_fetch_array($result, $dbi);
    OpenTable();
    echo "<center><b><a class=\"storycat\" href=\"admin.php\">"._ADMINMENU."</a></b>";
    if ($radminsuper==1) {
        echo"&nbsp;&nbsp;&nbsp;<b><a class=\"storycat\" href=\"admin.php?op=BannersAdmin\">"._BANNERSADMIN."</a></b>";
    }
    if (!$hlpfile) {
    } else {
        echo "<br><br>[ <a href=\"javascript:openwindow()\">"._ONLINEMANUAL."</a> ]</center>";
    }
    echo "<br><br>";
    echo"<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>";
    $linksdir = dir("admin/links");
    while($func=$linksdir->read()) {
        if(substr($func, 0, 6) == "links.") {
    	    $menulist .= "$func ";
	}
    }
    closedir($linksdir->handle);
    $menulist = explode(" ", $menulist);
    sort($menulist);
    for ($i=0; $i < sizeof($menulist); $i++) {
	if($menulist[$i]!="") {
	    $counter = 0;
	    include($linksdir->path."/$menulist[$i]");
	}
    }
    adminmenu("admin.php?op=logout", ""._ADMINLOGOUT."", "exit.gif");
    echo"</tr></table></center>";
    CloseTable();
    echo "<br>";
}

/*********************************************************/
/* Administration Main Function                          */
/*********************************************************/

function adminMain() {
    global $language, $hlpfile, $admin, $aid, $prefix, $file, $dbi;
    $hlpfile = "manual/admin.html";
    include ("header.php");
    $dummy = 0;
    GraphicAdmin($hlpfile);
    $result2 = sql_query("select radminarticle, radminsuper, admlanguage from $prefix"._authors." where aid='$aid'", $dbi);
    list($radminarticle, $radminsuper, $admlanguage) = sql_fetch_row($result2, $dbi);
    if ($admlanguage != "" ) {
	$queryalang = "WHERE alanguage='$admlanguage' ";
	$queryplang = "WHERE planguage='$admlanguage' ";
    } else {
	$queryalang = "";
	$queryplang = "WHERE planguage='$language' ";
    }
    OpenTable();
    echo "<center><b>"._AUTOMATEDARTICLES."</b></center><br>";
    $count = 0;
    $result = sql_query("select anid, aid, title, time, alanguage from $prefix"._autonews." $queryalang order by time ASC", $dbi);
    while(list($anid, $said, $title, $time, $alanguage) = sql_fetch_row($result, $dbi)) {
	if ($alanguage == "") {
	    $alanguage = ""._ALL."";
	}
	if ($anid != "") {
	    if ($count == 0) {
		echo "<table border=\"1\" width=\"100%\">";
		$count = 1;
	    }
	    $time = ereg_replace(" ", "@", $time);
	    if (($radminarticle==1) OR ($radminsuper==1)) {
		if (($radminarticle==1) AND ($aid == $said) OR ($radminsuper==1)) {
    		    echo "<tr><td nowrap>&nbsp;(<a href=\"admin.php?op=autoEdit&amp;anid=$anid\">"._EDIT."</a>-<a href=\"admin.php?op=autoDelete&amp;anid=$anid\">"._DELETE."</a>)&nbsp;</td><td width=\"100%\">&nbsp;$title&nbsp;</td><td align=\"center\">&nbsp;$alanguage&nbsp;</td><td nowrap>&nbsp;$time&nbsp;</td></tr>"; /* Multilingual Code : added column to display language */
		} else {
		    echo "<tr><td>&nbsp;("._NOFUNCTIONS.")&nbsp;</td><td width=\"100%\">&nbsp;$title&nbsp;</td><td align=\"center\">&nbsp;$alanguage&nbsp;</td><td nowrap>&nbsp;$time&nbsp;</td></tr>"; /* Multilingual Code : added column to display language */
		}
	    } else {
		echo "<tr><td width=\"100%\">&nbsp;$title&nbsp;</td><td align=\"center\">&nbsp;$alanguage&nbsp;</td><td nowrap>&nbsp;$time&nbsp;</td></tr>"; /* Multilingual Code : added column to display language */
	    }
	}
    }
    if (($anid == "") AND ($count == 0)) {
	echo "<center><i>"._NOAUTOARTICLES."</i></center>";
    }
    if ($count == 1) {
        echo "</table>";
    }
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<center><b>"._LAST." 20 "._ARTICLES."</b></center><br>";
    $result = sql_query("select sid, aid, title, time, topic, informant, alanguage from $prefix"._stories." $queryalang order by time desc limit 0,20", $dbi);
    echo "<center><table border=\"1\" width=\"100%\" bgcolor=\"$bgcolor1\">";
    while(list($sid, $said, $title, $time, $topic, $informant, $alanguage) = sql_fetch_row($result, $dbi)) {
	$ta = sql_query("select topicname from $prefix"._topics." where topicid=$topic", $dbi);
	list($topicname) = sql_fetch_row($ta, $dbi);
	if ($alanguage == "") {
	    $alanguage = ""._ALL."";
	}
	formatTimestamp($time);
	echo "<tr><td align=\"right\"><b>$sid</b>"
	    ."</td><td align=\"left\" width=\"100%\"><a href=\"article.php?sid=$sid\">$title</a>"
	    ."</td><td align=\"center\">$alanguage"
	    ."</td><td align=\"right\">$topicname";
	if (($radminarticle==1) OR ($radminsuper==1)) {
	    if (($radminarticle==1) AND ($aid == $said) OR ($radminsuper==1)) {
		echo "</td><td align=\"right\" nowrap>(<a href=\"admin.php?op=EditStory&sid=$sid\">"._EDIT."</a>-<a href=\"admin.php?op=RemoveStory&sid=$sid\">"._DELETE."</a>)"
		    ."</td></tr>";
	    } else {
		echo "</td><td align=\"right\" nowrap><font class=\"content\"><i>("._NOFUNCTIONS.")</i></font>"
		    ."</td></tr>";
	    }
	} else {
	    echo "</td></tr>";
	}
    }
    echo "
    </table>";
    if (($radminarticle==1) OR ($radminsuper==1)) {
	echo "<center>
	<form action=\"admin.php\" method=\"post\">
	"._STORYID.": <input type=\"text\" NAME=\"sid\" SIZE=\"10\">
	<select name=\"op\">
	<option value=\"EditStory\" SELECTED>"._EDIT."</option>
	<option value=\"RemoveStory\">"._DELETE."</option>
	</select>
	<input type=\"submit\" value=\""._GO."\">
	</form></center>";
    }
    CloseTable();
    $result = sql_query("SELECT pollID, pollTitle, timeStamp FROM $prefix"._poll_desc." $queryplang ORDER BY pollID DESC limit 1", $dbi);
    $object = sql_fetch_object($result, $dbi);
    $pollID = $object->pollID;
    $pollTitle = $object->pollTitle;
    echo "<br>";
    OpenTable();
    echo "<center><b>"._CURRENTPOLL.":</b> $pollTitle [ <a href=\"admin.php?op=polledit&pollID=$pollID\">"._EDIT."</a> | <a href=\"admin.php?op=create\">"._ADD."</a> ]</center>";
    CloseTable();
    include ("footer.php");
}

if ((isset($file)) AND ($file != "none") AND ($admintest == 1)) {
    $updir = "images/articles";
    @copy($file, "$updir/$file_name");
}

if ($admintest == 1) {
    $basedir = dirname($SCRIPT_FILENAME);
    $textrows = 20;
    $textcols = 85;
    $udir = dirname($PHP_SELF);
    if(!$wdir) $wdir="/";
    if($cancel) $op="FileManager";
    if($upload) {
	copy($userfile,$basedir.$wdir.$userfile_name);
	$lastaction = ""._UPLOADED." $userfile_name --> $wdir";
	$wdir2="/";
	chdir($basedir . $wdir2);
	Header("Location: admin.php?op=FileManager");
	exit;
    }
}

if($admintest) {

    switch($op) {

	case "deleteNotice":
	deleteNotice($id, $table, $op_back);
	break;

	case "GraphicAdmin":
        GraphicAdmin($hlpfile);
        break;

	case "adminMain":
	adminMain();
	break;

	case "logout":
	setcookie("admin");
	include("header.php");
	OpenTable();
	echo "<center><font class=\"title\"><b>"._YOUARELOGGEDOUT."</b></font></center>";
	CloseTable();
	include("footer.php");
	break;

	case "login";
	unset($op);

	default:
	$casedir = dir("admin/case");
	while($func=$casedir->read()) {
	    if(substr($func, 0, 5) == "case.") {
		include($casedir->path."/$func");
	    }
	}
	closedir($casedir->handle);
	break;

	}

} else {

    login();

}

?>