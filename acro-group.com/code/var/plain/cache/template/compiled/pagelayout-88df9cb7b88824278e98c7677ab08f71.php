<?php
// URI:       design:pagelayout.tpl
// Filename:  design/admin/templates/pagelayout.tpl
// Timestamp: 1089197114 (Wed Jul 7 13:45:14 BST 2004)
$oldSetArray_a73471279d5667cd84b9149cbe222e27 = isset( $setArray ) ? $setArray : array();
$setArray = array();
$eZTemplateCompilerCodeDate = 1074699607;
if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )
    include_once( "var/plain/cache/template/compiled/common.php" );

$text .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"no\" lang=\"no\">\n\n<head>";
$oldRestoreIncludeArray_f7056599360bf1100f0c125fc5083b3b = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( !isset( $dKeys ) )
{
    $resH =& $tpl->resourceHandler( "design" );
    $dKeys =& $resH->keys();
}

$resourceFound = false;
if ( file_exists( "var/plain/cache/template/compiled/page_head-384ec3d4ccb30d920cede8679d7cf917.php" ) )
{
    $resourceFound = true;
    $namespaceStack[] = array( $rootNamespace, $currentNamespace );
    $currentNamespace = $rootNamespace;
    include( "var/plain/cache/template/compiled/page_head-384ec3d4ccb30d920cede8679d7cf917.php" );
    list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
    $textElements = array();
    $extraParameters = array();
    $tpl->processURI( "design/standard/templates/page_head.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
    $text .= implode( '', $textElements );
}

foreach ( $restoreIncludeArray as $element )
{
    $vars[$element[0]][$element[1]] = $element[2];
}
$restoreIncludeArray = $oldRestoreIncludeArray_f7056599360bf1100f0c125fc5083b3b;

unset( $cacheKeys1 );
$cacheKeys1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
$cacheKeys2 = compiledFetchAttribute( $cacheKeys1, "identifier" );
unset( $cacheKeys1 );
$cacheKeys1 = $cacheKeys2;
while ( is_object( $cacheKeys1 ) and method_exists( $cacheKeys1, 'templateValue' ) )
    $cacheKeys1 = $cacheKeys1->templateValue();
unset( $cacheKeys2 );
$cacheKeys2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "current_user", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["current_user"] : null;
$cacheKeys3 = compiledFetchAttribute( $cacheKeys2, "contentobject_id" );
unset( $cacheKeys2 );
$cacheKeys2 = $cacheKeys3;
while ( is_object( $cacheKeys2 ) and method_exists( $cacheKeys2, 'templateValue' ) )
    $cacheKeys2 = $cacheKeys2->templateValue();
$cacheKeys = array( "navigation_tabs", $cacheKeys1, $cacheKeys2 );unset( $cacheKeys1, $cacheKeys2 );

$subtreeExpiry = false;
if ( is_array( $cacheKeys ) )
    $cacheKeys = implode( '_', $cacheKeys ) . '_';
else
    $cacheKeys .= '_';
$keyString = sprintf( '%u', crc32( $cacheKeys . "8_0_8_100_design/admin/templates/pagelayout.tpl_admin_acro" ) );
$cacheDir = "var/plain/cache/template-block/" . $keyString[0] . '/' . $keyString[1] . '/' . $keyString[2];
$cachePath = $cacheDir . '/' . $keyString . '.cache';
include_once( 'lib/ezutils/classes/ezexpiryhandler.php' );
$handler =& eZExpiryHandler::instance();
$globalExpiryTime = -1;
if ( $handler->hasTimestamp( 'content-cache' ) )
{
    $globalExpiryTime = $handler->timestamp( 'content-cache' );
}
if ( file_exists( $cachePath )
    and filemtime( $cachePath ) >= ( time() - 7200 )
    and ( ( filemtime( $cachePath ) > $globalExpiryTime ) or ( $globalExpiryTime == -1 ) ) )
{
    $fp = fopen( $cachePath, 'r' );
    $contentData = fread( $fp, filesize( $cachePath ) );
    fclose( $fp );

    $text .= $contentData;
    unset( $contentData );
}
else
{
    if ( !isset( $textStack ) )
        $textStack = array();
    $textStack[] = $text;
    $text = '';
    if ( !isset( $cacheStack ) )
        $cacheStack = array();
    $cacheEntry = array( $cacheDir, $cachePath, $keyString, false );
    if ( isset( $subtreeExpiry ) )
        $cacheEntry[3] = $subtreeExpiry;
    $cacheStack[] = $cacheEntry;
    $text .= "\n\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"/design/standard/stylesheets/core.css\" />\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"/design/admin/stylesheets/admin.css\" />\n    <link rel=\"stylesheet\" type=\"text/css\" href=\"/design/standard/stylesheets/debug.css\" />\n\n\n</head>\n\n<body>\n\n\n<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"background-color: #4272b4; background-image:url('/design/admin/images/bgimage.gif'); background-position: right top; background-repeat: no-repeat;\">\n<tr>\n    <td style=\"padding: 4px\" colspan=\"13\">\n    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\n    <tr>\n        <td width=\"5\" style=\"background-image:url('/design/admin/images/tbox-top-left.gif'); background-repeat: no-repeat;\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"5\" height=\"6\" /></td>\n        <td style=\"border-top: solid 1px #789dce;\" width=\"99%\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"1\" height=\"1\" /></td>\n        <td width=\"5\" style=\"background-image:url('/design/admin/images/tbox-top-right.gif'); background-repeat: no-repeat;\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"5\" height=\"6\" /></td>\n    </tr>\n    <tr>\n        <td style=\"border-left: solid 1px #789dce;\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"5\" height=\"6\" /></td>\n        <td>\n        <table width=\"100%\">\n        <tr> \n            <td>\n	    <img src=\"/design/admin/images/logo.gif\" alt=\"\" /></td>\n            <td>\n            &nbsp;&nbsp;\n            </td>\n            <td valign=\"top\">\n                <form action=\"/index.php/admin_acro/content/search\" method=\"get\" style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px;\">\n                    <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                    <tr>\n                        <td>\n                            <input class=\"searchbox\" type=\"text\" size=\"20\" name=\"SearchText\" id=\"Search\" value=\"\" />\n                        </td>  \n                        <td>\n                            <input class=\"searchbutton\" name=\"SearchButton\" type=\"submit\" value=\"Search\" />\n                        </td>\n                    </tr>\n                    </table>\n                </form>\n            </td>\n            <td valign=\"center\">\n	        ";
    include_once( 'kernel/content/ezcontentfunctioncollection.php' );
    $show = call_user_func_array( array( new eZContentFunctionCollection(), 'canInstantiateClasses' ),
      array(     'parent_node' => 0 ) );
    $show = isset( $show['result'] ) ? $show['result'] : null;

    if ( $show )
    {

        unset( $show );

        $text .= "	        <form method=\"post\" action=\"/index.php/admin_acro/content/action\">\n                    <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n                    <tr>\n                        <td>\n                        <select name=\"ClassID\" class=\"classcreate\">\n	                    ";
        include_once( 'kernel/content/ezcontentfunctioncollection.php' );
        $loopItem = call_user_func_array( array( new eZContentFunctionCollection(), 'canInstantiateClassList' ),
          array(     'group_id' => 0,
            'parent_node' => 0 ) );
        $loopItem = isset( $loopItem['result'] ) ? $loopItem['result'] : null;

        $namespaceStack[] = $currentNamespace;
        $currentNamespace .= ( $currentNamespace ? ":" : "" ) . 'Classes';

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

            $text .= "                            <option value=\"";
            $namespace = $rootNamespace;
            if ( $namespace == '' )
                $namespace = "Classes";
            else
                $namespace .= ':Classes';
            unset( $var );
            $var = ( array_key_exists( $namespace, $vars ) and array_key_exists( "item", $vars[$namespace] ) ) ? $vars[$namespace]["item"] : null;
            $var1 = compiledFetchAttribute( $var, "id" );
            unset( $var );
            $var = $var1;
            while ( is_object( $var ) and method_exists( $var, 'templateValue' ) )
                $var = $var->templateValue();
            $text .= ( is_object( $var ) ? compiledFetchText( $tpl, $rootNamespace, $currentNamespace, $namespace, $var ) : $var );
            unset( $var );

            $text .= "\">";
            $namespace = $rootNamespace;
            if ( $namespace == '' )
                $namespace = "Classes";
            else
                $namespace .= ':Classes';
            unset( $var1 );
            $var1 = ( array_key_exists( $namespace, $vars ) and array_key_exists( "item", $vars[$namespace] ) ) ? $vars[$namespace]["item"] : null;
            $var2 = compiledFetchAttribute( $var1, "name" );
            unset( $var1 );
            $var1 = $var2;
            while ( is_object( $var1 ) and method_exists( $var1, 'templateValue' ) )
                $var1 = $var1->templateValue();
            $var = htmlspecialchars( $var1 );
            unset( $var1 );
            $text .= $var;
            unset( $var );

            $text .= "</option>\n                            ";
            list( $loopItem, $loopKeys, $loopCount, $currentIndex, $index ) = array_pop( $sectionStack );
            ++$currentIndex;

            ++$index;

        }
        unset( $loopKeys, $loopCount, $index, $last, $loopIndex, $loopItem );
        $currentNamespace = array_pop( $namespaceStack );

        $text .= "                         </select>\n                        </td>\n			<td>\n                            <input class=\"classbutton\" type=\"submit\" name=\"NewButton\" value=\"New\" />\n                        </td>\n                    </tr>\n                    </table>    \n                </form>\n                ";
    }

    $text .= "            </td>  \n            <td align=\"right\">\n      ";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "current_user", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["current_user"] : null;
    $show2 = compiledFetchAttribute( $show1, "contentobject_id" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    unset( $show2 );
    $show2 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "anonymous_user_id", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["anonymous_user_id"] : null;
    while ( is_object( $show2 ) and method_exists( $show2, 'templateValue' ) )
        $show2 = $show2->templateValue();
    $show = ( ( $show1 ) == ( $show2 ) );
    unset( $show1, $show2 );

    if ( $show )
    {

        unset( $show );

        $text .= "      <a class=\"leftmenuitem\"  href=\"/index.php/admin_acro/user/login\">Login</a>\n      ";
    }
    else
    {

        unset( $show );

        $text .= "      <a class=\"leftmenuitem\" href=\"/index.php/admin_acro/user/logout\">Logout (";
        unset( $var1 );
        $var1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "current_user", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["current_user"] : null;
        $var2 = compiledFetchAttribute( $var1, "contentobject" );
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

        $text .= ") </a> \n      ";
    }

    $text .= "            </td> \n        </tr>  \n        </table>\n        </td>\n        <td style=\"border-right: solid 1px #789dce;\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"5\" height=\"6\" /></td>\n    </tr>\n    <tr>\n        <td style=\"background-image:url('/design/admin/images/tbox-bottom-left.gif'); background-repeat: no-repeat;\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"5\" height=\"6\" /></td>\n        <td style=\"border-bottom: solid 1px #789dce;\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"1\" height=\"1\" /></td>\n        <td style=\"background-image:url('/design/admin/images/tbox-bottom-right.gif'); background-repeat: no-repeat;\">\n        <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"5\" height=\"6\" /></td>\n    </tr>\n    </table>\n\n    </td>\n</tr>\n<tr>\n    <td colspan=\"13\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"3\" height=\"5\" /></td>\n</tr>\n<tr>\n    <td class=\"headlogo\" width=\"130\">\n    \n    &nbsp;\n     </td>\n    <td class=\"headlink\" width=\"66\">\n    \n\n    ";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezcontentnavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_35546abe70fa2859c72a52730f0544e9 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Content";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $var = ( "/content/view/full/" . "2" );
        $vars[$currentNamespace]["menu_url"] = $var;
        unset( $var );
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadselected.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_35546abe70fa2859c72a52730f0544e9;

        $text .= "</td>\n    ";
    }
    else
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_daf0f934ba4f7703cd63c9eb4086de30 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Content";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $var = ( "/content/view/full/" . "2" );
        $vars[$currentNamespace]["menu_url"] = $var;
        unset( $var );
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadgray.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_daf0f934ba4f7703cd63c9eb4086de30;

        $text .= "</td>\n    ";
    }

    $text .= "\n    <td class=\"menuheadspacer\" width=\"3\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"3\" height=\"1\" /></td>\n    <td class=\"headlink\" width=\"66\">\n    \n    ";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezmedianavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_a4d76b04c1ad3f6781b54af9e0109c46 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Media";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $var = ( "/content/view/full/" . "43" );
        $vars[$currentNamespace]["menu_url"] = $var;
        unset( $var );
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadselected.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_a4d76b04c1ad3f6781b54af9e0109c46;

        $text .= "</td>\n    ";
    }
    else
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_a388257377a50ea52bdfd63e920ca1bd = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Media";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $var = ( "/content/view/full/" . "43" );
        $vars[$currentNamespace]["menu_url"] = $var;
        unset( $var );
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadgray.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_a388257377a50ea52bdfd63e920ca1bd;

        $text .= "</td>\n    ";
    }

    $text .= "\n    <td class=\"menuheadspacer\" width=\"3\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"3\" height=\"1\" /></td>\n    <td class=\"headlink\" width=\"66\">\n    \n    ";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezshopnavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_2e56c4d8712e345c3350c96f9a2d3b03 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Shop";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/shop/orderlist/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadselected.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_2e56c4d8712e345c3350c96f9a2d3b03;

        $text .= "</td>\n    ";
    }
    else
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_1e61350379a9478324b4f3999e8c5de2 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Shop";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/shop/orderlist/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadgray.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_1e61350379a9478324b4f3999e8c5de2;

        $text .= "</td>\n    ";
    }

    $text .= "    \n    <td class=\"menuheadspacer\" width=\"3\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"3\" height=\"1\" /></td>\n\n    <td class=\"headlink\" width=\"66\">\n\n    \n    ";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezusernavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_d3c5dd0e0628bafaf4f17d4d693945f4 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Users";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/content/view/full/5/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadselected.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_d3c5dd0e0628bafaf4f17d4d693945f4;

        $text .= "    ";
    }
    else
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_914fc77bb96660d9a3bee52ee4d001c8 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Users";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/content/view/full/5/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadgray.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_914fc77bb96660d9a3bee52ee4d001c8;

        $text .= "    ";
    }

    $text .= "    \n    </td>\n\n    <td class=\"menuheadspacer\" width=\"3\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"3\" height=\"1\" /></td>\n\n    <td class=\"headlink\" width=\"66\">\n\n    \n    ";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezsetupnavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_ce4d9f2d915aac1671c7e427333442ec = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Set up";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/setup/menu/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadselected.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_ce4d9f2d915aac1671c7e427333442ec;

        $text .= "    ";
    }
    else
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_bd819ef9c347f43953c815e08306edc2 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Set up";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/setup/menu/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadgray.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_bd819ef9c347f43953c815e08306edc2;

        $text .= "    ";
    }

    $text .= "\n    </td>\n\n    <td class=\"menuheadspacer\" width=\"3\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"3\" height=\"1\" /></td>\n\n    <td class=\"headlink\" width=\"66\">\n\n    \n    ";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezmynavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_00cf2f7833237fd5916794c113e280fd = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Personal";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/content/draft/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadselected-1a8cf739007af4cc6a7d107f77fa39dc.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadselected.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_00cf2f7833237fd5916794c113e280fd;

        $text .= "    ";
    }
    else
    {

        unset( $show );

        $text .= "    ";
        $oldRestoreIncludeArray_b78778cf3ff4e8e81610158d42228d24 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        $vars[$currentNamespace]["menu_text"] = "Personal";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_text', $vars[$currentNamespace]['menu_text'] );

        $vars[$currentNamespace]["menu_url"] = "/content/draft/";
        $restoreIncludeArray[] = array( $currentNamespace, 'menu_url', $vars[$currentNamespace]['menu_url'] );

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/page_menuheadgray-bf7f4b42ed40315cff18f74077d5cbcf.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/page_menuheadgray.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_b78778cf3ff4e8e81610158d42228d24;

        $text .= "    ";
    }

    $text .= "\n    </td>\n   <td class=\"headlogo\" width=\"500\">\n   &nbsp;</td>\n</tr>\n<tr>\n    <td colspan=\"13\" style=\"background-image:url('/design/admin/images/bgtilelight.gif'); background-repeat: repeat;\">\n    <img src=\"/design/standard/images/1x1.gif\" alt=\"\" width=\"1\" height=\"8\" /></td>\n</tr>\n";
    list( $cacheDir, $cachePath, $keyString, $subtreeExpiry ) = array_pop( $cacheStack );
    $cachedText = $text;
    include_once( 'lib/ezfile/classes/ezdir.php' );
    eZDir::mkdir( $cacheDir, 511, true );
    $fd = fopen( $cachePath, 'w' );
    fwrite( $fd, $cachedText );
    fclose( $fd );
    $text = array_pop( $textStack );
    $text .= $cachedText;
    if ( isset( $subtreeExpiry ) && $subtreeExpiry )
    {
        include_once( 'lib/ezdb/classes/ezdb.php' );
        $db =& eZDB::instance();

        if ( substr( $subtreeExpiry, -1 ) != '/'  )
        {
            $subtreeExpiry .= '/';
        }
        $subtree =& $db->escapeString( $subtreeExpiry );
        $cacheKey =& $db->escapeString( $cachePath );

        $insertQuery = "INSERT INTO ezsubtree_expiry ( subtree, cache_file )
                    VALUES ( '$subtree', '$cacheKey' )";
        $db->query( $insertQuery );
    }
    unset( $cachedText );
}
$text .= "\n\n\n<tr>\n    <td rowspan=\"2\" width=\"130\" valign=\"top\" style=\"padding-right: 0px; padding-left: 0px; padding-top: 0px; background-image:url('/design/admin/images/bgtilelight.gif'); background-repeat: repeat;\">\n\n\n";
unset( $show1 );
$show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
$show2 = compiledFetchAttribute( $show1, "identifier" );
unset( $show1 );
$show1 = $show2;
while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
    $show1 = $show1->templateValue();
