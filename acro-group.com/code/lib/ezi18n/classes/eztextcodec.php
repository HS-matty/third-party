<?php
//
// Definition of eZTextCodec class
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

/*! \defgroup eZI18N Internationalization */

/*!
  \class eZTextCodec eztextcodec.php
  \ingroup eZI18N
  \brief Handles conversion from one charset to another

  Supports <a href="http://www.ietf.org/rfc/rfc2279.txt">utf8</a> encoding/decoding

*/

class eZTextCodec
{
    /*!
    */
    function eZTextCodec( $inputCharsetCode, $outputCharsetCode,
                          $realInputCharsetCode, $realOutputCharsetCode,
                          $inputEncoding, $outputEncoding )
    {
        include_once( "lib/ezi18n/classes/ezcharsetinfo.php" );
        $this->RequestedInputCharsetCode = $inputCharsetCode;
        $this->RequestedOutputCharsetCode = $outputCharsetCode;
        $this->InputCharsetCode = $realInputCharsetCode;
        $this->OutputCharsetCode = $realOutputCharsetCode;
        $this->InputCharacterEncodingScheme = $inputEncoding;
        $this->OutputCharacterEncodingScheme = $outputEncoding;

        $useMBStringExtension = false;
        if ( isset( $GLOBALS['eZTextCodecMBStringExtension'] ) )
            $useMBStringExtension = $GLOBALS['eZTextCodecMBStringExtension'];

        // NOTE:
        // The method eZMBStringMapper::hasMBStringExtension() has been copied and inlined here
        // Any modification must be reflected in the method
        $hasMBString = ( function_exists( "mb_convert_encoding" ) and
                         function_exists( "mb_substitute_character" ) and
                         function_exists( "mb_strcut" ) and
                         function_exists( "mb_strlen" ) and
                         function_exists( "mb_strpos" ) and
                         function_exists( "mb_strrpos" ) and
                         function_exists( "mb_strwidth" ) and
                         function_exists( "mb_substr" ) );

        $useMBString = ( $useMBStringExtension and
                         eZTextCodec::useMBString() and
                         $hasMBString );

        // Map for conversion functions using encoding functions
        $encodingConvertMap = array();
        $encodingConvertInitMap = array();
        $encodingStrlenMap = array();

        $encodingStrlenMap['unicode'] = 'strlenUnicode';
        $encodingStrlenMap['utf-8'] = 'strlenCodepageRev';
        $encodingStrlenMap['singlebyte'] = 'strlenCodepage';
        $encodingStrlenMap['doublebyte'] = 'strlenCodepage';

        // Unicode -> other
        $encodingConvertMap['unicode']['unicode'] = 'convertNone';
        $encodingConvertMap['unicode']['utf-8'] = 'convertUnicodeToUTF8';
        $encodingConvertMap['unicode']['singlebyte'] = 'convertUnicodeToCodepage';
        $encodingConvertMap['unicode']['doublebyte'] = 'convertUnicodeToCodepage';

        $encodingConvertInitMap['unicode']['singlebyte'] = 'initializeOutputCodepage';
        $encodingConvertInitMap['unicode']['doublebyte'] = 'initializeOutputCodepage';

        // UTF8 -> other
        $encodingConvertMap['utf-8']['unicode'] = 'convertUTF8ToUnicode';
        $encodingConvertMap['utf-8']['utf-8'] = 'convertNone';
        $encodingConvertMap['utf-8']['singlebyte'] = 'convertCodepageRev';
        $encodingConvertMap['utf-8']['doublebyte'] = 'convertCodepageRev';

        $encodingConvertInitMap['utf-8']['singlebyte'] = 'initializeOutputCodepage';
        $encodingConvertInitMap['utf-8']['doublebyte'] = 'initializeOutputCodepage';

        // singlebyte -> other
        $encodingConvertMap['singlebyte']['unicode'] = 'convertCodepageToUnicode';
        $encodingConvertMap['singlebyte']['utf-8'] = 'convertCodepage';
        $encodingConvertMap['singlebyte']['singlebyte'] = 'convertCodepageMapper';
        $encodingConvertMap['singlebyte']['doublebyte'] = 'convertCodepageMapper';

        $encodingConvertInitMap['singlebyte']['unicode'] = 'initializeInputCodepage';
        $encodingConvertInitMap['singlebyte']['utf-8'] = 'initializeInputCodepage';
        $encodingConvertInitMap['singlebyte']['singlebyte'] = 'initializeCodepageMapper';
        $encodingConvertInitMap['singlebyte']['doublebyte'] = 'initializeCodepageMapper';

        // doublebyte -> other
        $encodingConvertMap['doublebyte']['unicode'] = 'convertCodepageToUnicode';
        $encodingConvertMap['doublebyte']['utf-8'] = 'convertCodepage';
        $encodingConvertMap['doublebyte']['singlebyte'] = 'convertCodepageMapper';
        $encodingConvertMap['doublebyte']['doublebyte'] = 'convertCodepageMapper';

        $encodingConvertInitMap['doublebyte']['unicode'] = 'initializeInputCodepage';
        $encodingConvertInitMap['doublebyte']['utf-8'] = 'initializeInputCodepage';
        $encodingConvertInitMap['doublebyte']['singlebyte'] = 'initializeCodepageMapper';
        $encodingConvertInitMap['doublebyte']['doublebyte'] = 'convertCodepageMapper';


        $noneConversionFunction = 'convertNone';
        $noneStrlenFunction = 'strlenNone';
        $conversionFunction = null;
        $strlenFunction = null;
        $encodingConvertInitFunction = null;

        // NOTE:
        // The method eZMBStringMapper::charsetList() hash been copied and inlined here
        // Any modification must be reflected in the method
        $mbStringCharsets =& $GLOBALS["eZMBCharsetList"];
        if ( $useMBString and
             !is_array( $mbStringCharsets ) )
        {
            $charsetList = array( "ucs-4", "ucs-4be", "ucs-4le", "ucs-2", "ucs-2be", "ucs-2le", "utf-32", "utf-32be", "utf-32le", "utf-16",
                                  "utf-16be", "utf-16le", "utf-8", "utf-7", "ascii", "euc-jp", "sjis", "eucjp-win", "sjis-win", "iso-2022-jp", "jis",
                                  "iso-8859-1", "iso-8859-2", "iso-8859-3", "iso-8859-4", "iso-8859-5", "iso-8859-6", "iso-8859-7", "iso-8859-8",
                                  "iso-8859-9", "iso-8859-10", "iso-8859-13", "iso-8859-14", "iso-8859-15", "byte2be", "byte2le", "byte4be",
                                  "byte4le", "base64", "7bit", "8bit", "utf7-imap" );
            $mbStringCharsets = array();
            foreach ( $charsetList as $charset )
            {
                $mbStringCharsets[$charset] = $charset;
            }
        }

        // Is to true if the charsets are the same and they have singlebyte encoding
        $isSinglebyteSame = false;
        $isSame = false;

        // First detect conversion type
        if ( $this->InputCharsetCode == $this->OutputCharsetCode ) // Direct match, no conversion
        {
            $conversionFunction = $noneConversionFunction;
            $encodingConvertInitFunction = 'initializeInputCodepage';
            $inpenc = $this->InputCharacterEncodingScheme;
            if ( $inpenc == 'singlebyte' )
            {
                $isSinglebyteSame = true;
            }
            $isSame = true;
        }
        else if ( $useMBString and
                  isset( $mbStringCharsets[$this->InputCharsetCode] ) and
                  isset( $mbStringCharsets[$this->OutputCharsetCode] ) ) // Use MBString for converting if charsets supported
        {
            // NOTE:
            // The mbstringmapper object is no longer needed since all functionality is inlined
//             $this->MBStringMapper = eZMBStringMapper::instance( $this->InputCharsetCode,
//                                                                 $this->OutputCharsetCode );
            $conversionFunction = "convertMBString";
            $strlenFunction = "strlenMBString";
            $encodingConvertInitFunction = false;
        }
        else // See if we support encoding scheme and codepage
        {
            $inpenc = $this->InputCharacterEncodingScheme;
            $outenc = $this->OutputCharacterEncodingScheme;
            if ( isset( $encodingConvertMap[$inpenc][$outenc] ) )
            {
                $conversionFunction = $encodingConvertMap[$inpenc][$outenc];
            }
        }

        if ( $strlenFunction === null )
        {
            $inpenc = $this->InputCharacterEncodingScheme;
            if ( $isSinglebyteSame )
                $strlenFunction = 'strlenNone';
            else if ( isset( $encodingStrlenMap[$inpenc] ) )
            {
                $strlenFunction = $encodingStrlenMap[$inpenc];
            }
        }

        if ( !$isSame and
             $conversionFunction and
             $strlenFunction )
        {
            $this->initializeConversionFunction( $encodingConvertInitMap, $encodingConvertInitFunction );
        }
        if ( !$conversionFunction or
             !$strlenFunction )
        {
            eZDebug::writeError( "Cannot create textcodec from characterset " . $this->RequestedInputCharsetCode .
                                 " to characterset " . $this->RequestedOutputCharsetCode,
                                 "eZTextCodec" );
            if ( !$conversionFunction )
                $conversionFunction = $noneConversionFunction;
            if ( !$strlenFunction )
                $strlenFunction = $noneStrlenFunction;
        }

        $this->ConversionFunction = $conversionFunction;
        $this->StrlenFunction = $strlenFunction;
        $this->RequireConversion = $conversionFunction != $noneConversionFunction;
    }

