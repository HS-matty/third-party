<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* Some changes by Daiz13                                               */
/* http://online.if.ua                                                  */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

require_once("mainfile.php");

if (isset($name)) {
    $result = sql_query("select active from $prefix"._modules." where title='$name'", $dbi);
    list($mod_active) = sql_fetch_row($result, $dbi);
    if (($mod_active == 1) OR ($mod_active == 0 AND is_admin($admin))) {
	if (!isset($op)) { $op="modload"; }
	if (!isset($file)) { $file="index"; }
	if (ereg("\.\.",$name) || ereg("\.\.",$file)) {
	    echo "You are so cool...";
	} else {
	    $modpath="modules/$name/$file.php";
    	    if (file_exists($modpath)) {
		include($modpath);
    	    } else {
		die ("Sorry, such file doesn't exist...");
	    }
	}
    } else {
	include("header.php");
	OpenTable();
	echo "<center>"._MODULENOTACTIVE."<br><br>"
	    .""._GOBACK."</center>";
	CloseTable();
	include("footer.php");
    }
} else {
    die ("Sorry, you can't access this file directly...");
}

?>