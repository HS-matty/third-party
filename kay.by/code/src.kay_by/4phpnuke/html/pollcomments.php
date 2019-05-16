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

function modone() {
	global $admin, $moderate;
	if(((isset($admin)) && ($moderate == 1)) || ($moderate==2)) echo "<form action=\"pollcomments.php\" method=\"post\">";
}

function modtwo($tid, $score, $reason) {
	global $admin, $user, $moderate, $reasons;
	if((((isset($admin)) && ($moderate == 1)) || ($moderate == 2)) && ($user)) {
		echo " | <select name=dkn$tid>";
		for($i=0; $i<sizeof($reasons); $i++) {
			echo "<option value=\"$score:$i\">$reasons[$i]</option>\n";
		}
		echo "</select>";
	}
}

function modthree($pollID, $mode, $order, $thold=0) {
	global $admin, $user, $moderate;
	if((((isset($admin)) && ($moderate == 1)) || ($moderate==2)) && ($user)) echo "<center><input type=hidden name=pollID value=$pollID><input type=hidden name=mode value=$mode><input type=hidden name=order value=$order><input type=hidden name=thold value=$thold>
	<input type=hidden name=op value=moderate>
	<input type=image src=images/menu/moderate.gif border=0></form></center>";
}

function navbar($pollID, $title, $thold, $mode, $order) {
    global $user, $bgcolor1, $bgcolor2, $textcolor1, $textcolor2, $anonpost, $pollcomm, $prefix, $dbi;
    $query = sql_query("select pollID FROM $prefix"._pollcomments." where pollID=$pollID", $dbi);
    if(!$query) $count = 0; else $count = sql_num_rows($query, $dbi);
    $result = sql_query("select pollTitle from $prefix"._poll_desc." where pollID=$pollID", $dbi);
    list($title) = sql_fetch_row($result, $dbi);
    if(!isset($thold)) $thold=0;
    echo "\n\n<!-- COMMENTS NAVIGATION BAR START -->\n\n";
    echo "<table width=\"99%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n";
    if($title) {
	echo "<tr><td bgcolor=\"$bgcolor2\" align=\"center\"><font class=\"content\" color=\"$textcolor1\">\"$title\" | ";
	    if(is_user($user)) {
		echo "<a href=\"user.php?op=editcomm\"><font color=\"$textcolor1\">"._CONFIGURE."</font></a>";
	    } else {
		echo "<a href=\"user.php\"><font color=\"$textcolor1\">"._LOGINCREATE."</font></a>";
	    }
	    if(($count==1)) {
	        echo " | <B>$count</B> "._COMMENT."</font></td></tr>\n";
	    } else {
	        echo " | <B>$count</B> "._COMMENTS."</font></td></tr>\n";
	    }
    }
    echo "<tr><td bgcolor=\"$bgcolor1\" align=\"center\" width=\"100%\">\n"
	."<table border=\"0\"><tr><td><font class=\"content\">\n"
	."<form method=\"post\" action=\"pollBooth.php?op=results&pollID=$pollID\">\n"
	."<font color=\"$textcolor2\">"._THRESHOLD."</font> <select name=\"thold\">\n"
	."<option value=\"-1\"";
    if ($thold == -1) {
	echo " selected";
    }
    echo ">-1</option>\n"
         ."<option value=\"0\"";
    if ($thold == 0) {
	echo " selected";
    }
    echo ">0</option>\n"
	 ."<option value=\"1\"";
    if ($thold == 1) {
	echo " selected";
    }
    echo ">1</option>\n"
	 ."<option value=\"2\"";
    if ($thold == 2) {
	echo " selected";
    }
    echo ">2</option>\n"
	 ."<option value=\"3\"";
    if ($thold == 3) {
	echo " selected";
    }
    echo ">3</option>\n"
	 ."<option value=\"4\"";
    if ($thold == 4) {
	echo " selected";
    }
    echo ">4</option>\n"
	 ."<option value=\"5\"";
    if ($thold == 5) {
	echo " selected";
    }
    echo ">5</option>\n"
	 ."</select> <select name=mode>"
	 ."<option value=\"nocomments\"";
    if ($mode == 'nocomments') {
	echo " selected";
    }
    echo ">"._NOCOMMENTS."</option>\n"
	 ."<option value=\"nested\"";
    if ($mode == 'nested') {
	echo " selected";
    }
    echo ">"._NESTED."</option>\n"
	 ."<option value=\"flat\"";
    if ($mode == 'flat') {
	echo " selected";
    }
    echo ">"._FLAT."</option>\n"
	 ."<option value=\"thread\"";
    if (!isset($mode) || $mode=='thread' || $mode=="") {
	echo " selected";
    }
    echo ">"._THREAD."</option>\n"
	 ."</select> <select name=\"order\">"
	 ."<option value=\"0\"";
    if (!$order) {
	echo " selected";
    }
    echo ">"._OLDEST."</option>\n"
	 ."<option value=\"1\"";
    if ($order==1) {
	echo " selected";
    }
    echo ">"._NEWEST."</option>\n"
    	 ."<option value=\"2\"";
    if ($order==2) {
	echo " selected";
    }
    echo ">"._HIGHEST."</option>\n"
	 ."</select>\n"
	 ."<input type=\"hidden\" name=\"sid\" value=\"$sid\">\n"
	 ."<input type=\"submit\" value=\""._REFRESH."\"></form>\n";
    cookiedecode($user);
    if (($pollcomm) AND ($mode != "nocomments")) {
	if ($anonpost==1 OR is_admin($admin) OR is_user($user)) {
	    echo "</font></td><td bgcolor=\"$bgcolor1\"><font class=\"content\"><form action=\"pollcomments.php\" method=\"post\">"
		."<input type=\"hidden\" name=\"pid\" value=\"$pid\">"
		."<input type=\"hidden\" name=\"pollID\" value=\"$pollID\">"
		."<input type=\"hidden\" name=\"op\" value=\"Reply\">"
		."&nbsp;&nbsp;<input type=\"submit\" value=\""._REPLYMAIN."\">";
	}
    }
    echo "</form></font></td></tr></table>\n"
	."</td></tr>"
	."<tr><td bgcolor=\"$bgcolor2\" align=\"center\"><font class=\"tiny\">"._COMMENTSWARNING."</font></td></tr>\n"
	."</table>"
	."\n\n<!-- COMMENTS NAVIGATION BAR END -->\n\n";
}

