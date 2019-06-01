<?php

class Logic_Model_App_Market_Offer extends Logic_Model {

	

	public function onInit(){

		parent::onInit();;
		$datasource = new Logic_Datasource_App_Market_Offer_Query_Select();
		$this->setDatasource($datasource);

	}






	/**
	 * Enter description here...
	 *
	 * @param array $params
	 * @return Logic_Model_App_Market_Product
	 */
	public function add(array $params = null){

		$array = $this->getParams();

		$table = new Logic_Datasource_App_Market_Offer_Table();
		$id = $table->insertRow($array);

		//$id = $market_product_table->insertRow($array);
		$this->setId($id);
		return $this;


	}

	//public $_data;

}


?>