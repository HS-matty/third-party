<?php
//
// Definition of eZModuleOperationInfo class
//
// Created on: <06-Oct-2002 16:27:36 amos>
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

/*! \file ezmoduleoperationinfo.php
*/

/*!
  \class eZModuleOperationInfo ezmoduleoperationinfo.php
  \brief The class eZModuleOperationInfo does

*/

include_once( 'lib/ezutils/classes/ezmodule.php' );
include_once( 'lib/ezutils/classes/ezdebug.php' );
include_once( 'lib/ezutils/classes/ezoperationmemento.php' );
include_once( 'kernel/classes/eztrigger.php' );

include_once( 'lib/ezutils/classes/ezmoduleoperationdefinition.php' );


class eZModuleOperationInfo
{
    /*!
     Constructor
    */
    function eZModuleOperationInfo( $moduleName, $useTriggers = true )
    {
        $this->ModuleName = $moduleName;
        $this->IsValid = false;
        $this->OperationList = array();
        $this->UseOldCall = false;
        $this->Memento = null;
        $this->UseTriggers = $useTriggers;
    }

    function isValid()
    {
        return $this->IsValid;
    }

    function loadDefinition()
    {
        $pathList = eZModule::globalPathList();
        foreach ( $pathList as $path )
        {
            $definitionFile = $path . '/' . $this->ModuleName . '/operation_definition.php';
            if ( file_exists( $definitionFile ) )
                break;
            $definitionFile = null;
        }
        if ( $definitionFile === null )
        {
            eZDebug::writeError( 'Missing operation definition file for module: ' . $this->ModuleName,
                                 'eZModuleOperationInfo::loadDefinition' );
            return false;
        }
        unset( $OperationList );
        include( $definitionFile );
        if ( !isset( $OperationList ) )
        {
            eZDebug::writeError( 'Missing operation definition list for module: ' . $this->ModuleName,
                                 'eZModuleOperationInfo::loadDefinition' );
            return false;
        }
        $this->OperationList = $OperationList;
        $this->IsValid = true;
        return true;
    }

    function makeOperationKeyArray( $operationDefinition, $operationParameters )
    {
        $keyDefinition = null;
        if ( array_key_exists( 'keys', $operationDefinition ) and
             is_array( $operationDefinition['keys'] ) )
        {
            $keyDefinition = $operationDefinition['keys'];
        }
        return $this->makeKeyArray( $keyDefinition, $operationDefinition['parameters'], $operationParameters );
    }

    function makeKeyArray( $keyDefinition, $parameterDefinition, $operationParameters )
    {
        $keyArray = array();
        if ( $keyDefinition !== null )
        {
            foreach ( $keyDefinition as $key )
            {
                $keyArray[$key] = $operationParameters[$key];
            }
        }
        else
        {
            foreach ( $parameterDefinition as $operationParameter )
            {
                $keyArray[$operationParameter['name']] = $operationParameters[$operationParameter['name']];
            }
        }
        return $keyArray;
    }

