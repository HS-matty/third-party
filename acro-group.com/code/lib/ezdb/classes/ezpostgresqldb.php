<?php
//
// $Id$
//
// Definition of eZPostgreSQLLDB class
//
// Created on: <25-Feb-2002 14:08:32 bf>
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

/*!
  \class eZPostgreSQLDB ezpostgresqldb.php
  \ingroup eZDB
  \brief  The eZPostgreSQLDB class provides PostgreSQL database functions.

  eZPostgreSQLDB implementes PostgreSQLDB specific database code.

  \sa eZDB
*/

include_once( "lib/ezutils/classes/ezdebug.php" );
include_once( "lib/ezutils/classes/ezini.php" );
include_once( "lib/ezdb/classes/ezdbinterface.php" );

class eZPostgreSQLDB extends eZDBInterface
{
    /*!
      Creates a new eZPostgreSQLDB object and connects to the database.
    */
    function eZPostgreSQLDB( $parameters )
    {
        $this->eZDBInterface( $parameters );

        if ( !extension_loaded( 'pgsql' ) )
        {
            if ( function_exists( 'eZAppendWarningItem' ) )
            {
                eZAppendWarningItem( array( 'error' => array( 'type' => 'ezdb',
                                                              'number' => EZ_DB_ERROR_MISSING_EXTENSION ),
                                            'text' => 'PostgreSQL extension was not found, the DB handler will not be initialized.' ) );
                $this->IsConnected = false;
                return;
            }
        }

        $ini =& eZINI::instance();

        $server = $this->Server;
        $db = $this->DB;
        $user = $this->User;
        $password = $this->Password;

        if ( $ini->variable( "DatabaseSettings", "UsePersistentConnection" ) == "enabled" &&  function_exists( "pg_pconnect" ))
        {
            eZDebugSetting::writeDebug( 'kernel-db-postgresql', $ini->variable( "DatabaseSettings", "UsePersistentConnection" ), "using persistent connection" );
            $this->DBConnection = pg_pconnect( "host='$server' dbname='$db' user='$user' password='$password'" );
            $maxAttempts = $this->connectRetryCount();
            $waitTime = $this->connectRetryWaitTime();
            $numAttempts = 1;
            while ( $this->DBConnection == false and $numAttempts <= $maxAttempts )
            {
                sleep( $waitTime );
                $this->DBConnection = pg_pconnect( "host='$server' dbname='$db' user='$user' password='$password'" );
                $numAttempts++;
            }
            if ( $this->DBConnection )
                $this->IsConnected = true;
            // add error checking
//          eZDebug::writeError( "Error: could not connect to database." . pg_errormessage( $this->DBConnection ), "eZPostgreSQLDB" );
        }
        else if ( function_exists( "pg_connect" ) )
        {
            eZDebugSetting::writeDebug( 'kernel-db-postgresql', "using real connection",  "using real connection" );
            $this->DBConnection = pg_connect( "host='$server' dbname='$db' user='$user' password='$password'" );
            $maxAttempts = $this->connectRetryCount();
            $waitTime = $this->connectRetryWaitTime();
            $numAttempts = 1;
            while ( $this->DBConnection == false and $numAttempts <= $maxAttempts )
            {
                sleep( $waitTime );
                $this->DBConnection = pg_connect( "host='$server' dbname='$db' user='$user' password='$password'" );
                $numAttempts++;
            }
            if ( $this->DBConnection )
                $this->IsConnected = true;
        }
        else
        {
            $this->IsConnected = false;
            eZDebug::writeError( "PostgreSQL support not compiled into PHP, contact your system administrator", "eZPostgreSQLDB" );

        }
    }

    /*!
     \reimp
    */
    function databaseName()
    {
        return 'postgresql';
    }

