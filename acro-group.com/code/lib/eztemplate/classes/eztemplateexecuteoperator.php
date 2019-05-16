<?php
//
// Definition of eZTemplateExecuteOperator class
//
// Created on: <06-Oct-2002 17:53:19 amos>
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

/*! \file eztemplateexecuteoperator.php
*/

/*!
  \class eZTemplateExecuteOperator eztemplateexecuteoperator.php
  \brief The class eZTemplateExecuteOperator does

*/

include_once( 'lib/eztemplate/classes/eztemplate.php' );

class eZTemplateExecuteOperator
{
    /*!
     Constructor
    */
    function eZTemplateExecuteOperator( $fetchName = 'fetch', $fetchAliasName = 'fetch_alias' )
    {
        $this->Operators = array( $fetchName, $fetchAliasName );
        $this->Fetch = $fetchName;
        $this->FetchAlias = $fetchAliasName;
    }

    /*!
     Returns the operators in this class.
    */
    function &operatorList()
    {
        return $this->Operators;
    }

    /*!
     \return true to tell the template engine that the parameter list exists per operator type.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    function operatorTemplateHints()
    {
        return array( $this->Fetch => array( 'input' => false,
                                             'output' => true,
                                             'parameters' => true,
                                             'element-transformation' => true,
                                             'transform-parameters' => true,
                                             'element-transformation-func' => 'fetchTransform' ),
                      $this->FetchAlias => array( 'input' => false,
                                                  'output' => true,
                                                  'parameters' => true,
                                                  'element-transformation' => true,
                                                  'transform-parameters' => true,
                                                  'element-transformation-func' => 'fetchTransform' )
                      );
    }

    function fetchTransform( $operatorName, &$node, &$tpl, &$resourceData,
                             &$element, &$lastElement, &$elementList, &$elementTree, &$parameters )
    {
        $parameterTranslation = false;
        $constParameters = array();

        if ( $operatorName == $this->Fetch )
        {
            if ( !eZTemplateNodeTool::isStaticElement( $parameters[0] ) ||
                 !eZTemplateNodeTool::isStaticElement( $parameters[1] ) )
            {
                return false;
            }

            $moduleName = eZTemplateNodeTool::elementStaticValue( $parameters[0] );
            $functionName = eZTemplateNodeTool::elementStaticValue( $parameters[1] );

            include_once( 'lib/ezutils/classes/ezfunctionhandler.php' );
            $moduleFunctionInfo =& eZFunctionHandler::moduleFunctionInfo( $moduleName );
            if ( !$moduleFunctionInfo->isValid() )
            {
                eZDebug::writeError( "Cannot execute  module '$moduleName', no module found",
                                     'eZFunctionHandler::execute' );
                return array();
            }
            $fetchParameters = array();
            if ( isset( $parameters[2] ) )
                $fetchParameters =  $parameters[2];
        }
        else if ( $operatorName == $this->FetchAlias )
        {
            if ( !eZTemplateNodeTool::isStaticElement( $parameters[0] ) )
            {
                return false;
            }

            $aliasFunctionName = eZTemplateNodeTool::elementStaticValue( $parameters[0] );

            $aliasSettings =& eZINI::instance( 'fetchalias.ini' );
            if ( $aliasSettings->hasSection( $aliasFunctionName ) )
            {
                include_once( 'lib/ezutils/classes/ezfunctionhandler.php' );
                $moduleFunctionInfo =& eZFunctionHandler::moduleFunctionInfo( $aliasSettings->variable( $aliasFunctionName, 'Module' ) );
                if ( !$moduleFunctionInfo->isValid() )
                {
                    eZDebug::writeError( "Cannot execute function '$aliasFunctionName' in module '$moduleName', no valid data",
                                         'eZFunctionHandler::executeAlias' );
                    return array();
                }

                $functionName =& $aliasSettings->variable( $aliasFunctionName, 'FunctionName' );

                $functionArray = array();
                if ( $aliasSettings->hasVariable( $aliasFunctionName, 'Parameter' ) )
                {
                    $parameterTranslation =& $aliasSettings->variable( $aliasFunctionName, 'Parameter' );
                }

                if ( $aliasSettings->hasVariable( $aliasFunctionName, 'Constant' ) )
                {
                    $constantParameterArray =& $aliasSettings->variable( $aliasFunctionName, 'Constant' );
                    if ( is_array( $constantParameterArray ) )
                    {
                        foreach ( array_keys( $constantParameterArray ) as $constKey )
                        {
                            if ( $moduleFunctionInfo->isParameterArray( $functionName, $constKey ) )
                                $constParameters[$constKey] = explode( ';', $constantParameterArray[$constKey] );
                            else
                                $constParameters[$constKey] = $constantParameterArray[$constKey];
                        }
                    }
                }
            }
            $fetchParameters = array();
            if ( isset( $parameters[1] ) )
                $fetchParameters = $parameters[1];
        }
        else
        {
            return false;
        }

        $functionDefinition =& $moduleFunctionInfo->preExecute( $functionName );
        if ( $functionDefinition === false )
        {
            return false;
        }

        $isDynamic = false;
        $isVariable = false;
        if ( eZTemplateNodeTool::isStaticElement( $fetchParameters ) )
        {
            $staticParameters = eZTemplateNodeTool::elementStaticValue( $fetchParameters );
            $functionKeys = array_keys( $staticParameters );
        }
        else if ( eZTemplateNodeTool::isDynamicArrayElement( $fetchParameters ) )
        {
            $isDynamic = true;
            $dynamicParameters = eZTemplateNodeTool::elementDynamicArray( $fetchParameters );
            $functionKeys = eZTemplateNodeTool::elementDynamicArrayKeys( $fetchParameters );
        }
        else if ( eZTemplateNodeTool::isVariableElement( $fetchParameters ) or 
                  eZTemplateNodeTool::isInternalCodePiece( $fetchParameters ) )
        {
            $isVariable = true;
        }
        else
        {
            $functionKeys = array();
        }

        $paramCount = 0;
        $values = array();
        $code = 'include_once( \'' . $functionDefinition['call_method']['include_file'] . '\' );' . "\n";
        if ( $isVariable )
        {
            $values[] = $fetchParameters;
            $parametersCode = '%1%';
        }
        else
        {
            $parametersCode = 'array( ';
            foreach( $functionDefinition['parameters'] as $parameterDefinition )
            {
                if ( $paramCount != 0 )
                {
                    $parametersCode .= ',' . "\n";
                }
                ++$paramCount;

                $parameterName = $parameterDefinition['name'];

                if ( $parameterTranslation )
                {
                    if ( in_array( $parameterName, array_keys( $parameterTranslation ) ) )
                    {
                        $parameterName = $parameterTranslation[$parameterName];
                    }
                }

                $parametersCode .= '    \'' . $parameterName . '\' => ';

                if ( in_array( $parameterName, $functionKeys ) )
                {
                    if ( $isDynamic )
                    {
                        if ( eZTemplateNodeTool::isStaticElement( $dynamicParameters[$parameterName] ) )
                        {
                            $parametersCode .= eZPHPCreator::variableText( eZTemplateNodeTool::elementStaticValue( $dynamicParameters[$parameterName] ), 0, 0, false );
                        }
                        else
                        {
                            $values[] = $dynamicParameters[$parameterName];
                            $parametersCode .= '%' . count( $values ) . '%';
                        }
                    }
                    else
                    {
                        $parametersCode .= eZPHPCreator::variableText( $staticParameters[$parameterName], 0, 0, false );
                    }
                }
                else if( $constParameters &&
                         isset( $constParameters[$parameterName] ) )
                {
                    $parametersCode .= eZPHPCreator::variableText( $constParameters[$parameterName], 0, 0, false );
                }
                else
                {
                    if ( $parameterDefinition['required'] )
                    {
                        return false;
                    }
                    else if ( isset( $parameterDefinition['default'] ) )
                    {
                        $parametersCode .= eZPHPCreator::variableText( $parameterDefinition['default'], 0, 0, false );
                    }
                    else
                    {
                        $parametersCode .= 'null';
                    }
                }
            }

            $parametersCode .= ' )';
        }

        $code .= '%output% = ';
        if ( $moduleFunctionInfo->UseOldCall )
        {
            $code .= 'call_user_method_array( ' . $functionDefinition['call_method']['method'] . ', new ' . $functionDefinition['call_method']['class'] . '(), ' . $parametersCode . ' );';
        }
        else
        {
            $code .= 'call_user_func_array( array( new ' . $functionDefinition['call_method']['class'] . '(), \'' . $functionDefinition['call_method']['method'] . '\' ),' . "\n" .
                 '  ' . $parametersCode . ' );';
        }
        $code .= "\n";

        $code .= '%output% = isset( %output%[\'result\'] ) ? %output%[\'result\'] : null;' . "\n";

        return array( eZTemplateNodeTool::createCodePieceElement( $code, $values ) );
    }

    /*!
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
        return array( 'fetch' => array( 'module_name' => array( 'type' => 'string',
                                                                'required' => true,
                                                                'default' => false ),
                                        'function_name' => array( 'type' => 'string',
                                                                  'required' => true,
                                                                  'default' => false ),
                                        'function_parameters' => array( 'type' => 'array',
                                                                        'required' => false,
                                                                        'default' => array() ) ),
                      'fetch_alias' => array( 'function_name' => array( 'type' => 'string',
                                                                  'required' => true,
                                                                  'default' => false ),
                                              'function_parameters' => array( 'type' => 'array',
                                                                              'required' => false,
                                                                              'default' => array() ) ) );
    }

    /*!
     Calls a specified module function and returns the result.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters,
                     &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        $functionName = $namedParameters['function_name'];
        $functionParameters = $namedParameters['function_parameters'];

        include_once( 'lib/ezutils/classes/ezfunctionhandler.php' );

        if ( $operatorName == $this->Fetch )
        {
            $moduleName = $namedParameters['module_name'];
            $result =& eZFunctionHandler::execute( $moduleName, $functionName, $functionParameters );
            $operatorValue = $result;
        }
        else if ( $operatorName == $this->FetchAlias )
        {
            $result =& eZFunctionHandler::executeAlias( $functionName, $functionParameters );
            $operatorValue = $result;
        }
    }

    /// \privatesection
    var $Operators;

    var $Fetch;
    var $FetchAlias;
}

?>
