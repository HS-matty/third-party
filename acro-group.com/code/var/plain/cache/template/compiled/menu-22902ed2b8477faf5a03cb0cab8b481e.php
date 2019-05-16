<?php
// URI:       design/admin/templates/parts/my/menu.tpl
// Filename:  design/admin/templates/parts/my/menu.tpl
// Timestamp: 1089197114 (Wed Jul 7 13:45:14 BST 2004)
$oldSetArray_9f812f38ee9fa49cfd276d45a7a3b595 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/content/draft\">My drafts</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/content/pendinglist\">My pending list</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/notification/settings\">My notification settings</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/content/bookmark\">My bookmarks</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/collaboration/view/summary\">Collaboration</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=";
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "current_user", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["current_user"] : null;
$var4 = compiledFetchAttribute( $var3, "contentobject_id" );
unset( $var3 );
$var3 = $var4;
while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
    $var3 = $var3->templateValue();
$var1 = ( "/user/password/" . $var3 . "/" );
unset( $var3 );
if ( preg_match( "#^[a-zA-Z0-9]+:#", $var1 ) or
    substr( $var1, 0, 2 ) == '//')
{
    /* Do nothing */
}
else
{
    if ( strlen( $var1 ) == 0 )
    {
      $var1 = '/';
    }
    else if ( $var1[0] == '#' )
    {
        $var1 = htmlspecialchars( $var1 );
    }
    else if ( $var1[0] != '/' )
    {
        $var1 = '/' . $var1;
    };
    $var1 = "/index.php/admin_acro" . $var1;
    $var1 = preg_replace( "#(//)#", "/", $var1 );
    $var1 = preg_replace( "#^(.+)(/+)$#", "$1", $var1 );
    $var1 = htmlspecialchars( $var1 );
}
if ( $var1 == "" )
    $var1 = "/";$var1 = "\"" . $var1 . "\"";
$var = $var1;
unset( $var1 );
$text .= $var;
unset( $var );

$text .= ">Change password</a>\n</div>\n";

$setArray = $oldSetArray_9f812f38ee9fa49cfd276d45a7a3b595;
?>
