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

    case "messages":
    include("admin/modules/messages.php");
    break;

/* Start Multilingual Code *************************************************************/
/* modified original $op called 'messages': only displays the messages in a table      */
/* added a new $op called  'editmsg' that is used to edit a message                    */
/* added a new $op called  'addmsg' that is used to add a new message                  */
/* added a new $op called  'deletemsg' that is used to remove a message permanently    */
/***************************************************************************************/

    case "addmsg":
    include("admin/modules/messages.php");
    break;

    case "editmsg":
    include("admin/modules/messages.php");
    break;

    case "deletemsg":
    include("admin/modules/messages.php");
    break;

/* End Multilingual Code ***************************************************************/

    case "savemsg":
    include("admin/modules/messages.php");
    break;

}

?>