<?php

abstract class Controller extends Module {
	
	var $SelfModuleName = 'not_defined';
	var $Module;
	var $Object; 
	public $RedirectFlag = 0;
	
	
	function __construct($Module,$Object,$User)
	{
				
		$this->Module = $Module;
		$this->Object = $Object;
		$this->User = $User;
		
		


	}
	
	protected function GetModule(){
		return $this->Module;
		
	}
	public 	function &GetAllowedModulesList(){
	
		return $Modules->GetUserAvailableModules($this->User);
		
	}
	
	protected function GetObject(){
	
		return $this->Object;
	}
	
	protected function GetUser(){
	
		return $this->User;
	}
	
	abstract  function GetPageObject($Lang,$SideType,$View = 'common');
	
	
		

	

}

?>