    function execute( $operationName, $operationParameters, $mementoData = null )
    {
        $moduleName = $this->ModuleName;
        if ( !isset( $this->OperationList[$operationName] ) )
        {
            eZDebug::writeError( "No such operation '$operationName' in module '$moduleName'",
                                 'eZModuleOperationInfo::execute' );
            return null;
        }
        $operationDefinition =& $this->OperationList[$operationName];
        if ( !isset( $operationName['default_call_method'] ) )
        {
            eZDebug::writeError( "No call method defined for operation '$operationName' in module '$moduleName'",
                                 'eZModuleOperationInfo::execute' );
            return null;
        }
        if ( !isset( $operationName['body'] ) )
        {
            eZDebug::writeError( "No body for operation '$operationName' in module '$moduleName'",
                                 'eZModuleOperationInfo::execute' );
            return null;
        }
        if ( !isset( $operationName['parameters'] ) )
        {
            eZDebug::writeError( "No parameters defined for operation '$operationName' in module '$moduleName'",
                                 'eZModuleOperationInfo::execute' );
            return null;
        }
        $callMethod =& $operationDefinition['default_call_method'];
        $resultArray = null;
        $this->Memento = null;
        if ( isset( $callMethod['include_file'] ) and
             isset( $callMethod['class'] ) )
        {
            $bodyCallCount = array( 'loop_run' => array() );
            $operationKeys = null;
            if ( isset( $operationDefinition['keys'] ) )
                $operationKeys = $operationDefinition['keys'];
            $operationParameterDefinitions = $operationDefinition['parameters'];
            $this->storeOperationMemento( $operationKeys, $operationParameterDefinitions, $operationParameters, $bodyCallCount, $operationName );

            $runOperation = true;
            if ( $mementoData === null )
            {
                $keyArray = $this->makeOperationKeyArray( $operationDefinition, $operationParameters );
                $keyArray['session_key'] = eZHTTPTool::getSessionKey();
                $mainMemento = null;
                if ( $this->UseTriggers )
                    $mainMemento =& eZOperationMemento::fetchMain( $keyArray );

                if ( $mainMemento !== null )
                {
                    $this->Memento =& $mainMemento;
                    $mementoOperationData = $this->Memento->data();
                    if ( isset( $mementoOperationData['loop_run'] ) )
                        $bodyCallCount['loop_run'] = $mementoOperationData['loop_run'];
                }
                else
                    eZDebug::writeWarning( 'Missing main operation memento for key: ' . $this->Memento->attribute( 'memento_key' ), 'eZModuleOperationInfo::execute' );

                $mementoList = null;
                if ( $this->UseTriggers )
                    $mementoList = eZOperationMemento::fetchList( $keyArray );

                if ( count( $mementoList ) > 0 )
                {
                    $lastResultArray = array();
                    $mementoRestoreSuccess = true;
                    // restoring running operation
                    foreach ( array_keys( $mementoList ) as $key )
                    {
                        $memento =& $mementoList[$key];
                        $mementoData = $memento->data();
                        $memento->remove();

                        $resultArray =& $this->executeBody( $callMethod['include_file'], $callMethod['class'], $operationDefinition['body'],
                                                            $operationKeys, $operationParameterDefinitions, $operationParameters,
                                                            $mementoData, $bodyCallCount, $operationDefinition['name'] );
                        if ( is_array( $resultArray ) )
                        {
                            $lastResultArray = array_merge( $lastResultArray, $resultArray );
                            if ( !$resultArray['status'] )
                                $mementoRestoreSuccess = false;
                        }
                    }
                    $resultArray = $lastResultArray;
                    //                 $resultArray['status'] = $mementoRestoreSuccess;
                    $runOperation = false;
                }
            }
            if ( $runOperation )
            {
                // start  new operation
                $resultArray =& $this->executeBody( $callMethod['include_file'], $callMethod['class'], $operationDefinition['body'],
                                                    $operationKeys, $operationParameterDefinitions, $operationParameters,
                                                    $mementoData, $bodyCallCount, $operationDefinition['name'] );

//                 eZDebug::writeDebug( $resultArray, 'ezmodule operation result array' );
            }
            if ( is_array( $resultArray ) and
                 isset( $resultArray['status'] ) and 
                 $resultArray['status'] == EZ_MODULE_OPERATION_HALTED )
            {
//                 eZDebug::writeDebug( $this->Memento, 'ezmodule operation result halted' );
                if ( $this->Memento !== null )
                {
                    $this->Memento->store();
                }
            }
            else if ( $this->Memento !== null and
                      $this->Memento->attribute( 'id' ) !== null )
            {
//                 eZDebug::writeDebug( $this->Memento, 'ezmodule operation result not halted' );
                $this->Memento->remove();
            }
//            if ( $resultArray['status'] == EZ_MODULE_OPERATION_CANCELED )
//            {
//                return null;
//            }
            /*
            else if ( isset( $mementoData['memento_key'] ) )
            {
                $memento = eZOperationMemento::fetch( $mementoData['mementoKey'] );
                if ( $memento->attribute( 'main_key') !=  $mementoData['mementoKey'] )
                {
                    $mainMemento = eZOperationMemento::fetch( $memento->attribute( 'main_key') );
                }
                $memento->remove();
            }
            */
            $this->Memento = null;
        }
        else
        {
            eZDebug::writeError( "No valid call methods found for operation '$operationName' in module '$moduleName'",
                                 'eZModuleOperationInfo::execute' );
            return null;
        }
        if ( !is_array( $resultArray ) )
        {
            eZDebug::writeError( "Operation '$operationName' in module '$moduleName' did not return a result array",
                                 'eZOperationHandler::execute' );
            return null;
        }
        if ( isset( $resultArray['internal_error'] ) )
        {
            switch ( $resultArray['internal_error'] )
            {
                case EZ_MODULE_OPERATION_ERROR_NO_CLASS:
                {
                    $className = $resultArray['internal_error_class_name'];
                    eZDebug::writeError( "No class '$className' available for operation '$operationName' in module '$moduleName'",
                                         'eZModuleOperationInfo::execute' );
                    return null;
                } break;
                case EZ_MODULE_OPERATION_ERROR_NO_CLASS_METHOD:
                {
                    $className = $resultArray['internal_error_class_name'];
                    $classMethodName = $resultArray['internal_error_class_method_name'];
                    eZDebug::writeError( "No method '$classMethodName' in class '$className' available for operation '$operationName' in module '$moduleName'",
                                         'eZModuleOperationInfo::execute' );
                    return null;
                } break;
                case EZ_MODULE_OPERATION_ERROR_CLASS_INSTANTIATE_FAILED:
                {
                    $className = $resultArray['internal_error_class_name'];
                    eZDebug::writeError( "Failed instantiating class '$className' which is needed for operation '$operationName' in module '$moduleName'",
                                         'eZModuleOperationInfo::execute' );
                    return null;
                } break;
                case EZ_MODULE_OPERATION_ERROR_MISSING_PARAMETER:
                {
                    $parameterName = $resultArray['internal_error_parameter_name'];
                    eZDebug::writeError( "Missing parameter '$parameterName' for operation '$operationName' in module '$moduleName'",
                                         'eZModuleOperationInfo::execute' );
                    return null;
                } break;
                default:
                {
                    $internalError = $resultArray['internal_error'];
                    eZDebug::writeError( "Unknown internal error '$internalError' for operation '$operationName' in module '$moduleName'",
                                         'eZModuleOperationInfo::execute' );
                    return null;
                } break;
            }
            return null;
        }
        else if ( isset( $resultArray['error'] ) )
        {
        }
        else if ( isset( $resultArray['status'] ) )
        {
            return $resultArray;
        }
        else
        {
            eZDebug::writeError( "Operation '$operationName' in module '$moduleName' did not return a result value",
                                 'eZOperationHandler::execute' );
        }
        return null;
    }

