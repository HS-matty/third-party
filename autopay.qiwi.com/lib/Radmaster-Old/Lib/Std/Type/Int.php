<?php

class Std_Type_Int extends Std_Type{

	
/*	public function __construct($value = null){
		
		$this->_value = $value;
			
	}*/

	

	public function __toString(){
		return (string) $this->_value;
	}

	}

?>