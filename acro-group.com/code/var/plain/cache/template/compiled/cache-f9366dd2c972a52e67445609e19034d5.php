<?php
// URI:       design:setup/cache.tpl
// Filename:  design/standard/templates/setup/cache.tpl
// Timestamp: 1089197124 (Wed Jul 7 13:45:24 BST 2004)
$oldSetArray_6622afd8bb1b65204bfcae516325ac54 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "\n<form method=\"post\" action=\"/index.php/admin_acro/setup/cache\">\n\n<h1>Cache admin</h1>\n";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_cleared", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_cleared"] : null;
$show1 = compiledFetchAttribute( $show, "content" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "<div class=\"feedback\">\nContent view cache was cleared.\n</div>";
}

unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_cleared", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_cleared"] : null;
$show1 = compiledFetchAttribute( $show, "all" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "<div class=\"feedback\">\nAll caches were cleared.\n</div>";
}

unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_cleared", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_cleared"] : null;
$show1 = compiledFetchAttribute( $show, "ini" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "<div class=\"feedback\">\nIni file cache was cleared.\n</div>";
}

unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_cleared", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_cleared"] : null;
$show1 = compiledFetchAttribute( $show, "template" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "<div class=\"feedback\">\nTemplate cache was cleared.\n</div>";
}

unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_cleared", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_cleared"] : null;
$show1 = compiledFetchAttribute( $show, "list" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "<div class=\"feedback\">";
    unset( $loopItem );
    $loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_cleared", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_cleared"] : null;
    $loopItem1 = compiledFetchAttribute( $loopItem, "list" );
    unset( $loopItem );
    $loopItem = $loopItem1;

    $namespaceStack[] = $currentNamespace;
    $currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'Cache';

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

        if ( $currentIndex > 1 )
        {
            $text .= "<br/>";
        }

        unset( $var3 );
        $var3 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var4 = compiledFetchAttribute( $var3, "name" );
        unset( $var3 );
        $var3 = $var4;
        $var2 = array( '%name' => $var3 );        unset( $var3 );
        $var3 = array();
        foreach ( $var2 as $var4 => $var5 )
        {
          if ( is_int( $var4 ) )
            $var3['%' . ( ($var4%9) + 1 )] = $var5;
          else
            $var3[$var4] = $var5;
        }
        $var = strtr( "%name was cleared.", $var3 );
        unset( $var2, $var3, $var4, $var5 );
        $text .= $var;
        unset( $var );

        list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
        ++$currentIndex;

        ++$index;

    }
    unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
    $currentNamespace = array_pop( $namespaceStack );

    $text .= "</div>";
}

$text .= "\n<div class=\"objectheader\">\n<h2>Cache collections</h2>\n</div>\n\n<div class=\"object\">\n    <p>Click a button to clear a collection of caches.</p>\n\n\n    <table>\n    <tr>\n        <td><p>All caches.</p></td>\n        <td><div class=\"buttonblock\">\n        ";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_enabled", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_enabled"] : null;
$show1 = compiledFetchAttribute( $show, "all" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "        <input type=\"submit\" name=\"ClearAllCacheButton\" value=\"All caches\" />\n        ";
}
else
{

    unset( $show );

    $text .= "            <p>All caches are disabled</p>\n        ";
}

$text .= "    </div></td>\n    </tr>\n\n    <tr>\n        <td><p>Content views and template blocks.</p></td>\n        <td>\n        ";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_enabled", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_enabled"] : null;
$show1 = compiledFetchAttribute( $show, "content" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "        <input type=\"submit\" name=\"ClearContentCacheButton\" value=\"Content caches\" />\n        ";
}
else
{

    unset( $show );

    $text .= "            <p>Content caches is disabled</p>\n        ";
}

