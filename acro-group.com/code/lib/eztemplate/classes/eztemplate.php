<?php
//
// Definition of eZTemplate class
//
// Created on: <01-Mar-2002 13:49:57 amos>
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

/*! \file eztemplate.php
 Template system manager.
*/

/*! \defgroup eZTemplate Template system */

/*!
  \class eZTemplate eztemplate.php
  \ingroup eZTemplate
  \brief The main manager for templates

  The template systems allows for separation of code and
  layout by moving the layout part into template files. These
  template files are parsed and processed with template variables set
  by the PHP code.

  The template system in itself is does not do much, it parses template files
  according to a rule set sets up a tree hierarchy and process the data
  using functions and operators. The standard template system comes with only
  a few functions and no operators, it is meant for these functions and operators
  to be specified by the users of the template system. But for simplicity a few
  help classes is available which can be easily enabled.

  The classes are:
  - eZTemplateDelimitFunction - Inserts the left and right delimiter which are normally parsed.
  - eZTemplateSectionFunction - Allows for conditional blocks and loops.
  - eZTemplateIncludeFunction - Includes external templates
  - eZTemplateSequenceFunction - Creates sequences arrays
  - eZTemplateSwitchFunction - Conditional output of template

  - eZTemplatePHPOperator - Allows for easy redirection of operator names to PHP functions.
  - eZTemplateLocaleOperator - Allows for locale conversions.
  - eZTemplateArrayOperator - Creates arrays
  - eZTemplateAttributeOperator - Displays contents of template variables, useful for debugging
  - eZTemplateImageOperator - Converts text to image
  - eZTemplateLogicOperator - Various logical operators for boolean handling
  - eZTemplateUnitOperator - Unit conversion and display

  To enable these functions and operator use registerFunction and registerOperator.

  In keeping with the spirit of being simple the template system does not know how
  to get the template files itself. Instead it relies on resource handlers, these
  handlers fetches the template files using different kind of transport mechanism.
  For simplicity a default resource class is available, eZTemplateFileResource fetches
  templates from the filesystem.

  The parser process consists of three passes, each pass adds a new level of complexity.
  The first pass strips text from template blocks which starts with a left delimiter and
  ends with a right delimiter (default is { and } ), and places them in an array.
  The second pass iterates the text and block elements and removes newlines from
  text before function blocks and text after function blocks.
  The third pass builds the tree according the function rules.

  Processing is done by iterating over the root of the tree, if a text block is found
  the text is appended to the result text. If a variable or contant is it's data is extracted
  and any operators found are run on it before fetching the result and appending it to
  the result text. If a function is found the function is called with the parameters
  and it's up to the function handle children if any.

  Constants and template variables will usually be called variables since there's little
  difference. A template variable expression will start with a $ and consists of a
  namespace (optional) a name and attribues(optional). The variable expression
  \verbatim $root:var.attr1 \endverbatim exists in the "root" namespace, has the name "var" and uses the
  attribute "attr1". Some functions will create variables on demand, to avoid name conflicts
  namespaces were introduced, each function will place the new variables in a namespace
  specified in the template file. Attribues are used for fetching parts of the variable,
  for instance an element in an array or data in an object. Since the syntax is the
  same for arrays and objects the PHP code can use simple arrays when speed is required,
  the template code will not care.
  A different syntax is also available when you want to access an attribute using a variable.
  For instance \verbatim $root:var[$attr_var] \endverbatim, if the variable $attr_var contains "attr1" it would
  access the same attribute as in the first example.

  The syntax for operators is a | and a name, optionally parameters can be specified with
  ( and ) delimited with ,. Valid operators are \verbatim |upcase, |l10n(date) \endverbatim.

  Functions look a lot like HTML/XML tags. The function consists of a name and parameters
  which are assigned using the param=value syntax. Some parameters may be required while
  others may be optionally, the exact behaviour is specified by each function.
  Valid functions are \verbatim "section name=abc loop=4" \endverbatim

  Example of usage:
\code
// Init template
$tpl =& eZTemplate::instance();

$tpl->registerOperators( new eZTemplatePHPOperator( array( "upcase" => "strtoupper",
                                                           "reverse" => "strrev" ) ) );
$tpl->registerOperators( new eZTemplateLocaleOperator() );
$tpl->registerFunction( "section", new eZTemplateSectionFunction( "section" ) );
$tpl->registerFunctions( new eZTemplateDelimitFunction() );

$tpl->setVariable( "my_var", "{this value set by variable}", "test" );
$tpl->setVariable( "my_arr", array( "1st", "2nd", "third", "fjerde" ) );
$tpl->setVariable( "multidim", array( array( "a", "b" ),
                                      array( "c", "d" ),
                                      array( "e", "f" ),
                                      array( "g", "h" ) ) );

class mytest
{
    function mytest( $n, $s )
    {
        $this->n = $n;
        $this->s = $s;
    }

    function hasAttribute( $attr )
    {
        return ( $attr == "name" || $attr == "size" );
    }

    function &attribute( $attr )
    {
        switch ( $attr )
        {
            case "name";
            return $this->n;
            case "size";
            return $this->s;
            default:
                return null;
        }
    }

};

$tpl->setVariable( "multidim_obj", array( new mytest( "jan", 200 ),
                                          new mytest( "feb", 200 ),
                                          new mytest( "john", 200 ),
                                          new mytest( "doe", 50 ) ) );
$tpl->setVariable( "curdate", mktime() );

$tpl->display( "lib/eztemplate/example/test.tpl" );

// test.tpl

{section name=outer loop=4}
123
{delimit}::{/delimit}
{/section}

{literal test=1} This is some {blah arg1="" arg2="abc" /} {/literal}

<title>This is a test</title>
<table border="1">
<tr><th>{$test:my_var}
{"some text!!!"|upcase|reverse}</th></tr>
{section name=abc loop=$my_arr}
<tr><td>{$abc:item}</td></tr>
{/section}
</table>

<table border="1">
{section name=outer loop=$multidim}
<tr>
{section name=inner loop=$outer:item}
<td>{$inner:item}</td>
{/section}
</tr>
{/section}
</table>

<table border="1">
{section name=outer loop=$multidim_obj}
<tr>
<td>{$outer:item.name}</td>
<td>{$outer:item.size}</td>
</tr>
{/section}
</table>

{section name=outer loop=$nonexistingvar}
<b><i>Dette skal ikke vises</b></i>
{section-else}
<b><i>This is shown when the {ldelim}$loop{rdelim} variable is non-existant</b></i>
{/section}


Denne koster {1.4|l10n(currency)}<br>
{-123456789|l10n(number)}<br>
{$curdate|l10n(date)}<br>
{$curdate|l10n(shortdate)}<br>
{$curdate|l10n(time)}<br>
{$curdate|l10n(shorttime)}<br>
{include file="test2.tpl"/}

\endcode
*/

include_once( "lib/ezutils/classes/ezdebug.php" );

include_once( "lib/eztemplate/classes/eztemplatefileresource.php" );

include_once( "lib/eztemplate/classes/eztemplateroot.php" );
include_once( "lib/eztemplate/classes/eztemplatetextelement.php" );
include_once( "lib/eztemplate/classes/eztemplatevariableelement.php" );
include_once( "lib/eztemplate/classes/eztemplateoperatorelement.php" );
include_once( "lib/eztemplate/classes/eztemplatefunctionelement.php" );

define( "EZ_RESOURCE_FETCH", 1 );
define( "EZ_RESOURCE_QUERY", 2 );

define( "EZ_ELEMENT_TEXT", 1 );
define( "EZ_ELEMENT_SINGLE_TAG", 2 );
define( "EZ_ELEMENT_NORMAL_TAG", 3 );
define( "EZ_ELEMENT_END_TAG", 4 );
define( "EZ_ELEMENT_VARIABLE", 5 );
define( "EZ_ELEMENT_COMMENT", 6 );

define( "EZ_TEMPLATE_NODE_ROOT", 1 );
define( "EZ_TEMPLATE_NODE_TEXT", 2 );
define( "EZ_TEMPLATE_NODE_VARIABLE", 3 );
define( "EZ_TEMPLATE_NODE_FUNCTION", 4 );
define( "EZ_TEMPLATE_NODE_OPERATOR", 5 );


define( "EZ_TEMPLATE_NODE_INTERNAL", 100 );
define( "EZ_TEMPLATE_NODE_INTERNAL_CODE_PIECE", 101 );

define( "EZ_TEMPLATE_NODE_INTERNAL_VARIABLE_SET", 105 );
define( "EZ_TEMPLATE_NODE_INTERNAL_VARIABLE_UNSET", 102 );

define( "EZ_TEMPLATE_NODE_INTERNAL_NAMESPACE_CHANGE", 103 );
define( "EZ_TEMPLATE_NODE_INTERNAL_NAMESPACE_RESTORE", 104 );