function DisplayKids ($tid, $mode, $order=0, $thold=0, $level=0, $dummy=0, $tblwidth=99) {
	global $datetime, $user, $cookie, $bgcolor1, $reasons, $anonymous, $anonpost, $commentlimit, $prefix, $dbi;
	$comments = 0;
	cookiedecode($user);
	$result = sql_query("select tid, pid, pollID, date, name, email, url, host_name, subject, comment, score, reason from $prefix"._pollcomments." where pid = $tid order by date, tid", $dbi);
	if ($mode == 'nested') {
		/* without the tblwidth variable, the tables run of the screen with netscape
		   in nested mode in long threads so the text can't be read. */
		while (list($r_tid, $r_pid, $r_pollID, $r_date, $r_name, $r_email, $r_url, $r_host_name, $r_subject, $r_comment, $r_score, $r_reason) = sql_fetch_row($result, $dbi)) {
			if($r_score >= $thold) {
				if (!isset($level)) {
				} else {
					if (!$comments) {
						echo "<ul>";
						$tblwidth -= 5;
					}
				}
				$comments++;
				if (!eregi("[a-z0-9]",$r_name)) $r_name = $anonymous;
				if (!eregi("[a-z0-9]",$r_subject)) $r_subject = "["._NOSUBJECT."]";
			// enter hex color between first two appostrophe for second alt bgcolor
				$r_bgcolor = ($dummy%2)?"":"#E6E6D2";
				echo "<a name=\"$r_tid\">";
				echo "<table width=90% border=0><tr bgcolor=\"$r_bgcolor\"><td>";
				formatTimestamp($r_date);
				if ($r_email) {
					echo "<p><b>$r_subject</b> <font class=content>";
					if(!$cookie[7]) {
						echo "("._SCORE." $r_score";
						if($r_reason>0) echo ", $reasons[$r_reason]";
						echo ")";
					}
					echo "<br>"._BY." <a href=\"mailto:$r_email\">$r_name</a> <font class=content><b>($r_email)</b></font> "._ON." $datetime";
				} else {
					echo "<p><b>$r_subject</b> <font class=content>";
					if(!$cookie[7]) {
						echo "("._SCORE." $r_score";
						if($r_reason>0) echo ", $reasons[$r_reason]";
						echo ")";
					}
					echo "<br>"._BY." $r_name "._ON." $datetime";
				}			
				if ($r_name != $anonymous) { echo "<BR>(<a href=\"user.php?op=userinfo&uname=$r_name\">"._USERINFO."</a> | <a href=\"replypmsg.php?send=1&amp;uname=$r_name\">"._SENDAMSG."</a>) "; }
				if (eregi("http://",$r_url)) { echo "<a href=\"$r_url\" target=\"window\">$r_url</a> "; }
				echo "</font></td></tr><tr><td>";
				if(($cookie[10]) && (strlen($r_comment) > $cookie[10])) echo substr("$r_comment", 0, $cookie[10])."<br><br><b><a href=\"pollcomments.php?pollID=$r_pollID&tid=$r_tid&mode=$mode&order=$order&thold=$thold\">"._READREST."</a></b>";
				elseif(strlen($r_comment) > $commentlimit) echo substr("$r_comment", 0, $commentlimit)."<br><br><b><a href=\"pollcomments.php?pollID=$r_pollID&tid=$r_tid&mode=$mode&order=$order&thold=$thold\">"._READREST."</a></b>";
				else echo $r_comment;
				echo "</td></tr></table><br><p>";
				if ($anonpost==1 OR is_admin($admin) OR is_user($user)) {
				    echo "<font class=content color=\"$bgcolor2\"> [ <a href=\"pollcomments.php?op=Reply&pid=$r_tid&pollID=$r_pollID&mode=$mode&order=$order&thold=$thold\">"._REPLY."</a>";
				}
				modtwo($r_tid, $r_score, $r_reason);
				echo " ]</font><p>";
				DisplayKids($r_tid, $mode, $order, $thold, $level+1, $dummy+1, $tblwidth);
			}
		}
	} elseif ($mode == 'flat') {
		while (list($r_tid, $r_pid, $r_pollID, $r_date, $r_name, $r_email, $r_url, $r_host_name, $r_subject, $r_comment, $r_score, $r_reason) = sql_fetch_row($result, $dbi)) {
			if($r_score >= $thold) {
				if (!eregi("[a-z0-9]",$r_name)) $r_name = $anonymous;
				if (!eregi("[a-z0-9]",$r_subject)) $r_subject = "["._NOSUBJECT."]";
				echo "<a name=\"$r_tid\">";
				echo "<hr><table width=99% border=0><tr bgcolor=\"$bgcolor1\"><td>";
				formatTimestamp($r_date);
				if ($r_email) {
					echo "<p><b>$r_subject</b> <font class=content>";
					if(!$cookie[7]) {
						echo "("._SCORE." $r_score";
						if($r_reason>0) echo ", $reasons[$r_reason]";
						echo ")";
					}
					echo "<br>"._BY." <a href=\"mailto:$r_email\">$r_name</a> <font class=content><b>($r_email)</b></font> "._ON." $datetime";
 				} else {
					echo "<p><b>$r_subject</b> <font class=content>";
					if(!$cookie[7]) {
						echo "("._SCORE." $r_score";
						if($r_reason>0) echo ", $reasons[$r_reason]";
						echo ")";
					}
					echo "<br>"._BY." $r_name "._ON." $datetime";
				}			
				if ($r_name != $anonymous) { echo "<BR>(<a href=\"user.php?op=userinfo&uname=$r_name\">"._USERINFO."</a> | <a href=\"replypmsg.php?send=1&amp;uname=$r_name\">"._SENDAMSG."</a>) "; }
				if (eregi("http://",$r_url)) { echo "<a href=\"$r_url\" target=\"window\">$r_url</a> "; }
				echo "</font></td></tr><tr><td>";
				if(($cookie[10]) && (strlen($r_comment) > $cookie[10])) echo substr("$r_comment", 0, $cookie[10])."<br><br><b><a href=\"pollcomments.php?pollID=$r_pollID&amp;tid=$r_tid&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._READREST."</a></b>";
				elseif(strlen($r_comment) > $commentlimit) echo substr("$r_comment", 0, $commentlimit)."<br><br><b><a href=\"pollcomments.php?pollID=$r_pollID&amp;tid=$r_tid&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._READREST."</a></b>";
				else echo $r_comment;
				echo "</td></tr></table><br><p><font class=content color=\"$bgcolor2\"> [ <a href=\"pollcomments.php?op=Reply&amp;pid=$r_tid&amp;pollID=$r_pollID&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._REPLY."</a>";
				modtwo($r_tid, $r_score, $r_reason);
				echo " ]</font><p>";
				DisplayKids($r_tid, $mode, $order, $thold);
			}
		}
	} else {
		while (list($r_tid, $r_pid, $r_pollID, $r_date, $r_name, $r_email, $r_url, $r_host_name, $r_subject, $r_comment, $r_score, $r_reason) = sql_fetch_row($result, $dbi)) {
			if($r_score >= $thold) {
				if (!isset($level)) {
				} else {
					if (!$comments) {
						echo "<ul>";
					}
				}
				$comments++;
				if (!eregi("[a-z0-9]",$r_name)) $r_name = $anonymous;
				if (!eregi("[a-z0-9]",$r_subject)) $r_subject = "["._NOSUBJECT."]";
				formatTimestamp($r_date);
				echo "<li><font class=\"content\"><a href=\"pollcomments.php?op=showreply&tid=$r_tid&pollID=$r_pollID&pid=$r_pid&mode=$mode&order=$order&thold=$thold#$r_tid\">$r_subject</a> "._BY." $r_name "._ON." $datetime</font><br>";

				DisplayKids($r_tid, $mode, $order, $thold, $level+1, $dummy+1);
			} 
		}
	}
	if ($level && $comments) {
		echo "</ul>";
	}

}

