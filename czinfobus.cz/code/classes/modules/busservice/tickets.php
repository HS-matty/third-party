<?php
class Tickets{

	protected $PlacesNum = 0;

	public function GetPlacesNum(){

		return $this->PlacesNum;

	}
	public function &GetParnerTickets($PartnerId){

		global $Db;
		$Sql = "SELECT * FROM bus_tickets as t,bus_buses as b WHERE t.ticket_owner='dealer' AND t.ticket_owner_id=$PartnerId
		AND b.bus_id = t.bus_id ORDER BY ticket_id DESC";
		$Db->query($Sql);
		$Array = $Db->fetch_all_array();
		return $Array;


	}
	public function &GetClientTickets($ClientId,$DealerId){

		global $Db;
		$Sql = "SELECT * FROM bus_tickets as t,bus_buses as b , bus_clients as c WHERE c.client_id = t.dclient_id 
		AND  t.dclient_id=$ClientId AND t.bus_id = b.bus_id AND c.dealer_id = $DealerId
		ORDER BY ticket_id DESC";
		$Db->query($Sql);
		
		return   $Db->fetch_all_array();
		//var_dump($arr);
		


	}
	
	
	public function &GetTicketInfo($BusId,$TicketPlace){

		global $Db;
		$Sql = "SELECT * FROM bus_tickets WHERE ticket_place = '$TicketPlace' AND bus_id = $BusId LIMIT 1";
		$Db->query($Sql);

		if($Db->rows()) {
			$Row = $Db->fetch_array();
			return $Row;
		}
		return 0;

	}

	public function GetTicketOwner($TicketId){

		global $Db;
		$Db->query("SELECT ticket_owner FROM bus_tickets WHERE ticket_id = $TicketId");
		if(!$Db->rows()) return 0;
		$Arr = $Db->fetch_array();
		if($Arr[0] == 'dealer'){
			$Sql = "SELECT * FROM bus_tickets as t, bus_dealers as d 
			WHERE t.ticket_id = $TicketId AND t.ticket_owner_id = d.dealer_id";
			$Db->query($Sql);
			return $Db->fetch_array();
			
		}


	}
	public function IsTicketExists($TicketId){

		global $Db;
		$Sql = "SELECT ticket_id FROM bus_tickets WHERE ticket_id = '$TicketId'";
		$Db->query($Sql);

		if($Db->rows()) return 1;
		return 0;

	}
	public function IsTicketExistsExt($BusId,$TicketPlace){

		global $Db;
		$Sql = "SELECT ticket_id,ticket_owner,ticket_owner_id FROM bus_tickets WHERE ticket_place = '$TicketPlace' AND bus_id = '$BusId'";
		$Db->query($Sql);

		if($Db->rows()) return 1;

		return 0;

	}

	public function SetTicketPayed($TicketId,$PayFlag = 0){

		global $Db;
		$PayFlag = (int) $PayFlag;
		//echo $Status;
		$Sql = "UPDATE bus_tickets SET ticket_payed = $PayFlag WHERE ticket_id = $TicketId";
		$Db->query($Sql);
		//echo $Db->GetErrorMessage();
		if($Db->affected_rows()) return 0;
		return 1;



	}

	public function ReserveTicket($TicketId,$ClientId,$TicketPrice,$TicketCurrency,$IntervalTitle,$UserType){

		global $Db;
		//user type  1 = common client
		// 2 = dealer cleint
		$Db->query("UPDATE bus_tickets SET dclient_id = $ClientId,ticket_interval_title = '$IntervalTitle', ticket_price = $TicketPrice, ticket_currency_title  = '$TicketCurrency', user_type = $UserType WHERE ticket_id = $TicketId");


	}

	public function SetTicketStatus($TicketId,$Status){


		global $Db;
		//echo $Status;
		$Sql = "UPDATE bus_tickets SET ticket_status = '$Status' WHERE ticket_id = $TicketId";
		$Db->query($Sql);
		//echo $Db->GetErrorMessage();
		if($Db->affected_rows()) return 0;
		return 1;


	}
	public function GetTicketCount($ClientId,$NotPayed = 1){
		global $Db;
		$Sql = "SELECT count(*) FROM bus_tickets WHERE dclient_id = $ClientId";
		if($NotPayed) $Sql .= " AND ticket_payed=0";
		$Db->query($Sql);
		$arr = $Db->fetch_array();
		return $arr[0];
		
	
	
	
	}

