<?php
//
// Created on: <04-Jul-2002 13:19:43 bf>
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

$http =& eZHTTPTool::instance();
$module =& $Params["Module"];

include_once( "kernel/classes/ezcontentobject.php" );
include_once( "kernel/classes/ezbasket.php" );
include_once( "kernel/classes/ezvattype.php" );
include_once( "kernel/classes/ezorder.php" );
include_once( "kernel/classes/datatypes/ezuser/ezuser.php" );

include_once( "kernel/classes/ezproductcollection.php" );
include_once( "kernel/classes/ezproductcollectionitem.php" );
include_once( "kernel/classes/ezproductcollectionitemoption.php" );
include_once( "kernel/common/template.php" );
include_once( 'lib/ezutils/classes/ezhttptool.php' );

$basket =& eZBasket::currentBasket();
$basket->updatePrices();

if ( $http->hasPostVariable( "ActionAddToBasket" ) )
{
    $objectID = $http->postVariable( "ContentObjectID" );
    $optionList =& $http->postVariable( "eZOption" );
    $object = eZContentObject::fetch( $objectID );
    $nodeID = $object->attribute( 'main_node_id' );
    $http->setSessionVariable( "FromPage", "/content/view/full/" . $nodeID . "/" );
    $price = 0.0;
    $isVATIncluded = true;
    $attributes = $object->contentObjectAttributes();
    foreach ( $attributes as $attribute )
    {
        $dataType =& $attribute->dataType();

        if ( $dataType->isA() == "ezprice" )
        {
            $priceObj =& $attribute->content();
            $price += $priceObj->attribute( 'price' );
        }
    }

    $basket =& eZBasket::currentBasket();
    $sessionID = $http->sessionID();

    $item =& eZProductCollectionItem::create( $basket->attribute( "productcollection_id" ) );

    $item->setAttribute( "contentobject_id", $objectID );
    $item->setAttribute( "item_count", 1 );
    $item->setAttribute( "price", $price );
    if ( $priceObj->attribute( 'is_vat_included' ) )
    {
        $item->setAttribute( "is_vat_inc", '1' );
    }
    else
    {
        $item->setAttribute( "is_vat_inc", '0' );
    }
    $item->setAttribute( "vat_value", $priceObj->attribute( 'vat_percent' ) );
    $item->setAttribute( "discount", $priceObj->attribute( 'discount_percent' ) );
    $item->store();
    $priceWithoutOptions = $price;
    eZDebug::writeDebug( $optionList, 'optionlist' );
    foreach ( array_keys( $optionList ) as $key )
    {
        $attributeID = $key;
        $optionSelected = $optionList[$key];
        $attribute =& eZContentObjectAttribute::fetch( $attributeID, $object->attribute( 'current_version' ) );
        $option =& $attribute->attribute( 'content' );
        eZDebug::writeDebug( $option->attribute( 'option_list' ), "optionitems" );
        foreach( $option->attribute( 'option_list' ) as $optionArray )
        {
            if( $optionArray['id'] == $optionSelected )
            {
                $optionItem =& eZProductCollectionItemOption::create( $item->attribute( 'id' ), $optionArray['id'], $option->attribute( 'name' ),
                                                                      $optionArray['value'], $optionArray['additional_price'], $attributeID );
                $optionItem->store();
                $price += $optionArray['additional_price'];
                break;
            }
        }

    }
    if ( $price != $priceWithoutOptions )
    {
        $item->setAttribute( "price", $price );
        $item->store();
    }

    $module->redirectTo( "/shop/basket/" );
    return;
}

if ( $http->hasPostVariable( "RemoveProductItemButton" ) )
{
    $itemCountList = $http->postVariable( "ProductItemCountList" );
    $itemIDList = $http->postVariable( "ProductItemIDList" );

    $i = 0;
    foreach ( $itemIDList as $id )
    {
        $item = eZProductCollectionItem::fetch( $id );
        if ( is_object( $item ) )
        {
            $item->setAttribute( "item_count", $itemCountList[$i] );
            $item->store();
        }
        

        $i++;
    }

    $basket =& eZBasket::currentBasket();

    $item = $http->postVariable( "RemoveProductItemButton" );
    eZDebug::writeDebug( $item, "basket item" );
    if ( is_numeric( $http->postVariable( "RemoveProductItemButton" ) )  )
    {
        $item = $http->postVariable( "RemoveProductItemButton" );
        $basket->removeItem( $item );
    }
    else
    {
        $itemList = $http->postVariable( "RemoveProductItemDeleteList" );

        foreach ( $itemList as $item )
        {
            $basket->removeItem( $item );
        }
    }
    $module->redirectTo( $module->functionURI( "basket" ) . "/" );
    return;
}