    /*!
     \reimp
    */
    function &query( $sql )
    {
        if ( $this->isConnected() )
        {
            if ( $this->OutputSQL )
            {
                eZDebug::accumulatorStart( 'postgresql_query', 'postgresql_total', 'Postgresql_queries' );
                $this->startTimer();

            }
            $result = @pg_exec( $this->DBConnection, $sql );
            if ( $this->OutputSQL )
            {
                $this->endTimer();
                eZDebug::accumulatorStop( 'postgresql_query' );
                $this->reportQuery( 'eZPostgreSQLDB', $sql, false, $this->timeTaken() );
            }

            if ( !$result )
            {
                eZDebug::writeError( "Error: error executing query: $sql " . pg_errormessage ( $this->DBConnection ), "eZPostgreSQLDB" );
                $this->setError();
            }
        }
        return $result;
    }


    /*!
     \reimp
    */
    function &arrayQuery( $sql, $params = array() )
    {
        $retArray = array();
        if ( $this->isConnected() )
        {
            $limit = -1;
            $offset = 0;
            // check for array parameters
            if ( is_array( $params ) )
            {
//                $params = $min;


                $column = false;
                if ( isset( $params["limit"] ) and is_numeric( $params["limit"] ) )
                {
                    $limit = $params["limit"];
                }

                if ( isset( $params["offset"] ) and is_numeric( $params["offset"] ) )
                {
                    $offset = $params["offset"];
                }
                if ( isset( $params["column"] ) and is_numeric( $params["column"] ) )
                    $column = $params["column"];
            }

            if ( $limit != -1 )
            {
                $sql .= "\nLIMIT $limit";
            }
            if ( $offset > 0 )
            {
                if ( $limit == -1 )
                    $sql .= "\n";
                else
                    $sql .= " ";
                $sql .= "OFFSET $offset";
            }
            $result =& $this->query( $sql );

            if ( $result == false )
            {
                return false;
            }

            $offset = count( $retArray );

            if ( pg_numrows( $result ) > 0 )
            {
                if ( !is_string( $column ) )
                {
                    for($i = 0; $i < pg_numrows($result); $i++)
                    {
                        $retArray[$i + $offset] =& pg_fetch_array ( $result, $i );
                    }
                }
                else
                {
                    for ($i = 0; $i < pg_numrows( $result ); $i++ )
                    {
                        $tmp_row =& pg_fetch_array ( $result, $i );
                        $retArray[$i + $offset] =& $tmp_row[$column];
                    }
                }
            }
            pg_freeresult( $result );
        }
        return $retArray;
    }

    /*!
     \private
    */
    function subString( $string, $from, $len = null )
    {
        if ( $len == null )
        {
            return " substring( $string from $from ) ";
        }else
        {
            return " substring( $string from $from for $len ) ";
        }

    }

    function concatString( $strings = array() )
    {
        $str = implode( " || " , $strings );
        return "  $str   ";
    }

    function md5( $str )
    {
        return " encode(digest( $str, 'md5' ), 'hex' ) ";
    }

    /*!
     \reimp
    */
    function supportedRelationTypeMask()
    {
        return ( EZ_DB_RELATION_TABLE_BIT |
                 EZ_DB_RELATION_SEQUENCE_BIT |
                 EZ_DB_RELATION_TRIGGER_BIT |
                 EZ_DB_RELATION_VIEW_BIT |
                 EZ_DB_RELATION_INDEX_BIT );
    }

    /*!
     \reimp
    */
    function supportedRelationTypes()
    {
        return array( EZ_DB_RELATION_TABLE,
                      EZ_DB_RELATION_SEQUENCE,
                      EZ_DB_RELATION_TRIGGER,
                      EZ_DB_RELATION_VIEW,
                      EZ_DB_RELATION_INDEX );
    }

    /*!
     \private
    */
    function relationKind( $relationType )
    {
        $kind = array( EZ_DB_RELATION_TABLE => 'r',
                       EZ_DB_RELATION_SEQUENCE => 'S',
                       EZ_DB_RELATION_TRIGGER => 't',
                       EZ_DB_RELATION_VIEW => 'v',
                       EZ_DB_RELATION_INDEX => 'i' );
        if ( !isset( $kind[$relationType] ) )
            return false;
        return $kind[$relationType];
    }

