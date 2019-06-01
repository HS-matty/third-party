<?php

class Logic_Datasource_App_Acl_User_Session_Table extends Datasource_Table  {

public function onInit(){
		
	
		parent::onInit();
		
		$this->setName('acl_user_session');
		$this->loadFields();
		
			
	}


}


?>