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

if (eregi("mainfile.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

require_once("config.php");
require_once("includes/sql_layer.php");
$dbi = sql_connect($dbhost, $dbuname, $dbpass, $dbname);
$mainfile = 1;

if (isset($newlang)) {
    if (file_exists("language/lang-$newlang.php")) {
	setcookie("lang",$newlang,time()+31536000);
	include("language/lang-$newlang.php");
	$currentlang = $newlang;
    } else {
	setcookie("lang",$language,time()+31536000);
	include("language/lang-$language.php");
	$currentlang = $language;
    }
} elseif (isset($lang)) {
    include("language/lang-$lang.php");
    $currentlang = $lang;
} else {
    setcookie("lang",$language,time()+31536000);
    include("language/lang-$language.php");
    $currentlang = $language;
}

function is_admin($admin) {
    global $prefix, $dbi;
    if(!is_array($admin)) {
	$admin = base64_decode($admin);
	$admin = explode(":", $admin);
        $aid = "$admin[0]";
	$pwd = "$admin[1]";
    } else {
        $aid = "$admin[0]";
	$pwd = "$admin[1]";
    }
    $result = sql_query("select pwd from $prefix"._authors." where aid='$aid'", $dbi);
    list($pass) = sql_fetch_row($result, $dbi);
    if($pass == $pwd && $pass != "") {
	return 1;
    }
    return 0;
}

function is_user($user) {
    global $prefix, $dbi;
    if(!is_array($user)) {
	$user = base64_decode($user);
	$user = explode(":", $user);
        $uid = "$user[0]";
	$pwd = "$user[2]";
    } else {
        $uid = "$user[0]";
	$pwd = "$user[2]";
    }
    $result = sql_query("select pass from $prefix"._users." where uid='$uid'", $dbi);
    list($pass) = sql_fetch_row($result, $dbi);
    if($pass == $pwd && $pass != "") {
	return 1;
    }
    return 0;
}

function blocks($side) {
    global $storynum, $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
    	$querylang = "AND (blanguage='$currentlang' OR blanguage='')";
    } else {
    	$querylang = "";
    }
    if (strtolower($side[0]) == "l") {
	$pos = "l";
    } elseif (strtolower($side[0]) == "r") {
	$pos = "r";
    }
    $result = sql_query("select bid, bkey, title, content, url, blockfile from $prefix"._blocks." where position='$pos' AND active='1' $querylang ORDER BY weight ASC", $dbi);
    while(list($bid, $bkey, $title, $content, $url, $blockfile) = sql_fetch_row($result, $dbi)) {
	if ($bkey == main) {
	    mainblock();
	} elseif ($bkey == online) {
	    online();
	} elseif ($bkey == admin) {
	    adminblock();
	} elseif ($bkey == poll) {
	    pollNewest();
	} elseif ($bkey == past) {
	    oldNews($storynum);
	} elseif ($bkey == big) {
	    bigstory();
	} elseif ($bkey == login) {
	    loginbox();
	} elseif ($bkey == modules) {
	    modules_block();
	} elseif ($bkey == search) {
	    searchbox();
	} elseif ($bkey == category) {
	    category();
	} elseif ($bkey == random) {
	    randombox();
	} elseif ($bkey == userbox) {
	    userblock();
	} elseif ($bkey == thelang) {
	    selectlanguage();
	} elseif ($bkey == "") {
	    if ($url == "") {
		if ($blockfile == "") {
		    themesidebox($title, $content);
		} else {
		    blockfileinc($title, $blockfile);
		}
	    } else {
		headlines($bid);
	    }
	}
    }
}

function message_box() {
    global $bgcolor1, $bgcolor2, $user, $admin, $cookie, $textcolor2, $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
	$querylang = "AND (mlanguage='$currentlang' OR mlanguage='')";
    } else {
	$querylang = "";
    }
    $result = sql_query("select mid, title, content, date, expire, view from $prefix"._message." where active='1' $querylang", $dbi);
    if (sql_num_rows($result, $dbi) == 0) {
	return;
    } else {
	while (list($mid, $title, $content, $mdate, $expire, $view) = sql_fetch_row($result, $dbi)) {
	if ($title != "" && $content != "") {
	    if ($expire == 0) {
		$remain = _UNLIMITED;
	    } else {
		$etime = (($mdate+$expire)-time())/3600;
		$etime = (int)$etime;
		if ($etime < 1) {
		    $remain = _EXPIRELESSHOUR;
		} else {
		    $remain = ""._EXPIREIN." $etime "._HOURS."";
		}
	    }
	    if ($view == 4 AND is_admin($admin)) {
                OpenTable();
                echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center>\n"
		    ."<font class=\"content\">$content</font>"
		    ."<br><br><center><font class=\"content\">[ "._MVIEWADMIN." - $remain - <a href=\"admin.php?op=editmsg&mid=$mid\">"._EDIT."</a> ]</font></center>";
		CloseTable();
		echo "<br>";
	    } elseif ($view == 3 AND !is_user($user) || is_admin($admin)) {
                OpenTable();
                echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center>\n"
		    ."<font class=\"content\">$content</font>";
		if (is_admin($admin)) {
		    echo "<br><br><center><font class=\"content\">[ "._MVIEWANON." - $remain - <a href=\"admin.php?op=editmsg&mid=$mid\">"._EDIT."</a> ]</font></center>";
		}
    		CloseTable();
		echo "<br>";
	    } elseif ($view == 2 AND is_user($user) || is_admin($admin)) {
                OpenTable();
                echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center>\n"
		    ."<font class=\"content\">$content</font>";
		if (is_admin($admin)) {
		    echo "<br><br><center><font class=\"content\">[ "._MVIEWUSERS." - $remain - <a href=\"admin.php?op=editmsg&mid=$mid\">"._EDIT."</a> ]</font></center>";
		}
		CloseTable();
		echo "<br>";
	    } elseif ($view == 1) {
                OpenTable();
                echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center>\n"
		    ."<font class=\"content\">$content</font>";
		if (is_admin($admin)) {
		    echo "<br><br><center><font class=\"content\">[ "._MVIEWALL." - $remain - <a href=\"admin.php?op=editmsg&mid=$mid\">"._EDIT."</a> ]</font></center>";
		}
		CloseTable();
		echo "<br>";
	    }
	    if ($expire != 0) {
	    	$past = time()-$expire;
		if ($mdate < $past) {
		    $result = sql_query("update $prefix"._message." set active='0' where mid='$mid'", $dbi);
		}
		}
	    }
	}
    }
}

function blockfileinc($title, $blockfile) {
    $blockfiletitle = $title;
    $file = @file("blocks/$blockfile");
    if (!$file) {
	$content = _BLOCKPROBLEM;
    } else {
	include("blocks/$blockfile");
    }
    if ($content == "") {
	$content = _BLOCKPROBLEM2;
    }
    themesidebox($blockfiletitle, $content);
}

