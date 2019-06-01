<?php

class  Logic_Template_Smarty extends Std_Class {

	public $_compiler;

	public $_base_path;

	public $left_delimiter = "{";
	public $right_delimiter = "}";



	//public $_ui_type_vendor =

	const TYPE_TEMPLATE_VENDOR_BOOTSTRAP  = 'bootstrap';
	const TYPE_TEMPLATE_VENDOR_SMARTADMIN  = 'smart-admin';

	/**
	 * Enter description here...
	 *
	 * @param string $path
	 * @return Logic_Template_Smarty
	 */
	public function setBasePath($path){

		$this->_base_path = $path;

		$this->getCompiler()->template_dir = $this->getBasePath();
		return $this;
	}
	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getBasePath(){
		return $this->_base_path;
	}



	public function setDir(){


		$ui_type = Registry::get('ui_type');
		//exit($ui_type);
		$this->getCompiler()->compile_dir = PATH_APP_DATA.'/_tmp/smarty/'.$ui_type.'/templates_c/';
		$this->getCompiler()->config_dir = PATH_APP_DATA.'/_tmp/smarty/'.$ui_type.'/configs/';
		$this->getCompiler()->cache_dir =  PATH_APP_DATA.'/_tmp/smarty/'.$ui_type.'/cache/';



		$this->setBasePath(PATH_TEMPLATE_INDEX.'/'.$ui_type.'/');
		//PATH_ROOT.'/Front'.
		//$this->setBasePath(PATH_ROOT.'/Front');
	

		$this->getCompiler()->template_dir = $this->getBasePath();
		
		
		return $this;

	}

	public function onInit(){

		parent::onInit();


		require_once(PATH_LIB.'/smarty/Smarty.class.php');

		//	require_once(PATH_LIB.'/smarty/Smarty_Compiler.class.php');




		$smarty  = new Smarty();

		$this->setCompiler($smarty);

		define('SMARTY_DIR',PATH_LIB.'/smarty/');
		$smarty->caching = false;
		$smarty->force_compile = true;
		
		

	//	$this->setDir();

		/*
		$smarty->assign('host_name',$config->getParam('hostname'));
		$smarty->assign('HostName',$Config->Hostname);
		$smarty->assign('request_uri',$request_uri);

		$window = Registry::get('window');
		$log = Registry::get('log');

		$smarty->assign('window',$window);
		$smarty->assign('app',$app);
		$smarty->assign('registry',Registry::getInstance());
		$smarty->assign('page',$page);
		$smarty->assign('log',$log);*/

		//	$smarty ->auto_literal = false;
		//	$smarty ->left_delimiter = $this->_left_delimiter;//"{*";
		//	$smarty ->right_delimiter = $this->_right_delimiter;//"*}";



	}
	public function setTemplateDelimiter($left = '{',$right = '}'){
		$this->_left_delimiter = $left;
		$this->_right_delimiter = $right;

		$this->getCompiler()->left_delimiter = $left;
		$this->getCompiler()->right_delimiter = $right;


		return $this;
	}
	
	



	/**
	 * Enter description here...
	 *
	 * @param unknown_type $compiler
	 * @return unknown
	 */
	public function setCompiler($compiler){
		$this->_compiler = $compiler;
		return $this;

	}
	/**
	 * Enter description here...
	 *
	 * @return Smarty
	 */
	public function getCompiler(){

		return $this->_compiler;
	}

	public function compile($file){

		$this->setDir();
		return $this->getCompiler()->fetch($file);

	}
	
	
	public function compileFile($file){

		$this->setDir();
		$this->setDefaultParams();
		return $this->getCompiler()->fetch('file:'.$file);

	}
	
	
	
	

	public function addParam($name,$value){
		parent::addParam($name,$value);

		$this->getCompiler()->assign($name,$value);
		return $this;

	}
	
	public function setDefaultParams(){
		$page = Registry::get('page');
		$params = $page->getAllParam();
		
		foreach ($params as $key=>$value){
			$this->getCompiler()->assign($key,$value);
		}
		return ;
	}

}

?>