<?php
class FrontendUserActions{
	
	public $IsAdmin = false;
	public $IsAuth = false;
	public $Sid;
	public $View;
	public $IsActive;
	public $IsClosed;
	public $Actions;
	
	public function setView($View){
		if($View != 'edit' && $View != 'view') $this->View = 'view';
		else $this->View = $View;
	}
	public function proceedUser($Data, RadUser $ItemUser, RadUser $LoginedUser){
		

		
		if($LoginedUser->isLogined('RegisteredUser') && ( $ItemUser->getUserId() == $LoginedUser->getUserId() ) ){
			$this->IsAuth = true;
		}
		elseif($ItemUser->generateSidForAnonymousPosting($Data['listing_id']) == $this->Sid){
			$this->IsAuth = true;
		}elseif ($this->Sid == DIRECTORY_ADMIN_KEY){
		
			$this->IsAdmin = true;
			$this->IsAuth = true;
			
			
		}
		
		$this->IsActive  = $Data['is_active'];
		$this->IsClosed =  $Data['is_closed'];
		if($this->IsAuth){
			
			$this->proceedUserActions();		
			
			
			
		}
		
		
		
	}
	protected function proceedUserActions(){
		$this->Actions = array();
		if(!$this->IsActive) $this->Actions[] = 'publish';
		elseif(!$this->IsClosed) $this->Actions[] = 'close';
		
		if($this->View == 'view' && !$this->IsClosed){
			
			$this->Actions[] = 'edit';
		}elseif ($this->View =='edit') {
			$this->Actions[] = 'view';
			$this->Actions[] = 'save';
		}
		if($this->IsAdmin) $this->Actions[] = 'delete_admin';
		elseif (!$this->IsActive) $this->Actions[] = 'delete_user';
		
	}
	public function &getUserActions(){
		
		
		
		return $this->Actions;
		
		
	}
	
	
	
	
	
	
	
	
	
	
}


?>