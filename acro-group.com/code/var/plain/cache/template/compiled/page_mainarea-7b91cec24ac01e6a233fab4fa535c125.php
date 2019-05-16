<?php
// URI:       design/standard/templates/page_mainarea.tpl
// Filename:  design/standard/templates/page_mainarea.tpl
// Timestamp: 1089197124 (Wed Jul 7 13:45:24 BST 2004)
$oldSetArray_20ed7320ab54522f6f6a0647c57a4a09 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$oldRestoreIncludeArray_192cd76fe05b83f373b490293764288c = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( !isset( $dKeys ) )
{
    $resH =& $tpl->resourceHandler( "design" );
    $dKeys =& $resH->keys();
}

$resourceFound = false;
if ( file_exists( "var/plain/cache/template/compiled/page_warning-c4d24cfcbc1042daa753ccc1fde83931.php" ) )
{
    $resourceFound = true;
    $namespaceStack[] = array( $rootNamespace, $currentNamespace );
    $currentNamespace = $rootNamespace;
    include( "var/plain/cache/template/compiled/page_warning-c4d24cfcbc1042daa753ccc1fde83931.php" );
    list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
    $textElements = array();
    $extraParameters = array();
    $tpl->processURI( "design/standard/templates/page_warning.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
    $text .= implode( '', $textElements );
}

foreach ( $restoreIncludeArray as $element )
{
    $vars[$element[0]][$element[1]] = $element[2];
}
$restoreIncludeArray = $oldRestoreIncludeArray_192cd76fe05b83f373b490293764288c;

$text .= "\n";
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "module_result", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["module_result"] : null;
$var1 = compiledFetchAttribute( $var, "content" );
unset( $var );
$var = $var1;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
unset( $var );

$text .= "\n";

$setArray = $oldSetArray_20ed7320ab54522f6f6a0647c57a4a09;
?>
