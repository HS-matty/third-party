<?php
//
// Definition of eZOverride class
//
// Created on: <31-Oct-2002 09:18:07 amos>
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

/*! \file ezoverride.php
*/

/*!
  \class eZOverride ezoverride.php
  \brief The class eZOverride does

*/

class eZOverride
{
    /*!
     Constructor
    */
    function eZOverride()
    {
    }

    function selectFile( $matches, $matchKeys, &$matchedKeys, $regexpMatch )
    {
        $match = null;
        foreach ( $matches as $templateMatch )
        {
            $templatePath = $templateMatch["file"];
            $templateType = $templateMatch["type"];
            if ( $templateType == "normal" )
            {
                if ( file_exists( $templatePath ) )
                {
                    $match = $templateMatch;
                    break;
                }
            }
            else if ( $templateType == "override" )
            {
                $foundOverrideFile = false;
                if ( file_exists( $templatePath ) )
                {
                    $match = $templateMatch;
                    $match["file"] = $templatePath;
                    $foundOverrideFile = true;
                }
                if ( !$foundOverrideFile and
                     count( $matchKeys ) == 0 )
                    continue;
                if ( !$foundOverrideFile and
                     preg_match( $regexpMatch, $templatePath, $regs ) )// Check for dir/filebase_keyname_keyid.tpl, eg. content/view_section_1.tpl
                {
                    foreach ( $matchKeys as $matchKeyName => $matchKeyValue )
                    {
                        $file = $regs[1] . "/" . $regs[2] . "_$matchKeyName" . "_$matchKeyValue" . $regs[3];
                        if ( file_exists( $file ) )
                        {
                            $match = $templateMatch;
                            $match["file"] = $file;
                            $foundOverrideFile = true;
                            $matchedKeys[$matchKeyName] = $matchKeyValue;
//                             eZDebug::writeNotice( "Match found, using override " . $match["file"]  );
                            break;
                        }
                    }
                }
                if ( $match !== null )
                    break;
            }
        }
        return $match;
    }
}

?>