	public function AddTicket($BusId,$TicketStatus,$TicketOwner,$TicketOwnerId,$TicketPlace){

		global $Db;

		$Sql = "INSERT INTO bus_tickets (bus_id,ticket_status,ticket_owner,ticket_owner_id,ticket_place)
	 	VALUES ('$BusId','$TicketStatus','$TicketOwner','$TicketOwnerId','$TicketPlace')";
		$Db->query($Sql);
		//echo $Db->GetErrorMessage();
		if($InsertId = $Db->get_insert_id()) {
			ActionsLog::Log($TicketOwnerId,"$TicketOwner created ticket with id=$InsertId, busid = $BusId");
			return $InsertId;
		}
		return 0;

	}
	public function  DeleteTicket($TicketId){

		global $Db,$LogData;
		$Sql = "DELETE FROM bus_tickets WHERE ticket_id = $TicketId";
		//var_dump($LogData);
		//die();
		$Db->query($Sql);
		if($LogData['id']) ActionsLog::Log($LogData['id'],"$LogData[User] deleted ticket ID $TicketId");

	}


	public function &GetTicket($TicketId,$Owner = 0,$OwnerId = 0){

		global $Db;

		$Sql = "SELECT t.*,b.bus_day_arrival FROM bus_tickets as t, bus_buses AS b
		WHERE t.ticket_id = $TicketId AND t.bus_id = b.bus_id"; 
		if($Owner && ((int) $OwnerId)) $Sql .= " AND ticket_owner = '$Owner' AND ticket_owner_id = '$OwnerId'";


		$Db->query($Sql);
		$Array = $Db->fetch_array();
		if(!empty($Array)) return $Array;

		return 0;

	}

	public function &GetTicketExt($TicketId,$DealerId){

		global $Db;
		//echo $TicketId;
		
		$Sql = "SELECT * FROM bus_buses as b,bus_tickets as t, bus_clients AS c
		WHERE t.ticket_id = $TicketId";
		if($DealerId >0) $Sql .= " AND t.ticket_owner = 'dealer'	AND t.ticket_owner_id=$DealerId AND b.bus_id = t.bus_id"; 
		else {
			global $InOut;
			if($InOut->InSideType != BACKEND) return 0;
			
					
		}
		
		


		$Db->query($Sql);
		$Array = $Db->fetch_array();
		if(!empty($Array)) return $Array;

		return 0;

	}

	public function &GetDealerTickets($DealerId,$NotDate=0){

		global $Db;


		$Sql = "SELECT *   FROM bus_tickets as t, bus_buses as b, bus_clients as c WHERE
		t.bus_id = b.bus_id AND t.ticket_owner = 'dealer' AND t.ticket_owner_id = $DealerId
		AND c.client_id = t.dclient_id";
		if($NotDate ==1) $Sql .= " AND CURDATE() < bus_day_depar ";
		$Sql .= " ORDER BY ticket_id DESC";
		$Db->query($Sql);
		$Array = $Db->fetch_all_array();

		return $Array;



	}

