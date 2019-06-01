<?php

class Logic_Class_App_Acl_User_Event extends Logic_Class{


		public function onInit(){

			parent::onInit();;
			$model_1 = new Logic_Model_App_Acl_User_Event();
	
			$this->addModel($model_1);
		
		}
		

		public function saveEvent(){
			
		}


}


function event(Std_Struct $event_struct){
	
	/*@var $session Logic_Class_App_Acl_User_Session */
	
	$session = Registry::get('Acl_User_Session');
		
	$event = $session->getEvent();
	
	$event_array  = $event_struct->toArray();
	

	$event->getModel()->add($event_array);
	return ;
	
	
	
}

?>