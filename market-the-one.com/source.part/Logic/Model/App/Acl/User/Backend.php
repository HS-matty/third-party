<?php

class Logic_Model_App_Acl_User_Backend extends Logic_Model_App_Acl_User{


	public function onInit($params = null){

		parent::onInit();
		$datasource = new Datasource_Table('acl_user');

		$this->setDatasource($datasource);

		$this->setType(Logic_Model_App_Acl_User::Type_User_Backend);


	}
	public function checkUserByField($field_name,$field_value){


		return $this->getDatasource()->isRowExists(array($field_name=>$field_value));


	}





}

?>