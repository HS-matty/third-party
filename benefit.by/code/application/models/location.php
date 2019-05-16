<?php

class  Location implements iRad_Form {
	
	public $LocationId;
	 static public function getLocations(){
	 	
	 	global $Db;
	 	$Db->query('SELECT * FROM location ORDER BY short_description ASC');
	
	 	return $Db->fetch_all_assoc();
	 	
	 }
	 public function getLocationsExt(){
	 	
	 	global $Db;
	 	$Query = new RadSelectQuery();
	 	$Query->addWhat('*');
	 	$Query->addFrom('location');
	 	
	 	return  $Db->perfromSelectQueryExt($Query);
	
	 	
	 	
	 }
	 public function addLocation($Data){
	 	
	 	global $Db;
		return $Db->sqlgen_insert('location',$Data);
	
	 	
	 	
	 }
	 public function parseAdditionalFields(&$Data,$FieldsXml){
		if($FieldsXml) $Data['params_xml'] = $FieldsXml;

	}
	 public function editLocation($Data){
	 	$LocationId = (int) $Data['location_id'];
	 	unset($Data['location_id']);
	 	global $Db;
	 	return $Db->sqlgen_update('location',$Data);
	 	
	 }
	 
	 static function getCurrentLocationId(){
	 	
		$arr = split('\.',$_SERVER['HTTP_HOST']);
		
		if(count($arr) <=1) return 1;
		
	 	if(@$arr[0] == 'www') $SubDomain = @$arr[1];
	 	
	 	else $SubDomain = @$arr[0];
	 	
	 	if(!$SubDomain) return  1;

	 	
	 	global $Db;
	 	$SubDomain = mysql_real_escape_string($SubDomain);
	 	$Db->query("SELECT * FROM location WHERE subdomain = '$SubDomain' limit 1");
	 	
	 	if(!$Db->rows()) return 1;
	 	return $Db->fetch_element();
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 }
	public function &getLocation($LocationId){
		global $Db;
		$Db->query("SELECT * FROM location WHERE location_id  = $LocationId");
		return $Db->fetch_assoc();
	}
	public function updateLocation($Data){
		global $Db;
		$LocationId = (int) $Data['location_id'];
		unset($Data['location_id']);
		return $Db->sqlgen_update('location',$Data,"location_id = $LocationId");
		
	}
	public function getFormData(){
		return $this->getLocation($this->LocationId);
	}
	public function updateFormObject($Data){
		return $this->updateLocation($Data);
	}
	public function insertFormObject($Data){
		return $this->addLocation($Data);
	}

	
	
}

?>