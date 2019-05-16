<?php

////////////////////////////////////////////////
// Oodle API - PHP5 Helper Library            //
// (c) 2007, Oodle Inc.                       //
////////////////////////////////////////////////

// XML/RPC.php is the PEAR XML-RPC package
// This class depends on that package being installed first.
// See http://pear.php.net/package/XML_RPC/
require_once('XML/RPC.php');

class OodleApi {

    // YOUR API KEY GOES HERE
    var $API_KEY     = 'YOUR-API-KEY';

    // Oodle XML-RPC server constants.  Leave these alone.
    var $SERVER_NAME = 'api.oodle.com';
    var $SERVER_PATH = '/api/';
    var $SERVER_PORT = '80';
    var $client;

    /**
     * Constructor
     * Instantiates OodleAPI object with XML-RPC client ready to go
     */
    function __construct() {
        $this->client = new XML_RPC_Client(
            $this->SERVER_PATH,
            $this->SERVER_NAME,
            $this->SERVER_PORT
        );
    }

    /**
     * Takes an array of request data.
     * Returns the XML-RPC result.
     */
    function make_request( $method, $methodParams ) {

        // automatically add our required Oodle API Key onto every query
        $methodParams['partner_id'] = $this->API_KEY;
        $params = array(XML_RPC_encode($methodParams));

        // make the request to the Oodle API
        $request  = new XML_RPC_Message($method,$params);
        $response = $this->client->send($request);

        // quick error handling
        if ($response->faultCode())
        {
            // error handling - print error code and error message
            print "Error retrieving data: " . $response->faultCode() . "\n";
            print "Error message: " . $response->faultString() . "\n";
            return;
        }

        // the actual listings data return by Oodle is here
        $results = XML_RPC_decode($response->value());
        return $results;

    }

}

?>
