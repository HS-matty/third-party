<?php

class Logic_Class_App_Mail_Message extends Logic_Class{

	public $_subject;

	/*@var $_from Logic_Class_User*/
	public $_user_from;

	public $_user_to = array();

	public $_text;

	public $_signature;

	public $_status;


	public function setStatus($status){
		$this->_status = $status;
		return $this;
	}

	public function getStatus(){

		return $this->_status;
	}



	public function setSubject($subject){
		$this->_subject = $subject;
		return $this;
	}
	public function getSubject(){
		return $this->_subject;
	}

	public function setSignature($signature){
		$this->_signature = $signature;
		return $this;
	}
	public function getSignature(){
		return $this->_signature;
	}

	public function setText($text){
		$this->_text = $text;
		return $this;
	}
	public function getText(){
		return $this->_text;
	}

	public function setUserFrom(Logic_Class_User $user){

		$this->_user_from = $user;
		return $this;

	}

	public function setFrom(Acl_User $from){
		return $this->setUserFrom($from);
	}

	public function addTo(Acl_User $to){
		return $this->addUserTo($to);
	}

	public function setTo(Acl_User $to){
		return $this->addUserTo($to);
	}

	/**
	 * Enter description here...
	 *
	 * @return Acl_User
	 */
	public function getUserFrom(){

		return $this->_user_from;
	}


	/**
	 * Enter description here...
	 *
	 * @return Acl_User
	 */
	public function getFrom(){
		return $this->getUserFrom();
	}


	public function addUserTo(Logic_Class_User $user){
		$this->_user_to[] = $user;
		return $this;

	}
	public function getAllUserTo(){
		return $this->_user_to;
	}


	/**
	 * Enter description here...
	 *
	 * @return Acl_User || null
	 */
	public function getUserTo(){

		$return_value = null;

		if(!$array_obj= $this->getParam('array_obj')){

			$array_obj = ArrayObject($this->getAllUserTo());
			$this->setParam('array_obj',$array_obj);
		}



		/*$it = $array_obj->getIterator();
		while( $it->valid() )
		{
		echo $it->key() . "=" . $it->current() . "\n";
		$it->next();
		}*/

		if($it->valid){
			$return_value = $it->current();
			$it->next();
		}

		return $return_value;

	}
	public function getAllUserToString(){
		return $this->_user_to;
	}

	public function getMessageString(){

		$message_string = $this->getText();
		$message_string .= $this->getSignature();
		return $message_string;
	}


	public function loadText($file,array $params = null){

		$tpl = new Logic_Template_Smarty();
		
		$tpl->setBasePath(PATH_STATIC);
		if($params){
			foreach ($params as $key=>$val){

				$var_list .= $key.'<br>';
				$tpl->addParam($key,$val);
			}
			$tpl->addParam('var_list',$var_list);
		}
		

	
	if(!file_exists($file)) throw new Exception_App_Mail('Couldnt load message-text from '.$file.' :'.$this->getCurrentClassName());


	//echo $file;
	//exit();
	$message_string = $tpl->compileFile($file);
	
	$this->setText($message_string);
	return $this;



}

}

?>