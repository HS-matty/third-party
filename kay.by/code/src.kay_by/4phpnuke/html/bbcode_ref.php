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

if ($userdata[9] != '') {
    $themes = "themes/$userdata[9]/theme.php";
} else {
    $themes = "themes/$Default_Theme/theme.php";
}
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
<p><br>
<font class="content" FACE="Verdana,Arial,Helvetica">
<CENTER>W H A T &nbsp;&nbsp;&nbsp;&nbsp; I S &nbsp;&nbsp;&nbsp;&nbsp; B B C O D E ?
</CENTER>
<P>
BBCode is a variation on the HTML tags you may already be familiar with.  Basically, it allows you to add functionality or style to your message that would normally require HTML.  You can use BBCode even if HTML is not enabled for the forum you are using.  You may want to use BBCode as opposed to HTML, even if HTML is enabled for your forum, because there is less coding required and it is safer to use (incorrect coding syntax will not lead to as many problems).
<P>
<B>Current BBCodes:</B>
<P>

<table border=0 cellpadding=0 cellspacing=0 width="95%"><TR><td bgcolor="#FFFFFF">
<table border=0 cellpadding=4 border=0 cellspacing=1 width=100%>
<TR bgcolor="<?php echo $bgcolor2?>">
<TD>
<font class="content" FACE="Verdana,Arial,Helvetica" COLOR="<?php echo $textcolor2; ?>">
URL Hyperlinking</FONT></td></tr>
<TR bgcolor="<?php echo $bgcolor1?>"><TD><font class="content" FACE="Verdana,Arial,Helvetica">
NEW! If BBCode is enabled in a forum, you no longer need to use the [URL] code to create a hyperlink.  Simply type the complete URL in either of the following manners and the hyperlink will be created automatically:
<UL><font class="content" FACE="Verdana,Arial,Helvetica" color="silver">
<LI> http://www.yourURL.com
<LI> www.yourURL.com
</font>

Notice that you can either use the complete http:// address or shorten it to the www domain.  If the site does not begin with "www", you must use the complete "http://" address.  Also, you may use https and ftp URL prefixes in auto-link mode (when BBCode is ON).
<P>
The old [URL] code will still work, as detailed below.