    function initializeConversionFunction( $encodingConvertInitMap, $encodingConvertInitFunction )
    {
        $inpenc = $this->InputCharacterEncodingScheme;
        $outenc = $this->OutputCharacterEncodingScheme;
        $initFunction = false;
        if ( $encodingConvertInitFunction !== null )
        {
            if ( $encodingConvertInitFunction )
            {
                $initFunction = $encodingConvertInitFunction;
            }
        }
        else if ( isset( $encodingConvertInitMap[$inpenc][$outenc] ) )
        {
            $initFunction = $encodingConvertInitMap[$inpenc][$outenc];
        }
        if ( $initFunction )
        {
            $this->$initFunction();
        }
    }

    function initializeCodepageMapper()
    {
        include_once( 'lib/ezi18n/classes/ezcodepagemapper.php' );
        $this->CodepageMapper =& eZCodepageMapper::instance( $this->InputCharsetCode,
                                                             $this->OutputCharsetCode );
    }

    function initializeInputCodepage()
    {
        include_once( 'lib/ezi18n/classes/ezcodepage.php' );
        $this->Codepage =& eZCodepage::instance( $this->InputCharsetCode );
    }

    function initializeOutputCodepage()
    {
        include_once( 'lib/ezi18n/classes/ezcodepage.php' );
        $this->Codepage =& eZCodepage::instance( $this->OutputCharsetCode );
    }

