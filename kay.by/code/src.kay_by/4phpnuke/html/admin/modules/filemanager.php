<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* ====================                                                 */
/* Based on WebExplorer                                                 */
/* Copyright (c) 2000 by Sune Alexandersen                              */
/* http://www.suneworld.com                                             */
/* (Integration Released under GPL with the author's approval)          */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (!eregi("admin.php", $PHP_SELF)) { die ("Access Denied"); }
$hlpfile = "manual/adminblock.html";
$result = sql_query("select radminsuper from $prefix"._authors." where aid='$aid'", $dbi);
list($radminsuper) = sql_fetch_row($result, $dbi);
if ($radminsuper==1) {

function html_header(){
    global $basedir, $wdir, $lastaction, $admin, $language, $hlpfile;
    OpenTable();
    echo "<center><font class=\"title\"><b>"._FILEMANAGER."</b></font></center>";
    CloseTable();
    echo "<br>";
    OpenTable();
    echo "<center>"._CURRENTDIR.": <b>$wdir</b><br>";
    echo "[ <a href=\"admin.php?op=root\">"._BACKTOROOT."</a> | <a href=\"admin.php?op=FileManager&amp;wdir=$wdir\">"._REFRESH."</a> ]<br><br>$lastaction</center><br><br>";
}

function display_size($file){
    $file_size = filesize($file);
    if($file_size >= 1073741824) {
        $file_size = round($file_size / 1073741824 * 100) / 100 . "g";
    } elseif($file_size >= 1048576) {
        $file_size = round($file_size / 1048576 * 100) / 100 . "m";
    } elseif($file_size >= 1024) {
        $file_size = round($file_size / 1024 * 100) / 100 . "k";
    } else {
        $file_size = $file_size . "b";
    }
    return $file_size;
}

function displaydir() {
    global $basedir, $wdir, $udir, $lastaction, $bgcolor2;
    $lastaction = ""._LISTINGDIR."";
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\">";
    echo "<tr>";
    echo "<td bgcolor=\"$bgcolor2\" align=\"center\">"._TYPE."</td>";
    echo "<td bgcolor=\"$bgcolor2\" align=\"center\">"._NAME."</td>";
    echo "<td bgcolor=\"$bgcolor2\" align=\"center\">"._SIZE."</td>";
    echo "<td bgcolor=\"$bgcolor2\" align=\"center\">"._MODIFIED."</td>";
    echo "<td bgcolor=\"$bgcolor2\" align=\"center\">"._FUNCTIONS."</td>";
    echo "</tr>";
    chdir($basedir . $wdir);
    $handle=opendir(".");
    while ($file = readdir($handle)) {
	if(is_dir($file)) $dirlist[] = $file;
	if(is_file($file)) $filelist[] = $file;
    }
    closedir($handle);
    if($dirlist) {
	asort($dirlist);
	while (list ($key, $file) = each ($dirlist)) {
	    if (!($file == ".")) {
		$filename=$basedir.$wdir.$file;
		$fileurl=rawurlencode($wdir.$file);
		$lastchanged = filectime($filename);
		$changeddate = date("d-m-Y H:i:s", $lastchanged);
		echo "<tr>\n";
		if($file == "..") {
		    $downdir = dirname("$wdir");
		    echo "<td align=\"center\"><a href=\"admin.php?op=chdr&amp;file=$downdir\"><img src=\"images/admin/filemanager/parent.gif\" alt=\""._PARENTDIR."\" border=\"0\"></a></td>\n";
		    echo "<td></td>\n";
		    echo "<td align=\"right\"><font size =\"-1\">".display_size($filename)."</font>\n";
		    echo "</td><td>&nbsp;\n";
		    echo "</td><td>&nbsp;\n";
		    echo "<a href=\"admin.php?op=chdr&amp;file=$downdir\"><img src=\"images/admin/filemanager/parent.gif\" alt=\""._PARENTDIR."\" border=\"0\"></A> ";
		} else {
		    $lastchanged = filectime($filename);
		    echo "<td align=\"center\"><a href=\"admin.php?op=chdr&amp;file=$fileurl\"><img src=\"images/admin/filemanager/folder.gif\" alt=\""._CHANGEDIR." $file\" border=\"0\"></a></td>\n";
		    echo "<td><font size =\"-1\">".htmlspecialchars($file)."</font></td>\n";
		    echo "<td align=\"right\"><font size =\"-1\">".display_size($filename)."</font></td>\n";
		    echo "<td align=\"center\"><font size =\"-1\">".$changeddate."</font>\n";
		    echo "</td><td>\n";
		    echo " <a href=\"admin.php?op=move&amp;wdir=$wdir&amp;file=$fileurl\"><img src=\"images/admin/filemanager/move.gif\" alt=\""._MOVRENCP." $file\" border=\"0\"></A> \n";
		    echo " <a href=\"admin.php?op=touch&amp;wdir=$wdir&amp;touchfile=$fileurl\"><img src=\"images/admin/filemanager/touch.gif\" alt=\""._TOUCH." $file\" border=\"0\"></A> \n";
		    echo "<a href=\"admin.php?op=del&amp;wdir=$wdir&amp;file=$fileurl\"><img src=\"images/admin/filemanager/delete.gif\" alt=\""._DELETE." $file\" border=\"0\"></A> \n";
		}
	    }
	}
    }
    if($filelist) {
	asort($filelist);
	while (list ($key, $file) = each ($filelist)) {
	    if (ereg(".gif|.jpg",$file)) {
		$icon = "<IMG src=\"images/admin/filemanager/image.gif\" alt=\""._IMAGE."\" border=\"0\">";
		$browse = "1";
		$raw = "0";
		$image = "1";
	    } elseif (ereg(".txt",$file)) {
		$icon = "<IMG src=\"images/admin/filemanager/text.gif\" alt=\""._TEXT."\" border=\"0\">";
		$browse = "1";
		$raw = "1";
		$image = "0";
	    } elseif (ereg(".wav|.mp2|.mp3|.mp4|.vqf|.midi",$file)) {
		$icon = "<IMG src=\"images/admin/filemanager/audio.gif\" alt=\""._AUDIO."\" border=\"0\">";
		$browse = "1";
		$raw = "0";
		$image = "0";
	    } elseif (ereg(".phps|.php|.php2|.php3|.php4|.asp|.asa|.cgi|.pl|.shtml",$file)) {
		$icon = "<IMG src=\"images/admin/filemanager/webscript.gif\" alt=\""._WEBPROGRAM."\" border=\"0\">";
		$browse = "1";
		$raw = "1";
		$image = "0";
	    } elseif (ereg(".htaccess",$file)) {
		$icon = "<IMG src=\"images/admin/filemanager/security.gif\" alt=\""._APACHESET."\" border=\"0\">" ;
		$browse = "0";
		$raw = "1";
		$image = "0";
	    } elseif (ereg(".html|.htm",$file))	{
		$icon = "<IMG src=\"images/admin/filemanager/webpage.gif\" alt=\""._WEBPAGE."\" border=\"0\">";
		$browse = "1";
		$raw = "1";
		$image = "0";
	    } else { 
		$icon = "<IMG src=\"images/admin/filemanager/text.gif\" alt=\""._UNKOWNFT."\" border=\"0\">";
		$browse = "1";
		$raw = "1";
		$image = "0";
	    }
	    $filename=$basedir.$wdir.$file;
	    $fileurl=rawurlencode($wdir.$file);
	    $fileurl2=rawurlencode($udir.$wdir.$file);
	    $lastchanged = filectime($filename);
	    $changeddate = date("d-m-Y H:i:s", $lastchanged);
	    echo "<tr>";
	    echo "<td align=\"center\">";
	    if($raw == "1") {
		echo "<a href=\"admin.php?op=show&amp;wdir=$wdir&amp;file=$fileurl\">";
	    }
	    if($image == "1") {
		echo "<a href=\"admin.php?op=show&amp;wdir=$wdir&amp;file=$fileurl&amp;image=$image\">";
	    }
	    echo "$icon</td>\n";
	    echo "<td><font size =\"-1\">".htmlspecialchars($file)."</font></td>\n";
	    echo "<td align=\"right\"><font size =\"-1\">".display_size($filename)."</font></td>";
	    echo "<td align=\"center\"><font size =\"-1\">".$changeddate."</font>";
	    echo "</td><td>";
	    echo " <a href=\"admin.php?op=move&amp;wdir=$wdir&amp;file=$fileurl\"><img src=\"images/admin/filemanager/move.gif\" alt=\""._MOVRENCP." $file\" border=\"0\"></A> ";
	    echo " <a href=\"admin.php?op=touch&amp;wdir=$wdir&amp;touchfile=$fileurl\"><img src=\"images/admin/filemanager/touch.gif\" alt=\""._TOUCH." $file\" border=\"0\"></A> ";
	    echo "<a href=\"admin.php?op=del&amp;wdir=$wdir&amp;file=$fileurl\"><img src=\"images/admin/filemanager/delete.gif\" alt=\""._DELETE." $file\" border=\"0\"></A> ";
	    if($browse == "1") {
		echo " <a href=\"$wdir$file\"><img src=\"images/admin/filemanager/browse.gif\" alt=\""._BROWSE."\" border=\"0\"></a> ";
	    }
	    if($raw =="1") {
		echo " <a href=\"admin.php?op=edit&amp;wdir=$wdir&amp;file=$fileurl\"><img src=\"images/admin/filemanager/edit.gif\" alt=\""._EDIT."\" border=\"0\"></A> ";
	    }
	}
    }
    echo "</td></tr></table>";
    echo "<table border=\"0\" width=\"100%\">";
    echo "<tr><td colspan=\"2\"><hr></td>";
    echo "<tr><td><font size =\"-1\">"._UPLOADFILE."</font></td><td>";
    echo "<FORM enctype=\"multipart/form-data\" METHOD=\"POST\" ACTION=\"admin.php\">";
    echo "<input type=\"HIDDEN\" name=\"wdir\" value=\"$wdir\">";
    echo "<input name=\"userfile\" type=\"file\" size=\"40\">";
    echo "<input type=\"SUBMIT\" name=\"upload\" value=\""._OK."\"></FORM></td></tr>";
    echo "<FORM METHOD=\"POST\" ACTION=\"admin.php\">";	
    echo "<tr><td><font size =\"-1\" face=\"arial, helvetica\">"._CREATEDIR."</font></td><td>";
    echo "<input type=\"TEXT\" name=\"mkdirfile\" size=\"40\">";
    echo "<input type=\"HIDDEN\" name=\"op\" value=\"mkdir\">";
    echo "<input type=\"HIDDEN\" name=\"wdir\" value=\"$wdir\">";
    echo "<input type=\"SUBMIT\" name=\"mkdir\"  value=\""._OK."\"></FORM></td></tr>";
    echo "<FORM METHOD=\"POST\" ACTION=\"admin.php\">";
    echo "<tr><td><font size =\"-1\" face=\"arial, helvetica\">"._CREATEFILE."</font></td><td>";
    echo "<input type=\"TEXT\" name=\"file\" size=\"40\">";
    echo "<input type=\"HIDDEN\" name=\"op\" value=\"createfile\"> ";
    echo "<input type=\"checkbox\" name=\"html\" value=\"yes\"><font size =\"-2\">&nbsp;"._HTMLTEMP."</font> ";
    echo "<input type=\"HIDDEN\" name=\"wdir\" value=\"$wdir\">";
    echo "<input type=\"SUBMIT\" name=\"createfile\" value=\""._OK."\">";
    echo "</FORM></td></tr>";
    echo "</TABLE>";
    echo "<TABLE BORDER=\"0\" cellspacing=\"0\" cellpadding=\"1\" width=\"100%\">";
    echo "<tr>";
    echo "<th><font class=\"tiny\">PHP-Nuke File Manager is Based on <a href=\"http://www.suneworld.com\">WebExplorer</a> and has been integrated with the author permission.<br>The code integrated on PHP-Nuke is licensed under the GPL.</font></th>";
    echo "</tr></table>";
    CloseTable();
}

} else {
    echo "Access Denied";
}

?>