<?php
class Logic_Model_App_Acl_Group extends Logic_Model {


	const Type_Group_Admin_Id = 1;
	const Type_Group_Partner_Id = 2;
	
	
	const Type_Group_Admin = 'admin';
	const Type_Group_Partner = 'partner';






	public function onInit($params = null){

		$datasource = new Datasource_Table('acl_group');

		$this->setDatasource($datasource);

		//$this->_data = $datasource->fetchData($params);

		/*$this->_data = $users->getRow($params);

		foreach ($this->_data->getParams() as $key=>$value){
		$this->setParam($key,$value);
		}*/
	}


/*	public function setUserType($user_type){

		$this->_user_type = $user_type;



	}
	
	
	public function getUserType(){
		return $this->_user_type;
	}
*/
	public function __construct($params = array()){

		parent::__construct($params);

		$this->onInit($params);
	}

	public function update(){

		$this->init(array('id'=>$this->id));


	}

	public function init($params = array()){

		$this->_data = $this->_datasource->fetchData($params);
	}

	public function getData(){

		return $this->_data;

	}

	public function add(array $data){

		return $this->_datasource->insertRow($data);

	}



	
	public function getId(){
		return $this->_data['id'];
	}
	public function getFieldValue($name){
		return $this->_data[$name];
	}
	

}

class Logic_Model_App_Acl_Group_Admin extends Logic_Model_App_Acl_Group {


	public function onInit($params = null){

		$datasource = new Datasource_Table('acl_group');

		$this->setDatasource($datasource);

		$this->setType(Logic_Model_App_Acl_Group::Type_Group_Admin);


	}



}


class Logic_Model_App_Acl_Group_Partner extends Logic_Model_App_Acl_Group {


	public function onInit($params = null){

		$datasource = new Datasource_Table('acl_group');

		$this->setDatasource($datasource);

		$this->setType(Logic_Model_App_Acl_Group::Type_Group_Partner);


	}



}


?>