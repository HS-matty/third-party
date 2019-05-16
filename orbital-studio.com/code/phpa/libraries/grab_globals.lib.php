<?php
/* $Id: grab_globals.lib.php,v 1.4 2002/02/09 18:11:55 loic1 Exp $ */


/**
 * This library grabs the names and values of the variables sent or posted to a
 * script in the '$HTTP_*_VARS' arrays and sets simple globals variables from
 * them
 *
 * loic1 - 2001/25/11: use the new globals arrays defined with php 4.1+
 */
if (!defined('PMA_GRAB_GLOBALS_INCLUDED')) {
    define('PMA_GRAB_GLOBALS_INCLUDED', 1);

    if (!empty($_GET)) {
        extract($_GET);
    } else if (!empty($HTTP_GET_VARS)) {
        extract($HTTP_GET_VARS);
    } // end if

    if (!empty($_POST)) {
        extract($_POST);
    } else if (!empty($HTTP_POST_VARS)) {
        extract($HTTP_POST_VARS);
    } // end if

    if (!empty($_SERVER) && isset($_SERVER['SCRIPT_NAME'])) {
        $SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
    } else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['SCRIPT_NAME'])) {
        $SCRIPT_NAME = $HTTP_SERVER_VARS['SCRIPT_NAME'];
    } // end if

    if (!empty($_FILES)) {
        while (list($name, $value) = each($_FILES)) {
            $$name = $value['tmp_name'];
        }
    } else if (!empty($HTTP_POST_FILES)) {
        while (list($name, $value) = each($HTTP_POST_FILES)) {
            $$name = $value['tmp_name'];
        }
    } // end if

} // $__PMA_GRAB_GLOBALS_LIB__
?>