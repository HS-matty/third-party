<?php
//
// Definition of eZTemplateToolbarFunction class
//
// Created on: <04-Mar-2004 13:22:32 wy>
//
// Copyright (C) 1999-2003 eZ systems as. All rights reserved.
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

/*! \file eztemplatetoolbarfunction.php
*/

/*!
  \class eZTemplateToolbarFunction eztemplatetoolbarfunction.php
  \brief The class eZTemplateToolarFunction does

*/

class eZTemplateToolbarFunction
{

    /*!
     Initializes the object with names.
    */
    function eZTemplateToolbarFunction( $blockName = 'tool_bar' )
    {
        $this->BlockName = $blockName;
    }

    /*!
     Returns an array containing the name of the block function, default is "block".
     The name is specified in the constructor.
    */
    function functionList()
    {
        return array( $this->BlockName );
    }

    function functionTemplateHints()
    {
        return array( $this->BlockName => array( 'parameters' => true,
                                                 'static' => false,
                                                 'transform-children' => false,
                                                 'tree-transformation' => true,
                                                 'transform-parameters' => true ) );
    }

    function templateNodeTransformation( $functionName, &$node,
                                         &$tpl, $parameters, $privateData )
    {
        if ( $functionName != $this->BlockName )
            return false;

        $parameters = eZTemplateNodeTool::extractFunctionNodeParameters( $node );

        if ( !isset( $parameters['name'] ) )
            return false;

        // Read ini file
        $toolbarIni =& eZINI::instance( "toolbar.ini" );

        if ( isset( $parameters["view"] ) )
        {
            $viewData = $parameters["view"];
            $viewMode = eZTemplateNodeTool::elementStaticValue( $viewData );
        }
        else
        {
            $viewMode = "full";
        }

        $params = $parameters;
        $namespaceValue = false;
        if ( isset( $parameters["name"] ) )
        {
            $nameData = $parameters["name"];
            if ( !eZTemplateNodeTool::isStaticElement( $nameData ) )
                return false;

            $nameValue = eZTemplateNodeTool::elementStaticValue( $nameData );

            $toolbarPosition = $nameValue;
            $toolbarName = "Toolbar_" . $toolbarPosition;
            $toolArray = $toolbarIni->variable( $toolbarName, 'Tool' );

            $newNodes = array();
            foreach ( array_keys( $toolArray ) as $toolKey )
            {
                $tool = $toolArray[$toolKey];
                $placement = $toolKey + 1;

                $uriString = "design:toolbar/$viewMode/$tool.tpl";

                if ( $placement == 1 )
                {
                    if ( $placement == count( $toolArray ) )
                    {
                        if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                        {
                            $newNodes[] = eZTemplateNodeTool::createTextNode( "<li class=\"toolbar-item last\">" );
                        }
                        else
                        {
                            $newNodes[] = eZTemplateNodeTool::createTextNode( "<div class=\"toolbar-item last\">" );
                        }

                    }
                    else
                    {
                        if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                        {
                            $newNodes[] = eZTemplateNodeTool::createTextNode( "<ul><li class=\"toolbar-item first\">" );
                        }
                        else
                        {
                            $newNodes[] = eZTemplateNodeTool::createTextNode( "<div class=\"toolbar-item first\">" );
                        }
                    }
                }
                else if ( $placement == count( $toolArray ) )
                {
                    if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                    {
                        $newNodes[] = eZTemplateNodeTool::createTextNode( "<li class=\"toolbar-item last\">" );
                    }
                    else
                    {
                        $newNodes[] = eZTemplateNodeTool::createTextNode( "<div class=\"toolbar-item last\">" );
                    }

                }
                else
                {
                    if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                    {
                        $newNodes[] = eZTemplateNodeTool::createTextNode( "<li class=\"toolbar-item\">" );
                    }
                    else
                    {
                        $newNodes[] = eZTemplateNodeTool::createTextNode( "<div class=\"toolbar-item\">" );
                    }
                }

                $resourceName = "";
                $templateName = "";
                $resource =& $tpl->resourceFor( $uriString, $resourceName, $templateName );
                $resourceData =& $tpl->resourceData( $resource, $uriString, $resourceName, $templateName );

                $includeNodes = $resource->templateNodeTransformation( $functionName, $node, $tpl, $resourceData, $parameters, $namespaceValue );
                if ( $includeNodes === false )
                    return false;

                $variableList = array();
                foreach ( array_keys( $parameters ) as $parameterName )
                {
                    if ( $parameterName == 'name' or
                         $parameterName == 'view' )
                        continue;
                    $parameterData =& $parameters[$parameterName];
                    $newNodes[] = eZTemplateNodeTool::createVariableNode( false, $parameterData, false, array(),
                                                                          array( $namespaceValue, EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE, $parameterName ) );
                    $variableList[] = $parameterName;
                }

                $actionParameters = array();
                if ( $toolbarIni->hasGroup( "Tool_" . $tool ) )
                {
                    $actionParameters = $toolbarIni->group( "Tool_" . $tool );
                }
                if ( $toolbarIni->hasGroup( "Tool_" . $toolbarPosition . "_" . $tool . "_" . $placement ) )
                {
                    $actionParameters = array_merge( $actionParameters, $toolbarIni->group( "Tool_" . $toolbarPosition . "_" . $tool . "_" . $placement ) );
                }
                foreach ( array_keys( $actionParameters ) as $key )
                {
                    $itemValue = $actionParameters[$key];
                    $newNodes[] = eZTemplateNodeTool::createVariableNode( false, $itemValue, false, array(),
                                                                          array( $namespaceValue, EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE, $key ) );
                    $variableList[] = $itemValue;
                }

                // Add parameter tool_id and offset
                $toolIDValue =  "Tool_" . $toolbarPosition . "_" . $tool . "_" . $placement;
                $newNodes[] = eZTemplateNodeTool::createVariableNode( false, $toolIDValue, false, array(),
                                                                      array( $namespaceValue, EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE, "tool_id" ) );
                $variableList[] = "tool_id";

                $toolOffset = $placement;
                $newNodes[] = eZTemplateNodeTool::createVariableNode( false, $toolOffset, false, array(),
                                                                      array( $namespaceValue, EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE, "offset" ) );
                $variableList[] = "offset";

                $newNodes = array_merge( $newNodes, $includeNodes );

                foreach ( $variableList as $variableName )
                {
                    $newNodes[] = eZTemplateNodeTool::createVariableUnsetNode( array( $namespaceValue, EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE, $variableName ) );
                }

                 if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                 {
                     $newNodes[] = eZTemplateNodeTool::createTextNode( "</li>" );
                     if ( $placement == count( $toolArray ) )
                     {
                         $newNodes[] = eZTemplateNodeTool::createTextNode( "</ul>" );
                     }
                 }
                 else
                 {
                     $newNodes[] = eZTemplateNodeTool::createTextNode( "</div>" );
                 }
            }
        }
        return $newNodes;
    }

