<?php
$eZIniCacheCodeDate = 1043407542;
$charset = "iso-8859-1";
$groupArray["Handler"] = "ezfilepasstrough";
$blockValues["BinaryFileSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["Handlers"] = array();
$groupArray["Handlers"]["tar"] = "eztararchivehandler";
$blockValues["ArchiveSettings"] =& $groupArray;
unset( $groupArray );
$groupArray["Handlers"] = array();
$groupArray["Handlers"]["gzip"] = "ezgzipcompressionhandler";
$groupArray["Handlers"]["gzipzlib"] = "ezgzipzlibcompressionhandler";
$groupArray["Handlers"]["gzipshell"] = "ezgzipshellcompressionhandler";
$blockValues["FileSettings"] =& $groupArray;
unset( $groupArray );
$groupPlacementArray["Handler"] = "settings/file.ini";
$blockValuesPlacement["BinaryFileSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["Handlers"] = array();
$groupPlacementArray["Handlers"][0] = "settings/file.ini";
$groupPlacementArray["Handlers"]["tar"] = "settings/file.ini";
$blockValuesPlacement["ArchiveSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );
$groupPlacementArray["Handlers"] = array();
$groupPlacementArray["Handlers"][0] = "settings/file.ini";
$groupPlacementArray["Handlers"]["gzip"] = "settings/file.ini";
$groupPlacementArray["Handlers"]["gzipzlib"] = "settings/file.ini";
$groupPlacementArray["Handlers"]["gzipshell"] = "settings/file.ini";
$blockValuesPlacement["FileSettings"] =& $groupPlacementArray;
unset( $groupPlacementArray );

?>