<?php
//
// Definition of eZFileDirectHandler class
//
// Created on: <30-Apr-2002 16:47:08 bf>
//
// Copyright (C) 1999-2004 eZ systems as. All rights reserved.
//
// This source file is part of the eZ publish (tm) Open Source Content
// Management System.
//
// This file may be distributed and/or modified under the terms of the
// "GNU General Public License" version 2 as published by the Free
// Software Foundation and appearing in the file LICENSE.GPL included in
// the packaging of this file.
//
// Licencees holding valid "eZ publish professional licences" may use this
// file in accordance with the "eZ publish professional licence" Agreement
// provided with the Software.
//
// This file is provided AS IS with NO WARRANTY OF ANY KIND, INCLUDING
// THE WARRANTY OF DESIGN, MERCHANTABILITY AND FITNESS FOR A PARTICULAR
// PURPOSE.
//
// The "eZ publish professional licence" is available at
// http://ez.no/products/licences/professional/. For pricing of this licence
// please contact us via e-mail to licence@ez.no. Further contact
// information is available at http://ez.no/home/contact/.
//
// The "GNU General Public License" (GPL) is available at
// http://www.gnu.org/copyleft/gpl.html.
//
// Contact licence@ez.no if any conditions of this licencing isn't clear to
// you.
//

/*!
  \class eZFileDirectHandler ezfiledirecthandler.php
  \ingroup eZBinaryHandlers
  \brief Handles file downloading by passing an URL directly to the file.

*/
include_once( "kernel/classes/datatypes/ezbinaryfile/ezbinaryfile.php" );
include_once( "kernel/classes/ezbinaryfilehandler.php" );
define( "EZ_FILE_DIRECT_ID", 'ezfiledirect' );

class eZFileDirectHandler extends eZBinaryFileHandler
{
    function eZFileDirectHandler()
    {
        $this->eZBinaryFileHandler( EZ_FILE_DIRECT_ID, "direct download", EZ_BINARY_FILE_HANDLE_DOWNLOAD );
    }

    function handleFileDownload( &$contentObject, &$contentObjectAttribute, $type, $mimeData )
    {
        return EZ_BINARY_FILE_RESULT_OK;
    }

    /*!
     \reimp
     \return the direct download template suffix
    */
    function &viewTemplate( &$contentobjectAttribute )
    {
        return 'direct';
    }

}

?>
