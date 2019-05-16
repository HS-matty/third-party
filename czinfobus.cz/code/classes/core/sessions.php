<?php

function session_handler_open($save_path,$sess_name) {
    return true;
}

function session_handler_close() {
    return true;
}

function session_handler_read($id) {
    global $db,$sess_table;

    if( !$db->query("select a_session from $sess_table where id='$id'") ) return "";
    $ret = $db->fetch_array();
    if( !$ret ) return "";
    return (string)($ret[0]);
}

function session_handler_write($id,$sess_data) {
    global $db,$sess_table;

    $ret = $db->query("select count(*) from $sess_table where id='$id'");
    if( !$ret ) return false;
    $ret = $db->fetch_array();

	$sess_data = mysql_escape_string($sess_data);

    if( $ret[0]>0 ) {
	$ret = $db->query("update $sess_table set a_session='$sess_data' where id='$id'");
    } else {
	$ret = $db->query("insert into $sess_table set id='$id', a_session='$sess_data'");
    }

    if( !$ret ) return false;
    return true;
}

function session_handler_destroy($id) {
    global $db,$sess_table;

    if( !$db->query("delete from $sess_table where id='$id'") ) return false;
    return true;
}

function session_handler_gc($maxlifetime) {
    return true;
}

function session_handlers_register() {
   session_set_save_handler("session_handler_open",
			    "session_handler_close",
			    "session_handler_read",
			    "session_handler_write",
			    "session_handler_destroy",
			    "session_handler_gc");
}

function DeleteOldSessions() {
	global $db,$config,$sess_table;

	$timeout = (int)($config->session_timeout);
	if( !$db->query("select id from $sess_table where adddate(created,interval ".$timeout." minute)<now()") )
		return false;

	$sids = array();
	for( $i=0; $i<$db->rows(); $i++ ) {
		if( !$sids[] = $db->fetch_object() )
			return false;
	}

	for( $i=0; $i<count($sids); $i++ ) {
		$db->query("delete from $sess_table where id='".$sids[$i]->id."'");
	}

	return true;
}

session_handlers_register();

?>