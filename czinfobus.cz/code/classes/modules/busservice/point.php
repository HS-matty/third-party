<?php
	class Point{
	
	
		function &GetPoints($Lang){
		
			global $Db;
			$PointsArray = null;
			$Sql = "SELECT * FROM bus_points ORDER BY point_latin_name ASC";
			$Db->query($Sql);
			if($Db->rows()) $PointsArray = $Db->fetch_all_array();
			
			return $PointsArray;
		
		}
		
		public function AddPoint($LatinName, $RuName,$IsCz){
		
			global $Db;
			$Sql = "Insert INTO bus_points (point_latin_name,point_ru_name,point_is_cz) VALUES ('$LatinName','$RuName',$IsCz)";
			$Db->query($Sql);
			//exit();
			if($Db->affected_rows()) return 0;
			return 	1;
					
		
		}
		
		public function DeletePoint($PointId){
			global $Db;
			
			$Db->query("DELETE FROM bus_points WHERE point_id = $PointId");
			
		
		}
		
	
	
	}

?>