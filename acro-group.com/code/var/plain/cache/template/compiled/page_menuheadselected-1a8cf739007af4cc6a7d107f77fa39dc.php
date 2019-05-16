<?php
// URI:       design/admin/templates/page_menuheadselected.tpl
// Filename:  design/admin/templates/page_menuheadselected.tpl
// Timestamp: 1089197114 (Wed Jul 7 13:45:14 BST 2004)
$oldSetArray_712750d3106f507d487997a5e31e6f24 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n<tr>\n    <td class=\"menuheadselectedgfx\">\n    <img src=\"/design/admin/images/light-left-corner.gif\" alt=\"\"/></td>\n    <td style=\"background-color: #c1d5ef; background-image:url('/design/admin/images/light-top.gif'); background-repeat: repeat;\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"60\" height=\"1\" /></td>\n    <td class=\"menuheadselectedgfx\">\n    <img src=\"/design/admin/images/light-right-corner.gif\" alt=\"\"/></td>\n</tr>\n<tr>\n    <td style=\"background-color: #c1d5ef; background-image:url('/design/admin/images/bgtilelight.gif'); background-position: left bottom; background-repeat: repeat;\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"1\" height=\"19\" /></td>\n    <td style=\"background-color: #c1d5ef; color: #4373b4; text-align: center;  background-image:url('/design/admin/images/bgtilelight.gif'); background-position: left bottom; background-repeat: repeat;\">\n    <p class=\"menuheadselected\">\n    <a class=\"menuheadlink\" href=";
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "menu_url", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["menu_url"] : null;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
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

$text .= ">";
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "menu_text", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["menu_text"] : null;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = htmlspecialchars( $var1 );
unset( $var1 );
$text .= $var;
unset( $var );

$text .= "</a>\n    </p>\n    </td>\n    <td style=\"background-color: #c1d5ef;background-image:url('/design/admin/images/bgtilelight.gif'); background-position: left bottom; background-repeat: repeat;\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"1\" height=\"19\" /></td>\n</tr>\n</table>\n";

$setArray = $oldSetArray_712750d3106f507d487997a5e31e6f24;
?>
