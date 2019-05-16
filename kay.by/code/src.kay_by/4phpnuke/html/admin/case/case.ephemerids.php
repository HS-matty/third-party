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

    case "Ephemeridsedit":
    include("admin/modules/ephemerids.php");
    break;
	
    case "Ephemeridschange":
    include("admin/modules/ephemerids.php");
    break;
			
    case "Ephemeridsdel":
    include("admin/modules/ephemerids.php");
    break;
			
    case "Ephemeridsmaintenance":
    include("admin/modules/ephemerids.php");
    break;
			
    case "Ephemeridsadd":
    include("admin/modules/ephemerids.php");
    break;
			
    case "Ephemerids":
    include("admin/modules/ephemerids.php");
    break;

}

?>