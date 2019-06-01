<?php

class Logic_Ui_Page extends Ui_Page {
	
	public  $_default_template_name;
	public  $_default_sub_template_name;
	
	
	public $_template_action;
	public $_success_status;
	
	
	public  $_page_static;

	
	
	public function setStaticPage($page){
		$this->_page_static = $page;
		return $this;	
		
	}
	
	public function getStaticPage(){
		return $this->_page_static;
	}
	
	/**
	 *  template
	 *
	 * @var Logic_Template_Smarty
	 */
	public $_template;
	
	
	
	public function onInit(){
		
		parent::onInit();;
		$this->_template = new Logic_Template_Smarty();
		
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @return Logic_Template_Smarty
	 */
	public function getTemplate(){
		return $this->_template;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param Template $template
	 * @return Logic_Ui_Page
	 */
	public function setTemplate(Template $template){
		$this->_template = $template;
		return $this;
	}
	
	

	
	public function setDefaultTemplateName($template_name){
		
		$this->_default_template_name = $template_name;
	}
	
	
	public function setDefaultSubTemplateName($template_name){
		
		$this->_default_sub_template_name = $template_name;
	}
	
	
	public function getDefaultTemplateName($template_name){
		
		return $this->_default_template_name;
	}
	
	
	public function getDefaultSubTemplateName($template_name){
		
		return $this->_default_sub_template_name;
	}
	
	public function addParam($name,$value){

		
		
		if(strtolower($name) == 'grid' || strtolower($name) == 'form') {
			$ui = Registry::get('ui');
			$ui->window->workspace->addElement($value);
		}
		
		parent::addParam($name,$value);
		
		$this->getTemplate()->addParam($name,$value);
		
	
		
	}
	
	
	public function getStaticPageFileName($static_page,$is_smarty = true){
		
		return 'file:'.PATH_STATIC.$static_page;
		
	}
	public function loadStatic($page){
		
		$return_value = '';
		$file = PATH_STATIC.$page;
		
		if(file_exists($file)){
			
			$return_value = file_get_contents($file);
		}else{
			
			$return_value = $file . ' not found ';
			
		}
		
		return $return_value;
		
	}
	
	
	public function setTemplateDelimiterAlternative(){
		
		$this->getTemplate()->setTemplateDelimiter('{*','*}');
		
	}
	
	
	public function setTemplateDelimiterDefault(){
		$this->getTemplate()->setTemplateDelimiter();
	}
	
	public function alternative_delimiter(){
		return $this->setTemplateDelimiterAlternative();
	}
	
	public function default_delimiter(){
		return $this->setTemplateDelimiterDefault();
	}
	
	
	
}


?>



