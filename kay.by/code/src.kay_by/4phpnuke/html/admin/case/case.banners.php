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

    case "BannersAdmin":
    include("admin/modules/banners.php");
    break;

    case "BannersAdd":
    include("admin/modules/banners.php");
    break;

    case "BannerAddClient":
    include("admin/modules/banners.php");
    break;

    case "BannerFinishDelete":
    include("admin/modules/banners.php");
    break;

    case "BannerDelete":
    include("admin/modules/banners.php");
    break;

    case "BannerEdit":
    include("admin/modules/banners.php");
    break;
		
    case "BannerChange":
    include("admin/modules/banners.php");
    break;

    case "BannerClientDelete":
    include("admin/modules/banners.php");
    break;

    case "BannerClientEdit":
    include("admin/modules/banners.php");
    break;

    case "BannerClientChange":
    include("admin/modules/banners.php");
    break;

}

?>