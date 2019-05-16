<?php

class  AdminUser extends FrontendUser  {


	protected $EmailAdmin;
	function __construct(){

		$this->EmailAdmin = ADMIN_EMAIL_ADDRESS;
		parent::__construct();
		
	}
	public function sendContactEmail($Data){

		$Data['text'] .= '<br /><br /> name: '.$Data['name'].'<br /> phone: '.$Data['phone_number'].'<br />email: '.$Data['email'];
		
		
		//require_once 'Zend/Mail.php';
	//	$mail = new Zend_Mail();

		

		/*		$Visiter = 'Barefoot Visiter';
		if($Data['phone_number']) $Data['text'] .= '<br /><br /> phone: '.$Data['phone_number'];
		$mail->setBodyHtml($Data['text']);
		$mail->setFrom($Data['email'], $Visiter);
		$mail->addTo($this->EmailAdmin, 'Hunter');
		$mail->setSubject($Data['subject']);
		require_once 'Zend/Mail/Transport/Sendmail.php';
		$Tr = new Zend_Mail_Transport_Sendmail();
		$mail->setDefaultTransport($Tr);
		$mail->send();*/


		global $Config;
		require($Config->SitePath.'/3rd_party/phpmailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->FromName = 'Contact Form Submission';
		$mail->Hostname =  $Config->Hostname;
		$mail->From = 'contact@barefootlistings.com';
		
		$mail->ReplyTo = $Data['email'];
		$mail->AddAddress($this->EmailAdmin,'Hunter');
		$mail->Subject = $Data['subject'];
		
		$mail->Body = nl2br($Data['text']);
		$mail->IsHTML(true);
		$mail->Send();

		
		$Message = new Contact_Form_Message();
		$Message->sendMessage($Data['email'],ADMIN_EMAIL_ADDRESS,$Data['subject'],$Data['text']);




	}



}
?>