function selectlanguage() {
    global $useflags, $currentlang;
    if ($useflags == 1) {
    $title = _SELECTLANGUAGE;
    $content = "<center><font class=\"content\">"._SELECTGUILANG."<br><br>";
    $langdir = dir("language");
    while($func=$langdir->read()) {
	if(substr($func, 0, 5) == "lang-") {
    	    $menulist .= "$func ";
	}
    }
    closedir($langdir->handle);
    $menulist = explode(" ", $menulist);
    sort($menulist);
    for ($i=0; $i < sizeof($menulist); $i++) {
        if($menulist[$i]!="") {
	    $tl = ereg_replace("lang-","",$menulist[$i]);
	    $tl = ereg_replace(".php","",$tl);
	    $altlang = ucfirst($tl);
	    $content .= "<a href=\"index.php?newlang=$tl\"><img src=\"images/language/flag-$tl.png\" border=\"0\" alt=\"$altlang\" hspace=\"3\" vspace=\"3\"></a> ";
	}
    }
    $content .= "</font></center>";
    themesidebox($title, $content);
	} else {
    $title = _SELECTLANGUAGE;
	$content = "<center><font class=\"content\">"._SELECTGUILANG."<br><br></font>";
    $content .= "<form action=\"index.php\" method=\"get\"><select name=\"newlanguage\" onChange=\"top.location.href=this.options[this.selectedIndex].value\">";
	    $handle=opendir('language');
	    while ($file = readdir($handle)) {
		if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
	            $langFound = $matches[1];
	            $languageslist .= "$langFound ";
	        }
	    }
	    closedir($handle);
	    $languageslist = explode(" ", $languageslist);
	    sort($languageslist);
	    for ($i=0; $i < sizeof($languageslist); $i++) {
		if($languageslist[$i]!="") {
	$content .= "<option value=\"index.php?newlang=$languageslist[$i]\" ";
		if($languageslist[$i]==$currentlang) $content .= " selected";
	$content .= ">".ucfirst($languageslist[$i])."</option>\n";
		}
    }
    $content .= "</select></form></center>";
    themesidebox($title, $content);
	}
}

function randombox() {
    global $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
	    $querylang = "AND (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
    } else {
	    $querylang = "";
    }
    $result = sql_query("select * from $prefix"._topics."", $dbi);
    $numrows = sql_num_rows($result, $dbi);
    $numrows = $numrows-1;
    mt_srand((double)microtime()*1000000);
    $topic = mt_rand(0, $numrows);
    $result = sql_query("select sid, title from $prefix"._stories." where topic='$topic' $querylang order by sid DESC limit 0,9", $dbi);
    $content = "<font class=\"content\">";
    $res = sql_query("select topictext from $prefix"._topics." where topicid='$topic'", $dbi);
    list($topictext) = sql_fetch_row($res, $dbi);
    $title2 = "<a href=\"search.php?topic=$topic\">$topictext</a>";
    while(list($sid, $title) = sql_fetch_row($result, $dbi)) {
	$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"article.php?sid=$sid\">$title</a><br>";
    }
    $content .= "</font>";
    themesidebox($title2, $content);
}

function ultramode() {
    global $prefix, $dbi;
    $ultra = "ultramode.txt";
    $file = fopen("$ultra", "w");
    fwrite($file, "General purpose self-explanatory file with news headlines\n");
    $rfile=sql_query("select sid, aid, title, time, comments, topic from $prefix"._stories." order by time DESC limit 0,10", $dbi);
    while(list($sid, $aid, $title, $time, $comments, $topic) = sql_fetch_row($rfile, $dbi)) {
	$rfile2=sql_query("select topictext, topicimage from $prefix"._topics." where topicid=$topic", $dbi);
	list($topictext, $topicimage) = sql_fetch_row($rfile2, $dbi);
	$content = "%%\n$title\n/article.php?sid=$sid\n$time\n$aid\n$topictext\n$comments\n$topicimage\n";
	fwrite($file, $content);
    }
    fclose($file);
}

function cookiedecode($user) {
    global $cookie, $prefix, $dbi;
    $user = base64_decode($user);
    $cookie = explode(":", $user);
    $result = sql_query("select pass from $prefix"._users." where uname='$cookie[1]'", $dbi);
    list($pass) = sql_fetch_row($result, $dbi);
    if ($cookie[2] == $pass && $pass != "") {
	return $cookie;
    } else {
	unset($user);
	unset($cookie);
    }
}

function getusrinfo($user) {
    global $userinfo, $user_prefix, $dbi;
    $user2 = base64_decode($user);
    $user3 = explode(":", $user2);
    $result = sql_query("select uid, name, uname, email, femail, url, user_avatar, user_icq, user_occ, user_from, user_intrest, user_sig, user_viewemail, user_theme, user_aim, user_yim, user_msnm, pass, storynum, umode, uorder, thold, noscore, bio, ublockon, ublock, theme, commentmax, newsletter from $user_prefix"._users." where uname='$user3[1]' and pass='$user3[2]'", $dbi);
    if (sql_num_rows($result, $dbi) == 1) {
    	$userinfo = sql_fetch_array($result, $dbi);
    }
    return $userinfo;
}

function searchblock() {
    OpenTable();
    echo "<form action=\"searchbb.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"addterm\" value=\"any\">";
    echo "<input type=\"hidden\" name=\"sortby\" value=\"p.post_time\">";
    echo "&nbsp;&nbsp;<b>"._SEARCH."</b>&nbsp;<input type=\"text\" name=\"term\" size=\"15\">";
    echo "<input type=\"hidden\" name=\"submit\" value=\"submit\"></form>";
    echo "<div align=\"left\"><font class=\"content\">&nbsp;&nbsp;[ <a href=\"searchbb.php?addterm=any&amp;sortby=p.post_time&amp;adv=1\">Advanced Search</a> ]</font></div>";
    CloseTable();
}

function searchbox() {
    $title = ""._SEARCH."";
    $content = "<form action=\"search.php\" method=\"get\">";
    $content .= "<br><center><input type=\"text\" name=\"query\" size=\"14\"></center>";
    $content .= "</form>";
    themesidebox($title, $content);
}

function FixQuotes ($what = "") {
	$what = ereg_replace("'","''",$what);
	while (eregi("\\\\'", $what)) {
		$what = ereg_replace("\\\\'","'",$what);
	}
	return $what;
}

/*********************************************************/
/* text filter                                           */
/*********************************************************/

function check_words($Message) {
    global $EditedMessage;
    include("config.php");
    $EditedMessage = $Message;
    if ($CensorMode != 0) {

	if (is_array($CensorList)) {
	    $Replace = $CensorReplace;
	    if ($CensorMode == 1) {
		for ($i = 0; $i < count($CensorList); $i++) {
		    $EditedMessage = eregi_replace("$CensorList[$i]([^a-zA-Z0-9])","$Replace\\1",$EditedMessage);
		}
	    } elseif ($CensorMode == 2) {
		for ($i = 0; $i < count($CensorList); $i++) {
		    $EditedMessage = eregi_replace("(^|[^[:alnum:]])$CensorList[$i]","\\1$Replace",$EditedMessage);
		}
	    } elseif ($CensorMode == 3) {
		for ($i = 0; $i < count($CensorList); $i++) {
		    $EditedMessage = eregi_replace("$CensorList[$i]","$Replace",$EditedMessage);
		}
	    }
	}
    }
    return ($EditedMessage);
}