Just encase the link as shown in the following example (BBCode is in <FONT COLOR="#FF0000">red</FONT>).
<P><center>
<FONT COLOR="#FF0000">[url]</FONT>www.totalgeek.org<FONT COLOR="#FF0000">[/url]</FONT>
<P></center>
NEW! You can now have true hyperlinks using the [url] code.  Just use the following format:
<BR><center>
<FONT COLOR="#FF0000">[url=http://www.totalgeek.org]</font>totalgeek.org<FONT COLOR="#FF0000">[/url]</font>
</center><p>
In the examples above, the BBCode automatically generates a hyperlink to the URL that is encased.  It will also ensure that the link is opened in a new window when the user clicks on it. Note that the "http://" part of the URL is completely optional. In the second example above, the URL will hypelink the text to whatever URL you provide after the equal sign.  Also note that you should NOT use quotation marks inside the URL tag.
</font>
</td>
<tr bgcolor="<?php echo $bgcolor2?>"><td>
<font class="content" FACE="Verdana,Arial,Helvetica" COLOR="<?php echo $textcolor2; ?>">
Email Links</FONT></td></tr>
<TR bgcolor="<?php echo $bgcolor1?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica">
To add a hyperlinked email address within your message, just encase the email address as shown in the following example (BBCode is in <FONT COLOR="#FF0000">red</FONT>).
<P>
<CENTER>
<FONT COLOR="#FF0000">[email]</FONT>james@totalgeek.org<FONT COLOR="#FF0000">[/email]</FONT>
</CENTER>
<P>
In the example above, the BBCode automatically generates a hyperlink to the email address that is encased.  
</FONT>
</td></tr>
<tr bgcolor="<?php echo $bgcolor2?>"><td>
<font class="content" FACE="Verdana,Arial,Helvetica" COLOR="<?php echo $textcolor2; ?>">
Bold and Italics</FONT></td></tr>
<TR bgcolor="<?php echo $bgcolor1?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica">
You can make italicized text or make text bold by encasing the applicable sections of your text with either the [b] [/b] or [i] [/i] tags. 
<P>
<CENTER>
Hello, <FONT COLOR="#FF0000">[b]</FONT><B>James</B><FONT COLOR="#FF0000">[/b]</FONT><BR>
Hello, <FONT COLOR="#FF0000">[i]</FONT><I>Mary</I><FONT COLOR="#FF0000">[/i]</FONT>
</CENTER>
</FONT>
</td></tr>
<tr bgcolor="<?php echo $bgcolor2?>"><td>
<font class="content" FACE="Verdana,Arial,Helvetica" COLOR="<?php echo $textcolor2; ?>">
Bullets/Lists</FONT></td></tr>
<TR bgcolor="<?php echo $bgcolor1?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica">
You can make bulleted lists or ordered lists (by number or letter).
<P>
Unordered, bulleted list:
<P>
<FONT COLOR="#FF0000">[list]</FONT>
<BR>
<FONT COLOR="#FF0000">[*]</font> This is the first bulleted item.<BR>
<FONT COLOR="#FF0000">[*]</font> This is the second bulleted item.<BR>
<FONT COLOR="#FF0000">[/list]</font>
<P>
This produces:
<ul>
<LI> This is the first bulleted item.
<LI> This is the second bulleted item.
</ul>
Note that you must include a closing [/list] when you end each list.

<P>
Making ordered lists is just as easy.  Just add either [LIST=A] or [LIST=1].  Typing [List=A] will produce a list from A to Z.  Using [List=1] will produce numbered lists.
<P>
Here's an example:
<P>

<FONT COLOR="#FF0000">[list=A]</FONT>
<BR>
<FONT COLOR="#FF0000">[*]</font> This is the first bulleted item.<BR>
<FONT COLOR="#FF0000">[*]</font> This is the second bulleted item.<BR>
<FONT COLOR="#FF0000">[/list]</font>
<P>
This produces:
<ol type=A>
<LI> This is the first bulleted item.
<LI> This is the second bulleted item.
</ul>


</FONT>
</td></tr>
<TR bgcolor="<?php echo $bgcolor2?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica" COLOR="<?php echo $textcolor2; ?>">
Adding Images</font></td></tr>
<TR bgcolor="<?php echo $bgcolor1?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica">
To add a graphic within your message, just encase the URL of the graphic image as shown in the following example (BBCode is in <FONT COLOR="#FF0000">red</FONT>).
<P>
<CENTER>
<FONT COLOR="#FF0000">[img]</FONT>http://www.totalgeek.org/images/tline.gif<FONT COLOR="#FF0000">[/img]</FONT>
</CENTER>
<P>
In the example above, the BBCode automatically makes the graphic visible in your message.  Note: the "http://" part of the URL is REQUIRED for the <FONT COLOR="#FF0000">[img]</FONT> code.  Also note: some UBB forums may disable the <FONT COLOR="#FF0000">[img]</FONT> tag support to prevent objectionable images from being viewed.
</FONT>
</td></tr>
<TR bgcolor="<?php echo $bgcolor2?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica" COLOR="<?php echo $textcolor2; ?>">
Quoting Other Messages</font></td></tr>
<TR bgcolor="<?php echo $bgcolor1?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica">
To reference something specific that someone has posted, just cut and paste the applicable verbiage and enclose it as shown below (BBCode is in <FONT COLOR="#FF0000">red</FONT>).
<P>
<CENTER>
<FONT COLOR="#FF0000">[QUOTE]</FONT>Ask not what your country can do for you....<BR>ask what you can do for your country.<FONT COLOR="#FF0000">[/QUOTE]</FONT>
</CENTER>
<P>
In the example above, the BBCode automatically blockquotes the text you reference.</FONT>
</td>
</tr>
<TR bgcolor="<?php echo $bgcolor2?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica" COLOR="<?php echo $textcolor2; ?>">
Code Tag</FONT></td></tr>
<TR bgcolor="<?php echo $bgcolor1?>"><TD>
<font class="content" FACE="Verdana,Arial,Helvetica">
Similar to the Quote tage, the Code tag adds some &lt;PRE&gt; tags to preserve formatting.  This useful for displaying programming code, for instance.
<P>

<FONT COLOR="#FF0000">[CODE]</FONT>#!/usr/bin/perl
<P>
print "Content-type: text/html\n\n";
<BR>
print "Hello World!";
<FONT COLOR="#FF0000">[/CODE]</FONT>

<P>
In the example above, the BBCode automatically blockquotes the text you reference and preserves the formatting of the coded text.</FONT>
</td>
</tr>
</table>
</td></tr></table>
</blockquote>
<BR><BR>
<FONT color="<?php echo $bgcolor2?>" >Of Note
<BR>
You must not use both HTML and BBCode to do the same function.  Also note that the BBCode is not case-sensitive (thus, you could use <FONT COLOR="#FF0000">[URL]</FONT> or <FONT COLOR="#FF0000">[url]</FONT>).
<P>
<FONT color="<?php echo $bgcolor2?>">Incorrect BBCode Usage:</FONT>
<P>
<FONT COLOR="#FF0000">[url]</FONT> www.totalgeek.org <FONT COLOR="#FF0000">[/url]</FONT> - don't put spaces between the bracketed code and the text you are applying the code to.
<P>
<FONT COLOR="#FF0000">[email]</FONT>james@totalgeek.org<FONT COLOR="#FF0000">[email]</FONT> - the end brackets must include a forward slash (<FONT COLOR="#FF0000">[/email]</FONT>)

<P><font class="tiny" FACE="Verdana,Arial,Helvetica">
<BR>

</FONT>
</FONT>
</B>
</body>
</html>
