<?php

class Logic_Datasource_App_Market_Offer_Meta_Table extends Datasource_Table  {

public function onInit(){
		
	
		parent::onInit();
		
		
		$fields = array ( 0 => 'id', 1 => 'item_id', 2 => 'hash_id', 3 => 'meta', );
		
		
		$this->setName('market_offer_meta');
		
		$this->setFields($fields);
		$table_name = $this->getName();
		
	//	$db_table = new Db_Table($table_name);		
	//	$db_table->load();
		
	//	var_export($db_table->getFieldsArray());
	//		exit();
		
		
		
		
			
	}


}


?>