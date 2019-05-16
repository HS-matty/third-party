<?php
//
// Definition of eZTemplateCompiler class
//
// Created on: <06-Dec-2002 14:17:10 amos>
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

/*! \file eztemplatecompiler.php
*/

/*!
  \class eZTemplateCompiler eztemplatecompiler.php
  \brief Creates compiled PHP code from templates to speed up template usage.

   Various optimizations that can be done are:

    Data:
    - Is constant, generate static data
    - Is variable, generate direct variable extraction
    - Has operators
    - Has attributes

    Attributes:
    - Is constant, generate static data

    Operators:
    - Supports input
    - Supports output
    - Supports parameters
    - Generates static data (true, false)
    - Custom PHP code
    - Modifies template variables, if possible name which ones. Allows
      for caching of variables in the script.

    Functions:
    - Supports parameters
    - Supports children (set? no, section? yes)
    - Generates static data (ldelim,rdelim)
    - Children usage, no result(set-block) | copy(let,default) | dynamic(conditional, repeated etc.)
    - Children tree, requires original tree | allows custom processing
    - Custom PHP code
    - Deflate/transform tree, create new non-nested tree (let, default)
    - Modifies template variables, if possible name which ones. Allows
      for caching of variables in the script.
*/

include_once( 'lib/ezutils/classes/ezdebug.php' );

define( 'EZ_TEMPLATE_COMPILE_CODE_DATE', 1074699607 );

class eZTemplateCompiler
{
    /*!
     Constructor
    */
    function eZTemplateCompiler()
    {
    }

    /*!
     \static
     Sets/unsets various compiler settings. To set a setting add a key in the \a $settingsMap
     with the wanted value, to unset it use \c null as the value.

     The following values can be set.
     - compile - boolean, whether to compile templates or not
     - comments - boolean, whether to include comments in templates
     - accumulators - boolean, whether to include debug accumulators in templates
     - timingpoints - boolean, whether to include debug timingpoints in templates
     - fallbackresource - boolean, whether to include the fallback resource code
     - nodeplacement - boolean, whether to include information on placement of all nodes
     - execution - boolean, whether to execute the compiled templates or not
     - generate - boolean, whether to always generate the compiled files, or only when template is changed
     - compilation-directory - string, where to place compiled files, the path will be relative from the
                               eZ publish directory and not the var/cache directory.
    */
    function setSettings( $settingsMap )
    {
        $existingMap = array();
        if ( isset( $GLOBALS['eZTemplateCompilerSettings'] ) )
        {
            $existingMap = $GLOBALS['eZTemplateCompilerSettings'];
        }
        $GLOBALS['eZTemplateCompilerSettings'] = array_merge( $existingMap, $settingsMap );
    }

