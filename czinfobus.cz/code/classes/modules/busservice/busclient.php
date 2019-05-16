<?php

class BusClient{

	public $Name;
	public $Phone1;
	public $Phone2;
	public $Email;

	public $ClientId;

	public function AddClient($ClientInfo){


		global $Db;
		$Db->sqlgen_insert('bus_clients',$ClientInfo);

		return $Db->get_insert_id();



	}
	public function IfLoginExist($Login){
	
		global $Db;
		$Db->query("SELECT client_login FROM bus_clients WHERE client_login = '$Login'");
		if($Db->rows() == 0) return 0;
		return 1;
	
	}
	
	public function GetClientDiscount($ClientId){

		//5000>10%, 7500<25%, 10000>50%, 15000<75%.
		global $Db;
		$Sql = "SELECT sum(ticket_price) FROM bus_tickets WHERE dclient_id = $ClientId AND ticket_currency_title = 'CZK'";
		$Db->query($Sql);
		$row = $Db->fetch_array();
		$Sum =  $row[0];
		
		$dis = 0;


		if($Sum > 5000 && $Sum < 7500) $dis= 10;
		elseif($Sum > 7500 && $Sum < 10000) $dis= 25;
		elseif($Sum > 10000 && $Sum < 15000) $dis= 50;
		elseif($Sum > 15000 ) $dis= 75;
		else $dis = 0;
		return $dis;







	}
	
	public function GetClientSumCz($ClientId){

		

	}



	public function &GetClients($DealerId){
		global $Db;
		$DealerId = (int) $DealerId;

		$Sql = "SELECT * FROM bus_clients";
		if($DealerId >0) $Sql .= " WHERE dealer_id = $DealerId";

		$Db->query($Sql);
		return $Db->fetch_all_array();

	}


	public function DeleteClient($ClientId){

		global $Db;
		$Db->query("DELETE FROM bus_clients WHERE client_id = $ClientId");


	}
	public function GetFullUserData($ClientId){
		global $Db;
		//Get User data
		$Sql = "SELECT * FROM bus_clients WHERE client_id = $ClientId";
		$Db->query($Sql);
		if(!$Db->rows()) return 1;

		$Data = $Db->fetch_array();
		$this->Name = $Data['client_name'];
		$this->ClientId = $Data['client_id'];
		$this->Phone1 = $Data['client_phone1'];
		$this->Phone2 = $Data['client_phone2'];
		$this->Email = $Data['client_email'];


		return 0;




	}

	public function UpdateClientData($ClientId,$ClientData){
		global $Db;
		$Db->sqlgen_update('bus_clients',$ClientData,"client_id = $ClientId");

	}

	public function &GetFullUserDataExt($ClientId,$DealerId = 0){

		global $Db;
		//Get User data
		$Sql = "SELECT * FROM bus_clients WHERE client_id = $ClientId";
		if($DealerId > 0 ) $Sql .=  " AND dealer_id = $DealerId";

		$Db->query($Sql);
		return $Db->fetch_array();


	}

	public function RegisterNewUser($Name,$Phone1,$Phone2,$Email,$Login,$Password){

		global $Db;

		$Sql = "INSERT INTO bus_clients
		(client_name,client_login,client_password,client_email,client_phone1,client_phone2)
		VALUES ('$Name','$Login',MD5('$Password'),'$Email','$Phone1','$Phone2')";
		$Db->query($Sql);

		return $Db->get_insert_id();



	}

	public function  GetClientStats($ClientId,$DealerId){

		global $Db;
		$Db->query("SELECT sum(b.bus_ticket_price) as sum, count(*) as count FROM bus_tickets as t, bus_buses as b
		 where 	t.ticket_owner = 'dealer' 
		 AND t.ticket_owner_id = $DealerId AND dclient_id = $ClientId
		 AND t.bus_id = b.bus_id GROUP BY t.dclient_id");

		return $Db->fetch_array();

	}




}

?>