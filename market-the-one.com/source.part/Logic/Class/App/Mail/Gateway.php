<?php 

class Logic_Class_App_Mail_Gateway extends Logic_Class {




	public function sendMessage(Mail_Message $message){


		require PATH_LIB.'/php-mailer/class.phpmailer.php';

		$mail = new PHPMailer;

		$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->IsSMTP();                                  // Set mailer to use SMTP
		//$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
		$mail->Host = 'smtp-pulse.com';
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'byqdes@gmail.com';                 // SMTP username
		$mail->Password = 'n5nTEaeN5A5';                           // SMTP password
		//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		//$mail->Port = 587;                                   // TCP port to connect 
		$mail->port = 2525;

		$user_from = $message->getFrom();



		$mail->From = $user_from->getEmail();
		$mail->FromName = $user_from->getFullName();
		
		//foreach ($message->getUserTo() as $user_to){
	//	while($user_to = $message->getUserTo()){
	/*@var $message Mail_Message*/
		foreach ($message->getAllUserTo() as $user_to){

			//echo $user_to->getName();
		//	echo 'ee';
		//	echo  $user_to->getEmail();
		//	print_r($user_to->getModel()->getData());
		//	print_r($user_to->getModel());
		//	exit();
			/*@var*/
			$mail->addAddress($user_to->getEmail(), $user_to->getFullName());     // Add a recipient
		}

		/*$mail->addAddress('ellen@example.com');               // Name is optional
		$mail->addReplyTo('info@example.com', 'Information');
		$mail->addCC('cc@example.com');
		$mail->addBCC('bcc@example.com');*/

//		$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//		$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = $message->getSubject();
		$mail->Body    = $message->getMessageString();
		$mail->AltBody = $message->getMessageString();

		$mail->SetLanguage('en');
		
		if(!$mail->send()) {
			throw new Exception_App_Mail('Mailer Error: ' . $mail->ErrorInfo);
			
		} else {
			$message->setStatus('success');
		}


		return $message;



	}

}

class Exception_App_Mail extends Exception_App {
	
}

?>