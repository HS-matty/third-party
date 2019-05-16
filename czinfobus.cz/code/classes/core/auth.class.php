<?php

//Определим уровни достура
define("USER",0);
define("MANAGER",1);
define("ADMIN",2);


define("SESSION_LIFE_TIME",30);
class CAuth{

	protected $Sid;
	var $Expired;
	var $UserName;
	public $UserId;
	var $Status;
	private  $Param = 0;
	
	public $UserObject;	//
	




	function CAuth(){


		$this->AccessLevel = 0;



	}
	function KillSid(){
		unset($this->Sid);
	}
	function GetParam(){
		return $this->Param;
	}
	

	function &AddUser($UserLogin,$UserPassword,$UserName){
	
		//todo Добавить НОРМАЛЬНУЮ проверку на access_level
		
		if(!$this->AccessLevel){
			
			$ReturnArray['ErrorMessage'] = 'Access denied!';
			$ReturnArray['ErrorLevel']  = 1;
			
		}
		elseif($this->IsLoginAlreadyRegistered($UserLogin)){
		
				$ReturnArray['ErrorMessage'] = 'Such login is already registered!';
				$ReturnArray['ErrorLevel']  = 1;
			
		}
		else{
			global $Db;
			$Sql = "INSERT INTO auth_users (user_login,user_password,user_name,su_flag) 
			VALUES ('$UserLogin',MD5('$UserPassword'),'$UserName',0)";
			$Db->query($Sql);
			if($Db->affected_rows())  {
				
				
				$ReturnArray['ErrorLevel']  = 0;
				$ReturnArray['LastId']  = $Db->get_insert_id();
				
			
			}else{
			
				$ReturnArray['ErrorLevel']  = 1;
				$ReturnArray['ErrorMessage'] = 'Database error!';
			
			}
			
		
		}
		
		
	return $ReturnArray;
	
	
	}
	
	function IsLoginAlreadyRegistered($Login){
	
		global $Db;
		$Sql = "SELECT user_id FROM auth_users WHERE user_login = '$Login' ";
		$Db->query($Sql);
		if($Db->rows()) return 1;
		return 0;
			
	}
	
	function DeleteOldSessions(){
		
		global $Db;
		
		
		$Sql = "DELETE FROM auth_sessions WHERE TO_DAYS(NOW()) - TO_DAYS(user_start_time) > 30";
		$Db->query($Sql);
			
	}


	function GetUserId ($Sid = NULL){

		global $Db;
		if(!$Sid) $Sid = $this->Sid;
		if($Sid){

			$Sql = "SELECT user_id FROM auth_sessions WHERE s_id = '$Sid'";
			$Db->query($Sql);
			if($Db->affected_rows()) {
				$Arr = $Db->fetch_array();
				return $Arr[0];
			}
		}
		return 0;
	}

	function GetUserName ($UserId = 0){

		global $Db;
		if(!$UserId) $UserId = $this->GetUserId();
		if(!$UserId) return 0;
		$Sql = "SELECT user_name FROM auth_users WHERE user_id = $UserId";

		$Db->query($Sql);
		if($Db->affected_rows()) {
			$Arr = $Db->fetch_array();
			return $Arr[0];
		}

		return 0;
	}
	

	function GetUserLogin ($UserId = 0){

		global $Db;
		if(!$UserId) $UserId = $this->GetUserId();
		if(!$UserId) return 0;
		$Sql = "SELECT user_login FROM auth_users WHERE user_id = $UserId";

		$Db->query($Sql);
		if($Db->affected_rows()) {
			$Arr = $Db->fetch_array();
			return $Arr[0];
		}

		return 0;
	}


	

	function VerifySession($Sid = null){
		
		global $Db;
		$ReturnValue = 0;
		
	//	$this->DeleteOldSessions();
		
		if(!$Sid) $Sid = $this->Sid;

		if(!$Sid){
			$ReturnValue = 1; //error;

		}else{
			$Sql = "SELECT user_id,param FROM auth_sessions WHERE s_id='$Sid' AND (UNIX_TIMESTAMP(user_start_time) + 30000) > UNIX_TIMESTAMP() AND closed = 0";
			$Db->query($Sql);
			
			if($Db->affected_rows()) {
	//such session exists and still active
				
				$arr = $Db->fetch_array();
				$this->Sid = $Sid;
//				print_r($arr);
				$this->Param = $arr['param'];
				
				$this->UserId = $arr['user_id'];
							
			}
			else $ReturnValue = 1;// no  session found

		}
		//print("<br>userid = $this->UserId, sid = $Sid<br>");
		return $ReturnValue;

	}
	

	
	
	/**
	* @return User Object
	* @desc 
	*/
	public function GetUserData($Login,$Password,$UserId = 0){
		
		$User = new User();

		if($User->FetchUserData($Login,$Password,$UserId)){ //no users found
				
			return null;	
		
		
		}
		$this->UserObject = $User;		
		return $User;
	}
	
	
	public function GetBusUserData($Login,$Password){
		
		$User = new User();

		if($User->FetchBusUserData($Login,$Password)){ //no users found
				
			return null;	
		
		
		}
		$this->UserObject = $User;		
		return $User;
	}
	




	public function GetSid(){

		return $this->Sid;
	}


	public function RegisterSession($User,$Param = 0){

		global $Log, $Db;

		$Sid = md5(uniqid(rand(), true));
		//echo '<br>';
		$Sql = "INSERT INTO auth_sessions (s_id,user_start_time,user_id,param) values ('$Sid',NOW(),'$User->UserId','$Param')";
		$Db->query($Sql);
		
		if($Db->affected_rows()) { //Если успешно зарегистрировали сессию
			$this->Sid = $Sid;
		//$Log->DoLogging("Registered session with user_id=$this->UserId, Sid = $this->Sid",INFO);
		//	echo 'registered session';
			return 0;
		}

		return 1; //if error;


	}

	function ChangeUserPassword($Password, $UserId = Null){

		if(!$UserId) $UserId = $this->GetUserId();
		if(!$UserId) return 0;

		global $Db;
		$Sql = "Update auth_users SET user_password = MD5('$Password') WHERE user_id = $UserId";
		$Db->query($Sql);
		if($Db->affected_rows()) return 1;
		return 0;



	}

	function CloseSession(){

		global $Log;
		global $Db;
		if($this->Sid) $Db->query("UPDATE auth_sessions SET closed = NOW() WHERE s_id='$this->Sid'");


	}
}

?>