<?php

class Logic_Class_App_Acl_User_Token extends Logic_Class{


		public function onInit(){
		
			$model_1 = new Logic_Model_App_Acl_User_Token();
			$this->addModel($model_1);

			
		}
		
		
		public function loadPublicToken(){
			
			$params = array('id'=>2);
			$this->getModel('Token')->load($params);
			
		}

		public function generateToken($value, $salt = null){
			return sha1($value.'-'.$salt);
		}
		
		public function add($value,$salt=null){
			
			$acl_user_id = 1;
			
			if($user = $this->getClass('User')){
				$acl_user_id = $user->getId();
			}
			$token = $this->generateToken($value,$salt);
			$token_array = array('name'=>'reset password','description'=>NULL,'datetime'=>'NOW()','start_datetime'=>'NOW()','end_datetime'=>'NOW()','acl_user_id'=>$acl_user_id,'value'=>$token);
			$id = $this->getModel('Token')->add($token_array)->getId();
			$this->getModel('Token')->load(array('id'=>$id));
			return $this;
			
		}
}

?>