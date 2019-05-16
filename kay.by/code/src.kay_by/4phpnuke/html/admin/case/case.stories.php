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

    case "YesDelCategory":
    include("admin/modules/stories.php");
    break;

    case "subdelete":
    include("admin/modules/stories.php");
    break;

    case "DelCategory":
    include("admin/modules/stories.php");
    break;
			
    case "NoMoveCategory":
    include("admin/modules/stories.php");
    break;

    case "EditCategory":
    include("admin/modules/stories.php");
    break;
	
    case "SaveEditCategory":
    include("admin/modules/stories.php");
    break;

    case "AddCategory":
    include("admin/modules/stories.php");
    break;

    case "SaveCategory":
    include("admin/modules/stories.php");
    break;

    case "DisplayStory":
    include("admin/modules/stories.php");
    break;

    case "PreviewAgain":
    include("admin/modules/stories.php");
    break;

    case "PostStory":
    include("admin/modules/stories.php");
    break;

    case "EditStory":
    include("admin/modules/stories.php");
    break;

    case "RemoveStory":
    include("admin/modules/stories.php");
    break;

    case "ChangeStory":
    include("admin/modules/stories.php");
    break;

    case "DeleteStory":
    include("admin/modules/stories.php");
    break;

    case "adminStory":
    include("admin/modules/stories.php");
    break;

    case "PreviewAdminStory":
    include("admin/modules/stories.php");
    break;

    case "PostAdminStory":
    include("admin/modules/stories.php");
    break;

    case "autoDelete":
    include("admin/modules/stories.php");
    break;

    case "autoEdit":
    include("admin/modules/stories.php");
    break;

    case "autoSaveEdit":
    include("admin/modules/stories.php");
    break;

    case "submissions":
    include("admin/modules/stories.php");
    break;

}

?>