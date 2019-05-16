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

$result = sql_query("select type, var, count from $prefix"._counter." order by type desc", $dbi);
while(list($type, $var, $count) = sql_fetch_row($result, $dbi)) {
	if(($type == "total") && ($var == "hits")) {
		$total = $count;
	} elseif($type == "browser") {
		if($var == "Netscape") {
			$netscape[] = $count;
			$netscape[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "MSIE") {
			$msie[] = $count;
			$msie[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "Konqueror") {
			$konqueror[] = $count;
			$konqueror[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "Opera") {
			$opera[] = $count;
			$opera[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "Lynx") {
			$lynx[] = $count;
			$lynx[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "Bot") {
			$bot[] = $count;
			$bot[] =  substr(100 * $count / $total, 0, 5);
		} elseif(($type == "browser") && ($var == "Other")) {
			$b_other[] = $count;
			$b_other[] =  substr(100 * $count / $total, 0, 5);
		}
	} elseif($type == "os") {
		if($var == "Windows") {
			$windows[] = $count;
			$windows[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "Mac") {
			$mac[] = $count;
			$mac[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "Linux") {
			$linux[] = $count;
			$linux[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "FreeBSD") {
			$freebsd[] = $count;
			$freebsd[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "SunOS") {
			$sunos[] = $count;
			$sunos[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "IRIX") {
			$irix[] = $count;
			$irix[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "BeOS") {
			$beos[] = $count;
			$beos[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "OS/2") {
			$os2[] = $count;
			$os2[] =  substr(100 * $count / $total, 0, 5);
		} elseif($var == "AIX") {
			$aix[] = $count;
			$aix[] =  substr(100 * $count / $total, 0, 5);
		} elseif(($type == "os") && ($var == "Other")) {
			$os_other[] = $count;
			$os_other[] =  substr(100 * $count / $total, 0, 5);
		}
	}
}

if(is_user($user)) {
    if($cookie[9]=="") $cookie[9]=$Default_Theme;
    if(!$file=@opendir("themes/$cookie[9]")) {
	$ThemeSel = $Default_Theme;
    } else {
	$ThemeSel = $cookie[9];
    }
} else {
    $ThemeSel = $Default_Theme;
}

OpenTable2();
echo "<center><font class=\"option\"><b>$sitename "._STATS."</b></font><br><br>"._WERECEIVED." <b>$total</b> "._PAGESVIEWS." $startdate</center>";
CloseTable2();
echo "<br><br>";
OpenTable2();
echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\"><tr><td colspan=\"2\">\n";
echo "<center><font color=\"$textcolor2\"><b>"._BROWSERS."</b></font></center><br></td></tr>\n";
echo "<tr><td><img src=\"images/stats/explorer.gif\" border=\"0\" alt=\"\">&nbsp;MSIE: </td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Internet Explorer\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Internet Explorer\" height=\"15\" width=", $msie[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Internet Explorer\"> $msie[1] % ($msie[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/netscape.gif\" border=\"0\" alt=\"\">&nbsp;Netscape: </td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Netscape\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Netscape\" height=\"15\" width=", $netscape[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Netscape\"> $netscape[1] % ($netscape[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/opera.gif\" border=\"0\" alt=\"\">&nbsp;Opera: </td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Opera\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Opera\" height=\"15\" width=", $opera[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Opera\"> $opera[1] % ($opera[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/konqueror.gif\" border=\"0\" alt=\"\">&nbsp;Konqueror: </td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Konqueror\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Konqueror (KDE)\" height=\"15\" width=", $konqueror[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Konqueror\"> $konqueror[1] % ($konqueror[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/lynx.gif\" border=\"0\" alt=\"\">&nbsp;Lynx: </td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Lynx\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Lynx\" height=\"15\" width=", $lynx[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Lynx\"> $lynx[1] % ($lynx[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/altavista.gif\" border=\"0\" alt=\"\">&nbsp;"._SEARCHENGINES.": </td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Robots - Spiders - Buscadores\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Robots - Spiders - Buscadores\" height=\"15\" width=", $bot[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\""._BOTS."\"> $bot[1] % ($bot[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/question.gif\" border=\"0\" alt=\"\">&nbsp;"._UNKNOWN.": </td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Otros - Desconocidos\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Otros - Desconocidos\" height=\"15\" width=", $b_other[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\""._OTHER."\"> $b_other[1] % ($b_other[0])\n";
echo "</td></tr></table>";
CloseTable2();
echo "<br><br>\n";
OpenTable2();
echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\"><tr><td colspan=\"2\">\n";
echo "<center><font color=\"$textcolor2\"><b>"._OPERATINGSYS."</b></font></center><br></td></tr>\n";
echo "<tr><td><img src=\"images/stats/windows.gif\" border=\"0\" alt=\"\">&nbsp;Windows:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Windows\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Windows\" height=\"15\" width=", $windows[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Windows\"> $windows[1] % ($windows[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/linux.gif\" border=\"0\" alt=\"\">&nbsp;Linux:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Linux\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Linux\" height=\"15\" width=", $linux[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Linux\"> $linux[1] % ($linux[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/mac.gif\" border=\"0\" alt=\"\">&nbsp;Mac/PPC:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Mac/PPC\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"Mac - PPC\" height=\"15\" width=", $mac[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"Mac/PPC\"> $mac[1] % ($mac[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/bsd.gif\" border=\"0\" alt=\"\">&nbsp;FreeBSD:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"FreeBSD\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"FreeBSD\" height=\"15\" width=", $freebsd[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"FreeBSD\"> $freebsd[1] % ($freebsd[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/sun.gif\" border=\"0\" alt=\"\">&nbsp;SunOS:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"SunOS\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"SunOS\" height=\"15\" width=", $sunos[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"SunOS\"> $sunos[1] % ($sunos[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/irix.gif\" border=\"0\" alt=\"\">&nbsp;IRIX:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"SGI Irix\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"SGI Irix\" height=\"15\" width=", $irix[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"SGI Irix\"> $irix[1] % ($irix[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/be.gif\" border=\"0\" alt=\"\">&nbsp;BeOS:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"BeOS\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"BeOS\" height=\"15\" width=", $beos[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"BeOS\"> $beos[1] % ($beos[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/os2.gif\" border=\"0\" alt=\"\">&nbsp;OS/2:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"OS/2\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"OS/2\" height=\"15\" width=", $os2[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"OS/2\"> $os2[1] % ($os2[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/aix.gif\" border=\"0\" alt=\"\">&nbsp;AIX:</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"AIX\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" Alt=\"AIX\" height=\"15\" width=", $aix[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"AIX\"> $aix[1] % ($aix[0])</td></tr>\n";
echo "<tr><td><img src=\"images/stats/question.gif\" border=\"0\" alt=\"\">&nbsp;"._UNKNOWN.":</td><td><img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"Otros - Desconocidos\"><img src=\"themes/$ThemeSel/images/mainbar.gif\" ALt=\"Otros - Desconocidos\" height=\"15\" width=", $os_other[1] * 2, "><img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\""._OTHER."\"> $os_other[1] % ($os_other[0])\n";
echo "</td></tr></table>\n";
CloseTable2();
echo "<br><br>\n";

$unum = sql_num_rows(sql_query("select * from $prefix"._users."", $dbi));
$anum = sql_num_rows(sql_query("select * from $prefix"._authors."", $dbi));
$snum = sql_num_rows(sql_query("select * from $prefix"._stories."", $dbi));
$cnum = sql_num_rows(sql_query("select * from $prefix"._comments."", $dbi));
$secnum = sql_num_rows(sql_query("select * from $prefix"._sections."", $dbi));
$secanum = sql_num_rows(sql_query("select * from $prefix"._seccont."", $dbi));
$subnum = sql_num_rows(sql_query("select * from $prefix"._queue."", $dbi));
$tnum = sql_num_rows(sql_query("select * from $prefix"._topics."", $dbi));
$links = sql_num_rows(sql_query("select * from $prefix"._links_links."", $dbi));
$cat1 = sql_num_rows(sql_query("select * from $prefix"._links_categories."", $dbi));
$cat2 = sql_num_rows(sql_query("select * from $prefix"._links_subcategories."", $dbi));
$cat = $cat1+$cat2;

OpenTable2();
echo "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\" align=\"center\"><tr><td colspan=\"2\">\n";
echo "<center><font color=\"$textcolor2\"><b>"._MISCSTATS."</b></font></center><br></td></tr>\n";
echo "<tr><td><img src=\"images/stats/users.gif\" border=\"0\" alt=\"\">&nbsp;"._REGUSERS."</td><td><b>$unum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/authors.gif\" border=\"0\" alt=\"\">&nbsp;"._ACTIVEAUTHORS."</td><td><b>$anum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/news.gif\" border=\"0\" alt=\"\">&nbsp;"._STORIESPUBLISHED."</td><td><b>$snum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/topics.gif\" border=\"0\" alt=\"\">&nbsp;"._SACTIVETOPICS."</td><td><b>$tnum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/comments.gif\" border=\"0\" alt=\"\">&nbsp;"._COMMENTSPOSTED."</td><td><b>$cnum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/sections.gif\" border=\"0\" alt=\"\">&nbsp;"._SSPECIALSECT."</td><td><b>$secnum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/articles.gif\" border=\"0\" alt=\"\">&nbsp;"._ARTICLESSEC."</td><td><b>$secanum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/topics.gif\" border=\"0\" alt=\"\">&nbsp;"._LINKSINLINKS."</td><td><b>$links</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/sections.gif\" border=\"0\" alt=\"\">&nbsp;"._LINKSCAT."</td><td><b>$cat</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/waiting.gif\" border=\"0\" alt=\"\">&nbsp;"._NEWSWAITING."</td><td><b>$subnum</b></td></tr>\n";
echo "<tr><td><img src=\"images/stats/sections.gif\" border=\"0\" alt=\"\">&nbsp;"._NUKEVERSION."</td><td><b>$Version_Num</b>\n";
echo "</td></tr></table>\n";
CloseTable2();
include("footer.php");

?>