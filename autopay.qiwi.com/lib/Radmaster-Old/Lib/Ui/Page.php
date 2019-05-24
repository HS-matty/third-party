<?php

class Ui_Page extends Std_Class {
	
	protected $_console;
	
	
	public function onInit(){
		$this->_console = new Std_Class();
						
	}
				
			
	public function addParam($name,$value){

		
		
		if(strtolower($name) == 'grid' || strtolower($name) == 'form') {
			$app = Registry::get('app');
			$app->window->workspace->addElement($value);
		}
		
		parent::addParam($name,$value);
	
		
	}
	
}

?>