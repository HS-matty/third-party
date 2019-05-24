<?php

class Ui_Action extends Std_Class  {
	
	
	
	const Type_CLICK = 'click';
	
	
	public function __construct($name = null){
		
		$this->setName($name);
	}
	
	public function __get($var_name)
	{
		
		
		$return_value = null;
		
		if(!preg_match('/^\_/',$var_name)) {
			$_var_name = '_'.$var_name;
			
			if(property_exists($this,$_var_name)){
				$return_value = $this->$_var_name;
			}else{
				$return_value = $this->getElement($var_name);
			}
			
		}

		

		if(!$return_value) {
			$action =  new Ui_Action();
			$action->setName($var_name);
		//	$this->addElement($action);
		
			$return_value = $action;
			
		}
		
		return $return_value;
	}
	
}


?>