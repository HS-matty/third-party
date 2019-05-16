<?php
/**
 * Registered user
 *
 */
class RegisteredUser extends FrontendUser implements iRad_Form  {

	protected $canAuth = true;

	public   $TableName = 'bluser';
	public   $PrimaryIdName = 'bluser_id';

	protected $Items;


	/**
	 * User searhes object
	 *
	 * @var Session_User_Searches
	 */
	public $Searches;

	function __construct(){

		$this->Searches = new Database_User_Searches($this);
		//$this->Searches = new Session_User_Searches($this);


	}

	
	public function isLogined($ClassParam = null){
		//$Ret = true;


		if($ClassParam && (get_class($this) == $ClassParam || is_subclass_of($this,$ClassParam)) &&  $this->UserData[$this->PrimaryIdName]){

			return true;

		}elseif (!$ClassParam && $this->UserData[$this->PrimaryIdName]) {
			return true;
		}


		return false;
	}

	public function getItems($Type,$Flag = null){

		$BarefootItems = new Rad_Directory_Record();
		return $BarefootItems->getItemsByUserId($this->getUserId(),$Type);


	}
	public function getItemsStats(){

		$BarefootItems = new Rad_Directory_Record();
		return $BarefootItems->getItemsStats($this->getUserId());


	}
	public function getTotalUsersStats(){
		
			
		
		$Stats = array();
		global $Db;
		$Db->query("SELECT count(*) FROM $this->TableName");
		$Stats['total'] = $Db->fetch_element();
		$Db->query("SELECT count(*) FROM $this->TableName WHERE  user_is_active  = 1");
		$Stats['is_active'] = $Db->fetch_element();
		

		return $Stats;
		
	
		
		
		
	}
	/**
	 * Get item object 
	 *
	 * @param int $ItemId
	 * @return  Rad_Directory_Record
	 */
	public function getItem($ItemId){
		$Item =  Rad_Directory_Record::getInstanceById($ItemId);


		if($ItemId) $Item->init($ItemId,$this);

		return $Item;

	}


	public function countItems(){

		$Item = new Rad_Directory_Record();
		return $Item->coutItems('bluser',$this->getUserId());
	}

