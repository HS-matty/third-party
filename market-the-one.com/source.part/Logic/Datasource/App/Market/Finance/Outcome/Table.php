<?php

class Logic_Datasource_App_Market_Finance_Outcome_Table extends Datasource_Table  {

public function onInit(){
		
	
	
		
		parent::onInit();	
				
		$current_dir = dirname(__FILE__);

		$this->setName('market_finance_outcome');
		
		$this->loadFields();
	
		
			
	}


}


?>