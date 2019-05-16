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

include('functions.php');
include('config.php');
include('mainfile.php');
include('auth.php');

if (is_user($user)) {
		$user = base64_decode($user);
	        $userdata = explode(":", $user);
}

if ($userdata[9] != '') $themes = "themes/$userdata[9]/theme.php";
else $themes = "themes/$Default_Theme/theme.php";
if (!(strstr(basename($themes),"theme.php")) || !(file_exists($themes))) {
    echo "Invalid Theme";
    exit;
}

include ("$themes");
?>

<html>
<head>
<style type="text/css">
<!--

<?php
echo "TD {font-size: 10pt; font-family: $site_font}\n";
echo "BODY {font-size: 10pt; font-family: $site_font}\n";
echo "-->\n</style>\n";
echo "<title>$sitename</title>\n";
?>
</head>

<BODY>
<p><br><p>
<center>
<TABLE width="<?php echo $table_width?>">
<tr><td colspan=3 bgcolor="<?php echo $bgcolor1?>">
<font class="tiny" >
<center>
S M I L I E S
</CENTER>
<p align=center>
Smilies are small graphical images that can be used to convey an emotion or feeling.
<P>
</td></tr>
<TR bgcolor="<?php echo $bgcolor2?>">
<TR bgcolor="<?php echo $bgcolor2?>">
<TD><font class="content" COLOR="<?php echo $textcolor2;?>"><b>What to Type</b></FONT></td>
<TD><font class="content" COLOR="<?php echo $textcolor2;?>"><b>Emotion</b></FONT></td>
<TD><font class="content" COLOR="<?php echo $textcolor2;?>"><b>Graphic That Will Appear</b></FONT></td>
</tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:)</FONT></td><td><font class="tiny" > Smile&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_smile.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:-)</FONT></td><td><font class="tiny" > Smile&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_smile.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:(</FONT></td><td><font class="tiny" > Frown&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_frown.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:-(</FONT></td><td><font class="tiny" > Frown&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_frown.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:-D</FONT></td><td><font class="tiny" > Big Grin&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_biggrin.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:D</FONT></td><td><font class="tiny" > Big Grin&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_biggrin.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >;)</FONT></td><td><font class="tiny" > Wink&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_wink.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >;-)</FONT></td><td><font class="tiny" > Wink&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_wink.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:o</FONT></td><td><font class="tiny" > Eek&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_eek.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:O</FONT></td><td><font class="tiny" > Eek&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_eek.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:-o</FONT></td><td><font class="tiny" > Eek&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_eek.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:-O</FONT></td><td><font class="tiny" > Eek&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_eek.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >8)</FONT></td><td><font class="tiny" > Cool&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_cool.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >8-)</FONT></td><td><font class="tiny" > Cool&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_cool.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:?</FONT></td><td><font class="tiny" > Confused&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_confused.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:-?</FONT></td><td><font class="tiny" > Confused&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_confused.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:p</FONT></td><td><font class="tiny" > Razz&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_razz.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:P</FONT></td><td><font class="tiny" > Razz&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_razz.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:-p</FONT></td><td><font class="tiny" > Razz&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_razz.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:-P</FONT></td><td><font class="tiny" > Razz&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_razz.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor1?>"><TD><font class="content" >:-|</FONT></td><td><font class="tiny" > Mad&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_mad.gif"></td></tr>
<TR BGCOLOR="<?php echo $bgcolor3?>"><TD><font class="content" >:|</FONT></td><td><font class="tiny" > Mad&nbsp;</FONT></td><td> <IMG SRC="images/forum/icons/icon_mad.gif"></td></tr>
<tr><td colspan=3 bgcolor="<?php echo $color1?>">
<font class="tiny" color=FFFFFF>
<center>
<P>
Note: you may disable smilies in any post you are making, if you like.  Look for the "Disable Smilies" box on each post page, if you want to turn off smilie conversion in your particular post.
</font>
</td></tr></table>
</center>
<br><br>
</body>
</html>