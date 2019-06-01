<?php

class Logic_Class_App_Finance_Contractor extends Logic_Class{
	
	const OUTCOME_RATE = 90;
	
	public static function calculateOutcomeSumUsingRate($sum,$rate = null){
		
		if(!$rate) $rate = self::OUTCOME_RATE;
		$return_sum = $sum /100 * $rate;
		
		return $return_sum;
		
	}
	
	public function onInit(){
		//$class_1 =  new Logic_Class_App_Acl_User();
		//$class_1->setName('User');
		
		return ;
	}
	
	
	public function setUser(Logic_Class_App_Acl_User $user){
		$user->setName('User');
		$this->setClass($user);
		return $this;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return Logic_Class_App_Acl_User
	 */
	public   function getUser(){
		return $this->getClass('User');
	
		
	}
	
	public function load($user_id = null){
		
		//$user = getUser();
		//get_class_methods()
		//if($user_id && self::ACL_USER_ID) throw new Exception_App_Finance('user_id and ACL_USER_ID set both');
		
		//if(!$user_id) $user_id = self::ACL_USER_ID;
		
			$this->getUser()->authById($user_id);
	}
	

}

?>