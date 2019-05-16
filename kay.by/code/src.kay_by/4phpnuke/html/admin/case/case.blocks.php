<?php

######################################################################
# PHP-NUKE: Web Portal System
# ===========================
#
# Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)
# http://phpnuke.org
#
# This modules is the main administration part
#
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
######################################################################

if (!eregi("admin.php", $PHP_SELF)) { die ("Access Denied"); }

switch($op) {

    case "BlocksAdmin":
    include("admin/modules/blocks.php");
    break;

    case "BlocksAdd":
    include("admin/modules/blocks.php");
    break;

    case "BlocksEdit":
    include("admin/modules/blocks.php");
    break;

    case "BlocksEditSave":
    include("admin/modules/blocks.php");
    break;

    case "ChangeStatus":
    include("admin/modules/blocks.php");
    break;

    case "BlocksDelete":
    include("admin/modules/blocks.php");
    break;

    case "BlocksEditFixed":
    include("admin/modules/blocks.php");
    break;

    case "BlocksEditSaveFixed":
    include("admin/modules/blocks.php");
    break;

    case "BlockOrder":    
    include("admin/modules/blocks.php");
    break;

    case "HeadlinesDel":
    include("admin/modules/blocks.php");
    break;
	
    case "HeadlinesAdd":
    include("admin/modules/blocks.php");
    break;
	
    case "HeadlinesSave":
    include("admin/modules/blocks.php");
    break;
	
    case "HeadlinesAdmin":
    include("admin/modules/blocks.php");
    break;
		
    case "HeadlinesEdit":
    include("admin/modules/blocks.php");
    break;

}

?>