define( "EZ_TEMPLATE_NODE_INTERNAL_WARNING", 120 );
define( "EZ_TEMPLATE_NODE_INTERNAL_ERROR", 121 );

define( "EZ_TEMPLATE_NODE_INTERNAL_RESOURCE_ACQUISITION", 140 );

define( "EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_ASSIGN", 150 );
define( "EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_READ", 151 );
define( "EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_INCREASE", 152 );
define( "EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_DECREASE", 153 );

define( "EZ_TEMPLATE_NODE_INTERNAL_SPACING_INCREASE", 160 );
define( "EZ_TEMPLATE_NODE_INTERNAL_SPACING_DECREASE", 161 );

define( "EZ_TEMPLATE_NODE_USER_CUSTOM", 1000 );


define( "EZ_TEMPLATE_TYPE_VOID", 0 );
define( "EZ_TEMPLATE_TYPE_STRING", 1 );
define( "EZ_TEMPLATE_TYPE_NUMERIC", 2 );
define( "EZ_TEMPLATE_TYPE_IDENTIFIER", 3 );
define( "EZ_TEMPLATE_TYPE_BOOLEAN", 7 );
define( "EZ_TEMPLATE_TYPE_ARRAY", 8 );
define( "EZ_TEMPLATE_TYPE_DYNAMIC_ARRAY", 9 );
define( "EZ_TEMPLATE_TYPE_VARIABLE", 4 );
define( "EZ_TEMPLATE_TYPE_ATTRIBUTE", 5 );
define( "EZ_TEMPLATE_TYPE_OPERATOR", 6 );

define( "EZ_TEMPLATE_TYPE_INTERNAL", 100 );
define( "EZ_TEMPLATE_TYPE_INTERNAL_CODE_PIECE", 101 );
define( "EZ_TEMPLATE_TYPE_INTERNAL_STOP", 999 );
define( "EZ_TEMPLATE_TYPE_PHP_VARIABLE", 102 );


define( "EZ_TEMPLATE_TYPE_STRING_BIT", (1 << (EZ_TEMPLATE_TYPE_STRING - 1)) );
define( "EZ_TEMPLATE_TYPE_NUMERIC_BIT", (1 << (EZ_TEMPLATE_TYPE_NUMERIC - 1)) );
define( "EZ_TEMPLATE_TYPE_IDENTIFIER_BIT", (1 << (EZ_TEMPLATE_TYPE_IDENTIFIER - 1)) );
define( "EZ_TEMPLATE_TYPE_VARIABLE_BIT", (1 << (EZ_TEMPLATE_TYPE_VARIABLE - 1)) );
define( "EZ_TEMPLATE_TYPE_ATTRIBUTE_BIT", (1 << (EZ_TEMPLATE_TYPE_ATTRIBUTE - 1)) );
define( "EZ_TEMPLATE_TYPE_OPERATOR_BIT", (1 << (EZ_TEMPLATE_TYPE_OPERATOR - 1)) );

define( "EZ_TEMPLATE_TYPE_NONE", 0 );

define( "EZ_TEMPLATE_TYPE_ALL", (EZ_TEMPLATE_TYPE_STRING_BIT |
                                 EZ_TEMPLATE_TYPE_NUMERIC_BIT |
                                 EZ_TEMPLATE_TYPE_IDENTIFIER_BIT |
                                 EZ_TEMPLATE_TYPE_VARIABLE_BIT |
                                 EZ_TEMPLATE_TYPE_ATTRIBUTE_BIT |
                                 EZ_TEMPLATE_TYPE_OPERATOR_BIT ) );

define( "EZ_TEMPLATE_TYPE_BASIC", (EZ_TEMPLATE_TYPE_STRING_BIT |
                                   EZ_TEMPLATE_TYPE_NUMERIC_BIT |
                                   EZ_TEMPLATE_TYPE_IDENTIFIER_BIT |
                                   EZ_TEMPLATE_TYPE_VARIABLE_BIT |
                                   EZ_TEMPLATE_TYPE_OPERATOR_BIT ) );

define( "EZ_TEMPLATE_TYPE_MODIFIER_MASK", (EZ_TEMPLATE_TYPE_ATTRIBUTE_BIT |
                                           EZ_TEMPLATE_TYPE_OPERATOR_BIT) );

define( "EZ_TEMPLATE_NAMESPACE_SCOPE_GLOBAL", 1 );
define( "EZ_TEMPLATE_NAMESPACE_SCOPE_LOCAL", 2 );
define( "EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE", 3 );

define( "EZ_TEMPLATE_DEBUG_INTERNALS", false );

define( 'EZ_ERROR_TEMPLATE_FILE_ERRORS', 1 );

class eZTemplate
{
    /*!
     Intializes the template with left and right delimiters being { and },
     and a file resource. The literal tag "literal" is also registered.
    */
    function eZTemplate()
    {
        $this->Tree = array( EZ_TEMPLATE_NODE_ROOT, false );
        $this->LDelim = "{";
        $this->RDelim = "}";

        $this->IncludeText = array();
        $this->IncludeOutput = array();

        $this->registerLiteral( "literal" );

        $res = new eZTemplateFileResource();
        $this->DefaultResource =& $res;
        $this->registerResource( $res );

        $this->Resources = array();
        $this->Text = null;

        $this->IsCachingAllowed = true;

        $this->AutoloadPathList = array( 'lib/eztemplate/classes/' );
        $this->Variables = array();
        $this->Functions = array();
        $this->FunctionAttributes = array();
        eZDebug::createAccumulatorGroup( 'template_total', 'Template Total' );
    }

    /*!
     Returns the left delimiter being used.
    */
    function &leftDelimiter()
    {
        return $this->LDelim;
    }

    /*!
     Returns the right delimiter being used.
    */
    function &rightDelimiter()
    {
        return $this->RDelim;
    }

    /*!
     Sets the left delimiter.
    */
    function setLeftDelimiter( $delim )
    {
        $this->LDelim = $delim;
    }

    /*!
     Sets the right delimiter.
    */
    function setRightDelimiter( $delim )
    {
        $this->RDelim = $delim;
    }

    /*!
     Fetches the result of the template file and displays it.
     If $template is supplied it will load this template file first.
    */
    function display( $template = false, $extraParameters = false )
    {
        $output =& $this->fetch( $template, $extraParameters );
        if ( $this->ShowDetails )
        {
            echo '<h1>Result:</h1>' . "\n";
            echo '<hr/>' . "\n";
        }
        echo "$output";
        if ( $this->ShowDetails )
        {
            echo '<hr/>' . "\n";
        }
        if ( $this->ShowDetails )
        {
            echo "<h1>Template data:</h1>";
            echo "<p class=\"filename\">" . $template . "</p>";
            echo "<pre class=\"example\">" . htmlspecialchars( $this->Text ) . "</pre>";
            reset( $this->IncludeText );
            while ( ( $key = key( $this->IncludeText ) ) !== null )
            {
                $item =& $this->IncludeText[$key];
                echo "<p class=\"filename\">" . $key . "</p>";
                echo "<pre class=\"example\">" . htmlspecialchars( $item ) . "</pre>";
                next( $this->IncludeText );
            }
            echo "<h1>Result text:</h1>";
            echo "<p class=\"filename\">" . $template . "</p>";
            echo "<pre class=\"example\">" . htmlspecialchars( $output ) . "</pre>";
            reset( $this->IncludeOutput );
            while ( ( $key = key( $this->IncludeOutput ) ) !== null )
            {
                $item =& $this->IncludeOutput[$key];
                echo "<p class=\"filename\">" . $key . "</p>";
                echo "<pre class=\"example\">" . htmlspecialchars( $item ) . "</pre>";
                next( $this->IncludeOutput );
            }
        }
    }

    /*!
     Tries to fetch the result of the template file and returns it.
     If $template is supplied it will load this template file first.
    */
    function &fetch( $template = false, $extraParameters = false )
    {
        eZDebug::accumulatorStart( 'template_total' );
        eZDebug::accumulatorStart( 'template_load', 'template_total', 'Template load' );
        $root = null;
        if ( is_string( $template ) )
        {
            $resourceData =& $this->loadURIRoot( $template, true, $extraParameters );
            if ( $resourceData and
                 $resourceData['root-node'] !== null )
                $root =& $resourceData['root-node'];
        }
        eZDebug::accumulatorStop( 'template_load' );
        if ( $resourceData['locales'] && count( $resourceData['locales'] ) )
        {
            $savedLocale = setlocale( LC_CTYPE, null );
            setlocale( LC_CTYPE, $resourceData['locales'] );
        }

        $text = "";

        if ( $root !== null or
             $resourceData['compiled-template'] )
        {
            if ( $this->ShowDetails )
                eZDebug::addTimingPoint( "Process" );
            eZDebug::accumulatorStart( 'template_processing', 'template_total', 'Template processing' );

            $templateCompilationUsed = false;
            if ( $resourceData['compiled-template'] )
            {
                $textElements = array();
                if ( $this->executeCompiledTemplate( $resourceData, $textElements, "", "", $extraParameters ) )
                {
                    $text = implode( '', $textElements );
                    $templateCompilationUsed = true;
                }
            }
            if ( !$templateCompilationUsed )
            {
                $this->process( $root, $text, "", "" );
            }

            eZDebug::accumulatorStop( 'template_processing' );
            if ( $this->ShowDetails )
                eZDebug::addTimingPoint( "Process done" );
        }

        eZDebug::accumulatorStop( 'template_total' );

        if ( $resourceData['locales'] && count( $resourceData['locales'] ) )
        {
            setlocale( LC_CTYPE, $savedLocale );
        }
        return $text;
    }

