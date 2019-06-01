<?php

class Logic_Class_App_Acl_User_Session extends Logic_Class{





	public function onInit(){


		$model_1 = new Logic_Model_App_Acl_User_Session();
		$this->addModel($model_1);

		$class_1 = new Logic_Class_App_Acl_User_Event();
		$class_1->setName('Event');
		$this->addClass($class_1);

		$class_2 = new Logic_Class_App_Acl_User();
		$class_2->setName('User');
		$this->addClass($class_2);

		return ;


	}


	/**
		 * get Token
		 *
		 * @return Logic_Class_App_Acl_User_Token
		 */
	public function getToken(){
		return $this->getClass('Token');
	}

	/**
	 * Enter description here...
	 *
	 * @return Logic_Class_App_Acl_User
	 */
	public function getUser(){
		return $this->getClass('User');
	}



	/**
		 * get Event
		 *
		 * @return Logic_Class_App_Acl_User_Event
		 */
	public function getEvent(){
		return $this->getClass('Event');
	}
	public function setEvent($event){
		return $this->addClass($event);
	}


	public function start($user_id, $token = null){

		/*@var $token Logic_Class_App_Acl_User_Token*/

		if(!$token){ //get a public token

			$token = new Logic_Class_App_Acl_User_Token();
			$token->loadPublicToken();
			$this->setClass($token);
		}
		$ip = get_user_ip();
		$params =  array('name'=>'session__','datetime'=>'NOW()','status'=>'opened','opened_datetime'=>'NOW()','acl_user_token_id'=>$token->getId(),'ip'=>$ip,'acl_user_id'=>$user_id);

		$this->getModel('Session')->add($params);
		$session_id = $this->getModel('Session')->getId();
		$this->load($session_id);
		return $this;


	}

	public function startByTokenId($token_id){


	}

	public function startByToken($token){


	}



	public function finish(){

		$session_id = $this->getModel('Session')->getId();
		//	if(!$session_id) throw new Exception_Logic_Class('session not loaded: '.$this->getCurrentClassName());

		if($session_id){

			$params =  array('status'=>'closed','closed_datetime'=>'NOW()');//,'acl_user_token_id'=>$token->getId(),'ip'=>$ip);

			$this->getModel('Session')->update($params);
		}
		return $this;
	}



	public function load($session_id){

		$this->getModel('Session')->load(array('id'=>$session_id));


		if($this->getModel('Session')->getId()){
			$token_id = $this->getModel('Session')->getFieldValue('acl_user_token_id');

			$token = new Logic_Class_App_Acl_User_Token();
			$token->getModel('Token')->load(array('id'=>$token_id));


			$this->setClass($token);
		}

		return $this;
	}

	public function loadPublicSession(){
		return $this->load(1);
	}

	public function getCurrentUserId(){
		if(!$user = $this->getClass('User')) throw new Exception_Logic('User Class not set: '.$this->getCurrentClassName());
		return $user->getId();

	}

	public function getUserIdFromToken(){
		$this->getToken()->getFieldValue('acl_user_id');
	}

	public function isExpired(){
		return ;
	}


	public function isClosed(){

		$return_value = null;

		$status = $this->getModel()->getFieldValue('status');
		if($status == 'opened') $return_value = false;
		else $return_value = true;

		return $return_value;
	}




}

?>