function DisplayBabies ($tid, $level=0, $dummy=0) {
	global $datetime, $anonymous, $prefix, $dbi;
	$comments = 0;
	$result = sql_query("select tid, pid, pollID, date, name, email, url, host_name, subject, comment, score, reason from $prefix"._pollcomments." where pid = $tid order by date, tid", $dbi);
	while (list($r_tid, $r_pid, $r_pollID, $r_date, $r_name, $r_email, $r_url, $r_host_name, $r_subject, $r_comment, $r_score, $r_reason) = sql_fetch_row($result, $dbi))
	{
		if (!isset($level)) {
		} else {
			if (!$comments) {
				echo "<ul>";
			}
		}
		$comments++;
		if (!eregi("[a-z0-9]",$r_name)) { $r_name = $anonymous; }
		if (!eregi("[a-z0-9]",$r_subject)) { $r_subject = "["._NOSUBJECT."]"; }

		formatTimestamp($r_date);
		echo "<a href=\"pollcomments.php?op=showreply&tid=$r_tid&mode=$mode&order=$order&thold=$thold\">$r_subject</a><font class=\"content\"> "._BY." $r_name "._ON." $datetime<br>";
		DisplayBabies($r_tid, $level+1, $dummy+1);
	} 
	if ($level && $comments) {
		echo "</ul>";
	}
}

