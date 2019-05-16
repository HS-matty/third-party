<?php
	
class Dealer{

	
	public function IsActive($DealerId){
		global $Db;
		$Db->query("SELECT dealer_activeflag FROM bus_dealers WHERE dealer_id = $DealerId ");
		$arr = $Db->fetch_array();
		return $arr[0];
	
	}
	public function SetActiveFlag($PartnerId, $Flag){
	
		$Flag  = (int) $Flag;
		
		global $Db;
		$Db->query("UPDATE bus_dealers SET dealer_activeflag = $Flag WHERE dealer_id = $PartnerId");
		
		
	}
	function &GetDealer($DealerId){
		
		global $Db;
		
		echo $Sql = "SELECT * FROM bus_dealers as d, bus_intervals_currs as c WHERE d.dealer_id = $DealerId AND d.currency_id = c.currency_id";
		$Db->query($Sql);
		$Dealer = $Db->fetch_array();
		
		return $Dealer;	
	
	}
	
	function InsertDealer($CorpName, $Inn,$Address,$Phone1,$Phone2,$Email,$Login,$Password,$CurrencyId){
		global $Db;
		
		$Sql = "INSERT INTO bus_dealers (dealer_corp_name,currency_id,dealer_inn,dealer_address,dealer_phone1,dealer_phone2,dealer_email,dealer_login,dealer_password)
		 VALUES ('$CorpName',$CurrencyId,'$Inn','$Address','$Phone1','$Phone2','$Email','$Login',md5('$Password'))";
		$Db->query($Sql);
	
		if(!$Db->affected_rows()) die('Database Error!');
		
	
	}
	
	function UpdateDealer($DealerId,$CurrencyId,$CorpName, $Inn,$Address,$Phone1,$Phone2,$Email,$Login,$Password=null){
		
			global $Db;
		
		
		$Sql = "UPDATE bus_dealers SET currency_id = $CurrencyId, dealer_corp_name = '$CorpName',dealer_inn='$Inn',dealer_address='$Address',
		dealer_phone1='$Phone1',dealer_phone2 = '$Phone2',dealer_email = '$Email',dealer_login = '$Login'";
		if(!empty($Password)) $Sql .= ", dealer_password = md5('$Password')";
		$Sql .= " WHERE dealer_id = $DealerId"; 		 
		$Db->query($Sql);
		
	
	
	}
		
	function &GetDealers(){
		
		global $Db;
		
		$Sql = "SELECT * FROM bus_dealers";
		$Db->query($Sql);
		$Dealers = $Db->fetch_all_array();
		
		return $Dealers;	
	
	}
	

}

?>