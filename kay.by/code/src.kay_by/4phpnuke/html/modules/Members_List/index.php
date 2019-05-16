<?php 

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* =========================                                            */
/* Based on MyPHPortal Modified MembersList                             */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

/* Some code taken from MemberList coded by Paul Joseph Thompson */
/* of www.slug.okstate.edu                                       */
/* In memoriam of Members List War ;)                            */

if (!eregi("modules.php", $PHP_SELF)) {
    die ("You can't access this file directly...");
}

require_once("mainfile.php");

function alpha() {
    /* Creates the list of letters and makes them a link. */
    global $sortby;
        $alphabet = array ("All", "A","B","C","D","E","F","G","H","I","J","K","L","M",
                            "N","O","P","Q","R","S","T","U","V","W","X","Y","Z","Other");
        $num = count($alphabet) - 1;
        echo "<center>[ ";
	/* start of HTML */
        $counter = 0;
        while (list(, $ltr) = each($alphabet)) {
            echo "<A HREF=\"modules.php?op=modload&amp;name=Members_List&amp;file=index&amp;letter=$ltr&amp;sortby=$sortby\">$ltr</a>";
            if ( $counter == round($num/2) ) {
                echo " ]\n<br>\n[ "; 
            } elseif ( $counter != $num ) {
                echo "&nbsp;|&nbsp;\n";
            }
            $counter++;
        }
        echo " ]\n</center>\n<br>\n";  // end of HTML
}

function SortLinks($letter) {  // Makes order by links..
        global $sortby;
        if ($letter == "front") { 
	    $letter = "All"; 
	}
        echo "\n<center>\n"; // Start of HTML
        echo ""._SORTBY." <b>[</b> ";
        if ($sortby == "uname" OR !$sortby) {
            echo ""._MNICKNAME."&nbsp;|&nbsp;";
        } else {
            echo "<A HREF=\"modules.php?op=modload&amp;name=Members_List&amp;file=index&amp;letter=$letter&amp;sortby=uname\">"._MNICKNAME."</a>&nbsp;|&nbsp;";
        }
        if ($sortby == "name") {
            echo ""._MREALNAME."&nbsp;|&nbsp;";
        } else {
            echo "<A HREF=\"modules.php?op=modload&amp;name=Members_List&amp;file=index&amp;letter=$letter&amp;sortby=name\">"._MREALNAME."</a>&nbsp;|&nbsp;";
        }
        if ($sortby == "femail") {
            echo ""._MEMAIL."&nbsp;|&nbsp;";
        } else { 
            echo "<A HREF=\"modules.php?op=modload&amp;name=Members_List&amp;file=index&amp;letter=$letter&amp;sortby=femail\">"._MEMAIL."</a>&nbsp;|&nbsp;";
        }
        if ($sortby == "url") {
            echo ""._MURL."&nbsp;|&nbsp;";
        } else {
            echo "<A HREF=\"modules.php?op=modload&amp;name=Members_List&amp;file=index&amp;letter=$letter&amp;sortby=url\">"._MURL."</a>";
        }
        echo " <b>]</b>\n</center>\n"; // end of HTML
}
        
include("header.php");
$pagesize = 20;

if (!isset($letter)) { $letter = "A"; }
if (!isset($sortby)) { $sortby = "uname"; }
if (!isset($page)) { $page = 1; }

/* All of the code from here to around line 125 will be optimized a little later */
/* This is the header section that displays the last registered and who's logged in and whatnot */

$result = sql_query("select uname from $prefix"._users." order by uid DESC limit 0,1", $dbi);
list($lastuser) = sql_fetch_row($result, $dbi);
echo "\n\n<!-- MEMBERS LIST -->\n\n";
	OpenTable();
        echo "<center><b>"._WELCOMETO." $sitename "._MEMBERSLIST."</b><br><br>\n";
        echo ""._GREETINGS." <A HREF=\"user.php?op=userinfo&amp;uname=$lastuser\">$lastuser</a>\n</center>\n<br>\n";

        $numrows = sql_num_rows(sql_query("select uid from $prefix"._users."", $dbi), $dbi);

        if (is_user($user)) {
            $result2 = sql_query("SELECT username,guest FROM $prefix"._session." where guest=0", $dbi);
            $member_online_num = sql_num_rows($result2, $dbi);
	    $who_online = "<b>"._ONLINEREG." </b><br><br>";
            $i = 1;
            while ($session = sql_fetch_array($result2, $dbi)) {
                if (isset($session["guest"]) and $session["guest"] == 0) {
                    $who_online .= "<A HREF=\"user.php?op=userinfo&amp;uname=$session[username]\">$session[username]</a>\n";
                    $who_online .= ($i != $member_online_num ? " - " : "");
                    $i++;
                }
            }
            echo "<center>"._WEHAVE." <b>$numrows</b> "._MREGISTERED." <b>$member_online_num</b>\n";
            echo " "._MREGONLINE."</center><br><br>";
	    OpenTable2();
            echo "<CENTER>$who_online</CENTER>\n";
	    CloseTable2();
	    echo "<br><br>";
        } else {
            echo "<center>"._WEHAVE." <b>$numrows</b> "._REGSOFAR."</center>\n<br>\n<br>\n";
        }

        alpha();
        SortLinks($letter);

