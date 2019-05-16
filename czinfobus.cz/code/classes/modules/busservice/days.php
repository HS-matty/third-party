<?PHP

class Days{



	function __costruct(){

	}

	public function CheckRange($Days,$Range){

		foreach ($Days as $Day) {



		}



	}
	
	public function CountDays($RouteId){
		global $Db;
		$Sql = "SELECT count(*) FROM bus_days WHERE route_id = $RouteId";
		$Db->query($Sql);
		if($Row = $Db->fetch_array()) return $Row[0];
		return 0;



	}
	public function &GetDays($RouteId){

		/*	$Dayz[1] = 'Понедельник';
		$Dayz[2] = 'Вторник';
		$Dayz[3] = 'Среда';
		$Dayz[4] = 'Четверг';
		$Dayz[5] = 'Пятница';
		$Dayz[6] = 'Суббота';
		$Dayz[0] = 'Воскресенье';
		*/
		global $Db;
		global $Weekdays;
		global $InOut;

		$arr = 0;
		$Sql = "SELECT * FROM bus_days WHERE route_id = $RouteId";
		$Db->query($Sql);

		if($Db->rows()){

			$arr =  $Db->fetch_all_array();
			foreach ($arr as &$value) {
				$value['day_departure_name'] = $Weekdays[$InOut->InLang][$value['day_departure']];
				$value['day_arrival_name'] = $Weekdays[$InOut->InLang][$value['day_arrival']];

			}
		}

		return $arr;
	}



	function InsertDays($RouteId,&$DayArray){

		global $Db;
		$Db->Transaction('start');
		$ReturnValue = 0;
		foreach ($DayArray as $Day) {

			$TimeDeparture = $Day['time_departure_hour'].','.$Day['time_departure_minute'].',00';
			$TimeArrival = $Day['time_arrival_hour'].','.$Day['time_arrival_minute'].',00';

			$BusPlacesNum = BusTypes::GetBusPlacesNum($Day['bus_type']);
			//
			$RangeArray = split(',',$Day['places_range']);
			$Error = 0;
			foreach ($RangeArray as $Range) {

				list($Low,$High) = split('-',$Range);
///				print ("Range is $Range, low is $Low, high is $High<br>");

				//check format high > low and  if given range hits bus_places_num
				if($Low > $High || $High > $BusPlacesNum){

					$Error = 1;
					break;
				}




			}

			//preg_match("/([0-9]*),*)$/",$Day['places_list'],$List);


			if( ($Error == 1) || !($BusPlacesNum) ) {
				$ReturnValue = 1;
				break;

			}else{

				$Sql = "INSERT INTO bus_days (route_id,bustype_id,day_departure,time_departure,day_arrival,time_arrival,places_range)
			VALUES
			('$RouteId','$Day[bus_type]','$Day[day_departure]',MAKETIME($TimeDeparture),'$Day[day_arrival]',MAKETIME($TimeArrival),'$Day[places_range]')";

				$Db->query($Sql);
				if(!$Db->affected_rows()){
					$ReturnValue = 1;
					break;
				}
				//		exit();
			}
		}

		if(!$ReturnValue) $Db->Transaction('commit');
		else $Db->Transaction('rollback');
		return $ReturnValue;

	}

	function DeleteDay($DaysId){
		global $Db;
		$Db->query("SELECT route_id FROM bus_days WHERE days_id = $DaysId");
		$arr = $Db->fetch_array();
		if(empty($arr)) return 0;
		$Db->query("DELETE FROM bus_days WHERE days_id = $DaysId");
		$Db->query("SELECT count(*) FROM bus_days WHERE route_id = $arr[0]");
		$arr2 = $Db->fetch_array();
		if($arr2[0] < 2) Route::SetActiveFlag(0,$arr[0]);


	}
	function UpdateDays(&$DayArray){

		global $Db;
		$Error = 0;
		$ReturnValue = 0;
		$Db->Transaction('start');
		//	var_dump($DaysArray);
			
		

		foreach ($DayArray as $Day) {
			$BusPlacesNum = BusTypes::GetBusPlacesNum($Day['bus_type']);
			$TimeDeparture = $Day['time_departure_hour'].','.$Day['time_departure_minute'].',00';
			$TimeArrival = $Day['time_arrival_hour'].','.$Day['time_arrival_minute'].',00';

			$RangeArray = split(',',$Day['places_range']);
			foreach ($RangeArray as $Range) {

				list($Low,$High) = split('-',$Range);
	//			print ("Range is $Range, low is $Low, high is $High<br>");

				//check format high > low and  if given range hits bus_places_num
				if($Low > $High || $High > $BusPlacesNum){

					$Error = 1;
					break;
				}




			}

		
			if( ($Error > 0) || !($BusPlacesNum) ) {

				$ReturnValue = 1;
				break;

			}else{


				

			$Sql = "UPDATE bus_days SET
			bustype_id = '$Day[bus_type]',days_ticket_price = '$Day[ticket_price]',
			day_departure = '$Day[day_departure]',time_departure = MAKETIME($TimeDeparture),
			day_arrival = '$Day[day_arrival]',time_arrival = MAKETIME($TimeArrival),
			places_range = '$Day[places_range]'
			WHERE days_id = '$Day[days_id]'";




				$Db->query($Sql);
				
				if(!$Db->affected_rows()){
					
					$ReturnValue = 1;
					break;
				}
				

			}
		}

		if(!$ReturnValue) $Db->Transaction('commit');
		else $Db->Transaction('rollback');
		return $ReturnValue;



	}


}

?>