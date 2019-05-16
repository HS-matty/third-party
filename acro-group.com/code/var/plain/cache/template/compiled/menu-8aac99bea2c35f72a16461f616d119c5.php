<?php
// URI:       design/admin/templates/parts/setup/menu.tpl
// Filename:  design/admin/templates/parts/setup/menu.tpl
// Timestamp: 1089197114 (Wed Jul 7 13:45:14 BST 2004)
$oldSetArray_706c6f566a49756ec908b604fb8f4f40 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/setup/cache\">Cache management</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/setup/menuconfig\">Menu management</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\"  href=\"/index.php/admin_acro/search/stats\">Search statistics</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\"  href=\"/index.php/admin_acro/setup/info\">System information</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/setup/toolbarlist\">Toolbar management</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/url/list\">URL management</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/content/urltranslator\">URL translator</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">";
include_once( 'kernel/classes/ezpreferences.php' );
$show1 = eZPreferences::value( "advanced_menu" );
$show = ( ( $show1 ) == ( "on" ) );
unset( $show1 );

if ( $show )
{

    unset( $show );

    $text .= " <a class=\"leftmenuitem\" href=\"/index.php/admin_acro/user/preferences/set/advanced_menu/off\">Advanced</a>\n <a href=\"/index.php/admin_acro/user/preferences/set/advanced_menu/off\"><img src=\"/design/admin/images/down.gif\" alt=\"\" width=\"11\" height=\"6\" /></a>\n</div>\n<ul class=\"leftmenu\">\n<li><p>&#187; <a href=\"/index.php/admin_acro/class/grouplist\">Classes</a></p></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/setup/extensions\">Extension setup</a></p></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/settings/view\">Ini settings</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/notification/runfilter\">Notification</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/pdf/list\">PDF export</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/package/list\">Packages</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/setup/rad\">RAD</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/rss/list\">RSS</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/section/list\">Sections</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/setup/session\">Sessions</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/setup/systemupgrade\">System upgrade</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/setup/templatelist\">Templates</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/content/translations\">Translations</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/trigger/list\">Triggers</a></li>\n<li><p>&#187; <a href=\"/index.php/admin_acro/workflow/grouplist\">Workflows</a></li>\n</ul>";
}
else
{

    unset( $show );

    $text .= " <a class=\"leftmenuitem\" href=\"/index.php/admin_acro/user/preferences/set/advanced_menu/on\">Advanced</a>\n <a href=\"/index.php/admin_acro/user/preferences/set/advanced_menu/on\"><img src=\"/design/admin/images/up.gif\" alt=\"\" width=\"11\" height=\"6\" /></a>\n</div>";
}


$setArray = $oldSetArray_706c6f566a49756ec908b604fb8f4f40;
?>