$show = ( ( $show1 ) == ( "ezcontentnavigationpart" ) );
unset( $show1 );

if ( $show )
{

    unset( $show );

    $oldRestoreIncludeArray_c7046593f66d235b04656ee425a03725 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
    $restoreIncludeArray = array();

    if ( !isset( $dKeys ) )
    {
        $resH =& $tpl->resourceHandler( "design" );
        $dKeys =& $resH->keys();
    }

    $resourceFound = false;
    if ( file_exists( "var/plain/cache/template/compiled/menu-b705e33a2b7ae8c40d830f17658b4653.php" ) )
    {
        $resourceFound = true;
        $namespaceStack[] = array( $rootNamespace, $currentNamespace );
        $currentNamespace = $rootNamespace;
        include( "var/plain/cache/template/compiled/menu-b705e33a2b7ae8c40d830f17658b4653.php" );
        list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
    }
    else
    {
        $resourceFound = true;
        $textElements = array();
        $extraParameters = array();
        $tpl->processURI( "design/admin/templates/parts/content/menu.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
        $text .= implode( '', $textElements );
    }

    foreach ( $restoreIncludeArray as $element )
    {
        $vars[$element[0]][$element[1]] = $element[2];
    }
    $restoreIncludeArray = $oldRestoreIncludeArray_c7046593f66d235b04656ee425a03725;

}

unset( $show1 );
$show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
$show2 = compiledFetchAttribute( $show1, "identifier" );
unset( $show1 );
$show1 = $show2;
while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
    $show1 = $show1->templateValue();
$show = ( ( $show1 ) == ( "ezmedianavigationpart" ) );
unset( $show1 );

if ( $show )
{

    unset( $show );

    $oldRestoreIncludeArray_02b41e168454693dc6b6d35f94e11999 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
    $restoreIncludeArray = array();

    if ( !isset( $dKeys ) )
    {
        $resH =& $tpl->resourceHandler( "design" );
        $dKeys =& $resH->keys();
    }

    $resourceFound = false;
    if ( file_exists( "var/plain/cache/template/compiled/menu-edbe20c74cc38813b0a22be14e07916c.php" ) )
    {
        $resourceFound = true;
        $namespaceStack[] = array( $rootNamespace, $currentNamespace );
        $currentNamespace = $rootNamespace;
        include( "var/plain/cache/template/compiled/menu-edbe20c74cc38813b0a22be14e07916c.php" );
        list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
    }
    else
    {
        $resourceFound = true;
        $textElements = array();
        $extraParameters = array();
        $tpl->processURI( "design/admin/templates/parts/media/menu.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
        $text .= implode( '', $textElements );
    }

    foreach ( $restoreIncludeArray as $element )
    {
        $vars[$element[0]][$element[1]] = $element[2];
    }
    $restoreIncludeArray = $oldRestoreIncludeArray_02b41e168454693dc6b6d35f94e11999;

}

unset( $cacheKeys1 );
$cacheKeys1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "current_user", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["current_user"] : null;
$cacheKeys2 = compiledFetchAttribute( $cacheKeys1, "contentobject_id" );
unset( $cacheKeys1 );
$cacheKeys1 = $cacheKeys2;
while ( is_object( $cacheKeys1 ) and method_exists( $cacheKeys1, 'templateValue' ) )
    $cacheKeys1 = $cacheKeys1->templateValue();
include_once( 'kernel/classes/ezpreferences.php' );
$cacheKeys2 = eZPreferences::value( "bookmark_menu" );
include_once( 'kernel/classes/ezpreferences.php' );
$cacheKeys3 = eZPreferences::value( "history_menu" );
include_once( 'kernel/classes/ezpreferences.php' );
$cacheKeys4 = eZPreferences::value( "advanced_menu" );
unset( $cacheKeys5 );
$cacheKeys5 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
$cacheKeys6 = compiledFetchAttribute( $cacheKeys5, "identifier" );
unset( $cacheKeys5 );
$cacheKeys5 = $cacheKeys6;
while ( is_object( $cacheKeys5 ) and method_exists( $cacheKeys5, 'templateValue' ) )
    $cacheKeys5 = $cacheKeys5->templateValue();
$cacheKeys = array( $cacheKeys1, $cacheKeys2, $cacheKeys3, $cacheKeys4, $cacheKeys5 );unset( $cacheKeys1, $cacheKeys2, $cacheKeys3, $cacheKeys4, $cacheKeys5 );

$subtreeExpiry = false;
if ( is_array( $cacheKeys ) )
    $cacheKeys = implode( '_', $cacheKeys ) . '_';
else
    $cacheKeys .= '_';
$keyString = sprintf( '%u', crc32( $cacheKeys . "207_0_207_171_design/admin/templates/pagelayout.tpl_admin_acro" ) );
$cacheDir = "var/plain/cache/template-block/" . $keyString[0] . '/' . $keyString[1] . '/' . $keyString[2];
$cachePath = $cacheDir . '/' . $keyString . '.cache';
include_once( 'lib/ezutils/classes/ezexpiryhandler.php' );
$handler =& eZExpiryHandler::instance();
$globalExpiryTime = -1;
if ( $handler->hasTimestamp( 'content-cache' ) )
{
    $globalExpiryTime = $handler->timestamp( 'content-cache' );
}
if ( file_exists( $cachePath )
    and filemtime( $cachePath ) >= ( time() - 7200 )
    and ( ( filemtime( $cachePath ) > $globalExpiryTime ) or ( $globalExpiryTime == -1 ) ) )
{
    $fp = fopen( $cachePath, 'r' );
    $contentData = fread( $fp, filesize( $cachePath ) );
    fclose( $fp );

    $text .= $contentData;
    unset( $contentData );
}
else
{
    if ( !isset( $textStack ) )
        $textStack = array();
    $textStack[] = $text;
    $text = '';
    if ( !isset( $cacheStack ) )
        $cacheStack = array();
    $cacheEntry = array( $cacheDir, $cachePath, $keyString, false );
    if ( isset( $subtreeExpiry ) )
        $cacheEntry[3] = $subtreeExpiry;
    $cacheStack[] = $cacheEntry;
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezshopnavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $oldRestoreIncludeArray_58dc14fdd3ceb13d2d68f63f879f3eac = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/menu-7ba5ecb34f15da4585b96cb0ac2d976d.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/menu-7ba5ecb34f15da4585b96cb0ac2d976d.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/parts/shop/menu.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_58dc14fdd3ceb13d2d68f63f879f3eac;

    }

    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezusernavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $oldRestoreIncludeArray_2bebe302d69435b56b7a30fb3b5bafed = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/menu-4a3023cabb2070695cc48a2a6610f4da.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/menu-4a3023cabb2070695cc48a2a6610f4da.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/parts/user/menu.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_2bebe302d69435b56b7a30fb3b5bafed;

    }

    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezsetupnavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $oldRestoreIncludeArray_f759e44db52ddc0fadd46d4fc79e749e = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/menu-8aac99bea2c35f72a16461f616d119c5.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/menu-8aac99bea2c35f72a16461f616d119c5.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/parts/setup/menu.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_f759e44db52ddc0fadd46d4fc79e749e;

    }

    $text .= "\n";
    unset( $show1 );
    $show1 = ( array_key_exists( $rootNamespace, $vars ) and array_key_exists( "navigation_part", $vars[$rootNamespace] ) ) ? $vars[$rootNamespace]["navigation_part"] : null;
    $show2 = compiledFetchAttribute( $show1, "identifier" );
    unset( $show1 );
    $show1 = $show2;
    while ( is_object( $show1 ) and method_exists( $show1, 'templateValue' ) )
        $show1 = $show1->templateValue();
    $show = ( ( $show1 ) == ( "ezmynavigationpart" ) );
    unset( $show1 );

    if ( $show )
    {

        unset( $show );

        $oldRestoreIncludeArray_05b5dde7aa8086b4c581321f18c28f31 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
        $restoreIncludeArray = array();

        if ( !isset( $dKeys ) )
        {
            $resH =& $tpl->resourceHandler( "design" );
            $dKeys =& $resH->keys();
        }

        $resourceFound = false;
        if ( file_exists( "var/plain/cache/template/compiled/menu-22902ed2b8477faf5a03cb0cab8b481e.php" ) )
        {
            $resourceFound = true;
            $namespaceStack[] = array( $rootNamespace, $currentNamespace );
            $currentNamespace = $rootNamespace;
            include( "var/plain/cache/template/compiled/menu-22902ed2b8477faf5a03cb0cab8b481e.php" );
            list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
        }
        else
        {
            $resourceFound = true;
            $textElements = array();
            $extraParameters = array();
            $tpl->processURI( "design/admin/templates/parts/my/menu.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
            $text .= implode( '', $textElements );
        }

        foreach ( $restoreIncludeArray as $element )
        {
            $vars[$element[0]][$element[1]] = $element[2];
        }
        $restoreIncludeArray = $oldRestoreIncludeArray_05b5dde7aa8086b4c581321f18c28f31;

    }

    $text .= "\n\n\n</td>\n    <td class=\"mainarea\" colspan=\"12\"  valign=\"top\"  style=\"background-color: #ffffff; background-image:url('/design/admin/images/corner.gif'); background-repeat: no-repeat; background-position: left top;\">\n";
    list( $cacheDir, $cachePath, $keyString, $subtreeExpiry ) = array_pop( $cacheStack );
    $cachedText = $text;
    include_once( 'lib/ezfile/classes/ezdir.php' );
    eZDir::mkdir( $cacheDir, 511, true );
    $fd = fopen( $cachePath, 'w' );
    fwrite( $fd, $cachedText );
    fclose( $fd );
    $text = array_pop( $textStack );
    $text .= $cachedText;
    if ( isset( $subtreeExpiry ) && $subtreeExpiry )
    {
        include_once( 'lib/ezdb/classes/ezdb.php' );
        $db =& eZDB::instance();

        if ( substr( $subtreeExpiry, -1 ) != '/'  )
        {
            $subtreeExpiry .= '/';
        }
        $subtree =& $db->escapeString( $subtreeExpiry );
        $cacheKey =& $db->escapeString( $cachePath );

        $insertQuery = "INSERT INTO ezsubtree_expiry ( subtree, cache_file )
                    VALUES ( '$subtree', '$cacheKey' )";
        $db->query( $insertQuery );
    }
    unset( $cachedText );
}
$text .= "\n    ";
$oldRestoreIncludeArray_bf8e198acbcbe61831602d3f753b05b4 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( !isset( $dKeys ) )
{
    $resH =& $tpl->resourceHandler( "design" );
    $dKeys =& $resH->keys();
}

