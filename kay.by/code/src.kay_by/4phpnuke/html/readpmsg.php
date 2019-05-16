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

include_once("mainfile.php");

include('functions.php');
include('auth.php');

if (!is_user($user)) {
    Header("Location: user.php");
} else {	
    include('header.php');
    $user = base64_decode($user);
    $userdata = explode(":", $user);
    if (!$result = check_user_pw($userdata[1],$userdata[2],$db,$system))
    $userdata = get_userdata($userdata[1], $db);
    $sql = "SELECT * FROM $prefix"._priv_msgs." WHERE to_userid = '$userdata[uid]' LIMIT $start,1";
    $resultID = sql_query($sql, $dbi);
    if (!$resultID) {
	forumerror(0005);
    } else {
	$myrow = sql_fetch_array($resultID, $dbi);
	$sql = "UPDATE $prefix"._priv_msgs." SET read_msg='1' WHERE msg_id='$myrow[msg_id]'";
	$result = sql_query($sql, $dbi);
	    if (!$result) {
	        forumerror(0005);
	    }
    }
    OpenTable();
    echo "<center><font class=\"title\"><b>"._PRIVATEMESSAGE."</b></font><br><br><font class=\"content\">[ <a href=\"viewpmsg.php\">"._INDEX."</a> | <i>$myrow[subject]</i> ]</font></center>";
    CloseTable();
    echo "<br>"
	."<table border=\"0\" cellpadding=\"1\" cellpadding=\"0\" valign=\"top\" width=\"100%\"><tr><td>"
	."<table border=\"0\" cellpadding=\"3\" cellpadding=\"1\" width=\"100%\">"
	."<tr bgcolor=\"$bgcolor2\" align=\"left\">"
	."<td width=\"20%\" colspan=\"2\" align=\"center\"><font class=\"tiny\" color=\"$textcolor2\"><b>"._FROM."</b></font></td>"
	."</tr>";

    if (!sql_num_rows($resultID, $dbi)) {
	echo "<td bgcolor=\"$bgcolor3\" colspan=\"2\" align=\"center\">"._DONTHAVEMESSAGES."</td></tr>\n";
    } else {
	echo "<tr bgcolor=\"$bgcolor3\" align=\"left\">\n";
	$posterdata = get_userdata_from_id($myrow[from_userid], $db);
	echo "<td valign=\"top\"><b>$posterdata[uname]</b><br><br>\n";
	if ($posterdata[user_from] != "") {
	    echo "<font class=\"content\">"._FROM.": $posterdata[user_from]</font><br><br>\n";
	}
	if ($posterdata[user_avatar] != "")
	echo "<img src='images/forum/avatar/$posterdata[user_avatar]' alt=\"\">\n"
	    ."</td><td><img src=\"images/forum/subject/$myrow[msg_image]\" alt=\"\">&nbsp;<font class=\"content\">"._SENT.": $myrow[msg_time]</font>&nbsp;&nbsp;&nbsp"
	    ."<hr noshade><b>$myrow[subject]</b><br><br>\n";
	$message = stripslashes($myrow[msg_text]);
	$message = eregi_replace("\[addsig]", "<br>-----------------<br>" . bbencode($posterdata[user_sig]), $message);
	echo $message . "<br><br>"
	    ."<hr noshade>\n"
	    ."&nbsp;&nbsp<a href=\"user.php?op=userinfo&uname=$posterdata[uname]\"><img src=\"images/forum/icons/profile.gif\" border=\"0\" alt=\"\"></a><font class=\"tiny\">"._PROFILE."</font>\n";
	if($posterdata["femail"] != 0) 
	    echo "&nbsp;&nbsp;<a href=\"mailto:$posterdata[femail]\"><IMG SRC=\"images/forum/icons/email.gif\" border=\"0\" alt=\"\"></a><font class=\"tiny\">"._EMAIL."</font>\n";
	if($posterdata["url"] != '') {
	    if(strstr("http://", $posterdata["url"])) {
		$posterdata["url"] = "http://" . $posterdata["url"];
	    }
	    echo "&nbsp;&nbsp;<a href=\"$posterdata[url]\" TARGET=\"_blank\"><IMG SRC=\"images/forum/icons/www_icon.gif\" border=0 Alt=\"\"></a><font class=tiny>www</font>\n";
	}
	if($posterdata["user_icq"] != '')
	    echo "&nbsp;&nbsp;<a href=\"http://wwp.mirabilis.com/$posterdata[icq]\" TARGET=\"_blank\"><IMG SRC=\"http://wwp.icq.com/scripts/online.dll?icq=$posterdata[user_icq]&img=5\" border=0\" Alt=\"\"></a>";
	if($posterdata["user_aim"] != '')
     	    echo "&nbsp;<a href=\"aim:goim?screenname=$posterdata[user_aim]&message=Hi+$posterdata[user_aim].+Are+you+there?\"><img src=\"images/forum/icons/aim.gif\" border=\"0\" Alt=\"\"></a><font class=tiny>aim</font>";
	if($posterdata["user_yim"] != '')
     	    echo "&nbsp;<a href=\"http://edit.yahoo.com/config/send_webmesg?.target=$posterdata[user_yim]&.src=pg\"><img src=\"images/forum/icons/yim.gif\" border=\"0\" Alt=\"\"></a>";
	if($posterdata["user_msnm"] != '')
     	    echo "&nbsp;<a href=\"bb_profile.php?userid=$posterdata[uid]\"><img src=\"images/forum/icons/msnm.gif\" border=\"0\" Alt=\"\"></a>";
	echo "</td></tr>"
	    ."<tr bgcolor=\"$bgcolor1\" align=\"RIGHT\"><td width=20% COLSPAN=2 align=RIGHT><font color=\"$textcolor2\" SIZE=1>";
	$previous = $start-1;
	$next = $start+1;
	if ($previous >= 0) {
	    echo "<a href=\"readpmsg.php?start=$previous&total_messages=$total_messages\">"._PREVIOUSMESSAGE."</a> | ";
	} else {
	    echo ""._PREVIOUSMESSAGE." | ";
	}
	if ($next < $total_messages) {
	    echo "<a href=\"readpmsg.php?start=$next&total_messages=$total_messages\">"._NEXTMESSAGE."</a></font>";
	} else {
	    echo ""._NEXTMESSAGE."</font>";
	}	
	echo "</td></tr>"
	    ."<tr bgcolor=\"$bgcolor2\" align=\"left\"><td width=\"20%\" COLSPAN=\"2\" align=\"left\">"
	    ."<font color=\"$textcolor2\">"
	    ."<a href=\"replypmsg.php?reply=1&msg_id=$myrow[msg_id]\"><img src=\"images/forum/icons/reply.gif\" border=\"0\" alt=\"\"></a>\n"
	    ."&nbsp;<a href=\"replypmsg.php?delete=1&msg_id=$myrow[msg_id]\"><img src=\"images/forum/icons/delete.gif\" border=0 alt=\"\"></a>\n";
    }
    echo "</font></td></tr></table></td></tr></table>";
}
include('footer.php');

?>