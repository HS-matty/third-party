<?php

class Logic_Datasource_App_Market_Aggregator_Table extends Datasource_Table  {

public function onInit(){
		
	
		parent::onInit();
		
		
		//$fields = array ( 0 => 'id', 1 => 'market_product_id', 2 => 'name', 3 => 'title', 4 => 'description', 5 => 'link_preview', 6 => 'category', 7 => 'payout', 8 => 'payout_type', 9 => 'clicks', 10 => 'conversions' );
		$fields = array ( 'id',  'title','description' );
		
		
		$this->setName('market_aggregator');
		
		$this->setFields($fields);
		$table_name = $this->getName();
		
		//$db_table = new Db_Table($table_name);		
		//$db_table->load();
		
	//	var_export($db_table->getFieldsArray());
	//		exit();
		
		
		
		
			
	}


}


?>