function DisplayTopic ($pollID, $pid=0, $tid=0, $mode="thread", $order=0, $thold=0, $level=0, $nokids=0) {
	global $hr, $user, $datetime, $cookie, $mainfile, $admin, $commentlimit, $anonymous, $reasons, $anonpost, $foot1, $foot2, $foot3, $foot4, $prefix, $dbi;
	if($mainfile) {
		global $title, $bgcolor1, $bgcolor2, $bgcolor3;
	} else {
		global $title, $bgcolor1, $bgcolor2, $bgcolor3;
		include("mainfile.php");
		include("header.php");
	}
	if ($pid!=0) {
	    include("header.php");
	}
	$count_times = 0;
	cookiedecode($user);
	$q = "select tid, pid, pollID, date, name, email, url, host_name, subject, comment, score, reason from $prefix"._pollcomments." where pollID=$pollID and pid=$pid";
	if($thold != "") {
		$q .= " and score>=$thold";
	} else {
		$q .= " and score>=0";
	}
	if ($order==1) $q .= " order by date desc";
	if ($order==2) $q .= " order by score desc";
	$something = sql_query($q, $dbi);
	$num_tid = sql_num_rows($something, $dbi);
	navbar($pollID, $title, $thold, $mode, $order);
	modone();
	while ($count_times < $num_tid) {
		list($tid, $pid, $pollID, $date, $name, $email, $url, $host_name, $subject, $comment, $score, $reason) = sql_fetch_row($something, $dbi);
		if ($name == "") { $name = $anonymous; }
		if ($subject == "") { $subject = "["._NOSUBJECT."]"; }	

		echo "<a name=\"$tid\">";
		echo "<table width=99% border=0><tr bgcolor=\"$bgcolor1\"><td width=500>";
		formatTimestamp($date);
		if ($email) {
			echo "<p><b>$subject</b> <font class=content>";
			if(!$cookie[7]) {
				echo "("._SCORE." $score";
				if($reason>0) echo ", $reasons[$reason]";
				echo ")";
			}
			echo "<br>"._BY." <a href=\"mailto:$email\">$name</a> <b>($email)</b> "._ON." $datetime"; 
		} else {
			echo "<p><b>$subject</b> <font class=content>";
			if(!$cookie[7]) {
				echo "("._SCORE." $score";
				if($reason>0) echo ", $reasons[$reason]";
				echo ")";
			}
			echo "<br>"._BY." $name "._ON." $datetime";
		}			
		
    // If you are admin you can see the Poster IP address (you have this right, no?)
    // with this you can see who is flaming you... ha-ha-ha
		
		if ($name != $anonymous) { echo "<br>(<a href=\"user.php?op=userinfo&uname=$name\">"._USERINFO."</a> | <a href=\"replypmsg.php?send=1&amp;uname=$name\">"._SENDAMSG."</a>) "; }
		if (eregi("http://",$url)) { echo "<a href=\"$url\" target=\"window\">$url</a> "; }
		
		if(is_admin($admin)) {
		    $result= sql_query("select host_name from $prefix"._pollcomments." where tid='$tid'", $dbi);
		    list($host_name) = sql_fetch_row($result, $dbi);
		    echo "<br><b>(IP: $host_name)</b>";
		}
		
		echo "</font></td></tr><tr><td>";
		if(($cookie[10]) && (strlen($comment) > $cookie[10])) echo substr("$comment", 0, $cookie[10])."<br><br><b><a href=\"pollcomments.php?pollID=$pollID&tid=$tid&mode=$mode&order=$order&thold=$thold\">"._READREST."</a></b>";
		elseif(strlen($comment) > $commentlimit) echo substr("$comment", 0, $commentlimit)."<br><br><b><a href=\"pollcomments.php?pollID=$pollID&tid=$tid&mode=$mode&order=$order&thold=$thold\">"._READREST."</a></b>";
		else echo $comment;
		echo "</td></tr></table><br><p>";
		if ($anonpost==1 OR is_admin($admin) OR is_user($user)) {
		    echo "<font class=\"content\"> [ <a href=\"pollcomments.php?op=Reply&amp;pid=$tid&amp;pollID=$pollID&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._REPLY."</a>";
		} else {
		    echo "[ "._NOANONCOMMENTS." ";
		}
		if ($pid != 0) {
			list($erin) = sql_fetch_row(sql_query("select pid from $prefix"._pollcomments." where tid=$pid", $dbi), $dbi);
			echo "| <a href=\"pollcomments.php?pollID=$pollID&amp;pid=$erin&amp;mode=$mode&amp;order=$order&amp;thold=$thold\">"._PARENT."</a>";
		}
		modtwo($tid, $score, $reason);
		
		if(is_admin($admin)) {
		    echo " | <a href=\"admin.php?op=RemovePollComment&amp;tid=$tid&amp;pollID=$pollID\">"._DELETE."</a> ]</font><p>";
		} else {
		    echo " ]</font><p>";
		}
		
		DisplayKids($tid, $mode, $order, $thold, $level);
		echo "</ul>";
		if($hr) echo "<hr noshade size=1>";
		echo "</p>";
		$count_times += 1;
	}
	modthree($pollID, $mode, $order, $thold);
	if($pid==0) return array($pollID, $pid, $subject);
	else include("footer.php");
}