/* end of top memberlist section thingie */
/* This starts the beef...*/

        $min = $pagesize * ($page - 1); // This is where we start our record set from
        $max = $pagesize; // This is how many rows to select
        
        /* All my SQL stuff. DO NOT ALTER ANYTHING UNLESS YOU KNOW WHAT YOU ARE DOING */

/* This is a totaly crap code, any help to re-code this functions will be very appreciated */
/* Need to be database independent */
	
        $count = "SELECT COUNT(uid) AS total FROM $prefix"._users." "; // Count all the users in the db..
        $select = "select uid, name, uname, femail, url from $prefix"._users." "; //select our data
	$where = "where uname != 'Anonymous' ";
	if ( ( $letter != "Other" ) AND ( $letter != "All" ) ) {  // are we listing all or "other" ?
            $where .= "AND uname like '".$letter."%' "; // I guess we are not.. 
        } else if ( ( $letter == "Other" ) AND ( $letter != "All" ) ) { // But other is numbers ?
            $where .= "AND uname REGEXP \"^\[1-9]\" "; // REGEX :D, although i think its MySQL only
                                                        // Will have to change this later.
                                                        // if you know a better way to match only the first char
                                                        // to be a number in uname, please change it and email
                                                        // myphportal-developers@lists.sourceforge.net the correction
                                                        // or goto http://sourceforge.net/projects/myphportal and post 
                                                        // your correction there. Thanks, Bjorn.
        } else { // or we are unknown or all..
            $where .= ""; // this is to get rid of anoying "undefinied variable" message
        }
        $sort = "order by $sortby"; //sorty by .....
        $limit = " ASC LIMIT ".$min.", ".$max; // we only want rows $min  to $max
        /* due to how this works, i need the total number of users per 
        letter group, then we can hack of the ones we want to view */
        $count_result = sql_query($count.$where, $dbi);
        $num_rows_per_order = mysql_result($count_result,0,0);
        
        /* This is where we get our limit'd result set. */
        $result = sql_query($select.$where.$sort.$limit, $dbi) or die(); // Now lets do it !!

