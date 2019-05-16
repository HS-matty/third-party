<?php
// URI:       design/standard/templates/page_head.tpl
// Filename:  design/standard/templates/page_head.tpl
// Timestamp: 1089197124 (Wed Jul 7 13:45:24 BST 2004)
$oldSetArray_5d28fd8ce371b6950f608e398d5addc8 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "\n";
if ( !isset( $vars[$currentNamespace]["enable_help"] ) )
{
    $vars[$currentNamespace]["enable_help"] = true;
    $setArray[$currentNamespace]["enable_help"] = true;
}

if ( !isset( $vars[$currentNamespace]["enable_link"] ) )
{
    $vars[$currentNamespace]["enable_link"] = true;
    $setArray[$currentNamespace]["enable_link"] = true;
}

unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "module_result", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["module_result"] : null;
$var1 = compiledFetchAttribute( $var, "path" );
unset( $var );
$var = $var1;
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "Path";
else
    $namespace .= ':Path';
$vars[$namespace]["path"] = $var;
unset( $var );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "Path";
else
    $namespace .= ':Path';
$vars[$namespace]["reverse_path"] = array();
$namespaceStack[] = $currentNamespace;
$currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'Path';

$text .= "  ";
unset( $show1 );
$show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "module_result", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["module_result"] : null;
$show2 = compiledFetchAttribute( $show1, "title_path" );
unset( $show1 );
$show1 = $show2;
while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
    $show1 = $show1->templateValue();
$show = isset( $show1 );unset( $show1 );

if ( $show )
{

    unset( $show );

    $text .= "    ";
    unset( $var );
    $var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "module_result", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["module_result"] : null;
    $var1 = compiledFetchAttribute( $var, "title_path" );
    unset( $var );
    $var = $var1;
    if ( isset( $vars[$currentNamespace]["path"] ) )
    {
        $vars[$currentNamespace]["path"] = $var;
        unset( $var );
    }
    $text .= "  ";
}

$text .= "  ";
unset( $loopItem );
$loopItem = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "path", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["path"] : null;

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

    $text .= "    ";
    unset( $var1 );
    $var1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
    while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
        $var1 = $var1->templateValue();
    unset( $var2 );
    $var2 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "reverse_path", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["reverse_path"] : null;
    while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
        $var2 = $var2->templateValue();
    $var = array_merge( array( $var1 ), $var2 );
    unset( $var1, $var2 );
    if ( isset( $vars[$currentNamespace]["reverse_path"] ) )
    {
        $vars[$currentNamespace]["reverse_path"] = $var;
        unset( $var );
    }
    $text .= "  ";
    list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
    ++$currentIndex;

    ++$index;

}
unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
if ( !isset( $textStack ) )
    $textStack = array();
$textStack[] = $text;
$text = '';
$namespace = $rootNamespace;
if ( $namespace == '' )
    $namespace = "Path";
else
    $namespace .= ':Path';
unset( $loopItem );
$loopItem = ( array_key_exists( $namespace, $vars ) and array_key_exists( "reverse_path", $vars[$namespace] ) ) ? $vars[$namespace]["reverse_path"] : null;

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
        $text .= " / ";
    }

    unset( $var1 );
    $var1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
    $var2 = compiledFetchAttribute( $var1, "text" );
    unset( $var1 );
    $var1 = $var2;
    while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
        $var1 = $var1->templateValue();
    $var = htmlspecialchars( $var1 );
    unset( $var1 );
    $text .= $var;
    unset( $var );

    list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
    ++$currentIndex;

    ++$index;

}
unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
$text .= " - ";
unset( $var1 );
$var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
$var2 = compiledFetchAttribute( $var1, "title" );
unset( $var1 );
$var1 = $var2;
while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
    $var1 = $var1->templateValue();
$var = htmlspecialchars( $var1 );
unset( $var1 );
$text .= $var;
unset( $var );

$blockText = $text;
$vars[$rootNamespace]["site_title"] = $blockText;
unset( $blockText );

$text = array_pop( $textStack );
$currentNamespace = array_pop( $namespaceStack );

$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "Path";
else
    $namespace .= ':Path';
if ( isset( $setArray[$namespace]["path"] ) )
{
    unset( $vars[$namespace]["path"] );
}

$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "Path";
else
    $namespace .= ':Path';
