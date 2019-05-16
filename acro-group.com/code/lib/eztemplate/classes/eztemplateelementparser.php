<?php
//
// Definition of eZTemplateElementParser class
//
// Created on: <27-Nov-2002 10:53:36 amos>
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

/*! \file eztemplateelementparser.php
*/

/*!
  \class eZTemplateElementParser eztemplateelementparser.php
  \brief The class eZTemplateElementParser does

*/

include_once( 'lib/eztemplate/classes/eztemplate.php' );

class eZTemplateElementParser
{
    /*!
     Constructor
    */
    function eZTemplateElementParser()
    {
    }

    function templateTypeName( $type )
    {
        switch ( $type )
        {
            case EZ_TEMPLATE_TYPE_STRING:
                return "string";
            case EZ_TEMPLATE_TYPE_NUMERIC:
                return "numeric";
            case EZ_TEMPLATE_TYPE_IDENTIFIER:
                return "identifier";
            case EZ_TEMPLATE_TYPE_VARIABLE:
                return "variable";
            case EZ_TEMPLATE_TYPE_ATTRIBUTE:
                return "attribute";
        }
        return null;
    }

    /*!
     Parses the variable and operators into a structure.
    */
    function parseVariableTag( &$tpl, $relatedTemplateName, &$text, $startPosition, &$endPosition, $textLength, $defaultNamespace,
                               $allowedType = false, $maxElements = false, $endMarker = false,
                               $undefinedType = EZ_TEMPLATE_TYPE_ATTRIBUTE )
    {
        $currentPosition = $startPosition;
        $elements = array();
        $lastPosition = false;
        if ( $allowedType === false )
            $allowedType = EZ_TEMPLATE_TYPE_BASIC;
        while ( $currentPosition < $textLength and
                ( $maxElements === false or
                  count( $elements ) < $maxElements ) )
        {
            if ( $lastPosition !== false and
                 $lastPosition == $currentPosition )
            {
                $tpl->error( "ElementParser::parseVariableTag", "parser error @ $relatedTemplateName[$currentPosition]\n" .
                             "Parser position did not move, this is most likely a bug in the template parser." );
                break;
            }
            $lastPosition = $currentPosition;
            $currentPosition = $this->whitespaceEndPos( $tpl, $text, $currentPosition, $textLength );
            if ( $currentPosition >= $textLength )
                continue;
            if ( $endMarker !== false )
            {
                if ( $currentPosition < $textLength and
                     strpos( $endMarker, $text[$currentPosition] ) !== false )
                    break;
            }
            if ( $text[$currentPosition] == '|' )
            {
                if ( !( $allowedType & EZ_TEMPLATE_TYPE_OPERATOR_BIT ) )
                {
                    $currentPosition = $lastPosition;
                    break;
                }
                $maxOperatorElements = 1;
                $operatorEndMarker = false;
                $currentOperatorPosition = $currentPosition + 1;
                $operatorEndPosition = false;
                $operatorElements = $this->parseVariableTag( $tpl, $relatedTemplateName, $text, $currentOperatorPosition, $operatorEndPosition, $textLength, $defaultNamespace,
                                                             EZ_TEMPLATE_TYPE_OPERATOR_BIT, $maxOperatorElements, $operatorEndMarker, EZ_TEMPLATE_TYPE_OPERATOR );
                if ( $operatorEndPosition > $currentOperatorPosition )
                {
                    $elements = array_merge( $elements, $operatorElements );
                    $currentPosition = $operatorEndPosition;
                }
            }
            else if ( $text[$currentPosition] == '.' or
                 $text[$currentPosition] == '[' )
            {
                if ( !( $allowedType & EZ_TEMPLATE_TYPE_ATTRIBUTE_BIT ) )
                {
                    $currentPosition = $lastPosition;
                    break;
                }
                $maxAttributeElements = 1;
                $attributeEndMarker = false;
                if ( $text[$currentPosition] == '[' )
                {
                    $maxAttributeElements = false;
                    $attributeEndMarker = ']';
                }
                ++$currentPosition;
                $attributeEndPosition = false;
                $attributeElements = $this->parseVariableTag( $tpl, $relatedTemplateName, $text, $currentPosition, $attributeEndPosition, $textLength, $defaultNamespace,
                                                              EZ_TEMPLATE_TYPE_BASIC, $maxAttributeElements, $attributeEndMarker );
                if ( $attributeEndPosition > $currentPosition )
                {
                    $element = array( EZ_TEMPLATE_TYPE_ATTRIBUTE, // type
                                      $attributeElements, // content
                                      false // debug
                                      );
                    $elements[] = $element;
                    if ( $attributeEndMarker !== false )
                        $attributeEndPosition += strlen( $attributeEndMarker );
                    $currentPosition = $attributeEndPosition;
                }
            }
            else if ( $text[$currentPosition] == "$" )
            {
                if ( !( $allowedType & EZ_TEMPLATE_TYPE_VARIABLE_BIT ) )
                {
                    $currentPosition = $lastPosition;
                    break;
                }
                ++$currentPosition;
                $variableEndPosition = $this->variableEndPos( $tpl, $relatedTemplateName, $text, $currentPosition, $textLength,
                                                              $variableNamespace, $variableName, $namespaceScope );
                if ( $variableEndPosition > $currentPosition )
                {
                    $element = array( EZ_TEMPLATE_TYPE_VARIABLE, // type
                                      array( $variableNamespace,
                                             $namespaceScope,
                                             $variableName ), // content
                                      false // debug
                                      );
                    $elements[] = $element;
                    $currentPosition = $variableEndPosition;
                    $allowedType = EZ_TEMPLATE_TYPE_MODIFIER_MASK;
                }
            }
            else if ( $text[$currentPosition] == "'" or
                      $text[$currentPosition] == '"' )
            {
                if ( !( $allowedType & EZ_TEMPLATE_TYPE_STRING_BIT) )
                {
                    $currentPosition = $lastPosition;
                    break;
                }
                $quote = $text[$currentPosition];
                ++$currentPosition;
                $quoteEndPosition = $this->quoteEndPos( $tpl, $text, $currentPosition, $textLength, $quote );
                $element = array( EZ_TEMPLATE_TYPE_STRING, // type
                                  substr( $text, $currentPosition, $quoteEndPosition - $currentPosition ), // content
                                  false // debug
                                  );
                $elements[] = $element;
                $currentPosition = $quoteEndPosition + 1;
                $allowedType = EZ_TEMPLATE_TYPE_OPERATOR_BIT;
            }
            else
            {
                $float = true;
                $numericEndPosition = $this->numericEndPos( $tpl, $text, $currentPosition, $textLength, $float );
                if ( $numericEndPosition > $currentPosition )
                {
                    if ( !( $allowedType & EZ_TEMPLATE_TYPE_NUMERIC_BIT ) )
                    {
                        $currentPosition = $lastPosition;
                        break;
                    }
                    // We got a number
                    $number = substr( $text, $currentPosition, $numericEndPosition - $currentPosition );
                    if ( $float )
                        $number = (float)$number;
                    else
                        $number = (int)$number;
                    $element = array( EZ_TEMPLATE_TYPE_NUMERIC, // type
                                      $number, // content
                                      false // debug
                                      );
                    $elements[] = $element;
                    $currentPosition = $numericEndPosition;
                    $allowedType = EZ_TEMPLATE_TYPE_OPERATOR_BIT;
                }
                else
                {
                    $identifierEndPosition = $this->identifierEndPosition( $tpl, $text, $currentPosition, $textLength );
                    if ( $currentPosition == $identifierEndPosition )
                    {
                        $currentPosition = $lastPosition;
                        break;
                    }
                    if ( ( $identifierEndPosition < $textLength and
                           $text[$identifierEndPosition] == '(' ) or
                         $undefinedType == EZ_TEMPLATE_TYPE_OPERATOR )
                    {
                        if ( !( $allowedType & EZ_TEMPLATE_TYPE_OPERATOR_BIT ) )
                        {
                            $currentPosition = $lastPosition;
                            break;
                        }
                        $operatorName = substr( $text, $currentPosition, $identifierEndPosition - $currentPosition );
                        $operatorParameterElements = array( $operatorName );

                        if ( $identifierEndPosition < $textLength and
                             $text[$identifierEndPosition] == '(' )
                        {
                            $currentPosition = $identifierEndPosition + 1;
                            $currentOperatorPosition = $currentPosition;
                            $operatorDone = false;
                            $parameterCount = 0;
                            while ( !$operatorDone )
                            {
                                $operatorEndPosition = false;
                                $operatorParameterElement = $this->parseVariableTag( $tpl, $relatedTemplateName, $text, $currentOperatorPosition, $operatorEndPosition, $textLength, $defaultNamespace,
                                                                                     EZ_TEMPLATE_TYPE_BASIC, false, ',)' );
                                if ( $operatorEndPosition < $textLength and
                                     $text[$operatorEndPosition] == ',' )
                                {
                                    if ( $operatorEndPosition == $currentOperatorPosition )
                                    {
                                        $operatorParameterElements[] = null;
                                    }
                                    else
                                        $operatorParameterElements[] = $operatorParameterElement;
                                    ++$parameterCount;
                                    $currentOperatorPosition = $operatorEndPosition + 1;
                                }
                                else if ( $operatorEndPosition < $textLength and
                                          $text[$operatorEndPosition] == ')' )
                                {
                                    $operatorDone = true;
                                    if ( $operatorEndPosition == $currentOperatorPosition )
                                    {
                                        if ( $parameterCount > 0 )
                                        {
                                            $operatorParameterElements[] = null;
                                            ++$parameterCount;
                                        }
                                    }
                                    else
                                    {
                                        $operatorParameterElements[] = $operatorParameterElement;
                                        ++$parameterCount;
                                    }
                                    ++$operatorEndPosition;
                                }
                                else
                                {
                                    $currentPosition = $lastPosition;
                                    break;
                                }
                            }
                            if ( !$operatorDone )
                                break;
                        }
                        else
                        {
                            $operatorEndPosition = $identifierEndPosition;
                        }

                        $element = array( EZ_TEMPLATE_TYPE_OPERATOR, // type
                                          $operatorParameterElements, // content
                                          false // debug
                                          );
                        $elements[] = $element;
                        $currentPosition = $operatorEndPosition;
                        $allowedType = EZ_TEMPLATE_TYPE_MODIFIER_MASK;
                    }
                    else
                    {
                        if ( !( $allowedType & EZ_TEMPLATE_TYPE_IDENTIFIER_BIT ) )
                        {
                            $currentPosition = $lastPosition;
                            break;
                        }
                        $identifier = substr( $text, $currentPosition, $identifierEndPosition - $currentPosition );
                        $element = array( EZ_TEMPLATE_TYPE_IDENTIFIER, // type
                                          $identifier, // content
                                          false // debug
                                          );
                        $elements[] = $element;
                        $currentPosition = $identifierEndPosition;
                        $allowedType = EZ_TEMPLATE_TYPE_NONE;
                    }
                }
            }
        }
        $endPosition = $currentPosition;
        return $elements;
    }

