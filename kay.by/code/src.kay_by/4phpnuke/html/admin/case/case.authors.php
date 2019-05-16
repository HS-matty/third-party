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

switch($op) {

    case "mod_authors":
    include("admin/modules/authors.php");
    break;
		
    case "modifyadmin":
    include("admin/modules/authors.php");
    break;

    case "UpdateAuthor":
    include("admin/modules/authors.php");
    break;

    case "AddAuthor":
    include("admin/modules/authors.php");
    break;

    case "deladmin2":
    include("admin/modules/authors.php");
    break;

    case "deladmin":
    include("admin/modules/authors.php");
    break;

    case "assignstories":
    include("admin/modules/authors.php");
    break;

    case "deladminconf":
    include("admin/modules/authors.php");
    break;

}

?>