function singlecomment($tid, $pollID, $mode, $order, $thold) {
	include("header.php");
	global $user, $cookie, $datetime, $bgcolor1, $bgcolor2, $bgcolor3, $anonpost, $admin, $anonymous, $prefix, $dbi;
	$result = sql_query("select date, name, email, url, subject, comment, score, reason from $prefix"._pollcomments." where tid=$tid and pollID=$pollID", $dbi);
	list($date, $name, $email, $url, $subject, $comment, $score, $reason) = sql_fetch_row($result, $dbi);
	$titlebar = "<b>$subject</b>";
	if($name == "") $name = $anonymous;
	if($subject == "") $subject = "["._NOSUBJECT."]";
	modone();
	echo "<table width=99% border=0><tr bgcolor=\"$bgcolor1\"><td width=500>";
	formatTimestamp($date);
	if($email) echo "<p><b>$subject</b> <font class=content>("._SCORE." $score)<br>"._BY." <a href=\"mailto:$email\"><font color=\"$bgcolor2\">$name</font></a> <font class=content><b>($email)</b></font> "._ON." $datetime";
	else echo "<p><b>$subject</b> <font class=content>("._SCORE." $score)<br>"._BY." $name "._ON." $datetime";
	echo "</td></tr><tr><td>$comment</td></tr></table><br><p><font class=content color=\"$bgcolor2\"> [ <a href=\"pollcomments.php?op=Reply&pid=$tid&pollID=$pollID&mode=$mode&order=$order&thold=$thold\">"._REPLY."</a> | <a href=\"pollBooth.php?pollID=$pollID\">"._ROOT."</a>";
	modtwo($tid, $score, $reason);
	echo " ]";
	modthree($pollID, $mode, $order, $thold);
	include("footer.php");
}

