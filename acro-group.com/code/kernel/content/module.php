<?php
//
// Created on: <17-Apr-2002 11:05:08 amos>
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

$Module = array( 'name' => 'eZContentObject',
                 'variable_params' => true );

$ViewList = array();
$ViewList['edit'] = array(
    'functions' => array( 'edit' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'single_post_actions' => array( 'PreviewButton' => 'Preview',
                                    'TranslateButton' => 'Translate',
                                    'VersionsButton' => 'VersionEdit',
                                    'PublishButton' => 'Publish',
                                    'DiscardButton' => 'Discard',
                                    'BrowseNodeButton' => 'BrowseForNodes',
//                                    'DeleteNodeButton' => 'DeleteNode',
//                                    'MoveNodeButton' => 'MoveNode',
                                    'EditLanguageButton' => 'EditLanguage',
                                    'BrowseObjectButton' => 'BrowseForObjects',
                                    'NewButton' => 'NewObject',
                                    'DeleteRelationButton' => 'DeleteRelation',
                                    'StoreButton' => 'Store',
//                                     'CustomActionButton' => 'CustomAction',
                                    'MoveNodeID' => 'MoveNode',
                                    'RemoveNodeID' => 'DeleteNode',
                                    'ConfirmButton' => 'ConfirmAssignmentDelete'
                                    ),
    'post_action_parameters' => array( 'EditLanguage' => array( 'SelectedLanguage' => 'EditSelectedLanguage' ) ),
    'post_actions' => array( 'BrowseActionName' ),
    'script' => 'edit.php',
    'params' => array( 'ObjectID', 'EditVersion', 'EditLanguage' ) );

$ViewList['removenode'] = array(
    'functions' => array( 'edit' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'single_post_actions' => array( 'ConfirmButton' => 'ConfirmAssignmentRemove',
                                    'CancelButton' => 'CancelAssignmentRemove' ),
    'script' => 'removenode.php',
    'params' => array( 'ObjectID', 'EditVersion', 'EditLanguage', 'NodeID' ) );

$ViewList['pdf'] = array(
    'functions' => array( 'pdf' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'pdf.php',
    'params' => array( 'NodeID' ),
    'unordered_params' => array( 'language' => 'Language',
                                 'offset' => 'Offset',
                                 'year' => 'Year',
                                 'month' => 'Month',
                                 'day' => 'Day' )
    );

$ViewList['view'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'view.php',
    'params' => array( 'ViewMode', 'NodeID' ),
    'unordered_params' => array( 'language' => 'Language',
                                 'offset' => 'Offset',
                                 'year' => 'Year',
                                 'month' => 'Month',
                                 'day' => 'Day' )
    );

$ViewList['copy'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'copy.php',
    'single_post_actions' => array( 'CopyButton' => 'Copy',
                                    'CancelButton' => 'Cancel' ),
    'post_action_parameters' => array( 'Copy' => array( 'VersionChoice' => 'VersionChoice' ) ),
    'params' => array( 'ObjectID' ) );


$ViewList['versionview'] = array(
    'functions' => array( 'versionread' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'versionview.php',
    'single_post_actions' => array( 'ChangeSettingsButton' => 'ChangeSettings',
                                    'EditButton' => 'Edit',
                                    'VersionsButton' => 'Versions',
                                    'PreviewPublishButton' => 'Publish' ),
    'post_action_parameters' => array( 'ChangeSettings' => array( 'Language' => 'SelectedLanguage',
                                                                  'PlacementID' => 'SelectedPlacement',
                                                                  'Sitedesign' => 'SelectedSitedesign' ) ),
    'params' => array( 'ObjectID', 'EditVersion', 'LanguageCode' ),
    'unordered_params' => array( 'language' => 'Language',
                                 'offset' => 'Offset' ) );

$ViewList['search'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'search.php',
    'params' => array( ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['urltranslator'] = array(
    'functions' => array( 'urltranslator' ),
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'urltranslator.php',
    'single_post_actions' => array( 'NewURLAliasButton' => 'NewURLAlias',
                                    'NewForwardURLAliasButton' => 'NewForwardURLAlias',
                                    'NewWildcardURLAliasButton' => 'NewWildcardURLAlias',
                                    'RemoveURLAliasButton' => 'RemoveURLAlias',
                                    'StoreURLAliasButton' => 'StoreURLAlias' ),
    'params' => array( ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['advancedsearch'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'advancedsearch.php',
    'params' => array( 'ViewMode' ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['browse'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'browse.php',
    'params' => array( 'NodeID', 'ObjectID', 'EditVersion' ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['removeobject'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'removeobject.php',
    'params' => array( ) );

$ViewList['removeeditversion'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'removeeditversion.php',
    'params' => array( ) );

$ViewList['download'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'download.php',
    'params' => array( 'ContentObjectID', 'ContentObjectAttributeID', 'FileType' ) );

$ViewList['action'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'action.php',
    'params' => array(  ),
    'post_actions' => array( 'BrowseActionName' ) );

$ViewList['collectinformation'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'collectinformation.php',
    'single_post_actions' => array( 'ActionCollectInformation' => 'CollectInformation' ),
    'post_action_parameters' => array( 'CollectInformation' => array( 'ContentObjectID' => 'ContentObjectID',
                                                                      'ContentNodeID' => 'ContentNodeID',
                                                                      'ViewMode' => 'ViewMode' ) ),
    'params' => array(  ) );

$ViewList['versions'] = array(
    'functions' => array( 'read', 'edit' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'versions.php',
    'single_post_actions' => array( 'CopyVersionButton' => 'CopyVersion',
                                    'EditButton' => 'Edit' ),
    'post_action_parameters' => array( 'CopyVersion' => array( 'VersionID' => 'RevertToVersionID',
                                                               'EditLanguage' => 'EditLanguage' ),
                                       'Edit' => array( 'VersionID' => 'RevertToVersionID',
                                                        'EditLanguage' => 'EditLanguage' ) ),
    'params' => array( 'ObjectID' ,'EditVersion', 'EditLanguage' ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['translate'] = array(
    'functions' => array( 'translate' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'translate.php',
    'single_post_actions' => array( 'EditObjectButton' => 'EditObject',
                                    'PreviewButton' => 'Preview',
                                    'StoreButton' => 'Store',
                                    'AddLanguageButton' => 'AddLanguage',
                                    'DeleteButton' => 'RemoveLanguage',
                                    'RemoveLanguageConfirmationButton' => 'RemoveLanguageConfirmation',
                                    'RemoveLanguageCancelButton' => 'RemoveLanguageCancel',
                                    'EditLanguageButton' => 'EditLanguage' ),
    'post_action_parameters' => array( 'AddLanguage' => array( 'SelectedLanguage' => 'SelectedLanguage' ) ,
                                       'RemoveLanguage' => array( 'SelectedLanguageList' => 'RemoveLanguageArray' ),
                                       'RemoveLanguageConfirmation' => array( 'SelectedLanguageList' => 'RemoveLanguageArray' ),
                                       'EditLanguage' => array( 'SelectedLanguage' => 'EditSelectedLanguage' ) ),
    'action_parameters' => array( 'CancelTask' => array( 'SelectedLanguage' ) ),
    'params' => array( 'ObjectID', 'EditVersion' ) );

$ViewList['draft'] = array(
    'functions' => array( 'create' ),
    'script' => 'draft.php',
    'default_navigation_part' => 'ezmynavigationpart',
    'params' => array( ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['trash'] = array(
    'functions' => array( 'restore' ),
    'script' => 'trash.php',
    'default_navigation_part' => 'ezcontentnavigationpart',
    'params' => array( ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['translations'] = array(
    'functions' => array( 'translations' ),
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'translations.php',
    'single_post_actions' => array( 'RemoveButton' => 'Remove',
                                    'StoreButton' => 'StoreNew',
/*                                    'EditButton' => 'Edit',
                                    'ChangeButton' => 'Change',*/
                                    'NewButton' => 'New',
                                    'ConfirmButton' => 'Confirm' ),
    'post_action_parameters' => array( 'StoreNew' => array( 'LocaleID' => 'LocaleID',
                                                            'TranslationName' => 'TranslationName',
                                                            'TranslationLocale' => 'TranslationLocale' ),
                                       'Remove' => array( 'SelectedTranslationList' => 'DeleteIDArray' ),
                                       'Confirm' => array( 'ConfirmList' => 'ConfirmTranlationID' ) ),
    'params' => array( ) );

$ViewList['tipafriend'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'tipafriend.php',
    'params' => array( 'NodeID' ) );

$ViewList['keyword'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'keyword.php',
    'params' => array( 'alphabet'=>'Alphabet' ),
    'unordered_params' => array( 'offset' => 'Offset', 'classid' => 'ClassID' ) );

$ViewList['collectedinfo'] = array(
    'functions' => array( 'read' ),
    'default_navigation_part' => 'ezcontentnavigationpart',
    'script' => 'collectedinfo.php',
    'params' => array( 'NodeID' ) );

$ViewList['bookmark'] = array(
    'functions' => array( 'bookmark' ),
    'default_navigation_part' => 'ezmynavigationpart',
    'script' => 'bookmark.php',
    'params' => array(),
    'single_post_actions' => array( 'AddButton' => 'Add',
                                    'RemoveButton' => 'Remove' ),
    'post_actions' => array( 'BrowseActionName' ),
    'post_action_parameters' => array( 'Remove' => array( 'DeleteIDArray' => 'DeleteIDArray' ) ),
    'unordered_params' => array( 'offset' => 'Offset' ) );

$ViewList['pendinglist'] = array(
    'functions' => array( 'pendinglist' ),
    'default_navigation_part' => 'ezmynavigationpart',
    'script' => 'pendinglist.php',
    'params' => array(),
    'unordered_params' => array( 'offset' => 'Offset' ) );


$ClassID = array(
    'name'=> 'Class',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezcontentclass.php',
    'class' => 'eZContentClass',
    'function' => 'fetchList',
    'parameter' => array( 0, false )
    );

$ParentClassID = array(
    'name'=> 'ParentClass',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezcontentclass.php',
    'class' => 'eZContentClass',
    'function' => 'fetchList',
    'parameter' => array( 0, false )
    );

$SectionID = array(
    'name'=> 'Section',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezsection.php',
    'class' => 'eZSection',
    'function' => 'fetchList',
    'parameter' => array(  false )
    );
$Status = array(
    'name'=> 'Status',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezcontentobjectversion.php',
    'class' => 'eZContentObjectVersion',
    'function' => 'statusList',
    'parameter' => array(  false )
    );
$Assigned = array(
    'name'=> 'Owner',
    'values'=> array(
        array(
            'Name' => 'Self',
            'value' => '1')
        )
    );
$Node = array(
    'name'=> 'Node',
    'values'=> array()
    );

$Subtree = array(
    'name'=> 'Subtree',
    'values'=> array()
    );

/*
          array(
            'Name' => 'Frontpage',
            'value' => '1'),
        array(
            'Name' => 'Sports',
            'value' => '2'),
        array(
            'Name' => 'Music',
            'value' => '3')
 */


$FunctionList['bookmark'] = array();

$FunctionList['read'] = array( 'Class' => $ClassID,
                               'Section' => $SectionID,
                               'Owner' => $Assigned,
                               'Node' => $Node,
                               'Subtree' => $Subtree);
$FunctionList['create'] = array( 'Class' => $ClassID,
                                 'Section' => $SectionID,
                                 'ParentClass' => $ParentClassID,
                                 'Node' => $Node,
                                 'Subtree' => $Subtree
                                 );
$FunctionList['edit'] = array( 'Class' => $ClassID,
                               'Section' => $SectionID,
                               'Owner' => $Assigned,
                               'Node' => $Node,
                               'Subtree' => $Subtree);
$FunctionList['translate'] = array( 'Class' => $ClassID,
                                    'Section' => $SectionID,
                                    'Owner' => $Assigned,
                                    'Node' => $Node,
                                    'Subtree' => $Subtree );
$FunctionList['remove'] = array( 'Class' => $ClassID,
                                 'Section' => $SectionID,
                                 'Owner' => $Assigned,
                                 'Node' => $Node,
                                 'Subtree' => $Subtree
                                 );

$FunctionList['versionread'] = array( 'Class' => $ClassID,
                                      'Section' => $SectionID,
                                      'Owner' => $Assigned,
                                      'Status' => $Status,
                                      'Node' => $Node,
                                      'Subtree' => $Subtree);
$FunctionList['pdf'] = array( 'Class' => $ClassID,
                              'Section' => $SectionID,
                              'Owner' => $Assigned,
                              'Node' => $Node,
                              'Subtree' => $Subtree );

$FunctionList['translations'] = array();
$FunctionList['urltranslator'] = array();
$FunctionList['pendinglist'] = array();

$FunctionList['restore'] = array( );
$FunctionList['cleantrash'] = array( );

/*
$ViewArray['view'] = array(
    'functions' => array( 'read', ''
    'script' => 'view.php',
    'params' => array( 'ViewMode', 'NodeID', 'LanguageCode' ),
    'unordered_params' => array( 'language' => 'Language',
                                 'offset' => 'Offset' )
    );

*/
// Module definition





?>