    /*!
     Processes the function with all it's children.
    */
    function process( &$tpl, &$textElements, $functionName, $functionChildren, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace )
    {
        $params = $functionParameters;
        switch ( $functionName )
        {
            case $this->BlockName:
            {
                $viewMode = "full";
                $name ="";
                // Read ini file
                $toolbarIni =& eZINI::instance( "toolbar.ini" );

                if ( isset( $functionParameters["view"] ) )
                {
                    $viewMode = $tpl->elementValue( $functionParameters["view"], $rootNamespace, $currentNamespace, $functionPlacement );
                }

                if ( isset( $functionParameters["name"] ) )
                {
                    reset( $params );
                    while ( ( $key = key( $params ) ) !== null )
                    {
                        $item =& $params[$key];
                        switch ( $key )
                        {
                            case "name":
                            case "view":
                                break;

                            default:
                            {
                                $item_value = $tpl->elementValue( $item, $rootNamespace, $currentNamespace, $functionPlacement );
                                $tpl->setVariable( $key, $item_value, $name );
                            } break;
                        }
                        next( $params );
                    }
                    $toolbarPosition = $tpl->elementValue( $functionParameters["name"], $rootNamespace, $currentNamespace, $functionPlacement );
                    $definedVariables = array();
                    $toolbarName = "Toolbar_" . $toolbarPosition;
                    $toolArray = $toolbarIni->variable( $toolbarName, 'Tool' );
                    foreach ( array_keys( $toolArray ) as $toolKey )
                    {
                        $tool = $toolArray[$toolKey];
                        $placement = $toolKey + 1;
                        if ( $toolbarIni->hasGroup( "Tool_" . $tool ) )
                        {
                            $actionParameters = $toolbarIni->group( "Tool_" . $tool );
                        }
                        if ( $toolbarIni->hasGroup( "Tool_" . $toolbarPosition . "_" . $tool . "_" . $placement ) )
                        {
                            $actionParameters = array_merge( $actionParameters, $toolbarIni->group( "Tool_" . $toolbarPosition . "_" . $tool . "_" . $placement ) );
                        }
                        foreach ( array_keys( $actionParameters ) as $key )
                        {
                            $itemValue = $actionParameters[$key];
                            $tpl->setVariable( $key, $itemValue, $name );
                            $definedVariables[] = $key;
                        }
                        $toolIDValue =  "Tool_" . $toolbarPosition . "_" . $tool . "_" . $placement;
                        $tpl->setVariable( "tool_id", $toolIDValue, $name );
                        $definedVariables[] = "tool_id";
                        $toolOffset = $placement;
                        $tpl->setVariable( "offset", $toolOffset, $name );
                        $definedVariables[] = "offset";
                        $uri = "design:toolbar/$viewMode/$tool.tpl";

                        if ( $placement == 1 )
                        {
                            if ( count( $toolArray ) == 1 )
                            {
                                if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                                {
                                    $textElements[] = "<li class=\"toolbar-item last\">";
                                }
                                else
                                {
                                    $textElements[] = "<div class=\"toolbar-item first\">";
                                }
                            }
                            else
                            {
                                if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                                {
                                    $textElements[] = "<ul><li class=\"toolbar-item first\">";
                                }
                                else
                                {
                                    $textElements[] = "<div class=\"toolbar-item first\">";
                                }
                            }
                        }
                        else if ( $placement == count( $toolArray ) )
                        {
                            if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                            {
                                $textElements[] = "<li class=\"toolbar-item last\">";
                            }
                            else
                            {
                                $textElements[] = "<div class=\"toolbar-item first\">";
                            }
                        }
                        else
                        {
                            if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                            {
                                $textElements[] = "<li class=\"toolbar-item\">";
                            }
                            else
                            {
                                $textElements[] = "<div class=\"toolbar-item\">";
                            }
                        }
                        $tpl->processURI( $uri, true, $extraParameters, $textElements, $name, $name );
                        if ( $toolbarPosition == 'top' or $toolbarPosition == 'bottom' )
                        {
                            $textElements[] = "</li>";
                            if ( $placement == count( $toolArray ) )
                            {
                                $textElements[] = "</ul>";
                            }
                        }
                        else
                        {
                            $textElements[] = "</div>";
                        }
                        foreach ( $definedVariables as $variable )
                        {
                            $tpl->unsetVariable( $variable, $currentNamespace );
                        }
                    }
                }
            }
        }
    }

    /*!
     Returns false.
    */
    function hasChildren()
    {
        return false;
    }
}

?>
