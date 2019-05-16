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

    case "sections":
    include("admin/modules/sections.php");
    break;

    case "sectionedit":
    include("admin/modules/sections.php");
    break;

    case "sectionmake":
    include("admin/modules/sections.php");
    break;

    case "sectiondelete":
    include("admin/modules/sections.php");
    break;

    case "sectionchange":
    include("admin/modules/sections.php");
    break;

    case "secarticleadd":
    include("admin/modules/sections.php");
    break;
		
    case "secartedit":
    include("admin/modules/sections.php");
    break;
			
    case "secartchange":
    include("admin/modules/sections.php");
    break;
		
    case "secartdelete":
    include("admin/modules/sections.php");
    break;

}

?>