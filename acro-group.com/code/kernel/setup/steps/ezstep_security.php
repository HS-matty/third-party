<?php
//
// Definition of eZStepSecurity class
//
// Created on: <13-Aug-2003 10:42:32 kk>
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

/*! \file ezstep_security.php
*/
include_once( 'kernel/setup/steps/ezstep_installer.php');
include_once( "kernel/common/i18n.php" );

/*!
  \class eZStepSecurity ezstep_security.php
  \brief The class eZStepSecurity does

*/

class eZStepSecurity extends eZStepInstaller
{
    /*!
     Constructor
    */
    function eZStepSecurity( &$tpl, &$http, &$ini, &$persistenceList )
    {
        $this->eZStepInstaller( $tpl, $http, $ini, $persistenceList );
    }

    /*!
     \reimp
    */
    function processPostData()
    {
        return true; // Always continue
    }

    /*!
     \reimp
     */
    function init()
    {
        if ( file_exists( '.htaccess' ) )
        {
            return true;
        }
        include_once( 'lib/ezutils/classes/ezsys.php' );
        return eZSys::indexFileName() == '' ; // If in virtual host mode, continue (return true)
    }

    /*!
     \reimp
    */
    function &display()
    {
        $this->Tpl->setVariable( 'setup_previous_step', 'Security' );
        $this->Tpl->setVariable( 'setup_next_step', 'Registration' );

        $this->Tpl->setVariable( 'path', realpath( '.' ) );

        // Return template and data to be shown
        $result = array();
        // Display template
        $result['content'] = $this->Tpl->fetch( 'design:setup/init/security.tpl' );
        $result['path'] = array( array( 'text' => ezi18n( 'design/standard/setup/init',
                                                          'Securing site' ),
                                        'url' => false ) );
        return $result;
    }
}

?>