    function executeBody( $includeFile, $className, $bodyStructure,
                          $operationKeys, $operationParameterDefinitions, $operationParameters,
                          &$mementoData, &$bodyCallCount, $operationName, $currentLoopData = null )
    {
        $bodyReturnValue = array( 'status' => EZ_MODULE_OPERATION_CONTINUE );
        foreach ( $bodyStructure as $body )
        {
            if ( !isset( $body['type'] ) )
            {
                eZDebug::writeError( 'No type for body element, skipping', 'eZModuleOperationInfo::executeBody' );
                continue;
            }
            if ( !isset( $body['name'] ) )
            {
                eZDebug::writeError( 'No name for body element, skipping', 'eZModuleOperationInfo::executeBody' );
                continue;
            }
            $bodyName = $body['name'];
            if ( !isset( $bodyCallCount['loop_run'][$bodyName] ) )
                $bodyCallCount['loop_run'][$bodyName] = 0;
            $type = $body['type'];
            switch ( $type )
            {
                case 'loop':
                {
                    $children = $body['children'];
                    $tmpOperationParameterDefinitions = $operationParameterDefinitions;
                    if ( isset( $body['child_parameters'] ) )
                        $tmpOperationParameterDefinitions = $body['child_parameters'];
                    $loopName = $body['name'];

                    if ( $mementoData !== null )
                    {
                        $returnValue = $this->executeBody( $includeFile, $className, $children,
                                                           $operationKeys, $tmpOperationParameterDefinitions, $operationParameters,
                                                           $mementoData, $bodyCallCount, $operationName, null );
                        if ( !$returnValue['status'] )
                            return $returnValue;
                    }
                    else
                    {
                        ++$bodyCallCount['loop_run'][$bodyName];

                        $method = $body['method'];
                        $resultArray =& $this->executeClassMethod( $includeFile, $className, $method,
                                                                   $operationParameterDefinitions, $operationParameters );
                        $parameters = array();
                        if ( isset( $resultArray['parameters'] ) )
                        {
                            $parameters = $resultArray['parameters'];
                        }
                        $count = 0;
                        $countDone = 0;
                        $countHalted = 0;
                        $countCanceled = 0;
                        foreach ( $parameters as $parameterStructure )
                        {
                            $tmpOperationParameters = $operationParameters;
                            foreach ( $parameterStructure as $parameterName => $parameterValue )
                            {
                                $tmpOperationParameters[$parameterName] = $parameterValue;
                            }
//                            ++$tmpCallValues['run_number'];
                            ++$count;
                            $returnValue = $this->executeBody( $includeFile, $className, $children,
                                                               $operationKeys, $tmpOperationParameterDefinitions, $tmpOperationParameters,
                                                               $mementoData, $bodyCallCount, $operationName, array( 'name' => $loopName,
                                                                                                                    'count' => count( $parameters ),
                                                                                                                    'index' => $count  ) );
                            switch( $returnValue['status'] )
                            {
                                case EZ_MODULE_OPERATION_CANCELED:
                                {
                                    $bodyReturnValue = $returnValue;
                                    ++$countCanceled;
                                }break;
                                case EZ_MODULE_OPERATION_CONTINUE:
                                {
                                    $bodyReturnValue = $returnValue;

                                    ++$countDone;
                                }break;
                                case EZ_MODULE_OPERATION_HALTED:
                                {
                                    $bodyReturnValue = $returnValue;
                                    ++$countHalted;
                                }break;
                            }
                        }
                        if ( $body['continue_operation'] == 'all' )
                        {
                            if ( $count == $countDone )
                            {
                                // continue operation
                            }
                            if ( $countCanceled > 0 )
                            {
                                return $bodyReturnValue;
                                //cancel operation
                            }
                            if ( $countHalted > 0 )
                            {
                                return $bodyReturnValue;                                //show tempalate
                            }

                        }
                        /*
                        if ( !$bodyReturnValue['status'] )
                        {
                            print( "One or more loop items failed, returning<br/>" );
                            return $bodyReturnValue;
                        }
                        */
                    }
                } break;
                case 'trigger':
                {
                    if ( !$this->UseTriggers )
                    {
                        $bodyReturnValue['status'] = EZ_MODULE_OPERATION_CONTINUE;
                        continue;

                    }

                    $triggerName = $body['name'];
                    $triggerKeys = $body['keys'];
                    $triggerRestored = false;
                    $executeTrigger = true;
                    if ( $mementoData !== null )
                    {
                        if ( $mementoData['name'] == $triggerName )
                        {
                            $executeTrigger =  $this->restoreBodyMementoData( $bodyName, $mementoData,
                                                                              $operationParameters, $bodyCallCount, $currentLoopData );
                            $triggerRestored = true;
                        }
                        else
                        {
                            $executeTrigger = false;
                        }
                    }
                    if ( $executeTrigger )
                    {
                        $status = $this->executeTrigger( $bodyReturnValue, $body,
                                                          $operationParameterDefinitions, $operationParameters,
                                                          $bodyCallCount, $currentLoopData,
                                                          $triggerRestored, $operationName, $operationKeys );
//                         eZDebug::writeDebug( $status, 'trigger execute status' );
                        switch( $status )
                        {
                            case EZ_MODULE_OPERATION_CONTINUE:
                            {
                                $bodyReturnValue['status'] = EZ_MODULE_OPERATION_CONTINUE;
                            }break;
                            case EZ_MODULE_OPERATION_CANCELED:
                            {
                                $bodyReturnValue['status'] = EZ_MODULE_OPERATION_CANCELED;
                                return $bodyReturnValue;
                            }break;
                            case EZ_MODULE_OPERATION_HALTED:
                            {

                                $bodyReturnValue['status'] = EZ_MODULE_OPERATION_HALTED;
                                return $bodyReturnValue;
                            }
                        }
/*
                        if ( !$this->executeTrigger( $bodyReturnValue, $body,
                                                    $operationParameterDefinitions, $operationParameters,
                                                    $bodyCallCount, $currentLoopData,
                                                    $triggerRestored, $operationName ) )
                        {
                            $this->storeBodyMemento( $triggerName, $triggerKeys,
                                                     $operationKeys, $operationParameterDefinitions, $operationParameters,
                                                     $bodyCallCount, $currentLoopData );
                            $bodyReturnValue['status'] = false;
                        }
                    }
                    if ( !$bodyReturnValue['status'] )
                        return $bodyReturnValue;
*/
                    }else
                    {
                        $bodyReturnValue['status'] = EZ_MODULE_OPERATION_CONTINUE;
//                        return $bodyReturnValue;
                    }
                } break;
                case 'method':
                {
                    if ( $mementoData === null )
                    {
                        $method = $body['method'];
                        $frequency = $body['frequency'];
                        $executeMethod = true;
                        if ( $frequency == 'once' and
                             $bodyCallCount['loop_run'][$bodyName] != 0 )
                            $executeMethod = false;
                        $tmpOperationParameterDefinitions = $operationParameterDefinitions;
                        if ( isset( $body['parameters'] ) )
                            $tmpOperationParameterDefinitions = $body['parameters'];
                        if ( $executeMethod )
                        {
                            ++$bodyCallCount['loop_run'][$bodyName];
                            $result = $this->executeClassMethod( $includeFile, $className, $method,
                                                                 $tmpOperationParameterDefinitions, $operationParameters );
                            if ( $result != null && ( !isset( $result['status'] ) || !$result['status'] ) )
                            {
                                return $result;
                            }
                            else
                            {
                                $result['status'] = EZ_MODULE_OPERATION_CONTINUE;
                                $bodyReturnValue =& $result;
                            }
                        }
                    }
                } break;
                default:
                {
                    eZDebug::writeError( "Unknown operation type $type", 'eZModuleOperationInfo::executeBody' );
                }
            }
        }

        return $bodyReturnValue;
    }

