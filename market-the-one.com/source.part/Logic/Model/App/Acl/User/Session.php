<?php

class Logic_Model_App_Acl_User_Session extends Logic_Model {

	public function onInit(){

		parent::onInit();
		$datasource = new Logic_Datasource_App_Acl_User_Session_Table();
		$this->setDatasource($datasource);
	}

}
?>