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

if (!eregi("admin.php", $PHP_SELF)) { die ("Access Denied"); }
$hlpfile = "manual/reviews.html";
$result = sql_query("select radminsuper from $prefix"._authors." where aid='$aid'", $dbi);
list($radminsuper) = sql_fetch_row($result, $dbi);
if ($radminsuper==1) {

/*********************************************************/
/* REVIEWS Block Functions                               */
/*********************************************************/

function modules() {
    global $hlpfile, $prefix, $dbi, $multilingual;
    include ("header.php");
    $hlpfile = "manual/reviews.html";
    GraphicAdmin($hlpfile);
    OpenTable();
    echo "<center><font class=\"title\"><b>"._MODULESADMIN."</b></font></center>";
    CloseTable();
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
    $result = sql_query("select title from $prefix"._modules."", $dbi);
    while (list($title) = sql_Fetch_row($result, $dbi)) {
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
    echo "<br>";
    OpenTable();
    echo "<br><center><font class=\"option\">"._MODULESADDONS."</font><br><br>"
	."<font class=\"content\">"._MODULESACTIVATION."</font><br><br>"
	."<form action=\"admin.php\" method=\"post\">"
        ."<table border=\"1\" align=\"center\" width=\"90%\"><tr><td align=\"center\">"
	."<b>"._TITLE."</b></td><td align=\"center\"><b>"._STATUS."</b></td><td align=\"center\"><b>"._FUNCTIONS."</b></td></tr>";
    $result = sql_query("select mid, title, active, view from $prefix"._modules." order by title ASC", $dbi);
    while(list($mid, $title, $active, $view) = sql_fetch_row($result, $dbi)) {
	if ($active == 1) {
	    $active = _ACTIVE;
	    $change = _DEACTIVATE;
	    $act = 0;
	} else {
	    $active = "<i>"._INACTIVE."</i>";
	    $change = _ACTIVATE;
	    $act = 1;
	}
	echo "<tr><td>&nbsp;$title</td><td align=\"center\">$active</td><td align=\"center\">[ <a href=\"admin.php?op=module_status&mid=$mid&active=$act\">$change</a> ]</td></tr>";
    }
    echo "</table>";
    CloseTable();
    include ("footer.php");
}

function module_status($mid, $active) {
    global $prefix, $dbi;
    sql_query("update $prefix"._modules." set active='$active' where mid='$mid'", $dbi);
    Header("Location: admin.php?op=modules");
}

switch ($op){

    case "modules":
    modules();
    break;

    case "module_status":
    module_status($mid, $active);
    break;

}

} else {
    echo "Access Denied";
}

?>