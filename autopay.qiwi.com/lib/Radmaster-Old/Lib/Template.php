<?php

class Template extends Std_Class{
	
	public function preparePath($tpl){
		
		return  PATH_TEMPLATE.$tpl;
		//return file_get_contents($file);
		
	}
	
}

?>