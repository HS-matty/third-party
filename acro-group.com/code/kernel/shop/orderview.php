<?php
//
// Created on: <31-Jul-2002 16:49:13 bf>
//
// Copyright (C) 1999-2004 eZ systems as. All rights reserved.
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE included in
// the packaging of this file.
//
// Licencees holding a valid "eZ publish professional licence" version 2
// may use this file in accordance with the "eZ publish professional licence"
// version 2 Agreement provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" version 2 is available at
// http://ez.no/ez_publish/licences/professional/ and in the file
// PROFESSIONAL_LICENCE included in the packaging of this file.
// For pricing of this licence please contact us via e-mail to licence@ez.no.
// Further contact information is available at http://ez.no/company/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.

//

$OrderID = $Params['OrderID'];
$module =& $Params['Module'];
include_once( "kernel/common/template.php" );

include_once( "kernel/classes/ezorder.php" );

$ini =& eZINI::instance();
$http =& eZHTTPTool::instance();
$user =& eZUser::currentUser();
$access = false;
$order = eZOrder::fetch( $OrderID );
if ( !$order )
{
    return $module->handleError( EZ_ERROR_KERNEL_NOT_AVAILABLE, 'kernel' );
}

$accessToAdministrate =& $user->hasAccessTo( 'shop', 'administrate', $accessList );
$accessToAdministrateWord = $accessToAdministrate['accessWord'];
eZDebug::writeDebug( $accessToAdministrateWord, 'accessToAdministrateWord' );

$accessToBuy =& $user->hasAccessTo( 'shop', 'buy', $accessList );
$accessToBuyWord = $accessToBuy['accessWord'];
eZDebug::writeDebug( $accessToBuyWord, 'accessToBuyWord' );

if ( $accessToAdministrateWord != 'no' )
{
    $access = true;
}
elseif ( $accessToBuyWord != 'no' )
{
    if ( $user->id() == $ini->variable( 'UserSettings', 'AnonymousUserID' ) )
    {
        if( $OrderID != $http->sessionVariable( 'UserOrderID' ) )
        {
            $access = false;
        }
        else
        {
            $access = true;
        }
    }
    else
    {
        if ( $order->attribute( 'user_id' ) == $user->id() )
        {
            $access = true;
        }
        else
        {
            $access = false;
        }
    }
}
if ( !$access )
{
     return $module->handleError( EZ_ERROR_KERNEL_ACCESS_DENIED, 'kernel' );
}
$tpl =& templateInit();


$tpl->setVariable( "order", $order );

$Result = array();
$Result['content'] =& $tpl->fetch( "design:shop/orderview.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'kernel/shop', 'Order view' ) ) );

?>
