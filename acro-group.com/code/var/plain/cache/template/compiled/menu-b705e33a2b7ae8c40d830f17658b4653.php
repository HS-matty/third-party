<?php
// URI:       design/admin/templates/parts/content/menu.tpl
// Filename:  design/admin/templates/parts/content/menu.tpl
// Timestamp: 1089197114 (Wed Jul 7 13:45:14 BST 2004)
$oldSetArray_10e867d9d0aa803b40dcb04003bc669a = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=";
$var1 = ( "/content/view/full/2/" . "2" );
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

$text .= ">Frontpage</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=\"/index.php/admin_acro/content/view/sitemap/2\">Sitemap</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n<a class=\"leftmenuitem\" href=";
$var1 = ( "/content/trash/" . "2" );
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

$text .= ">Trash</a>\n</div>\n\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n <a class=\"leftmenuitem\" href=\"/index.php/admin_acro/content/bookmark\">Bookmarks</a>";
include_once( 'kernel/classes/ezpreferences.php' );
$show1 = eZPreferences::value( "bookmark_menu" );
$show = ( ( $show1 ) == ( "on" ) );
unset( $show1 );

if ( $show )
{

    unset( $show );

    $text .= " <a href=\"/index.php/admin_acro/user/preferences/set/bookmark_menu/off\"><img src=\"/design/admin/images/down.gif\" alt=\"\" width=\"11\" height=\"6\" /></a>\n</div>\n<ul class=\"leftmenu\">";
    include_once( 'kernel/content/ezcontentfunctioncollection.php' );
    $var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchBookmarks' ),
      array(  ) );
    $var = isset( $var['result'] ) ? $var['result'] : null;
    $vars[$currentNamespace]["bookmark_list"] = $var;
    unset( $var );
    unset( $loopItem );
    $loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "bookmark_list", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["bookmark_list"] : null;

    $namespaceStack[] = $currentNamespace;
    $currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'BookMark';

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

        $text .= "<li>&#187; <a href=";
        unset( $var1 );
        $var1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var2 = compiledFetchAttribute( $var1, "node" );
        unset( $var1 );
        $var1 = $var2;
        $var2 = compiledFetchAttribute( $var1, "url_alias" );
        unset( $var1 );
        $var1 = $var2;
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
        unset( $var );
        $var = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var1 = compiledFetchAttribute( $var, "node" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "object" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "content_class" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "identifier" );
        unset( $var );
        $var = $var1;
        if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
        $varData = array( 'value' => $var );
        $tpl->processOperator( "class_icon",
                               array( array( array( 3,
                                                    "small",
                                                    false ) ),
                                      array( array( 4,
                                                    array( "",
                                                           3,
                                                           "item" ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "node",
                                                                  false ) ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "object",
                                                                  false ) ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "content_class",
                                                                  false ) ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "name",
                                                                  false ) ),
                                                    false ) ) ),
                               $rootNamespace, $currentNamespace, $varData, false, false );
        $var = $varData['value'];
        unset( $varData );
        while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
            $var = $var->templateValue();
        $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
        unset( $var );

        $text .= "&nbsp;";
        unset( $var1 );
        $var1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var2 = compiledFetchAttribute( $var1, "node" );
        unset( $var1 );
        $var1 = $var2;
        $var2 = compiledFetchAttribute( $var1, "name" );
        unset( $var1 );
        $var1 = $var2;
        while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
            $var1 = $var1->templateValue();
        $var = htmlspecialchars( $var1 );
        unset( $var1 );
        $text .= $var;
        unset( $var );

        $text .= "</a></li>";
        list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
        ++$currentIndex;

        ++$index;

    }
    unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
    $currentNamespace = array_pop( $namespaceStack );

if ( isset( $setArray[$currentNamespace]["bookmark_list"] ) )
{
        unset( $vars[$currentNamespace]["bookmark_list"] );
}

    $text .= "</ul>";
}
else
{

    unset( $show );

    $text .= " <a href=\"/index.php/admin_acro/user/preferences/set/bookmark_menu/on\"><img src=\"/design/admin/images/up.gif\" alt=\"\" width=\"11\" height=\"6\" /></a>\n</div>";
}

