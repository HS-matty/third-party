<?php

class Logic_Datasource_App_Market_Finance_Income_Table extends Datasource_Table  {

public function onInit(){
		
	
	
		
		parent::onInit();	
				
		$current_dir = dirname(__FILE__);

		$this->setName('market_finance_income');
		
		$this->loadFields();
	
		
			
	}


}


?>