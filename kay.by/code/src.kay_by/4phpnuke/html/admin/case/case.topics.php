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

    case "relatedsave":
    include("admin/modules/topics.php");
    break;
		
    case "relatededit":
    include("admin/modules/topics.php");
    break;
			
    case "relateddelete":
    include("admin/modules/topics.php");
    break;

    case "topicsmanager":
    include("admin/modules/topics.php");
    break;

    case "topicedit":
    include("admin/modules/topics.php");
    break;

    case "topicmake":
    include("admin/modules/topics.php");
    break;

    case "topicdelete":
    include("admin/modules/topics.php");
    break;

    case "topicchange":
    include("admin/modules/topics.php");
    break;

}

?>