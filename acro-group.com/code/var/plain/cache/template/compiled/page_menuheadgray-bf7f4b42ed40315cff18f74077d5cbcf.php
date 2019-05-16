<?php
// URI:       design/admin/templates/page_menuheadgray.tpl
// Filename:  design/admin/templates/page_menuheadgray.tpl
// Timestamp: 1089197114 (Wed Jul 7 13:45:14 BST 2004)
$oldSetArray_f6d28f853e495f67fccb0ed73bcba7e4 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "\n<table width=\"66\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n<tr>\n    <td class=\"menuheadgraygfx\" width=\"3\">\n    <img src=\"/design/admin/images/dark-left-corner.gif\" alt=\"\"/></td>\n    <td class=\"menuheadgraytopline\" width=\"60\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"60\" height=\"1\" /></td>\n    <td class=\"menuheadgraygfx\" width=\"3\">\n    <img src=\"/design/admin/images/dark-right-corner.gif\" alt=\"\"/></td>\n</tr>\n<tr>\n    <td class=\"menuheadgrayleftline\" width=\"3\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"1\" height=\"15\" /></td>\n    <td class=\"menuheadgray\">\n    <p class=\"menuheadselected\">\n    <a class=\"menuheadlinkgray\" href=";
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

$text .= "</a>\n    </p>\n    </td>\n    <td class=\"menuheadgrayrightline\" width=\"3\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"1\" height=\"15\" /></td>\n</tr>\n</table>";

$setArray = $oldSetArray_f6d28f853e495f67fccb0ed73bcba7e4;
?>
