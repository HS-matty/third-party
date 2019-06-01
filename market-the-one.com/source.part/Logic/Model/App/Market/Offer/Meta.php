<?php

class Logic_Model_App_Market_Product extends Logic_Model {

	public $_id;

	public $_url;


	public function onInit(){

		parent::onInit();;

	}


	public function setUrl($url){

		$this->_url = $url;
		return $this;
	}


	public function getUrl(){
		return $this->_url;
	}


	/**
	 * Enter description here...
	 *
	 * @param array $params
	 * @return Logic_Model_App_Market_Product
	 */
	public function add(array $params = null){
		
		$array = array();
		$array['name'] = $this->getName();
		$array['title'] = $this->getTitle();
		$array['url'] = $this->getUrl();
		
		$market_product_table = new Logic_Datasource_App_Market_Product_Table();
		
		$id = $market_product_table->insertRow($array);
		$this->setId($id);
		return $this;
		
		
	}
	//public $_data;

}


?>