<?php
	
	class User{
	
		public $UserId;
		public $User;
		
		public $Group;
		public $GroupId;
		public $GroupDescr;

		
		public function FetchUserData($Login, $Password,$UserId= null){
		
			global $Db;
			
			$Sql = "SELECT u.user_name,u.user_id,g.group_name,g.group_id,g.group_descr FROM auth_users AS u, auth_groups AS g
					WHERE u.group_id = g.group_id";
			
			if(!$UserId)  $Sql .= " AND u.user_login = '$Login' AND u.user_password = MD5('$Password')";
			else $Sql .= " AND u.user_id = '$UserId'";
				
								
			//echo $Sql;
			$Db->query($Sql);
			if($Db->rows()) {
				
				$arr = $Db->fetch_array();
				
					$this->UserId = $arr['user_id'];
					$this->User = $arr['user_name'];
					$this->Group = $arr['group_name'];
					$this->GroupId = $arr['group_id'];
					$this->GroupDescr = $arr['group_descr'];
					return 0; //ok
					
			}
			
			return 1; //failed	
			
			
		}
		
		public function FetchBusUserData($Login,$Password){
			global $Db;
			
			//checj if this is user
			
			$Sql = "SELECT client_id FROM bus_clients WHERE client_login = '$Login' AND client_password=MD5('$Password')";		
			
			$Db->query($Sql);
			if($Db->rows()){
			
				//user is client;
				$this->Group = 'users';
				$this->User = $Login;
				
			
			}else{
			//check if it's a dealer
				$this->Group = 'partners';
				$this->User = $Login;
			
			}
			return 0;
			
		
		}
		
	
	
	}

?>