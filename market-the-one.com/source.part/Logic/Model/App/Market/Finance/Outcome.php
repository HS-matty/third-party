<?php

class Logic_Model_App_Market_Finance_Outcome extends Logic_Model {

	




	public function onInit(){

		parent::onInit();;
		$datasource = new Logic_Datasource_App_Market_Finance_Outcome_Table();

		$this->setDatasource($datasource);

	}

}







?>