    /*!/
     \return true if a conversion is required, if false there's no need to call the textcodec functions.
    */
    function conversionRequired()
    {
        return $this->RequireConversion;
    }

    function setUseMBString( $use )
    {
        $GLOBALS["eZTextCodecUseMBString"] = $use;
    }

    function useMBString()
    {
        $use =& $GLOBALS["eZTextCodecUseMBString"];
        if ( !isset( $use ) )
            $use = true;
        return $use;
    }

    function requestedInputCharsetCode()
    {
        return $this->RequestedInputCharsetCode;
    }

    function requestedOutputCharsetCode()
    {
        return $this->RequestedOutputCharsetCode;
    }

    function inputCharsetCode()
    {
        return $this->InputCharsetCode;
    }

    function outputCharsetCode()
    {
        return $this->OutputCharsetCode;
    }

    function &convertString( $str )
    {
        eZDebug::accumulatorStart( 'textcodec_conversion', false, 'String conversion' );
        $conversionFunction = $this->ConversionFunction;
        $tmp =& $this->$conversionFunction( $str );
        eZDebug::accumulatorStop( 'textcodec_conversion' );
        return $tmp;
    }

    function strlen( $str )
    {
        $strlenFunction = $this->StrlenFunction;
        return $this->$strlenFunction( $str );
    }

    /*!
     \return an empty array since no conversion is possible.
    */
    function &convertNoneToUnicode( $str )
    {
        return array();
    }

    function &convertCodepageToUnicode( $str )
    {
        eZDebug::accumulatorStart( 'textcodec_codepage_unicode', false, 'String conversion w/ codepage to Unicode' );
        $tmp = $this->Codepage->convertStringToUnicode( $str );
        eZDebug::accumulatorStop( 'textcodec_codepage_unicode' );
        return $tmp;
    }

    function &convertUTF8ToUnicode( $str )
    {
        include_once ( 'lib/ezi18n/classes/ezutf8codec.php' );
        eZDebug::accumulatorStart( 'textcodec_utf8_unicode', false, 'String conversion w/ UTF-8 to Unicode' );
        $tmp = eZUTF8Codec::convertStringToUnicode( $str );
        eZDebug::accumulatorStop( 'textcodec_utf8_unicode' );
        return $tmp;
    }