function reply ($pid, $pollID, $mode, $order, $thold) {
	include("header.php");
	global $user, $cookie, $datetime, $bgcolor1, $bgcolor2, $bgcolor3, $AllowableHTML, $anonymous, $prefix, $anonpost, $dbi;
	if($pid!=0) {
		list($date, $name, $email, $url, $subject, $comment, $score) = sql_fetch_row(sql_query("select date, name, email, url, subject, comment, score from $prefix"._pollcomments." where tid=$pid", $dbi), $dbi);
	} else {
		list($subject) = sql_fetch_row(sql_query("select pollTitle FROM $prefix"._poll_desc." where pollID=$pollID", $dbi), $dbi);
	}
	if($comment == "") {
	    $comment = $temp_comment;
	}
	$titlebar = "<b>$subject</b>";
	if($name == "") $name = $anonymous;
	if($subject == "") $subject = "["._NOSUBJECT."]";
	formatTimestamp($date);
	OpenTable();
	echo "<center><font class=\"title\"><b>"._SURVEYCOM."</b></font></center>";
	CloseTable();
	echo "<br>";
	OpenTable();
	echo "<center><font class=\"content\"><b>$subject</b></center><br>";
	if ($comment == "") {
	    echo "<center><i>"._DIRECTCOM."</i></font></center><br>";
	} else {
	    echo "<br>$comment</font>";
	}
	CloseTable();
	if(!isset($pid) || !isset($pollID)) { echo "Something is not right. This message is just to keep things from messing up down the road"; exit(); }
	if($pid == 0) {
		list($subject) = sql_fetch_row(sql_query("select pollTitle from $prefix"._poll_desc." where pollID=$pollID", $dbi), $dbi);
	} else {
		list($subject) = sql_fetch_row(sql_query("select subject from $prefix"._pollcomments." where tid=$pid", $dbi), $dbi);
	}
	echo "<br>";
	OpenTable();
	echo "<form action=\"pollcomments.php\" method=\"post\">";
	echo "<font class=\"content\"><b>"._YOURNAME.":</b></font> ";
	if (is_user($user)) {
		cookiedecode($user);
		echo "<font class=\"content\"><a href=\"user.php\">$cookie[1]</a> [ <a href=\"user.php?op=logout\">"._LOGOUT."</a> ]</font>";
	} else {
		echo "<font class=\"content\">$anonymous</font>";
		$xanonpost=1;
	}
	echo "<br><br><font class=\"content\"><B>"._SUBJECT.":</B></FONT><BR>";
	if (!eregi("Re:",$subject)) $subject = "Re: ".substr($subject,0,81)."";
	echo "<INPUT TYPE=\"text\" NAME=\"subject\" SIZE=50 maxlength=85 value=\"$subject\"><BR>";
	echo "<br><br><font class=\"content\"><B>"._UCOMMENT.":</B></FONT><BR>"
		."<TEXTAREA wrap=virtual cols=50 rows=10 name=comment></TEXTAREA><br>
		<font class=\"content\">"._ALLOWEDHTML."<br>";
		while (list($key,)= each($AllowableHTML)) echo " &lt;".$key."&gt;";
		echo "<br>";
	if (is_user($user) AND ($anonpost == 1)) { echo "<INPUT type=checkbox name=xanonpost> "._POSTANON."<br>"; }
	echo "<INPUT type=\"hidden\" name=\"pid\" value=\"$pid\">"
		."<INPUT type=\"hidden\" name=\"pollID\" value=\"$pollID\">"
		."<INPUT type=\"hidden\" name=\"mode\" value=\"$mode\">"
		."<INPUT type=\"hidden\" name=\"order\" value=\"$order\">"
		."<INPUT type=\"hidden\" name=\"thold\" value=\"$thold\">"
		."<INPUT type=submit name=op value=\""._PREVIEW."\">"
		."<INPUT type=submit name=op value=\""._OK."\">"
		."<SELECT name=\"posttype\">"
		."<OPTION value=\"exttrans\">"._EXTRANS."</option>"
		."<OPTION value=\"html\" >"._HTMLFORMATED."</option>"
		."<OPTION value=\"plaintext\" SELECTED>"._PLAINTEXT."</option>"
		."</SELECT>"
		."</FORM>";
	CloseTable();
	include("footer.php");
}

