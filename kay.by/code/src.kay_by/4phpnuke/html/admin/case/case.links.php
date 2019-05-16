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

    case "links":
    include("admin/modules/links.php");
    break;

    case "LinksDelNew":
    include("admin/modules/links.php");
    break;

    case "LinksAddCat":
    include("admin/modules/links.php");
    break;

    case "LinksAddSubCat":
    include("admin/modules/links.php");
    break;

    case "LinksAddLink":
    include("admin/modules/links.php");
    break;
			
    case "LinksAddEditorial":
    include("admin/modules/links.php");
    break;			
			
    case "LinksModEditorial":
    include("admin/modules/links.php");
    break;	
			
    case "LinksLinkCheck":
    include("admin/modules/links.php");
    break;	
		
    case "LinksValidate":
    include("admin/modules/links.php");
    break;

    case "LinksDelEditorial":
    include("admin/modules/links.php");
    break;						

    case "LinksCleanVotes":
    include("admin/modules/links.php");
    break;	
			
    case "LinksListBrokenLinks":
    include("admin/modules/links.php");
    break;

    case "LinksDelBrokenLinks":
    include("admin/modules/links.php");
    break;
			
    case "LinksIgnoreBrokenLinks":
    include("admin/modules/links.php");
    break;			
			
    case "LinksListModRequests":
    include("admin/modules/links.php");
    break;		
			
    case "LinksChangeModRequests":
    include("admin/modules/links.php");
    break;	
			
    case "LinksChangeIgnoreRequests":
    include("admin/modules/links.php");
    break;
			
    case "LinksDelCat":
    include("admin/modules/links.php");
    break;

    case "LinksModCat":
    include("admin/modules/links.php");
    break;

    case "LinksModCatS":
    include("admin/modules/links.php");
    break;

    case "LinksModLink":
    include("admin/modules/links.php");
    break;

    case "LinksModLinkS":
    include("admin/modules/links.php");
    break;

    case "LinksDelLink":
    include("admin/modules/links.php");
    break;

    case "LinksDelVote":
    include("admin/modules/links.php");
    break;			

    case "LinksDelComment":
    include("admin/modules/links.php");
    break;

}

?>