    function &convertUnicodeToCodepage( $unicodeValues )
    {
        eZDebug::accumulatorStart( 'textcodec_unicode_codepage', false, 'String conversion w/ Unicode to codepage' );
        $tmp = $this->Codepage->convertUnicodeToString( $unicodeValues );
        eZDebug::accumulatorStop( 'textcodec_unicode_codepage' );
        return $tmp;
    }

    function &convertUnicodeToUTF8( $unicodeValues )
    {
        include_once ( 'lib/ezi18n/classes/ezutf8codec.php' );
        eZDebug::accumulatorStart( 'textcodec_unicode_utf8', false, 'String conversion w/ Unicode to UTF8' );
        $tmp = eZUTF8Codec::convertUnicodeToString( $unicodeValues );
        eZDebug::accumulatorStop( 'textcodec_unicode_utf8' );
        return $tmp;
    }

    function &convertNone( $str )
    {
        return $str;
    }

    function &convertCodepage( $str )
    {
        eZDebug::accumulatorStart( 'textcodec_codepage', false, 'String conversion w/ codepage' );
        $tmp =& $this->Codepage->convertString( $str );
        eZDebug::accumulatorStop( 'textcodec_codepage', false, 'String conversion w/ codepage' );
        return $tmp;
    }

    function &convertCodepageRev( $str )
    {
        eZDebug::accumulatorStart( 'textcodec_codepage_rev', false, 'String conversion w/ codepage reverse' );
        $tmp =& $this->Codepage->convertStringFromUTF8( $str );
        eZDebug::accumulatorStop( 'textcodec_codepage_rev', false, 'String conversion w/ codepage reverse' );
        return $tmp;
    }

    function &convertCodepageMapper( $str )
    {
        eZDebug::accumulatorStart( 'textcodec_codepage_mapper', false, 'String conversion w/ codepage mapper' );
        $tmp =& $this->CodepageMapper->convertString( $str );
        eZDebug::accumulatorStop( 'textcodec_codepage_mapper', false, 'String conversion w/ codepage mapper' );
        return $tmp;
    }

    function &convertMBString( $str )
    {
        eZDebug::accumulatorStart( 'textcodec_mbstring', false, 'String conversion w/ mbstring' );
//        $tmp =& $this->MBStringMapper->convertString( $str );
        // NOTE:
        // Uses the mbstring function directly instead of going trough the class
        $tmp =& mb_convert_encoding( $str, $this->OutputCharsetCode, $this->InputCharsetCode );
        eZDebug::accumulatorStop( 'textcodec_mbstring', false, 'String conversion w/ mbstring' );
        return $tmp;
    }

    function strlenNone( $str )
    {
        return strlen( $str );
    }

    function strlenUnicode( $unicodeValues )
    {
        return count( $unicodeValues );
    }

    function strlenCodepage( $str )
    {
        return $this->Codepage->strlen( $str );
    }

    function strlenCodepageRev( $str )
    {
        return $this->Codepage->strlenFromUTF8( $str );
    }

    function strlenCodepageMapper( $str )
    {
        return $this->CodepageMapper->strlen( $str );
    }

    function strlenMBString( $str )
    {
//        return $this->MBStringMapper->strlen( $str );
        // NOTE:
        // Uses the mbstring function directly instead of going trough the class
        return mb_strlen( $str, $this->InputCharsetCode );
    }