function delQuotes($string){
    /* no recursive function to add quote to an HTML tag if needed */
    /* and delete duplicate spaces between attribs. */
    $tmp="";    # string buffer
    $result=""; # result string
    $i=0;
    $attrib=-1; # Are us in an HTML attrib ?   -1: no attrib   0: name of the attrib   1: value of the atrib
    $quote=0;   # Is a string quote delimited opened ? 0=no, 1=yes
    $len = strlen($string);
    while ($i<$len) {
	switch($string[$i]) { # What car is it in the buffer ?
	    case "\"": #"       # a quote.
		if ($quote==0) {
		    $quote=1;
		} else {
		    $quote=0;
		    if (($attrib>0) && ($tmp != "")) { $result .= "=\"$tmp\""; }
		    $tmp="";
		    $attrib=-1;
		}
		break;
	    case "=":           # an equal - attrib delimiter
		if ($quote==0) {  # Is it found in a string ?
		    $attrib=1;
		    if ($tmp!="") $result.=" $tmp";
		    $tmp="";
		} else $tmp .= '=';
		break;
	    case " ":           # a blank ?
		if ($attrib>0) {  # add it to the string, if one opened.
		    $tmp .= $string[$i];
		}
		break;
	    default:            # Other
		if ($attrib<0)    # If we weren't in an attrib, set attrib to 0
		$attrib=0;
		$tmp .= $string[$i];
		break;
	}
	$i++;
    }
    if (($quote!=0) && ($tmp != "")) {
	if ($attrib==1) $result .= "=";
	/* If it is the value of an atrib, add the '=' */
	$result .= "\"$tmp\"";  /* Add quote if needed (the reason of the function ;-) */
    }
    return $result;
}

function check_html ($str, $strip="") {
    /* The core of this code has been lifted from phpslash */
    /* which is licenced under the GPL. */
    include("config.php");
    if ($strip == "nohtml")
    	$AllowableHTML=array('');
	$str = stripslashes($str);
	$str = eregi_replace("<[[:space:]]*([^>]*)[[:space:]]*>",
                         '<\\1>', $str);
               // Delete all spaces from html tags .
	$str = eregi_replace("<a[^>]*href[[:space:]]*=[[:space:]]*\"?[[:space:]]*([^\" >]*)[[:space:]]*\"?[^>]*>",
                         '<a href="\\1">', $str); # "
               // Delete all attribs from Anchor, except an href, double quoted.
	$str = eregi_replace("<img?",
                         '', $str); # "
	$tmp = "";
	while (ereg("<(/?[[:alpha:]]*)[[:space:]]*([^>]*)>",$str,$reg)) {
		$i = strpos($str,$reg[0]);
		$l = strlen($reg[0]);
		if ($reg[1][0] == "/") $tag = strtolower(substr($reg[1],1));
		else $tag = strtolower($reg[1]);
		if ($a = $AllowableHTML[$tag])
			if ($reg[1][0] == "/") $tag = "</$tag>";
			elseif (($a == 1) || ($reg[2] == "")) $tag = "<$tag>";
			else {
			  # Place here the double quote fix function.
			  $attrb_list=delQuotes($reg[2]);
			  // A VER
			  $attrb_list = ereg_replace("&","&amp;",$attrb_list);
			  $tag = "<$tag" . $attrb_list . ">";
			} # Attribs in tag allowed
		else $tag = "";
		$tmp .= substr($str,0,$i) . $tag;
		$str = substr($str,$i+$l);
	}
	$str = $tmp . $str;
	return $str;
	exit;
	/* Squash PHP tags unconditionally */
	$str = ereg_replace("<\?","",$str);
	return $str;
}

function filter_text($Message, $strip="") {
    global $EditedMessage;
    check_words($Message);
    $EditedMessage=check_html($EditedMessage, $strip);
    return ($EditedMessage);
}

/*********************************************************/
/* formatting stories                                    */
/*********************************************************/

function formatTimestamp($time) {
    global $datetime, $locale;
    setlocale ("LC_TIME", "$locale");
    ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);
    $datetime = strftime(""._DATESTRING."", mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));
    $datetime = ucfirst($datetime);
    return($datetime);
}

function formatAidHeader($aid) {
    global $prefix, $dbi;
    $holder = sql_query("SELECT url, email FROM $prefix"._authors." where aid='$aid'", $dbi);
    if (!$holder) {
    	echo _ERROR;
	exit();
    }
    list($url, $email) = sql_fetch_row($holder, $dbi);
    if (isset($url)) {
	$aid = "<a href=\"$url\">$aid</a>";
    } elseif (isset($email)) {
	$aid = "<a href=\"mailto:$email\">$aid</a>";
    } else {
	$aid = $aid;
    }
    return($aid);
}

function oldNews($storynum) {
    global $locale, $oldnum, $storyhome, $cookie, $categories, $cat, $prefix, $multilingual, $currentlang, $dbi;
	if ($multilingual == 1) {
		if ($categories == 1) {
	    	$querylang = "where catid='$cat' AND (alanguage='$currentlang' OR alanguage='')";
		} else {
	    	$querylang = "where (alanguage='$currentlang' OR alanguage='')";
		}
    } else {
    	if ($categories == 1) {
		   	$querylang = "where catid='$cat'";
    	} else {
	    	$querylang = "";
		}
    }
    $storynum = $storyhome;
    $boxstuff = "<font class=\"content\">";
    $boxTitle = _PASTARTICLES;
    $result = sql_query("select sid, title, time, comments from $prefix"._stories." $querylang order by time desc limit $storynum, $oldnum", $dbi);
    $vari = 0;
    if (isset($cookie[4])) {
	$options .= "&amp;mode=$cookie[4]";
    } else {
	$options .= "&amp;mode=thread";
    }
    if (isset($cookie[5])) {
	$options .= "&amp;order=$cookie[5]";
    } else {
	$options .= "&amp;order=0";
    }
    if (isset($cookie[6])) {
	$options .= "&amp;thold=$cookie[6]";
    } else {
	$options .= "&amp;thold=0";
    }
    while(list($sid, $title, $time, $comments) = sql_fetch_row($result, $dbi)) {
	$see = 1;
	setlocale ("LC_TIME", "$locale");
	ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime2);
	$datetime2 = strftime(""._DATESTRING2."", mktime($datetime2[4],$datetime2[5],$datetime2[6],$datetime2[2],$datetime2[3],$datetime2[1]));
	$datetime2 = ucfirst($datetime2);
	if($time2==$datetime2) {
	    $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"article.php?sid=$sid$options\">$title</a> ($comments)<br>\n";
	} else {
	    if($a=="") {
		$boxstuff .= "<b>$datetime2</b><br><br><strong><big>&middot;</big></strong>&nbsp;<a href=\"article.php?sid=$sid$options\">$title</a> ($comments)<br>\n";
		$time2 = $datetime2;
		$a = 1;
	    } else {
		$boxstuff .= "<br><br><b>$datetime2</b><br><br><strong><big>&middot;</big></strong>&nbsp;<a href=\"article.php?sid=$sid$options\">$title</a> ($comments)<br>\n";
		$time2 = $datetime2;
	    }
	}
	$vari++;
	if ($vari==$oldnum) {
	    if (isset($cookie[3])) {
		$storynum = $cookie[3];
	    } else {
		$storynum = $storyhome;
	    }
	    $min = $oldnum + $storynum;
	    $boxstuff .= "<br><br><a href=\"search.php?min=$min&amp;type=stories&amp;category=$cat\"><b>"._OLDERARTICLES."</b></a>\n";
	}
    }
    $boxstuff .= "</font>";
    if ($see == 1) {
	themesidebox($boxTitle, $boxstuff);
    }
}