$text .= "        </td>\n    </tr>\n\n    <tr>\n        <td><p>Template overrides and template compiling.</p></td>\n        <td>\n        ";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_enabled", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_enabled"] : null;
$show1 = compiledFetchAttribute( $show, "template" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "        <input type=\"submit\" name=\"ClearTemplateCacheButton\" value=\"Template caches\" />\n        ";
}
else
{

    unset( $show );

    $text .= "            <p>Template caches are disabled</p>\n        ";
}

$text .= "        </td>\n    </tr>\n\n    <tr>\n        <td><p>INI caches.</p></td>\n        <td>\n        ";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_enabled", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_enabled"] : null;
$show1 = compiledFetchAttribute( $show, "ini" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "        <input type=\"submit\" name=\"ClearINICacheButton\" value=\"INI caches\" />\n        ";
}
else
{

    unset( $show );

    $text .= "            <p>INI cache is disabled</p>\n        ";
}

$text .= "        </td>\n    </tr>\n\n    </table>\n\n</div>\n\n<table class=\"list\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">\n<tr>\n    <th width=\"50%\">Name</th>\n    <th width=\"50%\">Path</th>\n    <th width=\"1\">Selection</th>\n</tr>";
unset( $loopItem );
$loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_list", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_list"] : null;

$sequence = array( "bglight",
       "bgdark" );
$namespaceStack[] = $currentNamespace;
$currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'Cache';

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
    if ( is_array( $sequence ) )
    {
        $sequenceValue = array_shift( $sequence );

    $vars[$currentNamespace]["sequence"] = $sequenceValue;
        $sequence[] = $sequenceValue;
        unset( $sequenceValue );
    }
    $sectionStack[] = array( &$loopItem, $loopKeys, $loopCount, $currentIndex, $index, $sequence );
    unset( $loopItem, $loopKeys );

    $text .= "<tr class=\"";
    unset( $var );
    $var = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "sequence", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["sequence"] : null;
    while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
        $var = $var->templateValue();
    $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
    unset( $var );

    $text .= "\">\n    <td>";
    unset( $var );
    $var = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
    $var1 = compiledFetchAttribute( $var, "name" );
    unset( $var );
    $var = $var1;
    while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
        $var = $var->templateValue();
    $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
    unset( $var );

    $text .= "</td>\n    <td>";
    unset( $var );
    $var = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
    $var1 = compiledFetchAttribute( $var, "path" );
    unset( $var );
    $var = $var1;
    while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
        $var = $var->templateValue();
    $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
    unset( $var );

    $text .= "</td>";
    unset( $show );
    $show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "cache_enabled", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["cache_enabled"] : null;
    $show1 = compiledFetchAttribute( $show, "list" );
    unset( $show );
    $show = $show1;
    unset( $show2 );
    $show2 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
    $show3 = compiledFetchAttribute( $show2, "id" );
    unset( $show2 );
    $show2 = $show3;
    $show1 = compiledFetchAttribute( $show, $show2 );
    unset( $show );
    $show = $show1;

    if ( $show )
    {

        unset( $show );

        $text .= "    <td align=\"right\"><input type=\"checkbox\" name=\"CacheList[]\" value=\"";
        unset( $var );
        $var = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var1 = compiledFetchAttribute( $var, "id" );
        unset( $var );
        $var = $var1;
        while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
            $var = $var->templateValue();
        $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
        unset( $var );

        $text .= "\" /></td>";
    }
    else
    {

        unset( $show );

        $text .= "    <td align=\"right\">Disabled</td>";
    }

    $text .= "</tr>";
    list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index, $sequence ) = array_pop( $sectionStack );
    ++$currentIndex;

    ++$index;

}
unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem, $sequence );
$currentNamespace = array_pop( $namespaceStack );

$text .= "</table>\n\n<div class=\"buttonblock\" align=\"right\">\n    <input type=\"submit\" name=\"ClearCacheButton\" value=\"Clear selected\" />\n</div>\n\n\n\n</form>\n";

$setArray = $oldSetArray_6622afd8bb1b65204bfcae516325ac54;
?>