if ( $http->hasPostVariable( "StoreChangesButton" ) )
{
    $itemCountList = $http->postVariable( "ProductItemCountList" );
    $itemIDList = $http->postVariable( "ProductItemIDList" );

    $i = 0;
    foreach ( $itemIDList as $id )
    {
        $item = eZProductCollectionItem::fetch( $id );
        if ( $itemCountList[$i] == 0 )
        {
            $item->remove();
        }
        else
        {
            $item->setAttribute( "item_count", $itemCountList[$i] );
            $item->store();
        }

        $i++;
    }
    $module->redirectTo( $module->functionURI( "basket" ) . "/" );
    return;
}

if ( $http->hasPostVariable( "ContinueShoppingButton" ) )
{
    $itemCountList = $http->postVariable( "ProductItemCountList" );
    $itemIDList = $http->postVariable( "ProductItemIDList" );

    $i = 0;
    foreach ( $itemIDList as $id )
    {
        $item = eZProductCollectionItem::fetch( $id );
        $item->setAttribute( "item_count", $itemCountList[$i] );
        $item->store();

        $i++;
    }
    $fromURL = $http->sessionVariable( "FromPage" );
    $module->redirectTo( $fromURL );
}

$doCheckout = false;
if ( eZHTTPTool::hasSessionVariable( 'DoCheckoutAutomatically' ) )
{
    if ( eZHTTPTool::sessionVariable( 'DoCheckoutAutomatically' ) === true )
    {
        $doCheckout = true;
        eZHTTPTool::setSessionVariable( 'DoCheckoutAutomatically', false );
    }
}

$removedItems = array();

if ( $http->hasPostVariable( "CheckoutButton" ) or ( $doCheckout === true ) )
{
    if ( $http->hasPostVariable( "ProductItemIDList" ) )
    {
        $itemCountList = $http->postVariable( "ProductItemCountList" );
        $itemIDList = $http->postVariable( "ProductItemIDList" );

        $i = 0;
        foreach ( $itemIDList as $id )
        {
            $item = eZProductCollectionItem::fetch( $id );
            $item->setAttribute( "item_count", $itemCountList[$i] );
            $item->store();

            $i++;
        }
    }

    // Fetch the shop account handler
    include_once( 'kernel/classes/ezshopaccounthandler.php' );
    $accountHandler =& eZShopAccountHandler::instance();

    // Do we have all the information we need to start the checkout
    if ( !$accountHandler->verifyAccountInformation() )
    {
        // Fetches the account information, normally done with a redirect
        $accountHandler->fetchAccountInformation( $module );
        return;
    }
    else
    {
        // Creates an order and redirects
        $basket =& eZBasket::currentBasket();
        $productCollectionID = $basket->attribute( 'productcollection_id' );

        $verifyResult =& eZProductCollection::verify( $productCollectionID  );
        $basket->updatePrices();

        if ( $verifyResult === true )
        {
            $order =& $basket->createOrder();
            $order->setAttribute( 'account_identifier', "default" );
            $order->store();

            eZHTTPTool::setSessionVariable( 'MyTemporaryOrderID', $order->attribute( 'id' ) );

            $module->redirectTo( '/shop/confirmorder/' );
            return;
        }
        else
        {
            $basket =& eZBasket::currentBasket();
            $itemList =& $verifyResult;
            $removedItems = array();
            foreach ( $itemList as $item )
            {
                $removedItems[] = $item;
                $basket->removeItem( $item->attribute( 'id' ) );
            }
        }
    }
}

$basket =& eZBasket::currentBasket();
$tpl =& templateInit();
$tpl->setVariable( "removed_items", $removedItems);
$tpl->setVariable( "basket", $basket );
$tpl->setVariable( "module_name", 'shop' );

$Result = array();
$Result['content'] =& $tpl->fetch( "design:shop/basket.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezi18n( 'kernel/shop', 'Basket' ) ) );
?>