function themepreview($title, $hometext, $bodytext="", $notes="") {
    echo "<b>$title</b><br><br>$hometext";
    if ($bodytext != "") {
	echo "<br><br>$bodytext";
    }
    if ($notes != "") {
	echo "<br><br><b>"._NOTE."</b> <i>$notes</i>";
    }
}

function mainblock() {
    global $prefix, $dbi;
    $result = sql_query("select title, content from $prefix"._blocks." where bkey='main'", $dbi);
    list($title, $content) = sql_fetch_row($result, $dbi);
    $content = "<font class=\"content\">$content</font>";
    themesidebox($title, $content);
}

function category() {
    global $cat, $language, $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
	    $querylang = "AND (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
    } else {
	    $querylang = "";
    }
    $result = sql_query("select catid, title from $prefix"._stories."_cat order by title", $dbi);
    $numrows = sql_num_rows($result, $dbi);
    if ($numrows == 0) {
	return;
    } else {
	$boxstuff = "<font class=\"content\">";
	while(list($catid, $title) = sql_fetch_row($result, $dbi)) {
	    $result2 = sql_query("select * from $prefix"._stories." where catid='$catid' $querylang", $dbi);
	    $numrows = sql_num_rows($result2, $dbi);
	    if ($numrows > 0) {
		$res = sql_query("select time from $prefix"._stories." where catid='$catid' $querylang order by sid DESC limit 0,1", $dbi);
		list($time) = sql_fetch_row($res, $dbi);
		ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $dat);
		if ($cat == $catid) {
		    $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<b>$title</b><br>";
		} else {
		    $boxstuff .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"categories.php?op=newindex&amp;catid=$catid\">$title</a> <font class=tiny>($dat[2]/$dat[3])</font><br>";
		}
	    }
	}
	$boxstuff .= "</font>";
	$title = _CATEGORIES;
	themesidebox($title, $boxstuff);
    }
}

function modules_block() {
    global $prefix, $dbi, $admin;
    
    /* If the module doesn't exist, it will be removed from the database automaticaly */

    $result = sql_query("select title from $prefix"._modules."", $dbi);
    while (list($title) = sql_fetch_row($result, $dbi)) {
	$a = 0;
	$handle=opendir('modules');
	while ($file = readdir($handle)) {
    	    if ($file == $title) {
		$a = 1;
	    }
	}
	closedir($handle);
	if ($a == 0) {
    	    sql_query("delete from $prefix"._modules." where title='$title'", $dbi);
	}
    }

    /* Now we make the Modules block with the correspondent links */

    $result = sql_query("select title from $prefix"._modules." where active='1' ORDER BY title ASC", $dbi);
    while(list($m_title) = sql_fetch_row($result, $dbi)) {
	$m_title2 = ereg_replace("_", " ", $m_title);
	$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$m_title\">$m_title2</a><br>\n";
    }

    /* If you're Admin you and only you can see Inactive modules and test it */
    /* If you copied a new module is the /modules/ directory , it will be added to the database */

    if (is_admin($admin)) {
	$handle=opendir('modules');
	while ($file = readdir($handle)) {
	    if ( (!ereg("[.]",$file)) ) {
		$modlist .= "$file ";
	    }
	}
	closedir($handle);
	$modlist = explode(" ", $modlist);
	sort($modlist);
	for ($i=0; $i < sizeof($modlist); $i++) {
	    if($modlist[$i] != "") {
		$result = sql_query("select mid from $prefix"._modules." where title='$modlist[$i]'", $dbi);
		list ($mid) = sql_fetch_row($result, $dbi);
		if ($mid == "") {
		    sql_query("insert into $prefix"._modules." values (NULL, '$modlist[$i]', '0', '0')", $dbi);
		}
	    }
	}
	$content .= "<br><center><b>"._NOACTIVEMODULES."</b><br>";
	$content .= "<font class=\"tiny\">"._FORADMINTESTS."</font></center><br>";
	$result = sql_query("select title from $prefix"._modules." where active='0' ORDER BY title ASC", $dbi);
	while(list($mn_title) = sql_fetch_row($result, $dbi)) {
	    $mn_title2 = ereg_replace("_", " ", $mn_title);
	    $content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"modules.php?name=$mn_title\">$mn_title2</a><br>\n";
	    $a = 1;
	}
	if ($a != 1) {
    	    $content .= "<strong><big>&middot;</big></strong>&nbsp;<i>"._NONE."</i><br>\n";
	}
    }
    $title = _MODULES;
    themesidebox($title, $content);
}

function adminblock() {
    global $admin, $prefix, $dbi;
    if (is_admin($admin)) {
	$result = sql_query("select title, content from $prefix"._blocks." where bkey='admin'", $dbi);
	while(list($title, $content) = sql_fetch_array($result, $dbi)) {
	    $content = "<font class=\"content\">$content</font>";
	    themesidebox($title, $content);
	}
	$title = ""._WAITINGCONT."";
	$result = sql_query("select * from $prefix"._queue."", $dbi);
	$num = sql_num_rows($result, $dbi);
	$content = "<font class=\"content\">";
	$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"admin.php?op=submissions\">"._SUBMISSIONS."</a>: $num<br>";
	$result = sql_query("select * from $prefix"._reviews."_add", $dbi);
	$num = sql_num_rows($result, $dbi);
	$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"admin.php?op=reviews\">"._WREVIEWS."</a>: $num<br>";
	$result = sql_query("select * from $prefix"._links_newlink."", $dbi);
	$num = sql_num_rows($result, $dbi);
	$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"admin.php?op=links\">"._WLINKS."</a>: $num<br>";
	$result = sql_query("select * from $prefix"._downloads_newdownload."", $dbi);
	$num = sql_num_rows($result, $dbi);
	$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"admin.php?op=downloads\">"._UDOWNLOADS."</a>: $num<br></font>";
	themesidebox($title, $content);
    }
}

