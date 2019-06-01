<?php

class Logic_Class_App_Market_User_Aggregator_AffiseCom extends Logic_Class_App_Market_User_Aggregator{

	const ACL_USER_ID = 110;

	public function onInit(){
		parent::onInit();


	}
	
	public function load(){
		
		$this->authById(self::ACL_USER_ID);
		return $this;
		
		
	}



}

?>