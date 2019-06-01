<?php

class Logic_Class_App_Acl_User extends Logic_Class  {



	/**
	 * Enter description here...
	 *
	 * @var Logic_Model_App_Acl_User
	 */
	//public $_model;


	//public $_model_group;




	public function onInit(){

		$this->init();

		$token = new Logic_Class_App_Acl_User_Token();
		$this->addClass($token)	;
		$outcome = new Logic_Class_App_Market_Finance_Outcome();
		$this->addClass($outcome);
		
		return true;

	}


	
	public function getIp(){
		return get_user_ip();		
	}

	
	//public function get

	public function init(array $params = null){

		if(!$model = $params['model']){
			$model = new Logic_Model_App_Acl_User_Backend();
			$model->setName('User');
			$this->setModel($model);

		}
		
		
	//	$session = new Logic_Class_App_Acl_User_Session();
	//	$this->addClass($session);

		return $this;

	}

	
	
	public function calculateBalance(){
		
		
		$outcome = $this->getClass('Outcome');
		$sum = $outcome->getModel()->getDatasource()->_sum('sum',array('acl_user_id'=>$this->getId()));
		$this->setParam('balance',$sum);
		return $this;
	}
	
	public function updateBalance($balance){
		
		$this->getModel('User')->update(array('balance'=>$this->getParam('balance')));
		return $this;
		
	}
	
	public function getType(){
		return $this->getModel('User')->getType();
	}
	
	public function setTypeBackend(){
		$model = new Logic_Model_App_Acl_User_Backend();
		$model->setName('User');
		$this->setModel($model);
		return $this;
		
	}
	
	public function setTypeFrontend(){
		$model = new Logic_Model_App_Acl_User_Frontend();
		$model->setName('User');
		$this->setModel($model);
		return ;
	}

	
	
	/**
	 * Enter description here...
	 * @var Logic_Class_App_Acl_User_Session
	 * 
	 * @return Logic_Class_App_Acl_User_Session
	 */
	public function setSession(Logic_Class_App_Acl_User_Session $session){
		
		$session->setName('Session');
		return $this->setClass($session);
		return $this;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return Logic_Class_App_Acl_User_Session
	 */
	public function getSession(){
		//return $this->getClass('Session');
		return Registry::get('Acl_User_Session');
	}
	
	/**
	 * Enter description here...
	 *
	 * @return Logic_Class_User
	 */
	public function authAsGuest(){

		$model  = new Logic_Model_App_Acl_User_Frontend();
		$model->setName('User');

		$this->setType('user_frontend');
		//return $this->init(array('model'=>$model));
		$this->setModel($model);
		$acl_user_session = Registry::get('Acl_User_Session');
		$guest_user_id = 1;//$acl_user_session->getToken()->getFieldValue('acl_user_id');
	//	exit($guest_user_id);
		$this->getModel('User')->load(array('id'=>$guest_user_id));
		
		return $this;

	}





	public function authById($id){

		$this->checkModel();


		$params = array('id'=>$id);

		$this->getModel()->load($params);
		return $this;


	}


	public function authByHash($hash){

		$this->checkModel();


		$params = array('hash'=>$hash);

		$this->getModel()->load($params);
		return $this;


	}
	
	
	public function authBySessionId($session_id){
		
		$session = $this->getSession();
		$session->load($session_id);
		
		if($user_id = $session->getFieldValue('user_id')){
			
			$this->authById($id);
			
		}
		return $this;	
	}
	
	public function authByTokenId(){
		
	}

	public function authByEmail($email,$password = null){

		$this->checkModel();
		$params  = array('email'=>$email);
		if($password){
			$params['sha_password']= sha1($password);
		}

		$this->getModel()->load($params);
		return $this;

	}

	public function isPassedAuth(){

		return $this->getModel()->getId();
	}




	public function getFieldValue($field_name){
		return $this->getModel()->getData($field_name);
	}

	public function getHash(){
		return $this->getModel->getData('hash');
	}

	public function setHash($hash){
		$this->getModel()->setData($hash,'hash');
		return $this;
	}

	/**
	 * Enter description here...
	 *
	 * @return Logic_Model_Acl_User
	 */
	public function updateHash(){
		if(!$id = $this->getModel()->getId()){
			throw new Exception_Logic_Model("model not loaded (no user_id): {$this->getCurrentClassName()}");
		}


		if(!$salt = SHA_SALT){
			throw new Exception_Logic_Model("SHA_SALT constant not set: {$this->getCurrentClassName()}");
		}


		$str = $id.'__'.$salt;

		$sha_string = sha1($str);
		//	$this->up

		$update_data = array('hash'=>$sha_string);

		$this->getModel()->update($update_data);
		return $this;

	}

	public function getGroupId(){

		return $this->getModel()->getData('acl_group_id');

	}


	public function checkUserByField($field_name,$field_value){


		return $this->getModel()->getDatasource()->isRowExists(array($field_name=>$field_value));


	}
	
	
	public function getEmail(){
		return $this->getFieldValue('email');
	}

	
	public function getFirstName(){
		return $this->getFieldValue('first_name');
		
	}
	
	public function getLastName(){
		return $this->getFieldValue('last_name');	
		
	}
	public function getFullName(){
		
		return $this->getFirstName().' '.$this->getLastName();
		
	}
	
	public function getNickName(){
		
		return $this->getFieldValue('nickname');
		
	}

		
	/*public function getName(){
		
		return $this->getFieldValue('name');
		
	}*/
	
	public function getRole(){
		
		return $this->getModel('User')->getFieldValue('role');
	}
	
	public function isAdmin(){
		$return_value = false;
		 if($this->getRole() == 'admin') $return_value = true;
		 
		 return $return_value;
	}
	

	public function isBackend(){
		
		$return_value = false;
		 if($this->getRole() == 'admin' || $this->getRole() == 'partner') $return_value = true;
		 
		 return $return_value;
		
	}
	
	
	public function __get($var_name){
		
		$return_value = null;
		if($this->getModel()->isFieldExists($var_name)){
			$return_value = $this->getModel()->getFieldValue($var_name);
		}else{
			$return_value =  parent::__get($var_name);
		}
		
		return $return_value;
		
		
	}

	
	public function load(array $params = null){
		
		if($acl_user_id = self::ACL_USER_ID){
			if($acl_user_id && $params['id']) throw new Exception_Logic_Class('user_id and ACL_USER_ID set both');
			
			$params['id']  = $acl_user_id;
			
		}
		return parent::load($params);
		
	}







}


?>