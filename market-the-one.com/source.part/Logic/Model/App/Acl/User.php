<?php

class Logic_Model_App_Acl_User extends Logic_Model {


	const Type_User_Frontend = 'user_frontend';
	const Type_User_Backend = 'user_backend';



	public $_login_field_name = 'email';



	public $_hash;




	public function onInit($params = null){


		$datasource = new Logic_Datasource_App_Acl_User_Table();

		$this->setDatasource($datasource);

	}


	public function init($params = array()){
	
//		$this->load($params);
		return $this;

	}
	
	



}


?>