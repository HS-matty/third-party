<?php

class Datasource_File extends Std_Class {
	
	
	
	public function __construct($param=null){
		
		if($param){
			$this->loadFile($param);
		}
		
		
		
		
	}
	
	
	public function loadFile($file){
		$this->setName($file);
		$this->setValue(file_get_contents($file));
	}
}

?>