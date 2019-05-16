<?PHP

class dClients{

	public function  &GetClients($DealerId){
		
		
		global $Db;
		$Db->query("SELECT * FROM bus_dclients where dealer_id = $DealerId ORDER BY dclient_id DESC");
		return $Db->fetch_all_array();
	
	
	}
	
	public function &GetClient($ClientId,$DealerId){
		global $Db;
		$Db->query("SELECT * FROM bus_dclients where dealer_id = $DealerId AND dclient_id = $ClientId");
		return $Db->fetch_array();
	
	
	}
	
	public function AddClient($ClientInfo){
	
	
		global $Db;
		$Db->sqlgen_insert('bus_dclients',$ClientInfo);
	//	var_dump($ClientInfo);
		echo $Db->GetErrorMessage();
		
		
	
	}
	
	public function UpdateClientInfo($ClientId,$DealerId,$Info){
		global $Db;
		$Db->sqlgen_update('bus_dclients',$Info,"dclient_id = $ClientId AND dealer_id = $DealerId");
		
	
	}
	
	public function  GetClientStats($ClientId,$DealerId){
		
		global $Db;
		$Db->query("SELECT sum(b.bus_ticket_price) as sum, count(*) as count FROM bus_tickets as t, bus_buses as b
		 where 	t.ticket_owner = 'dealer' 
		 AND t.ticket_owner_id = $DealerId AND dclient_id = $ClientId
		 AND t.bus_id = b.bus_id GROUP BY t.dclient_id");
		
		return $Db->fetch_array();
		
	}
	function &GetClientHistory($ClientId,$DealerId){
	
		global $Db;
		$Db->query("SELECT * FROM bus_tickets as t, bus_buses as b
		 where 	t.ticket_owner = 'dealer' 
		 AND t.ticket_owner_id = $DealerId AND dclient_id = $ClientId
		 AND t.bus_id = b.bus_id ");
		return $Db->fetch_all_array();
		
	}
	public function DeleteClient($ClientId){
		global $Db;
		//check if user has history
	
		$Db->query("SELECT count(*) FROM bus_tickets WHERE dclient_id = $ClientId");
		$Row = $Db->fetch_array();
		if( $Row[0]>0 ) return 1;
		
		$Db->query("DELETE FROM bus_dclients WHERE dclient_id=$ClientId");
		return 0;
		
		

	
	
	
	}


}

?>