    /*!
     \static
     \return true if template compiling is enabled.
     \note To change this setting edit settings/site.ini and locate the group TemplateSettings and the entry TemplateCompile.
    */
    function isCompilationEnabled()
    {
        if ( isset( $GLOBALS['eZSiteBasics'] ) )
        {
            $siteBasics = $GLOBALS['eZSiteBasics'];
            if ( $siteBasics['no-cache-adviced'] )
            {
                return false;
            }
        }

        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['compile'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['compile'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['compile'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $compilationEnabled = $ini->variable( 'TemplateSettings', 'TemplateCompile' ) == 'enabled';
        return $compilationEnabled;
    }

    /*!
     \static
     \return true if template compilation should include comments.
    */
    function isCommentsEnabled()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['comments'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['comments'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['comments'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $commentsEnabled = $ini->variable( 'TemplateSettings', 'CompileComments' ) == 'enabled';
        return $commentsEnabled;
    }

    /*!
     \static
     \return true if template compilation should include debug accumulators.
    */
    function isAccumulatorsEnabled()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['accumulators'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['accumulators'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['accumulators'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $enabled = $ini->variable( 'TemplateSettings', 'CompileAccumulators' ) == 'enabled';
        return $enabled;
    }

    /*!
     \static
     \return true if template compilation should include debug timing points.
    */
    function isTimingPointsEnabled()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['timingpoints'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['timingpoints'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['timingpoints'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $enabled = $ini->variable( 'TemplateSettings', 'CompileTimingPoints' ) == 'enabled';
        return $enabled;
    }

    /*!
     \static
     \return true if resource fallback code should be included.
    */
    function isFallbackResourceCodeEnabled()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['fallbackresource'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['fallbackresource'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['fallbackresource'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $enabled = $ini->variable( 'TemplateSettings', 'CompileResourceFallback' ) == 'enabled';
        return $enabled;
    }

    /*!
     \static
     \return true if template compilation should include comments.
    */
    function isNodePlacementEnabled()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['nodeplacement'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['nodeplacement'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['nodeplacement'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $nodePlacementEnabled = $ini->variable( 'TemplateSettings', 'CompileNodePlacements' ) == 'enabled';
        return $nodePlacementEnabled;
    }

    /*!
     \static
     \return true if the compiled template execution is enabled.
    */
    function isExecutionEnabled()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['execution'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['execution'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['execution'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $execution = $ini->variable( 'TemplateSettings', 'CompileExecution' ) == 'enabled';
        return $execution;
    }

    /*!
     \static
     \return true if template compilation should always be run even if a sufficient compilation already exists.
    */
    function alwaysGenerate()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['generate'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['generate'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['generate'];
        }

        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $alwaysGenerate = $ini->variable( 'TemplateSettings', 'CompileAlwaysGenerate' ) == 'enabled';
        return $alwaysGenerate;
    }

    /*!
     \static
     \return true if template node tree named \a $treeName should be included the compiled template.
    */
    function isTreeEnabled( $treeName )
    {
        include_once( 'lib/ezutils/classes/ezini.php' );
        $ini =& eZINI::instance();
        $treeList = $ini->variable( 'TemplateSettings', 'CompileIncludeNodeTree' );
        return in_array( $treeName, $treeList );
    }

    /*!
     \static
     \return the directory for compiled templates.
    */
    function compilationDirectory()
    {
        if ( isset( $GLOBALS['eZTemplateCompilerSettings']['compilation-directory'] ) and
             $GLOBALS['eZTemplateCompilerSettings']['compilation-directory'] !== null )
        {
            return $GLOBALS['eZTemplateCompilerSettings']['compilation-directory'];
        }

        $compilationDirectory =& $GLOBALS['eZTemplateCompilerDirectory'];
        if ( !isset( $compilationDirectory ) )
        {
            include_once( 'lib/ezfile/classes/ezdir.php' );
            include_once( 'lib/ezutils/classes/ezsys.php' );
            $compilationDirectory = eZDir::path( array( eZSys::cacheDirectory(), 'template/compiled' ) );
        }
        return $compilationDirectory;
    }

    /*!
     Creates the name for the compiled template and returns it.
     The name conists of original filename with the md5 of the key and charset appended.
    */
    function compilationFilename( $key, $resourceData )
    {
        $internalCharset = eZTextCodec::internalCharset();
        $templateFilepath = $resourceData['template-filename'];
        $extraName = '';
        if ( preg_match( "#^.+/(.*)\.tpl$#", $templateFilepath, $matches ) )
            $extraName = $matches[1] . '-';
        else if ( preg_match( "#^(.*)\.tpl$#", $templateFilepath, $matches ) )
            $extraName = $matches[1] . '-';
        $accessText = false;
        if ( isset( $GLOBALS['eZCurrentAccess']['name'] ) )
            $accessText = '-' . $GLOBALS['eZCurrentAccess']['name'];
        include_once( 'lib/ezlocale/classes/ezlocale.php' );
        $locale =& eZLocale::instance();
        $language =& $locale->translationCode();
        $cacheFileKey = $key . '-' . $internalCharset . '-' . $language . $accessText;
        $cacheFileName = $extraName . md5( $cacheFileKey ) . '.php';
        return $cacheFileName;
    }

    /*!
     \static
     \return true if the compiled template with the key \a $key exists.
             A compiled template is found usable when it exists and has a timestamp
             higher or equal to \a $timestamp.
    */
    function hasCompiledTemplate( $key, $timestamp, &$resourceData )
    {
        if ( !eZTemplateCompiler::isCompilationEnabled() )
            return false;
        if ( eZTemplateCompiler::alwaysGenerate() )
            return false;

        $cacheFileName = eZTemplateCompiler::compilationFilename( $key, $resourceData );

        include_once( 'lib/ezutils/classes/ezphpcreator.php' );

        $php = new eZPHPCreator( eZTemplateCompiler::compilationDirectory(), $cacheFileName );
        $canRestore = $php->canRestore( $timestamp );
        $uri = false;
        if ( $canRestore )
            eZDebugSetting::writeDebug( 'eztemplate-compile', "Cache hit for uri '$uri' with key '$key'", 'eZTemplateCompiler::hasCompiledTemplate' );
        else
            eZDebugSetting::writeDebug( 'eztemplate-compile', "Cache miss for uri '$uri' with key '$key'", 'eZTemplateCompiler::hasCompiledTemplate' );
        return $canRestore;
    }

    /*!
     Tries to execute the compiled template and returns \c true if succsesful.
     Returns \c false if caching is disabled or the compiled template could not be executed.
    */
    function executeCompilation( &$tpl, &$textElements, $key, &$resourceData,
                                 $rootNamespace, $currentNamespace )
     {
        if ( !eZTemplateCompiler::isCompilationEnabled() )
            return false;
        if ( !eZTemplateCompiler::isExecutionEnabled() )
            return false;
        $cacheFileName = eZTemplateCompiler::compilationFilename( $key, $resourceData );

        $directory = eZTemplateCompiler::compilationDirectory();
        $phpScript = eZDir::path( array( $directory, $cacheFileName ) );
        if ( file_exists( $phpScript ) )
        {
            $text = false;
            $helperStatus = eZTemplateCompiler::executeCompilationHelper( $phpScript, $text,
                                                                          $tpl, $key, $resourceData,
                                                                          $rootNamespace, $currentNamespace );
            if ( $helperStatus )
            {
                $textElements[] = $text;
                return true;
            }
            else
                eZDebug::writeError( "Failed executing compiled template '$phpScript'", 'eZTemplateCompiler::executeCompilation' );
        }
        else
            eZDebug::writeError( "Unknown compiled template '$phpScript'", 'eZTemplateCompiler::executeCompilation' );
        return false;
    }

    /*!
     Helper function for executeCompilation. Will execute the script \a $phpScript and
     set the result text in \a $text.
     The parameters \a $tpl, \a $resourceData, \a $rootNamespace and \a $currentNamespace
     are passed to the executed template compilation script.
     \return true if a text result was created.
    */
    function executeCompilationHelper( $phpScript, &$text,
                                       &$tpl, $key, &$resourceData,
                                       $rootNamespace, $currentNamespace )
    {
        $vars =& $tpl->Variables;

        $text = null;
        $namespaceStack = array();
        include( $phpScript );
        if ( $text !== null )
        {
            return true;
        }
        return false;
    }

    /*!
     \static
     Generates the cache which will be used for handling optimized processing using the key \a $key.
     \note Each call to this will set the PHP time limit to 30
     \return false if the cache does not exist.
    */
    function compileTemplate( &$tpl, $key, &$resourceData )
    {
        if ( !eZTemplateCompiler::isCompilationEnabled() )
            return false;
        $cacheFileName = eZTemplateCompiler::compilationFilename( $key, $resourceData );

        // Time limit #1:
        // We reset the time limit to 30 seconds to ensure that templates
        // have enough time to compile
        // However if time limit is unlimited (0) we leave it be
        // Time limit will also be reset after subtemplates are compiled
        if ( ini_get( 'max_execution_time' ) != 0  )
        {
            @set_time_limit( 30 );
        }

        include_once( 'lib/eztemplate/classes/eztemplatenodetool.php' );
        include_once( 'lib/ezutils/classes/ezphpcreator.php' );

        $rootNode =& $resourceData['root-node'];
        if ( !$rootNode )
            return false;

        $GLOBALS['eZTemplateCompilerResourceCache'][$resourceData['template-filename']] =& $resourceData;

        $useComments = eZTemplateCompiler::isCommentsEnabled();

        eZTemplateCompiler::createCommonCompileTemplate();

        $php = new eZPHPCreator( eZTemplateCompiler::compilationDirectory(), $cacheFileName );
        $php->addComment( 'URI:       ' . $resourceData['uri'] );
        $php->addComment( 'Filename:  ' . $resourceData['template-filename'] );
        $php->addComment( 'Timestamp: ' . $resourceData['time-stamp'] . ' (' . date( 'D M j G:i:s T Y', $resourceData['time-stamp'] ) . ')' );

        $php->addCodePiece('$oldSetArray_'. md5( $resourceData['template-filename'] ). " = isset( \$setArray ) ? \$setArray : array();\n".
                           "\$setArray = array();\n");

        if ( $resourceData['locales'] && count( $resourceData['locales'] ) )
        {
            $php->addComment( 'Locales:   ' . join( ', ', $resourceData['locales'] ) );

            $php->addCodePiece( 
                '$locales = array( "'. join( '", "', $resourceData['locales'] ) . "\" );\n". 
                '$oldLocale_'. md5( $resourceData['template-filename'] ). ' = setlocale( LC_CTYPE, null );'. "\n".
                '$currentLocale_'. md5( $resourceData['template-filename'] ). ' = setlocale( LC_CTYPE, $locales );'. "\n"
            );
        }
//         $php->addCodePiece( "print( \"" . $resourceData['template-filename'] . " ($cacheFileName)<br/>\n\" );" );
        if ( $useComments )
        {
            $templateFilename = $resourceData['template-filename'];
            if ( file_exists( $templateFilename ) )
            {
                $fd = fopen( $templateFilename, 'rb' );
                if ( $fd )
                {
                    $templateText = fread( $fd, filesize( $templateFilename ) );
                    $php->addComment( "Original code:\n" . $templateText );
                    fclose( $fd );
                }
            }
        }
        $php->addVariable( 'eZTemplateCompilerCodeDate', EZ_TEMPLATE_COMPILE_CODE_DATE );
        $php->addCodePiece( "if ( !defined( 'EZ_TEMPLATE_COMPILER_COMMON_CODE' ) )\n" );
        $php->addInclude( eZTemplateCompiler::compilationDirectory() . '/common.php', EZ_PHPCREATOR_INCLUDE_ONCE, array( 'spacing' => 4 ) );
        $php->addSpace();

        if ( eZTemplateCompiler::isAccumulatorsEnabled() )
            $php->addCodePiece( "eZDebug::accumulatorStart( 'template_compiled_execution', 'template_total', 'Template compiled execution', true );\n" );
        if ( eZTemplateCompiler::isTimingPointsEnabled() )
            $php->addCodePiece( "eZDebug::addTimingPoint( 'Script start $cacheFileName' );\n" );

//         $php->addCodePiece( "if ( !isset( \$vars ) )\n    \$vars =& \$tpl->Variables;\n" );
//         $php->addSpace();

        $parameters = array();
        $textName = eZTemplateCompiler::currentTextName( $parameters );

//         $php->addCodePiece( "if ( !isset( \$$textName ) )\n    \$$textName = '';\n" );
//         $php->addSpace();

//         $variableStats = array();
//         eZTemplateCompiler::prepareVariableStatistics( $tpl, $resourceData, $variableStats );
//         eZTemplateCompiler::calculateVariableStatistics( $tpl, $rootNode, $resourceData, $variableStats );
//         print_r( $variableStats );

        $transformedTree = array();
        eZTemplateCompiler::processNodeTransformation( $useComments, $php, $tpl, $rootNode, $resourceData, $transformedTree );

        $staticTree = array();
        eZTemplateCompiler::processStaticOptimizations( $useComments, $php, $tpl, $transformedTree, $resourceData, $staticTree );

        $combinedTree = array();
        eZTemplateCompiler::processNodeCombining( $useComments, $php, $tpl, $staticTree, $resourceData, $combinedTree );

        $finalTree = $combinedTree;
        if ( !eZTemplateCompiler::isNodePlacementEnabled() )
            eZTemplateCompiler::processRemoveNodePlacement( $finalTree );

        eZTemplateCompiler::generatePHPCode( $useComments, $php, $tpl, $finalTree, $resourceData );

        if ( eZTemplateCompiler::isTreeEnabled( 'final' ) )
            $php->addVariable( 'finalTree', $finalTree, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'full-tree' => true ) );
        if ( eZTemplateCompiler::isTreeEnabled( 'combined' ) )
            $php->addVariable( 'combinedTree', $combinedTree, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'full-tree' => true ) );
        if ( eZTemplateCompiler::isTreeEnabled( 'static' ) )
            $php->addVariable( 'staticTree', $staticTree, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'full-tree' => true ) );
        if ( eZTemplateCompiler::isTreeEnabled( 'transformed' ) )
            $php->addVariable( 'transformedTree', $transformedTree, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'full-tree' => true ) );
        if ( eZTemplateCompiler::isTreeEnabled( 'original' ) )
            $php->addVariable( 'originalTree', $rootNode, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'full-tree' => true ) );

        if ( eZTemplateCompiler::isTimingPointsEnabled() )
            $php->addCodePiece( "eZDebug::addTimingPoint( 'Script end $cacheFileName' );\n" );
        if ( eZTemplateCompiler::isAccumulatorsEnabled() )
            $php->addCodePiece( "eZDebug::accumulatorStop( 'template_compiled_execution', true );\n" );

        if ( $resourceData['locales'] && count( $resourceData['locales'] ) )
        {
            $php->addCodePiece( 
                'setlocale( LC_CTYPE, $oldLocale_'. md5( $resourceData['template-filename'] ). ' );'. "\n"
            );
        }
        $php->addCodePiece('$setArray = $oldSetArray_'. md5( $resourceData['template-filename'] ). ";\n");

        $php->store();

        return true;
    }

    function prepareVariableStatistics( &$tpl, &$resourceData, &$stats )
    {
//         $path = $resourceData['template-filename'];
//         $info =& $GLOBALS['eZTemplateCompileVariableInfo'][$path];
        if ( isset( $resourceData['variable-info'] ) )
        {
        }
    }

    /*!
    */
    function calculateVariableStatistics( &$tpl, &$node, &$resourceData, &$stats )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            $children = $node[1];
            $namespace = '';
            if ( $children )
            {
                eZTemplateCompiler::calculateVariableStatisticsChildren( $tpl, $children, $resourceData, $namespace, $stats );
            }
        }
        else
            $tpl->error( 'calculateVariableStatistics', "Unknown root type $nodeType, should be " . EZ_TEMPLATE_NODE_ROOT );
    }

    function calculateVariableStatisticsChildren( &$tpl, &$nodeChildren, &$resourceData, $namespace, &$stats )
    {
        foreach ( $nodeChildren as $node )
        {
            if ( !isset( $node[0] ) )
                continue;
            $nodeType = $node[0];
            if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
            {
                $children = $node[1];
                if ( $children )
                {
                    eZTemplateCompiler::calculateVariableStatisticsChildren( $tpl, $children, $resourceData, $namespace, $stats );
                }
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_TEXT )
            {
                $text = $node[2];
                $placement = $node[3];
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
            {
                $variableData = $node[2];
                $variablePlacement = $node[3];
                $variableParameters = false;
                eZTemplateCompiler::calculateVariableNodeStatistics( $tpl, $variableData, $variablePlacement, $resourceData, $namespace, $stats );
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_FUNCTION )
            {
                $functionChildren = $node[1];
                $functionName = $node[2];
                $functionParameters = $node[3];
                $functionPlacement = $node[4];

                if ( !isset( $tpl->Functions[$functionName] ) )
                    continue;

                if ( is_array( $tpl->Functions[$functionName] ) )
                {
                    $tpl->loadAndRegisterOperators( $tpl->Functions[$functionName] );
                }
                $functionObject =& $tpl->Functions[$functionName];
                if ( is_object( $functionObject ) )
                {
                    $hasTransformationSupport = false;
                    $transformChildren = true;
                    if ( method_exists( $functionObject, 'functionTemplateStatistics' ) )
                    {
                        $functionObject->functionTemplateStatistics( $functionName, $node, $tpl, $resourceData, $namespace, $stats );
                    }
                }
            }
        }
    }

    function calculateVariableNodeStatistics( &$tpl, $variableData, $variablePlacement, &$resourceData, $namespace, &$stats )
    {
        if ( !is_array( $variableData ) )
            return false;
        foreach ( $variableData as $variableItem )
        {
            $variableItemType = $variableItem[0];
            $variableItemData = $variableItem[1];
            $variableItemPlacement = $variableItem[2];
            if ( $variableItemType == EZ_TEMPLATE_TYPE_STRING or
                 $variableItemType == EZ_TEMPLATE_TYPE_IDENTIFIER )
            {
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_NUMERIC )
            {
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_ARRAY )
            {
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_BOOLEAN )
            {
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_VARIABLE )
            {
                $variableNamespace = $variableItemData[0];
                $variableNamespaceScope = $variableItemData[1];
                $variableName = $variableItemData[2];
                if ( $variableNamespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_GLOBAL )
                    $newNamespace = $variableNamespace;
                else if ( $variableNamespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_LOCAL )
                    $newNamespace = $variableNamespace;
                else if ( $variableNamespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE )
                    $newNamespace = $tpl->mergeNamespace( $namespace, $variableNamespace );
                else
                    $newNamespace = false;
                eZTemplateCompiler::setVariableStatistics( $stats, $newNamespace, $variableName, array( 'is_accessed' => true ) );
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_ATTRIBUTE )
            {
                eZTemplateCompiler::calculateVariableNodeStatistics( $tpl, $variableItemData, $variableItemPlacement, $resourceData, $namespace, $stats );
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_OPERATOR )
            {
                $operatorName = $variableItemData[0];

                if ( !isset( $tpl->Operators[$operatorName] ) )
                    continue;

                if ( is_array( $tpl->Operators[$operatorName] ) )
                {
                    $tpl->loadAndRegisterOperators( $tpl->Operators[$operatorName] );
                }
                $operator =& $tpl->Operators[$operatorName];

                if ( is_object( $operator ) )
                {
                    $hasStats = false;
                    if ( method_exists( $operator, 'operatorTemplateHints' ) )
                    {
                        $hints = $operator->operatorTemplateHints();
                        if ( isset( $hints[$operatorName] ) )
                        {
                            $operatorHints = $hints[$operatorName];
                            $hasParameters = false;
                            if ( isset( $operatorHints['parameters'] ) )
                                $hasParameters = $operatorHints['parameters'];
                            if ( $hasParameters === true )
                            {
                                $parameters = $variableItemData;
                                $count = count( $parameters ) - 1;
                                for ( $i = 0; $i < $count; ++$i )
                                {
                                    $parameter =& $parameters[$i + 1];
                                    $parameterData = $parameter[1];
                                    $parameterPlacement = $parameter[2];
                                    eZTemplateCompiler::calculateVariableNodeStatistics( $tpl, $parameter, $parameterPlacement,
                                                                                         $resourceData, $namespace, $stats );
                                }
                            }
                            else if ( is_integer( $hasParameters ) )
                            {
                                $parameters = $variableItemData;
                                $count = min( count( $parameters ) - 1, $hasParameters );
                                for ( $i = 0; $i < $count; ++$i )
                                {
                                    $parameter =& $parameters[$i + 1];
                                    $parameterData = $parameter[1];
                                    $parameterPlacement = $parameter[2];
                                    eZTemplateCompiler::calculateVariableNodeStatistics( $tpl, $parameter, $parameterPlacement,
                                                                                         $resourceData, $namespace, $stats );
                                }
                            }
                            $hasStats = true;
                        }
                    }
                    if ( !$hasStats and method_exists( $operator, 'operatorTemplateStatistics' ) )
                    {
                        $hasStats = $operator->operatorTemplateStatistics( $operatorName, $variableItem, $variablePlacement, $tpl, $resourceData, $namespace, $stats );
                    }
                    if ( !$hasStats and method_exists( $operator, 'namedParameterList' ) )
                    {
                        $namedParameterList = $operator->namedParameterList();
                        if ( method_exists( $operator, 'namedParameterPerOperator' ) and
                             $operator->namedParameterPerOperator() )
                        {
                            $namedParameterList = $namedParameterList[$operatorName];
                        }
                        $operatorParameters = array_slice( $variableItemData, 1 );
                        $count = 0;
                        foreach ( $namedParameterList as $parameterName => $parameterDefinition )
                        {
                            $operatorParameter = $operatorParameters[$count];
                            eZTemplateCompiler::calculateVariableNodeStatistics( $tpl, $operatorParameter, $variablePlacement, $resourceData, $namespace, $stats );
                            ++$count;
                        }
                        $hasStats = true;
                    }
                }
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_VOID )
            {
                $tpl->warning( 'TemplateCompiler::calculateOperatorStatistics', "Void datatype should not be used, ignoring it" );
            }
            else
            {
                $tpl->warning( 'TemplateCompiler::calculateOperatorStatistics', "Unknown data type $variableItemType, ignoring it" );
            }
        }
        return true;
    }

    function setVariableStatistics( &$stats, $namespace, $variableName, $changes )
    {
        if ( isset( $stats['variables'][$namespace][$variableName] ) )
        {
            $variableStats =& $stats['variables'][$namespace][$variableName];
        }
        else
        {
            $variableStats = array( 'is_accessed' => false,
                                    'is_created' => false,
                                    'is_modified' => false,
                                    'is_removed' => false,
                                    'is_local' => false,
                                    'is_input' => false,
                                    'namespace' => $namespace,
                                    'namespace_scope' => false,
                                    'type' => false );
            $stats['variables'][$namespace][$variableName] =& $variableStats;
        }
        if ( isset( $changes['invalid_access'] ) and $changes['invalid_access'] !== false )
            $variableStats['invalid_access'] = $changes['invalid_access'];
        if ( isset( $changes['is_accessed'] ) and $changes['is_accessed'] !== false )
            $variableStats['is_accessed'] = $changes['is_accessed'];
        if ( isset( $changes['is_created'] ) and $changes['is_created'] !== false )
            $variableStats['is_created'] = $changes['is_created'];
        if ( isset( $changes['is_modified'] ) and $changes['is_modified'] !== false )
            $variableStats['is_modified'] = $changes['is_modified'];
        if ( isset( $changes['is_removed'] ) and $changes['is_removed'] !== false )
            $variableStats['is_removed'] = $changes['is_removed'];
        if ( isset( $changes['is_local'] ) and $changes['is_local'] !== false )
            $variableStats['is_local'] = $changes['is_local'];
        if ( isset( $changes['is_input'] ) and $changes['is_input'] !== false )
            $variableStats['is_input'] = $changes['is_input'];
        if ( isset( $changes['namespace'] ) )
            $variableStats['namespace'] = $changes['namespace'];
        if ( isset( $changes['namespace_scope'] ) )
            $variableStats['namespace_scope'] = $changes['namespace_scope'];
        if ( isset( $changes['type'] ) )
            $variableStats['type'] = $changes['type'];
    }

    /*!
     Iterates over the template node tree and tries to combine multiple static siblings
     into one element. The original tree is specified in \a $node and the new
     combined tree will be present in \a $newNode.
     \sa processNodeCombiningChildren
    */
    function processNodeCombining( $useComments, &$php, &$tpl, &$node, &$resourceData, &$newNode )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            $children = $node[1];
            $newNode[0] = $nodeType;
            $newNode[1] = false;
            if ( $children )
            {
                eZTemplateCompiler::processNodeCombiningChildren( $useComments, $php, $tpl, $children, $resourceData, $newNode );
            }
        }
        else
            $tpl->error( 'processNodeCombining', "Unknown root type $nodeType, should be " . EZ_TEMPLATE_NODE_ROOT );
    }

    /*!
     Does node combining on the children \a $nodeChildren.
     \sa processNodeCombining
    */
    function processNodeCombiningChildren( $useComments, &$php, &$tpl, &$nodeChildren, &$resourceData, &$parentNode )
    {
        $newNodeChildren = array();
        $lastNode = false;
        foreach ( $nodeChildren as $node )
        {
            $newNode = false;
            if ( !isset( $node[0] ) )
                continue;
            $nodeType = $node[0];
            if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
            {
                $children = $node[1];
                $newNode = array( $nodeType,
                                  false );
                if ( $children )
                {
                    eZTemplateCompiler::processNodeCombiningChildren( $useComments, $php, $tpl, $children, $resourceData, $newNode );
                }
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_TEXT )
            {
                $text = $node[2];
                $placement = $node[3];

                $newNode = array( $nodeType,
                                  false,
                                  $text,
                                  $placement );
                eZTemplateCompiler::combineStaticNodes( $tpl, $resourceData, $lastNode, $newNode );
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
            {
                $variableCustom = $node[1];
                $variableData = $node[2];
                $variablePlacement = $node[3];
                $variableParameters = false;
                $dataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                           $variableData, $variablePlacement,
                                                                           $resourceData );
                $newNode = $node;
                $newNode[1] = $variableCustom;
                unset( $dataInspection );
                eZTemplateCompiler::combineStaticNodes( $tpl, $resourceData, $lastNode, $newNode );
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_FUNCTION )
            {
                $functionChildren = $node[1];
                $functionName = $node[2];
                $functionParameters = $node[3];
                $functionPlacement = $node[4];

                $newNode = array( $nodeType,
                                  false,
                                  $functionName,
                                  $functionParameters,
                                  $functionPlacement );
                if ( isset( $node[5] ) )
                    $newNode[5] = $node[5];

                if ( is_array( $functionChildren ) )
                {
                    eZTemplateCompiler::processNodeCombiningChildren( $useComments, $php, $tpl,
                                                                          $functionChildren, $resourceData, $newNode );
                }

            }
            else
                $newNode = $node;
            if ( $lastNode != false )
            {
                $newNodeChildren[] = $lastNode;
                $lastNode = false;
            }
            if ( $newNode != false )
                $lastNode = $newNode;
        }
        if ( $lastNode != false )
        {
            $newNodeChildren[] = $lastNode;
            $lastNode = false;
        }
        $parentNode[1] = $newNodeChildren;
    }

    /*!
     Tries to combine the node \a $lastNode and the node \a $newNode
     into one new text node. If possible the new node is created in \a $newNode
     and \a $lastNode will be set to \c false.
     Combining nodes only works for text nodes and variable nodes without
     variable lookup, attributes and operators.
    */
    function combineStaticNodes( &$tpl, &$resourceData, &$lastNode, &$newNode )
    {
        if ( $lastNode == false or
             $newNode == false )
            return false;
        $lastNodeType = $lastNode[0];
        $newNodeType = $newNode[0];
        if ( !in_array( $lastNodeType, array( EZ_TEMPLATE_NODE_TEXT,
                                              EZ_TEMPLATE_NODE_VARIABLE ) ) or
             !in_array( $newNodeType, array( EZ_TEMPLATE_NODE_TEXT,
                                             EZ_TEMPLATE_NODE_VARIABLE ) ) )
            return false;
        if ( $lastNodeType == EZ_TEMPLATE_NODE_VARIABLE )
        {
            if ( is_array( $lastNode[1] ) )
                return false;
            $lastDataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                           $lastNode[2], $lastNode[3],
                                                                           $resourceData );
            if ( !$lastDataInspection['is-constant'] or
                 $lastDataInspection['is-variable'] or
                 $lastDataInspection['has-attributes'] or
                 $lastDataInspection['has-operators'] )
                return false;
            if ( isset( $lastNode[4] ) and
                 isset( $lastNode[4]['text-result'] ) and
                 !$lastNode[4]['text-result'] )
                return false;
        }
        if ( $newNodeType == EZ_TEMPLATE_NODE_VARIABLE )
        {
            if ( is_array( $newNode[1] ) )
                return false;
            $newDataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                          $newNode[2], $newNode[3],
                                                                          $resourceData );
            if ( !$newDataInspection['is-constant'] or
                 $newDataInspection['is-variable'] or
                 $newDataInspection['has-attributes'] or
                 $newDataInspection['has-operators'] )
                return false;
            if ( isset( $newNode[4] ) and
                 isset( $newNode[4]['text-result'] ) and
                 !$newNode[4]['text-result'] )
                return false;
            if ( isset( $newNode[1] ) and
                 $newNode[1] !== false )
                return false;
        }
        $textElements = array();
        $lastNodeData = eZTemplateCompiler::staticNodeData( $lastNode );
        $newNodeData = eZTemplateCompiler::staticNodeData( $newNode );
        $tpl->appendElementText( $textElements, $lastNodeData, false, false );
        $tpl->appendElementText( $textElements, $newNodeData, false, false );
        $newData = implode( '', $textElements );
        $newPlacement = $lastNode[3];
        if ( !is_array( $newPlacement ) )
        {
            $newPlacement = $newNode[3];
        }
        else
        {
            $newPlacement[1][0] = $newNode[3][1][0]; // Line end
            $newPlacement[1][1] = $newNode[3][1][1]; // Column end
            $newPlacement[1][2] = $newNode[3][1][2]; // Position end
        }
        $lastNode = false;
        $newNode = array( EZ_TEMPLATE_NODE_TEXT,
                          false,
                          $newData,
                          $newPlacement );
    }

    /*!
     \return the static data for the node \a $node or \c false if
             no data could be fetched.
             Will only return data from text nodes and variables nodes
             without variable lookup, attribute lookup or operators.
    */
    function staticNodeData( $node )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_TEXT )
        {
            return $node[2];
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
        {
            $data = $node[2];
            if ( is_array( $data ) and
                 count( $data ) > 0 )
            {
                $dataType = $data[0][0];
                if ( $dataType == EZ_TEMPLATE_TYPE_STRING or
                     $dataType == EZ_TEMPLATE_TYPE_NUMERIC or
                     $dataType == EZ_TEMPLATE_TYPE_IDENTIFIER or
                     $dataType == EZ_TEMPLATE_TYPE_ARRAY or
                     $dataType == EZ_TEMPLATE_TYPE_BOOLEAN )
                {
                    return $data[0][1];
                }
            }
        }
        return null;
    }

    /*!
     Iterates over the items in the tree \a $node and tries to extract static data
     from operators which supports it.
    */
    function processStaticOptimizations( $useComments, &$php, &$tpl, &$node, &$resourceData, &$newNode )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            $children = $node[1];
            $newNode[0] = $nodeType;
            $newNode[1] = false;
            if ( $children )
            {
                $newNode[1] = array();
                foreach ( $children as $child )
                {
                    $newChild = array();
                    eZTemplateCompiler::processStaticOptimizations( $useComments, $php, $tpl, $child, $resourceData, $newChild );
                    $newNode[1][] = $newChild;
                }
            }
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_TEXT )
        {
            $text = $node[2];
            $placement = $node[3];

            $newNode[0] = $nodeType;
            $newNode[1] = false;
            $newNode[2] = $text;
            $newNode[3] = $placement;
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
        {
            $variableCustom = $node[1];
            $variableData = $node[2];
            $variablePlacement = $node[3];
            $dataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                       $variableData, $variablePlacement,
                                                                       $resourceData );
            if ( isset( $dataInspection['new-data'] ) )
            {
                $variableData = $dataInspection['new-data'];
            }
            $newNode = $node;
            $newNode[1] = $variableCustom;
            $newNode[2] = $variableData;
            unset( $dataInspection );
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_FUNCTION )
        {
            $functionChildren = $node[1];
            $functionName = $node[2];
            $functionParameters = $node[3];
            $functionPlacement = $node[4];

            $newFunctionChildren = array();
            if ( is_array( $functionChildren ) )
            {
                foreach ( $functionChildren as $functionChild )
                {
                    $newChild = array();
                    eZTemplateCompiler::processStaticOptimizations( $useComments, $php, $tpl,
                                                                        $functionChild, $resourceData, $newChild );
                    $newFunctionChildren[] = $newChild;
                }
                $functionChildren = $newFunctionChildren;
            }

            $newFunctionParameters = array();
            if ( $functionParameters )
            {
                foreach ( $functionParameters as $functionParameterName => $functionParameterData )
                {
                    $dataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                                   $functionParameterData, false,
                                                                                   $resourceData );
                    if ( isset( $dataInspection['new-data'] ) )
                    {
                        $functionParameterData = $dataInspection['new-data'];
                    }
                    $newFunctionParameters[$functionParameterName] = $functionParameterData;
                }
                $functionParameters = $newFunctionParameters;
            }

            $newNode[0] = $nodeType;
            $newNode[1] = $functionChildren;
            $newNode[2] = $functionName;
            $newNode[3] = $functionParameters;
            $newNode[4] = $functionPlacement;
            if ( isset( $node[5] ) )
                $newNode[5] = $node[5];
        }
        else
            $newNode = $node;
    }

    /*!
     Iterates over the template node tree \a $node and returns a new transformed
     tree in \a $newNode.
     \sa processNodeTransformationRoot, processNodeTransformationChild
    */
    function processNodeTransformation( $useComments, &$php, &$tpl, &$node, &$resourceData, &$newNode )
    {
        $newNode = eZTemplateCompiler::processNodeTransformationRoot( $useComments, $php, $tpl, $node, $resourceData );
    }

    /*!
     Iterates over the nodes \a $nodes and does transformation on them.
     \sa processNodeTransformationChildren
     \note This method can be called from operator and functions as long as they have the \a $privateData parameter.
    */
    function processNodeTransformationNodes( &$tpl, &$node, &$nodes, &$privateData )
    {
        $useComments = $privateData['use-comments'];
        $php =& $privateData['php-creator'];
        $resourceData =& $privateData['resource-data'];
        return eZTemplateCompiler::processNodeTransformationChildren( $useComments, $php, $tpl, $node, $nodes, $resourceData );
    }

    /*!
     Iterates over the children \a $children and does transformation on them.
     \sa processNodeTransformation, processNodeTransformationChild
    */
    function processNodeTransformationChildren( $useComments, &$php, &$tpl, &$node, &$children, &$resourceData )
    {
        if ( $children )
        {
            $newChildren = array();
            foreach ( $children as $childNode )
            {
                $newChildNode = eZTemplateCompiler::processNodeTransformationChild( $useComments, $php, $tpl, $childNode, $resourceData );
                if ( !$newChildNode )
                    $newChildren[] = $childNode;
                else
                    $newChildren = array_merge( $newChildren, $newChildNode );
            }
            if ( count( $newChildren ) > 0 )
                return $newChildren;
        }
        return $children;
    }

    /*!
     Iterates over the children of the root node \a $node and does transformation on them.
     \sa processNodeTransformation, processNodeTransformationChild
    */
    function processNodeTransformationRoot( $useComments, &$php, &$tpl, &$node, &$resourceData )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            $children = $node[1];
            $newNode = array( $nodeType,
                              false );
            if ( $children )
            {
                $newChildren = array();
                foreach ( $children as $childNode )
                {
                    $newChildNode = eZTemplateCompiler::processNodeTransformationChild( $useComments, $php, $tpl, $childNode, $resourceData );
                    if ( !$newChildNode )
                        $newChildren[] = $childNode;
                    else
                        $newChildren = array_merge( $newChildren, $newChildNode );
                }
                if ( count( $newChildren ) > 0 )
                    $newNode[1] = $newChildren;
            }
            return $newNode;
        }
        else
            $tpl->error( 'processNodeTransformation', "Unknown root type $nodeType, should be " . EZ_TEMPLATE_NODE_ROOT );
        return false;
    }

    /*!
     Iterates over the children of the function node \a $node and transforms the tree.
     If the node is not a function it will return \c false.
     \sa processNodeTransformationRoot, processNodeTransformationChild
    */
    function processNodeTransformationChild( $useComments, &$php, &$tpl, &$node, &$resourceData )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_FUNCTION )
        {
            $nodeCopy = $node;
            $functionChildren = $node[1];
            $functionName = $node[2];
            $functionParameters = $node[3];
            $functionPlacement = $node[4];
            if ( !isset( $tpl->Functions[$functionName] ) )
                return false;

            if ( is_array( $tpl->Functions[$functionName] ) )
            {
                $tpl->loadAndRegisterFunctions( $tpl->Functions[$functionName] );
            }
            $functionObject =& $tpl->Functions[$functionName];
            if ( is_object( $functionObject ) )
            {
                $hasTransformationSupport = false;
                $transformChildren = true;
                $transformParameters = false;
                if ( method_exists( $functionObject, 'functionTemplateHints' ) )
                {
                    $hints = $functionObject->functionTemplateHints();
                    if ( isset( $hints[$functionName] ) and
                         isset( $hints[$functionName]['tree-transformation'] ) and
                         $hints[$functionName]['tree-transformation'] )
                        $hasTransformationSupport = true;
                    if ( isset( $hints[$functionName] ) and
                         isset( $hints[$functionName]['transform-children'] ) )
                        $transformChildren = $hints[$functionName]['transform-children'];
                    if ( isset( $hints[$functionName] ) and
                         isset( $hints[$functionName]['transform-parameters'] ) )
                        $transformParameters = $hints[$functionName]['transform-parameters'];
                }
                if ( $hasTransformationSupport and
                     method_exists( $functionObject, 'templateNodeTransformation' ) )
                {
                    if ( $transformChildren and
                         $functionChildren )
                    {
                        $newChildren = array();
                        foreach ( $functionChildren as $childNode )
                        {
                            $newChildNode = eZTemplateCompiler::processNodeTransformationChild( $useComments, $php, $tpl, $childNode, $resourceData );
                            if ( !$newChildNode )
                                $newChildren[] = $childNode;
                            else if ( !is_array( $newChildNode ) )
                                $newChildren[] = $newChildNode;
                            else
                                $newChildren = array_merge( $newChildren, $newChildNode );
                        }
                        if ( count( $newChildren ) > 0 )
                            $node[1] = $newChildren;
                    }

                    if ( $transformParameters and
                         $functionParameters )
                    {
                        $newParameters = array();
                        foreach ( $functionParameters as $parameterName => $parameterElementList )
                        {
                            $elementTree = $parameterElementList;
                            $elementList = $elementTree;
                            $newParamNode = eZTemplateCompiler::processElementTransformationChild( $useComments, $php, $tpl, $node,
                                                                                                   $elementTree, $elementList, $resourceData );
                            if ( !$newParamNode || !is_array( $newParamNode ) )
                                $newParameters[$parameterName] = $parameterElementList;
                            else
                                $newParameters[$parameterName] = $newParamNode;
                        }
                        if ( count( $newParameters ) > 0 )
                        {
                            $node[3] = $newParameters;
                            $functionParameters = $newParameters;
                        }
                    }

                    $privateData = array( 'use-comments' => $useComments,
                                          'php-creator' => &$php,
                                          'resource-data' => &$resourceData );
                    $newNodes = $functionObject->templateNodeTransformation( $functionName, $node,
                                                                             $tpl, $functionParameters, $privateData );
                    unset( $privateData );
                    if ( !$newNodes )
                    {
                        $node = $nodeCopy;
                        $node[1] = $functionChildren;
                        return false;
                        return $node;
                    }
                    return $newNodes;
                }
            }
            return false;
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
        {
            $elementTree = $node[2];
            $elementList = $elementTree;

            $newParameterElements = eZTemplateCompiler::processElementTransformationChild( $useComments, $php, $tpl, $node,
                                                                                           $elementTree, $elementList, $resourceData );
            if ( $newParameterElements )
            {
                $newNode = $node;
                $newNode[2] = $newParameterElements;
                $newNodes = array( $newNode );
                return $newNodes;
            }
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            return eZTemplateCompiler::processNodeTransformationRoot( $useComments, $php, $tpl, $node, $resourceData );
        }
        else
            return false;
    }

    /*!
     Iterates over the element list \a $elements and transforms them.
     \sa processElementTransformationChild
    */
    function processElementTransformationList( &$tpl, &$node, &$elements, &$privateData )
    {
        $useComments = $privateData['use-comments'];
        $php =& $privateData['php-creator'];
        $resourceData =& $privateData['resource-data'];
        $elementTree = $elements;
        $newElements = eZTemplateCompiler::processElementTransformationChild( $useComments, $php, $tpl, $node,
                                                                              $elementTree, $elements, $resourceData );
        if ( $newElements )
            return $newElements;
        return $elements;
    }

    /*!
     Iterates over the children of the function node \a $node and transforms the tree.
     If the node is not a function it will return \c false.
     \sa processNodeTransformationRoot, processNodeTransformationChild
    */
    function processElementTransformationChild( $useComments, &$php, &$tpl, &$node,
                                                &$elementTree, &$elementList, &$resourceData )
    {
        $count = count( $elementList );
        $lastElement = null;
        $newElementList = array();
        for ( $i = 0; $i < $count; ++$i )
        {
            $element =& $elementList[$i];
            $elementType = $element[0];
            if ( $elementType == EZ_TEMPLATE_TYPE_OPERATOR )
            {
                $operatorName = $element[1][0];
                $operatorParameters = array_slice( $element[1], 1 );
                if ( !isset( $tpl->Operators[$operatorName] ) )
                    return false;

                if ( is_array( $tpl->Operators[$operatorName] ) )
                {
                    $tpl->loadAndRegisterOperators( $tpl->Operators[$operatorName] );
                }
                $operatorObject =& $tpl->Operators[$operatorName];
                if ( is_object( $operatorObject ) )
                {
                    $hasTransformationSupport = false;
                    $transformParameters = false;
                    $inputAsParameter = false;
                    $knownType = 'static';
                    if ( method_exists( $operatorObject, 'operatorTemplateHints' ) )
                    {
                        $hints = $operatorObject->operatorTemplateHints();
                        if ( isset( $hints[$operatorName] ) and
                             isset( $hints[$operatorName]['element-transformation'] ) and
                             $hints[$operatorName]['element-transformation'] )
                        {
                            $hasTransformationSupport = true;
                        }

                        if ( $hasTransformationSupport  and
                             isset( $hints[$operatorName]['element-transformation-func'] ) )
                        {
                            $transformationMethod = $hints[$operatorName]['element-transformation-func'];
                        }
                        else
                        {
                            $transformationMethod = 'templateElementTransformation';
                        }

                        if ( isset( $hints[$operatorName] ) and
                             isset( $hints[$operatorName]['transform-parameters'] ) )
                        {
                            $transformParameters = $hints[$operatorName]['transform-parameters'];
                        }

                        if ( isset( $hints[$operatorName] ) and
                             isset( $hints[$operatorName]['input-as-parameter'] ) )
                        {
                            $inputAsParameter = $hints[$operatorName]['input-as-parameter'];
                        }

                        if ( isset( $hints[$operatorName]['output'] ) and !$hints[$operatorName]['output'] )
                        {
                            $knownType = 'null';
                        }
                        else if ( isset( $hints[$operatorName]['output-type'] ) )
                        {
                            $knownType = $hints[$operatorName]['output-type'];
                        }
                    }
                    if ( $hasTransformationSupport and
                         method_exists( $operatorObject, $transformationMethod ) )
                    {
                        $resetNewElementList = false;
                        if ( $transformParameters )
                        {
                            $newParameters = array();
                            if ( $inputAsParameter )
                            {
                                $newParameterElements = eZTemplateCompiler::processElementTransformationChild( $useComments, $php, $tpl, $node,
                                                                                                               $elementTree, $newElementList, $resourceData );
                                if ( count( $newParameterElements ) > 0 or
                                     $inputAsParameter === 'always' )
                                {
                                    $newParameters[] = $newParameterElements;
                                    $resetNewElementList = true;
                                }
                            }

                            foreach ( $operatorParameters as $operatorParameter )
                            {
                                $newParameterElements = eZTemplateCompiler::processElementTransformationChild( $useComments, $php, $tpl, $node,
                                                                                                               $elementTree, $operatorParameter, $resourceData );
                                if ( !$newParameterElements )
                                    $newParameters[] = $operatorParameter;
                                else
                                    $newParameters[] = $newParameterElements;
                            }
                            $operatorParameters = $newParameters;
                        }

                        $newElements = $operatorObject->$transformationMethod( $operatorName, $node, $tpl, $resourceData,
                                                                               $element, $lastElement, $elementList, $elementTree,
                                                                               $operatorParameters );
                        if ( is_array( $newElements ) )
                        {
                            if ( $resetNewElementList )
                            {
                                $newElementList = $newElements;
                            }
                            else
                            {
                                $newElementList = array_merge( $newElementList, $newElements );
                            }
                        }
                        else
                        {
                            $newElementList[] = $element;
                        }
                    }
                    else
                    {
                        $newElementList[] = $element;
                    }
                }
            }
            else
            {
                $newElementList[] = $element;
            }
            $lastElement = $element;
        }
        return $newElementList;
    }

    /*!
     Iterates over the node tree and removes all placement information.
    */
    function processRemoveNodePlacement( &$node )
    {
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            $nodeChildren =& $node[1];
            for ( $i = 0; $i < count( $nodeChildren ); ++$i )
            {
                $nodeChild =& $nodeChildren[$i];
                eZTemplateCompiler::processRemoveNodePlacement( $nodeChild );
            }
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_TEXT )
        {
            $node[3] = false;
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
        {
            $node[3] = false;
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_FUNCTION )
        {
            $node[4] = false;
            $nodeChildren =& $node[1];
            if ( $nodeChildren )
            {
                for ( $i = 0; $i < count( $nodeChildren ); ++$i )
                {
                    $nodeChild =& $nodeChildren[$i];
                    eZTemplateCompiler::processRemoveNodePlacement( $nodeChild );
                }
            }
        }
        else if ( $nodeType == EZ_TEMPLATE_NODE_OPERATOR )
        {
        }
    }

    /*!
     Looks over the variable data \a $variableData and returns an array with
     information on the structure.
     The following entries are generated.
     - is-constant - true if the variable data contains constant data like text and numerics
     - is-variable - true if the variable data is a variable lookup
     - has-operators - true if operators are present
     - has-attributes - true if attributes are used
    */
    function inspectVariableData( &$tpl, $variableData, $variablePlacement, &$resourceData )
    {
        $dataInspection = array( 'is-constant' => false,
                                 'is-variable' => false,
                                 'has-operators' => false,
                                 'has-attributes' => false );
        if ( !is_array( $variableData ) )
            return $dataInspection;
        $newVariableData = array();
        // Static optimizations, the following items are done:
        // - Recognize static data
        // - Extract static data, if possible, from operators
        // - Remove parameters and input which not be used.
        foreach ( $variableData as $variableItem )
        {
            $variableItemType = $variableItem[0];
            $variableItemData = $variableItem[1];
            $variableItemPlacement = $variableItem[2];
            if ( $variableItemType == EZ_TEMPLATE_TYPE_STRING or
                 $variableItemType == EZ_TEMPLATE_TYPE_IDENTIFIER )
            {
                $dataInspection['is-constant'] = true;
                $dataInspection['is-variable'] = false;
                $newVariableData[] = $variableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_NUMERIC )
            {
                $dataInspection['is-constant'] = true;
                $dataInspection['is-variable'] = false;
                $newVariableData[] = $variableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_BOOLEAN )
            {
                $dataInspection['is-constant'] = true;
                $dataInspection['is-variable'] = false;
                $newVariableData[] = $variableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_DYNAMIC_ARRAY )
            {
                $dataInspection['is-constant'] = false;
                $dataInspection['is-variable'] = true;
                $newVariableData[] = $variableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_ARRAY )
            {
                $dataInspection['is-constant'] = true;
                $dataInspection['is-variable'] = false;
                $newVariableData[] = $variableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_VARIABLE )
            {
                $dataInspection['is-constant'] = false;
                $dataInspection['is-variable'] = true;
                $newVariableData[] = $variableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_ATTRIBUTE )
            {
                $dataInspection['has-attributes'] = true;
                $newDataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                                  $variableItemData, $variableItemPlacement,
                                                                                  $resourceData );
                if ( isset( $newDataInspection['new-data'] ) )
                {
                    $variableItemData = $newDataInspection['new-data'];
                }
                $variableItem[1] = $variableItemData;
                unset( $newDataInspection );
                $newVariableData[] = $variableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_OPERATOR )
            {
                $dataInspection['has-operators'] = true;
                $operatorName = $variableItemData[0];
                $operatorHint = eZTemplateCompiler::operatorHint( $tpl, $operatorName );
                $newVariableItem = $variableItem;
                if ( $operatorHint and
                     isset( $operatorHint['input'] ) and
                     isset( $operatorHint['output'] ) and
                     isset( $operatorHint['parameters'] ) )
                {
                    if ( !$operatorHint['input'] and
                         $operatorHint['output'] )
                        $newVariableData = array();
                    if ( !isset( $operatorHint) or !$operatorHint['parameters'] )
                        $newVariableItem[1] = array( $operatorName );
                    if ( isset ( $operatorHint['static'] ) and
                         $operatorHint['static'] )
                    {
                        $operatorStaticData = eZTemplateCompiler::operatorStaticData( $tpl, $operatorName );
                        $newVariableItem = eZTemplateCompiler::createStaticVariableData( $tpl, $operatorStaticData, $variableItemPlacement );
                        $dataInspection['is-constant'] = true;
                        $dataInspection['is-variable'] = false;
                        $dataInspection['has-operators'] = false;
                    }
                }
                if ( $newVariableItem[0] == EZ_TEMPLATE_TYPE_OPERATOR )
                {
                    $tmpVariableItem = $newVariableItem[1];
                    $newVariableItem[1] = array( $operatorName );
                    for ( $i = 1; $i < count( $tmpVariableItem ); ++$i )
                    {
                        $operatorParameter = $tmpVariableItem[$i];
                        $newDataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                                          $operatorParameter, false,
                                                                                          $resourceData );
                        if ( isset( $newDataInspection['new-data'] ) )
                        {
                            $operatorParameter = $newDataInspection['new-data'];
                        }
                        $newVariableItem[1][] = $operatorParameter;
                    }
                }
                $newVariableData[] = $newVariableItem;
            }
            else if ( $variableItemType == EZ_TEMPLATE_TYPE_VOID )
            {
                $tpl->warning( 'TemplateCompiler', "Void datatype should not be used, ignoring it" );
            }
            else if ( $variableItemType > EZ_TEMPLATE_TYPE_INTERNAL and
                      $variableItemType < EZ_TEMPLATE_TYPE_INTERNAL_STOP )
            {
                $newVariableData[] = $variableItem;
            }
            else
            {
                $tpl->warning( 'TemplateCompiler', "Unknown data type $variableItemType, ignoring it" );
            }
        }
        $dataInspection['new-data'] = $newVariableData;
        return $dataInspection;
    }

    /*!
     \return the operator hint for the operator \a $operatorName, or \c false if
             the operator does not exist or has no hints.
    */
    function operatorHint( &$tpl, $operatorName )
    {
        if ( isset( $tpl->Operators[$operatorName] ) and
             is_array( $tpl->Operators[$operatorName] ) )
        {
            $tpl->loadAndRegisterOperators( $tpl->Operators[$operatorName] );
        }
        $operatorObject =& $tpl->Operators[$operatorName];
        $operatorHint = false;
        if ( is_object( $operatorObject ) )
        {
            if ( method_exists( $operatorObject, 'operatorTemplateHints' ) )
            {
                $operatorHintArray = $operatorObject->operatorTemplateHints();
                if ( isset( $operatorHintArray[$operatorName] ) )
                {
                    $operatorHint = $operatorHintArray[$operatorName];
                }
            }
        }
        return $operatorHint;
    }

    /*!
     \return static data from operators which support returning static data,
             or \c null if no static data could be extracted.
             The operator is specified in \a $operatorName.

    */
    function operatorStaticData( &$tpl, $operatorName )
    {
        if ( is_array( $tpl->Operators[$operatorName] ) )
        {
            $tpl->loadAndRegisterOperators( $tpl->Operators[$operatorName] );
        }
        $operatorObject =& $tpl->Operators[$operatorName];
        $operatorData = null;
        if ( is_object( $operatorObject ) )
        {
            if ( method_exists( $operatorObject, 'operatorCompiledStaticData' ) )
            {
                $operatorData = $operatorObject->operatorCompiledStaticData( $operatorName );
            }
        }
        return $operatorData;
    }

    /*!
     Creates a variable data element for the data \a $staticData and returns it.
     The type of element depends on the type of the data, strings and booleans
     are returned as EZ_TEMPLATE_TYPE_TEXT and EZ_TEMPLATE_TYPE_NUMERIC while other
     types are turned into text and returned as EZ_TEMPLATE_TYPE_TEXT.
    */
    function createStaticVariableData( &$tpl, $staticData, $variableItemPlacement )
    {
        if ( is_string( $staticData ) )
            return array( EZ_TEMPLATE_TYPE_TEXT,
                          $staticData,
                          $variableItemPlacement );
        else if ( is_bool( $staticData ) )
            return array( EZ_TEMPLATE_TYPE_BOOLEAN,
                          $staticData,
                          $variableItemPlacement );
        else if ( is_bool( $staticData ) or is_numeric( $staticData ) )
            return array( EZ_TEMPLATE_TYPE_NUMERIC,
                          $staticData,
                          $variableItemPlacement );
        else if ( is_array( $staticData ) )
            return array( EZ_TEMPLATE_TYPE_ARRAY,
                          $staticData,
                          $variableItemPlacement );
        else
            return array( EZ_TEMPLATE_TYPE_TEXT,
                          "$staticData",
                          $variableItemPlacement );
    }

    /*!
     Opens the template files specified in \a $placementData
     and fetches the text portion defined by the
     start and end position. The text is returned or \c null if the
     text could not be fetched.
    */
    function fetchTemplatePiece( $placementData )
    {
        if ( !isset( $placementData[0] ) or
             !isset( $placementData[1] ) or
             !isset( $placementData[2] ) )
            return null;
        $file = $placementData[2];
        $startPosition = $placementData[0][2];
        $endPosition = $placementData[1][2];
        $length = $endPosition - $startPosition;
        if ( file_exists( $file ) )
        {
            if ( $length > 0 )
            {
                $fd = fopen( $file, 'rb' );
                fseek( $fd, $startPosition );
                $text = fread( $fd, $length );
                fclose( $fd );
                return $text;
            }
            else
            {
                return '';
            }
        }
        return null;
    }

    /*!
     Creates the common.php file which has common functions for compiled templates.
     If the file already exists if will not create it.
    */
    function createCommonCompileTemplate()
    {
        $php = new eZPHPCreator( eZTemplateCompiler::compilationDirectory(), 'common.php' );
        if ( $php->exists() )
            return;

        $php->addComment( "This file contains functions which are common to all compiled templates.\n\n" .
                          'NOTE: This file is autogenerated and should not be modified, any changes will be lost!' );
        $php->addSpace();
        $php->addDefine( 'EZ_TEMPLATE_COMPILER_COMMON_CODE', true );
        $php->addSpace();

        $namespaceStack = array();
        $php->addCodePiece( "if ( !isset( \$namespaceStack ) )\n" );
        $php->addVariable( 'namespaceStack', $namespaceStack, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'spacing' => 4 ) );
        $php->addSpace();

        $lbracket = '{';
        $rbracket = '}';
        $initText = "if ( !function_exists( 'compiledfetchvariable' ) )
