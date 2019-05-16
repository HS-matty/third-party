<?php
class BusParner{
	
	public $CorpName;
	public $Phone1;
	public $Phone2;
	public $Email;
	
	public $Id;
	public $History = array();
	
	public function GetFullUserData($PartnerId){
		global $Db;
		//Get User data
		$Sql = "SELECT * FROM bus_dealers WHERE dealer_id = $PartnerId";
		$Db->query($Sql);
		if(!$Db->rows()) return 1;
		
		$Data = $Db->fetch_array();
		$this->Id = $Data['dealer_id'];
		$this->CorpName = $Data['dealer_corp_name'];
		$this->Phone1 = $Data['dealer_phone1'];
		$this->Phone2 = $Data['dealer_phone2'];
		$this->Email = $Data['dealer_email'];
		
	return 0;		
		
	
	
	
	}

	
	

}
?>