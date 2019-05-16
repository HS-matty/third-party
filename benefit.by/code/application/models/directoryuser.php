<?php

	class DirectoryUser{
		
		public $UserId;
		public $UserData;
		
		
		public function onUpdate(){
			
			return true;			
		}
		public function onInsert($Data){
			$Ret = true;
			global $Page;
			if($this->checkIfUserExists($Data['login'])){
				$Page->addErrorExt('Login','already exists');
				$Ret = false;
			}
			return $Ret;
			
		}
		public function canAddNewItem(){
			
			//count items
			
			global $Db;
			
			$UserId = $this->UserData['duser_id'];
			$ItemsLimit = $this->UserData['items_limit'];
			$Db->query("SELECT count(*) FROM directory_items WHERE duser_id = $UserId");
			$Count = $Db->get_element();
			if($Count >= $ItemsLimit) return false;
			return true;
			
		}
		
		static function &getUserList(){
			global $Db;
			
			$Sql = "SELECT directory_users.*,count(directory_items.ditem_id) as items_count FROM directory_users LEFT JOIN directory_items ON(directory_items.duser_id =  directory_users.duser_id) GROUP BY directory_users.duser_id";
			
			//$Sql = "SELECT directory_users.*,count(directory_cat_content.ditem_id) as items_count FROM directory_users LEFT JOIN directory_items ON(directory_items.duser_id = directory_users.duser_id) LEFT JOIN directory_cat_content ON (directory_cat_content.ditem_id = directory_items.duser_id) GROUP BY directory_users.duser_id";
			//$Sql = "SELECT directory_users . * , (select count( * ) from directory_cat_content where directory_cat_content.ditem_id = directory_items.ditem_id) AS items_count FROM directory_users LEFT JOIN directory_items ON ( directory_items.duser_id = directory_users.duser_id )  GROUP BY directory_users.duser_id";
		//$Sql = "SELECT * FROM directory_users";
			$Db->performSelectQueryForList($Sql);
			return $Db->getQrFetchedRows();
			
		}
		
		static function checkIfUserExists($Login,$UserId = 0){
			global $Db;
			
			$Sql = "select duser_id,login from directory_users WHERE login='$Login'";
			if($UserId) $Sql .= " AND duser_id != $UserId";
			
			$Db->query($Sql." limit 1");
			return $Db->rows();
			
			
			
			
		}
		public  function AuthUser($Login,$Password){		
		
			global $Db;
			$Db->query("SELECT * FROM directory_users 
			WHERE login = '$Login' AND password = '$Password' limit 1");
			if($row =& $Db->fetch_assoc()){
				
				$this->UserData = $row;
				return true;
			}
			
			return false;
		}

		public function registerSession(){
			
			if(!$this->UserData) throw new Exception('cannot register user session');
			unset($this->UserData['password']);
			$_SESSION['data'] = $this->UserData;
						
			
		}
		
		public function checkSession(){
			
			if(@$Data = @$_SESSION['data']){
				
				$this->UserData = $Data;
				$this->UserId = $Data['duser_id'];
				return true;
				
				
				
			}
			return false;
			
			
		}
		public function closeSession(){
			
			unset($_SESSION['data']);
			session_start();
			
		}
		
		
		
		
		
		static  function &getUserArray($Id){
			global $Db;
			$Db->query("SELECT * FROM directory_users WHERE duser_id = $Id");
			return $Db->fetch_assoc();
			
		}
		static function deleteUser($UserId){
			global $Db;
			$Db->query("DELETE FROM directory_users WHERE duser_id = $UserId");
			return $Db->affected_rows();
			
		}
		public  function addUser($Data){
			global $Db;
			if($this->onInsert($Data)){
			//if(true){
				$Db->sqlgen_insert('directory_users',$Data);
				return $Db->get_insert_id();	
			}
			return null;
			
			
		}
		
		public function updateUser($Data){
			
			$UserId = (int) $Data['duser_id'];
			unset($Data['duser_id']);
			global $Db;
			
			$Db->sqlgen_update('directory_users',$Data,"duser_id = $UserId");
			return  $Db->affected_rows();
			
			
		}
		
		static public function &getUserInfoForPaycenterModule($UserId){
			
			global $InOut;
			$UserArr =& self::getUserArray($UserId);
			$Arr = array('name'=>$UserArr['name'].' '.$UserArr['last_name'],
			'id'=>$UserArr['duser_id']);
			 $Arr['link'] = $InOut->GenerateFullUrl('directory',array('user','edit'),null,0,array('duser_id'=>$UserId));
			 
			 return $Arr;
			 
			
		}
		
				
		
	}

?>