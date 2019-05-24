<?php

class Std_Class extends Element{

	public function __construct($param = null,$registry_auto_set = false){

		
		//check for type
		
		
		
		$class_name = get_class($this);
		
		$class_name_array = split("_",$class_name);
		
		$type_name = $class_name_array[count($class_name_array)-1];
					
		$reflector = new ReflectionObject($this);
		if($constant = $reflector->getConstant('TYPE_'.$type_name)){
			
			$this->setType($constant);
			
			
		}else{
			
			$this->setType(Std_Type::TYPE_Undefined);			
		}
			
 		
		
		//if Std_Class object - $param => $name
		//else $param => $value
		
		if($type_name == 'Class' || $registry_auto_set) $this->setName($param);
		else $this->setValue($param);
		
			
		if($registry_auto_set){
			Registry::set($param,$this);
		}
		
				

		
		$this->onInit();

		return $this;

	}




}


?>