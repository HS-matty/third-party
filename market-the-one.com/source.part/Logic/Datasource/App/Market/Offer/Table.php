<?php

class Logic_Datasource_App_Market_Offer_Table extends Datasource_Table  {

public function onInit(){
		
	
	
		
		parent::onInit();	
				
		//$fields = array ( 0 => 'id', 1 => 'market_product_id', 2 => 'name', 3 => 'title', 4 => 'description', 5 => 'link_preview', 6 => 'category', 7 => 'payout', 8 => 'payout_type', 9 => 'clicks', 10 => 'conversions' );
		//$fields = array ( 'id',  'market_product_id', 'payout', 'payout_type',  'clicks_in',  'conversions','clicks_in','clicks_out','url');
		$current_dir = dirname(__FILE__);
		
//		include($current_dir.'/Table/_fields.php');
		
		
		$this->setName('market_offer');
		
		$this->loadFields();
		//$this->setFields($fields);
		//$table_name = $this->getName();
	
		
		
		//$db_table = new Db_Table($table_name);		
		//$db_table->load();
		
	//	var_export($db_table->getFieldsArray());
	//		exit();
		
		
		
		
			
	}


}


?>