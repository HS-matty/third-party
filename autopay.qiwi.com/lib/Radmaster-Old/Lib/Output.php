<?php

class Output extends Std_Class{
	
	
	const Type_HTML  = 'html';
	const Type_FILE  = 'file';
	const Type_JSON =  'json';
	const Type_XML = 'xml';
	
	protected $_header;
	
	public function onInit(){
		
		$this->_header = new Element('header');
		
		
	}
	
	
	
	
	
}


?>