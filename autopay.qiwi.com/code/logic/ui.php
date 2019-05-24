<?php

class Logic_Ui{


	protected $_app_dir_path = '';


	public function setApplicationDirPath($path){
		$this->_app_dir_path = $path;
	}

	public function getTemplate_form($tpl_file_name = 'form.tpl'){

		$file = PATH_TEMPLATE.'/_ui/ru/'.$tpl_file_name;
		return $file;

	}
	public function getTemplate_grid($tpl_file_name = 'grid.tpl'){
		$file = PATH_TEMPLATE.'/_ui/ru/'.$tpl_file_name;
		return $file;

	}
	public function getTemplate_form_type($tpl_file_name){
		$file = PATH_TEMPLATE.'/_ui/ru/form_type/'.$tpl_file_name;
		return $file;

	}
	
	public function getIndexTmpl($file_name){
		return $this->getTemplate_form_type($file_name);
	}

}

?>