function loginbox() {
    global $user;
    if (!is_user($user)) {
	$title = _LOGIN;
	$boxstuff = "<form action=\"user.php\" method=\"post\">";
	$boxstuff .= "<center><font class=\"content\">"._NICKNAME."<br>";
	$boxstuff .= "<input type=\"text\" name=\"uname\" size=\"8\" maxlength=\"25\"><br>";
	$boxstuff .= ""._PASSWORD."<br>";
	$boxstuff .= "<input type=\"password\" name=\"pass\" size=\"8\" maxlength=\"20\"><br>";
	$boxstuff .= "<input type=\"hidden\" name=\"op\" value=\"login\">";
	$boxstuff .= "<input type=\"submit\" value=\""._LOGIN."\"></font></center></form>";
	$boxstuff .= "<center><font class=\"content\">"._ASREGISTERED."</font></center>";
	themesidebox($title, $boxstuff);
    }
}

function userblock() {
    global $user, $cookie, $prefix, $dbi;
    if((is_user($user)) AND ($cookie[8])) {
	$getblock = sql_query("select ublock from $prefix"._users." where uid='$cookie[0]'", $dbi);
	$title = ""._MENUFOR." $cookie[1]";
	list($ublock) = sql_fetch_row($getblock, $dbi);
	themesidebox($title, $ublock);
    }
}

/*********************************************************/
/* poll functions                                        */
/*********************************************************/

function pollMain($pollID) {
    global $boxTitle, $boxContent, $pollcomm, $user, $cookie, $prefix, $dbi;
    if(!isset($pollID))
	$pollID = 1;
    if(!isset($url))
	$url = sprintf("pollBooth.php?op=results&amp;pollID=%d", $pollID);
    $boxContent .= "<form action=\"pollBooth.php\" method=\"post\">";
    $boxContent .= "<input type=\"hidden\" name=\"pollID\" value=\"".$pollID."\">";
    $boxContent .= "<input type=\"hidden\" name=\"forwarder\" value=\"".$url."\">";
    $result = sql_query("SELECT pollTitle, voters FROM $prefix"._poll_desc." WHERE pollID=$pollID", $dbi);
    list($pollTitle, $voters) = sql_fetch_row($result, $dbi);
    $boxTitle = _SURVEY;
    $boxContent .= "<font class=\"content\"><b>$pollTitle</b></font><br><br>\n";
    $boxContent .= "<table border=\"0\" width=\"100%\">";
    for($i = 1; $i <= 12; $i++) {
	$result = sql_query("SELECT pollID, optionText, optionCount, voteID FROM $prefix"._poll_data." WHERE (pollID=$pollID) AND (voteID=$i)", $dbi);
	$object = sql_fetch_object($result, $dbi);
	if(is_object($object)) {
	    $optionText = $object->optionText;
	    if($optionText != "") {
		$boxContent .= "<tr><td valign=\"top\"><input type=\"radio\" name=\"voteID\" value=\"".$i."\"></td><td width=\"100%\"><font class=\"content\">$optionText</font></td></tr>\n";
	    }
	}
    }
    $boxContent .= "</table><br><center><font class=\"content\"><input type=\"submit\" value=\""._VOTE."\"></font><br>";
    if (is_user($user)) {
        cookiedecode($user);
    }
    for($i = 0; $i < 12; $i++) {
	$result = sql_query("SELECT optionCount FROM $prefix"._poll_data." WHERE (pollID=$pollID) AND (voteID=$i)", $dbi);
	$object = sql_fetch_object($result, $dbi);
	$optionCount = $object->optionCount;
	$sum = (int)$sum+$optionCount;
    }
    $boxContent .= "<font class=\"content\">[ <a href=\"pollBooth.php?op=results&amp;pollID=$pollID&amp;mode=$cookie[4]&amp;order=$cookie[5]&amp;thold=$cookie[6]\"><b>"._RESULTS."</b></a> | <a href=\"pollBooth.php\"><b>"._POLLS."</b></a> ]<br>";

    if ($pollcomm) {
	list($numcom) = sql_fetch_row(sql_query("select count(*) from $prefix"._pollcomments." where pollID=$pollID", $dbi), $dbi);
	$boxContent .= "<br>"._VOTES.": <b>$sum</b> <br> "._PCOMMENTS." <b>$numcom</b>\n\n";
    } else {
        $boxContent .= "<br>"._VOTES." <b>$sum</b>\n\n";
    }
    $boxContent .= "</font></center></form>\n\n";
    themesidebox($boxTitle, $boxContent);
}

function pollLatest() {
    global $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
	$querylang = "WHERE planguage='$currentlang' AND artid='0'";
    } else {
	$querylang = "WHERE artid='0'";
    }
    $result = sql_query("SELECT pollID FROM $prefix"._poll_desc." $querylang ORDER BY pollID DESC LIMIT 1", $dbi);
    $pollID = sql_fetch_row($result, $dbi);
    return($pollID[0]);
}

function pollNewest() {
    $pollID = pollLatest();
    pollMain($pollID);
}

function pollCollector($pollID, $voteID, $forwarder) {
    global $HTTP_COOKIE_VARS, $prefix, $dbi;
    /* Fix for lamers that like to cheat on polls */
    $ip = getenv("REMOTE_ADDR");
    $past = time()-1800;
    sql_query("DELETE FROM $prefix"._poll_check." WHERE time < $past", $dbi);
    $result = sql_query("SELECT ip FROM $prefix"._poll_check." WHERE (ip='$ip') AND (pollID='$pollID')", $dbi);
    list($ips) = sql_fetch_row($result, $dbi);
    $ctime = time();
    if ($ip == $ips) {
	$voteValid = 0;
    } else {
	sql_query("INSERT INTO $prefix"._poll_check." (ip, time, pollID) VALUES ('$ip', '$ctime', '$pollID')", $dbi);
	$voteValid = "1";
    }
    /* Fix end */
    /* update database if the vote is valid */
    if($voteValid>0) {
        sql_query("UPDATE $prefix"._poll_data." SET optionCount=optionCount+1 WHERE (pollID=$pollID) AND (voteID=$voteID)", $dbi);
        if ($voteID != "") {
	    sql_query("UPDATE $prefix"._poll_desc." SET voters=voters+1 WHERE pollID=$pollID", $dbi);
        }
	Header("Location: $forwarder");
    } else {
        Header("Location: $forwarder");
    }
    /* a lot of browsers can't handle it if there's an empty page */
    echo "<html><head></head><body></body></html>";
}

