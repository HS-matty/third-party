<?php

class Logic_Datasource_App_Market_Product_Table extends Datasource_Table  {

public function onInit(){
		
	
		parent::onInit();
		
		
//		$fields = array ( 'id', 'name', 'title','description','url','logo_url');
		
		
		$this->setName('market_product');
		
	//	$this->setFields($fields);
		$table_name = $this->getName();
		
		$this->loadFields();
		
	//	$db_table = new Db_Table($table_name);		
	//	$db_table->load();
		
	//	var_export($db_table->getFieldsArray());
	//		exit();
		
		
		
		
			
	}


}


?>