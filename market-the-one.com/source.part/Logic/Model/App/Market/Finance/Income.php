<?php

class Logic_Model_App_Market_Finance_Income extends Logic_Model {

	




	public function onInit(){

		parent::onInit();;
		$datasource = new Logic_Datasource_App_Market_Finance_Income_Table();

		$this->setDatasource($datasource);

	}

}







?>