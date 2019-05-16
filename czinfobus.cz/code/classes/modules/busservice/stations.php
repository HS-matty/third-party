<?php

class Stations{

	public function DeleteTimings($DaysId){
		global $Db;
		$Sql = "DELETE FROM bus_stations_timing WHERE days_id = $DaysId";
		$Db->query($Sql);

	}
	public function &GetStationTimings($DaysId){

		global $Db;

		$Sql = "SELECT * FROM bus_stations_timing as t,bus_stations as s, bus_points as p WHERE
		t.days_id = $DaysId AND t.station_id = s.station_id AND s.point_id = p.point_id ";
		$Db->query($Sql);
		$Arr = $Db->fetch_all_array();
		return $Arr;


	}
	public function IsTimingsExist($DaysId){

		global $Db;
		$Db->query("SELECT t_id FROM bus_stations_timing WHERE days_id = $DaysId limit 1");
		if($Db->rows() > 0) return 1;
		return 0;

	}
	public function InsertStationTiming($Timings){

		global $Db;
		if(empty($Timings)) return 1;

		foreach ($Timings as $Timing) {

			$Db->sqlgen_insert('bus_stations_timing',$Timing);



		}



	}
	public function &GetAllStations($RouteId,$Lang){

		global $Db;

		$Sql = "SELECT * FROM bus_stations as s,bus_points as p WHERE s.point_id = p.point_id";

		if($RouteId > 0) $Sql .= " AND s.route_id = $RouteId";
		else $Sql .= " GROUP BY point_latin_name";
		$Sql .= " ORDER BY s.station_order ASC";

		//		if($RouteId == 25) echo '<br>'.$Sql;

		$Db->query($Sql);
		$arr = $Db->fetch_all_array();
		//		var_dump($arr);
		return $arr;

	}

	public function SearchRouteByStations($DeparturePointId,$ArrivalPointId){
		//echo $DeparturePointId.'/'.$ArrivalPointId.'<br>';
		global $Db;
		$FoundRoutes  = array();
		$Db->query("SELECT route_id FROM bus_stations WHERE (point_id = $DeparturePointId OR point_id = $ArrivalPointId) GROUP BY route_id");
		$Routes = $Db->fetch_all_array();
		//	var_dump($Routes);

		if(empty($Routes)) return 0;

		foreach ($Routes as $Route){

			$Db->query("SELECT s.route_id,s.station_id, s.point_id ,s.station_order FROM bus_stations as s,bus_routes as r
			WHERE s.route_id = $Route[route_id] 
			AND s.route_id = r.route_id AND r.route_active =1
			ORDER BY station_order ASC");
			$Stations = $Db->fetch_all_array();
			//var_dump($Stations);
			$FoundDepar = 0;
			foreach ($Stations as $Station)

			if($Station['point_id'] == $DeparturePointId && $FoundDepar ==0) $FoundDepar =1;
			elseif ($Station['point_id']==$ArrivalPointId && $FoundDepar == 1) 
			{
				
				array_push($FoundRoutes,$Route['route_id']);
			}
		}



	return $FoundRoutes;



	}




	public function InsertStations($RouteId,$StationsArray){

		global $Db;

		foreach ($StationsArray as  $Station) {
			//print ("<br>key is $key,Val is $value");
			//if($Station['time_in_road'] == 'empty') $Station['time_in_road'] = 0;


			//		$Station['time_in_road_hour'] =  (int) $Station['time_in_road_hour'];
			//		$Station['time_in_road_minute'] =  (int) $Station['time_in_road_minute'];

			//	$TimeInRoad = $Station['time_in_road_hour'].','.$Station['time_in_road_minute'].','.'00';
			//echo '<br>';
			$Sql = "INSERT INTO bus_stations (route_id,station_order,point_id)
			VALUES ('$RouteId','$Station[station_order]','$Station[point_id]')";
			$Db->query($Sql);
			//echo '<br>';
			//echo $Db->GetErrorMessage();

			//	exit();

		}
		//		exit();


	}
	public function IsStationExist($RouteId,$StationOrder){

		global $Db;

		$Sql = "SELECT station_id FROM bus_stations WHERE route_id = $RouteId AND station_order = $StationOrder";
		//echo '<br>';
		$Db->query($Sql);
		if($Db->rows()){

			return 1;
		}
		return 0;

	}

	public function GetStationsNum($RouteId){

		global $Db;
		$Sql = "SELECT count(*) FROM bus_stations WHERE route_id = $RouteId";
		$Db->query($Sql);
		if($Db->rows()) {
			$arr = $Db->fetch_array();
			//	echo $arr[0];
			return $arr[0];
		}
		return 0;

	}
	public function GetLastOrderIndex($RouteId){
		global $Db;
		$Sql = "SELECT station_order FROM bus_stations WHERE route_id = $RouteId  ORDER BY station_order DESC LIMIT 1";
		$Db->query($Sql);
		$Row = $Db->fetch_array();
		if($Row[0]) return $Row[0];
		return 0;




	}
	public function DeleteStation($StationId){

		global $Db;
		$Db->query("DELETE FROM bus_stations WHERE station_id = $StationId");


	}


}

?>