<?php


class Bus{


	function CreateRouteArray($StartDate,$EndDate,$data) {
		
		
		
		
		$StartDate = mktime(0,0,0,date('n',$StartDate),date('j',$StartDate),date('Y',$StartDate));
		//$EndDate = mktime(0,0,0,date('n',$EndDate),date('j',$EndDate),date('Y',$EndDate));
		$EndDate = mktime(0,0,0,date('n',$StartDate)+6,date('j',$StartDate),date('Y',$StartDate));
		if( $EndDate < $StartDate ) return 'Route=[];';
		$StartDayweek = date('w',$StartDate);
		$EndDayweek = date('w',$EndDate);

		$Route = array();
		for( $i=0; $i<count($data); $i++ ) {
			$Route[$i]['id'] = $data[$i]['route_id'];
			$Route[$i]['name'] = $data[$i]['route_name_latin'].' / '.$data[$i]['route_name_ru'];
			$days = array();
			for( $j=0; $j<count($data[$i]['days']); $j++ )
			$days[$data[$i]['days'][$j]['day_departure']] = true;

			// Fills data for the first week
			$StartTimestamp = strtotime('-'.$StartDayweek.' day',$StartDate);
			foreach( $days as $day_num => $dummy ) {
				$date = strtotime('+'.$day_num.' day',$StartTimestamp);
				if( ($date >= $StartDate) && ($date <= $EndDate) )
				$Route[$i]['dates'][$date] = true;
			}

			// Start of next week after $StartDate (Sunday)
			$StartTimestamp = strtotime('+'.(7-$StartDayweek).' day',$StartDate);
			// End of previous week before $EndDate (Saturday)
			$EndTimestamp = strtotime('-'.(1+$EndDayweek).' day',$EndDate);
			while( $StartTimestamp < $EndTimestamp ) {
				foreach( $days as $day_num => $dummy ) {
					$date = strtotime('+'.$day_num.' day',$StartTimestamp);
					$Route[$i]['dates'][$date] = true;
				}
				$StartTimestamp = strtotime('+1 week',$StartTimestamp);
			}

			// Fills data for the first week
			$StartTimestamp = strtotime('-'.$EndDayweek.' day',$EndDate);
			foreach( $days as $day_num => $dummy ) {
				$date = strtotime('+'.$day_num.' day',$StartTimestamp);
				if( ($date <= $EndDate) && ($date >= $StartDate) )
				$Route[$i]['dates'][$date] = true;
			}
		}

		$JSRoute = array();
		$n=0;
		for( $i=0; $i<count($Route); $i++ ) {
			if( !isset($Route[$i]['dates']) ||
			!is_array($Route[$i]['dates']) ||
			(count($Route[$i]['dates'])) == 0 ) continue;
			$JSRoute[$n]['id'] = $Route[$i]['id'];
			$JSRoute[$n]['name'] = $Route[$i]['name'];
			foreach( $Route[$i]['dates'] as $date => $dummy ) {
				$JSRoute[$n]['years'][date('Y',$date)][date('n',$date)][date('j',$date)] = true;
			}
			$n++;
		}

		$JSRouteStr = 'Route=[';
		for( $i=0; $i<count($JSRoute); $i++ ) {
			$JSRouteStr .= "\n".$JSRoute[$i]['id'].',"'.addslashes($JSRoute[$i]['name']).'",[';
			foreach( $JSRoute[$i]['years'] as $year => $months ) {
				$JSRouteStr .= "\n".$year.',[';
				foreach( $months as $month => $days ) {
					$JSRouteStr .= "\n".$month.',"Month name #'.$month."\",[";
					foreach( $days as $day => $dummy )
					$JSRouteStr .= $day.',';
					$JSRouteStr = substr($JSRouteStr,0,-1).'],';
				}
				$JSRouteStr = substr($JSRouteStr,0,-1).'],';
			}
			$JSRouteStr = substr($JSRouteStr,0,-1)."],";
		}
		$JSRouteStr = substr($JSRouteStr,0,-1)."];";
		return $JSRouteStr;
	}




	public function GetBusDaysId($BusId){
	
		global $Db;
		$Db->query("SELECT bus_days_id FROM bus_buses where bus_id = $BusId");
		$arr = $Db->fetch_array();
		return $arr[0];
		
	}