$lbracket
    function compiledFetchVariable( &\$vars, \$namespace, \$name )
    $lbracket
        \$exists = ( array_key_exists( \$namespace, \$vars ) and
                    array_key_exists( \$name, \$vars[\$namespace] ) );
        if ( \$exists )
        $lbracket
            \$var = \$vars[\$namespace][\$name];
        $rbracket
        else
            \$var = null;
        return \$var;
    $rbracket
$rbracket
if ( !function_exists( 'compiledfetchtext' ) )
$lbracket
    function compiledFetchText( &\$tpl, \$rootNamespace, \$currentNamespace, \$namespace, &\$var )
    $lbracket
        \$text = '';
        \$tpl->appendElement( \$text, \$var, \$rootNamespace, \$currentNamespace );
        return \$text;
    $rbracket
$rbracket
if ( !function_exists( 'compiledAcquireResource' ) )
$lbracket
    function compiledAcquireResource( \$phpScript, \$key, &\$originalText,
                                      &\$tpl, \$rootNamespace, \$currentNamespace )
    {
        include( \$phpScript );
        if ( isset( \$text ) )
        {
            \$originalText .= \$text;
            return true;
        }
        return false;
    }
$rbracket
if ( !function_exists( 'compiledfetchattribute' ) )
$lbracket
    function compiledFetchAttribute( &\$value, \$attributeValue )
    $lbracket
        if ( is_object( \$value ) )
        $lbracket
            if ( method_exists( \$value, \"attribute\" ) and
                 method_exists( \$value, \"hasattribute\" ) )
            $lbracket
                if ( \$value->hasAttribute( \$attributeValue ) )
                $lbracket
                    unset( \$tempValue );
                    \$tempValue = \$value->attribute( \$attributeValue );
                    return \$tempValue;
                $rbracket
            $rbracket
        $rbracket
        else if ( is_array( \$value ) )
        $lbracket
            if ( isset( \$value[\$attributeValue] ) )
            $lbracket
                unset( \$tempValue );
                \$tempValue = \$value[\$attributeValue];
                return \$tempValue;
            $rbracket
        $rbracket
        return null;
    $rbracket
$rbracket
";
        $php->addCodePiece( $initText );
        $php->store();
    }

    /*!
     Figures out the current text name to use in compiled template code and return it.
     The names will be text, text1, text2 etc.
    */
    function currentTextName( $parameters )
    {
        $textData = array( 'variable' => 'text',
                           'counter' => 0 );
        if ( isset( $parameters['text-data'] ) )
            $textData = $parameters['text-data'];
        $name = $textData['variable'];
        if ( $textData['counter'] > 0 )
            $name .= $textData['counter'];
        return $name;
    }

    /*!
     Increases the counter for the current text name, this ensure a uniqe name for it.
    */
    function increaseCurrentTextName( &$parameters )
    {
        $textData = array( 'variable' => 'text',
                           'counter' => 0 );
        if ( !isset( $parameters['text-data'] ) )
            $parameters['text-data'] = $textData;

        $parameters['text-data']['counter']++;
    }

    /*!
     Decreases a previosuly increased counter for the current text name.
    */
    function decreaseCurrentTextName( &$parameters )
    {
        $textData = array( 'variable' => 'text',
                           'counter' => 0 );
        if ( !isset( $parameters['text-data'] ) )
        {
            $parameters['text-data'] = $textData;
            return;
        }

        $parameters['text-data']['counter']--;
    }

    function boundVariableName( $variableID, $parameters )
    {
        $bindMap =& $parameters['variable-bind']['map'][$variableID];
        if ( isset( $bindMap ) )
            $bindMap = array();
    }

    /*!
     Generates the PHP code defined in the template node tree \a $node.
     The code is generated using the php creator specified in \a $php.
    */

    function generatePHPCode( $useComments, &$php, &$tpl, &$node, &$resourceData )
    {
        $parameters = array();
        $currentParameters = array( 'spacing' => 0 );
        $nodeType = $node[0];
        if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
        {
            $children = $node[1];
            if ( $children )
            {
                eZTemplateCompiler::generatePHPCodeChildren( $useComments, $php, $tpl, $children, $resourceData, $parameters, $currentParameters );
            }
        }
        else
            $tpl->error( 'generatePHPCode', "Unknown root type $nodeType, should be " . EZ_TEMPLATE_NODE_ROOT );
        $php->addSpace();
    }

    /*!
     Generates the PHP code for all node children specified in \a $nodeChildren.
     \sa generatePHPCode
    */
    function generatePHPCodeChildren( $useComments, &$php, &$tpl, &$nodeChildren, &$resourceData, &$parameters, $currentParameters )
    {
        foreach ( $nodeChildren as $node )
        {
            $newNode = false;
            $nodeType = $node[0];
            if ( $nodeType > EZ_TEMPLATE_NODE_USER_CUSTOM )
            {
                // Do custom nodes
            }
            else if ( $nodeType > EZ_TEMPLATE_NODE_INTERNAL )
            {
                // Do custom internal nodes
                if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_CODE_PIECE )
                {
                    $codePiece = $node[1];
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[2]['spacing'] ) )
                        $spacing += $node[2]['spacing'];
                    $php->addCodePiece( $codePiece, array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_WARNING )
                {
                    $warningText = $php->variableText( $node[1], 23, 0, false );
                    $warningLabel = false;
                    $warningLabelText = '';
                    if ( isset( $node[2] ) )
                        $warningLabelText = $php->variableText( $node[2], 0, 0, false );
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[3]['spacing'] ) )
                        $spacing += $node[3]['spacing'];
                    $placementText = 'false';
                    if ( isset( $node[4] ) )
                        $placementText = $php->variableText( $node[4], 0, 0, false );
                    $php->addCodePiece( "\$tpl->warning( " . $warningLabelText . ", " . $warningText . ", " . $placementText . " );", array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_ERROR )
                {
                    $errorText = $php->variableText( $node[1], 21, 0, false );
                    $errorLabel = false;
                    $errorLabelText = '';
                    if ( isset( $node[2] ) )
                        $errorLabelText = $php->variableText( $node[2], 0, 0, false );
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[3]['spacing'] ) )
                        $spacing += $node[3]['spacing'];
                    $placementText = 'false';
                    if ( isset( $node[4] ) )
                        $placementText = $php->variableText( $node[4], 0, 0, false );
                    $php->addCodePiece( "\$tpl->error( " . $errorLabelText . ", " . $errorText . ", " . $placementText . " );", array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_READ )
                {
                    $variableName = $node[1];
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[2]['spacing'] ) )
                        $spacing += $node[2]['spacing'];
                    $textName = eZTemplateCompiler::currentTextName( $parameters );
                    $assignmentType = $node[3];
                    $assignmentText = $php->variableNameText( $variableName, $assignmentType, $node[2] );
                    $php->addCodePiece( "$assignmentText\$$textName;", array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_ASSIGN )
                {
                    $variableName = $node[1];
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[2]['spacing'] ) )
                        $spacing += $node[2]['spacing'];
                    $textName = eZTemplateCompiler::currentTextName( $parameters );
                    $assignmentType = $node[3];
                    $assignmentText = $php->variableNameText( $textName, $assignmentType, $node[2] );
                    $php->addCodePiece( "$assignmentText\$$variableName;", array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_INCREASE )
                {
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[1]['spacing'] ) )
                        $spacing += $node[1]['spacing'];
                    $textName = eZTemplateCompiler::currentTextName( $parameters );
                    $php->addCodePiece( "if ( !isset( \$textStack ) )\n" .
                                        "    \$textStack = array();\n" .
                                        "\$textStack[] = \$$textName;\n" .
                                        "\$$textName = '';", array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_OUTPUT_DECREASE )
                {
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[1]['spacing'] ) )
                        $spacing += $node[1]['spacing'];
                    $textName = eZTemplateCompiler::currentTextName( $parameters );
                    $php->addCodePiece( "\$$textName = array_pop( \$textStack );", array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_SPACING_INCREASE )
                {
                    $spacing = $node[1];
                    $currentParameters['spacing'] += $spacing;
                    continue;
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_SPACING_DECREASE )
                {
                    $spacing = $node[1];
                    $currentParameters['spacing'] -= $spacing;
                    continue;
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_VARIABLE_SET )
                {
                    $variableName = $node[1];
                    $variableValue = $node[2];
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[3]['spacing'] ) )
                        $spacing += $node[3]['spacing'];
                    $php->addVariable( $variableName, $variableValue, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_VARIABLE_UNSET )
                {
                    $variableName = $node[1];
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[2]['spacing'] ) )
                        $spacing += $node[2]['spacing'];
                            
                    if ( is_array( $variableName ) )
                    {
                        $namespace = $variableName[0];
                        $namespaceScope = $variableName[1];
                        $variableName = $variableName[2];
                        $namespaceText = eZTemplateCompiler::generateMergeNamespaceCode( $php, $tpl, $namespace, $namespaceScope, array( 'spacing' => $spacing ), true );
                        if ( !is_string( $namespaceText ) )
                            $namespaceText = "\$namespace";
                        $variableNameText = $php->variableText( $variableName, 0 );
                        if ( isset( $node[2]['remember_set'] ) )
                        {
                            $php->addCodePiece( "if ( isset( \$setArray[$namespaceText][$variableNameText] ) )\n".
                                                "{\n" );
                            $spacing += 4;
                        }
                        $php->addCodePiece( "unset( \$vars[$namespaceText][$variableNameText] );",
                                            array( 'spacing' => $spacing ) );
                        if ( isset( $node[2]['remember_set'] ) )
                        {
                            $php->addCodePiece( "\n}\n" );
                            $spacing -= 4;
                        }
                    }
                    else
                    {
                        $php->addVariableUnset( $variableName, array( 'spacing' => $spacing ) );
                    }
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_RESOURCE_ACQUISITION )
                {
                    $resource = $node[1];
                    $resourceObject =& $tpl->resourceHandler( $resource );
                    if ( !$resourceObject )
                        continue;

                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[7]['spacing'] ) )
                        $spacing += $node[7]['spacing'];
                    $newRootNamespace = $node[8];
                    $resourceVariableName = $node[9];