    /*!
     \reimp
    */
    function relationCounts( $relationMask )
    {
        $relationTypes = $this->supportedRelationTypes();
        $relationKinds = array();
        foreach ( $relationTypes as $relationType )
        {
            $relationBit = (1 << $relationType );
            if ( $relationMask & $relationBit )
            {
                $relationKind = $this->relationKind( $relationType );
                if ( $relationKind )
                    $relationKinds[] = $relationKind;
            }
        }
        if ( count( $relationKinds ) == 0 )
            return 0;
        $count = false;
        $relkindText = '';
        $i = 0;
        foreach ( $relationKinds as $relationKind )
        {
            if ( $i > 0 )
                $relkindText .= ' OR ';
            $relkindText .= "relkind='$relationKind'";
            $i++;
        }
        if ( $this->isConnected() )
        {
            $sql = "SELECT COUNT( relname ) as count FROM pg_class WHERE ( $relkindText ) AND NOT relname~'pg_.*'";
            $array = $this->arrayQuery( $sql, array( 'column' => '0' ) );
            $count = $array[0];
        }
        return $count;
    }

    /*!
      \reimp
    */
    function relationCount( $relationType = EZ_DB_RELATION_TABLE )
    {
        $count = false;
        $relationKind = $this->relationKind( $relationType );
        if ( !$relationKind )
        {
            eZDebug::writeError( "Unsupported relation type '$relationType'", 'eZPostgreSQLDB::relationCount' );
            return false;
        }

        if ( $this->isConnected() )
        {
            $sql = "SELECT COUNT( relname ) as count FROM pg_class WHERE relkind='$relkind' AND NOT relname~'pg_.*'";
            $array = $this->arrayQuery( $sql, array( 'column' => 0 ) );
            $count = $array[0];
        }
        return $count;
    }

    /*!
      \reimp
    */
    function relationList( $relationType = EZ_DB_RELATION_TABLE )
    {
        $count = false;
        $relationKind = $this->relationKind( $relationType );
        if ( !$relationKind )
        {
            eZDebug::writeError( "Unsupported relation type '$relationType'", 'eZPostgreSQLDB::relationList' );
            return false;
        }

        $array = array();
        if ( $this->isConnected() )
        {
            $sql = "SELECT relname FROM pg_class WHERE relkind='$relationKind' AND NOT relname~'pg_.*'";
            $array = $this->arrayQuery( $sql, array( 'column' => '0' ) );
        }
        return $array;
    }

    /*!
     \reimp
    */
    function eZTableList()
    {
        $array = array();
        if ( $this->isConnected() )
        {
            foreach ( array ( EZ_DB_RELATION_TABLE, EZ_DB_RELATION_SEQUENCE ) as $relationType )
            {
                $sql = "SELECT relname FROM pg_class WHERE relkind='" . $this->relationKind( $relationType ) . "' AND relname like 'ez%'";
                foreach ( $this->arrayQuery( $sql, array( 'column' => '0' ) ) as $result )
                {
                    $array[$result] = $relationType;
                }
            }
        }
        return $array;
    }

    /*!
      \reimp
    */
    function removeRelation( $relationName, $relationType )
    {
        $relationTypeName = $this->relationName( $relationType );
        if ( !$relationTypeName )
        {
            eZDebug::writeError( "Unsupported relation type '$relationType'", 'eZPostgreSQLDB::removeRelation' );
            return false;
        }

        if ( $this->isConnected() )
        {
            $sql = "DROP $relationTypeName $relationName";
            return $this->query( $sql );
        }
        return false;
    }

    /*!
     \reimp
    */
    function lock( $table )
    {
        $this->begin();
        if ( $this->isConnected() )
        {
            if ( is_array( $table ) )
            {
                $lockQuery = "LOCK TABLE";
                $first = true;
                foreach( array_keys( $table ) as $tableKey )
                {
                    if ( $first == true )
                        $first = false;
                    else
                        $lockQuery .= ",";
                    $lockQuery .= " " . $table[$tableKey]['table'];
                }
                $this->query( $lockQuery );
            }
            else
            {
                $this->query( "LOCK TABLE $table" );
            }
        }
    }

    /*!
     \reimp
    */
    function unlock()
    {
        $this->commit();
    }