    function executeTrigger( &$bodyReturnValue, $body,
                             $operationParameterDefinitions, $operationParameters,
                             &$bodyCallCount, $currentLoopData,
                             $triggerRestored, $operationName, &$operationKeys )
    {
        $triggerName = $body['name'];
        $triggerKeys = $body['keys'];

        $status = eZTrigger::runTrigger( $triggerName, $this->ModuleName, $operationName, $operationParameters, $triggerKeys );


        if ( $status['Status'] == EZ_TRIGGER_WORKFLOW_DONE ||
             $status['Status'] == EZ_TRIGGER_NO_CONNECTED_WORKFLOWS )
        {
            ++$bodyCallCount['loop_run'][$triggerName];
            return EZ_MODULE_OPERATION_CONTINUE;
        }
        else if ( $status['Status'] == EZ_TRIGGER_STATUS_CRON_JOB ||
                  $status['Status'] == EZ_TRIGGER_FETCH_TEMPLATE ||
                  $status['Status'] == EZ_TRIGGER_REDIRECT )
        {
            $bodyMemento =& $this->storeBodyMemento( $triggerName, $triggerKeys,
                                                     $operationKeys, $operationParameterDefinitions, $operationParameters,
                                                     $bodyCallCount, $currentLoopData, $operationName );
            $workflowProcess =& $status['WorkflowProcess'];
            if ( ! is_null( $workflowProcess ) )
            {
                $workflowProcess->setAttribute( 'memento_key', $bodyMemento->attribute( 'memento_key' ) );
                $workflowProcess->store();
            }

            $bodyReturnValue['result'] =& $status['Result'];
            if ( $status['Status'] == EZ_TRIGGER_REDIRECT )
            {
                $bodyReturnValue['redirect_url'] =& $status['Result'];
            }
            return EZ_MODULE_OPERATION_HALTED;
        }
        else if ( $status['Status'] == EZ_TRIGGER_WORKFLOW_CANCELED or
                  $status['Status'] == EZ_TRIGGER_WORKFLOW_RESET )
        {
             return EZ_MODULE_OPERATION_CANCELED;
             $bodyReturnValue['result'] =& $status['Result'];
        }
    }

