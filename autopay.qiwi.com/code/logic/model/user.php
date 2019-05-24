<?php

class Logic_Model_User extends Std_Class {

	public function __construct($params = array()){

		parent::__construct($params);

		$this->init($params);
	}

	public function update(){

		$this->init(array('id'=>$this->id));


	}


	public function pay($service_id,$amount){

		$db = Registry::get('connection')->mysql;
		$sql = "update 	autopay_services SET balance = (balance + $amount) WHERE id = {$service_id}";
		//		echo $sql;
		//	exit();
		$db->query($sql);

		$sql = "update 	auth_users SET balance = (balance - $amount) WHERE id = {$this->id}";
		//		echo $sql;
		//	exit();
		$db->query($sql);

		return $db->affected_rows();



	}
	public function init($params = null){
		$users = new Datasource_Table('auth_users');
		$this->_data = $users->getRow($params);
		foreach ($this->_data->getParams() as $key=>$value){
			$this->setParam($key,$value);
		}
	}

	public function onInit(){
		parent::onInit();

	}
}

?>