    /*!
     \reimp
    */
    function begin()
    {
        $counter = $this->TransactionCounter++;
        if ( $counter > 0 )
            return false;
        if ( $this->isConnected() )
        {
            $this->query( "BEGIN WORK" );
        }
        return true;
    }

    /*!
     \reimp
    */
    function commit()
    {
        if ( $this->TransactionCounter <= 0 )
        {
            eZDebug::writeError( 'No transaction in progress, cannot commit', 'eZPostgreSQLDB::commit' );
            return false;
        }
        --$this->TransactionCounter;
        if ( $this->TransactionCounter == 0 )
        {
            if ( $this->isConnected() )
            {
                $this->query( "COMMIT WORK" );
            }
        }
        return true;
    }

    /*!
     \reimp
    */
    function rollback()
    {
        if ( $this->TransactionCounter <= 0 )
        {
            eZDebug::writeError( 'No transaction in progress, cannot rollback', 'eZPostgreSQLDB::rollback' );
            return false;
        }
        --$this->TransactionCounter;
        if ( $this->isConnected() )
        {
            $this->query( "ROLLBACK WORK" );
        }
    }

    /*!
     \reimp
    */
    function lastSerialID( $table, $column = 'id' )
    {
        if ( $this->isConnected() )
        {
            $sql = "SELECT currval( '" . $table . "_s')";
            $result = @pg_exec( $this->DBConnection, $sql );
            if ( !$result )
            {
                eZDebug::writeError( "Error: error executing query: $sql " . pg_errormessage( $this->DBConnection ), "eZPostgreSQLDB" );
            }

            if ( $result )
            {
                $array = pg_fetch_row( $result, 0 );
                $id = $array[0];
            }
        }
        return $id;
    }

    /*!
     \reimp
    */
    function setError( )
    {
        if ( $this->DBConnection )
        {

            $this->ErrorMessage = pg_errormessage ( $this->DBConnection );
            if ( $this->ErrorMessage != '' )
            {
                $this->ErrorNumber = 1;
            }
            else
            {
                $this->ErrorNumber = 0;
            }

        }
    }

    /*!
     \reimp
    */
    function &escapeString( $str )
    {
        $str = str_replace ("'", "\'", $str );
        $str = str_replace ("\"", "\\\"", $str );
        return $str;
    }

    /*!
     \reimp
    */
    function close()
    {
        @pg_close();
    }

    /*!
     \reimp
    */
    function isCharsetSupported( $charset )
    {
        return true;
    }

     /*!
     \reimp
    */
    function databaseServerVersion()
    {
        if ( $this->isConnected() )
        {
            $sql = "SELECT version()";
            $result = @pg_exec( $this->DBConnection, $sql );
            if ( !$result )
            {
                eZDebug::writeError( "Error: error executing query: $sql " . pg_errormessage( $this->DBConnection ), "eZPostgreSQLDB" );
            }

            if ( $result )
            {
                $array = pg_fetch_row( $result, 0 );
                $versionText = $array[0];
            }
            list ( $dbType, $versionInfo ) = split( " ", $versionText );
            $versionArray = explode( '.', $versionInfo );
            return array( 'string' => $versionInfo,
                          'values' => $versionArray );
        }
        return false;
    }

    /*!
     Sets PostgreSQL sequence values to the maximum values used in the corresponding columns.
    */
    function correctSequenceValues()
    {
        if ( $this->isConnected() )
        {
            $rows =& $this->arrayQuery( "SELECT pg_class.relname AS table, pg_attribute.attname AS column
                FROM pg_class,pg_attribute,pg_attrdef
                WHERE pg_attrdef.adsrc LIKE 'nextval(%'
                    AND pg_attrdef.adrelid=pg_attribute.attrelid
                    AND pg_attrdef.adnum=pg_attribute.attnum
                    AND pg_attribute.attrelid=pg_class.oid" );
            foreach ( $rows as $row )
            {
                $this->query( "SELECT setval('".$row['table']."_s', max(".$row['column'].")) from ".$row['table'] );
            }
            return true;
        }
        return false;
    }

    /// \privatesection

}

?>
