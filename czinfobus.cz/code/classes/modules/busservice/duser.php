<?PHP

class dUser{

	public function  &GetUsers($DealerId){
		
		
		global $Db;
		$Db->query("SELECT * FROM bus_dusers where dealer_id = $DealerId");
		return $Db->fetch_all_array();
	
	
	}


}

?>