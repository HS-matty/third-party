<?php
//
// Definition of eZCodePageMapper class
//
// Created on: <11-Jul-2002 15:39:41 amos>
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

/*! \file ezcodepagemapper.php
*/

/*!
  \class eZCodePageMapper ezcodepagemapper.php
  \brief The class eZCodePageMapper does

*/

include_once( "lib/ezutils/classes/ezdebug.php" );
include_once( "lib/ezi18n/classes/ezcodepage.php" );

define( "EZ_CODEPAGE_MAPPER_CACHE_CODE_DATE", 1026316422 );

class eZCodePageMapper
{
    /*!
     Constructor
    */
    function eZCodePageMapper( $input_charset_code, $output_charset_code, $use_cache = true )
    {
        $this->RequestedInputCharsetCode = $input_charset_code;
        $this->InputCharsetCode = eZCharsetInfo::realCharsetCode( $input_charset_code );
        $this->RequestedOutputCharsetCode = $output_charset_code;
        $this->OutputCharsetCode = eZCharsetInfo::realCharsetCode( $output_charset_code );
        $this->Valid = false;
        $this->load( $use_cache );
        $this->setSubstituteCharacter( 63 ); // ?
    }

    function isValid()
    {
        return $this->Valid;
    }

    function &mapInputCode( $in_code )
    {
        if ( isset( $this->InputOutputMap[$in_code] ) )
            return $this->InputOutputMap[$in_code];
        return null;
    }

    function &mapOutputCode( $out_code )
    {
        if ( isset( $this->OutputInputMap[$out_code] ) )
            return $this->OutputInputMap[$out_code];
        return null;
    }

    function mapInputChar( $in_char )
    {
        $in_code = ord( $in_char );
        if ( isset( $this->InputOutputMap[$in_code] ) )
            return chr( $this->InputOutputMap[$in_code] );
        return $this->SubstituteOutputChar;
    }

    function mapOutputChar( $out_char )
    {
        $out_code = ord( $out_char );
        if ( isset( $this->OutputInputMap[$out_code] ) )
            return chr( $this->OutputInputMap[$out_code] );
        return $this->SubstituteInputChar;
    }

    function substituteCharacterFor( $char )
    {
    }

    function substituteCharacter()
    {
        return $this->SubstituteCharValue;
    }

    function convertString( $str )
    {
        $out = "";
        $len = strlen( $str );
        for ( $i = 0; $i < $len; ++$i )
        {
            $char = $str[$i];
            $out .= $this->mapInputChar( $char );
        }
        return $out;
    }

    function strlen( $str )
    {
        return strlen( $str );
    }

    function strpos( $haystack, $needle, $offset = 0 )
    {
        return strpos( $haystack, $needle, $offset );
    }

    function strrpos( $haystack, $needle )
    {
        return strrpos( $haystack, $needle );
    }

    function substr( $str, $start, $length )
    {
        return substr( $str, $start, $length );
    }

    function setSubstituteCharacter( $char_code )
    {
        $this->SubstituteCharValue = $char_code;
        $input_codepage =& eZCodePage::instance( $this->InputCharsetCode );
        $output_codepage =& eZCodePage::instance( $this->OutputCharsetCode );
        if ( !$input_codepage->isValid() )
        {
            eZDebug::writeError( "Input codepage for " . $this->InputCharsetCode . " is not valid", "eZCodePageMapper" );
            return false;
        }
        if ( !$output_codepage->isValid() )
        {
            eZDebug::writeError( "Output codepage for " . $this->OutputCharsetCode . " is not valid", "eZCodePageMapper" );
            return false;
        }
        $this->SubstituteInputChar = chr( $input_codepage->unicodeToCode( $char_code ) );
        $this->SubstituteOutputChar = chr( $output_codepage->unicodeToCode( $char_code ) );
    }

    function load( $use_cache = true )
    {
        $cache_dir = "var/cache/codepages/";
        $cache_filename = md5( $this->InputCharsetCode . $this->OutputCharsetCode );
        $cache = $cache_dir . $cache_filename . ".php";

        if ( !eZCodePage::exists( $this->InputCharsetCode ) )
        {
            $input_file = eZCodePage::fileName( $this->InputCharsetCode );
            eZDebug::writeWarning( "Couldn't load input codepage file $input_file", "eZCodePageMapper" );
            return false;
        }
        if ( !eZCodePage::exists( $this->OutputCharsetCode ) )
        {
            $output_file = eZCodePage::fileName( $this->OutputCharsetCode );
            eZDebug::writeWarning( "Couldn't load output codepage file $output_file", "eZCodePageMapper" );
            return false;
        }

        $this->Valid = false;
        if ( file_exists( $cache ) and $use_cache )
        {
            $cache_m = filemtime( $cache );
            if ( eZCodePage::fileModification( $this->InputCharsetCode ) <= $cache_m and
                 eZCodePage::fileModification( $this->OutputCharsetCode ) <= $cache_m )
            {
                unset( $eZCodePageMapperCacheCodeDate );
                $in_out_map =& $this->InputOutputMap;
                $out_in_map =& $this->OutputInputMap;
                include( $cache );
                if ( isset( $eZCodePageMapperCacheCodeDate ) or
                     $eZCodePageMapperCacheCodeDate == EZ_CODEPAGE_MAPPER_CACHE_CODE_DATE )
                {
                    $this->Valid = true;
                    return;
                }
            }
        }

        $this->InputOutputMap = array();
        $this->OutputInputMap = array();

        $input_codepage =& eZCodePage::instance( $this->InputCharsetCode );
        $output_codepage =& eZCodePage::instance( $this->OutputCharsetCode );

        if ( !$input_codepage->isValid() )
        {
            eZDebug::writeError( "Input codepage for " . $this->InputCharsetCode . " is not valid", "eZCodePageMapper" );
            return false;
        }
        if ( !$output_codepage->isValid() )
        {
            eZDebug::writeError( "Output codepage for " . $this->OutputCharsetCode . " is not valid", "eZCodePageMapper" );
            return false;
        }

        $min = max( $input_codepage->minCharValue(),
                    $output_codepage->minCharValue() );
        $max = min( $input_codepage->maxCharValue(),
                    $output_codepage->maxCharValue() );

        for ( $i = $min; $i <= $max; ++$i )
        {
            $code = $i;
            $unicode = $input_codepage->codeToUnicode( $code );
            if ( $unicode !== null )
            {
                $output_code = $output_codepage->unicodeToCode( $unicode );
                if ( $output_code !== null )
                {
                    $this->InputOutputMap[$code] = $output_code;
                    $this->OutputInputMap[$output_code] = $code;
                }
            }
        }
    }

    /*!
     Returns the only instance of the codepage mapper for $input_charset_code and $output_charset_code.
    */
    function &instance( $input_charset_code, $output_charset_code, $use_cache = true )
    {
        $cp =& $GLOBALS["eZCodePageMapper-$input_charset_code-$output_charset_code"];
        if ( get_class( $cp ) != "ezcodepagemapper" )
        {
            $cp = new eZCodePageMapper( $input_charset_code, $output_charset_code, $use_cache );
        }
        return $cp;
    }

}

?>