$resourceFound = false;
if ( file_exists( "var/plain/cache/template/compiled/page_toppath-b04a1d5f04a23cc7b7de9a8b62162ab0.php" ) )
{
    $resourceFound = true;
    $namespaceStack[] = array( $rootNamespace, $currentNamespace );
    $currentNamespace = $rootNamespace;
    include( "var/plain/cache/template/compiled/page_toppath-b04a1d5f04a23cc7b7de9a8b62162ab0.php" );
    list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
    $textElements = array();
    $extraParameters = array();
    $tpl->processURI( "design/admin/templates/page_toppath.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
    $text .= implode( '', $textElements );
}

foreach ( $restoreIncludeArray as $element )
{
    $vars[$element[0]][$element[1]] = $element[2];
}
$restoreIncludeArray = $oldRestoreIncludeArray_bf8e198acbcbe61831602d3f753b05b4;

$text .= "\n\n\n";
$oldRestoreIncludeArray_0124dac44961bef8e2e3edb76aec4325 = isset( $restoreIncludeArray ) ? $restoreIncludeArray : array();
$restoreIncludeArray = array();

if ( !isset( $dKeys ) )
{
    $resH =& $tpl->resourceHandler( "design" );
    $dKeys =& $resH->keys();
}

$resourceFound = false;
if ( file_exists( "var/plain/cache/template/compiled/page_mainarea-7b91cec24ac01e6a233fab4fa535c125.php" ) )
{
    $resourceFound = true;
    $namespaceStack[] = array( $rootNamespace, $currentNamespace );
    $currentNamespace = $rootNamespace;
    include( "var/plain/cache/template/compiled/page_mainarea-7b91cec24ac01e6a233fab4fa535c125.php" );
    list( $rootNamespace, $currentNamespace ) = array_pop( $namespaceStack );
}
else
{
    $resourceFound = true;
    $textElements = array();
    $extraParameters = array();
    $tpl->processURI( "design/standard/templates/page_mainarea.tpl", true, $extraParameters, $textElements, $rootNamespace, $currentNamespace );
    $text .= implode( '', $textElements );
}

foreach ( $restoreIncludeArray as $element )
{
    $vars[$element[0]][$element[1]] = $element[2];
}
$restoreIncludeArray = $oldRestoreIncludeArray_0124dac44961bef8e2e3edb76aec4325;

$text .= "\n\n\n    </td>\n</tr>\n<tr>\n    <td bgcolor=\"#ffffff\" colspan=\"12\" valign=\"bottom\">\n    <div align=\"center\" style=\"padding-top: 0.5em;\">\n    <p class=\"small\"><a href=\"http://ez.no\">eZ publish&trade;</a> copyright &copy; 1999-2004 <a href=\"http://ez.no\">eZ systems as</a></p>\n    </div>\n    </td>\n</tr>\n</table>\n\n\n<!--DEBUG_REPORT-->\n\n</body>\n</html>\n";

$setArray = $oldSetArray_a73471279d5667cd84b9149cbe222e27;
?>
