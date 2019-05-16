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

    case "downloads":
    include("admin/modules/download.php");
    break;

    case "DownloadsDelNew":
    include("admin/modules/download.php");
    break;

    case "DownloadsAddCat":
    include("admin/modules/download.php");
    break;

    case "DownloadsAddSubCat":
    include("admin/modules/download.php");
    break;

    case "DownloadsAddDownload":
    include("admin/modules/download.php");
    break;
			
    case "DownloadsAddEditorial":
    include("admin/modules/download.php");
    break;			
			
    case "DownloadsModEditorial":
    include("admin/modules/download.php");
    break;	
			
    case "DownloadsDownloadCheck":
    include("admin/modules/download.php");
    break;	
		
    case "DownloadsValidate":
    include("admin/modules/download.php");
    break;

    case "DownloadsDelEditorial":
    include("admin/modules/download.php");
    break;						

    case "DownloadsCleanVotes":
    include("admin/modules/download.php");
    break;	
			
    case "DownloadsListBrokenDownloads":
    include("admin/modules/download.php");
    break;

    case "DownloadsDelBrokenDownloads":
    include("admin/modules/download.php");
    break;
			
    case "DownloadsIgnoreBrokenDownloads":
    include("admin/modules/download.php");
    break;			
			
    case "DownloadsListModRequests":
    include("admin/modules/download.php");
    break;		
			
    case "DownloadsChangeModRequests":
    include("admin/modules/download.php");
    break;	
			
    case "DownloadsChangeIgnoreRequests":
    include("admin/modules/download.php");
    break;
			
    case "DownloadsDelCat":
    include("admin/modules/download.php");
    break;

    case "DownloadsModCat":
    include("admin/modules/download.php");
    break;

    case "DownloadsModCatS":
    include("admin/modules/download.php");
    break;

    case "DownloadsModDownload":
    include("admin/modules/download.php");
    break;

    case "DownloadsModDownloadS":
    include("admin/modules/download.php");
    break;

    case "DownloadsDelDownload":
    include("admin/modules/download.php");
    break;

    case "DownloadsDelVote":
    include("admin/modules/download.php");
    break;			

    case "DownloadsDelComment":
    include("admin/modules/download.php");
    break;

}

?>