<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/


abstract class RadUser{

	public   $TableName;
	public   $PrimaryIdName;
	protected $canAuth = false;


	protected  $LoginField = 'email';

	public $UserData;


	public function getType(){
		return get_class($this);
	}

	public function isUserDataLoaded(){
		if(!empty($this->UserData)) return true;
		return false;
	}
	static function getInstance($UserId = null){

		//	self::getUserData()


	}

	public function getUserId(){

		return $this->UserData[$this->PrimaryIdName];

	}
	public function setLoginField($Field = 'email'){
		$this->LoginField = $Field;
	}
	public function refreshUserData(){

		global $Db;
		$Db->query("SELECT * FROM $this->TableName WHERE $this->PrimaryIdName = ".$this->getUserId());
		$this->UserData = $Db->fetch_assoc();


	}
	public function isLogined($ClassParam = null){
		//$Ret = true;

	
		if($ClassParam && ((get_class($this) == $ClassParam || is_subclass_of($this,$ClassParam)))){
//&& $this->UserData[$this->PrimaryIdName]

			return true;

		}elseif (!$ClassParam && $this->UserData[$this->PrimaryIdName]) {
			return true;
		}


		return false;
	}


	//must be reloaded
	public function ControlUserTries($Login,$LoginTries = -1){

	}


	public function isAuth(){
		return (bool) $this->getUserId();
	}
	public   function getUserIp($Format ='long'){

		$Ip =  null;
		$Ip = @$_SERVER['REMOTE_ADDR'];
		if($Ip){

			$Ip  = ip2long($Ip);
			return $Ip;
		}

		return false;

	}

	public  function checkIfUserExists($Login,$UserId = 0){
		global $Db;

		$Sql = "SELECT  $this->PrimaryIdName from $this->TableName WHERE login='$Login'";
		if($UserId) $Sql .= " AND $this->PrimaryIdName != $UserId";
		///die('dss');
		$Db->query($Sql." limit 1");
		return $Db->rows();




	}




	public function changeUserPassword($UserId,$Password){


		global $Db;
		$Sql = "Update $this->TableName password = MD5('$Password') WHERE $this->PrimaryIdName = $UserId";
		$Db->query($Sql);
		if($Db->affected_rows()) return 1;
		return 0;



	}

	public function authByField($FieldName,$FieldValue){

		global $Db;
		$FieldValue = mysql_real_escape_string($FieldValue);
		$sql = "SELECT * FROM 	$this->TableName	WHERE $FieldName = '$FieldValue'";

		$Db->query($sql);
		if($this->UserData =  $Db->fetch_assoc()){

			return true;
		}

		return false;

	}

	public function getUserIdByLoginAndEmail($Login,$Email){

		global $Db;
		$Sql = "SELECT $this->PrimaryIdName FROM $this->TableName WHERE login = '$Login' AND email ='$Email' ";
		$Db->query($Sql);
		return $Db->get_element();

	}

	public function isLoginAlreadyRegistered($LoginFieldTitle,$Login){

		global $Db;
		$Login = mysql_real_escape_string($Login);
		$Sql = "SELECT $LoginFieldTitle FROM $this->TableName WHERE $LoginFieldTitle = '$Login' ";
		$Db->query($Sql);
		return $Db->rows();
	}

	public function getUsersList($Params = null){
		global $Db;
		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom($this->TableName);
		$Where = $Query->addWhereGroup();
		if($Params['email']){
			$Where->add('email',$Params['email'],null,'=','',true);
		}
		if($Params['is_active']){
			$Where->add('user_is_active',$Params['is_active']-1);
			
		}
		
		if($Params['user_type']){
			$Where->add('user_type',$Params['user_type'],null,'=','',true);
		}

		
		$Db->perfromSelectQueryExt($Query);
		
		return $Query->QueryResult->Data;
	}

	public function getExtendedUserObject(){
		
		switch ($this->UserData['user_type']){
			case 'client':
				$Obj = new clientUser();
				$Obj->UserData = $this->UserData;
				return $Obj;
			break;
			case 'partner':
				$Obj = new partnerUser();
				$Obj->UserData = $this->UserData;
				return $Obj;
			break;
			default:
				return $this;
				
				
			
			
		}
		
	}
	public  function authUser($Login,$Password, $CheckIsActive  = true){

		global $Db;


		//	if(!$this->CanAuth) return false;
		$Login = mysql_escape_string($Login);
		$Password = mysql_escape_string($Password);
		
		$Sql = "SELECT * FROM 	$this->TableName	WHERE {$this->LoginField} = '$Login' AND sha_password = sha1('$Password')";
		if($CheckIsActive) $Sql .= ' AND user_is_active = 1 ';
		$Sql .=' limit 1';

//die($Sql);
		$Db->query($Sql);

		if($this->UserData =  $Db->fetch_assoc()){


			return true;

		}

		return false;
	}