function pollList() {
    global $user, $cookie, $prefix, $multilingual, $currentlang, $admin, $dbi;
    if ($multilingual == 1) {
        $querylang = "WHERE planguage='$currentlang' AND artid='0'";
    } else {
        $querylang = "WHERE artid='0'";
    }
    $result = sql_query("SELECT pollID, pollTitle, timeStamp, voters FROM $prefix"._poll_desc." $querylang ORDER BY timeStamp DESC", $dbi);
    $counter = 0;
    OpenTable();
    OpenTable();
    echo "<center><font class=\"title\"><b>"._PASTSURVEYS."</b></font></center>";
    CloseTable();
    echo "<table border=\"0\" cellpadding=\"8\"><tr><td>";
    while($object = sql_fetch_object($result, $dbi)) {
	$resultArray[$counter] = array($object->pollID, $object->pollTitle, $object->timeStamp, $object->voters);
	$counter++;
    }
    for ($count = 0; $count < count($resultArray); $count++) {
	$id = $resultArray[$count][0];
	$pollTitle = $resultArray[$count][1];
	$voters = $resultArray[$count][3];
	for($i = 0; $i < 12; $i++) {
	    $result = sql_query("SELECT optionCount FROM $prefix"._poll_data." WHERE (pollID=$id) AND (voteID=$i)", $dbi);
	    $object = sql_fetch_object($result, $dbi);
	    $optionCount = $object->optionCount;
	    $sum = (int)$sum+$optionCount;
	}
	echo "<strong><big>&middot;</big></strong>&nbsp;<a href=\"pollBooth.php?pollID=$id\">$pollTitle</a> ";
	if (is_admin($admin)) {
	    $editing = " - <a href=\"admin.php?op=polledit&amp;pollID=$id\">Edit</a>";
	} else {
	    $editing = "";
	}
	echo "(<a href=\"pollBooth.php?op=results&amp;pollID=$id&amp;mode=$cookie[4]&amp;order=$cookie[5]&amp;thold=$cookie[6]\">"._RESULTS."</a> - $sum "._LVOTES."$editing)<br>\n";
	$sum = 0;
    }
    echo "</td></tr></table>"
	."<br>";
    OpenTable();
    echo "<center><font class=\"title\"><b>"._SURVEYSATTACHED."</b></font></center>";
    CloseTable();
    echo "<table border=\"0\" cellpadding=\"8\"><tr><td>";
    if ($multilingual == 1) {
        $querylang = "WHERE planguage='$currentlang' AND artid!='0'";
    } else {
        $querylang = "WHERE artid!='0'";
    }
    $counter = 0;
    $result = sql_query("SELECT pollID, pollTitle, timeStamp, voters FROM $prefix"._poll_desc." $querylang ORDER BY timeStamp DESC", $dbi);
    while($object = sql_fetch_object($result, $dbi)) {
	$resultArray2[$counter] = array($object->pollID, $object->pollTitle, $object->timeStamp, $object->voters);
	$counter++;
    }
    for ($count = 0; $count < count($resultArray2); $count++) {
	$id = $resultArray2[$count][0];
	$pollTitle = $resultArray2[$count][1];
	$voters = $resultArray2[$count][3];
	for($i = 0; $i < 12; $i++) {
	    $result = sql_query("SELECT optionCount FROM $prefix"._poll_data." WHERE (pollID=$id) AND (voteID=$i)", $dbi);
	    $object = sql_fetch_object($result, $dbi);
	    $optionCount = $object->optionCount;
	    $sum = (int)$sum+$optionCount;
	}
	echo "<strong><big>&middot;</big></strong>&nbsp;<a href=\"pollBooth.php?pollID=$id\">$pollTitle</a> ";
	if (is_admin($admin)) {
	    $editing = " - <a href=\"admin.php?op=polledit&amp;pollID=$id\">Edit</a>";
	} else {
	    $editing = "";
	}
	$res = sql_query("select sid, title from $prefix"._stories." where pollID='$id'", $dbi);
	list($sid, $title) = sql_fetch_row($res, $dbi);
	echo "(<a href=\"pollBooth.php?op=results&amp;pollID=$id&amp;mode=$cookie[4]&amp;order=$cookie[5]&amp;thold=$cookie[6]\">"._RESULTS."</a> - $sum "._LVOTES."$editing)<br>\n"
	    .""._ATTACHEDTOARTICLE." <a href=\"article.php?sid=$sid\">$title</a><br><br>\n";
    }
    echo "</td></tr></table>";
    CloseTable();
}

function pollResults($pollID) {
    global $resultTableBgColor, $resultBarFile, $Default_Theme, $user, $cookie, $prefix, $dbi;
    if(!isset($pollID)) $pollID = 1;
    $result = sql_query("SELECT pollID, pollTitle, timeStamp, artid FROM $prefix"._poll_desc." WHERE pollID=$pollID", $dbi);
    $holdtitle = sql_fetch_row($result, $dbi);
    echo "<br><b>$holdtitle[1]</b><br><br>";
    for($i = 0; $i < 12; $i++) {
	$result = sql_query("SELECT optionCount FROM $prefix"._poll_data." WHERE (pollID=$pollID) AND (voteID=$i)", $dbi);
	$object = sql_fetch_object($result, $dbi);
	$optionCount = $object->optionCount;
	$sum = (int)$sum+$optionCount;
    }
    echo "<table border=\"0\">";
    /* cycle through all options */
    for($i = 1; $i <= 12; $i++) {
	/* select next vote option */
	$result = sql_query("SELECT pollID, optionText, optionCount, voteID FROM $prefix"._poll_data." WHERE (pollID=$pollID) AND (voteID=$i)", $dbi);
	$object = sql_fetch_object($result, $dbi);
	if(is_object($object)) {
	    $optionText = $object->optionText;
	    $optionCount = $object->optionCount;
	    if($optionText != "") {
		echo "<tr><td>";
		echo "$optionText";
		echo "</td>";
		if($sum) {
		    $percent = 100 * $optionCount / $sum;
		} else {
		    $percent = 0;
		}
		echo "<td>";
		$percentInt = (int)$percent * 4 * 1;
		$percent2 = (int)$percent;
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
		if ($percent > 0) {
		    echo "<img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"$percent2 %\">";
		    echo "<img src=\"themes/$ThemeSel/images/mainbar.gif\" height=\"15\" width=\"$percentInt\" Alt=\"$percent2 %\">";
		    echo "<img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"$percent2 %\">";
		} else {
		    echo "<img src=\"themes/$ThemeSel/images/leftbar.gif\" height=\"15\" width=\"7\" Alt=\"$percent2 %\">";
		    echo "<img src=\"themes/$ThemeSel/images/mainbar.gif\" height=\"15\" width=\"3\" Alt=\"$percent2 %\">";
		    echo "<img src=\"themes/$ThemeSel/images/rightbar.gif\" height=\"15\" width=\"7\" Alt=\"$percent2 %\">";
		}
                printf(" %.2f %% (%d)", $percent, $optionCount);
		echo "</td></tr>";
	    }
	}

    }
    echo "</table><br>";
    echo "<center><font class=\"content\">";
    echo "<b>"._TOTALVOTES." $sum</b><br>";
    echo "<br><br>";
    $booth = $pollID;
    if ($holdtitle[3] > 0) {
	$article = "<br><br>"._GOBACK."</font></center>";
    } else {
	$article = "</font></center>";
    }
    echo "[ <a href=\"pollBooth.php?pollID=$booth\">"._VOTING."</a> | "
	."<a href=\"pollBooth.php\">"._OTHERPOLLS."</a> ] $article";
    return(1);
}