function replyPreview ($pid, $pollID, $subject, $comment, $xanonpost, $mode, $order, $thold, $posttype) {
	//include("mainfile.php");
	include("header.php");
	global $user, $cookie, $AllowableHTML, $anonymous;
	cookiedecode($user);
	$subject = stripslashes($subject);
	$comment = stripslashes($comment);
	if (!isset($pid) || !isset($pollID)) {
	    echo ""._NOTRIGHT."";
	    exit();
	}
	OpenTable();
	echo "<center><font class=\"title\"><b>"._SURVEYCOMPRE."</b></font></center>";
	CloseTable();
	echo "<br>";
	OpenTable();
	echo "<b>$subject</b><br>";
	echo "<font class=content>"._BY." ";
	if (is_user($user)) {
	    echo "$cookie[1]";
	} else {
	    echo "$anonymous ";
	}
	echo ""._ONN."</font><br><br>";
	if ($posttype=="exttrans") {
	    echo nl2br(htmlspecialchars($comment));
	} elseif ($posttype=="plaintext") {
	    echo nl2br($comment);
	} else {
	    echo $comment;
	}
	CloseTable();
	echo "<br>";
	OpenTable();
	echo "<form action=\"pollcomments.php\" method=\"post\">"
	    ."<font class=\"content\"><B>"._YOURNAME.":</B></FONT> ";
	if (is_user($user)) {
	    echo "<font class=\"content\"><a href=\"user.php\">$cookie[1]</a> <font class=\"content\">[ <a href=\"user.php?op=logout\">"._LOGOUT."</a> ]</font>";
	} else {
	    echo "<font class=\"content\">$anonymous</font>";
	}
	echo "<br><br><font class=\"content\"><B>"._SUBJECT.":</B></FONT><BR>"
		."<INPUT TYPE=\"text\" name=\"subject\" size=\"50\" maxlength=\"85\" value=\"$subject\"><br><br>"
		."<P><font class=\"content\"><B>"._UCOMMENT.":</B></FONT><BR>"
		."<TEXTAREA wrap=\"virtual\" cols=\"50\" rows=\"10\" name=\"comment\">$comment</TEXTAREA><br>";
		echo"<font class=\"content\">"._ALLOWEDHTML."<br>";
		while (list($key,)= each($AllowableHTML)) echo " &lt;".$key."&gt;";
		echo "<br>";		
	if (($xanonpost) AND ($anonpost == 1)) { 
	    echo "<INPUT type=\"checkbox\" name=\"xanonpost\" checked> "._POSTANON."<br>"; 
	} elseif ((is_user($user)) AND ($anonpost == 1)) {
	    echo "<INPUT type=\"checkbox\" name=\"xanonpost\"> "._POSTANON."<br>";
	}
	echo "<INPUT type=\"hidden\" name=\"pid\" value=\"$pid\">"
		."<INPUT type=\"hidden\" name=\"pollID\" value=\"$pollID\"><INPUT type=\"hidden\" name=\"mode\" value=\"$mode\">"
		."<INPUT type=\"hidden\" name=\"order\" value=\"$order\"><INPUT type=\"hidden\" name=\"thold\" value=\"$thold\">"
		."<INPUT type=submit name=op value=\""._PREVIEW."\">"
		."<INPUT type=submit name=op value=\""._OK."\"> <SELECT name=\"posttype\"><OPTION value=\"exttrans\"";
		if($posttype=="exttrans") echo" SELECTED";
		echo  ">"._EXTRANS."<OPTION value=\"html\"";;
		if($posttype=="html") echo" SELECTED";
		echo ">"._HTMLFORMATED."<OPTION value=\"plaintext\"";
		if(($posttype!="exttrans") && ($posttype!="html")) echo" SELECTED";
		echo ">"._PLAINTEXT."</SELECT></FORM>";
    CloseTable();
    include("footer.php");
}

