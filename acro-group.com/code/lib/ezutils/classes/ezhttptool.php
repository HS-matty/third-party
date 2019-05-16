<?php
//
// Definition of eZHTTPTool class
//
// Created on: <18-Apr-2002 14:05:21 amos>
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

/*! \defgroup eZHTTP HTTP utilities
    \ingroup eZUtils */

/*!
  \class eZHTTPTool ezhttptool.php
  \ingroup eZHTTP
  \brief Provides access to HTTP post,get and session variables

  See PHP manual on <a href="http://www.php.net/manual/fi/language.variables.predefined.php">Predefined Variables</a> for more information.

*/

include_once( "lib/ezutils/classes/ezdebug.php" );
include_once( "lib/ezutils/classes/ezsession.php" );
include_once( "lib/ezutils/classes/ezsys.php" );

class eZHTTPTool
{
    /*!
     Initializes the class. Use eZHTTPTool::instance to get a single instance.
    */
    function eZHTTPTool()
    {
		$magicQuote = get_magic_quotes_gpc();

		if ( $magicQuote == 1 )
		{
			eZHTTPTool::removeMagicQuotes();
		}
    }

    /*!
     Sets the post variable \a $var to \a $value.
     \sa postVariable
    */
    function setPostVariable( $var, $value )
    {
        $_POST[$var] = $value;
    }

    /*!
     \return a reference to the HTTP post variable $var, or null if it does not exist.
     \sa variable
    */
    function &postVariable( $var )
    {
        $ret = null;
        if ( isset( $_POST[$var] ) )
            $ret =& $_POST[$var];
        else
            eZDebug::writeWarning( "Undefined post variable: $var",
                                   "eZHTTPTool" );
        return $ret;
    }

    /*!
     \return true if the HTTP post variable $var exist.
     \sa hasVariable
    */
    function hasPostVariable( $var )
    {
        return isset( $_POST[$var] );
    }

    /*!
     Sets the get variable \a $var to \a $value.
     \sa getVariable
    */
    function setGetVariable( $var, $value )
    {
        $_GET[$var] = $value;
    }

    /*!
     \return a reference to the HTTP get variable $var, or null if it does not exist.
     \sa variable
    */
    function &getVariable( $var )
    {
        $ret = null;
        if ( isset( $_GET[$var] ) )
            $ret =& $_GET[$var];
        else
            eZDebug::writeWarning( "Undefined get variable: $var",
                                   "eZHTTPTool" );
        return $ret;
    }

    /*!
     \return true if the HTTP get variable $var exist.
     \sa hasVariable
    */
    function hasGetVariable( $var )
    {
        return isset( $_GET[$var] );
    }

    /*!
     \return true if the HTTP post/get variable $var exists.
     \sa hasPostVariable
    */
    function hasVariable( $var )
    {

        if ( isset( $_POST[$var] ) )
        {
            return isset( $_POST[$var] );
        }
        else
        {
            return isset( $_GET[$var] );
        }
    }

    /*!
     \return a reference to the HTTP post/get variable $var, or null if it does not exist.
     \sa postVariable
    */
    function &variable( $var )
    {
        if ( isset( $_POST[$var] ) )
        {
            return $_POST[$var];
        }
        else
        {
            if ( isset( $_GET[$var] ) )
            {
                return $_GET[$var];
            }
            else
            {
                return false;
            }
        }
    }

    /*!
     \return the attributes for this object.
    */
    function &attributes()
    {
        return array( "post", "get", "session" );
    }

    /*!
     \return true if the attribute $attr exist.
    */
    function hasAttribute( $attr )
    {
        return $attr == "post" or $attr == "get" or $attr == "session";
    }

    /*!
     \return the value for the attribute $attr or null if the attribute does not exist.
    */
    function &attribute( $attr )
    {
        if ( $attr == "post" )
            return $_POST;
        if ( $attr == "get" )
            return $_GET;
        if ( $attr == "session" )
        {
            eZSessionStart();
            return $_SESSION;
//             return $GLOBALS["HTTP_SESSION_VARS"];
        }
        return null;
    }

    /*!
     \return the unique instance of the HTTP tool
    */
    function &instance()
    {
        $instance =& $GLOBALS["eZHTTPToolInstance"];
        if ( get_class( $instance ) != "ezhttptool" )
        {
            $instance = new eZHTTPTool();
            $instance->createPostVarsFromImageButtons();
        }
        return $instance;
    }