    /*!
     Returns the end position of the variable.
    */
    function variableEndPos( &$tpl, $relatedTemplateName, &$text, $startPosition, $textLength,
                             &$namespace, &$name, &$scope )
    {
        $currentPosition = $startPosition;
        $namespaces = array();
        $variableName = false;
        $lastPosition = false;
        $scopeType = EZ_TEMPLATE_NAMESPACE_SCOPE_LOCAL;
        $scopeRead = false;
        while ( $currentPosition < $textLength )
        {
            if ( $lastPosition !== false and
                 $lastPosition == $currentPosition )
            {
                $tpl->error( "ElementParser::variableEndPos", "parser error @ $relatedTemplateName\[" . $currentPosition . "]\n" .
                             "Parser position did not move, this is most likely a bug in the template parser." );
                break;
            }
            $lastPosition = $currentPosition;
            if ( $text[$currentPosition] == '#' )
            {
                if ( $scopeRead )
                {
                    $tpl->error( "ElementParser::variableEndPos", "parser error @ $relatedTemplateName\[" . $currentPosition . "]\n" .
                                 "Namespace scope already declared, cannot set to global." );
                }
                else
                {
                    $scopeType = EZ_TEMPLATE_NAMESPACE_SCOPE_GLOBAL;
                }
                $scopeRead = true;
                ++$currentPosition;
            }
            else if ( $text[$currentPosition] == ':' )
            {
                if ( $scopeRead )
                {
                    $tpl->error( "ElementParser::variableEndPos", "parser error @ $relatedTemplateName\[" . $currentPosition . "]\n" .
                                 "Namespace scope already declared, cannot set to relative." );
                }
                else
                {
                    $scopeType = EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE;
                }
                $scopeRead = true;
                ++$currentPosition;
            }
            else
            {
                $identifierEndPosition = $this->identifierEndPosition( $tpl, $text, $currentPosition, $textLength );
                if ( $identifierEndPosition > $currentPosition )
                {
                    $identifier = substr( $text, $currentPosition, $identifierEndPosition - $currentPosition );
                    $currentPosition = $identifierEndPosition;
                    if ( $identifierEndPosition < $textLength and
                         $text[$identifierEndPosition] == ':' )
                    {
                        $namespaces[] = $identifier;
                        ++$currentPosition;
                    }
                    else
                        $variableName = $identifier;
                }
                else if ( $identifierEndPosition < $textLength and
                          ( $text[$identifierEndPosition] != ":" and
                            $text[$identifierEndPosition] != "#" ) )
                {
                    if ( $variableName === false )
                    {
                        $tpl->error( "ElementParser::variableEndPos", "parser error @ $relatedTemplateName\[" . $currentPosition . "]\n" .
                                     "No variable name found, this is most likely a bug in the template parser." );
                        return $startPosition;
                    }
                    break;
                }
                else
                {
                    $tpl->error( "ElementParser::variableEndPos", "parser error @ $relatedTemplateName\[" . $currentPosition . "]\n" .
                                 "Missing identifier for variable name or namespace, this is most likely a bug in the template parser." );
                    return $startPosition;
                }
            }
        }
        $scope = $scopeType;
        $namespace = implode( ':', $namespaces );
        $name = $variableName;
        return $currentPosition;
    }