$text .= "\n<div style=\"width: 100%; padding-right: 4px; padding-left: 15px; padding-top: 4px; padding-bottom: 4px; margin-bottom:1px; background-image:url('/design/admin/images/bgtiledark.gif'); background-repeat: repeat;\">\n <a class=\"leftmenuitem\">History</a>";
include_once( 'kernel/classes/ezpreferences.php' );
$show1 = eZPreferences::value( "history_menu" );
$show = ( ( $show1 ) == ( "on" ) );
unset( $show1 );

if ( $show )
{

    unset( $show );

    $text .= " <a href=\"/index.php/admin_acro/user/preferences/set/history_menu/off\"><img src=\"/design/admin/images/down.gif\" alt=\"\" width=\"11\" height=\"6\" /></a>\n</div>\n<ul class=\"leftmenu\">";
    include_once( 'kernel/content/ezcontentfunctioncollection.php' );
    $var = call_user_func_array( array( new eZContentFunctionCollection(), 'fetchRecent' ),
      array(  ) );
    $var = isset( $var['result'] ) ? $var['result'] : null;
    $vars[$currentNamespace]["history_list"] = $var;
    unset( $var );
    unset( $loopItem );
    $loopItem = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "history_list", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["history_list"] : null;

    $namespaceStack[] = $currentNamespace;
    $currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'History';

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

        $text .= "<li>&#187; <a href=";
        unset( $var1 );
        $var1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var2 = compiledFetchAttribute( $var1, "node" );
        unset( $var1 );
        $var1 = $var2;
        $var2 = compiledFetchAttribute( $var1, "url_alias" );
        unset( $var1 );
        $var1 = $var2;
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
        unset( $var );
        $var = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var1 = compiledFetchAttribute( $var, "node" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "object" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "content_class" );
        unset( $var );
        $var = $var1;
        $var1 = compiledFetchAttribute( $var, "identifier" );
        unset( $var );
        $var = $var1;
        if (! isset( $var ) ) $var = NULL;
while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
    $var = $var->templateValue();
        $varData = array( 'value' => $var );
        $tpl->processOperator( "class_icon",
                               array( array( array( 3,
                                                    "small",
                                                    false ) ),
                                      array( array( 4,
                                                    array( "",
                                                           3,
                                                           "item" ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "node",
                                                                  false ) ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "object",
                                                                  false ) ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "content_class",
                                                                  false ) ),
                                                    false ),
                                             array( 5,
                                                    array( array( 3,
                                                                  "name",
                                                                  false ) ),
                                                    false ) ) ),
                               $rootNamespace, $currentNamespace, $varData, false, false );
        $var = $varData['value'];
        unset( $varData );
        while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
            $var = $var->templateValue();
        $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
        unset( $var );

        $text .= "&nbsp;";
        unset( $var1 );
        $var1 = ( array_key_exists( $currentNamespace, $vars ) and array_key_exists( "item", $vars[$currentNamespace] ) ) ? $vars[$currentNamespace]["item"] : null;
        $var2 = compiledFetchAttribute( $var1, "node" );
        unset( $var1 );
        $var1 = $var2;
        $var2 = compiledFetchAttribute( $var1, "name" );
        unset( $var1 );
        $var1 = $var2;
        while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
            $var1 = $var1->templateValue();
        $var = htmlspecialchars( $var1 );
        unset( $var1 );
        $text .= $var;
        unset( $var );

        $text .= "</a></li>";
        list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
        ++$currentIndex;

        ++$index;

    }
    unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
    $currentNamespace = array_pop( $namespaceStack );

if ( isset( $setArray[$currentNamespace]["history_list"] ) )
{
        unset( $vars[$currentNamespace]["history_list"] );
}

    $text .= "</ul>";
}
else
{

    unset( $show );

    $text .= " <a href=\"/index.php/admin_acro/user/preferences/set/history_menu/on\"><img src=\"/design/admin/images/up.gif\" alt=\"\" width=\"11\" height=\"6\" /></a>\n</div>";
}


$setArray = $oldSetArray_10e867d9d0aa803b40dcb04003bc669a;
?>
