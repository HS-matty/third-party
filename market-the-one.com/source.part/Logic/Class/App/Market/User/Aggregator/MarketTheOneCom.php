<?php

class Logic_Class_App_Market_User_Aggregator_MarketTheOneCom extends Logic_Class_App_Market_User_Aggregator{

	const ACL_USER_ID = 2;

	public function onInit(){
		parent::onInit();


	}
	
	public function load(){
		
		$this->authById(self::ACL_USER_ID);
		return $this;
		
		
	}



}

?>