	function CanAddNewTicket($BusId){

		global $Db;

		$Sql = "SELECT bus_id FROM bus_buses WHERE bus_id = $BusId AND bus_active = 1";
		$Db->query($Sql);
		if($Db->rows()) return 1;
		return 0;


	}
	function &GetAllBuses($RouteId = 0){

		global $Db;

		$Sql = "SELECT *, DATE_FORMAT(bus_day_depar, '%d/%m/%Y') as bus_day_depar_converted FROM bus_buses as b, bus_bustype as t,bus_busowners as o WHERE
		b.bustype_id = t.bustype_id 
		AND t.busowner_id = o.busowner_id";
		if($RouteId) $Sql .= "AND route_id = $RouteId ";
		$Sql .= " ORDER BY bus_id DESC";
		$Db->query($Sql);
		$Buses = $Db->fetch_all_array();

		$Route = new Route();
		$Tickets = new Tickets();


		foreach ($Buses as &$val) {

			//get Route for each bus
			$val['route'][0] = $Route->GetSingleRoute($val['route_id']);
			//	$val['tickets'] = $Tickets->GetTickets();

		}


		return $Buses;


	}
	public function InsertBus($Route, $Day,$TimeDepar,$AddedBy){

		global $Db ;

		$BusTitle = $Route['route_name_latin'].' / '.$Route['route_name_ru'];


		if($Day['day_arrival'] > $Day['day_departure']) $Diff = $Day['day_arrival'] - $Day['day_departure'];
		else $Diff = ($Day['day_arrival']+7) - $Day['day_departure'];

		$Sql = "INSERT INTO bus_buses (bus_days_id,bustype_id,bus_route_title,route_id,bus_time_arrival,bus_time_depar,bus_day_arrival,bus_day_depar,
		bus_addedby,places_range,bus_addedtime) VALUES  ('$Day[days_id]','$Day[bustype_id]','$BusTitle','$Route[route_id]','$Day[time_arrival]',
		'$Day[time_departure]',ADDDATE(DATE(FROM_UNIXTIME($TimeDepar)),$Diff),DATE(FROM_UNIXTIME($TimeDepar)),'$AddedBy',
		'$Day[places_range]',NOW())";
		$Db->query($Sql);
		if($Id = $Db->get_insert_id()) return  $Id;
		return 0;



	}

	public function GetBusByParams($Time,$RouteId){
		global $Db;
		$Sql = "SELECT bus_id FROM bus_buses 	WHERE bus_day_depar = DATE(FROM_UNIXTIME($Time)) AND route_id = $RouteId";
		$Db->query($Sql);
		if($Db->rows()){
			$row = $Db->fetch_array();
			return $row[0];
		}
		return 0;

	}


	function &GetBus($BusId){
		
		global $Db;

		$Sql = "SELECT  bus_id, bustype_id, bus_route_title, route_id, bus_time_arrival, bus_day_arrival, bus_time_depar, bus_day_depar, bus_addedby, bus_addedtime, places_range, bus_active FROM bus_buses WHERE bus_id = $BusId limit 1";
		$Db->query($Sql);
		global 	$WeekDays;

		if($Db->rows()) {
			$row = $Db->fetch_array();
			//		 $row['bus_day_arrival']  = $WeekDays['ru'][
			/*switch ($row['bus_day_arrival']){
			case 1: $row['bus_day_arrival'] = 'Понедельник';
			break;
			case 2: $row['bus_day_arrival'] = 'Вторник';
			break;
			case 3: $row['bus_day_arrival'] = 'Среда';
			break;
			case 4: $row['bus_day_arrival'] = 'Четверг';
			break;
			case 5: $row['bus_day_arrival'] = 'Пятница';
			break;
			case 6: $row['bus_day_arrival'] = 'Суббота';
			break;
			case 7: $row['bus_day_arrival'] = 'Воскресенье';
			break;


			}

			switch ($row['bus_day_depar']){

			case 1:
			$row['bus_day_depar'] = 'Понедельник';
			break;
			case 2:
			$row['bus_day_depar'] = 'Вторник';
			break;

			case 3: $row['bus_day_depar'] = 'Среда';
			break;
			case 4: $row['bus_day_depar'] = 'Четверг';
			break;
			case 5: $row['bus_day_depar'] = 'Пятница';
			break;
			case 6: $row['bus_day_depar'] = 'Суббота';
			break;
			case 7: $row['bus_day_depar'] = 'Воскресенье';
			break;


			}
			*/

			return $row;
		}
		return null;

	}

}
?>