<?php

class Logic_Ui_Template extends Logic_Template_Smarty{

	public function preparePath($tpl){
		$ui_type = Registry::get('ui_type');
		
		return  PATH_TEMPLATE.'/'.$ui_type.$tpl;
		//return file_get_contents($file);
		
	}

	public function getTemplate($template_name,$template_action_type = 'edit',$sub_template = null,$default_template_type='default'){
		
		$return_value = null;
		$ui_type = Registry::get('ui_type');
		
		$filename =  PATH_TEMPLATE.'/'.$ui_type."/@ui/@element/form/@el/{$template_name}/";
		if($sub_template) $filename = $filename.$sub_template.'/';
		$filename = $filename.$template_action_type.'.tpl';
		Log_Output::add($filename);
	/*	echo $filename;
		exit();*/
		if(file_exists($filename)) $return_value = $filename;
		else{
			$filename =  PATH_TEMPLATE.'/'.$ui_type."/@ui/@element/form/@el/@default/edit.tpl";
			if(file_exists($filename)) $return_value = $filename;
		}
		
		return $return_value;
	}


	

}

?>