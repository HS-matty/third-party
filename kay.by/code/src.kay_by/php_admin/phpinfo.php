<?php
/* $Id: phpinfo.php,v 1.6 2001/11/09 07:54:04 loic1 Exp $ */


/**
 * Gets core libraries and defines some variables
 */
require('./libraries/grab_globals.lib.php');
require('./libraries/common.lib.php');


/**
 * Displays PHP information
 */
$is_superuser = @mysql_query('USE mysql', $userlink);
if ($is_superuser || $cfgShowPhpInfo) {
    phpinfo();
}
?>