/* Crap code ends here */

        echo "<br>";
        if ( $letter != "front" ) {
            echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\"><tr>\n";
            echo "<td BGCOLOR=\"$bgcolor4\" align=\"center\"><font color=\"$textcolor2\"><b>"._NICKNAME."</b></font></td>\n";
            echo "<td BGCOLOR=\"$bgcolor4\" align=\"center\"><font color=\"$textcolor2\"><b>"._REALNAME."</b></font></td>\n";
            echo "<td BGCOLOR=\"$bgcolor4\" align=\"center\"><font color=\"$textcolor2\"><b>"._EMAIL."</b></font></td>\n";
            echo "<td BGCOLOR=\"$bgcolor4\" align=\"center\"><font color=\"$textcolor2\"><b>"._URL."</b></font></td>\n";
            $cols = 4;
            if(is_admin($admin)) {
                $cols = 5;
                echo "<td BGCOLOR=\"$bgcolor4\" align=\"center\"><font color=\"$textcolor2\"><b>"._FUNCTIONS."</b></font></td>\n";
            }
            echo "</tr>";
            $a = 0;
            $dcolor_A = "$bgcolor2";
            $dcolor_B = "$bgcolor1";


            $num_users = sql_num_rows($result, $dbi); //number of users per sorted and limit query
            if ( $num_rows_per_order > 0  ) {
                while($user = sql_fetch_array($result, $dbi)) {
                    $dcolor = ($a == 0 ? $dcolor_A : $dcolor_B);
                    echo "<tr><td bgcolor=\"$dcolor\"><A HREF=\"user.php?op=userinfo&amp;uname=$user[uname]\"><font color=\"$textcolor1\">$user[uname]</font></a>&nbsp;</td>\n";
                    echo "<td bgcolor=\"$dcolor\"><font color=\"$textcolor1\">$user[name]</font>&nbsp;</td>\n";
                    echo "<td bgcolor=\"$dcolor\"><font color=\"$textcolor1\">$user[femail]</font>&nbsp;</td>\n";
                    if ($user[url] == "") {
			$url2 = "&nbsp;";
		    } else {
			$urlno = eregi_replace("http://","",$user[url]);
			$url2 = "<a href=\"http://$urlno\" target=\"new\">"._HOMEPAGE."</a>";
		    }
		    echo "<td bgcolor=\"$dcolor\" align=\"center\">$url2</td>\n";
                    if(is_admin($admin)) {
                        echo "<td bgcolor=$dcolor align=center><font class=\"content\" color=\"$textcolor1\">[ <A HREF=\"admin.php?chng_uid=$user[uid]&amp;op=modifyUser\">"._EDIT."</a> | \n";
                        echo "<A HREF=\"admin.php?op=delUser&amp;chng_uid=$user[uid]\">"._DELETE."</a> ]</font></td>\n";
                    }
                    echo "</tr>";
                    $a = ($dcolor == $dcolor_A ? 1 : 0);
                }
                // start of next/prev/row links.
                echo "\n<tr><td colspan='$cols' align='right'>\n";
		echo "<br><br>";
		OpenTable();
                echo "\t<table width='100%' cellspacing='0' cellpadding='0' border=0><tr>";
                
                if ( $num_rows_per_order > $pagesize ) { 
                    $total_pages = ceil($num_rows_per_order / $pagesize); // How many pages are we dealing with here ??
                    $prev_page = $page - 1;
                    
                    if ( $prev_page > 0 ) {
                        echo "<td align='left' width='15%'><a href='modules.php?op=modload&amp;name=Members_List&file=index&letter=$letter&amp;sortby=$sortby&amp;page=$prev_page'>";
                        echo "<img src=\"images/download/left.gif\" border=\"0\" Alt=\""._PREVIOUS." ($prev_page)\"></a></td>";
                    } else { 
                        echo "<td width='15%'>&nbsp;</td>\n"; 
                    }
                
                    echo "<td align='center' width='70%'>";
                    echo "<font class=tiny>$num_rows_per_order "._USERSFOUND." <b>$letter</b> ($total_pages "._PAGES.", $num_users "._USERSSHOWN.")</font>";
                    echo "</td>";

                    $next_page = $page + 1;
                    if ( $next_page <= $total_pages ) {
                        echo "<td align='right' width='15%'><a href='modules.php?op=modload&amp;name=Members_List&file=index&letter=$letter&amp;sortby=$sortby&amp;page=$next_page'>";
                        echo "<img src=\"images/download/right.gif\" border=\"0\" Alt=\"Next Page ($next_page)\"></a></td>";
                    } else {
                        echo "<td width='15%'>&nbsp;</td></tr>\n"; 
                    }
    /* Added a numbered page list, only shows up to 50 pages. */
                    
                        echo "<tr><td colspan=\"3\" align=\"center\">";
                        echo " <font class=tiny>[ </font>";
                        
                        for($n=1; $n < $total_pages; $n++) {
                        
                            
                            if ($n == $page) {
				echo "<font class=tiny><b>$n</b></font></a>";
                            } else {
				echo "<a href='modules.php?op=modload&amp;name=Members_List&file=index&letter=$letter&amp;sortby=$sortby&amp;page=$n'>";
				echo "<font class=tiny>$n</font></a>";
			    }
                            if($n >= 50) {  // if more than 50 pages are required, break it at 50.
                                $break = true; 
                                break;
                            } else {  // guess not.
                                echo "<font class=tiny> | </font>"; 
                            }
                        }
                        
                        if(!isset($break)) { // are we sopposed to break ?
			    if ($n == $page) {
                        	echo "<font class=tiny><b>$n</b></font></a>";
			    } else {
                        	echo "<a href='modules.php?op=modload&amp;name=Members_List&file=index&letter=$letter&amp;sortby=$sortby&amp;page=$total_pages'>";
                        	echo "<font class=tiny>$n</font></a>";
			    }
                        }
                        echo " <font class=tiny>]</font> ";
                        echo "</td></tr>";

    /* This is where it ends */
                }else{  // or we dont have any users..
                    echo "<td align='center'>";
                    echo "<font class=tiny>$num_rows_per_order "._USERSFOUND." $letter</font>";
                    echo "</td></tr>";
                    
                 }
                
                 echo "</table>\n";
		 CloseTable();
                echo "</td></tr>\n";

                 // end of next/prev/row links
                
            } else { // you have no members on this letter, hahaha
                echo "<tr><td bgcolor=\"$dcolor_A\" colspan=\"$cols\" align=\"center\"><br>\n";
                echo "<b><font color=\"$textcolor1\">"._NOMEMBERS." $letter</font></b>\n";
                echo "<br></td></tr>\n";
            }
            
            echo "\n</table><br>\n";
        }
        
	CloseTable();
        include("footer.php");

?>