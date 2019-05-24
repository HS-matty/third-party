<?php

class Session extends Element {


	public function onInit(){
		if(!session_id()){
			session_start();
			parent::setParam('session_id',session_id());
		}


	}
	public function setParam($name, $value){
		$_SESSION[$name] = $value;
		parent::setParam($name,$value);
	}

	public function getParam($name){
		return @$_SESSION[$name];
	}

	public function unsetParam($name){
		unset($_SESSION[$name]);
		$this->removeElement($name);

	}


	public function save($name,$value){
		
		if(is_object($value)) $value = serialize($value);
		$this->setParam($name,$value);
	}
	
	public function fetch($name){
		$value = $this->getParam($name);
		if(is_object($value)) $value = unserialize($value);
		return $value;
	}



}

?>