    /*!
     Returns the end position of the identifier.
     If no identifier was found the end position is returned.
    */
    function identifierEndPosition( &$tpl, &$text, $start_pos, $len )
    {
        $pos = $start_pos;
        while ( $pos < $len )
        {
            if ( !preg_match( "/^[a-zA-Z0-9_-]$/", $text[$pos] ) )
            {
                return $pos;
            }
            ++$pos;
        }
        return $pos;
    }

    /*!
     Returns the end position of the quote $quote.
     If no quote was found the end position is returned.
    */
    function quoteEndPos( &$tpl, &$text, $startPosition, $textLength, $quote )
    {
        $currentPosition = $startPosition;
        while ( $currentPosition < $textLength )
        {
            if ( $text[$currentPosition] == "\\" )
                ++$currentPosition;
            else if ( $text[$currentPosition] == $quote )
                return $currentPosition;
            ++$currentPosition;
        }
        return $currentPosition;
    }

    /*!
     Returns the end position of the numeric.
     If no numeric was found the end position is returned.
    */
    function numericEndPos( &$tpl, &$text, $start_pos, $len,
                            &$float )
    {
        $pos = $start_pos;
        $has_comma = false;
        $numberPos = $pos;
        if ( $pos < $len )
        {
            if ( $text[$pos] == '-' )
            {
                ++$pos;
                $numberPos = $pos;
            }
        }
        while ( $pos < $len )
        {
            if ( $text[$pos] == "." and $float )
            {
                if ( $has_comma )
                {
                    if ( !$has_comma and
                         $float )
                        $float = false;
                    return $pos;
                }
                $has_comma = $pos;
            }
            else if ( $text[$pos] < '0' or $text[$pos] > '9' )
            {
                if ( !$has_comma and
                     $float )
                    $float = false;
                if ( $pos < $len and
                     $has_comma and
                     $pos == $has_comma + 1 )
                {
                    return $start_pos;
                }
                if ( $pos == $numberPos )
                {
                    return $start_pos;
                }
                return $pos;
            }
            ++$pos;
        }
        if ( !$has_comma and
             $float )
            $float = false;
        if ( $has_comma and
             $start_pos + 1 == $pos )
        {
            return $start_pos;
        }
        return $pos;
    }

    /*!
     Returns the position of the first non-whitespace characters.
    */
    function whitespaceEndPos( &$tpl, &$text, $currentPosition, $textLength )
    {
        if ( $currentPosition >= $textLength )
            return $currentPosition;
        while( $currentPosition < $textLength and
               preg_match( "/[ \t\r\n]/", $text[$currentPosition] ) )
        {
            ++$currentPosition;
        }
        return $currentPosition;
    }

    /*!
     Returns the position of the first non-whitespace characters.
    */
    function isWhitespace( &$tpl, &$text, $startPosition )
    {
        return preg_match( "/[ \t\r\n]/", $text[$startPosition] );
    }

    function &instance()
    {
        $instance =& $GLOBALS['eZTemplateElementParserInstance'];
        if ( get_class( $instance ) != 'eztemplateelementparser' )
        {
            $instance = new eZTemplateElementParser();
        }
        return $instance;
    }

}

?>
