<?php

require 'template.php';

//DeleteOldSessions();
session_start();

//$db->query("update sessions set created=null where id='".session_id()."'");

if( get_cfg_var('register_globals') ) {
	// register_globals enabled - must be used session_register()
	if(!session_is_registered('session')) {
		session_register('session');
		$session = array();
	} else {
		$session = &$HTTP_SESSION_VARS['session'];
	}
} else {
	if( !isset($HTTP_SESSION_VARS['session']) ) {
		$HTTP_SESSION_VARS['session'] = array();
	}
	$session = &$HTTP_SESSION_VARS['session'];
}

if( isset($HTTP_GET_VARS['ph']) ) {
  $session['selected_phone_id'] = (int)$HTTP_GET_VARS['ph'];
}

if( ($session['selected_phone_id'] < 1) ||
    ($session['selected_phone_id'] > 7) ) {
	$session['selected_phone_id'] = 0;
}

header("Content-type: text/html; charset=windows-1251");

?>