    function storeOperationMemento( $operationKeys, $operationParameterDefinitions, $operationParameters,
                                    &$bodyCallCount, $operationName )
    {
        $mementoData = array();
        $mementoData['module_name'] = $this->ModuleName;
        $mementoData['operation_name'] = $operationName;
        if ( $this->Memento === null )
        {
            $keyArray = $this->makeKeyArray( $operationKeys, $operationParameterDefinitions, $operationParameters );
            $keyArray['session_key'] = eZHTTPTool::getSessionKey();
            $mementoData['loop_run'] = $bodyCallCount['loop_run'];
            $memento = eZOperationMemento::create( $keyArray, $mementoData, true );
            $this->Memento =& $memento;
        }
        else
        {
            $mementoData = $this->Memento->data();
            $mementoData['loop_run'] = $bodyCallCount['loop_run'];
            $this->Memento->setData( $mementoData );
        }
    }

    function removeBodyMemento( $bodyName, $bodyKeys,
                                $operationKeys, $operationParameterDefinitions, $operationParameters,
                                &$bodyCallCount, $currentLoopData, $operationName )
    {
        $keyArray = $this->makeKeyArray( $operationKeys, $operationParameterDefinitions, $operationParameters );
    }
    function &storeBodyMemento( $bodyName, $bodyKeys,
                               $operationKeys, $operationParameterDefinitions, $operationParameters,
                               &$bodyCallCount, $currentLoopData, $operationName )
    {
        $this->storeOperationMemento( $operationKeys, $operationParameterDefinitions, $operationParameters, $bodyCallCount, $operationName );

        $keyArray = $this->makeKeyArray( $operationKeys, $operationParameterDefinitions, $operationParameters );
        $keyArray['session_key'] = eZHTTPTool::getSessionKey();
        $mementoData = array();
        $mementoData['name'] = $bodyName;
        $mementoData['parameters'] = $operationParameters;
        $mementoData['loop_data'] = $currentLoopData;
        $mementoData['module_name'] = $this->ModuleName;
        $mementoData['operation_name'] = $operationName;
        $memento =& eZOperationMemento::create( $keyArray, $mementoData, false, $this->Memento->attribute( 'memento_key' ) );
        $memento->store();
        return $memento;
    }

