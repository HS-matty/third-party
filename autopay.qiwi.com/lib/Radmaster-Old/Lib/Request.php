<?php

class Request extends Std_Class{


	public function getClassName(){

		$class_name = '';
		if($class = $this->getElement(0)){

			if($class->hasElements()){
				foreach ($class->getElements()  as $key=> $sub_class){
					if($key) $class_name .= '_';
					$class_name = ucfirst(strtolower( (string) $sub_class));

				}

			}else $class_name = ucfirst(strtolower( (string) $class));

		}

		return $class_name;

	}

	public function getClassParam(){


		return  (string) $this->getElement(1);






	}

	public function getAddParam(){

		return  (string) $this->getElement(2);
	}


	public function getParam($param_name, $escape= false){

		$return_value = null;

		if( isset($_REQUEST[$param_name]) ) {
			if($escape) $return_value =  $this->_escape($_REQUEST[$param_name]);
			else $return_value=  $_REQUEST[$param_name];
		}

		return $return_value;

	}


}


?>