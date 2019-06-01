<?php

class Logic_Datasource_App_Market_Category_Table extends Datasource_Table  {

public function onInit(){
		
	
		parent::onInit();
		
		
		$fields = array ( 0 => 'id', 1 => 'name', 2 => 'title', );
		
		
		$this->setName('market_category');
		
		$this->setFields($fields);
		$table_name = $this->getName();
		
	//	$db_table = new Db_Table($table_name);		
	//	$db_table->load();
		
	//	var_export($db_table->getFieldsArray());
	//		exit();
		
		
		
		
			
	}


}


?>