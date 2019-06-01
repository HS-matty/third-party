<?php

class Logic_Acl extends Acl {


	const Acl_User_Group_Partner = 'partner';
	const Acl_User_Group_Admin = 'admin';
	const Acl_User_Group_Guest = 'guest';

	public static function aclRegisterUser(Std_Class $user,$is_session=true){
		$acl = Registry::get('acl');
		$acl->_registerUser($user,$is_session);
		return ;

	}


	public static function aclUnregisterUser(){

		$acl = Registry::get('acl');
		$acl->_unregisterUser();
		return ;

	}

	/*	public static function registerUser(Std_Class $user){

	$session = Registry::get('session');

	$session->setParam('user',serialize($user));
	$session->setParam('user_id',$user->id);


	}

	public static function unregisterUser(){

	$session = Registry::get('session');
	$session->unsetParam('user_id');
	$session->unsetParam('user');





	}*/


	public function sendResetPasswordMessage(Acl_User $user_to,$define_vars = null){
		
		

		if(!$define_vars) $define_vars = array(); //$define_vars = get_defined_vars();
		
		//print_r(get_defined_vars());
		
		$define_vars = array_merge($define_vars,get_defined_vars());
		
		$user_from = new Acl_User();

		$user_from->authById(ADMINISTRATOR_USER_ID);

		$message = new Mail_Message();

		$message->setFrom($user_from);
		$message->addTo($user_to);

		

		$message->loadText(PATH_STATIC.'/Mail/Letter/ResetPassword.html',$define_vars);


		$message->setSubject("Reset password for {$user_to->nickname} @ market-the-one.com");


		$mail_gateway = new Mail_Gateway();
		$mail_gateway->sendMessage($message);

		$message_status = $message->getStatus();


		return $message;
		
		
	}
	
	
	public static function sendWelcomeMessage(Acl_User $user_to){


		//ini_set("SMTP", "localhost");
		//ini_set("sendmail_from", "localhost");


		//$tpl->setBasePath(PATH_STATIC);
		//	print_r($user);


		$define_vars = get_defined_vars();


		//$file = new File();
		//$file->setBasePath(PATH_STATIC);
		//$file->load('/Mail/Letter/Welcome.html');





		$user_from = new Acl_User();

		$user_from->authById(ADMINISTRATOR_USER_ID);

		$message = new Mail_Message();

		$message->setFrom($user_from);
		$message->addTo($user_to);


		$message->loadText(PATH_STATIC.'/Mail/Letter/Welcome.html',$define_vars);


		$message->setSubject("Welcome {$user_to->nickname} to market-the-one.com");


		$mail_gateway = new Mail_Gateway();
		$mail_gateway->sendMessage($message);

		$message_status = $message->getStatus();


		return $message;
	}





	public static function getUserByHash($hash){

		//$user = new Logic_Model_


	}


	public static function  startUserSession($user){
		$_session = new Logic_Class_App_Acl_User_Session();
		Registry::set('Acl_User_Session',$_session);
		$_session->start($user->getId());
		return ;

	}
	
	
	public static function  finishUserSession($user){
		
		$_session = Registry::get('Acl_User_Session');
		$_session->finish();
		return ;

	}

	public function _registerUser(Std_Class $user,$is_session = true){

		$this->_user = $user;
		Registry::set('user',$user);



		if($is_session){
			$session = Registry::get('session');
			$acl_user_session = Registry::get('Acl_User_Session');

			$acl_user_session_id = $acl_user_session->getId();

			$session->setParam('acl_user_session_id',$acl_user_session_id);
		//	exit($acl_user_session);
		}

		return $this;

	}

	public function _unregisterUser(){


		$this->_user = null;
		$session = Registry::get('session');
		$session->unsetParam('acl_user_session_id');
		$_SESSION['acl_user_session_id'] = NULL; // =))
		//$session->setParam('session_id',null);

		$acl_user_session = Registry::get('Acl_User_Session');
		$acl_user_session->finish();

	}
}

?>