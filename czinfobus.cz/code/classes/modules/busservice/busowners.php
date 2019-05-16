<?php

class BusOwners{
	
	function &GetBusAllOwners(){
	
		global $Db;
		
		$Sql = "SELECT * FROM bus_busowners";
		$Db->query($Sql);
		return $Db->fetch_all_array();
	
	}
	
	
	function &GetBusOwnerInfo($BusOwnerid){
	
		global $Db;
		$Sql = "SELECT * FROM bus_busowners WHERE busowner_id = $BusOwnerid";
		$Db->query($Sql);
		return $Db->fetch_array();
		
	
	}
	
}
?>