<?php

require 'core/template.php';

class cTemplate extends coreTemplate {
  function parse() {
	global $session;

	$this->param['selected_phone_id'] = $session['selected_phone_id'];

	return parent::parse();
  }
}

?>