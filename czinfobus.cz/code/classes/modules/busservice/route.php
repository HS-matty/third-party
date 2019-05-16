<?PHP

class 	Route{

	function __construct(){

	}

	public $RouteId;
	public $RouteAddedBy;
	public $RouteAddedTime;
	public $Days;

	public $Stations; //object where all information about stations is located



	public function IsRouteWithGivenNameExist($LatinName,$RuName){

		global $Db;
		$Sql = "SELECT route_id FROM bus_routes WHERE route_name_ru = '$RuName' AND route_name_latin = '$LatinName'";
		$Db->query($Sql);
		if(!$Db->rows()) return 0;
		return 1;




	}
	public function IsRouteExist($RouteId){

		global $Db;
		$Sql = "SELECT route_id FROM bus_routes WHERE route_id = $RouteId";
		$Db->query($Sql);
		if($Db->rows()) return 1;
		return 0;
	}

	public function UpdateRoute($RouteId,$LatinName,$RuName,&$RouteDays=null){

		global $Db;

		$Error = 0;
		$Db->Transaction('start');


		$Sql = "UPDATE bus_routes SET route_name_ru = '$RuName', route_name_latin = '$LatinName'
				WHERE route_id = $RouteId";


		$Db->query($Sql);



		if(!empty($RouteDays)){
			$Days = new Days();
			if($Days->UpdateDays($RouteDays)) $Error = 1;

		}




		if(!$Error) $Db->Transaction('commit');
		else $Db->Transaction('rollback');



	}

	public function DeleteRoute($RouteId){

		global $Db;
		$Db->query("DELETE FROM bus_routes WHERE route_id = $RouteId");




	}
	public function AddRoute($AddedBy,$LatinName,$RuName,&$RouteDays=null){

		global $Db;
		$Error = 0;
		$Db->Transaction('start');


		$Sql = "INSERT INTO bus_routes (route_name_ru,route_name_latin,route_addedby,route_addedtime) VALUES ('$RuName','$LatinName','$AddedBy',NOW())";

		$Db->query($Sql);

		if(!$RouteId = $Db->get_insert_id()) die('cant insert');
		//insert names
		else {
			//

			if(!empty($RouteDays)){
				$Days = new Days();
				if($Days->InsertDays($RouteId,$RouteDays)) $Error = 1;


			}



		}

		if(!$Error) $Db->Transaction('commit');




	}

	public function SetActiveFlag($ActiveFlag,$RouteId){
		
		
		if(($ActiveFlag == 0) || ($ActiveFlag ==1)){
			
		
			global $Db;
			
			$Db->query("SELECT count(*) from bus_days  WHERE route_id = $RouteId");
			
			$Arr = $Db->fetch_array();
			if($Arr[0] == 0 && $ActiveFlag == 1) return 0;
			
			$Db->query("UPDATE bus_routes SET route_active = $ActiveFlag WHERE route_id = $RouteId");


		}

	}
	public function &GetAllRoutes($Active = 'any',$IncludeDaysAndStations = 1){

		//fetch routes with days
		global $Db;

		$Sql = "SELECT * FROM bus_routes";

		if($Active != 'any') {

			$Active = (int) $Active;
			$Sql .= " WHERE route_active = $Active";
		}

		$Sql .= " ORDER BY route_id DESC";

		//get all routes
		$Db->query($Sql);

		$Routes = $Db->fetch_all_array();




		if ($IncludeDaysAndStations) {
			$Days = new Days();
			$Stations = new Stations();
			foreach ($Routes as &$val) {

				//get days of each route
				$val['days'] = $Days->GetDays($val['route_id']);

				$val['stations'] = $Stations->GetAllStations($val['route_id'],'ru');

			}
			//	var_dump($Routes);


		}
		return $Routes;


	}



	public function &GetSingleRoute($RouteId, $Lang='ru',$AddData = 1){

		global $Db;
				
		
		$Sql = "SELECT * FROM bus_routes
			WHERE route_id = $RouteId LIMIT 1";
		
		//get all routes
		$Db->query($Sql);

		$Route = $Db->fetch_array();
		if($AddData){
			$Days = new Days();
			$Stations = new Stations();
			$Route['days'] = $Days->GetDays($RouteId);
			$Route['stations'] = $Stations->GetAllStations($RouteId,'ru');
		}

		return $Route;


	}

	public function CreateRoute($StationsArray,$DaysArray){

		// new Station($StationArray)
		// new Days($DaysArray);

		return 'CreateRoute';
	}

	public function &GetRoutesSchedule($RouteId,$DaysNum){
		global $Db;

		if($DaysNum <= 0 || $DaysNum > 90) $DaysNum = 7;
		$Sql = "SELECT route_id,route_active FROM bus_routes";
		$Db->query($Sql);
		if(!$Db->rows()) return 1;

		$Array = $Db->fetch_array();
		if($Array['route_active'] == 0) return 0;
		$DaysObj = new Days();
		$Days = $DaysObj->GetDays($RouteId);
		if(empty($Days)) return 1;
		$ScheduleArray = array();
		$j=0;

		for($i=0;$i<$DaysNum;$i++){
			$CurrDate = getdate();
			$Time = mktime(0, 0, 0,$CurrDate['mon'], $CurrDate['mday']+$i, $CurrDate['year']);
			$Weekday = date("w", $Time);
			//echo $Weekday.'<br>';
			foreach ($Days as $Day){
				if($Day['day_departure'] == $Weekday){

					$ScheduleArray[$j]['departure_date'] = date("d",$Time).'.'.date("m",$Time).'.'.date("Y",$Time);
					$ScheduleArray[$j]['departure_time'] = $Day['time_departure'];
					if($Day['day_arrival'] >=  $Day['day_departure']) $ArrivalDaysToAdd = $Day['day_arrival'] - $Day['day_departure'] ;
					else $ArrivalDaysToAdd = $Day['day_arrival'] - $Day['day_departure'] +7;
					//echo $Day['time_departure'].', '. $Day['day_arrival'].', '.$ArrivalDaysToAdd.'<br>';
					$ArrivalTime = mktime(0, 0, 0,$CurrDate['mon'], $CurrDate['mday']+$i+$ArrivalDaysToAdd, $CurrDate['year']);
					$ScheduleArray[$j]['arrival_date'] = date("d",$ArrivalTime).'.'.date("m",$ArrivalTime).'.'.date("Y",$ArrivalTime);
					$ScheduleArray[$j]['arrival_time'] = $Day['time_arrival'];
					$j++;



				}

			}

		}
		//var_dump($ScheduleArray);
		return $ScheduleArray;
		//get





	}
	
	public function CheckRouteByPoint($PointId){
	
		global $Db;
		$Sql = "SELECT r.route_id FROM bus_routes as r, bus_stations  as s 
		WHERE s.point_id = $PointId AND r.route_id = s.route_id";
		$Db->query($Sql);
		if(!$Db->rows()) return 0;
		$Row = $Db->fetch_array();
		return $Row[0];
	
	}

	public function GetRouteByDayId($DayId){
	
		global $Db;
		$Sql = "SELECT route_id FROM bus_days WHERE days_id = $DayId LIMIT 1";
		$Db->query($Sql);
		if(!$Db->rows()) return 0;
		$Row = $Db->fetch_array();
		return $Row[0];
	
	}





}

?>