function getTopics($s_sid) {
    global $topicname, $topicimage, $topictext, $prefix, $dbi;
    $sid = $s_sid;
    $result = sql_query("SELECT topic FROM $prefix"._stories." where sid=$sid", $dbi);
    list($topic) = sql_fetch_row($result, $dbi);
    $result = sql_query("SELECT topicid, topicname, topicimage, topictext FROM $prefix"._topics." where topicid=$topic", $dbi);
    list($topicid, $topicname, $topicimage, $topictext) = sql_fetch_row($result, $dbi);
}

function headlines($bid) {
    global $prefix, $dbi;
    $result = sql_query("select title, content, url, refresh, time from $prefix"._blocks." where bid='$bid'", $dbi);
    list($title, $content, $url, $refresh, $otime) = sql_fetch_row($result, $dbi);
    $past = time()-$refresh;
    if ($otime < $past) {
	$btime = time();
	$rdf = parse_url($url);
	$fp = fsockopen($rdf['host'], 80, $errno, $errstr, 15);
	if (!$fp) {
	    $content = "";
	    //$content = "<font class=\"content\">"._RSSPROBLEM."</font>";
	    $result = sql_query("update $prefix"._blocks." set content='$content', time='$btime' where bid='$bid'", $dbi);
	    $cont = 0;
	    themesidebox($title, $content);
	    return;
	}
	if ($fp) {
	    fputs($fp, "GET " . $rdf['path'] . "?" . $rdf['query'] . " HTTP/1.0\r\n");
	    fputs($fp, "HOST: " . $rdf['host'] . "\r\n\r\n");
	    $string	= "";
	    while(!feof($fp)) {
	    	$pagetext = fgets($fp,300);
	    	$string .= chop($pagetext);
	    }
	    fputs($fp,"Connection: close\r\n\r\n");
	    fclose($fp);
	    $items = explode("</item>",$string);
	    $content = "<font class=\"content\">";
	    for ($i=0;$i<10;$i++) {
		$link = ereg_replace(".*<link>","",$items[$i]);
		$link = ereg_replace("</link>.*","",$link);
		$title2 = ereg_replace(".*<title>","",$items[$i]);
		$title2 = ereg_replace("</title>.*","",$title2);
		if ($items[$i] == "") {
		    $content = "";
		    sql_query("update $prefix"._blocks." set content='$content', time='$btime' where bid='$bid'", $dbi);
		    $cont = 0;
		    themesidebox($title, $content);
		    return;
		} else {
		    if (strcmp($link,$title)) {
			$cont = 1;
			$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"$link\" target=\"new\">$title2</a><br>\n";
		    }
		}
	    }

	}
	sql_query("update $prefix"._blocks." set content='$content', time='$btime' where bid='$bid'", $dbi);
    }
    $siteurl = ereg_replace("http://","",$url);
    $siteurl = explode("/",$siteurl);
    if (($cont == 1) OR ($content != "")) {
	$content .= "<br><a href=\"http://$siteurl[0]\" target=\"blank\"><b>"._HREADMORE."</b></a></font>";
    } elseif (($cont == 0) OR ($content == "")) {
	$content = "<font class=\"content\">"._RSSPROBLEM."</font>";
    }
    themesidebox($title, $content);
}

function online() {
    global $user, $cookie, $prefix, $dbi;
    cookiedecode($user);
    $ip = getenv("REMOTE_ADDR");
    $username = $cookie[1];
    if (!isset($username)) {
        $username = "$ip";
        $guest = 1;
    }
    $past = time()-1800;
    sql_query("DELETE FROM $prefix"._session." WHERE time < $past", $dbi);
    $result = sql_query("SELECT time FROM $prefix"._session." WHERE username='$username'", $dbi);
    $ctime = time();
    if ($row = sql_fetch_array($result, $dbi)) {
	sql_query("UPDATE $prefix"._session." SET username='$username', time='$ctime', host_addr='$ip', guest='$guest' WHERE username='$username'", $dbi);
    } else {
	sql_query("INSERT INTO $prefix"._session." (username, time, host_addr, guest) VALUES ('$username', '$ctime', '$ip', '$guest')", $dbi);
    }

    $result = sql_query("SELECT username FROM $prefix"._session." where guest=1", $dbi);
    $guest_online_num = sql_num_rows($result, $dbi);

    $result = sql_query("SELECT username FROM $prefix"._session." where guest=0", $dbi);
    $member_online_num = sql_num_rows($result, $dbi);

    $who_online_num = $guest_online_num + $member_online_num;
    $who_online = "<center><font class=\"content\">"._CURRENTLY." $guest_online_num "._GUESTS." $member_online_num "._MEMBERS."<br>";
    $result = sql_query("select title from $prefix"._blocks." where bkey='online'", $dbi);
    list($title) = sql_fetch_row($result, $dbi);
    $content = "$who_online";
    if (is_user($user)) {
	$content .= "<br>"._YOUARELOGGED." <b>$username</b>.<br>";
	$result = sql_query("select uid from $prefix"._users." where uname='$username'", $dbi);
	list($uid) = sql_fetch_row($result, $dbi);
	$result2 = sql_query("select to_userid from $prefix"._priv_msgs." where to_userid='$uid'", $dbi);
	$numrow = sql_num_rows($result2, $dbi);
	$content .= ""._YOUHAVE." <a href=\"viewpmsg.php\"><b>$numrow</b></a> "._PRIVATEMSG."</font></center>";
    } else {
	$content .= "<br>"._YOUAREANON."</font></center>";
    }
    themesidebox($title, $content);
}

function bigstory() {
    global $cookie, $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
	    $querylang = "AND (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
    } else {
	    $querylang = "";
    }
    $today = getdate();
    $day = $today["mday"];
    if ($day < 10) {
	$day = "0$day";
    }
    $month = $today["mon"];
    if ($month < 10) {
	$month = "0$month";
    }
    $year = $today["year"];
    $tdate = "$year-$month-$day";
    $result = sql_query("select sid, title from $prefix"._stories." where (time LIKE '%$tdate%') $querylang order by counter DESC limit 0,1", $dbi);
    list($fsid, $ftitle) = sql_fetch_row($result, $dbi);
    $content = "<font class=\"content\">";
    if ((!$fsid) AND (!$ftitle)) {
	$content .= ""._NOBIGSTORY."</font>";
    } else {
	$content .= ""._BIGSTORY."<br><br>";
	if (isset($cookie[4])) { $options .= "&amp;mode=$cookie[4]"; } else { $options .= "&amp;mode=thread"; }
	if (isset($cookie[5])) { $options .= "&amp;order=$cookie[5]"; } else { $options .= "&amp;order=0"; }
	if (isset($cookie[6])) { $options .= "&amp;thold=$cookie[6]"; } else { $options .= "&amp;thold=0"; }
	$content .= "<a href=\"article.php?sid=$fsid$options\">$ftitle</a></font>";
    }
    $boxtitle = _TODAYBIG;
    themesidebox($boxtitle, $content);
}