if ( isset( $setArray[$namespace]["reverse_path"] ) )
{
    unset( $vars[$namespace]["reverse_path"] );
}

$text .= "\n    <title>";
unset( $var );
$var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site_title", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site_title"] : null;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
$text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
unset( $var );

$text .= "</title>\n\n    ";
$namespace = "Header";
unset( $show2 );
$show2 = ( array_key_exists( $namespace, $vars ) and array_key_exists( "extra_data", $vars[$namespace] ) ) ? $vars[$namespace]["extra_data"] : null;
while ( is_object( $show2 ) and method_exists( $show2, 'templateValue' ) )
    $show2 = $show2->templateValue();
$show1 = isset( $show2 );unset( $show2 );
$namespace = "Header";
unset( $show3 );
$show3 = ( array_key_exists( $namespace, $vars ) and array_key_exists( "extra_data", $vars[$namespace] ) ) ? $vars[$namespace]["extra_data"] : null;
while ( is_object( $show3 ) and method_exists( $show3, 'templateValue' ) )
    $show3 = $show3->templateValue();
$show2 = is_array( $show3 );unset( $show3 );
if ( !$show1 )
    $show = false;
else if ( !$show2 )
    $show = false;
else
    $show = $show2;
unset( $show1, $show2 );

if ( $show )
{

    unset( $show );

    $text .= "      ";
    $namespace = "Header";
    unset( $loopItem );
    $loopItem = ( array_key_exists( $namespace, $vars ) and array_key_exists( "extra_data", $vars[$namespace] ) ) ? $vars[$namespace]["extra_data"] : null;

    $namespaceStack[] = $currentNamespace;
    $currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'ExtraData';

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

        $text .= "      ";
        unset( $var );
        $var = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
            $var = $var->templateValue();
        $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
        unset( $var );

        $text .= "\n      ";
        list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
        ++$currentIndex;

        ++$index;

    }
    unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
    $currentNamespace = array_pop( $namespaceStack );

    $text .= "    ";
}

$text .= "\n    \n    ";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
$show1 = compiledFetchAttribute( $show, "redirect" );
unset( $show );
$show = $show1;

if ( $show )
{

    unset( $show );

    $text .= "    <meta http-equiv=\"Refresh\" content=\"";
    unset( $var );
    $var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
    $var1 = compiledFetchAttribute( $var, "redirect" );
    unset( $var );
    $var = $var1;
    $var1 = compiledFetchAttribute( $var, "timer" );
    unset( $var );
    $var = $var1;
    while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
        $var = $var->templateValue();
    $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
    unset( $var );

    $text .= "; URL=";
    unset( $var );
    $var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
    $var1 = compiledFetchAttribute( $var, "redirect" );
    unset( $var );
    $var = $var1;
    $var1 = compiledFetchAttribute( $var, "location" );
    unset( $var );
    $var = $var1;
    while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
        $var = $var->templateValue();
    $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
    unset( $var );

    $text .= "\" />\n\n    ";
}

$text .= "\n    ";
unset( $loopItem );
$loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
$loopItem1 = compiledFetchAttribute( $loopItem, "http_equiv" );
unset( $loopItem );
$loopItem = $loopItem1;

$namespaceStack[] = $currentNamespace;
$currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'HTTP';

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

    $text .= "    <meta http-equiv=\"";
    $namespace = $rootNamespace;
    if ( $namespace == '' )
        $namespace = "HTTP";
    else
        $namespace .= ':HTTP';
    unset( $var1 );
    $var1 = ( array_key_exists( $namespace, $vars ) and array_key_exists( "key", $vars[$namespace] ) ) ? $vars[$namespace]["key"] : null;
    while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
        $var1 = $var1->templateValue();
    $var = htmlspecialchars( $var1 );
    unset( $var1 );
    $text .= $var;
    unset( $var );

    $text .= "\" content=\"";
    $namespace = $rootNamespace;
    if ( $namespace == '' )
        $namespace = "HTTP";
    else
        $namespace .= ':HTTP';
    unset( $var1 );
    $var1 = ( array_key_exists( $namespace, $vars ) and array_key_exists( "item", $vars[$namespace] ) ) ? $vars[$namespace]["item"] : null;
    while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
        $var1 = $var1->templateValue();
    $var = htmlspecialchars( $var1 );
    unset( $var1 );
    $text .= $var;
    unset( $var );

    $text .= "\" />\n\n    ";
    list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
    ++$currentIndex;

    ++$index;

}
unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
$currentNamespace = array_pop( $namespaceStack );

