<?php
//
// Definition of eZMBStringMapper class
//
// Created on: <12-Jul-2002 12:56:48 amos>
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

/*! \file ezmbstringmapper.php
*/

/*!
  \class eZMBStringMapper ezmbstringmapper.php
  \ingroup eZI18N
  \brief The class eZMBStringMapper does

  The mbstring extension supports the following charset:
  UCS-4, UCS-4BE, UCS-4LE, UCS-2, UCS-2BE, UCS-2LE, UTF-32, UTF-32BE, UTF-32LE, UCS-2LE, UTF-16,
  UTF-16BE, UTF-16LE, UTF-8, UTF-7, ASCII, EUC-JP, SJIS, eucJP-win, SJIS-win, ISO-2022-JP, JIS,
  ISO-8859-1, ISO-8859-2, ISO-8859-3, ISO-8859-4, ISO-8859-5, ISO-8859-6, ISO-8859-7, ISO-8859-8,
  ISO-8859-9, ISO-8859-10, ISO-8859-13, ISO-8859-14, ISO-8859-15, byte2be, byte2le, byte4be,
  byte4le, BASE64, 7bit, 8bit and UTF7-IMAP.
*/

include_once( "lib/ezi18n/classes/ezcharsetinfo.php" );

class eZMBStringMapper
{
    /*!
     Constructor
    */
    function eZMBStringMapper( $input_charset_code, $output_charset_code )
    {
        $this->RequestedInputCharsetCode = $input_charset_code;
        $this->InputCharsetCode = eZCharsetInfo::realCharsetCode( $input_charset_code );
        $this->RequestedOutputCharsetCode = $output_charset_code;
        $this->OutputCharsetCode = eZCharsetInfo::realCharsetCode( $output_charset_code );
        $this->Valid = false;
        if ( !$this->isCharsetSupported( $input_charset_code ) )
        {
            eZDebug::writeError( "Input charset $input_charset_code not supported", "eZMBStringMapper" );
        }
        else if ( !$this->isCharsetSupported( $output_charset_code ) )
        {
            eZDebug::writeError( "Output charset $output_charset_code not supported", "eZMBStringMapper" );
        }
        else if ( $this->hasMBStringExtension() )
            $this->Valid = true;
        else
            eZDebug::writeError( "No mbstring functions available", "eZMBStringMapper" );
    }

    /*!
     \static
     \note This function is duplicated in eZTextCodec::eZTextCodec(), remember to update both places.
    */
    function &charsetList()
    {
        $charsets =& $GLOBALS["eZMBCharsetList"];
        if ( !is_array( $charsets ) )
        {
            $charsetList = array( "ucs-4", "ucs-4be", "ucs-4le", "ucs-2", "ucs-2be", "ucs-2le", "utf-32", "utf-32be", "utf-32le", "utf-16",
                                  "utf-16be", "utf-16le", "utf-8", "utf-7", "ascii", "euc-jp", "sjis", "eucjp-win", "sjis-win", "iso-2022-jp", "jis",
                                  "iso-8859-1", "iso-8859-2", "iso-8859-3", "iso-8859-4", "iso-8859-5", "iso-8859-6", "iso-8859-7", "iso-8859-8",
                                  "iso-8859-9", "iso-8859-10", "iso-8859-13", "iso-8859-14", "iso-8859-15", "byte2be", "byte2le", "byte4be",
                                  "byte4le", "base64", "7bit", "8bit", "utf7-imap" );
            $charsets = array();
            foreach ( $charsetList as $charset )
            {
                $charsets[$charset] = $charset;
            }
        }
        return $charsets;
    }

    /*!
     \static
     \return \c true if the mbstring can be used.
     \note The following function must be present for the function to return \c true.
           mb_convert_encoding
           mb_substitute_character
           mb_strcut
           mb_strlen
           mb_strpos
           mb_strrpos
           mb_strwidth
           mb_substr
     \note This function is duplicated in eZTextCodec::eZTextCodec(), remember to update both places.
    */
    function hasMBStringExtension()
    {
        return ( function_exists( "mb_convert_encoding" ) and
                 function_exists( "mb_substitute_character" ) and
                 function_exists( "mb_strcut" ) and
                 function_exists( "mb_strlen" ) and
                 function_exists( "mb_strpos" ) and
                 function_exists( "mb_strrpos" ) and
                 function_exists( "mb_strwidth" ) and
                 function_exists( "mb_substr" ) );
    }

    function inputCharsetCode()
    {
        return $this->InputCharsetCode;
    }

    function outputCharsetCode()
    {
        return $this->OutputCharsetCode;
    }

    function requestedInputCharsetCode()
    {
        return $this->RequestedInputCharsetCode;
    }

    function requestedOutputCharsetCode()
    {
        return $this->RequestedOutputCharsetCode;
    }

    function isCharsetSupported( $charset_code )
    {
        $charset_code = eZCharsetInfo::realCharsetCode( $charset_code );
        return in_array( $charset_code, eZMBStringMapper::charsetList() );
    }

    function substituteCharacter()
    {
        if ( !$this->Valid )
            return null;
        return mb_substitute_character();
    }

    function setSubstituteCharacter( $char )
    {
        if ( $this->Valid )
            mb_substitute_character( $char );
    }

    function convertString( $str )
    {
        if ( !$this->Valid )
            return $str;
        return mb_convert_encoding( $str, $this->OutputCharsetCode, $this->InputCharsetCode );
    }

    function strlen( $str )
    {
        return mb_strlen( $str, $this->InputCharsetCode );
    }

    function strpos( $haystack, $needle, $offset = 0 )
    {
        return mb_strpos( $haystack, $needle, $offset, $this->InputCharsetCode );
    }

    function strrpos( $haystack, $needle )
    {
        return mb_strrpos( $haystack, $needle, $this->InputCharsetCode );
    }

    function substr( $str, $start, $length )
    {
        return mb_substr( $str, $start, $length, $this->InputCharsetCode );
    }

    function instance( $input_charset_code, $output_charset_code )
    {
        $mb =& $GLOBALS["eZMBStringMapper-$input_charset_code-$output_charset_code"];
        if ( get_class( $mb ) != "ezmbstringmapper" )
        {
            $mb = new eZMBStringMapper( $input_charset_code, $output_charset_code );
        }
        return $mb;
    }
}

?>