function CreateTopic ($xanonpost, $subject, $comment, $pid, $pollID, $host_name, $mode, $order, $thold, $posttype) {
    global $user, $userinfo, $EditedMessage, $cookie, $prefix, $pollcomm, $anonpost, $dbi;
    $author = FixQuotes($author);
    $subject = FixQuotes(filter_text($subject, "nohtml"));
    if ($posttype=="exttrans") {
    	$comment = FixQuotes(nl2br(htmlspecialchars(check_words($comment))));
    } elseif ($posttype=="plaintext") {
    	$comment = FixQuotes(nl2br(filter_text($comment)));
    } else {
    	$comment = FixQuotes(filter_text($comment));
    }
    if(is_user($user)) {
	getusrinfo($user);
    }
    if ((is_user($user)) && (!$xanonpost)) {
    	getusrinfo($user);
	$name = $userinfo[uname];
	$email = $userinfo[femail];
	$url = $userinfo[url];
	$score = 1;
    } else {
	$name = ""; $email = ""; $url = "";
	$score = 0;
    }
    $ip = getenv("REMOTE_HOST");
    if (empty($ip)) {
        $ip = getenv("REMOTE_ADDR");
    }
    $result = sql_query("select count(*) from $prefix"._poll_desc." where pollID='$pollID'", $dbi);
    $fake = sql_num_rows($result, $dbi);
    if ($fake == 1) {
	if ((($anonpost == 0) AND (is_user($user))) OR ($anonpost == 1)) {
	    sql_query("insert into $prefix"._pollcomments." values (NULL, '$pid', '$pollID', now(), '$name', '$email', '$url', '$ip', '$subject', '$comment', '$score', '0')", $dbi);
	} else {
	    echo "Nice try...";
	    die();
	}
    } else {
	include("header.php");
	echo "According to my records, the topic you are trying "
	    ."to reply to does not exist. If you're just trying to be "
	    ."annoying, well then too bad.";
	include("footer.php");
	die();
    }
    if ($pollcomm == 1) {
	if (isset($cookie[4])) { $options .= "&mode=$cookie[4]"; } else { $options .= "&mode=thread"; }
	if (isset($cookie[5])) { $options .= "&order=$cookie[5]"; } else { $options .= "&order=0"; }
	if (isset($cookie[6])) { $options .= "&thold=$cookie[6]"; } else { $options .= "&thold=0"; }
    } else {
	$options = "";
    }
    Header("Location: pollBooth.php?op=results&pollID=$pollID$options");
}

switch($op) {

	case "Reply":
		reply($pid, $pollID, $mode, $order, $thold);
		break;

	case ""._PREVIEW."":
		replyPreview ($pid, $pollID, $subject, $comment, $xanonpost, $mode, $order, $thold, $posttype);
		break;

	case ""._OK."":
		CreateTopic($xanonpost, $subject, $comment, $pid, $pollID, $host_name, $mode, $order, $thold, $posttype);
		break;

	case "moderate":
		if(isset($admin)) {
			include("auth.inc.php");
		} else {
			include("mainfile.php");	
		}
		if(($admintest==1) || ($moderate==2)) {
			while(list($tdw, $emp) = each($HTTP_POST_VARS)) {
				if (eregi("dkn",$tdw)) {
					$emp = explode(":", $emp);
					if($emp[1] != 0) {
						$tdw = ereg_replace("dkn", "", $tdw);
						$q = "UPDATE $prefix"._pollcomments." SET";
						if(($emp[1] == 9) && ($emp[0]>=0)) { # Overrated
							$q .= " score=score-1 where tid=$tdw";
						} elseif (($emp[1] == 10) && ($emp[0]<=4)) { # Underrated
							$q .= " score=score+1 where tid=$tdw";
						} elseif (($emp[1] > 4) && ($emp[0]<=4)) {
							$q .= " score=score+1, reason=$emp[1] where tid=$tdw";
						} elseif (($emp[1] < 5) && ($emp[0] > -1)) {
							$q .= " score=score-1, reason=$emp[1] where tid=$tdw";
						} elseif (($emp[0] == -1) || ($emp[0] == 5)) {
							$q .= " reason=$emp[1] where tid=$tdw";
						}
						if(strlen($q) > 20) sql_query("$q", $dbi);
					}
				}
			}
		}
		Header("Location: pollBooth.php?op=results&pollID=$pollID");
		break;

	case "showreply":
		DisplayTopic($pollID, $pid, $tid, $mode, $order, $thold);
		break;

	default:
		if ((isset($tid)) && (!isset($pid))) {
			singlecomment($tid, $pollID, $mode, $order, $thold);
		} elseif (($mainfile) xor (($pid==0) AND (!isset($pid)))) {
			Header("Location: pollBooth.php?op=results&pollID=$pollID&mode=$mode&order=$order&thold=$thold");
		} else {
			if(!isset($pid)) $pid=0;
			DisplayTopic($pollID, $pid, $tid, $mode, $order, $thold);
		}
		break;
}

?>