function automated_news() {
    global $prefix, $multilingual, $currentlang, $dbi;
    if ($multilingual == 1) {
	    $querylang = "WHERE (alanguage='$currentlang' OR alanguage='')"; /* the OR is needed to display stories who are posted to ALL languages */
    } else {
	    $querylang = "";
    }
    $today = getdate();
    $day = $today[mday];
    if ($day < 10) {
	$day = "0$day";
    }
    $month = $today[mon];
    if ($month < 10) {
	$month = "0$month";
    }
    $year = $today[year];
    $hour = $today[hours];
    $min = $today[minutes];
    $sec = "00";
    $result = sql_query("select anid, time from $prefix"._autonews." $querylang", $dbi);
    while(list($anid, $time) = sql_fetch_row($result, $dbi)) {
	ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $date);
	if (($date[1] <= $year) AND ($date[2] <= $month) AND ($date[3] <= $day)) {
	    if (($date[4] < $hour) AND ($date[5] >= $min) OR ($date[4] <= $hour) AND ($date[5] <= $min)) {
		$result2 = sql_query("select catid, aid, title, hometext, bodytext, topic, informant, notes, ihome, alanguage, acomm from $prefix"._autonews." where anid='$anid'", $dbi);
		while(list($catid, $aid, $title, $hometext, $bodytext, $topic, $author, $notes, $ihome, $alanguage, $acomm) = sql_fetch_row($result2, $dbi)) {
		    $title = stripslashes(FixQuotes($title));
		    $hometext = stripslashes(FixQuotes($hometext));
		    $bodytext = stripslashes(FixQuotes($bodytext));
		    $notes = stripslashes(FixQuotes($notes));
		    sql_query("insert into $prefix"._stories." values (NULL, '$catid', '$aid', '$title', now(), '$hometext', '$bodytext', '0', '0', '$topic', '$author', '$notes', '$ihome', '$alanguage', '$acomm', '0', '0')", $dbi);
		    sql_query("delete from $prefix"._autonews." where anid='$anid'", $dbi);
		}
	    }
	}
    }
}

function forumerror($e_code) {
    global $sitename, $header, $footer;
    if ($e_code == "0001") {
	$error_msg = "Could not connect to the forums database.";
    }
    if ($e_code == "0002") {
	$error_msg = "The forum you selected does not exist. Please go back and try again.";
    }
    if ($e_code == "0003") {
	$error_msg = "Password Incorrect.";
    }
    if ($e_code == "0004") {
	$error_msg = "Could not query the topics database.";
    }
    if ($e_code == "0005") {
	$error_msg = "Error getting messages from the database.";
    }
    if ($e_code == "0006") {
	$error_msg = "Please enter the Nickname and the Password.";
    }
    if ($e_code == "0007") {
	$error_msg = "You are not the Moderator of this forum therefore you can't perform this function.";
    }
    if ($e_code == "0008") {
	$error_msg = "You did not enter the correct password, please go back and try again.";
    }
    if ($e_code == "0009") {
	$error_msg = "Could not remove posts from the database.";
    }
    if ($e_code == "0010") {
	$error_msg = "Could not move selected topic to selected forum. Please go back and try again.";
    }
    if ($e_code == "0011") {
	$error_msg = "Could not lock the selected topic. Please go back and try again.";
    }
    if ($e_code == "0012") {
	$error_msg = "Could not unlock the selected topic. Please go back and try again.";
    }
    if ($e_code == "0013") {
	$error_msg = "Could not query the database.";
    }
    if ($e_code == "0014") {
	$error_msg = "No such user or post in the database.";
    }
    if ($e_code == "0015") {
	$error_msg = "Search Engine was unable to query the forums database.";
    }
    if ($e_code == "0016") {
	$error_msg = "That user does not exist. Please go back and search again.";
    }
    if ($e_code == "0017") {
	$error_msg = "You must type a subject to post. You can't post an empty subject. Go back and enter the subject";
    }
    if ($e_code == "0018") {
	$error_msg = "You must choose message icon to post. Go back and choose message icon.";
    }
    if ($e_code == "0019") {
	$error_msg = "You must type a message to post. You can't post an empty message. Go back and enter a message.";
    }
    if ($e_code == "0020") {
	$error_msg = "Could not enter data into the database. Please go back and try again.";
    }
    if ($e_code == "0021") {
	$error_msg = "Can't delete the selected message.";
    }
    if ($e_code == "0022") {
	$error_msg = "An error ocurred while querying the database.";
    }
    if ($e_code == "0023") {
	$error_msg = "Selected message was not found in the forum database.";
    }
    if ($e_code == "0024") {
	$error_msg = "You can't reply to that message. It wasn't sent to you.";
    }
    if ($e_code == "0025") {
	$error_msg = "You can't post a reply to this topic, it has been locked. Contact the administrator if you have any question.";
    }
    if ($e_code == "0026") {
	$error_msg = "The forum or topic you are attempting to post to does not exist. Please try again.";
    }
    if ($e_code == "0027") {
	$error_msg = "You must enter your username and password. Go back and do so.";
    }
    if ($e_code == "0028") {
	$error_msg = "You have entered an incorrect password. Go back and try again.";
    }
    if ($e_code == "0029") {
	$error_msg = "Couldn't update post count.";
    }
    if ($e_code == "0030") {
	$error_msg = "The forum you are attempting to post to does not exist. Please try again.";
    }
    if ($e_code == "0031") {
	return(0);
    }
    if ($e_code == "0032") {
	$error_msg = "Error doing DB query in check_user_pw()";
    }
    if ($e_code == "0033") {
	$error_msg = "Error doing DB query in get_pmsg_count";
    }
    if ($e_code == "0034") {
	$error_msg = "Error doing DB query in check_username()";
    }
    if ($e_code == "0035") {
	$error_msg = "You can't edit a post that's not yours.";
    }
    if ($e_code == "0036") {
	$error_msg = "You do not have permission to edit this post.";
    }
    if ($e_code == "0037") {
	$error_msg = "You did not supply the correct password or do not have permission to edit this post. Please go back and try again.";
    }
    if (!isset($header)) {
	include("header.php");
    }
    OpenTable2();
    echo "<center><font class=\"content\"><b>$sitename Error</b></font><br><br>";
    echo "Error Code: $e_code<br><br><br>";
    echo "<b>ERROR:</b> $error_msg<br><br><br>";
    echo "[ <a href=\"javascript:history.go(-1)\">Go Back</a> ]<br><br>";
    CloseTable2();
    include("footer.php");
    die("");
}

?>
