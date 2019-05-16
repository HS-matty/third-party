<?php
// URI:       design:error/kernel/20.tpl
// Filename:  design/standard/templates/error/kernel/20.tpl
// Timestamp: 1089197122 (Wed Jul 7 13:45:22 BST 2004)
$oldSetArray_cad665b96b00e816445ac946820c9c5b = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/ez/cache/template/compiled/common.php" );

$text .= "\n<!-- START: including template: design/standard/templates/error/kernel/20.tpl (design:error/kernel/20.tpl) -->\n<p class=\"small\">design/standard/templates/error/kernel/20.tpl</p><br/>\n\n<div class=\"warning\">\n<h2>Module not found</h2>\n<p>";
unset( $var4 );
$var4 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "parameters", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["parameters"] : null;
$var5 = compiledFetchAttribute( $var4, "module" );
unset( $var4 );
$var4 = $var5;
while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
    $var4 = $var4->templateValue();
$var3 = htmlspecialchars( $var4 );
unset( $var4 );
$var2 = array( '%module' => $var3 );unset( $var3 );
$var3 = array();
foreach ( $var2 as $var4 => $var5 )
{
  if ( is_int( $var4 ) )
    $var3['%' . ( ($var4%9) + 1 )] = $var5;
  else
    $var3[$var4] = $var5;
}
$var = strtr( "The requested module %module could not be found.", $var3 );
unset( $var2, $var3, $var4, $var5 );
$text .= $var;
unset( $var );

$text .= "</p>\n<p>Possible reasons for this is.</p>\n<ul>\n    <li>The module name was misspelled, try changing the url.</li>\n    <li>The module does not exist on this site.</li>\n    <li>This site uses siteaccess matching in the url and you didn't supply one, try inserting a siteaccess name before the module in the url .</li>\n</ul>\n</div>\n";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "embed_content", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["embed_content"] : null;

if ( $show )
{

    unset( $show );

    $text .= "\n";
    unset( $var );
    $var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "embed_content", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["embed_content"] : null;
    while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
        $var = $var->templateValue();
    $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
    unset( $var );

}

$text .= "\n<!-- STOP: including template: design/standard/templates/error/kernel/20.tpl (design:error/kernel/20.tpl) -->\n";

$setArray = $oldSetArray_cad665b96b00e816445ac946820c9c5b;
?>
