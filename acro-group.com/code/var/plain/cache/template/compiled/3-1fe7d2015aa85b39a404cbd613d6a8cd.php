<?php
// URI:       design:error/kernel/3.tpl
// Filename:  design/standard/templates/error/kernel/3.tpl
// Timestamp: 1089197122 (Wed Jul 7 13:45:22 BST 2004)
$oldSetArray_ce29ead5994d3ede912071c914174aec = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "\n<!-- START: including template: design/standard/templates/error/kernel/3.tpl (design:error/kernel/3.tpl) -->\n<p class=\"small\">design/standard/templates/error/kernel/3.tpl</p><br/>\n\n<div class=\"warning\">\n<h2>Object is unavailable</h2>\n<p>The object you requested is not currently available.</p>\n<p>Possible reasons for this is.</p>\n<ul>\n    <li>The id or name of the object was misspelled, try changing it.</li>\n    <li>The object is no longer available on the site.</li>\n</ul>\n</div>\n";
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

$text .= "\n<!-- STOP: including template: design/standard/templates/error/kernel/3.tpl (design:error/kernel/3.tpl) -->\n";

$setArray = $oldSetArray_ce29ead5994d3ede912071c914174aec;
?>