//                    $templateNameText = $php->variableText( $node[2], 0 );
                    $useFallbackCode = true;
                    $uriMap = $node[2];
                    if ( is_string( $uriMap ) )
                    {
                        $uriMap = array( $uriMap );
                    }
                    else
                    {
                        $useFallbackCode = false;
                    }

                    $resourceMap = array();
                    $hasCompiledCode = false;
                    foreach ( $uriMap as $uriKey => $originalURI )
                    {
                        $uri = $originalURI;
                        if ( $resource )
                            $uri = $resource . ':' . $uri;
                        unset( $tmpResourceData );
                        $tmpResourceData = eZTemplate::resourceData( $resourceObject, $uri, $node[1], $originalURI );
                        $uriText = $php->variableText( $uri, 0 );

                        $resourceCanCache = true;
                        if ( !$resourceObject->servesStaticData() )
                            $resourceCanCache = false;
                        if ( !$tpl->isCachingAllowed() )
                            $resourceCanCache = false;

                        $tmpResourceData['text'] = null;
                        $tmpResourceData['root-node'] = null;
                        $tmpResourceData['compiled-template'] = false;
                        $tmpResourceData['time-stamp'] = null;
                        $tmpResourceData['key-data'] = null;
                        $subSpacing = 0;
                        $hasResourceData = false;

                        $savedLocale = setlocale( LC_CTYPE, null );
                        if ( isset( $GLOBALS['eZTemplateCompilerResourceCache'][$tmpResourceData['template-filename']] ) )
                        {
                            $tmpFileName = $tmpResourceData['template-filename'];
                            unset( $tmpResourceData );
                            $tmpResourceData = $GLOBALS['eZTemplateCompilerResourceCache'][$tmpFileName];
                            $tmpResourceData['compiled-template'] = true;
                            $hasResourceData = true;
                            $hasCompiledCode = true;
                        }
                        else
                        {
                            if ( $resourceObject->handleResource( $tpl, $tmpResourceData, $node[4], $node[5] ) )
                            {
                                if ( !$tmpResourceData['compiled-template'] and
                                     $tmpResourceData['root-node'] === null )
                                {
                                    $root =& $tmpResourceData['root-node'];
                                    $root = array( EZ_TEMPLATE_NODE_ROOT, false );
                                    $templateText =& $tmpResourceData["text"];
                                    $keyData = $tmpResourceData['key-data'];
                                    $rootNamespace = '';
                                    $tpl->parse( $templateText, $root, $rootNamespace, $tmpResourceData );
                                    $hasResourceData = false;
                                }
                                if ( !$tmpResourceData['compiled-template'] and
                                     $resourceCanCache and
                                     $tpl->canCompileTemplate( $tmpResourceData, $node[5] ) )
                                {
                                    $generateStatus = $tpl->compileTemplate( $tmpResourceData, $node[5] );

                                    // Time limit #2:
                                    // We reset the time limit to 20 seconds to ensure that remaining
                                    // template has enough time to compile.
                                    // However if time limit is unlimited (0) we leave it be
                                    if ( ini_get( 'max_execution_time' ) != 0  )
                                    {
                                        @set_time_limit( 30 );
                                    }

                                    if ( $generateStatus )
                                        $tmpResourceData['compiled-template'] = true;
                                }
                            }
                            $GLOBALS['eZTemplateCompilerResourceCache'][$tmpResourceData['template-filename']] =& $tmpResourceData;
                        }
                        setlocale( LC_CTYPE, $savedLocale );
//                         $tmpResourceData2 = $tmpResourceData;
//                         unset( $tmpResourceData2['text'] );
//                         unset( $tmpResourceData2['root-node'] );
//                         var_dump( $tmpResourceData2 );
                        $textName = eZTemplateCompiler::currentTextName( $parameters );
                        if ( $tmpResourceData['compiled-template'] )
                        {
                            $hasCompiledCode = true;
//                            if ( !eZTemplateCompiler::isFallbackResourceCodeEnabled() )
//                                $useFallbackCode = false;
                            $keyData = $tmpResourceData['key-data'];
                            $templatePath = $tmpResourceData['template-name'];
                            $key = $resourceObject->cacheKey( $keyData, $tmpResourceData, $templatePath, $node[5] );
                            $cacheFileName = eZTemplateCompiler::compilationFilename( $key, $tmpResourceData );

                            $directory = eZTemplateCompiler::compilationDirectory();
                            $phpScript = eZDir::path( array( $directory, $cacheFileName ) );
                            $phpScriptText = $php->variableText( $phpScript, 0 );
                            $resourceMap[$uriKey] = array( 'key' => $uriKey,
                                                           'uri' => $uri,
                                                           'phpscript' => $phpScript );
                        }
                        else
                        {
                        }
                    }

                    if ( $useComments )
                    {
                        $variablePlacement = $node[6];
                        if ( $variablePlacement )
                        {
                            $originalText = eZTemplateCompiler::fetchTemplatePiece( $variablePlacement );
                            $php->addComment( "Resource Acquisition:", true, true, array( 'spacing' => $spacing ) );
                            $php->addComment( $originalText, true, true, array( 'spacing' => $spacing ) );
                        }
                    }

                    if ( $hasCompiledCode )
                    {
                        if ( $resourceVariableName )
                        {
                            $phpScriptText = $php->variableText( $phpScript, 0 );
                            $phpScriptText = '$phpScript';
                            $phpScriptArray = array();
                            foreach ( $resourceMap as $resourceMapItem )
                            {
                                $phpScriptArray[$resourceMapItem['key']] = $resourceMapItem['phpscript'];
                            }
                            $php->addVariable( "phpScriptArray", $phpScriptArray, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, array( 'spacing' => $spacing ) );
                            $resourceVariableNameText = "\$$resourceVariableName";
                            $php->addCodePiece( "\$phpScript = isset( \$phpScriptArray[$resourceVariableNameText] ) ? \$phpScriptArray[$resourceVariableNameText] : false;\n", array( 'spacing' => $spacing ) );
                            $php->addCodePiece( "\$resourceFound = false;\nif ( $phpScriptText !== false and file_exists( $phpScriptText ) )\n{\n", array( 'spacing' => $spacing ) );
                        }
                        else
                        {
                            $php->addCodePiece( "\$resourceFound = false;\n", array( 'spacing' => $spacing ) );
                            $phpScript = $resourceMap[0]['phpscript'];
                            $phpScriptText = $php->variableText( $phpScript, 0 );
                            // Not sure where this should come from
//                         if ( $resourceIndex > 0 )
//                             $php->addCodePiece( "else " );
                            $php->addCodePiece( "if ( file_exists( $phpScriptText ) )\n{\n", array( 'spacing' => $spacing ) );

                        }

                        $code = "\$resourceFound = true;\n\$namespaceStack[] = array( \$rootNamespace, \$currentNamespace );\n";
                        if ( $newRootNamespace )
                        {
                            $newRootNamespaceText = $php->variableText( $newRootNamespace, 0, 0, false );
                            $code .= "\$currentNamespace = \$rootNamespace = !\$currentNamespace ? $newRootNamespaceText : ( \$currentNamespace . ':' . $newRootNamespaceText );\n";
                        }
                        else
                        {
                            $code .= "\$currentNamespace = \$rootNamespace;\n";
                        }

                        $code .= "include( $phpScriptText );\n" .
                            "list( \$rootNamespace, \$currentNamespace ) = array_pop( \$namespaceStack );\n";
                        $php->addCodePiece( $code, array( 'spacing' => $spacing + 4 ) );
                        if ( $useFallbackCode )
                            $php->addCodePiece( "}\nelse\n{\n    \$resourceFound = true;\n", array( 'spacing' => $spacing ) );
                        else
                            $php->addCodePiece( "}\n", array( 'spacing' => $spacing ) );
                        $subSpacing = 4;
                    }

                    if ( $useFallbackCode )
                    {
                        $php->addCodePiece( "\$textElements = array();\n\$extraParameters = array();\n\$tpl->processURI( $uriText, true, \$extraParameters, \$textElements, \$rootNamespace, \$currentNamespace );\n\$$textName .= implode( '', \$textElements );\n", array( 'spacing' => $spacing + $subSpacing ) );
                    }

                    if ( $hasCompiledCode and $useFallbackCode )
                    {
                        $php->addCodePiece( "}\n", array( 'spacing' => $spacing ) );
                    }
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_NAMESPACE_CHANGE )
                {
                    $variableData = $node[1];
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[2]['spacing'] ) )
                        $spacing += $node[2]['spacing'];
                    $php->addCodePiece( "\$namespaceStack[] = \$currentNamespace;\n", array( 'spacing' => $spacing ) );
                    $php->addCodePiece( '$currentNamespace .= ( $currentNamespace ? ":" : "" ) . \''. $variableData[0][1] . '\';' . "\n", array( 'spacing' => $spacing ) );
                }
                else if ( $nodeType == EZ_TEMPLATE_NODE_INTERNAL_NAMESPACE_RESTORE )
                {
                    $spacing = $currentParameters['spacing'];
                    if ( isset( $node[1]['spacing'] ) )
                        $spacing += $node[1]['spacing'];
                    $php->addCodePiece( "\$currentNamespace = array_pop( \$namespaceStack );\n", array( 'spacing' => $spacing ) );
                }
                else
                    eZDebug::writeWarning( "Unknown internal template node type $nodeType, ignoring node for code generation",
                                           'eZTemplateCompiler:generatePHPCodeChildren' );
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_ROOT )
            {
                $children = $node[1];
                if ( $children )
                {
                    $newCurrentParameters = $currentParameters;
                    $newCurrentParameters['spacing'] += 4;
                    eZTemplateCompiler::generatePHPCodeChildren( $useComments, $php, $tpl, $children, $resourceData, $parameters, $newCurrentParameters );
                }
                continue;
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_TEXT )
            {
                $text = $node[2];
                if ( $text != '' )
                {
                    $variablePlacement = $node[3];
                    $originalText = eZTemplateCompiler::fetchTemplatePiece( $variablePlacement );
                    if ( $useComments )
                    {
                        $php->addComment( "Text start:", true, true, array( 'spacing' => $currentParameters['spacing'] ) );
                        $php->addComment( $originalText, true, true, array( 'spacing' => $currentParameters['spacing'] ) );
                        $php->addComment( "Text end:", true, true, array( 'spacing' => $currentParameters['spacing'] ) );
                    }
                    $php->addVariable( eZTemplateCompiler::currentTextName( $parameters ),
                                       $text, EZ_PHPCREATOR_VARIABLE_APPEND_TEXT,
                                       array( 'spacing' => $currentParameters['spacing'] ) );
                }
                continue;
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_VARIABLE )
            {
                $variableAssignmentName = $node[1];
                $variableData = $node[2];
                $variablePlacement = $node[3];

                $variableParameters = array();
                if ( isset( $node[4] ) and
                     $node[4] )
                    $variableParameters = $node[4];
                $variableOnlyExisting = isset( $node[5] ) ? $node[5] : false;
                $variableOverWrite = isset( $node[6] ) ? $node[6] : false;
                $rememberSet = isset( $node[7] ) ? $node[7] : false;

                $spacing = $currentParameters['spacing'];
                if ( isset( $variableParameters['spacing'] ) )
                    $spacing += $variableParameters['spacing'];
                $variableParameters = array_merge( array( 'variable-name' => 'var',
                                                          'text-result' => true ),
                                                   $variableParameters );
                $dataInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                           $variableData, $variablePlacement,
                                                                           $resourceData );
                $newNode = $node;
                $newNode[1] = false;
                if ( $useComments )
                {
                    $php->addComment( "Variable data: " .
                                      "Is constant: " . ( $dataInspection['is-constant'] ? 'Yes' : 'No' ) .
                                      " Is variable: " . ( $dataInspection['is-variable'] ? 'Yes' : 'No' ) .
                                      " Has attributes: " . ( $dataInspection['has-attributes'] ? 'Yes' : 'No' ) .
                                      " Has operators: " . ( $dataInspection['has-operators'] ? 'Yes' : 'No' ),
                                      true, true, array( 'spacing' => $spacing )
                                      );
                    $originalText = eZTemplateCompiler::fetchTemplatePiece( $variablePlacement );
                    $php->addComment( '{' . $originalText . '}', true, true, array( 'spacing' => $spacing ) );
                }
                $generatedVariableName = $variableParameters['variable-name'];
                $assignVariable = false;
                if ( $variableAssignmentName !== false )
                {
                    if ( is_array( $variableAssignmentName ) )
                    {
                        $variableParameters['text-result'] = false;
                        $assignVariable = true;
                    }
                    else
                    {
                        $generatedVariableName = $variableAssignmentName;
                        $variableParameters['text-result'] = false;
                    }
                }

                $isStaticElement = false;
                $nodeElements = $node[2];
                $knownTypes = array();
                if ( eZTemplateNodeTool::isStaticElement( $nodeElements ) and
                     !$variableParameters['text-result'] )
                {
                    $variableText = $php->variableText( eZTemplateNodeTool::elementStaticValue( $nodeElements ) );
                    $isStaticElement = true;
                }
                else if ( eZTemplateNodeTool::isPHPVariableElement( $nodeElements ) and
                          !$variableParameters['text-result'] )
                {
                    $variableText = '$' . eZTemplateNodeTool::elementStaticValue( $nodeElements );
                    $isStaticElement = true;
                }
                else
                {
                    $variableText = "\$$generatedVariableName";
                    eZTemplateCompiler::generateVariableCode( $php, $tpl, $node, $knownTypes, $dataInspection,
                                                              array( 'spacing' => $spacing,
                                                                     'variable' => $generatedVariableName,
                                                                     'counter' => 0 ) );
                }

                if ( $variableParameters['text-result'] )
                {
                    $textName = eZTemplateCompiler::currentTextName( $parameters );
                    if ( count( $knownTypes ) == 0 or in_array( 'objectproxy', $knownTypes ) )
                    {
                        $php->addCodePiece( "while ( is_object( \$$generatedVariableName ) and method_exists( \$$generatedVariableName, 'templateValue' ) )\n" .
                                            "    \$$generatedVariableName = \$$generatedVariableName" . "->templateValue();\n" .
                                            "\$$textName .= ( is_object( \$$generatedVariableName ) ? compiledFetchText( \$tpl, \$rootNamespace, \$currentNamespace, \$namespace, \$$generatedVariableName ) : \$$generatedVariableName );\n" .
                                            "unset( \$$generatedVariableName );\n", array( 'spacing' => $spacing ) );
                    }
                    else
                    {
                        $php->addCodePiece( "\$$textName .= \$$generatedVariableName;\n" .
                                            "unset( \$$generatedVariableName );\n", array( 'spacing' => $spacing ) );
                    }
                }
                else if ( $assignVariable )
                {
                    $namespace = $variableAssignmentName[0];
                    $namespaceScope = $variableAssignmentName[1];
                    $variableName = $variableAssignmentName[2];
                    $namespaceText = eZTemplateCompiler::generateMergeNamespaceCode( $php, $tpl, $namespace, $namespaceScope, array( 'spacing' => $spacing ), true );
                    if ( !is_string( $namespaceText ) )
                        $namespaceText = "\$namespace";
                    $variableNameText = $php->variableText( $variableName, 0 );
                    $unsetVariableText = false;
                    if ( $variableOnlyExisting )
                    {
                        if ( !$isStaticElement )
                            $unsetVariableText = "\n    unset( $variableText );";
                        $php->addCodePiece( "if ( isset( \$vars[$namespaceText][$variableNameText] ) )\n{\n    \$vars[$namespaceText][$variableNameText] = $variableText;$unsetVariableText\n}",
                                            array( 'spacing' => $spacing ) );
                    }
                    else if ( $variableOverWrite )
                    {
                        if ( !$isStaticElement )
                            $unsetVariableText = "\nunset( $variableText );";
                        $php->addCodePiece( "\$vars[$namespaceText][$variableNameText] = $variableText;$unsetVariableText",
                                            array( 'spacing' => $spacing ) );
                    }
                    else if ( $rememberSet )
                    {
                        if ( !$isStaticElement )
                            $unsetVariableText = "\n    unset( $variableText );";
                        $php->addCodePiece( "if ( !isset( \$vars[$namespaceText][$variableNameText] ) )\n".
                                            "{\n".
                                            "    \$vars[$namespaceText][$variableNameText] = $variableText;$unsetVariableText\n".
                                            "    \$setArray[$namespaceText][$variableNameText] = true;\n".
                                            "}\n",
                                            array( 'spacing' => $spacing ) );
                    }
                    else
                    {
                        if ( !$isStaticElement )
                            $unsetVariableText = "\n    unset( $variableText );";
                        $php->addCodePiece( "if ( !isset( \$vars[$namespaceText][$variableNameText] ) )\n{\n    \$vars[$namespaceText][$variableNameText] = $variableText;$unsetVariableText\n}",
                                            array( 'spacing' => $spacing ) );
                    }
                }
                else if ( $variableAssignmentName !== false and $isStaticElement )
                {
                    $php->addCodePiece( "\$$generatedVariableName = $variableText;", array( 'spacing' => $spacing ) );
                }
                unset( $dataInspection );
            }
            else if ( $nodeType == EZ_TEMPLATE_NODE_FUNCTION )
            {
                $functionChildren = $node[1];
                $functionName = $node[2];
                $functionParameters = $node[3];
                $functionPlacement = $node[4];

                $newNode = array( $nodeType,
                                  false,
                                  $functionName,
                                  $functionParameters,
                                  $functionPlacement );

                $parameterText = 'No parameters';
                if ( $functionParameters )
                {
                    $parameterText = "Parameters: ". implode( ', ', array_keys( $functionParameters ) );
                }
                if ( $useComments )
                {
                    $php->addComment( "Function: $functionName, $parameterText", true, true, array( 'spacing' => $currentParameters['spacing'] ) );
                    $originalText = eZTemplateCompiler::fetchTemplatePiece( $functionPlacement );
                    $php->addComment( '{' . $originalText . '}', true, true, array( 'spacing' => $currentParameters['spacing'] ) );
                }
                if ( isset( $node[5] ) )
                {
                    $functionHook = $node[5];
                    $functionHookCustomFunction = $functionHook['function'];
                    if ( $functionHookCustomFunction )
                    {
                        $functionHookCustomFunction = array_merge( array( 'add-function-name' => false,
                                                                          'add-hook-name' => false,
                                                                          'add-template-handler' => true,
                                                                          'add-function-hook-data' => false,
                                                                          'add-function-parameters' => true,
                                                                          'add-function-placement' => false,
                                                                          'add-calculated-namespace' => false,
                                                                          'add-namespace' => true,
                                                                          'add-input' => false,
                                                                          'return-value' => false ),
                                                                   $functionHookCustomFunction );
                        if ( !isset( $parameters['hook-result-variable-counter'][$functionName] ) )
                            $parameters['hook-result-variable-counter'][$functionName] = 0;
                        if ( $functionHookCustomFunction['return-value'] )
                            $parameters['hook-result-variable-counter'][$functionName]++;
                        $hookResultName = $functionName . 'Result' . $parameters['hook-result-variable-counter'][$functionName];
                        if ( $functionHookCustomFunction['add-input'] )
                            $parameters['hook-result-variable-counter'][$functionName]--;
                        $functionHookCustomFunctionName = $functionHookCustomFunction['name'];
                        $codeText = '';
                        if ( $functionHookCustomFunction['return-value'] )
                            $codeText = "\$$hookResultName = ";
                        if ( $functionHookCustomFunction['static'] )
                        {
                            $hookClassName = $functionHookCustomFunction['class-name'];
                            $codeText .= "$hookClassName::$functionHookCustomFunctionName( ";
                        }
                        else
                            $codeText .= "\$functionObject->$functionHookCustomFunctionName( ";
                        $codeTextLength = strlen( $codeText );

                        $functionNameText = $php->variableText( $functionName, 0 );
                        $functionChildrenText = $php->variableText( $functionChildren, $codeTextLength, 0, false );

                        $inputFunctionParameters = $functionParameters;
                        if ( $functionHookCustomFunction['add-calculated-namespace'] )
                            unset( $inputFunctionParameters['name'] );
                        $functionParametersText = $php->variableText( $inputFunctionParameters, $codeTextLength, 0, false );

                        $functionPlacementText = $php->variableText( $functionPlacement, $codeTextLength, 0, false );
                        $functionHookText = $php->variableText( $functionHook, $codeTextLength, 0, false );

                        $functionHookName = $functionHook['name'];
                        $functionHookNameText = $php->variableText( $functionHookName, 0 );

                        $codeParameters = array();
                        if ( $functionHookCustomFunction['add-function-name'] )
                            $codeParameters[] = $functionNameText;
                        if ( $functionHookCustomFunction['add-hook-name'] )
                            $codeParameters[] = $functionHookNameText;
                        if ( $functionHookCustomFunction['add-function-hook-data'] )
                            $codeParameters[] = $functionHookText;
                        if ( $functionHookCustomFunction['add-template-handler'] )
                            $codeParameters[] = "\$tpl";
                        if ( $functionHookCustomFunction['add-function-parameters'] )
                            $codeParameters[] = $functionParametersText;
                        if ( $functionHookCustomFunction['add-function-placement'] )
                            $codeParameters[] = $functionPlacementText;
                        if ( $functionHookCustomFunction['add-calculated-namespace'] )
                        {
                            $name = '';
                            if ( isset( $functionParameters['name'] ) )
                            {
                                $nameParameter = $functionParameters['name'];
                                $nameInspection = eZTemplateCompiler::inspectVariableData( $tpl,
                                                                                           $nameParameter, $functionPlacement,
                                                                                           $resourceData );
                                if ( $nameInspection['is-constant'] and
                                     !$nameInspection['is-variable'] and
                                     !$nameInspection['has-attributes'] and
                                     !$nameInspection['has-operators'] )
                                {
                                    $nameData = $nameParameter[0][1];
                                    $nameText = $php->variableText( $nameData, 0, 0, false );
                                    $php->addCodePiece( "if ( \$currentNamespace != '' )
    \$name = \$currentNamespace . ':' . $nameText;
else
    \$name = $nameText;\n", array( 'spacing' => $currentParameters['spacing'] ) );
                                    $codeParameters[] = "\$name";
                                }
                                else
                                {
                                    $persistence = array();
                                    $knownTypes = array();
                                    eZTemplateCompiler::generateVariableCode( $php, $tpl, $nameParameter, $knownTypes, $nameInspection,
                                                                                  $persistence,
                                                                                  array( 'variable' => 'name',
                                                                                         'counter' => 0 ) );
                                    $php->addCodePiece( "if ( \$currentNamespace != '' )
{
    if ( \$name != '' )
        \$name = \"\$currentNamespace:\$name\";
    else
        \$name = \$currentNamespace;
}\n", array( 'spacing' => $currentParameters['spacing'] ) );
                                    $codeParameters[] = "\$name";
                                }
                            }
                            else
                            {
                                $codeParameters[] = "\$currentNamespace";
                            }
                        }
                        if ( $functionHookCustomFunction['add-namespace'] )
                            $codeParameters[] = "\$rootNamespace, \$currentNamespace";
                        if ( $functionHookCustomFunction['add-input'] )
                            $codeParameters[] = "\$$hookResultName";
                        $codeText .= implode( ",\n" . str_repeat( ' ', $codeTextLength ),
                                              $codeParameters );
                        $codeText .= " );\n";
                        if ( $functionHookCustomFunction['static'] )
                        {
                            $hookFile = $functionHookCustomFunction['php-file'];
                            $hookFileText = $php->variableText( $hookFile, 0 );
                            $php->addCodePiece( "include_once( $hookFileText );\n", array( 'spacing' => $currentParameters['spacing'] ) );
                        }
                        else
                            $php->addCodePiece( "\$functionObject =& \$tpl->fetchFunctionObject( $functionNameText );\n", array( 'spacing' => $currentParameters['spacing'] ) );
                        $php->addCodePiece( $codeText, array( 'spacing' => $currentParameters['spacing'] ) );
                    }
                    else
                    {
                        $functionNameText = $php->variableText( $functionName, 0 );
                        $functionChildrenText = $php->variableText( $functionChildren, 52, 0, false );
                        $functionParametersText = $php->variableText( $functionParameters, 52, 0, false );
                        $functionPlacementText = $php->variableText( $functionPlacement, 52, 0, false );

                        $functionHookText = $php->variableText( $functionHook, 52, 0, false );
                        $functionHookName = $functionHook['name'];
                        $functionHookNameText = $php->variableText( $functionHookName, 0 );
                        $functionHookParameters = $functionHook['parameters'];
                        $php->addCodePiece( "\$functionObject =& \$tpl->fetchFunctionObject( $functionNameText );
\$hookResult = \$functionObject->templateHookProcess( $functionNameText, $functionHookNameText,
                                                    $functionHookText,
                                                    \$tpl,
                                                    $functionParametersText,
                                                    $functionPlacementText,
                                                    \$rootNamespace, \$currentNamespace );
", array( 'spacing' => $currentParameters['spacing'] ) );
                    }
                }
                else
                {
                    $textName = eZTemplateCompiler::currentTextName( $parameters );
                    $functionNameText = $php->variableText( $functionName, 0 );
                    $functionChildrenText = $php->variableText( $functionChildren, 22, 0, false );
                    $functionParametersText = $php->variableText( $functionParameters, 22, 0, false );
                    $functionPlacementText = $php->variableText( $functionPlacement, 22, 0, false );
                    $php->addCodePiece( "\$textElements = array();
\$tpl->processFunction( $functionNameText, \$textElements,
                       $functionChildrenText,
                       $functionParametersText,
                       $functionPlacementText,
                       \$rootNamespace, \$currentNamespace );
\$$textName .= implode( '', \$textElements );\n", array( 'spacing' => $currentParameters['spacing'] ) );
                }
            }
            $php->addSpace();
        }
    }

    /*!
     Generates PHP code which will do namespace merging.
     The namespace to merge with is specified in \a $namespace and
     the scope of the merging is defined by \a $namespaceScope.
    */
    function generateMergeNamespaceCode( &$php, &$tpl, $namespace, $namespaceScope, $parameters = array(), $skipSimpleAssignment = false )
    {
        if ( $namespace != '' )
        {
            if ( $namespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_GLOBAL )
            {
                $php->addVariable( 'namespace', $namespace, EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, $parameters );
            }
            else if ( $namespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_LOCAL )
            {
                $php->addCodePiece( "\$namespace = \$rootNamespace;
if ( \$namespace == '' )
    \$namespace = \"$namespace\";
else
    \$namespace .= ':$namespace';
", $parameters );
            }
            else if ( $namespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE )
            {
                $php->addCodePiece( "\$namespace = \$currentNamespace;
if ( \$namespace == '' )
    \$namespace = \"$namespace\";
else
    \$namespace .= ':$namespace';
", $parameters );
            }
        }
        else
        {
            if ( $namespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_GLOBAL )
            {
                if ( $skipSimpleAssignment )
                    return "''";
                $php->addVariable( 'namespace', '', EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, $parameters );
            }
            else if ( $namespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_LOCAL )
            {
                if ( $skipSimpleAssignment )
                    return "\$rootNamespace";
                $php->addCodePiece( "\$namespace = \$rootNamespace;\n", $parameters );
            }
            else if ( $namespaceScope == EZ_TEMPLATE_NAMESPACE_SCOPE_RELATIVE )
            {
                if ( $skipSimpleAssignment )
                    return "\$currentNamespace";
                $php->addCodePiece( "\$namespace = \$currentNamespace;\n", $parameters );
            }
        }
        return true;
    }

    /*!
     Generates PHP code for the variable node \a $node.
     Use generateVariableDataCode if you want to create code for arbitrary variable data structures.
    */
    function generateVariableCode( &$php, &$tpl, $node, &$knownTypes, $dataInspection,
                                   $parameters )
    {
        $variableData = $node[2];
        $persistence = array();
        eZTemplateCompiler::generateVariableDataCode( $php, $tpl, $variableData, $knownTypes, $dataInspection, $persistence, $parameters );
    }

    /*!
     Generates PHP code for the variable tree structure in \a $variableData.
     The code will contain string, numeric and identifier assignment,
     variable lookup, attribute lookup and operator execution.
     Use generateVariableCode if you want to create code for a variable tree node.
    */
    function generateVariableDataCode( &$php, &$tpl, $variableData, &$knownTypes, $dataInspection, &$persistence, $parameters )
    {
        $staticTypeMap = array( EZ_TEMPLATE_TYPE_STRING => 'string',
                                EZ_TEMPLATE_TYPE_NUMERIC => 'numeric',
                                EZ_TEMPLATE_TYPE_IDENTIFIER => 'string',
                                EZ_TEMPLATE_TYPE_ARRAY => 'array',
                                EZ_TEMPLATE_TYPE_BOOLEAN => 'boolean' );

        $variableAssignmentName = $parameters['variable'];
        $variableAssignmentCounter = $parameters['counter'];
        $spacing = 0;
        if ( isset( $parameters['spacing'] ) )
            $spacing = $parameters['spacing'];
        if ( $variableAssignmentCounter > 0 )
            $variableAssignmentName .= $variableAssignmentCounter;
        foreach ( $variableData as $variableDataItem )
        {
            $variableDataType = $variableDataItem[0];
            if ( $variableDataType == EZ_TEMPLATE_TYPE_STRING or
                 $variableDataType == EZ_TEMPLATE_TYPE_NUMERIC or
                 $variableDataType == EZ_TEMPLATE_TYPE_IDENTIFIER or
                 $variableDataType == EZ_TEMPLATE_TYPE_ARRAY or
                 $variableDataType == EZ_TEMPLATE_TYPE_BOOLEAN )
            {
                $knownTypes = array_unique( array_merge( $knownTypes, array( $staticTypeMap[$variableDataType] ) ) );
                $dataValue = $variableDataItem[1];
                $dataText = $php->variableText( $dataValue, 0 );
                $php->addCodePiece( "\$$variableAssignmentName = $dataText;\n", array( 'spacing' => $spacing ) );
            }
            else if ( $variableDataType == EZ_TEMPLATE_TYPE_PHP_VARIABLE )
            {
                $knownTypes = array();
                $phpVariableName = $variableDataItem[1];
                $php->addCodePiece( "\$$variableAssignmentName = \$$phpVariableName;\n", array( 'spacing' => $spacing ) );
            }
            else if ( $variableDataType == EZ_TEMPLATE_TYPE_VARIABLE )
            {
                $knownTypes = array();
                $namespace = $variableDataItem[1][0];
                $namespaceScope = $variableDataItem[1][1];
                $variableName = $variableDataItem[1][2];
                $namespaceText = eZTemplateCompiler::generateMergeNamespaceCode( $php, $tpl, $namespace, $namespaceScope, array( 'spacing' => $spacing ), true );
                if ( !is_string( $namespaceText ) )
                    $namespaceText = "\$namespace";
                $variableNameText = $php->variableText( $variableName, 0 );
                $code = "unset( \$$variableAssignmentName );\n";
                $code .= "\$$variableAssignmentName = ( array_key_exists( $namespaceText, \$vars ) and array_key_exists( $variableNameText, \$vars[$namespaceText] ) ) ? \$vars[$namespaceText][$variableNameText] : null;\n";
                $php->addCodePiece( $code,
                                    array( 'spacing' => $spacing ) );
            }
            else if ( $variableDataType == EZ_TEMPLATE_TYPE_ATTRIBUTE )
            {
                $knownTypes = array();
                $newParameters = $parameters;
                $newParameters['counter'] += 1;
                $tmpVariableAssignmentName = $newParameters['variable'];
                $tmpVariableAssignmentCounter = $newParameters['counter'];
                if ( $tmpVariableAssignmentCounter > 0 )
                    $tmpVariableAssignmentName .= $tmpVariableAssignmentCounter;
                if ( eZTemplateNodeTool::isStaticElement( $variableDataItem[1] ) )
                {
                    $attributeStaticValue = eZTemplateNodeTool::elementStaticValue( $variableDataItem[1] );
                    $attributeText = $php->variableText( $attributeStaticValue, 0, 0, false );
                }
                else
                {
                    $newParameters['counter'] += 1;
                    $tmpKnownTypes = array();
                    eZTemplateCompiler::generateVariableDataCode( $php, $tpl, $variableDataItem[1], $tmpKnownTypes, $dataInspection,
                                                                  $persistence, $newParameters );
                    $newVariableAssignmentName = $newParameters['variable'];
                    $newVariableAssignmentCounter = $newParameters['counter'];
                    if ( $newVariableAssignmentCounter > 0 )
                        $newVariableAssignmentName .= $newVariableAssignmentCounter;
                    $attributeText = "\$$newVariableAssignmentName";
                }
//                 $php->addCodePiece( "\$$variableAssignmentName = compiledFetchAttribute( \$$variableAssignmentName, $attributeText );\n",
//                                     array( 'spacing' => $spacing ) );
                $php->addCodePiece( "\$$tmpVariableAssignmentName = compiledFetchAttribute( \$$variableAssignmentName, $attributeText );\n" .
                                    "unset( \$$variableAssignmentName );\n" .
                                    "\$$variableAssignmentName = \$$tmpVariableAssignmentName;\n",
                                    array( 'spacing' => $spacing ) );
            }
            else if ( $variableDataType == EZ_TEMPLATE_TYPE_OPERATOR )
            {
                $knownTypes = array();
                $operatorParameters = $variableDataItem[1];
                $operatorName = $operatorParameters[0];
                $operatorParameters = array_splice( $operatorParameters, 1 );
                $operatorNameText = $php->variableText( $operatorName, 0 );
                $operatorParametersText = $php->variableText( $operatorParameters, 23, 0, false );

                $operatorHint = eZTemplateCompiler::operatorHint( $tpl, $operatorName );
                if ( isset( $operatorHint['output'] ) and $operatorHint['output'] )
                {
                    if ( isset( $operatorHint['output-type'] ) )
                    {
                        $knownType = $operatorHint['output-type'];
                        if ( is_array( $knownType ) )
                            $knownTypes = array_merge( $knownTypes, $knownType );
                        else
                            $knownTypes[] = $knownType;
                        $knownTypes = array_unique( $knownTypes );
                    }
                    else
                        $knownTypes[] = 'static';
                }

                $php->addCodePiece( "if (! isset( \$$variableAssignmentName ) ) \$$variableAssignmentName = NULL;\n", array ( 'spacing' => $spacing ) );
                $php->addCodePiece( "while ( is_object( \$$variableAssignmentName ) and method_exists( \$$variableAssignmentName, 'templateValue' ) )\n" .
                                                  "    \$$variableAssignmentName = \$$variableAssignmentName" . "->templateValue();\n" );
                $php->addCodePiece( "\$" . $variableAssignmentName . "Data = array( 'value' => \$$variableAssignmentName );
\$tpl->processOperator( $operatorNameText,
                       $operatorParametersText,
                       \$rootNamespace, \$currentNamespace, \$" . $variableAssignmentName . "Data, false, false );
\$$variableAssignmentName = \$" . $variableAssignmentName . "Data['value'];
unset( \$" . $variableAssignmentName . "Data );\n",
                                    array( 'spacing' => $spacing ) );
            }
            else if ( $variableDataType == EZ_TEMPLATE_TYPE_VOID )
            {
            }
            else if ( $variableDataType == EZ_TEMPLATE_TYPE_DYNAMIC_ARRAY )
            {
                $knownTypes = array_unique( array_merge( $knownTypes, array( 'array' ) ) );
                $code = '%output% = array( ';

                $matchMap = array( '%input%', '%output%' );
                $replaceMap = array( '$' . $variableAssignmentName, '$' . $variableAssignmentName );
                $unsetList = array();
                $counter = 1;
                $paramCount = 0;

                $values = $variableDataItem[2];
                $newParameters = $parameters;
                foreach ( $values as $key => $value )
                {
                    if ( $paramCount != 0 )
                    {
                        $code .= ', ';
                    }
                    ++$paramCount;
                    $code .= '\'' . $key . '\' => ';
                    if( eZTemplateNodeTool::isStaticElement( $value ) )
                    {
                        $code .= eZPHPCreator::variableText( eZTemplateNodeTool::elementStaticValue( $value ), 0, 0, false );
                        continue;
                    }
                    $code .= '%' . $counter . '%';
                    $newParameters['counter'] += 1;
                    $newVariableAssignmentName = $newParameters['variable'];
                    $newVariableAssignmentCounter = $newParameters['counter'];
                    if ( $newVariableAssignmentCounter > 0 )
                        $newVariableAssignmentName .= $newVariableAssignmentCounter;
                    $matchMap[] = '%' . $counter . '%';
                    $replaceMap[] = '$' . $newVariableAssignmentName;
                    $unsetList[] = $newVariableAssignmentName;
                    $tmpKnownTypes = array();
                    eZTemplateCompiler::generateVariableDataCode( $php, $tpl, $value, $tmpKnownTypes, $dataInspection,
                                                                  $persistence, $newParameters );
                    ++$counter;
                }

                $code .= ' );';
                $code = str_replace( $matchMap, $replaceMap, $code );
                $php->addCodePiece( $code, array( 'spacing' => $spacing ) );
                $php->addVariableUnsetList( $unsetList, array( 'spacing' => $spacing ) );
            }
            else if ( $variableDataType == EZ_TEMPLATE_TYPE_INTERNAL_CODE_PIECE )
            {
                $code = $variableDataItem[1];
                $values = false;
                $matchMap = array( '%input%', '%output%' );
                $replaceMap = array( '$' . $variableAssignmentName, '$' . $variableAssignmentName );
                $unsetList = array();
                $counter = 1;
                if ( isset( $variableDataItem[3] ) && is_array( $variableDataItem[3] ) )
                {
                    $newParameters = $parameters;
                    $values = $variableDataItem[3];
                    foreach ( $values as $value )
                    {
                        $newParameters['counter'] += 1;
                        $newVariableAssignmentName = $newParameters['variable'];
                        $newVariableAssignmentCounter = $newParameters['counter'];
                        if ( $newVariableAssignmentCounter > 0 )
                            $newVariableAssignmentName .= $newVariableAssignmentCounter;
                        if ( eZTemplateNodeTool::isStaticElement( $value ) )
                        {
                            $staticValue = eZTemplateNodeTool::elementStaticValue( $value );
                            $staticValueText = $php->variableText( $staticValue, 0, 0, false );
                            if ( preg_match( "/%code$counter%/", $code ) )
                            {
                                $matchMap[] = '%code' . $counter . '%';
                                $replaceMap[] = '';
                            }
                            $matchMap[] = '%' . $counter . '%';
                            $replaceMap[] = $staticValueText;
                        }
                        else
                        {
                            $matchMap[] = '%' . $counter . '%';
                            $replaceMap[] = '$' . $newVariableAssignmentName;
                            $unsetList[] = $newVariableAssignmentName;
                            if ( preg_match( "/%code$counter%/", $code ) )
                            {
                                $tmpPHP = new eZPHPCreator( '', '' );
                                $tmpKnownTypes = array();
                                eZTemplateCompiler::generateVariableDataCode( $tmpPHP, $tpl, $value, $tmpKnownTypes, $dataInspection,
                                                                              $persistence, $newParameters );
                                $newCode = $tmpPHP->fetch( false );
                                if ( count( $tmpKnownTypes ) == 0 or in_array( 'objectproxy', $tmpKnownTypes ) )
                                {
                                    $newCode .= ( "while ( is_object( \$$newVariableAssignmentName ) and method_exists( \$$newVariableAssignmentName, 'templateValue' ) )\n" .
                                                  "    \$$newVariableAssignmentName = \$$newVariableAssignmentName" . "->templateValue();\n" );
                                }
                                $matchMap[] = '%code' . $counter . '%';
                                $replaceMap[] = $newCode;
                            }
                            else
                            {
                                $tmpKnownTypes = array();
                                eZTemplateCompiler::generateVariableDataCode( $php, $tpl, $value, $tmpKnownTypes, $dataInspection,
                                                                              $persistence, $newParameters );
                                if ( count( $tmpKnownTypes ) == 0 or in_array( 'objectproxy', $tmpKnownTypes ) )
                                {
                                    $php->addCodePiece( "while ( is_object( \$$newVariableAssignmentName ) and method_exists( \$$newVariableAssignmentName, 'templateValue' ) )\n" .
                                                        "    \$$newVariableAssignmentName = \$$newVariableAssignmentName" . "->templateValue();\n",
                                                        array( 'spacing' => $spacing ) );
                                }
                            }
                        }
                        ++$counter;
                    }
                }
                if ( isset( $variableDataItem[4] ) && ( $variableDataItem[4] !== false ) )
                {
                    $values = $variableDataItem[4];

                    for ( $i = 0; $i < $values; $i++ )
                    {
                        $newParameters['counter'] += 1;
                        $newVariableAssignmentName = $newParameters['variable'];
                        $newVariableAssignmentCounter = $newParameters['counter'];
                        if ( $newVariableAssignmentCounter > 0 )
                            $newVariableAssignmentName .= $newVariableAssignmentCounter;
                        $matchMap[] = '%tmp' . ( $i + 1 ) . '%';
                        $replaceMap[] = '$' . $newVariableAssignmentName;
                        $unsetList[] = $newVariableAssignmentName;
                    }
                }
                if ( isset( $variableDataItem[5] ) and $variableDataItem[5] )
                {
                    if ( is_array( $variableDataItem[5] ) )
                        $knownTypes = array_unique( array_merge( $knownTypes, $variableDataItem[5] ) );
                    else if ( is_string( $variableDataItem[5] ) )
                        $knownTypes = array_unique( array_merge( $knownTypes, array( $variableDataItem[5] ) ) );
                    else
                        $knownTypes = array_unique( array_merge( $knownTypes, array( 'static' ) ) );
                }
                $code = str_replace( $matchMap, $replaceMap, $code );
                $php->addCodePiece( $code, array( 'spacing' => $spacing ) );
                $php->addVariableUnsetList( $unsetList, array( 'spacing' => $spacing ) );
            }
        }
    }
}

?>
