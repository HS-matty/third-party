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

if (eregi("counter.php",$PHP_SELF)) {
    Header("Location: index.php");
    die();
}

/* Get the Browser data */

if((ereg("Nav", getenv("HTTP_USER_AGENT"))) || (ereg("Gold", getenv("HTTP_USER_AGENT"))) || (ereg("X11", getenv("HTTP_USER_AGENT"))) || (ereg("Mozilla", getenv("HTTP_USER_AGENT"))) || (ereg("Netscape", getenv("HTTP_USER_AGENT"))) AND (!ereg("MSIE", getenv("HTTP_USER_AGENT")))) $browser = "Netscape";
elseif(ereg("MSIE", getenv("HTTP_USER_AGENT"))) $browser = "MSIE";
elseif(ereg("Lynx", getenv("HTTP_USER_AGENT"))) $browser = "Lynx";
elseif(ereg("Opera", getenv("HTTP_USER_AGENT"))) $browser = "Opera";
elseif(ereg("WebTV", getenv("HTTP_USER_AGENT"))) $browser = "WebTV";
elseif(ereg("Konqueror", getenv("HTTP_USER_AGENT"))) $browser = "Konqueror";
elseif((eregi("bot", getenv("HTTP_USER_AGENT"))) || (ereg("Google", getenv("HTTP_USER_AGENT"))) || (ereg("Slurp", getenv("HTTP_USER_AGENT"))) || (ereg("Scooter", getenv("HTTP_USER_AGENT"))) || (eregi("Spider", getenv("HTTP_USER_AGENT"))) || (eregi("Infoseek", getenv("HTTP_USER_AGENT")))) $browser = "Bot";
else $browser = "Other";

/* Get the Operating System data */

if(ereg("Win", getenv("HTTP_USER_AGENT"))) $os = "Windows";
elseif((ereg("Mac", getenv("HTTP_USER_AGENT"))) || (ereg("PPC", getenv("HTTP_USER_AGENT")))) $os = "Mac";
elseif(ereg("Linux", getenv("HTTP_USER_AGENT"))) $os = "Linux";
elseif(ereg("FreeBSD", getenv("HTTP_USER_AGENT"))) $os = "FreeBSD";
elseif(ereg("SunOS", getenv("HTTP_USER_AGENT"))) $os = "SunOS";
elseif(ereg("IRIX", getenv("HTTP_USER_AGENT"))) $os = "IRIX";
elseif(ereg("BeOS", getenv("HTTP_USER_AGENT"))) $os = "BeOS";
elseif(ereg("OS/2", getenv("HTTP_USER_AGENT"))) $os = "OS/2";
elseif(ereg("AIX", getenv("HTTP_USER_AGENT"))) $os = "AIX";
else $os = "Other";

/* Save on the databases the obtained values */

sql_query("update $prefix"._counter." set count=count+1 where (type='total' and var='hits') or (var='$browser' and type='browser') or (var='$os' and type='os')", $dbi);

?>