    /*!
     \static
     \return a text codec instance which can be used to convert from input charset \a $inputCharsetCode
             and into output charset \a $outputCharsetCode.
     \param $inputCharsetCode If \c false the internal charset it used, otherwise it is used directly
     \param $outputCharsetCode If \c false the internal charset it used, otherwise it is used directly
     \param $alwaysReturn If \c false it will only return a textcodec instance if it is required for the input and output charset.
                          In which case it returns \c null.
    */
    function &instance( $inputCharsetCode, $outputCharsetCode = false, $alwaysReturn = true )
    {
        if ( $inputCharsetCode === false or $outputCharsetCode === false )
        {
            if ( isset( $GLOBALS['eZTextCodecInternalCharsetReal'] ) )
            {
                $internalCharset = $GLOBALS['eZTextCodecInternalCharsetReal'];
            }
            else
            {
                $internalCharset = eZTextCodec::internalCharset();
            }
        }

        if ( $inputCharsetCode === false )
        {
            $realInputCharsetCode = $inputCharsetCode = $internalCharset;
        }
        else
        {
            $realInputCharsetCode = eZCharsetInfo::realCharsetCode( $inputCharsetCode );
        }

        if ( $outputCharsetCode === false )
        {
            $realOutputCharsetCode = $outputCharsetCode = $internalCharset;
        }
        else
        {
            $realOutputCharsetCode = eZCharsetInfo::realCharsetCode( $outputCharsetCode );
        }

        $check =& $GLOBALS["eZTextCodecCharsetCheck"]["$realInputCharsetCode-$realOutputCharsetCode"];
        if ( !$alwaysReturn and isset( $check ) and !$check )
        {
            return null;
        }
        if ( isset( $check ) and is_object( $check ) )
        {
            return $check;
        }

        if ( !$realInputCharsetCode )
        {
            include_once( "lib/ezi18n/classes/ezcharsetinfo.php" );
            $realInputCharsetCode = eZCharsetInfo::realCharsetCode( $inputCharsetCode );
        }
        if ( !$realOutputCharsetCode )
        {
            include_once( "lib/ezi18n/classes/ezcharsetinfo.php" );
            $realOutputCharsetCode = eZCharsetInfo::realCharsetCode( $outputCharsetCode );
        }
        $inputEncoding = eZCharsetInfo::characterEncodingScheme( $realInputCharsetCode, true );
        $outputEncoding = eZCharsetInfo::characterEncodingScheme( $realOutputCharsetCode, true );
        if ( !$alwaysReturn and
             $inputEncoding == 'singlebyte' and
             $inputEncoding == $outputEncoding and
             $realInputCharsetCode == $realOutputCharsetCode )
        {
            $check = false;
            return null;
        }
        $codec =& $GLOBALS["eZTextCodec-$realInputCharsetCode-$realOutputCharsetCode"];
        if ( get_class( $codec ) != "eztextcodec" )
        {
            $codec = new eZTextCodec( $inputCharsetCode, $outputCharsetCode,
                                      $realInputCharsetCode, $realOutputCharsetCode,
                                      $inputEncoding, $outputEncoding );
        }
        $check =& $codec;
        return $codec;
    }

    /*!
     \static
     Initializes the eZTextCodec settings to the ones in the array \a $settings.
     \sa internalCharset, httpCharset.
    */
    function updateSettings( $settings )
    {
        unset( $GLOBALS['eZTextCodecInternalCharsetReal'] );
        unset( $GLOBALS['eZTextCodecHTTPCharsetReal'] );
        unset( $GLOBALS['eZTextCodecCharsetCheck'] );
        $GLOBALS['eZTextCodecInternalCharset'] = $settings['internal-charset'];
        $GLOBALS['eZTextCodecHTTPCharset'] = $settings['http-charset'];
        $GLOBALS['eZTextCodecMBStringExtension'] = $settings['mbstring-extension'];
    }

    /*!
     \static
     \return the charset which is used internally,
     this is the charset which all external files and resources are converted to.
     \note will return iso-8859-1 if eZTextCodec has been updated with proper settings.
    */
    function internalCharset()
    {
        $realCharset =& $GLOBALS['eZTextCodecInternalCharsetReal'];
        if ( !isset( $realCharset ) )
        {
            if ( !isset( $GLOBALS['eZTextCodecInternalCharset'] ) )
                $charsetCode = 'iso-8859-1';
            else
                $charsetCode = $GLOBALS['eZTextCodecInternalCharset'];
            include_once( "lib/ezi18n/classes/ezcharsetinfo.php" );
            $realCharset = eZCharsetInfo::realCharsetCode( $charsetCode );
        }
        return $realCharset;
    }

    /*!
     \static
     \return a charset value which can be used in HTTP headers.
     \note Will return the internalCharset() if not http charset is set.
    */
    function httpCharset()
    {
        $realCharset =& $GLOBALS['eZTextCodecHTTPCharsetReal'];
        if ( !isset( $realCharset ) )
        {
            $charset = '';
            if ( isset( $GLOBALS['eZTextCodecHTTPCharset'] ) )
                $charset = $GLOBALS['eZTextCodecHTTPCharset'];
            if ( $charset == '' )
            {
                if ( isset( $GLOBALS['eZTextCodecInternalCharsetReal'] ) )
                    $realCharset = $GLOBALS['eZTextCodecInternalCharsetReal'];
                else
                    $realCharset = eZTextCodec::internalCharset();
            }
            else
            {
                include_once( "lib/ezi18n/classes/ezcharsetinfo.php" );
                $realCharset = eZCharsetInfo::realCharsetCode( $charset );
            }
        }
        return $realCharset;
    }
}

?>
