<?php

class Std_Type extends Std_Class  {
	
	const TYPE_Int = 'int';
	const TYPE_Float = 'float';
	const TYPE_Numeric = 'numeric';
	const TYPE_String = 'string';
	const TYPE_Bool = 'bool';
	const TYPE_Byte = 'byte';
	const TYPE_Undefined = 'undefined';
	
		
/*	public function __construct($value){

		$class_name = get_class($this);
		
		$class_name_array = split("_",$class_name);
		
		$type_name = $class_name_array[count($class_name_array)-1];
					
		$reflector = new ReflectionObject($this);
		if($constant = $reflector->getConstant('TYPE_'.$type_name)){
			
			$this->setType($constant);
		}else{
			$this->setType(Std_Type::TYPE_Undefined);
		}
		
		
		
		
 		$this->setValue($value);
		
		
	}*/
	
	public static function convert(Std_Type $from, Std_Type $to){
				
				
	}


}


?>