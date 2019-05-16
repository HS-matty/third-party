<?php
// URI:       design/standard/templates/link.tpl
// Filename:  design/standard/templates/link.tpl
// Timestamp: 1089197122 (Wed Jul 7 13:45:22 BST 2004)
$oldSetArray_de9c1b65151a28955d85db1c9825c828 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "\n";
if ( !isset( $vars[$currentNamespace]["enable_print"] ) )
{
    $vars[$currentNamespace]["enable_print"] = true;
    $setArray[$currentNamespace]["enable_print"] = true;
}

$text .= "\n<link rel=\"Home\" href=\"/index.php/admin_acro\" title=\"";
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
$var4 = compiledFetchAttribute( $var3, "title" );
unset( $var3 );
$var3 = $var4;
$var2 = array( '%sitetitle' => $var3 );unset( $var3 );
$var3 = array();
foreach ( $var2 as $var4 => $var5 )
{
  if ( is_int( $var4 ) )
    $var3['%' . ( ($var4%9) + 1 )] = $var5;
  else
    $var3[$var4] = $var5;
}
$var = strtr( "%sitetitle front page", $var3 );
unset( $var2, $var3, $var4, $var5 );
$text .= $var;
unset( $var );

$text .= "\" />\n<link rel=\"Index\" href=\"/index.php/admin_acro\" />\n<link rel=\"Top\"  href=\"/index.php/admin_acro\" title=\"";
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site_title", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site_title"] : null;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
unset( $var );

$text .= "\" />\n<link rel=\"Search\" href=\"/index.php/admin_acro/content/advancedsearch\" title=\"";
unset( $var3 );
$var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
$var4 = compiledFetchAttribute( $var3, "title" );
unset( $var3 );
$var3 = $var4;
$var2 = array( '%sitetitle' => $var3 );unset( $var3 );
$var3 = array();
foreach ( $var2 as $var4 => $var5 )
{
  if ( is_int( $var4 ) )
    $var3['%' . ( ($var4%9) + 1 )] = $var5;
  else
    $var3[$var4] = $var5;
}
$var = strtr( "Search %sitetitle", $var3 );
unset( $var2, $var3, $var4, $var5 );
$text .= $var;
unset( $var );

$text .= "\" />\n<link rel=\"Shortcut icon\" href=\"/design/standard/images/favicon.ico\" type=\"image/x-icon\" />\n<link rel=\"Copyright\" href=\"/index.php/admin_acro/ezinfo/copyright\" />\n<link rel=\"Author\" href=\"/index.php/admin_acro/ezinfo/about\" />\n";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "enable_print", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["enable_print"] : null;

if ( $show )
{

    unset( $show );

    $text .= "<link rel=\"Alternate\" href=";
    unset( $var3 );
    $var3 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
    $var4 = compiledFetchAttribute( $var3, "uri" );
    unset( $var3 );
    $var3 = $var4;
    $var4 = compiledFetchAttribute( $var3, "tail" );
    unset( $var3 );
    $var3 = $var4;
    while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
        $var3 = $var3->templateValue();
    $var1 = ( "layout/set/print/" . $var3 );
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

    $text .= " media=\"print\" title=\"Printable version\" />";
}

if ( isset( $setArray[$currentNamespace]["enable_print"] ) )
{
    unset( $vars[$currentNamespace]["enable_print"] );
}


$setArray = $oldSetArray_de9c1b65151a28955d85db1c9825c828;
?>
