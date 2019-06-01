<?php

class Logic_Class_App_Acl_User_Event_Struct extends Std_Struct {
	
	
	
	public $_fields = array ('name','description','datetime','acl_user_session_id');
	
	public function setStruct($name,$description,$datetime,$acl_user_session_id){
		$this->setParam('name',$name);
		$this->setParam('description',$description);
		$this->setParam('datetime',$datetime);
		$this->setParam('acl_user_session_id',$acl_user_session_id);
		
		
	}

}



class Event_Struct extends Logic_Class_App_Acl_User_Event_Struct{
	
}

?>