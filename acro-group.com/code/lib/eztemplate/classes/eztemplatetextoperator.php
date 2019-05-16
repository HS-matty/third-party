<?php
//
// Definition of eZTemplateTextOperator class
//
// Created on: <01-Aug-2002 11:38:40 amos>
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

/*! \file eztemplatetextoperator.php
*/

/*!
  \class eZTemplateTextOperator eztemplatetextoperator.php
  \brief The class eZTemplateTextOperator does

*/

class eZTemplateTextOperator
{
    /*!
     Constructor
    */
    function eZTemplateTextOperator()
    {
        $this->Operators= array( 'concat', 'indent' );

        foreach ( $this->Operators as $operator )
        {
            $name = $operator . 'Name';
            $name[0] = $name[0] & "\xdf";
            $this->$name = $operator;
        }
    }

    /*!
     Returns the operators in this class.
    */
    function &operatorList()
    {
        return $this->Operators;
    }

    function operatorTemplateHints()
    {
        return array( $this->ConcatName => array( 'input' => true,
                                                  'output' => true,
                                                  'parameters' => true,
                                                  'element-transformation' => true,
                                                  'transform-parameters' => true,
                                                  'input-as-parameter' => true,
                                                  'element-transformation-func' => 'concatTransformation'),
                      $this->IndentName => array( 'input' => true,
                                                  'output' => true,
                                                  'parameters' => 3,
                                                  'element-transformation' => true,
                                                  'transform-parameters' => true,
                                                  'input-as-parameter' => true,
                                                  'element-transformation-func' => 'indentTransformation') ) ;
    }

    /*!
     \return true to tell the template engine that the parameter list exists per operator type.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( $this->IndentName => array( 'indent_count' => array( 'type' => 'integer',
                                                                           'required' => true,
                                                                           'default' => false ),
                                                  'indent_type' => array( 'type' => 'identifier',
                                                                          'required' => false,
                                                                          'default' => 'space' ),
                                                  'indent_filler' => array( 'type' => 'string',
                                                                            'required' => false,
                                                                            'default' => false ) ) );
    }

    function indentTransformation( $operatorName, &$node, &$tpl, &$resourceData,
                                   &$element, &$lastElement, &$elementList, &$elementTree, &$parameters )
    {
        $values = array();
        $count = $type = $filler = false;
        $paramCount = count( $parameters );

        if ( $paramCount == 4 )
        {
            if ( eZTemplateNodeTool::isStaticElement( $parameters[3] ) )
            {
                $filler = eZTemplateNodeTool::elementStaticValue( $parameters[3] );
            }
        }
        if ( $paramCount >= 3 )
        {
            if ( eZTemplateNodeTool::isStaticElement( $parameters[2] ) )
            {
                $type = eZTemplateNodeTool::elementStaticValue( $parameters[2] );
                if ( $type == 'space' )
                {
                    $filler = ' ';
                }
                else if ( $type == 'tab' )
                {
                    $filler = "\t";
                }
                else if ( $type != 'custom' )
                {
                    $filler = ' ';
                }
            }
        }
        if ( $paramCount >= 2 )
        {
            if ( eZTemplateNodeTool::isStaticElement( $parameters[1] ) )
            {
                $count = eZTemplateNodeTool::elementStaticValue( $parameters[1] );
            }
            if ( $paramCount < 3 )
            {
                $type = 'space';
                $filler = ' ';
            }
        }
        $newElements = array();

        if ( $count and $type and $filler )
        {
            $tmpCount = 0;
            $values[] = $parameters[0];
            $indentation = str_repeat( $filler, $count );
            $code = ( "%output% = '$indentation' . str_replace( '\n', '\n$indentation', %1% );\n" );
        }
        else if ( $filler and $type )
        {
            $tmpCount = 1;
            $values[] = $parameters[0];
            $values[] = $parameters[1];
            $code = ( "%tmp1% = str_repeat( '$filler', %2% );\n" .
                      "%output% = %tmp1% . str_replace( '\n', '\n' . %tmp1%, %1% );\n" );
        }
        else
        {
            $tmpCount = 2;
            $code = "if ( %3% == 'tab' )\n{\n\t%tmp1% = \"\\t\";\n}\nelse ";
            $code .= "if ( %3% == 'space' )\n{\n\t%tmp1% = ' ';\n}\nelse\n";
            if ( count ( $parameters ) == 4 )
            {
                $code .= "{\n\t%tmp1% = %4%;\n}\n";
            }
            else
            {
                $code.= "{\n\t%tmp1% = ' ';\n}\n";
            }
            $code .= ( "%tmp2% = str_repeat( %tmp1%, %2% );\n" .
                       "%output% = %tmp2% . str_replace( '\n', '\n' . %tmp2%, %1% );\n" );
            foreach ( $parameters as $parameter )
            {
                $values[] = $parameter;
            }
        }

        $newElements[] = eZTemplateNodeTool::createCodePieceElement( $code, $values, 'false', $tmpCount );
        return $newElements;
    }

    function concatTransformation( $operatorName, &$node, &$tpl, &$resourceData,
                                   &$element, &$lastElement, &$elementList, &$elementTree, &$parameters )
    {
        $values = array();
        $function = $operatorName;

        if ( ( count( $parameters ) < 1 ) )
        {
            return false;
        }
        if ( ( count( $parameters ) == 1 ) and
             eZTemplateNodeTool::isStaticElement( $parameters[0] ) )
        {
            return array( eZTemplateNodeTool::createStaticElement( eZTemplateNodeTool::elementStaticValue( $parameters[0] ) ) );
        }
        $newElements = array();

        $counter = 1;
        $code = "%output% = ( ";
        foreach ( $parameters as $parameter )
        {
            $values[] = $parameter;
            if ( $counter > 1 )
            {
                $code .= ' . ';
            }
            $code .= "%$counter%";
            $counter++;
        }
        $code .= " );\n";

        $newElements[] = eZTemplateNodeTool::createCodePieceElement( $code, $values );
        return $newElements;
    }

    /*!
     Handles concat and indent operators.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case $this->ConcatName:
            {
                $operands = array();
                if ( $operatorValue !== null )
                    $operands[] = $operatorValue;
                for ( $i = 0; $i < count( $operatorParameters ); ++$i )
                {
                    $operand = $tpl->elementValue( $operatorParameters[$i], $rootNamespace, $currentNamespace );
                    if ( !is_object( $operand ) )
                        $operands[] = $operand;
                }
                $operatorValue = implode( '', $operands );
            } break;
            case $this->IndentName:
            {
                $indentCount = $namedParameters['indent_count'];
                $indentType = $namedParameters['indent_type'];
                $filler = false;
                switch ( $indentType )
                {
                    case 'space':
                    default:
                    {
                        $filler = ' ';
                    } break;
                    case 'tab':
                    {
                        $filler = "\t";
                    } break;
                    case 'custom':
                    {
                        $filler = $namedParameters['indent_filler'];
                    } break;
                }
                $fillText = str_repeat( $filler, $indentCount );
                $operatorValue = $fillText . str_replace( "\n", "\n" . $fillText, $operatorValue );
            } break;
        }
    }

    /// \privatesection
    var $ConcatName;
    var $Operators;
}

?>