	public function refreshUserData(){

		global $Db;
		$Db->query("SELECT * FROM $this->TableName WHERE $this->PrimaryIdName = ".$this->getUserId());
		$this->UserData = $Db->fetch_assoc();


	}
	public function recoverPassword(){

		if(!$this->UserData) die('error - no user data');

		$NewPassword = $this->generatePassword(8,5);
		$Data['sha_password'] = sha1($NewPassword);
		if($this->updateUser($this->getUserId(),$Data))	$this->sendPasswordRecoverEmail($NewPassword);




	}
	public function transferFromAnonymous(){



	}
	public function sendTransferFromAnonymousEmail($view){
		global $Config;


		require($Config->SitePath.'/3rd_party/phpmailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->FromName = 'Barefoot Listings';
		$mail->Hostname =  $Config->Hostname;
		$mail->From = 'noreply@barefootlistings.com';
		$mail->AddAddress($this->UserData['email']);
		$mail->Subject = "Account registration";
		$Data['email']  =$this->UserData['email'];
		$Data['sid'] = $this->generateTransferFromAnonymousEmailSid();
		$Body  =  trim($view->compileSmartyBlock('anonymous_transfer.tpl','/user/',$Data));

		$mail->Body = $Body;
		$mail->IsHTML(true);
		$mail->Send();


	}
	public  function generateTransferFromAnonymousEmailSid(){

		return  md5($this->UserData['login'].$this->UserData['email'].'01927x');


	}
	public function updateLastVisit(){

		global $Db;
		$Db->query("UPDATE $this->TableName SET last_login = NOW() WHERE $this->PrimaryIdName = {$this->getUserId()}");
		return $Db->affected_rows();


	}
	public function sendConfirmationEmail($Sid,$Email,$NoteFlag = false){

		global $Config;
		require_once($Config->SitePath.'/3rd_party/phpmailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->FromName = 'New registration';
		$mail->From = 'confirmation@'.$Config->Hostname;
		$mail->Hostname = $Config->Hostname;
		$mail->AddAddress($Email);
		$Link = "{$Config->Hostname}/auth/account_confirmation/?sid={$Sid}";
		$mail->Subject = "Account Confirmation";
		$mail->Body = "Thank you for signing up. Please click the link below to activate your account. If the link is not clickable, copy and paste the link into a browser. ";


		

	//	if($NoteFlag)  $mail->Body .= ' PLEASE NOTE - You still must activate your post by clicking on My Postings and selecting the Unpublished tab.';
		$mail->Body .=  "<br><br><a href=\"{$Link}\">{$Link}</a>";
		$mail->IsHTML(true);
		$mail->Send();
	}


	public function send_AddListing_ConfirmationEmail($ItemId){
		
		//echo("HERE"); exit;

		global $Config;
		require_once($Config->SitePath.'/3rd_party/phpmailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->FromName = 'Barefoot Listings';
		$mail->From = 'noreply@barefootlistings.com';
		$mail->Hostname = $Config->Hostname;
		$mail->AddAddress($this->UserData['email']);
		$mail->Subject = "Barefoot Listings Post Confirmation";
		$Sid = $this->generateSidForAnonymousPosting($ItemId);
		$mail->Body = "Thank you for posting!. Please click on the link below to Publish, Edit or Delete your listing.<br><br><a href='{$Config->Hostname}/directory/edit_item/?item_id={$ItemId}&sid={$Sid}&type=view'>{$Config->Hostname}/directory/edit_item/?item_id={$ItemId}&sid={$Sid}</a>";
		$mail->IsHTML(true);
		$mail->Send();
	}



	
	public function sendPasswordRecoverEmail($NewPassword){
		global $Config;
		require($Config->SitePath.'/3rd_party/phpmailer/class.phpmailer.php');
		$mail = new PHPMailer();
	//	$mail->FromName = 'Password recover';
		$mail->From = 'passwords@barefootlistings.com';
		$mail->Hostname = $Config->Hostname;
		$mail->AddAddress($this->UserData['email']);
		$mail->Subject = "Forgotten Password";
		$mail->Body = "You have requested to be sent a new password.  Your password is below: <br /><br />
		Email: {$this->UserData['email']}<br />Password: $NewPassword
		<br /> <br />Go to <a href='{$Config->Hostname}/'>$Config->Hostname</a> to login and change your password.
		";
		$mail->IsHTML(true);
		$mail->Send();
	}
	public function setActive(){
		$Data['user_is_active'] = 1;
		return $this->updateUser($this->getUserId(),$Data);

	}
	public function updateFormObject($Data){
		if(!$Data['sha_password']) unset($Data['sha_password']);
		else $Data['sha_password'] = sha1($Data['sha_password']);
		
		unset($Data[$this->PrimaryIdName]);
		$this->updateUser(null,$Data);
		
	}
	public function insertFormObject($Data){
		if(!$Data['sha_password']) unset($Data['sha_password']);
		else $Data['sha_password'] = sha1($Data['sha_password']);
		$this->addUser($Data);
		
	}
	public function getFormData(){
		if($this->UserData['sha_password']) unset($this->UserData['sha_password']);
		return $this->UserData;
	}
	public function parseAdditionalFields(&$Data,$FieldsXml){
		if($FieldsXml) $Data['params_xml'] = $FieldsXml;

	}
}
class PartnerUser extends RegisteredUser {
	public function getUsersList($Params = null){
		
		$Params['user_type'] = 'partner';
		
		return parent::getUsersList($Params);
	}
	
}
class ClientUser extends RegisteredUser {
	public function getUsersList($Params = null){
		$Params['user_type'] = 'client';
		return parent::getUsersList($Params);
	}
	
	
	
}
?>