    function process( &$root, &$text, $rootNamespace, $currentNamespace )
    {
        $textElements = array();
        $this->processNode( $root, $textElements, $rootNamespace, $currentNamespace );
        if ( is_array( $textElements ) )
            $text = implode( '', $textElements );
        else
            $text = $textElements;
    }

    function processNode( &$node, &$textElements, $rootNamespace, $currentNamespace )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            $children = $node[1];
            if ( $children )
            {
                foreach ( $children as $child )
                {
                    $this->processNode( $child, $textElements, $rootNamespace, $currentNamespace );
                    if ( !is_array( $textElements ) )
                        eZDebug::writeError( "Textelements is no longer array: '$textElements'",
                                             'eztemplate::processNode::root' );
                }
            }
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_TEXT )
        {
            $textElements[] = $node[2];
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
        {
            $variableData = $node[2];
            $variablePlacement = $node[3];
            $this->processVariable( $textElements, $variableData, $variablePlacement, $rootNamespace, $currentNamespace );
            if ( !is_array( $textElements ) )
                eZDebug::writeError( "Textelements is no longer array: '$textElements'",
                                     'eztemplate::processNode::variable' );
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_FUNCTION )
        {
            $functionChildren = $node[1];
            $functionName = $node[2];
            $functionParameters = $node[3];
            $functionPlacement = $node[4];
            $this->processFunction( $functionName, $textElements, $functionChildren, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace );
            if ( !is_array( $textElements ) )
                eZDebug::writeError( "Textelements is no longer array: '$textElements'",
                                     "eztemplate::processNode::function( '$functionName' )" );
        }
    }

    function processVariable( &$textElements, $variableData, $variablePlacement, $rootNamespace, $currentNamespace )
    {
        $value = $this->elementValue( $variableData, $rootNamespace, $currentNamespace, $variablePlacement );
        $this->appendElementText( $textElements, $value, $rootNamespace, $currentNamespace );
    }

    function processFunction( $functionName, &$textElements, $functionChildren, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace )
    {
        // Note: This code piece is replicated in the eZTemplateCompiler,
        //       if this code is changed the replicated code must be updated as well.
        $func =& $this->Functions[$functionName];
        if ( is_array( $func ) )
        {
            $this->loadAndRegisterFunctions( $this->Functions[$functionName] );
            $func =& $this->Functions[$functionName];
        }
        if ( isset( $func ) and
             is_object( $func ) )
        {
            $value =& $func->process( $this, $textElements, $functionName, $functionChildren, $functionParameters, $functionPlacement, $rootNamespace, $currentNamespace );
            return $value;
        }
        else
        {
            $this->warning( "", "Function \"$functionName\" is not registered" );
        }
    }

    function fetchFunctionObject( $functionName )
    {
        $func =& $this->Functions[$functionName];
        if ( is_array( $func ) )
        {
            $this->loadAndRegisterFunctions( $this->Functions[$functionName] );
            $func =& $this->Functions[$functionName];
        }
        return $func;
    }

    /*!
     Loads the template using the URI $uri and parses it.
    */
    function &load( $uri, $extraParameters = false )
    {
        $resourceData =& $this->loadURIRoot( $uri, true, $extraParameters );
        if ( !$resourceData or
             $resourceData['root-node'] === null )
            return null;
        return $resourceData['root-node'];
    }

    function parse( &$sourceText, &$rootElement, $rootNamespace, $relation )
    {
        include_once( 'lib/eztemplate/classes/eztemplatemultipassparser.php' );
        $parser =& eZTemplateMultiPassParser::instance();
        $parser->parse( $this, $sourceText, $rootElement, $rootNamespace, $relation );
    }

    function &loadURIData( &$resourceObject, $uri, $resourceName, $template, &$extraParameters, $displayErrors = true )
    {
        $resourceData = $this->resourceData( $resourceObject, $uri, $resourceName, $template );

        $resourceData['text'] = null;
        $resourceData['root-node'] = null;
        $resourceData['compiled-template'] = false;
        $resourceData['time-stamp'] = null;
        $resourceData['key-data'] = null;
        $resourceData['locales'] = null;

        if ( !$resourceObject->handleResource( $this, $resourceData, EZ_RESOURCE_FETCH, $extraParameters ) )
        {
            $resourceData = null;
            if ( $displayErrors )
                $this->warning( "", "No template could be loaded for \"$template\" using resource \"$resourceName\"" );
        }
        return $resourceData;
    }

    /*!
     \static
     Creates a resource data structure of the parameters and returns it.
     This structure is passed to various parts of the template system.

     \note If you only have the URI you should call resourceFor() first to
           figure out the resource handler.
    */
    function resourceData( &$resourceObject, $uri, $resourceName, $templateName )
    {
        $resourceData = array();
        $resourceData['uri'] = $uri;
        $resourceData['resource'] = $resourceName;
        $resourceData['template-name'] = $templateName;
        $resourceData['template-filename'] = $templateName;
        $resourceData['handler'] =& $resourceObject;
        return $resourceData;
    }

    /*!
     Loads the template using the URI $uri and returns a structure with the text and timestamp,
     false otherwise.
     The structure keys are:
     - "text", the text.
     - "time-stamp", the timestamp.
    */
    function &loadURIRoot( $uri, $displayErrors = true, &$extraParameters )
    {
        $res = "";
        $template = "";
        $resobj =& $this->resourceFor( $uri, $res, $template );
        if ( !is_object( $resobj ) )
        {
            if ( $displayErrors )
                $this->warning( "", "No resource handler for \"$res\" and no default resource handler, aborting." );
            return null;
        }
        $canCache = true;
        if ( !$resobj->servesStaticData() )
            $canCache = false;
        if ( !$this->isCachingAllowed() )
            $canCache = false;

        $resourceData = null;
        $root = null;

        $resourceData =& $this->loadURIData( $resobj, $uri, $res, $template, $extraParameters, $displayErrors );

        if ( !$resourceData )
            return null;
        if ( !$resourceData['compiled-template'] and
             $resourceData['root-node'] === null )
        {
            $root =& $resourceData['root-node'];
            $root = array( EZ_TEMPLATE_NODE_ROOT, false );
            $templateText =& $resourceData["text"];
            $keyData = $resourceData['key-data'];
            $this->setIncludeText( $uri, $templateText );
            $rootNamespace = '';
            $this->parse( $templateText, $root, $rootNamespace, $resourceData );
            if ( $canCache )
                $resobj->setCachedTemplateTree( $keyData, $uri, $res, $template, $extraParameters, $root );
        }
        if ( !$resourceData['compiled-template'] and
             $canCache and
             $this->canCompileTemplate( $resourceData, $extraParameters ) )
        {
            $generateStatus = $this->compileTemplate( $resourceData, $extraParameters );
            if ( $generateStatus )
                $resourceData['compiled-template'] = true;
        }
        return $resourceData;
    }

    function processURI( $uri, $displayErrors = true, &$extraParameters,
                         &$textElements, $rootNamespace, $currentNamespace )
    {
        $resourceData =& $this->loadURIRoot( $uri, $displayErrors, $extraParameters );
        if ( !$resourceData or
             ( !$resourceData['compiled-template'] and
               $resourceData['root-node'] === null ) )
            return;
        $templateCompilationUsed = false;

        if ( $resourceData['locales'] && count( $resourceData['locales'] ) )
        {
            $savedLocale = setlocale( LC_CTYPE, null );
            setlocale( LC_CTYPE, $resourceData['locales'] );
        }

        if ( $resourceData['compiled-template'] )
        {
            if ( $this->executeCompiledTemplate( $resourceData, $textElements, $rootNamespace, $currentNamespace, $extraParameters ) )
                $templateCompilationUsed = true;
        }
        if ( !$templateCompilationUsed )
        {
            $root =& $resourceData['root-node'];
            $text = null;
            $this->process( $root, $text, $rootNamespace, $currentNamespace );
            $this->setIncludeOutput( $uri, $text );
            $textElements[] = $text;
        }

        if ( $resourceData['locales'] && count( $resourceData['locales'] ) )
        {
            setlocale( LC_CTYPE, $savedLocale );
        }
    }

    function canCompileTemplate( &$resourceData, &$extraParameters )
    {
        $resourceObject =& $resourceData['handler'];
        if ( !$resourceObject )
            return false;
        $canGenerate = $resourceObject->canCompileTemplate( $this, $resourceData, $extraParameters );
        return $canGenerate;
    }

    function compileTemplateFile( $file )
    {
        if ( !file_exists( $file ) )
            return false;
        $resourceHandler =& $this->resourceFor( $file, $resourceName, $templateName );
        if ( !$resourceHandler )
            return false;
        $resourceData =& $this->resourceData( $resourceHandler, $file, $resourceName, $templateName );
        $keyData =& $resourceData['key-data'];
        $keyData = "file:" . $file;
        $key = md5( $keyData );
        $extraParameters = array();
        $resourceHandler->handleResource( $this, $resourceData, EZ_RESOURCE_FETCH, $extraParameters );

        $isCompiled = false;
        if ( isset( $resourceData['compiled-template'] ) )
            $isCompiled = $resourceData['compiled-template'];

        if ( !$isCompiled )
        {
            $root =& $resourceData['root-node'];
            $root = array( EZ_TEMPLATE_NODE_ROOT, false );
            $templateText =& $resourceData["text"];
            $rootNamespace = '';
            $this->parse( $templateText, $root, $rootNamespace, $resourceData );

            return eZTemplateCompiler::compileTemplate( $this, $key, $resourceData );
        }
        else
        {
            return true;
        }
    }

    function compileTemplate( &$resourceData, &$extraParameters )
    {
        $resourceObject =& $resourceData['handler'];
        if ( !$resourceObject )
            return false;
        $keyData = $resourceData['key-data'];
        $uri = $resourceData['uri'];
        $resourceName = $resourceData['resource'];
        $templatePath = $resourceData['template-name'];
        return $resourceObject->compileTemplate( $this, $keyData, $uri, $resourceName, $templatePath, $extraParameters, $resourceData );
    }

    function executeCompiledTemplate( &$resourceData, &$textElements, $rootNamespace, $currentNamespace, &$extraParameters )
    {
        $resourceObject =& $resourceData['handler'];
        if ( !$resourceObject )
            return false;
        $keyData = $resourceData['key-data'];
        $uri = $resourceData['uri'];
        $resourceName = $resourceData['resource'];
        $templatePath = $resourceData['template-name'];
        $timestamp = $resourceData['time-stamp'];
        return $resourceObject->executeCompiledTemplate( $this, $textElements,
                                                         $keyData, $uri, $resourceData, $templatePath,
                                                         $extraParameters, $timestamp,
                                                         $rootNamespace, $currentNamespace );
    }

    /*!
     Returns the resource object for URI $uri. If a resource type is specified
     in the URI it is extracted and set in $res. The template name is set in $template
     without any resource specifier. To specify a resource the name and a ":" is
     prepended to the URI, for instance file:my.tpl.
     If no resource type is found the URI the default resource handler is used.
    */
    function &resourceFor( &$uri, &$res, &$template )
    {
        $args =& explode( ":", $uri );
        if ( count( $args ) > 1 )
        {
            $res = $args[0];
            $template = $args[1];
        }
        else
            $template = $uri;
        if ( eZTemplate::isDebugEnabled() )
            eZDebug::writeNotice( "eZTemplate: Loading template \"$template\" with resource \"$res\"" );
        $resobj =& $this->DefaultResource;
        if ( isset( $this->Resources[$res] ) and is_object( $this->Resources[$res] ) )
        {
            $resobj =& $this->Resources[$res];
        }
        return $resobj;
    }

    /*!
     \return The resource handler object for resource name \a $resourceName.
     \sa resourceFor
    */
    function &resourceHandler( $resourceName )
    {
        $resource =& $this->DefaultResource;
        if ( isset( $this->Resources[$resourceName] ) and
             is_object( $this->Resources[$resourceName] ) )
        {
            $resource =& $this->Resources[$resourceName];
        }
        return $resource;
    }

    function hasChildren( &$function, $functionName )
    {
        $hasChildren = $function->hasChildren();
        if ( is_array( $hasChildren ) )
            return $hasChildren[$functionName];
        else
            return $hasChildren;
     }

    /*!
     Returns the empty variable type.
    */
    function emptyVariable()
    {
        return array( "type" => "null" );
    }

    /*!
     \static
    */
    function mergeNamespace( $rootNamespace, $additionalNamespace )
    {
        $namespace = $rootNamespace;
        if ( $namespace == '' )
            $namespace = $additionalNamespace;
        else if ( $additionalNamespace != '' )
            $namespace = "$namespace:$additionalNamespace";
        return $namespace;
    }

    /*!
     Returns the actual value of a template type or null if an unknown type.
    */
    function &elementValue( &$dataElements, $rootNamespace, $currentNamespace, $placement = false,
                            $checkExistance = false )
    {
        $value = null;
        if ( !is_array( $dataElements ) )
        {
            $this->error( "elementValue",
                          "Missing array data structure, got " . gettype( $dataElements ) );
            return null;
        }
        foreach ( $dataElements as $dataElement )
        {
            if ( is_null( $dataElement ) )
            {
                return null;
            }
            $dataType = $dataElement[0];
            switch ( $dataType )
            {
                case EZ_TEMPLATE_TYPE_VOID:
                {
                    if ( !$checkExistance )
                        $this->warning( 'elementValue',
                                        'Found void datatype, should not be used' );
                    else
                        return null;
                } break;
                case EZ_TEMPLATE_TYPE_STRING:
                case EZ_TEMPLATE_TYPE_NUMERIC:
                case EZ_TEMPLATE_TYPE_IDENTIFIER:
                case EZ_TEMPLATE_TYPE_BOOLEAN:
                case EZ_TEMPLATE_TYPE_ARRAY:
                {
                    $value = $dataElement[1];
                } break;
                case EZ_TEMPLATE_TYPE_VARIABLE:
                {
                    $variableData = $dataElement[1];
                    $variableNamespace = $variableData[0];
                    $variableNamespaceScope = $variableData[1];
                    $variableName = $variableData[2];
                    if ( $variableNamespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_GLOBAL )
                        $namespace = $variableNamespace;
                    else if ( $variableNamespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_LOCAL )
                        $namespace = $this->mergeNamespace( $rootNamespace, $variableNamespace );
                    else if ( $variableNamespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE )
                        $namespace = $this->mergeNamespace( $currentNamespace, $variableNamespace );
                    else
                        $namespace = false;
                    if ( $this->hasVariable( $variableName, $namespace ) )
                    {
                        $value = $this->variable( $variableName, $namespace );
                    }
                    else
                    {
                        if ( !$checkExistance )
                            $this->error( '', "Unknown template variable '$variableName' in namespace '$namespace'", $placement );
                        return null;
                    }
                } break;
                case EZ_TEMPLATE_TYPE_ATTRIBUTE:
                {
                    $attributeData = $dataElement[1];
                    $attributeValue = $this->elementValue( $attributeData, $rootNamespace, $currentNamespace, false, $checkExistance );

                    if ( !is_null( $attributeValue ) )
                    {
                        if ( !is_numeric( $attributeValue ) and
                             !is_string( $attributeValue ) and
                             !is_bool( $attributeValue ) )
                        {
                            if ( !$checkExistance )
                                $this->error( "",
                                              "Cannot use type " . gettype( $attributeValue ) . " for attribute lookup", $placement );
                            return null;
                        }
                        if ( is_array( $value ) )
                        {
                            if ( isset( $value[$attributeValue] ) )
                            {
                                unset( $tempValue );
                                $tempValue =& $value[$attributeValue];
                                unset( $value );
                                $value =& $tempValue;
                            }
                            else
                            {
                                if ( !$checkExistance )
                                {
                                    $arrayAttributeList = array_keys( $value );
                                    $arrayCount = count( $arrayAttributeList );
                                    $errorMessage = "No such attribute for array($arrayCount): $attributeValue";
                                    $chooseText = "Choose one of following: ";
                                    $errorMessage .= "\n$chooseText";
                                    $errorMessage .= $this->expandAttributes( $arrayAttributeList, $chooseText, 25 );
                                    $this->error( "",
                                                  $errorMessage, $placement );
                                }
                                return null;
                            }
                        }
                        else if ( is_object( $value ) )
                        {
                            if ( method_exists( $value, "attribute" ) and
                                 method_exists( $value, "hasattribute" ) )
                            {
                                if ( $value->hasAttribute( $attributeValue ) )
                                {
                                    unset( $tempValue );
                                    $tempValue =& $value->attribute( $attributeValue );
                                    unset( $value );
                                    $value =& $tempValue;
                                }
                                else
                                {
                                    if ( !$checkExistance )
                                    {
                                        $objectAttributeList = array();
                                        if ( method_exists( $value, 'attributes' ) )
                                            $objectAttributeList = $value->attributes();
                                        $objectClass= get_class( $value );
                                        $errorMessage = "No such attribute for object($objectClass): $attributeValue";
                                        $chooseText = "Choose one of following: ";
                                        $errorMessage .= "\n$chooseText";
                                        $errorMessage .= $this->expandAttributes( $objectAttributeList, $chooseText, 25 );
                                        $this->error( "",
                                                      $errorMessage, $placement );
                                    }
                                    return null;
                                }
                            }
                            else
                            {
                                if ( !$checkExistance )
                                    $this->error( "",
                                                  "Cannot retrieve attribute of object(" . get_class( $value ) .
                                                  "), no attribute functions available",
                                                  $placement );
                                return null;
                            }
                        }
                        else
                        {
                            if ( !$checkExistance )
                                $this->error( "",
                                              "Cannot retrieve attribute of a " . gettype( $value ),
                                              $placement );
                            return null;
                        }
                    }
                    else
                    {
                        if ( !$checkExistance )
                            $this->error( '',
                                          'Attribute value was null, cannot get attribute',
                                          $placement );
                        return null;
                    }
                } break;
                case EZ_TEMPLATE_TYPE_OPERATOR:
                {
                    $operatorParameters = $dataElement[1];
                    $operatorName = $operatorParameters[0];
                    $operatorParameters = array_splice( $operatorParameters, 1 );
                    $valueData = array( 'value' => $value );
                    $this->processOperator( $operatorName, $operatorParameters, $rootNamespace, $currentNamespace,
                                            $valueData, $placement, $checkExistance );
                    unset( $value );
                    $value = $valueData['value'];
                } break;
                default:
                {
                    if ( !$checkExistance )
                        $this->error( "elementValue",
                                      "Unknown data type: '$dataType'" );
                    return null;
                }
            }
        }
        if ( is_object( $value ) and
             method_exists( $value, 'templateValue' ) )
        {
            $value =& $value->templateValue();
        }
        return $value;
    }

    function expandAttributes( $attributeList, $chooseText, $maxThreshold, $minThreshold = 1 )
    {
        $errorMessage = '';
        $attributeCount = count( $attributeList );
        if ( $attributeCount < $minThreshold )
            return $errorMessage;
        if ( $attributeCount < $maxThreshold )
        {
            $chooseLength = strlen( $chooseText );
            $attributeText = '';
            $i = 0;
            foreach ( $attributeList as $attributeName )
            {
                if ( $i > 0 )
                    $attributeText .= ",";
                if ( strlen( $attributeText ) > 40 )
                {
                    $attributeText .= "\n";
                    $errorMessage .= $attributeText;
                    $errorMessage .= str_repeat( ' ', $chooseLength );
                    $attributeText = '';
                }
                else if ( $i > 0 )
                    $attributeText .= " ";
                $attributeText .= $attributeName;
                ++$i;
            }
            $errorMessage .= $attributeText;
        }
        return $errorMessage;
    }

    function processOperator( $operatorName, $operatorParameters, $rootNamespace, $currentNamespace,
                              &$valueData, $placement = false, $checkExistance = false )
    {
        $namedParameters = array();
        $operatorParameterDefinition = $this->operatorParameterList( $operatorName );
        $i = 0;
        foreach ( $operatorParameterDefinition as $parameterName => $parameterType )
        {
            if ( !isset( $operatorParameters[$i] ) or
                 !isset( $operatorParameters[$i][0] ) or
                 $operatorParameters[$i][0] == EZ_TEMPLATE_TYPE_VOID )
            {
                if ( $parameterType["required"] )
                {
                    if ( !$checkExistance )
                        $this->warning( "eZTemplateOperatorElement", "Parameter '$parameterName' ($i) missing",
                                        $placement );
                    $namedParameters[$parameterName] = $parameterType["default"];
                }
                else
                {
                    $namedParameters[$parameterName] = $parameterType["default"];
                }
            }
            else
            {
                $parameterData = $operatorParameters[$i];
                $namedParameters[$parameterName] = $this->elementValue( $parameterData, $rootNamespace, $currentNamespace, false, $checkExistance );
            }
            ++$i;
        }

        if ( is_array( $this->Operators[$operatorName] ) )
        {
            $this->loadAndRegisterOperators( $this->Operators[$operatorName] );
        }
        $op =& $this->Operators[$operatorName];
        if ( isset( $op ) )
        {
            if ( is_object( $op ) and method_exists( $op, 'modify' ) )
            {
                $value = $valueData['value'];
                $op->modify( $this, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, $value, $namedParameters );
                $valueData['value'] = $value;
            }
            else
                $this->error( '', "Object problem with operator '$operatorName' ",
                              $placement );
        }
        else if ( !$checkExistance )
            $this->warning( "", "Operator '$operatorName' is not registered",
                            $placement );
    }

    /*!
     Returns the value of the template variable $data, or null if no defined variable for that name.
    */
    function &variableElementValue( &$data, $def_nspace )
    {
        if ( $data["type"] != "variable" )
            return null;
        $nspace = $data["namespace"];
        if ( $nspace === false )
            $nspace = $def_nspace;
        else
        {
            if ( $def_nspace != "" )
                $nspace = $def_nspace . ':' . $nspace;
        }
        $name = $data["name"];
        if ( !$this->hasVariable( $name, $nspace ) )
        {
            $var_name = $name;
            $this->warning( "", "Undefined variable: \"$var_name\"" . ( $nspace != "" ? " in namespace \"$nspace\"" : "" ) );
            return null;
        }
        $value =& $this->variable( $name, $nspace );
        $return_value =& $value;
        $attrs =& $data["attributes"];
        if ( count( $attrs ) > 0 )
        {
            reset( $attrs );
            while( ( $key = key( $attrs ) ) !== null )
            {
                $attr =& $attrs[$key];
                $attr_value = $this->attributeValue( $attr, $def_nspace );
                if ( !is_null( $attr_value ) )
                {
                    if ( !is_numeric( $attr_value ) and
                         !is_string( $attr_value ) )
                    {
                        $this->error( "",
                                      "Cannot use type " . gettype( $attr_value ) . " for attribute lookup" );
                        return null;
                    }
                    if ( is_array( $return_value ) )
                    {
                        if ( isset( $return_value[$attr_value] ) )
                            $return_value =& $return_value[$attr_value];
                        else
                        {
                            $this->error( "",
                                          "No such attribute for array: $attr_value" );
                            return null;
                        }
                    }
                    else if ( is_object( $return_value ) )
                    {
                        if ( method_exists( $return_value, "attribute" ) and
                             method_exists( $return_value, "hasattribute" ) )
                        {
                            if ( $return_value->hasAttribute( $attr_value ) )
                            {
                                unset( $return_attribute_value );
                                $return_attribute_value =& $return_value->attribute( $attr_value );
                                unset( $return_value );
                                $return_value =& $return_attribute_value;
                            }
                            else
                            {
                                $this->error( "",
                                              "No such attribute for object: $attr_value" );
                                return null;
                            }
                        }
                        else
                        {
                            $this->error( "",
                                          "Cannot retrieve attribute of object(" . get_class( $return_value ) .
                                          "), no attribute functions available." );
                            return null;
                        }
                    }
                    else
                    {
                        $this->error( "",
                                      "Cannot retrieve attribute of a " . gettype( $return_value ) );
                        return null;
                    }
                }
                else
                    return null;
                next( $attrs );
            }
        }
        return $return_value;
    }

    /*!
     Return the identifier used for attribute lookup.
    */
    function attributeValue( &$data, $nspace )
    {
        switch ( $data["type"] )
        {
            case "map":
            {
                return $data["content"];
            } break;
            case "index":
            {
                return $data["content"];
            } break;
            case "variable":
            {
                return $this->elementValue( $data["content"], $nspace );
            } break;
            default:
            {
                $this->error( "attributeValue()", "Unknown attribute type: " . $data["type"] );
                return null;
            }
        }
    }

    /*!
     Helper function for creating a displayable text for a variable.
    */
    function &variableText( &$var, $namespace = "", $attrs = array() )
    {
        $txt = "$";
        if ( $namespace != "" )
            $txt .= "$namespace:";
        $txt .= $var;
        if ( count( $attrs ) > 0 )
            $txt .= "." . implode( ".", $attrs );
        return $txt;
    }

    /*!
     Returns the named parameter list for the operator $name.
    */
    function operatorParameterList( $name )
    {
        $param_list = array();
        if ( isset( $this->Operators[$name] ) and
             is_array( $this->Operators[$name] ) )
        {
            $this->loadAndRegisterOperators( $this->Operators[$name] );
        }
        $op =& $this->Operators[$name];
        if ( isset( $op ) and
             method_exists( $op, "namedparameterlist" ) )
        {
            $param_list = $op->namedParameterList();
            if ( method_exists( $op, "namedparameterperoperator" ) and
                 $op->namedParameterPerOperator() )
            {
                if ( !isset( $param_list[$name] ) )
                    return array();
                $param_list = $param_list[$name];
            }
        }
        return $param_list;
    }

    /*!
     Tries to run the operator $operatorName with parameters $operatorParameters
     on the value $value.
    */
    function doOperator( &$element, &$namespace, &$current_nspace, &$value, &$operatorName, &$operatorParameters, &$named_params )
    {
        if ( is_array( $this->Operators[$operatorName] ) )
        {
            $this->loadAndRegisterOperators( $this->Operators[$operatorName] );
        }
        $op =& $this->Operators[$operatorName];
        if ( isset( $op ) )
        {
            $op->modify( $element, $this, $operatorName, $operatorParameters, $namespace, $current_nspace, $value, $named_params );
        }
        else
            $this->warning( "", "Operator \"$operatorName\" is not registered" );
    }

    /*!
     Tries to run the function object $func_obj
    */
    function &doFunction( &$name, &$func_obj, $nspace, $current_nspace )
    {
        $func =& $this->Functions[$name];
        if ( is_array( $func ) )
        {
            $this->loadAndRegisterFunctions( $this->Functions[$name] );
            $func =& $this->Functions[$name];
        }
        if ( isset( $func ) and
             is_object( $func ) )
        {
            return $func->process( $this, $name, $func_obj, $nspace, $current_nspace );
        }
        else
        {
            $this->warning( "", "Function \"$name\" is not registered" );
            $str = false;
            return $str;
        }
    }

    /*!
     Sets the template variable $var to the value $val.
     \sa setVariableRef
    */
    function setVariable( $var, $val, $namespace = "" )
    {
        if ( array_key_exists( $namespace, $this->Variables ) and
             array_key_exists( $var, $this->Variables[$namespace] ) )
            unset( $this->Variables[$namespace][$var] );
        $this->Variables[$namespace][$var] = $val;
    }

    /*!
     Sets the template variable $var to the value $val.
     \note This sets the variable using reference
     \sa setVariable
    */
    function setVariableRef( $var, &$val, $namespace = "" )
    {
        if ( array_key_exists( $namespace, $this->Variables ) and
             array_key_exists( $var, $this->Variables[$namespace] ) )
            unset( $this->Variables[$namespace][$var] );
        $this->Variables[$namespace][$var] =& $val;
    }

    /*!
     Removes the template variable $var. If the variable does not exists an error is output.
    */
    function unsetVariable( $var, $namespace = "" )
    {
        if ( array_key_exists( $namespace, $this->Variables ) and
             array_key_exists( $var, $this->Variables[$namespace] ) )
            unset( $this->Variables[$namespace][$var] );
        else
            $this->warning( "unsetVariable()", "Undefined Variable: \$$namespace:$var, cannot unset" );
    }

    /*!
     Returns true if the variable $var is set in namespace $namespace,
     if $attrs is supplied alle attributes must exist for the function to return true.
    */
    function hasVariable( $var, $namespace = "", $attrs = array() )
    {
        $exists = ( array_key_exists( $namespace, $this->Variables ) and
                    array_key_exists( $var, $this->Variables[$namespace] ) );
        if ( $exists and count( $attrs ) > 0 )
        {
            $ptr =& $this->Variables[$namespace][$var];
            foreach( $attrs as $attr )
            {
                unset( $tmp );
                if ( is_object( $ptr ) )
                {
                    if ( $ptr->hasAttribute( $attr ) )
                        $tmp =& $ptr->attribute( $attr );
                    else
                        return false;
                }
                else if ( is_array( $ptr ) )
                {
                    if ( array_key_exists( $attr, $ptr ) )
                        $tmp =& $ptr[$attr];
                    else
                        return false;
                }
                else
                {
                    return false;
                }
                unset( $ptr );
                $ptr =& $tmp;
            }
        }
        return $exists;
    }

    /*!
     Returns the content of the variable $var using namespace $namespace,
     if $attrs is supplied the result of the attributes is returned.
    */
    function &variable( $var, $namespace = "", $attrs = array() )
    {
        $val = null;
        $exists = ( array_key_exists( $namespace, $this->Variables ) and
                    array_key_exists( $var, $this->Variables[$namespace] ) );
        if ( $exists )
        {
            if ( count( $attrs ) > 0 )
            {
                $ptr =& $this->Variables[$namespace][$var];
                foreach( $attrs as $attr )
                {
                    unset( $tmp );
                    if ( is_object( $ptr ) )
                    {
                        if ( $ptr->hasAttribute( $attr ) )
                            $tmp =& $ptr->attribute( $attr );
                        else
                            return $val;
                    }
                    else if ( is_array( $ptr ) )
                    {
                        if ( array_key_exists( $attr, $ptr ) )
                            $tmp =& $ptr[$attr];
                        else
                            return $val;
                    }
                    else
                        return $val;
                    unset( $ptr );
                    $ptr =& $tmp;
                }
                if ( isset( $ptr ) )
                    return $ptr;
            }
            else
            {
                $val =& $this->Variables[$namespace][$var];
            }
        }
        return $val;
    }

    /*!
     Returns the attribute(s) of the template variable $var,
     $attrs is an array of attribute names to use iteratively for each new variable returned.
    */
    function &variableAttribute( &$var, $attrs )
    {
        if ( count( $attrs ) > 0 )
        {
            $ptr =& $var;
            foreach( $attrs as $attr )
            {
                unset( $tmp );
                if ( is_object( $ptr ) )
                {
                    if ( $ptr->hasAttribute( $attr ) )
                        $tmp =& $ptr->attribute( $attr );
                    else
                        return $val;
                }
                else if ( is_array( $ptr ) )
                {
                    if ( isset( $ptr[$attr] ) )
                        $tmp =& $ptr[$attr];
                    else
                        return $val;
                }
                else
                    return $val;
                unset( $ptr );
                $ptr =& $tmp;
            }
            if ( isset( $ptr ) )
                return $ptr;
        }
        return null;
    }

    /*!
    */
    function appendElement( &$text, &$item, $nspace, $name )
    {
        $this->appendElementText( $textElements, $item, $nspace, $name );
        $text .= implode( '', $textElements );
    }

    /*!
    */
    function appendElementText( &$textElements, &$item, $nspace, $name )
    {
        if ( !is_array( $textElements ) )
            $textElements = array();
        if ( is_object( $item ) and
             method_exists( $item, 'templateValue' ) )
        {
            $item =& $item->templateValue();
            $textElements[] = "$item";
        }
        else if ( is_object( $item ) )
        {
            $hasTemplateData = false;
            if ( method_exists( $item, 'templateData' ) )
            {
                $templateData =& $item->templateData();
                if ( is_array( $templateData ) and
                     isset( $templateData['type'] ) )
                {
                    $templateType =& $templateData['type'];
                    if ( $templateType == 'template' and
                         isset( $templateData['uri'] ) and
                         isset( $templateData['template_variable_name'] ) )
                    {
                        $templateURI =& $templateData['uri'];
                        $templateVariableName =& $templateData['template_variable_name'];
                        $templateText = '';
                        include_once( 'lib/eztemplate/classes/eztemplateincludefunction.php' );
                        $this->setVariableRef( $templateVariableName, $item, $name );
                        eZTemplateIncludeFunction::handleInclude( $textElements, $templateURI, $this, $nspace, $name );
                        $hasTemplateData = true;
                    }
                }
            }
            if ( !$hasTemplateData )
                $textElements[] = 'Object(' . get_class( $item ) . ')';
        }
        else
            $textElements[] = "$item";
        return $textElements;
    }

    /*!
     Registers the functions supplied by the object $functionObject.
     The object must have a function called functionList()
     which returns an array of functions this object handles.
     If the object has a function called attributeList()
     it is used for registering function attributes.
     The function returns an associative array with each key being
     the name of the function and the value being a boolean.
     If the boolean is true the function will have children.
    */
    function registerFunctions( &$functionObject )
    {
        $this->registerFunctionsInternal( $functionObject );
    }

    /*!
    */
    function registerAutoloadFunctions( $functionDefinition )
    {
        if ( ( ( isset( $functionDefinition['function'] ) or
                 ( isset( $functionDefinition['script'] ) and
                   isset( $functionDefinition['class'] ) ) ) and
               ( isset( $functionDefinition['function_names_function'] ) or
                 isset( $functionDefinition['function_names'] ) ) ) )
        {
            if ( isset( $functionDefinition['function_names_function'] ) )
            {
                $functionNamesFunction = $functionDefinition['function_names_function'];
                if ( !function_exists( $functionNamesFunction ) )
                {
                    $this->error( 'registerFunctions', "Cannot register function definition, missing function names function '$functionNamesFunction'" );
                    return;
                }
                $functionNames = $operatorNamesFunction();
            }
            else
                $functionNames = $functionDefinition['function_names'];
            foreach ( $functionNames as $functionName )
            {
                $this->Functions[$functionName] =& $functionDefinition;
            }
            if ( isset( $functionDefinition['function_attributes'] ) )
            {
                foreach ( $functionDefinition['function_attributes'] as $functionAttributeName )
                {
                    unset( $this->FunctionAttributes[$functionAttributeName] );
                    $this->FunctionAttributes[$functionAttributeName] =& $functionDefinition;
                }
            }
        }
        else
            $this->error( 'registerFunctions', 'Cannot register function definition, missing data' );
    }

    function loadAndRegisterFunctions( $functionDefinition )
    {
        eZDebug::accumulatorStart( 'template_register_function', 'template_total', 'Template load and register function' );
        $functionObject = null;
        if ( isset( $functionDefinition['function'] ) )
        {
            $function = $functionDefinition['function'];
//             print( "loadAndRegisterFunction: $function<br/>" );
            if ( function_exists( $function ) )
                $functionObject =& $function();
        }
        else if ( isset( $functionDefinition['script'] ) )
        {
            $script = $functionDefinition['script'];
            $class = $functionDefinition['class'];
//             print( "loadAndRegisterFunction: $script<br/>" );
            include_once( $script );
            if ( class_exists( $class ) )
                $functionObject = new $class();
        }
        eZDebug::accumulatorStop( 'template_register_function' );
        if ( is_object( $functionObject ) )
        {
            $this->registerFunctionsInternal( $functionObject, true );
            return true;
        }
        return false;
    }

    /*!
     \private
    */
    function registerFunctionsInternal( &$functionObject, $debug = false )
    {
        if ( !is_object( $functionObject ) or
             !method_exists( $functionObject, 'functionList' ) )
            return false;
        foreach ( $functionObject->functionList() as $functionName )
        {
            $this->Functions[$functionName] =& $functionObject;
        }
        if ( method_exists( $functionObject, "attributeList" ) )
        {
            $functionAttributes = $functionObject->attributeList();
            foreach ( $functionAttributes as $attributeName => $hasChildren )
            {
                unset( $this->FunctionAttributes[$attributeName] );
                $this->FunctionAttributes[$attributeName] = $hasChildren;
            }
        }
        return true;
    }

    /*!
     Registers the function $func_name to be bound to object $func_obj.
     If the object has a function called attributeList()
     it is used for registering function attributes.
     The function returns an associative array with each key being
     the name of the function and the value being a boolean.
     If the boolean is true the function will have children.
    */
    function registerFunction( $func_name, &$func_obj )
    {
        $this->Functions[$func_name] =& $func_obj;
        if ( method_exists( $func_obj, "attributeList" ) )
        {
            $attrs = $func_obj->attributeList();
            while ( list( $attr_name, $has_children ) = each( $attrs ) )
            {
                $this->FunctionAttributes[$attr_name] = $has_children;
            }
        }
    }

    /*!
     Registers a new literal tag in which the tag will be transformed into
     a text element.
    */
    function registerLiteral( $func_name )
    {
        $this->Literals[$func_name] = true;
    }

    /*!
     Removes the literal tag $func_name.
    */
    function unregisterLiteral( $func_name )
    {
        unset( $this->Literals[$func_name] );
    }

    /*!
    */
    function registerAutoloadOperators( $operatorDefinition )
    {
        if ( ( ( isset( $operatorDefinition['function'] ) or
                 ( isset( $operatorDefinition['script'] ) and
                   isset( $operatorDefinition['class'] ) ) ) and
               ( isset( $operatorDefinition['operator_names_function'] ) or
                 isset( $operatorDefinition['operator_names'] ) ) ) )
        {
            if ( isset( $operatorDefinition['operator_names_function'] ) )
            {
                $operatorNamesFunction = $operatorDefinition['operator_names_function'];
                if ( !function_exists( $operatorNamesFunction ) )
                {
                    $this->error( 'registerOperators', "Cannot register operator definition, missing operator names function '$operatorNamesFunction'" );
                    return;
                }
                $operatorNames = $operatorNamesFunction();
            }
            else
                $operatorNames = $operatorDefinition['operator_names'];
            foreach ( $operatorNames as $operatorName )
            {
                $this->Operators[$operatorName] =& $operatorDefinition;
            }
        }
        else
            $this->error( 'registerOperators', 'Cannot register operator definition, missing data' );
    }

    function loadAndRegisterOperators( $operatorDefinition )
    {
        $operatorObject = null;
        if ( isset( $operatorDefinition['function'] ) )
        {
            $function = $operatorDefinition['function'];
//             print( "loadAndRegisterOperator: $function<br/>" );
            if ( function_exists( $function ) )
                $operatorObject =& $function();
        }
        else if ( isset( $operatorDefinition['script'] ) )
        {
            $script = $operatorDefinition['script'];
            $class = $operatorDefinition['class'];
//             print( "loadAndRegisterOperator: $script<br/>" );
            include_once( $script );
            if ( class_exists( $class ) )
            {
                if ( isset( $operatorDefinition['class_parameter'] ) )
                    $operatorObject = new $class( $operatorDefinition['class_parameter'] );
                else
                    $operatorObject = new $class();
            }
        }
        if ( is_object( $operatorObject ) )
        {
            $this->registerOperatorsInternal( $operatorObject, true );
            return true;
        }
        return false;
    }

    /*!
     Registers the operators supplied by the object $operatorObject.
     The function operatorList() must return an array of operator names.
    */
    function registerOperators( &$operatorObject )
    {
        $this->registerOperatorsInternal( $operatorObject );
    }

    /*!
    */
    function registerOperatorsInternal( &$operatorObject, $debug = false )
    {
        if ( !is_object( $operatorObject ) or
             !method_exists( $operatorObject, 'operatorList' ) )
            return false;
        foreach( $operatorObject->operatorList() as $operatorName )
        {
            $this->Operators[$operatorName] =& $operatorObject;
        }
    }

    /*!
     Registers the operator $op_name to use the object $op_obj.
    */
    function registerOperator( $op_name, &$op_obj )
    {
        $this->Operators[$op_name] =& $op_obj;
    }

    /*!
     Unregisters the operator $op_name.
    */
    function unregisterOperator( $op_name )
    {
        if ( is_array( $op_name ) )
        {
            foreach ( $op_name as $op )
            {
                $this->unregisterOperator( $op_name );
            }
        }
        else if ( isset( $this->Operators ) )
            unset( $this->Operators[$op_name] );
        else
            $this->warning( "unregisterOpearator()", "Operator $op_name is not registered, cannot unregister" );
    }

    /*!
     Not implemented yet.
    */
    function registerFilter()
    {
    }

    /*!
     Registers a new resource object $res.
     The resource object take care of fetching templates using an URI.
    */
    function registerResource( &$res )
    {
        if ( is_object( $res ) )
            $this->Resources[$res->resourceName()] =& $res;
        else
            $this->warning( "registerResource()", "Supplied argument is not a resource object" );
    }

    /*!
     Unregisters the resource $res_name.
    */
    function unregisterResource( $res_name )
    {
        if ( is_array( $res_name ) )
        {
            foreach ( $res_name as $res )
            {
                $this->unregisterResource( $res );
            }
        }
        else if ( isset( $this->Resources[$res_name] ) )
            unset( $this->Resources[$res_name] );
        else
            $this->warning( "unregisterResource()", "Resource $res_name is not registered, cannot unregister" );
    }

    /*!
     Sets whether detail output is used or not.
     Detail output is useful for debug output where you want to examine the template
     and the output text.
    */
    function setShowDetails( $show )
    {
        $this->ShowDetails = $show;
    }

    /*!
     Outputs a warning about the parameter $param missing for function/operator $name.
    */
    function missingParameter( $name, $param )
    {
        $this->warning( $name, "Missing parameter $param" );
    }

    /*!
     Outputs a warning about the parameter count being to high for function/operator $name.
    */
    function extraParameters( $name, $count, $maxCount )
    {
        $this->warning( $name, "Passed $count parameters but correct count is $maxCount" );
    }

    /*!
     Outputs a warning about the variable $var being undefined.
    */
    function undefinedVariable( $name, $var )
    {
        $this->warning( $name, "Undefined variable: $var" );
    }

    /*!
     Outputs an error about the template function $func_name being undefined.
    */
    function undefinedFunction( $func_name )
    {
        $this->error( "", "Undefined function: $func_name" );
    }

    /*!
     Creates a string for the placement information and returns it.
     \note The placement information can either be in indexed or associative
    */
    function placementText( $placement = false )
    {
        $placementText = false;
        if ( $placement !== false )
        {
            if ( isset( $placement['start'] ) and
                 isset( $placement['stop'] ) and
                 isset( $placement['templatefile'] ) )
            {
                $line = $placement['start']['line'];
                $column = $placement['start']['column'];
                $templateFile = $placement['templatefile'];
            }
            else
            {
                $line = $placement[0][0];
                $column = $placement[0][1];
                $templateFile = $placement[2];
            }

            $placementText = " @ $templateFile:$line" . "[$column]";
        }
        return $placementText;
    }

    /*!
     Displays a warning for the function/operator $name and text $txt.
    */
    function warning( $name, $txt, $placement = false )
    {
        if ( !is_string( $placement ) )
            $placementText = $this->placementText( $placement );
        else
            $placementText = $placement;
        $placementText = $this->placementText( $placement );
        if ( $name != "" )
            eZDebug::writeWarning( $txt, "eZTemplate:$name" . $placementText );
        else
            eZDebug::writeWarning( $txt, "eZTemplate" . $placementText );
    }

    /*!
     Displays an error for the function/operator $name and text $txt.
    */
    function error( $name, $txt, $placement = false )
    {
        if ( !is_string( $placement ) )
            $placementText = $this->placementText( $placement );
        else
            $placementText = $placement;
        if ( $name != "" )
            $nameText = "eZTemplate:$name";
        else
            $nameText = "eZTemplate";
        eZDebug::writeError( $txt, $nameText . $placementText );
        $hasAppendWarning =& $GLOBALS['eZTemplateHasAppendWarning'];
        $ini =& $this->ini();
        if ( $ini->variable( 'ControlSettings', 'DisplayWarnings' ) == 'enabled' )
        {
            if ( !isset( $hasAppendWarning ) or
                 !$hasAppendWarning )
            {
                if ( function_exists( 'eZAppendWarningItem' ) )
                {
                    eZAppendWarningItem( array( 'error' => array( 'type' => 'template',
                                                                  'number' => EZ_ERROR_TEMPLATE_FILE_ERRORS ),
                                                'text' => ezi18n( 'lib/eztemplate', 'Some template errors occured, see debug for more information.' ) ) );
                    $hasAppendWarning = true;
                }
            }
        }
    }


    function operatorInputSupported( $operatorName )
    {
    }

    /*!
     Sets the original text for uri $uri to $text.
    */
    function setIncludeText( $uri, &$text )
    {
        $this->IncludeText[$uri] =& $text;
    }

    /*!
     Sets the output for uri $uri to $output.
    */
    function setIncludeOutput( $uri, &$output )
    {
        $this->IncludeOutput[$uri] =& $output;
    }

    /*!
     \return the path list which is used for autoloading functions and operators.
    */
    function autoloadPathList()
    {
        return $this->AutoloadPathList;
    }

    /*!
     Sets the path list for autoloading.
    */
    function setAutoloadPathList( $pathList )
    {
        $this->AutoloadPathList = $pathList;
    }

    /*!
     Looks trough the pathes specified in autoloadPathList() and fetches autoload
     definition files used for autoloading functions and operators.
    */
    function autoload()
    {
        $pathList =& $this->autoloadPathList();
        foreach ( $pathList as $path )
        {
            $autoloadFile = $path . '/eztemplateautoload.php';
            if ( file_exists( $autoloadFile ) )
            {
                unset( $eZTemplateOperatorArray );
                unset( $eZTemplateFunctionArray );
                include( $autoloadFile );
                if ( isset( $eZTemplateOperatorArray ) and
                     is_array( $eZTemplateOperatorArray ) )
                {
                    foreach ( $eZTemplateOperatorArray as $operatorDefinition )
                    {
                        $this->registerAutoloadOperators( $operatorDefinition );
                    }
                }
                if ( isset( $eZTemplateFunctionArray ) and
                     is_array( $eZTemplateFunctionArray ) )
                {
                    foreach ( $eZTemplateFunctionArray as $functionDefinition )
                    {
                        $this->registerAutoloadFunctions( $functionDefinition );
                    }
                }
            }
        }
    }

    /*!
     Resets all template variables.
    */
    function resetVariables()
    {
        $this->Variables = array();
    }

    /*!
     Resets all template functions and operators by calling the resetFunction and resetOperator
     on all elements that supports it.
    */
    function resetElements()
    {
        foreach ( array_keys( $this->Functions ) as $functionName )
        {
            $functionObject =& $this->Functions[$functionName];
            if ( is_object( $functionObject ) and
                 method_exists( $functionObject, 'resetFunction' ) )
            {
                $functionObject->resetFunction( $functionName );
            }
        }

        foreach ( array_keys( $this->Operators ) as $operatorName )
        {
            $operatorObject =& $this->Operators[$operatorName];
            if ( is_object( $operatorObject ) and
                 method_exists( $operatorObject, 'resetOperator' ) )
            {
                $operatorObject->resetOperator( $operatorName );
            }
        }
    }

    /*!
     Resets all template variables, functions and operators.
    */
    function reset()
    {
        $this->resetVariables();
        $this->resetElements();
        $this->IsCachingAllowed = true;
    }

    /*!
     Returns the globale template instance, creating it if it does not exist.
    */
    function &instance()
    {
        $tpl =& $GLOBALS["eZTemplateInstance"];
        if ( get_class( $tpl ) != "eztemplate" )
        {
            $tpl = new eZTemplate();
        }
        return $tpl;
    }

    /*!
     Returns the INI object for the template.ini file.
    */
    function &ini()
    {
        include_once( "lib/ezutils/classes/ezini.php" );
        $ini =& eZINI::instance( "template.ini" );
        return $ini;
    }

    /*!
     \static
     \return true if special XHTML code should be included before the included template file.
             This code will display the template filename in the browser but will eventually
             break the design.
    */
    function isXHTMLCodeIncluded()
    {
        if ( !isset( $GLOBALS['eZTemplateDebugXHTMLCodeEnabled'] ) )
        {
            $ini =& eZINI::instance();
            $GLOBALS['eZTemplateDebugXHTMLCodeEnabled'] = $ini->variable( 'TemplateSettings', 'ShowXHTMLCode' ) == 'enabled';
        }
        return $GLOBALS['eZTemplateDebugXHTMLCodeEnabled'];
    }

    /*!
     \static
     \return true if debugging of internals is enabled, this will display
     which files are loaded and when cache files are created.
      Set the option with setIsDebugEnabled().
    */
    function isDebugEnabled()
    {
        if ( !isset( $GLOBALS['eZTemplateDebugInternalsEnabled'] ) )
             $GLOBALS['eZTemplateDebugInternalsEnabled'] = EZ_TEMPLATE_DEBUG_INTERNALS;
        return $GLOBALS['eZTemplateDebugInternalsEnabled'];
    }

    /*!
     \static
     Sets whether internal debugging is enabled or not.
    */
    function setIsDebugEnabled( $debug )
    {
        $GLOBALS['eZTemplateDebugInternalsEnabled'] = $debug;
    }

    /*!
      \return \c true if caching is allowed (default) or \c false otherwise.
              This also affects template compiling.
      \sa setIsCachingAllowed
    */
    function isCachingAllowed()
    {
        return $this->IsCachingAllowed;
    }

    /*!
      Sets whether caching/compiling is allowed or not. This is useful
      if you need to make sure templates are parsed and processed
      without any caching mechanisms.
      \note The default is to allow caching.
      \sa isCachingAllowed
    */
    function setIsCachingAllowed( $allowed )
    {
        $this->IsCachingAllowed = $allowed;
    }

    /// \privatesection
    /// Associative array of resource objects
    var $Resources;
    /// Reference to the default resource object
    var $DefaultResource;
    /// The original template text
    var $Text;
    /// Included texts, usually performed by custom functions
    var $IncludeText;
    /// Included outputs, usually performed by custom functions
    var $IncludeOutput;
    /// The timestamp of the template when it was last modified
    var $TimeStamp;
    /// The left delimiter used for parsing
    var $LDelim;
    /// The right delimiter used for parsing
    var $RDelim;

    /// The resulting object tree of the template
    var $Tree;
    /// An associative array of template variables
    var $Variables;
    /// An associative array of operators
    var $Operators;
    /// An associative array of functions
    var $Functions;
    /// An associative array of function attributes
    var $FunctionAttributes;
    /// An associative array of literal tags
    var $Literals;
    /// True if output details is to be shown
    var $ShowDetails = false;
    /// \c true if caching is allowed
    var $IsCachingAllowed;

    var $AutoloadPathList;

//     var $CurrentRelatedResource;
//     var $CurrentRelatedTemplateName;
}

?>
