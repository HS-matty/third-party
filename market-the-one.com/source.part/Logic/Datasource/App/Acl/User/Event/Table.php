<?php

class Logic_Datasource_App_Acl_User_Event_Table extends Datasource_Table  {

public function onInit(){
		
	
		parent::onInit();
		
		$this->setName('acl_user_event');
		$this->loadFields();
		
			
	}


}


?>