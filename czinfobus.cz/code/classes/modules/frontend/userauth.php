<?PHP
require_once('busclient.php');
require_once('buspartner.php');
	class UserAuth{
		
		function AuthBusUser($Login,$Password){
		
		
			global $Db;
			$Return = NULL;
			//check if it's cleint
			$Sql = "SELECT * FROM bus_clients WHERE client_login = '$Login' AND client_password = MD5('$Password')";
			if($Db->rows()){
				//found such user
						$Array = $Db->fetch_array();
						//var_dump($Array);
						$Client = new BusClient();
						$Client->Name 	= $Array['client_name'];
						$Return = $Client;
						
			
				
				
			
			}else{
				//check if it partner;
				
				$Sql = "SELECT * FROM bus_dealers WHERE dealer_login = '$Login' AND dealer_password = MD5('$Password')";
				$Db->query($Sql);
				if($Db->rows()){
				//found such user
						$Array = $Db->fetch_array();
						$Partner = new BusParner();
						$Partner->Name= $Array['dealer_corp_name '];
						$Return = $Partner;
						
				}
			
				
			
			}
		return $Return;
		}
	
		
	
	}


?>