    function restoreBodyMementoData( $bodyName, &$mementoData,
                                     &$operationParameters, &$bodyCallCount, &$currentLoopData )
    {
        $operationParameters = array();
        if ( isset( $mementoData['parameters'] ) )
            $operationParameters = $mementoData['parameters'];
        if ( isset( $mementoData[ 'main_memento' ] ) )
        {
            $this->Memento =& $mementoData[ 'main_memento' ];
            $mainMementoData =& $this->Memento->data();
            if ( isset( $mainMementoData['loop_run'] ) )
            {
                $bodyCallCount['loop_run'] = $mainMementoData['loop_run'];
            }

        }

//         if ( $this->Memento !== null )
//         {
//             $mementoOperationData = $this->Memento->data();
//             if ( isset( $mementoOperationData['loop_run'] ) )
//                 $bodyCallCount['loop_run'] = $mementoOperationData['loop_run'];
//         }
        if ( isset( $mementoData['loop_data'] ) )
            $currentLoopData = $mementoData['loop_data'];
        if ( isset( $mementoData['skip_trigger'] ) )
        {
            $mementoData = null;
            return false;
        }
        else
        {
            $mementoData = null;
            return true;
        }

    }

    function executeClassMethod( $includeFile, $className, $methodName,
                                 $operationParameterDefinitions, $operationParameters )
    {
        include_once( $includeFile );
        if ( !class_exists( $className ) )
        {
            return array( 'internal_error' => EZ_MODULE_OPERATION_ERROR_NO_CLASS,
                          'internal_error_class_name' => $className );
        }
        $classObject =& $this->objectForClass( $className );
        if ( $classObject === null )
        {
            return array( 'internal_error' => EZ_MODULE_OPERATION_ERROR_CLASS_INSTANTIATE_FAILED,
                          'internal_error_class_name' => $className );
        }
        if ( !method_exists( $classObject, $methodName ) )
        {
            return array( 'internal_error' => EZ_MODULE_OPERATION_ERROR_NO_CLASS_METHOD,
                          'internal_error_class_name' => $className,
                          'internal_error_class_method_name' => $methodName );
        }
        $parameterArray = array();

        foreach ( $operationParameterDefinitions as $operationParameterDefinition )
        {
            $parameterName = $operationParameterDefinition['name'];
            if ( isset( $operationParameterDefinition['constant'] ) )
            {
                $constantValue = $operationParameterDefinition['constant'];
                $parameterArray[] = $constantValue;
            }
            else if ( isset( $operationParameters[$parameterName] ) )
            {
                // Do type checking
                $parameterArray[] = $operationParameters[$parameterName];
            }
            else
            {
                if ( $operationParameterDefinition['required'] )
                {

                    return array( 'internal_error' => EZ_MODULE_OPERATION_ERROR_MISSING_PARAMETER,
                                  'internal_error_parameter_name' => $parameterName );
                }
                else if ( isset( $operationParameterDefinition['default'] ) )
                {
                    $parameterArray[] = $operationParameterDefinition['default'];
                }
                else
                {
                    $parameterArray[] = null;
                }
            }
        }

        return $this->callClassMethod( $methodName, $classObject, $parameterArray );
    }

    function &objectForClass( $className )
    {
        $classObjectList =& $GLOBALS['eZModuleOperationClassObjectList'];
        if ( !isset( $classObjectList ) )
            $classObjectList = array();
        if ( isset( $classObjectList[$className] ) )
            return $classObjectList[$className];
        $classObject = new $className();
        $classObjectList[$className] =& $classObject;
        return $classObject;
    }

    function callClassMethod( $methodName, &$classObject, $parameterArray )
    {
        if ( $this->UseOldCall )
            return call_user_method_array( $methodName, $classObject, $parameterArray );
        else
            return call_user_func_array( array( $classObject, $methodName ), $parameterArray );
    }


    /// \privatesection
    var $ModuleName;
    var $FunctionList;
    var $IsValid;
    var $UseOldCall;
    var $UseTriggers = false;
}

?>