	public  function authUserById($Id){
		global $Db;
		$Db->query("SELECT * FROM 	$this->TableName	WHERE $this->PrimaryIdName = $Id");
		if($this->UserData =  $Db->fetch_assoc()){

			return true;
		}

		return false;


	}

	public function addUser($Data){


		global $Db;

		return $Db->sqlgen_insert($this->TableName,$Data);



	}
	public function updateUser($UserId,$Data){


		global $Db;

		if(!$UserId) $UserId = $this->getUserId();
		$Db->sqlgen_update($this->TableName,$Data,"$this->PrimaryIdName = $UserId");



		return $Db->affected_rows();
	}

	public function deleteUser($UserId){
		global $Db;
		$Db->query("DELETE FROM $this->TableName WHERE $this->PrimaryIdName = $UserId");
		return $Db->affected_rows();

	}
	public function getUserData(){
		return $this->UserData;
	}

	public function getUserInfoString(){
		
		return $this->UserData['name'].' ' .$this->UserData['last_name'].', '.$this->UserData['email'];
	}
	protected function generatePassword ($passwordLength, $characterSet)
	{
		//Random password generator if anyone needs one
		//B Palmer 2007 - Distribute, manipulate, just dont sell, not that its worth anything anyway!

		//Character Sets
		//1 - numbers only (48[0] to 57[9]) - 10
		//2 - lowercase only (97[a] to 122[z]) - 26
		//3 - uppercase only (65[A] to 90[Z]) - 26
		//4 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) - 52
		//5 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) + numbers (48[0] to 57[9]) - 62
		//6 - full keyboard set (32 to 126) less space (32[space], 34["], 39['], 96[`]) - 91


		//1 - numbers only (48[0] to 57[9]) - 10
		if($characterSet==1)
		{
			$passwordString = "";
			for($i=0; $i<$passwordLength; $i++)
			{
				$selectedChar = rand(0, 9);
				$passwordString .= $selectedChar;
			}
		}

		//2 - lowercase only (97[a] to 122[z]) - 26
		if($characterSet==2)
		{
			$passwordString = "";
			for($i=0; $i<$passwordLength; $i++)
			{
				$selectedChar = rand(97, 122);
				$selectedChar = chr($selectedChar);
				$passwordString .= $selectedChar;
			}
		}

		//3 - uppercase only (65[A] to 90[Z]) - 26
		if($characterSet==3)
		{
			$passwordString = "";
			for($i=0; $i<$passwordLength; $i++)
			{
				$selectedChar = rand(65, 90);
				$selectedChar = chr($selectedChar);
				$passwordString .= $selectedChar;
			}
		}

		//4 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) - 52
		if($characterSet==4)
		{
			$passwordString = "";
			for($i=0; $i<$passwordLength; $i++)
			{
				$selectedChar = rand(1, 52);
				if($selectedChar>=1&&$selectedChar<=26)
				{
					$selectedChar = $selectedChar + 64;
					$selectedChar = chr($selectedChar);
				}
				else
				{
					$selectedChar = $selectedChar + 70;
					$selectedChar = chr($selectedChar);
				}
				$passwordString .= $selectedChar;
			}
		}

		//5 - lowercase (97[a] to 122[z]) + uppercase (65[A] to 90[Z]) + numbers (48[0] to 57[9]) - 62
		if($characterSet==5)
		{
			$passwordString = "";
			for($i=0; $i<$passwordLength; $i++)
			{
				$selectedChar = rand(1, 62);
				if($selectedChar>=1&&$selectedChar<=10)
				{
					$selectedChar = $selectedChar + 47;
					$selectedChar = chr($selectedChar);
				}
				elseif($selectedChar>=11&&$selectedChar<=36)
				{
					$selectedChar = $selectedChar + 54;
					$selectedChar = chr($selectedChar);
				}
				else
				{
					$selectedChar = $selectedChar + 60;
					$selectedChar = chr($selectedChar);
				}
				$passwordString .= $selectedChar;
			}
		}

		//6 - full keyboard set (32 to 126) less space (32[space], 34["], 39['], 96[`]) - 91
		if($characterSet==6)
		{
			$passwordString = "";
			for($i=0; $i<$passwordLength; $i++)
			{
				$selectedChar = rand(1, 91);
				if($selectedChar==1)
				{
					$selectedChar = $selectedChar + 32;
					$selectedChar = chr($selectedChar);
				}
				elseif($selectedChar>=2&&$selectedChar<=5)
				{
					$selectedChar = $selectedChar + 33;
					$selectedChar = chr($selectedChar);
				}
				elseif($selectedChar>=6&&$selectedChar<=61)
				{
					$selectedChar = $selectedChar + 34;
					$selectedChar = chr($selectedChar);
				}
				else
				{
					$selectedChar = $selectedChar + 35;
					$selectedChar = chr($selectedChar);
				}
				$passwordString .= $selectedChar;
			}
		}

		return $passwordString;
	}



}






?>