<?PHP
require_once('busclient.php');
require_once('buspartner.php');
class BusUserAuth{



	function GetUserData($Id,$UserType){

		switch ($UserType){
			case 'partner':

			$UserObj = new BusParner();

			if($UserObj->GetFullUserData($Id)) return null;



			break;
			case 'client':
			$UserObj = new BusClient();
			if($UserObj->GetFullUserData($Id)) return null;

			break;
			default:

			return null;
			break;


		}
		//	var_dump($UserObj);
		return $UserObj;

	}

	public function ForgotPassword($Login){

		global $Db;
		$Db->query("SELECT client_id,client_email FROM bus_clients WHERE client_login = '$Login'");
		if(!$Db->rows()) return 0;
		$Arr = $Db->fetch_array();
		$Email = $Arr['client_email'];
		$Id = $Arr['client_id'];
		$min=5; // minimum length of password
		$max=10; // maximum length of password
		$pwd=""; // to store generated password

		for($i=0;$i<rand($min,$max);$i++)
		{
			$num=rand(48,122);

			if(($num > 97 && $num < 122))
			{
				$pwd.=chr($num);
			}

			else if(($num > 65 && $num < 90))
			{
				$pwd.=chr($num);
			}

			else if(($num >48 && $num < 57))
			{
				$pwd.=chr($num);
			}

			else if($num==95)
			{
				$pwd.=chr($num);
			}

			else
			{
				$i--;
			}
		}
		

		$Db->query("UPDATE bus_clients SET client_password = md5('$pwd') WHERE client_id = $Id");
		
		@mail($Email,'Password resetting on Czinfobus.cz',"Hello!\n Your new password is \'$pwd\'");


	}
	function AuthBusClient($Login,$Password,$UserType=0){


		global $Db;
		$Return = NULL;



		$Sql = "SELECT * FROM bus_clients WHERE client_login = '$Login' AND client_password = MD5('$Password')";		$Db->query($Sql);
		if($Db->rows()){
			//found such user

			$Array = $Db->fetch_array();
			///var_dump($Array);
			$Client = new BusClient();
			$Client->Name 	= $Array['client_name'];
			$Client->ClientId = $Array['client_id'];

			return  $Client;

		}
		return 0;
	}


	function AuthBusDealer($Login,$Password,$UserType=0){
		global $Db;
		//check if it partner;

		$Sql = "SELECT * FROM bus_dealers WHERE dealer_login = '$Login' AND dealer_password = MD5('$Password')";
		$Db->query($Sql);
		if($Db->rows()){
			//found such user
			$Array = $Db->fetch_array();
			//var_dump($Array);
			$Partner = new BusParner();
			$Partner->Name= $Array['dealer_corp_name'];
			$Partner->Id = $Array['dealer_id'];
			return $Partner;

		}
		return 0;
	}


}


?>