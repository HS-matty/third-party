<?

class Intervals{

	private $Intervals = array();
	
	function &GetIntervals(){
		
		return $this->Intervals;
	
	
	}
	
	public function GetCurrencyTitle($CurrId){
		global $Db;
		$Db->query("SELECT currency_name FROM bus_intervals_currs WHERE currency_id = $CurrId");
		$arr = $Db->fetch_array();
		return $arr[0];
	
	}
	
	public function IfIntervalsExist($DayId){
		
		global $Db;
		$Sql = "SELECT 	count(*) FROM bus_intervals WHERE days_id = $DayId";
		$Db->query($Sql);
		$arr = $Db->fetch_array();
		return $arr[0];
	
	}
	public function UpdatePriceValue($PriceId,$PriceValue){
	global $Db;
	
	
	$Db->sqlgen_update('bus_interval_prices',array('price_value'=>$PriceValue),"price_id = $PriceId");
	
		
	
	}
	public function &GetIntervalInfo($IntervalId){
		global $Db;
		$Db->query("SELECT * FROM bus_intervals WHERE interval_id = $IntervalId");
		$Interval = $Db->fetch_array();
		if(empty($Interval)) return 0;
		$StationId  = $Interval['departure_station_id'];
		$Sql = "SELECT p.point_latin_name,p.point_ru_name FROM bus_points as p,bus_stations as s
			WHERE s.station_id = $StationId AND p.point_id = s.point_id";
		$Db->query($Sql);
		$Arr = $Db->fetch_array();
		$Title = $Arr['point_latin_name'];
		$StationId  = $Interval['arrival_station_id'];
		$Db->query("SELECT p.point_latin_name,p.point_ru_name FROM bus_points as p,bus_stations as s
			WHERE s.station_id = $StationId AND p.point_id = s.point_id");
		unset($Arr);
		$Arr = $Db->fetch_array();
		
		$Title .= ' - '.$Arr['point_latin_name'];
		$Interval['title'] = $Title;
		return $Interval;
	
	}
	public function &GetCurrencies(){
	
		global $Db;
		$Db->query('SELECT * FROM bus_intervals_currs');
		return $Db->fetch_all_array();
		
	
	}
	public function GetPriceValueExt($PriceId){
		
		global $Db;
		
		$Db->query("SELECT price_value FROM bus_interval_prices WHERE price_id = $PriceId");
		$arr = $Db->fetch_array();
		return $arr[0];
		
	}
	public function &GetPriceValue($IntervalId,$CurrencyId){
		global $Db;
		$Sql = "SELECT * FROM bus_intervals_currs as c, bus_interval_prices as p
		WHERE p.interval_id = $IntervalId AND p.currency_id = $CurrencyId
		AND p.currency_id = c.currency_id";
		$Db->query($Sql);
		
		if(!$Db->rows()){

			//create record
			$Db->query("SELECT currency_id FROM bus_intervals_currs WHERE currency_id = $CurrencyId LIMIT 1");
			if($Db->rows()){
				
				$Db->query("INSERT INTO bus_interval_prices (currency_id,interval_id) VALUES ($CurrencyId,$IntervalId)");
				
			}
		
		}
		
		$Db->query($Sql);
		return $Db->fetch_array();
	
	}
	function DeleteRouteIntervals($RouteId){
		
		global $Db;
		$Db->query("SELECT days_id FROM bus_days WHERE route_id = $RouteId");
		$Arr = $Db->fetch_all_array();
		if(!empty($Arr)){
			$Sql = "DELETE FROM bus_intervals WHERE";
			$First = 1;
			foreach ($Arr as $Day){
				if($First) {
					$Sql .= " days_id = $Day[0]";
					$First = 0;
				}else{
					
					$Sql .= " OR days_id = $Day[0]";
				
				}
			
			}
			
			$Db->query($Sql);
		}
		
		
	}
	function LoadIntervals($DayId,$SkipZeroPrice = 0){
		global $Db;
		$Db->query("SELECT * FROM 	bus_intervals as i	WHERE  days_id = $DayId"); 
		
		$this->Intervals = $Db->fetch_all_array();
	//	var_dump($this->Intervals);
		foreach ($this->Intervals as &$Interval) {
			

			$IntervalId = $Interval['interval_id'];
			$Sql  = "SELECT i.currency_id,i.currency_name,p.price_id, p.price_value 
			FROM bus_intervals_currs as i LEFT JOIN 
			 bus_interval_prices  as p ON p.currency_id=i.currency_id 	WHERE p.interval_id = $IntervalId";
			
			if($SkipZeroPrice) $Sql .= " AND p.price_value > 0";
			//echo $Sql;
			$Db->query($Sql);
			
			
			$Interval['currs'] = $Db->fetch_all_array();
			
			
			
			$dStationId = $Interval['departure_station_id'];
			//echo '<br>';
			$aStationId = $Interval['arrival_station_id'];
			//echo '<br>';
			
			$Db->query("SELECT p.point_latin_name,p.point_ru_name FROM bus_points as p,bus_stations as s
			WHERE s.station_id = $dStationId AND p.point_id = s.point_id");
			$Arr = $Db->fetch_array();
			//var_dump($Arr);
			$Interval['departure_point_latin_name'] = $Arr['point_latin_name'];
			$Interval['departure_point_ru_name'] = $Arr['point_ru_name'];
			
			$Db->query("SELECT p.point_latin_name,p.point_ru_name FROM bus_points as p,bus_stations as s
			WHERE s.station_id = $aStationId AND p.point_id = s.point_id");
			unset($Arr);
			$Arr = $Db->fetch_array();
			//echo '<br>';
			//var_dump($Arr);
			$Interval['arrival_point_latin_name'] = $Arr['point_latin_name'];
			$Interval['arrival_point_ru_name'] = $Arr['point_ru_name'];
			
			
			
		}
		
		
		
	}
	
	function DeleteIntervals($DaysId){
		global $Db;
		$Db->query("DELETE FROM bus_intervals WHERE days_id = $DaysId");
		
	}
	function CreateIntervals($DayId){
		global $Db;
		
		$Db->query("SELECT route_id FROM bus_days WHERE days_id = $DayId ");
		$arr = $Db->fetch_array();
		$RouteId = $arr[0];
		
		
		//get stations
		
		$Db->query("SELECT * FROM bus_stations as s, bus_points as p 
		WHERE s.route_id = $RouteId AND s.point_id = p.point_id ORDER BY s.station_order ASC");
		
		$Stations = $Db->fetch_all_array();
		
		
		
		$j = 0;
		$k= 0 ;
		
		foreach ($Stations as &$Station){
			
			
			foreach ($Stations as &$ArrStation){
				
		//		print("bla $ArrStation[point_is_cz] , $ArrStation[point_ru_name] / $Station[point_is_cz],$Station[point_ru_name] <br>");
				if($Station['station_order'] >= $ArrStation['station_order']) {
					
					//echo $Station['station_order'].','.$ArrStation['station_order'].'<br>';
					continue;
				}
				
			//	elseif (($ArrStation['point_is_cz'] == 1) && ($Station['point_is_cz'] == 1)) continue;
			elseif ($ArrStation['point_is_cz'] ==  ($Station['point_is_cz'] )) continue;
				$this->Intervals[$j]['departure_station_id'] = $Station['station_id'];
				//$this->Intervals[$j]['departure_station'] = $Station['point_latin_name'];
				$this->Intervals[$j]['arrival_station_id'] = $ArrStation['station_id'];
				$this->Intervals[$j]['days_id'] = $DayId;
				//$this->Intervals[$j]['arrival_station'] = $ArrStation['point_latin_name'];
				++$j;
				
			
			}
		
		
		}
		//get all currencies
		$Db->query("SELECT currency_id FROM bus_intervals_currs");
		$Currencies = $Db->fetch_all_array();
		
		
		foreach ($this->Intervals as $Interval) {
			
			$Db->sqlgen_insert('bus_intervals',$Interval);
			$IntervalId = $Db->get_insert_id();
			foreach ($Currencies as &$Currency) {
				$Currency['interval_id'] = $IntervalId;
				$Currency['price_value'] = 0;
				$Db->sqlgen_insert('bus_interval_prices',$Currency)	;	
				
			}
				
		}
		
		
		
		

	}
	
	
	

}

?>