<?php

class Value extends Std_Class{
	
	
	public function __construct($value = null,$registry_auto_set = false){

		$this->setName('value');
		$this->setValue($value);
		
	}
	
	public function __toString(){
		return (string) $this->_value;
	}

	
}


?>