    /*!
     \static

     Sends a http request to the specified host. Using https:// requires PHP 4.3.0, and compiled in OpenSSL support.

     \param http/https address, only path to send request to eZ publish.
            examples: http://ez.no, https://secure.ez.no, ssl://secure.ez.no, content/view/full/2
     \param port, default 80
     \param post parameters array (optional), if no post parameters are present, a get request will be send.
     \param user agent, default will be eZ publish
     \param passtrough, will send result directly to client, default false

     \return result if http request, if pipetrough, program will end here.
    */
    function &sendHTTPRequest( $uri, $port = 80, $postParameters = false, $userAgent = 'eZ publish', $passtrough = true )
    {
        preg_match( "/^((http[s]?:\/\/)([a-zA-Z0-9_.]+))?([\/]?[~]?(\.?[^.]+[~]?)*)/i", $uri, $matches );
        $protocol = $matches[2];
        $host = $matches[3];
        $path = $matches[4];
        if ( !$path )
        {
            $path = '/';
        }

        $data = '';
        if ( $postParameters )
        {
            $method = 'POST';
            $dataCount = 0;
            foreach( array_keys( $postParameters ) as $paramName )
            {
                if ( $dataCount > 0 )
                {
                    $data .= '&';
                }
                ++$dataCount;
                if ( !is_array( $postParameters[$paramName] ) )
                {
                    $data .= urlencode( $paramName ) . '=' . urlencode( $postParameters[$paramName] );
                }
                else
                {
                    foreach( $postParameters[$paramName] as $value )
                    {
                        $data .= urlencode( $paramName ) . '[]=' . urlencode( $value );
                    }
                }
            }
        }
        else
        {
            $method = 'GET';
        }

        if ( !$host )
        {
            $host = $_SERVER['HTTP_HOST'];
            $filename = $host;
            if ( $path[0] != '/' )
            {
                $path = $_SERVER['SCRIPT_NAME'] . '/' . $path;
            }
            else
            {
                $path = $_SERVER['SCRIPT_NAME'] . $path;
            }
        }
        else{
            if ( !$protocol || $protocol == 'https://' )
            {
                $filename = 'ssl://' . $host;
            }
            else
            {
                $filename = 'tcp://' . $host;
            }
        }

        $fp = fsockopen( $filename, $port );

        $request = $method . ' ' . $path . ' ' . 'HTTP/1.1' . "\r\n" .
             "Host: $host\r\n" .
             "Accept: */*\r\n" .
             "Content-type: application/x-www-form-urlencoded\r\n" .
             "Content-length: " . strlen( $data ) . "\r\n" .
             "User-Agent: $userAgent\r\n" .
             "Pragma: no-cache\r\n" .
             "Connection: close\r\n\r\n";

        fputs( $fp, $request );
        if ( $method == 'POST' )
        {
            fputs( $fp, $data );
        }

        if ( $passtrough )
        {
            ob_end_clean();
            $header = true;

            $character = '';
            while( $header )
            {
                $buffer = $character;
                while ( !feof( $fp ) )
                {
                    $character = fgetc( $fp );
                    if ( $character == "\r" )
                    {
                        fgetc( $fp );
                        $character = fgetc( $fp );
                        if ( $character == "\r" )
                        {
                            fgetc( $fp );
                            $header = false;
                        }
                        break;
                    }
                    else
                    {
                        $buffer .= $character;
                    }
                }

                header( $buffer );
            }

            header( 'Content-Location: ' . $uri );

            fpassthru( $fp );
            include_once( 'lib/ezutils/classes/ezexecution.php' );
            eZExecution::cleanExit();
        }
        else
        {
            $buf = '';
            while ( !feof( $fp ) )
            {
                $buf .= fgets( $fp, 128 );
            }
        }

        fclose($fp);
        return $buf;
    }

