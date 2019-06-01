<?php

class Logic_Model_App_Acl_User_Frontend extends Logic_Model_App_Acl_User {


	public function onInit($params = null){

		$this->setType(Logic_Model_App_Acl_User::Type_User_Frontend);

		$datasource = new Datasource_Table('acl_user');

		$this->setDatasource($datasource);



	}
	
	public function getId(){
		return null; //=)
	}
	
	





}


?>