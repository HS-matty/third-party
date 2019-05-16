<?php

######################################################################
# PHP-NUKE: Web Portal System
# ===========================
#
# Copyright (c) 2000 by Francisco Burzi (fbc@mandrakesoft.com)
# http://phpnuke.org
#
# This module is to configure the main options for your site
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
######################################################################

######################################################################
# Database & System Config
#
# dbhost:       MySQL Database Hostname
# dbuname:      MySQL Username
# dbpass:       MySQL Password
# dbname:       MySQL Database Name
# system:       0 for Unix/Linux, 1 for Windows
# $prefix:      Your Database table's prefix
# $user_prefix: Your Users' Database table's prefix (To share it)
# $dbtype:      Your Database Server type. Supported servers are:
#               MySQL, mSQL, PostgreSQL, PostgreSQL_local, ODBC,
#               ODBC_Adabas, Interbase, and Sybase.
#               Be sure to write it exactly as above, CaSe SeNsItIvE!
######################################################################

$dbhost = "glade.tut.by";
$dbuname = "kayby";
$dbpass = "owGOrers97";
$dbname = "kayby";
$system = 0;
$prefix = "nuke";
$user_prefix = "nuke";
$dbtype = "MySQL";

/*********************************************************************/
/* You finished to configure the Database. Now you can change all    */
/* you want in the Administration Section.   To enter just launch    */
/* you web browser pointing to http://yourdomain.com/admin.php       */
/*                                                                   */
/* At the prompt use the following ID to login (case sensitive):     */
/*                                                                   */
/* AdminID: God                                                      */
/* Password: Password                                                */
/*                                                                   */
/* Be sure to change inmediately the God login & password clicking   */
/* on Edit Admin in the Admin menu. After that, click on Preferences */
/* to configure your new site. In that menu you can change all you   */
/* need to change.                                                   */
/*                                                                   */
/* Remember to chmod 666 this file in order to let the system write  */
/* to it properly. If you can't change the permissions you can edit  */
/* the rest of this file by hand.                                    */
/*                                                                   */
/* Congratulations! now you have an automated news portal!           */
/* Thanks for choose PHP-Nuke: The Future of the Web                 */
/*********************************************************************/



######################################################################
# General Site Configuration
#
# $sitename:      Your Site Name
# $nukeurl:       Complete URL for your site (Do not put / at end)
# $site_logo:     Logo for Printer Friendly Page (It's good to have a Black/White graphic)
# $slogan:        Your site's slogan
# $startdate:     Start Date to display in Statistic Page
# $adminmail:     Site Administrator's Email
# $anonpost:      Allow Anonymous to Post Comments? (1=Yes 0=No)
# $Default_Theme: Default Theme for your site (See /themes directory for the complete list, case sensitive!)
# $foot(x):       Messages for all footer pages (Can include HTML code)
# $commentlimit:  Maximum number of bytes for each comment
# $anonymous:     Anonymous users Default Name
# $minpass:       Minimum character for users passwords
# $pollcomm:      Activate comments in Polls? (1=Yes 0=No)
# $articlecomm:   Activate comments in Articles? (1=Yes 0=No)
######################################################################

$sitename = "KAY";
$nukeurl = "http://kay.by";
$site_logo = "logo.gif";
$slogan = "Your slogan here";
$startdate = "february 2002";
$adminmail = "webmaster@kay.by";
$anonpost = 0;
$Default_Theme = "NukeNews";
$foot1 = "<a href=\"http://phpnuke.org\" target=\"blank\"><img src=\"images/powered/nuke.gif\" border=\"0\" Alt=\"Web site powered by PHP-Nuke\" hspace=\"10\"></a> <a href=\"http://www.apache.org\" target=\"blank\"><img src=\"images/powered/apache.gif\" Alt=\"Apache Web Server\" border=\"0\" hspace=\"10\"></a><a href=\"http://www.php.net\" target=\"blank\"><img src=\"images/powered/php2.gif\" Alt=\"PHP Scripting Language\" border=\"0\" hspace=\"10\"></a><br>";
$foot2 = "All logos and trademarks in this site are property of their respective owner. The comments are property of their posters, all the rest © 2000 by me";
$foot3 = "This web site was made with <a href=\"http://phpnuke.org\">PHP-Nuke</a>, a web portal system written in PHP. PHP-Nuke is Free Software released under the <a href=\"http://www.gnu.org\">GNU/GPL license</a>.";
$foot4 = "You can syndicate our news using the file <a href=\"backend.php\">backend.php</a> or <a href=\"ultramode.txt\">ultramode.txt</a>";
$commentlimit = 4096;
$anonymous = "Anonymous";
$minpass = 5;
$pollcomm = 1;
$articlecomm = 1;

