#!/usr/bin/env php
<?php
//
// Created on: <18-Dec-2003 17:44:15 amos>
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

set_time_limit( 0 );

include_once( 'lib/ezutils/classes/ezcli.php' );
include_once( 'kernel/classes/ezscript.php' );

$cli =& eZCLI::instance();
$endl = $cli->endlineString();

$script =& eZScript::instance( array( 'description' => ( "eZ publish database cleanup.\n\n" .
                                                         "Will cleanup various data from the currently used database in eZ publish\n" .
                                                         "\n" .
                                                         "Possible values for NAME is:\n" .
                                                         "session, preferences, browse, tipafriend, shop, forgotpassword, workflow,\n" .
                                                         "collaboration, collectedinformation, notification, searchstats or all (for all items)\n" .
                                                         "cleanup.php -s admin session"),
                                      'use-session' => false,
                                      'use-modules' => true,
                                      'use-extensions' => true ) );

$script->startup();

$options = $script->getOptions( "[db-user:][db-password:][db-database:][db-driver:][sql]",
                                "[name]",
                                array( 'db-host' => "Database host",
                                       'db-user' => "Database user",
                                       'db-password' => "Database password",
                                       'db-database' => "Database name",
                                       'db-driver' => "Database driver",
                                       'sql' => "Display sql queries"
                                       ) );
$script->initialize();

if ( count( $options['arguments'] ) < 1 )
{
    $cli->error( "Missing NAME value ( could be session, preferences, browse, tipafriend, shop, forgotpassword, workflow,\n" .
                 "collaboration, collectedinformation, notification, searchstats or all )" );
    $script->shutdown( 1 );
}

$dbUser = $options['db-user'] ? $options['db-user'] : false;
$dbPassword = $options['db-password'] ? $options['db-password'] : false;
$dbHost = $options['db-host'] ? $options['db-host'] : false;
$dbName = $options['db-database'] ? $options['db-database'] : false;
$dbImpl = $options['db-driver'] ? $options['db-driver'] : false;
$showSQL = $options['sql'] ? true : false;
$siteAccess = $options['siteaccess'] ? $options['siteaccess'] : false;

if ( $siteAccess )
{
    changeSiteAccessSetting( $siteaccess, $siteAccess );
}

$cleanAllItems = false;
$clean = array( 'session' => false,
                'preferences' => false,
                'browse' => false,
                'tipafriend' => false,
                'shop' => false,
                'forgotpassword' => false,
                'workflow' => false,
                'collaboration' => false,
                'collectedinformation' => false,
                'notification' => false,
                'searchstats' => false );

foreach ( $options['arguments'] as $arg )
{

    $item = strtolower( $arg );
    if ( $item == 'all' )
        $cleanAllItems = true;
    else
        $cleanItems[] = $item;
}

if ( $cleanAllItems )
{
    $names = array_keys( $clean );
    foreach ( $names as $name )
    {
        $clean[$name] = true;
    }
}
else
{
    if ( count( $cleanItems ) == 0 )
    {
        help();
        exit;
    }
    foreach ( $cleanItems as $name )
    {
        $clean[$name] = true;
    }
}

function changeSiteAccessSetting( &$siteaccess, $optionData )
{
    global $isQuiet;
    $cli =& eZCLI::instance();
    if ( file_exists( 'settings/siteaccess/' . $optionData ) )
    {
        $siteaccess = $optionData;
        if ( !$isQuiet )
            $cli->notice( "Using siteaccess $siteaccess for database cleanup" );
    }
    else
    {
        if ( !$isQuiet )
            $cli->notice( "Siteaccess $optionData does not exist, using default siteaccess" );
    }
}