    /*!
     \static
     Sends a redirect path to the browser telling it to
     load the new path.
     By default only \a $path is required, other parameters
     will be fetched automatically to create a HTTP/1.1
     compatible header.
     The input \a $parameters may contain the following keys.
     - host - the name of the host, default will fetch the currenty hostname
     - protocol - which protocol to use, default will use HTTP
     - port - the port on the host
     - username - a username which is required to login on the site
     - password - if username is supplied this password will be used for authentication

     The path may be specified relativily \c rel/ative, from root \c /a/root, with hostname
     change \c //myhost.com/a/root/rel/ative, with protocol \c http://myhost.com/a/root/rel/ative.
     Also port may be placed in the path string.
     It is recommended that the path only contain a plain root path and instead send the rest
     as optional parameters, the support for different kinds of paths is only incase you get
     URLs externally which contains any of the above cases.

     \note The redirection does not happen immedietaly and the script execution will continue.
    */
    function createRedirectUrl( $path, $parameters = array() )
    {
        $parameters = array_merge( array( 'host' => false,
                                          'protocol' => false,
                                          'port' => false,
                                          'username' => false,
                                          'password' => false,
                                          'override_host' => false,
                                          'override_protocol' => false,
                                          'override_port' => false,
                                          'override_username' => false,
                                          'override_password' => false,
                                          'pre_url' => true ),
                                   $parameters );
        $host = $parameters['host'];
        $protocol = $parameters['protocol'];
        $port = $parameters['port'];
        $username = $parameters['username'];
        $password = $parameters['password'];
        if ( preg_match( '#^([a-zA-Z0-9]+):(.+)$#', $path, $matches ) )
        {
            if ( $matches[1] )
                $protocol = $matches[1];
            $path = $matches[2];

        }
        if ( preg_match( '#^//((([a-zA-Z0-9_.]+)(:([a-zA-Z0-9_.]+))?)@)?([^./:]+(\.[^./:]+)*)(:([0-9]+))?(.*)$#', $path, $matches ) )
        {
            if ( $matches[6] )
            {
                $host = $matches[6];
            }

            if ( $matches[3] )
                $username = $matches[3];
            if ( $matches[5] )
                $password = $matches[5];
            if ( $matches[9] )
                $port = $matches[9];
            $path = $matches[10];
        }
        if ( $parameters['pre_url'] )
        {
            if ( strlen( $path ) > 0 and
                 $path[0] != '/' )
            {
                $preURL = eZSys::serverVariable( 'SCRIPT_URL' );
                if ( strlen( $preURL ) > 0 and
                     $preURL[strlen($preURL) - 1] != '/' )
                    $preURL .= '/';
                $path = $preURL . $path;
            }
        }

        if ( $parameters['override_host'] )
            $host = $parameters['override_host'];
        if ( $parameters['override_port'] )
            $port = $parameters['override_port'];
        if ( !is_string( $host ) )
            $host = eZSys::hostname();
        if ( !is_string( $protocol ) )
        {
            $protocol = 'http';
            // Default to https if SSL is enabled

            // Check if SSL port is defined in site.ini
            $ini =& eZINI::instance();
            $sslPort = 443;
            if ( $ini->hasVariable( 'SiteSettings', 'SSLPort' ) )
            {
                $sslPort = $ini->variable( 'SiteSettings', 'SSLPort' );
            }

            if ( eZSys::serverPort() == $sslPort )
            {
                $protocol = 'https';
                $port = false;
            }
        }
        if ( $parameters['override_protocol'] )
            $host = $parameters['override_protocol'];

        $uri = $protocol . '://';
        if ( $parameters['override_username'] )
            $username = $parameters['override_username'];
        if ( $parameters['override_password'] )
            $password = $parameters['override_password'];
        if ( $username )
        {
            $uri .= $username;
            if ( $password )
                $uri .= ':' . $password;
            $uri .= '@';
        }
        $uri .= $host;
        if ( $port )
            $uri .= ':' . $port;
        $uri .= $path;
        return $uri;
    }

    function redirect( $path, $parameters = array() )
    {
        $uri = eZHTTPTool::createRedirectUrl( $path, $parameters );
        eZHTTPTool::headerVariable( 'Location', $uri );

        /* Fix for redirecting using workflows and apache 2 */
        echo '<HTML><HEAD>';
        echo '<META HTTP-EQUIV="Refresh" Content="0;URL='. htmlspecialchars( $uri ) .'">';
        echo '<META HTTP-EQUIV="Location" Content="'. htmlspecialchars( $uri ) .'">';
        echo '</HEAD><BODY></BODY></HTML>';
    }

