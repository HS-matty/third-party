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

    case "FaqCatSave":
    include ("admin/modules/adminfaq.php");
    FaqCatSave($id_cat, $categories, $flanguage); /* Multilingual Code : added variable */
    break;

    case "FaqCatGoSave":
    include ("admin/modules/adminfaq.php");
    FaqCatGoSave($id, $question, $answer);
    break;

    case "FaqCatAdd":
    include ("admin/modules/adminfaq.php");
    FaqCatAdd($categories, $flanguage); /* Multilingual Code : added variable */
    break;

    case "FaqCatGoAdd":
    include ("admin/modules/adminfaq.php");
    FaqCatGoAdd($id_cat, $question, $answer);
    break;

    case "FaqCatEdit":
    include ("admin/modules/adminfaq.php");
    FaqCatEdit($id_cat);
    break;

    case "FaqCatGoEdit":
    include ("admin/modules/adminfaq.php");
    FaqCatGoEdit($id);
    break;

    case "FaqCatDel":
    include ("admin/modules/adminfaq.php");
    FaqCatDel($id_cat, $ok);
    break;

    case "FaqCatGoDel":
    include ("admin/modules/adminfaq.php");
    FaqCatGoDel($id, $ok);
    break;

    case "FaqAdmin":
    include ("admin/modules/adminfaq.php");
    FaqAdmin();
    break;

    case "FaqCatGo":
    include ("admin/modules/adminfaq.php");
    FaqCatGo($id_cat);
    break;

}

?>
