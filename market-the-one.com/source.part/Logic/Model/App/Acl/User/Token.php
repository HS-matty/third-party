<?php
class Logic_Model_App_Acl_User_Token extends Logic_Model {

public function onInit(){

		parent::onInit();;
		$datasource = new Logic_Datasource_App_Acl_User_Token_Table();
		$this->setDatasource($datasource);
	}

}
?>