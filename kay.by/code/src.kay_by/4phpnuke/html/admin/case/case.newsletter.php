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

    case "newsletter":
    include("admin/modules/newsletter.php");
    break;

    case "newsletter_send":
    include("admin/modules/newsletter.php");
    break;

    case "newsletter_sent":
    include("admin/modules/newsletter.php");
    break;

    case "massmail_send":
    include("admin/modules/newsletter.php");
    break;

    case "massmail_sent":
    include("admin/modules/newsletter.php");
    break;

    case "check_type":
    include("admin/modules/newsletter.php");
    break;

}

?>