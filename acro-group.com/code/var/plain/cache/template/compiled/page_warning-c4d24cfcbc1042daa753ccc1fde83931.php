<?php
// URI:       design/standard/templates/page_warning.tpl
// Filename:  design/standard/templates/page_warning.tpl
// Timestamp: 1089197124 (Wed Jul 7 13:45:24 BST 2004)
$oldSetArray_f5c2fb34431e3e9c6a5dd383a4c4f2a4 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "warning_list", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["warning_list"] : null;

if ( $show )
{

    unset( $show );

    $text .= "<div class=\"error\">\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n  ";
    unset( $loopItem );
    $loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "warning_list", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["warning_list"] : null;

    $namespaceStack[] = $currentNamespace;
    $currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'Warning';

    if ( !isset( $sectionStack ) )
        $sectionStack = array();
    $index = 0;
    $currentIndex = 1;
    if ( is_array( $loopItem ) )
    {
        $loopKeys = array_keys( $loopItem );
        $loopCount = count( $loopKeys );
    }
    else if ( is_numeric( $loopItem ) )
    {
        $loopKeys = false;
        if ( $loopItem < 0 )
            $loopCountValue = -$loopItem;
        else
            $loopCountValue = $loopItem;
        $loopCount = $loopCountValue - 0;
    }
    else if ( is_string( $loopItem ) )
    {
        $loopKeys = false;
        $loopCount = strlen( $loopItem ) - 0;
    }
    else
    {
        $loopKeys = false;
        $loopCount = 0;
    }
    while ( $index < $loopCount )
    {
        if ( is_array( $loopItem ) )
        {
            $loopKey = $loopKeys[$index];
            unset( $item );
            $item = $loopItem[$loopKey];
        }
        else if ( is_numeric( $loopItem ) )
        {
            unset( $item );
            $item = $index + 0 + 1;
            if ( $loopItem < 0 )
                $item = -$item;
            $loopKey = $index + 0;
        }
        else if ( is_string( $loopItem ) )
        {
            unset( $item );
            $loopKey = $index + 0;
            $item = $loopItem[$loopKey];
        }
        unset( $last );
        $last = false;

        $vars[$currentNamespace]["key"] = $loopKey;
        $vars[$currentNamespace]["item"] = $item;
    $currentIndexInc = $currentIndex - 1;

        $vars[$currentNamespace]["index"] = $currentIndexInc;
        $vars[$currentNamespace]["number"] = $currentIndex;
        $sectionStack[] = array( &$loopItem, $loopKeys, $loopCount, $currentIndex, $index );
        unset( $loopItem, $loopKeys );

        $text .= "<tr>\n    <td>\n      <h3 class=\"error\">";
        $namespace = $rootNamespace;
        if ( $namespace == '' )
            $namespace = "Warning";
        else
            $namespace .= ':Warning';
        unset( $var );
        $var = ( array_key_exists( $namespace, $vars ) and array_key_exists( "item", $vars[$namespace] ) ) ? $vars[$namespace]["item"] : null;
        $var1 = compiledFetchAttribute( $var, "error" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "type" );
        unset( $var );
        $var = $var1;
        while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
            $var = $var->templateValue();
        $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
        unset( $var );

        $text .= " (";
        $namespace = $rootNamespace;
        if ( $namespace == '' )
            $namespace = "Warning";
        else
            $namespace .= ':Warning';
        unset( $var );
        $var = ( array_key_exists( $namespace, $vars ) and array_key_exists( "item", $vars[$namespace] ) ) ? $vars[$namespace]["item"] : null;
        $var1 = compiledFetchAttribute( $var, "error" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "number" );
        unset( $var );
        $var = $var1;
        while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
            $var = $var->templateValue();
        $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
        unset( $var );

        $text .= ")</h3>\n      <ul class=\"error\">\n        <li>";
        $namespace = $rootNamespace;
        if ( $namespace == '' )
            $namespace = "Warning";
        else
            $namespace .= ':Warning';
        unset( $var );
        $var = ( array_key_exists( $namespace, $vars ) and array_key_exists( "item", $vars[$namespace] ) ) ? $vars[$namespace]["item"] : null;
        $var1 = compiledFetchAttribute( $var, "text" );
        unset( $var );
        $var = $var1;
        while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
            $var = $var->templateValue();
        $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
        unset( $var );

        $text .= "</li>\n      </ul>\n    </td>\n</tr>\n  ";
        list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
        ++$currentIndex;

        ++$index;

    }
    unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
    $currentNamespace = array_pop( $namespaceStack );

    $text .= "</table>\n</div>";
}


$setArray = $oldSetArray_f5c2fb34431e3e9c6a5dd383a4c4f2a4;
?>