$text .= "\n    ";
unset( $loopItem );
$loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "site", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["site"] : null;
$loopItem1 = compiledFetchAttribute( $loopItem, "meta" );
unset( $loopItem );
$loopItem = $loopItem1;

$namespaceStack[] = $currentNamespace;
$currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'meta';

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

    $text .= "    <meta name=\"";
    $namespace = $rootNamespace;
    if ( $namespace == '' )
        $namespace = "meta";
    else
        $namespace .= ':meta';
    unset( $var1 );
    $var1 = ( array_key_exists( $namespace, $vars ) and array_key_exists( "key", $vars[$namespace] ) ) ? $vars[$namespace]["key"] : null;
    while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
        $var1 = $var1->templateValue();
    $var = htmlspecialchars( $var1 );
    unset( $var1 );
    $text .= $var;
    unset( $var );

    $text .= "\" content=\"";
    $namespace = $rootNamespace;
    if ( $namespace == '' )
        $namespace = "meta";
    else
        $namespace .= ':meta';
    unset( $var1 );
    $var1 = ( array_key_exists( $namespace, $vars ) and array_key_exists( "item", $vars[$namespace] ) ) ? $vars[$namespace]["item"] : null;
    while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
        $var1 = $var1->templateValue();
    $var = htmlspecialchars( $var1 );
    unset( $var1 );
    $text .= $var;
    unset( $var );

    $text .= "\" />\n\n    ";
    list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
    ++$currentIndex;

    ++$index;

}
unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
$currentNamespace = array_pop( $namespaceStack );

$text .= "\n    <meta name=\"MSSmartTagsPreventParsing\" content=\"TRUE\" />\n    <meta name=\"generator\" content=\"eZ publish\" />\n";
unset( $show );
$show = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "enable_link", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["enable_link"] : null;

if ( $show )
{

    unset( $show );

    $text .= "    ";
    $oldRestoreIncludeArray_6ebafc369b5065955dcb342d47e195ef = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
    $restoreIncludeArray = array();

    unset( $var );
    $var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "enable_help", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["enable_help"] : null;
    $vars[$currentNamespace]["enable_help"] = $var;
    unset( $var );
    $restoreIncludeArray[] = array( $currentNamespace, 'enable_help', $vars[$currentNamespace]['enable_help'] );

    unset( $var );
    $var = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "enable_link", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["enable_link"] : null;
    $vars[$currentNamespace]["enable_link"] = $var;
    unset( $var );
    $restoreIncludeArray[] = array( $currentNamespace, 'enable_link', $vars[$currentNamespace]['enable_link'] );

    if ( !isset( $dKeys ) )
    {
        $resH =& $tpl->resourceHandler( "design" );
        $dKeys =& $resH->keys();
    }

    $resourceFound = false;
    if ( file_exists( "var/plain/cache/template/compiled/link-0ff3dd81515f6adf3ca129e5aba08bdb.php" ) )
    {
        $resourceFound = true;
        $namespaceStack[] = array( $rootNamespace, $currentNamespace );
        $currentNamespace = $rootNamespace;
        include( "var/plain/cache/template/compiled/link-0ff3dd81515f6adf3ca129e5aba08bdb.php" );
        list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
    }
    else
    {
        $resourceFound = true;
        $textElements = array();
        $extraParameters = array();
        $tpl->processURI( "design/standard/templates/link.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
        $text .= implode( '', $textElements );
    }

    foreach ( $restoreIncludeArray as $element )
    {
        $vars[$element[0]][$element[1]] = $element[2];
    }
    $restoreIncludeArray = $oldRestoreIncludeArray_6ebafc369b5065955dcb342d47e195ef;

}

if ( isset( $setArray[$currentNamespace]["enable_help"] ) )
{
    unset( $vars[$currentNamespace]["enable_help"] );
}

if ( isset( $setArray[$currentNamespace]["enable_link"] ) )
{
    unset( $vars[$currentNamespace]["enable_link"] );
}


$setArray = $oldSetArray_5d28fd8ce371b6950f608e398d5addc8;
?>
