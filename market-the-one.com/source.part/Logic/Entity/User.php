<?php

class Logic_Entity_User extends Logic_Entity {

	/**
	 * Enter description here...
	 *
	 * @var Logic_Class_Group
	 */
	public $_group;




	public function onInit(){
		
		$this->setClass(new Acl_User());
		return $this;
		
	}






}



?>