######################################################################
# General Stories Options
#
# $top:       How many items in Top Page?
# $storyhome: How many stories to display in Home Page?
# $oldnum:    How many stories in Old Articles Box?
# $ultramode: Activate ultramode plain text file backend syndication? (1=Yes 0=No  Need to chmod 666 ultramode.txt file)
######################################################################

$top = 10;
$storyhome = 10;
$oldnum = 30;
$ultramode = 0;

######################################################################
# Banners/Advertising Configuration
#
# $banners: Activate Banners Ads for your site? (1=Yes 0=No)
# $myIP:    Write your IP number to not count impressions, be fair about this!
######################################################################

$banners = 0;
$myIP = "150.10.10.10";

######################################################################
# XML/RDF Backend Configuration
#
# $backend_title:    Backend title, can be your site's name and slogan
# $backend_language: Language format of your site
######################################################################

$backend_title = "PHP-Nuke Powered Site";
$backend_language = "en-us";

######################################################################
# Site Language Preferences
#
# $language: Language of your site (You need to have lang-xxxxxx.php file for your selected language in the /language directory of your site)
# $locale:   Locale configuration to correctly display date with your country format. (See /usr/share/locale)
######################################################################

$language = "russian";
$locale = "en_US";

######################################################################
# Multilingual Configuration
#
# $multilingual: Activate multilingual features? (1=Yes 0=No) No means you only want to use interface language switching.
# $autodetectlang: Activate auto detection of the visitor's browser language to autoswitch to the corresponding language.
# $useflags: (1=Yes 0=No) If set to Yes , flags will be used for the language switching , if set to No a dropdown box will be displayed
######################################################################

$multilingual = "0";
$useflags = "0";

######################################################################
# Notification of News Submissions
#
# $notify:         Notify you each time your site receives a news submission? (1=Yes 0=No)
# $notify_email:   Email, address to send the notification
# $notify_subject: Email subject
# $notify_message: Email body, message
# $notify_from:    account name to appear in From field of the Email
######################################################################

$notify = 0;
$notify_email = "me@yoursite.com";
$notify_subject = "NEWS for my site";
$notify_message = "Hey! You got a new submission for your site.";
$notify_from = "webmaster";

######################################################################
# Moderation Config (not 100% working)
#
# $moderate:   Activate moderation system? (1=Yes 0=No)
# $resons:     List of reasons for the moderation (each reason under quotes and comma separated)
# $badreasons: Number of bad reasons in the reasons list
######################################################################

$moderate = 0;
$reasons = array("As Is",
		    "Offtopic",
		    "Flamebait",
		    "Troll",
		    "Redundant",
		    "Insighful",
		    "Interesting",
		    "Informative",
		    "Funny",
		    "Overrated",
		    "Underrated");
$badreasons = 4;

######################################################################
# Some Graphics Options
#
# $admingraphic: Activate graphic menu for Administration Menu? (1=Yes 0=No)
######################################################################

$admingraphic = 0;

######################################################################
# HTTP Referers Options
#
# $httpref:    Activate HTTP referer logs to know who is linking to our site? (1=Yes 0=No)# $httprefmax: Maximum number of HTTP referers to store in the Database (Try to not set this to a high number, 500 ~ 1000 is Ok)
######################################################################

$httpref = 1;
$httprefmax = 1000;

######################################################################
# Allowable HTML tags
#
# $AllowableHTML: HTML command to allow in the comments
#                  =>2 means accept all qualifiers: <foo bar>
#                  =>1 means accept the tag only: <foo>
######################################################################

$AllowableHTML = array("b"=>1,
		    "i"=>1,
		    "a"=>2,
		    "em"=>1,
		    "br"=>1,
		    "strong"=>1,
		    "blockquote"=>1,
                    "tt"=>1,
                    "li"=>1,
                    "ol"=>1,
                    "ul"=>1);

######################################################################
# Filters Options
#
# $CensorList:	List of bad word to be replaced on Comments
# $CensorMode:  	0 = No Filtering (leave the bad words)
# 			1 = Exact Match
#			2 = Match Word at the Begining
#			3 = Match String Anywhere in the Text
# $CensorReplace:	String to replace bad words
######################################################################

$CensorList = array("fuck",
		    "cunt",
		    "fucker",
		    "fucking",
		    "pussy",
		    "cock",
		    "c0ck",
		    "cum",
		    "twat",
		    "clit",
		    "bitch",
		    "fuk",
		    "fuking",
		    "motherfucker");
$CensorMode = 1;
$CensorReplace = "*****";

######################################################################
# Do not touch the following options!
######################################################################

$tipath = "images/topics";
$Version_Num = "5.3.1";

if (eregi("config.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

?>