	public function &GetDealerTicket($TicketId, $DealerId){

		global $Db;
		$Db->query("SELECT * FROM bus_tickets as t, bus_buses as b LEFT JOIN bus_dclients ON bus_dclients.dclient_id=t.dclient_id WHERE ticket_id = $TicketId
		AND ticket_owner = 'dealer' AND ticket_owner_id = $DealerId AND t.bus_id = b.bus_id");
		return $Db->fetch_array();

	}


	public function &GetPayedDealerTicketsCount($DealerId){

		global $Db;
		$Sql = "SELECT count(*) as count,SUM(b.bus_ticket_price) as sum FROM bus_tickets as t, bus_buses as b
		WHERE t.ticket_owner_id = $DealerId AND ticket_payed >0 
		AND b.bus_id = t.bus_id";

		//echo $Sql;
		$Db->query($Sql);
		if(!$Array = $Db->fetch_array()) $Array = null;

		//	var_dump($Array);
		return $Array;



	}







	public function CheckTicketRangeList($Place,$Range,$List){

		$Valid = 0;

		preg_match("/^([0-9]*)\-([0-9]*)$/",$Range,$RangeArray);
		if(!empty($RangeArray)) {

			if($Place <= $RangeArray[3] && $Place >= $RangeArray[2]) $Valid=1;


		}

		if(!$Valid)
		$ListArray = split(',',$List);
		if(!empty($ListArray))
		foreach ($ListArray as $val) {
			if ($Place == (int) $val){
				$Valid =1;
				break;
			}

		}
		return $Valid;




	}

	
	public function &GetTickets($BusId, $RangeArray ,$List = 0, $Status = 'any'){

		$SkipFlag = 0;




		


		global $Db;
		
		switch ($Status) {

			case 'free':

			$Sql = "SELECT * FROM bus_tickets WHERE bus_id = $BusId
			AND ( ticket_status='waiting' OR ticket_status='reserved')";
			$FreeFlag = 1;



			break;

			case 'any':

			$Sql = 'SELECT * FROM bus_tickets';
			if($BusId) $Sql .= " WHERE bus_id = $BusId";

			break;


			default:
			die('tickets error');
			break;


		}


		$Db->query($Sql);
		$Tickets = $Db->fetch_all_array();

		$j=0;
		foreach ($RangeArray as $Range) {

			list($Start,$End) = split('-',$Range);
			if($Start > $End) return 1;



			for($i=$Start; $i<=$End ; $i++){
				//	echo $i;
				//echo '<br>';
				$SkipFlag = 0;
				$IsTicketExist = 0;

				foreach ($Tickets as &$Ticket) {

					$TicketStatus = null;

					if($Ticket['ticket_place'] == $i){
						if(($TicketStatus!='free') && ($Status=='free')) {
							$IsTicketExist = 1;
							$SkipFlag = 1;
							break;


						}
						$TicketStatus = $Ticket['ticket_status'];
						$IsTicketExist = 1;

						$TicketId = $Ticket['ticket_id'];
						if($Ticket['ticket_owner'] == 'dealer'){
							$Dealer = new Dealer();
							$Ticket['reserved'] = $Dealer->GetDealer($Ticket['ticket_owner_id']) ;
							$Status = 'partner';
							$ReservedByName = $Ticket['reserved']['dealer_name'];
							$ReservedById = $Ticket['reserved']['dealer_id'];
							$ReservedByObj = 'dealer';

						}

						elseif($Ticket['ticket_owner'] == 'admin'){
							global $Auth;
							$ReservedByName = $Auth->GetUserName($Ticket['ticket_owner_id']);
							$Status  = 'admin';
							
							

							$ReservedById = '';
							$ReservedByObj = '#';

						}elseif($Ticket['ticket_owner'] == 'user'){

							$Ticket['reserved'] = BusClient::GetFullUserDataExt($Ticket['ticket_owner_id']);
							
							$ReservedByName = $Ticket['reserved']['client_name'];
							$ReservedById = $Ticket['reserved']['client_id'];
							$ReservedByObj = 'user';
							


						}elseif ($Ticket['ticket_owner'] == 'nobody'){
							$Reserved = 0;
							$Status = 'free';

						}


					}

					if($IsTicketExist) {

						break;
					}
				}
				if(!$SkipFlag){
					if(!@$TicketStatus) $TicketStatus = 'none';

					$TicketsArray[$j]['id'] = $i;
					$TicketsArray[$j]['ticket_status'] = $TicketStatus;

					if(!$IsTicketExist)	{

						$TicketsArray[$j]['status'] = 'not_created';

					}
					else{

						$TicketsArray[$j]['ticket_id'] = $TicketId;
						$TicketsArray[$j]['status'] = $Status;

						$TicketsArray[$j]['reserved_by_id'] = $ReservedById;
						$TicketsArray[$j]['reserved_by_name'] = $ReservedByName;
						$TicketsArray[$j]['reserved_by_obj'] = $ReservedByObj;
						$TicketsArray[$j]['status'] = $Status;
					}
					$j++;

				}


			}
		}
		$this->PlacesNum = $j;
		//	var_dump($TicketsArray);
		return $TicketsArray;
	}

}

?>