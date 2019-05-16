<?php
//
// Definition of eZUserLoginHandler class
//
// Created on: <24-Jul-2003 15:11:57 wy>
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

/*! \file ezuserloginhandler.php
*/

/*!
  \class eZUserLoginHandler ezuserloginhandler.php
  \brief The class eZUserLoginHandler does

*/

class eZUserLoginHandler
{
    /*!
     Constructor
    */
    function eZUserLoginHandler()
    {
    }

    function &instance( $protocol = "standard" )
    {
        if ( $protocol == "standard" )
        {
            include_once( 'kernel/classes/datatypes/ezuser/ezuser.php' );
            $impl = new eZUser( 0 );
            return $impl;
        }
        else
        {
            // to do: get include path from extension dir.
            $ezuserFile = 'kernel/classes/datatypes/ezuser/ez' . strtolower( $protocol ) . 'user.php';
            if ( file_exists( $ezuserFile ) )
            {
                include_once( $ezuserFile );
                $className = 'eZ' . $protocol . 'User';
                $impl = new $className();
                return $impl;
            }
        }
    }
}

?>