<?php



class Rad_Message{
	
	public function sendMessage(){
		
		
		
		
	}
	
	
}

class Contact_Form_Message extends Rad_Message {
	
	public function sendMessage($SenderEmail,$RecipientEmail,$Subject,$Body){
		
		global $Db;
		$Data = array();
		$Data['message_type_id'] = 1;
		$Data['sender_email'] = $SenderEmail;
		$Data['recipient_email'] = $RecipientEmail;
	//	if($Name) $Subject = $Subject = 'from: '.$Name . ' - '.$Subject;  
		$Data['subject']  = $Subject;
		
		$Data['body']  = $Body;
		$Data['creation_date'] = 'NOW()';
		return $Db->sqlgen_insert('message',$Data);	
		
		
		
		
	}
	
	
	
}

?>