    /*!
     \static
     Sets the header variable \a $headerName to have the data \a $headerData.
     \note Calls PHPs header() with a constructed string.
    */
    function headerVariable( $headerName, $headerData )
    {
        header( $headerName .': '. $headerData );
    }

	function removeMagicQuotes()
	{
        foreach ( array_keys( $_POST ) as $key )
        {
			if ( !is_array( $_POST[$key] ) )
			{
				$_POST[$key] = str_replace( "\'", "'", $_POST[$key] );
				$_POST[$key] = str_replace( '\"', '"', $_POST[$key] );
				$_POST[$key] = str_replace( '\\\\', '\\', $_POST[$key] );
			}
            else
            {
                foreach ( array_keys( $_POST[$key] ) as $arrayKey )
                {
                    $_POST[$key][$arrayKey] = str_replace( "\'", "'", $_POST[$key][$arrayKey] );
                    $_POST[$key][$arrayKey] = str_replace( '\"', '"', $_POST[$key][$arrayKey] );
                    $_POST[$key][$arrayKey] = str_replace( '\\\\', '\\', $_POST[$key][$arrayKey] );
                }
            }
        }
        foreach ( array_keys( $_GET ) as $key )
        {
			if ( !is_array( $_GET[$key] ) )
			{
				$_GET[$key] = str_replace( "\'", "'", $_GET[$key] );
				$_GET[$key] = str_replace( '\"', '"', $_GET[$key] );
				$_GET[$key] = str_replace( '\\\\', '\\', $_GET[$key] );
			}
            else
            {
                foreach ( array_keys( $_GET[$key] ) as $arrayKey )
                {
                    $_GET[$key][$arrayKey] = str_replace( "\'", "'", $_GET[$key][$arrayKey] );
                    $_GET[$key][$arrayKey] = str_replace( '\"', '"', $_GET[$key][$arrayKey] );
                    $_GET[$key][$arrayKey] = str_replace( '\\\\', '\\', $_GET[$key][$arrayKey] );
                }
            }
        }
	}

    function createPostVarsFromImageButtons()
    {
        foreach ( array_keys( $_POST ) as $key )
        {
            if ( substr( $key, -2 ) == '_x' )
            {
                $yKey = substr( $key, 0, -2 ) . '_y';
                if ( array_key_exists( $yKey, $_POST ) )
                {
                    $keyClean = substr( $key, 0, -2 );
                    $matches = array();
                    if ( preg_match( "/_(\d+)$/", $keyClean, $matches ) )
                    {
                        $value = $matches[1];
                        $keyClean = preg_replace( "/(_\d+)$/","", $keyClean );
                        $_POST[$keyClean] = $value;
//                         eZDebug::writeDebug( $_POST[$keyClean], "We have create new  Post Var with name $keyClean and value $value:" );
                    }
                    else
                    {
                        $_POST[$keyClean] = true;
//                         eZDebug::writeDebug( $_POST[$keyClean], "We have create new  Post Var with name $keyClean and value true:" );
                    }
                }
            }
        }
    }

    /*!
     Sets the session variable $name to value $value.
    */
    function getSessionKey()
    {
        eZSessionStart();
        return session_id();
    }

    function setSessionKey( $sessionKey )
    {
        eZSessionStart();
        return session_id( $sessionKey );
    }

    function setSessionVariable( $name, $value )
    {
        eZSessionStart();
//         session_register( $name );
        $_SESSION[$name] =& $value;
    }

    /*!
     Removes the session variable $name.
    */
    function removeSessionVariable( $name )
    {
        eZSessionStart();
//         session_unregister( $name );
        unset( $_SESSION[$name] );
    }

    /*!
     \return true if the session variable $name exist.
    */
    function hasSessionVariable( $name )
    {
        eZSessionStart();
//         global $HTTP_SESSION_VARS;
        return isset( $_SESSION[$name] );
    }

    /*!
     \return the session variable $name.
    */
    function &sessionVariable( $name )
    {
        eZSessionStart();
//         global $HTTP_SESSION_VARS;
        return $_SESSION[$name];
    }

    /*!
     \return the session id
    */
    function sessionID()
    {
        eZSessionStart();
        return session_id();
    }
}

?>
