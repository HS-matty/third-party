<?php

class BusTypes{

	public function GetBusPlacesNum($BusTypeId,$BusId = 0){
		global $Db;
		
		$Sql = "SELECT bustype_places_num FROM bus_bustype WHERE ";
		if($BusTypeId) $Sql .= " bustype_id = $BusTypeId";
		elseif ($BusId) $Sql .= " bus_id = $BusId";
		else return 0;
		$Db->query($Sql);
		
		if($Db->rows()) {
			$arr = $Db->fetch_array();
			return $arr[0];
		}
		else return 0;
		
		
	
	}
	public function &GetBusTypes(){
	
		global $Db;
		$Sql = "SELECT * FROM bus_bustype as t, bus_busowners as o WHERE t.busowner_id = o.busowner_id ORDER BY bustype_id DESC";
		$Db->query($Sql);
		
//		if($Db->rows()){
			
//			$BusTypes = $Db->fetch_all_array();
//			$BusOwner = new BusOwners();
			
//			foreach ($BusTypes as &$BusType) {
				
//				if($BusOwnerInfo=$BusOwner->GetBusOwnerInfo($BusType['bustype_id']))	
//				$BusType['busowner_title'] = $BusOwnerInfo['busowner_title'];
					
					
					
				
				
				
//			}
			
		
//		} 
		$BusTypes = $Db->fetch_all_array();
		
	//	var_dump($BusTypes);
		return $BusTypes;
	}
	
	public function InsertBusType($Title,$PlacesNum,$Tv,$Toilet,$Cond,$Bar,$BusOwnerId,$BusTypePic = 0){
		
		global $Db; 
		$Sql = "INSERT INTO bus_bustype (bustype_title,bustype_places_num,bustype_tv,bustype_toilet,bustype_cond,bustype_bar,busowner_id,bustype_pic) VALUES ('$Title','$PlacesNum','$Tv','$Toilet','$Cond','$Bar','$BusOwnerId',$BusTypePic)";
		$Db->query($Sql);
		if(!$Id = $Db->get_insert_id()) return 0;
		return $Id;
	
	}
	
	public function InsertBusOwner($Title,$Inn,$Address,$Phone1,$Phone2,$Fax,$Email){
		global $Db;
		$Sql = "INSERT INTO bus_busowners (busowner_title,busowner_inn,busowner_address,busowner_phone1,
		busowner_phone2,busowner_fax,busowner_email) VALUES ('$Title','$Inn','$Address','$Phone1','$Phone2','$Fax','$Email')";
		$Db->query($Sql);
		
		
	
	
	}
	
	public function &GetBusOwners(){
		global $Db;
		
		$Db->query("SELECT * FROM bus_busowners ORDER BY busowner_id");
		if($Db->rows()) return $Db->fetch_all_array();
		return 0;
		
		
	}
	
}


?>
