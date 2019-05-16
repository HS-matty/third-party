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

    case "create":
    include("admin/modules/polls.php");
    break;
		
    case "createPosted":
    include("admin/modules/polls.php");
    break;

    case "ChangePoll":
    include("admin/modules/polls.php");
    break;

    case "remove":
    include("admin/modules/polls.php");
    break;

    case "removePosted":
    include("admin/modules/polls.php");
    break;

    case "polledit":
    include("admin/modules/polls.php");
    break;

    case "savepoll":
    include("admin/modules/polls.php");
    break;

    case "polledit_select":
    include("admin/modules/polls.php");
    break;

}

?>