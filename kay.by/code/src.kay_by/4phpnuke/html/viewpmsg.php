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

require_once("mainfile.php");
include('functions.php');
include('auth.php');

if (!is_user($user)) {
    Header("Location: user.php");
} else {	
    include('header.php');
    $user = base64_decode($user);
    $userdata = explode(":", $user);
    if (!$result = check_user_pw($userdata[1],$userdata[2],$system))
    $userdata = get_userdata($userdata[1]);
    $sql = "SELECT * FROM $prefix"._priv_msgs." WHERE (to_userid = $userdata[uid])";
    $resultID = sql_query($sql, $dbi);
    if (!$resultID) {
	forumerror(0005);
    }
    OpenTable();
    echo "<center><font class=\"option\"><b>"._PRIVATEMESSAGES."</b></font></center>";
    CloseTable();
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" align=\"center\" valign=\"top\" width=\"100%\"><tr><td>"
	."<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\">"
	."<form name=\"prvmsg\" method=\"get\" action=\"replypmsg.php\">"
	."<tr bgcolor=\"$bgcolor2\" align=\"left\">"
	."<td bgcolor=\"$bgcolor2\" align=\"center\" valign=\"middle\"><input name=\"allbox\" onclick=\"CheckAll();\" type=\"checkbox\" value=\""._CHECKALL."\"></td>"
	."<td bgcolor=\"$bgcolor2\" align=\"center\" valign=\"middle\"><img src=\"images/forum/download.gif\" border=\"0\" alt=\""._MSGSTATUS."\"></td>"
	."<td bgcolor=\"$bgcolor2\" align=\"center\" valign=\"middle\">&nbsp;</td>"
	."<td><font class=\"content\" color=\"$textcolor2\"><b>"._FROM."</b></font></td>"
	."<td align=\"center\"><font class=\"content\" color=\"$textcolor\"><b>"._SUBJECT."</b></font></td>"
	."<td align=\"center\"><font class=\"content\" color=\"$textcolor2\"><b>"._DATE."</b></font></td>"
	."</tr>";
	if (!$total_messages = sql_num_rows($resultID, $dbi)) {
	    echo "<td bgcolor=\"$bgcolor3\" colspan=\"6\" align=\"center\">"._DONTHAVEMESSAGES."</td></tr>\n";
	} else {
	    $display=1;
	}
	$count=0;
	while ($myrow = sql_fetch_array($resultID, $dbi)) {
	    echo "<tr align=\"left\">";
	    echo "<td bgcolor=\"$bgcolor1\" valign=\"top\" width=\"2%\" align=\"center\"><input type=\"checkbox\" onclick=\"CheckCheckAll();\" name=\"msg_id[$count]\" value=\"$myrow[msg_id]\"></td>";
	    if ($myrow[read_msg] == "1") {
		echo "<td valign=\"top\" width=\"5%\" align=\"center\" bgcolor=\"$bgcolor1\">&nbsp;</td>";
	    } else {
		echo "<td valign=\"top\" width=\"5%\" align=\"center\" bgcolor=\"$bgcolor1\"><img src=\"images/forum/read.gif\" border=\"0\" alt=\""._NOTREAD."\"></td>";
	    }
	    echo "<td bgcolor=\"$bgcolor3\" valign=\"top\" width=\"5%\" align=\"center\"><img src=\"images/forum/subject/$myrow[msg_image]\" border=\"0\"></td>";
	    $posterdata = get_userdata_from_id($myrow[from_userid]);
	    echo "<td bgcolor=\"$bgcolor1\" valign=\"middle\" width=\"10%\"><a href=\"readpmsg.php?start=$count&total_messages=$total_messages\">$posterdata[uname]</a></td>"
		."<td bgcolor=\"$bgcolor3\" valign=\"middle\"><font class=\"tiny\" color=\"$textcolor2\">$myrow[subject]</font></td>"
		."<td bgcolor=\"$bgcolor1\" valign=\"middle\" align=\"center\" width=\"20%\"><font class=\"tiny\" color=\"$textcolor2\">$myrow[msg_time]</font></td></tr>";
	    $count++;
	}
	if ($display) {
	echo "<tr bgcolor=\"$bgcolor2\" align=\"left\">";
	echo "<td colspan=6 align='left'><a href='replypmsg.php?send=1'><img src='images/forum/icons/send.gif' border=0></a>&nbsp;<input type='image' src='images/forum/icons/delete.gif' name='delete_messages' value='delete_messages' border='0'></td></tr>";
	echo "<input type='hidden' name='total_messages' value='$total_messages'>";
	echo "</form>";
	}
	else {
	echo "<tr bgcolor=\"$bgcolor2\" align=\"left\">";
	echo "<td colspan=6 align='left'><a href='replypmsg.php?send=1'><IMG SRC='images/forum/icons/send.gif' border=0></a></td></tr>";
	echo "</form>";
	}
    echo "</table></td></tr></table>
    <script type=\"text/javascript\">\n\n
    <!--\n\n
    function CheckAll() {\n
	for (var i=0;i<document.prvmsg.elements.length;i++) {\n
	    var e = document.prvmsg.elements[i];\n
	    if ((e.name != 'allbox') && (e.type=='checkbox'))\n
	    e.checked = document.prvmsg.allbox.checked;\n
	}\n
    }\n\n

    function CheckCheckAll() {\n
	var TotalBoxes = 0;\n
	var TotalOn = 0;\n
	for (var i=0;i<document.prvmsg.elements.length;i++) {\n
	    var e = document.prvmsg.elements[i];\n
	    if ((e.name != 'allbox') && (e.type=='checkbox')) {\n
		TotalBoxes++;\n
		if (e.checked) {\n
		    TotalOn++;\n
		}\n
	    }\n
	}\n
	if (TotalBoxes==TotalOn) {\n
	    document.prvmsg.allbox.checked=true;\n
	} else {\n
	    document.prvmsg.allbox.checked=false;\n
	}\n
    }\n\n

    -->\n
    </script>\n\n";
}
include('footer.php');

?>