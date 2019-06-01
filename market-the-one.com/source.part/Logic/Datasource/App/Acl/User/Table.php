<?php

class Logic_Datasource_App_Acl_User_Table extends Datasource_Table  {

public function onInit(){
		
	
		parent::onInit();
		
		
	//	$current_dir = dirname(__FILE__);
		
//		include($current_dir.'/_Table/_fields.php');
		
		
		$this->setName('acl_user');
		$this->loadFields();
		
		
	//	$this->setFields($fields);
	//	$table_name = $this->getName();
	
		

		
			
	}


}


?>