$db =& eZDB::instance();
if ( $dbHost or $dbName or $dbUser or $dbImpl )
{
    $params = array();
    if ( $dbHost !== false )
        $params['server'] = $dbHost;
    if ( $dbUser !== false )
    {
        $params['user'] = $dbUser;
        $params['password'] = '';
    }
    if ( $dbPassword !== false )
        $params['password'] = $dbPassword;
    if ( $dbName !== false )
        $params['database'] = $dbName;
    $db =& eZDB::instance( $dbImpl, $params, true );
    eZDB::setInstance( $db );
}

$db->setIsSQLOutputEnabled( $showSQL );

include_once( 'kernel/classes/ezpersistentobject.php' );

include_once( 'lib/ezutils/classes/ezsession.php' );
if ( $clean['session'] )
{
    $cli->output( "Removing all sessions" );
    eZSessionEmpty();
}
else
{
    $cli->output( "Removing expired sessions,", false );
    eZSessionGarbageCollector();
    $activeCount = eZSessionCountActive();
    $cli->output( " " . $cli->stylize( 'emphasize', $activeCount ) . " left" );
}

if ( $clean['preferences'] )
{
    include_once( 'kernel/classes/ezpreferences.php' );
    $cli->output( "Removing all preferences" );
    eZPreferences::cleanup();
}

if ( $clean['browse'] )
{
    include_once( 'kernel/classes/ezcontentbrowserecent.php' );
    include_once( 'kernel/classes/ezcontentbrowsebookmark.php' );
    $cli->output( "Removing all recent items and bookmarks for browse page" );
    eZContentBrowseRecent::cleanup();
    eZContentBrowseBookmark::cleanup();
}

if ( $clean['tipafriend'] )
{
    include_once( 'kernel/classes/eztipafriendcounter.php' );
    $cli->output( "Removing all counters for tip-a-friend" );
    eZTipafriendCounter::cleanup();
}

if ( $clean['shop'] )
{
    include_once( 'kernel/classes/ezbasket.php' );
    $cli->output( "Removing all baskets" );
    eZBasket::cleanup();
    include_once( 'kernel/classes/ezwishlist.php' );
    $cli->output( "Removing all wishlists" );
    eZWishList::cleanup();
    include_once( 'kernel/classes/ezorder.php' );
    $cli->output( "Removing all orders" );
    eZOrder::cleanup();
    $productCount = eZProductCollection::count();
    if ( $productCount > 0 )
    {
        $cli->warning( "$productCount product collections still exists, must be a leak" );
    }
}

if ( $clean['forgotpassword'] )
{
    include_once( 'kernel/classes/datatypes/ezuser/ezforgotpassword.php' );
    $cli->output( "Removing all forgot password requests" );
    eZForgotPassword::cleanup();
}

if ( $clean['workflow'] )
{
    include_once( 'lib/ezutils/classes/ezoperationmemento.php' );
    include_once( 'kernel/classes/ezworkflowprocess.php' );
    $cli->output( "Removing all workflow processes and operation mementos" );
    eZOperationMemento::cleanup();
    eZWorkflowProcess::cleanup();
}

if ( $clean['collaboration'] )
{
    include_once( 'kernel/classes/ezcollaborationitem.php' );
    $cli->output( "Removing all collaboration elements" );
    eZCollaborationItem::cleanup();
}

if ( $clean['collectedinformation'] )
{
    include_once( 'kernel/classes/ezinformationcollection.php' );
    $cli->output( "Removing all collected information" );
    eZInformationCollection::cleanup();
}

if ( $clean['notification'] )
{
    include_once( 'kernel/classes/notification/eznotificationevent.php' );
    include_once( 'kernel/classes/notification/eznotificationcollection.php' );
    include_once( 'kernel/classes/notification/eznotificationeventfilter.php' );
    $cli->output( "Removing all notifications events" );
    eZNotificationEvent::cleanup();
    eZNotificationCollection::cleanup();
    eZNotificationEventFilter::cleanup();
}

if ( $clean['searchstats'] )
{
    include_once( 'kernel/classes/ezsearchlog.php' );
    $cli->output( "Removing all search statistics" );
    eZSearchLog::removeStatistics();
}


$script->shutdown();

?>
