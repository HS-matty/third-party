<?php
//
// Created on: <11-Aug-2003 18:30:20 amos>
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

/*! \file function_definition.php
*/

$FunctionList = array();
$FunctionList['list'] = array( 'name' => 'list',
                               'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                       'class' => 'eZPackageFunctionCollection',
                                                       'method' => 'fetchList' ),
                               'parameter_type' => 'standard',
                               'parameters' => array(  array( 'name' => 'filter_array',
                                                              'type' => 'array',
                                                              'required' => false,
                                                              'default' => false ),
                                                       array( 'name' => 'offset',
                                                              'type' => 'integer',
                                                              'default' => false,
                                                              'required' => false ),
                                                       array( 'name' => 'limit',
                                                              'type' => 'integer',
                                                              'default' => false,
                                                              'required' => false ),
                                                       array( 'name' => 'repository_id',
                                                              'type' => 'string',
                                                              'default' => false,
                                                              'required' => false ) ) );
$FunctionList['maintainer_role_list'] = array( 'name' => 'maintainer_role_list',
                                               'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                                       'class' => 'eZPackageFunctionCollection',
                                                                       'method' => 'fetchMaintainerRoleList' ),
                                               'parameter_type' => 'standard',
                                               'parameters' => array(  array( 'name' => 'type',
                                                                              'type' => 'string',
                                                                              'required' => false,
                                                                              'default' => false ),
																	   array( 'name' => 'check_roles',
                                                                              'type' => 'boolean',
                                                                              'required' => false,
                                                                              'default' => false ) ) );
$FunctionList['can_create'] = array( 'name' => 'can_create',
                                     'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                             'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canCreate' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );

$FunctionList['can_edit'] = array( 'name' => 'can_edit',
                                   'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                           'class' => 'eZPackageFunctionCollection',
                                                           'method' => 'canEdit' ),
                                   'parameter_type' => 'standard',
                                   'parameters' => array() );

$FunctionList['can_import'] = array( 'name' => 'can_import',
                                     'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                             'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canImport' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );

$FunctionList['can_install'] = array( 'name' => 'can_install',
                                      'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                              'class' => 'eZPackageFunctionCollection',
                                                              'method' => 'canInstall' ),
                                      'parameter_type' => 'standard',
                                      'parameters' => array() );

$FunctionList['can_export'] = array( 'name' => 'can_export',
                                     'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                             'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canExport' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );

$FunctionList['can_read'] = array( 'name' => 'can_read',
                                   'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                           'class' => 'eZPackageFunctionCollection',
                                                           'method' => 'canRead' ),
                                   'parameter_type' => 'standard',
                                   'parameters' => array() );

$FunctionList['can_list'] = array( 'name' => 'can_list',
                                   'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                           'class' => 'eZPackageFunctionCollection',
                                                           'method' => 'canList' ),
                                   'parameter_type' => 'standard',
                                   'parameters' => array() );

$FunctionList['can_remove'] = array( 'name' => 'can_remove',
                                     'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                             'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canRemove' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );


$FunctionList['item'] = array( 'name' => 'item',
                               'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                       'class' => 'eZPackageFunctionCollection',
                                                       'method' => 'fetchPackage' ),
                               'parameter_type' => 'standard',
                               'parameters' => array( array( 'name' => 'package_name',
                                                             'type' => 'string',
                                                             'required' => true ),
                                                      array( 'name' => 'repository_id',
                                                             'type' => 'string',
                                                             'default' => false,
                                                             'required' => false ) ) );

$FunctionList['dependent_list'] = array( 'name' => 'dependent_list',
                                         'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                                 'class' => 'eZPackageFunctionCollection',
                                                                 'method' => 'fetchDependentPackageList' ),
                                         'parameter_type' => 'standard',
                                         'parameters' => array( array( 'name' => 'package_name',
                                                                       'type' => 'string',
                                                                       'required' => true ),
                                                                array( 'name' => 'parameters',
                                                                       'type' => 'array',
                                                                       'required' => false,
                                                                       'default' => false ),
                                                                array( 'name' => 'repository_id',
                                                                       'type' => 'string',
                                                                       'default' => false,
                                                                       'required' => false ) ) );
$FunctionList['repository_list'] = array( 'name' => 'repository_list',
                                          'call_method' => array( 'include_file' => 'kernel/package/ezpackagefunctioncollection.php',
                                                                  'class' => 'eZPackageFunctionCollection',
                                                                  'method' => 'fetchRepositoryList' ),
                                          'parameter_type' => 'standard',
                                          'parameters' => array() );
?>
