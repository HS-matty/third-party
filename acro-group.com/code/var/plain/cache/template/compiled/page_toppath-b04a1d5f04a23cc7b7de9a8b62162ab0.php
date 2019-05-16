<?php
// URI:       design/admin/templates/page_toppath.tpl
// Filename:  design/admin/templates/page_toppath.tpl
// Timestamp: 1089197114 (Wed Jul 7 13:45:14 BST 2004)
$oldSetArray_505689049b1a5acae4a81d53eff84884 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$var = ( ( "enabled" ) == ( "enabled" ) );
$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "Path";
else
    $namespace .= ':Path';
$vars[$namespace]["use_urlalias"] = $var;
unset( $var );
$namespaceStack[] = $currentNamespace;
$currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'Path';

$text .= "\n    <p class=\"path\">\n    ";
unset( $loopItem );
$loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "module_result", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["module_result"] : null;
$loopItem1 = compiledFetchAttribute( $loopItem, "path" );
unset( $loopItem );
$loopItem = $loopItem1;

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
        $text .= "            <span class=\"slash\">/</span>\n        ";
    }

    $text .= "        ";
    unset( $show );
    $show = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
    $show1 = compiledFetchAttribute( $show, "url" );
    unset( $show );
    $show = $show1;

    if ( $show )
    {

        unset( $show );

        $text .= "            <a class=\"path\" href=";
        unset( $var3 );
        $var3 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "use_urlalias", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["use_urlalias"] : null;
        while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
            $var3 = $var3->templateValue();
        unset( $var5 );
        $var5 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var6 = compiledFetchAttribute( $var5, "url_alias" );
        unset( $var5 );
        $var5 = $var6;
        while ( is_object( $var5 ) and method_exists( $var5, 'templateValue' ) )
            $var5 = $var5->templateValue();
        $var4 = isset( $var5 );        unset( $var5 );
        if ( !$var3 )
            $var2 = false;
        else if ( !$var4 )
            $var2 = false;
        else
            $var2 = $var4;
        unset( $var3, $var4 );
        if ( $var2 )
        {
                    unset( $var3 );
                $var3 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
                $var4 = compiledFetchAttribute( $var3, "url_alias" );
                unset( $var3 );
                $var3 = $var4;
        while ( is_object( $var3 ) and method_exists( $var3, 'templateValue' ) )
            $var3 = $var3->templateValue();

            $var1 = $var3;
        }
        else
        {
                    unset( $var4 );
                $var4 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
                $var5 = compiledFetchAttribute( $var4, "url" );
                unset( $var4 );
                $var4 = $var5;
        while ( is_object( $var4 ) and method_exists( $var4, 'templateValue' ) )
            $var4 = $var4->templateValue();

            $var1 = $var4;
        }
        unset( $var2, $var3, $var4 );
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
        unset( $var2 );
        $var2 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var3 = compiledFetchAttribute( $var2, "text" );
        unset( $var2 );
        $var2 = $var3;
        while ( is_object( $var2 ) and method_exists( $var2, 'templateValue' ) )
            $var2 = $var2->templateValue();
        $length = 80; $seq = "...";
                                                                          if ( 2 > 1 )
                                                                          {
                                                                              $length = 18;
                                                                          }
                                                                          if ( 2 > 2 )
                                                                          {
                                                                              $seq = $staticValues[2];
                                                                          }
                                                                          $maxLength = $length - strlen( $seq );
                                                                          if ( ( strlen( $var2 ) > $length ) && strlen( $var2 ) > $maxLength )
                                                                          {
                                                                              $var1 = trim( substr( $var2, 0, $maxLength) ) . $seq;
                                                                          }
                                                                          else
                                                                          {
                                                                              $var1 = $var2;
                                                                          }
        unset( $var2 );
        $var = htmlspecialchars( $var1 );
        unset( $var1 );
        $text .= $var;
        unset( $var );

        $text .= "</a>\n        ";
    }
    else
    {

        unset( $show );

        $text .= "            ";
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

        $text .= "\n        ";
    }

    $text .= "\n            ";
    list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
    ++$currentIndex;

    ++$index;

}
unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
$text .= "    &nbsp;</p>";
$currentNamespace = array_pop( $namespaceStack );

$namespace = $currentNamespace;
if ( $namespace == '' )
    $namespace = "Path";
else
    $namespace .= ':Path';
if ( isset( $setArray[$namespace]["use_urlalias"] ) )
{
    unset( $vars[$namespace]["use_urlalias"] );
}


$setArray = $oldSetArray_505689049b1a5acae4a81d53eff84884;
?>
