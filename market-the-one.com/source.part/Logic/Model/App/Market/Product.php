<?php

class Logic_Model_App_Market_Product extends Logic_Model {

	public $_logo_url;






	public function onInit(){

		parent::onInit();;

	}




	/**
	 * Enter description here...
	 *
	 * @param string $url
	 * @return Logic_Model
	 */
	public function setLogoUrl($url){

		$this->setParam('logo_url',$url);
		return $this;
	}


	/**
	 * Enter description here...
	 *
	 * @return string || null
	 */
	public function getLogoUrl(){
		return $this->getParam('logo_url');
	}





	/**
	 * Enter description here...
	 *
	 * @param array $params
	 * @return Logic_Model_App_Market_Product
	 */
	public function add(array $params = null){

		$array = $this->getParams();
		//$array['name'] = $this->getName();
		//$array['title'] = $this->getTitle();
		//$array['description'] = $this->getDescription();
		//$array['url'] = $this->getUrl();

		$market_product_table = new Logic_Datasource_App_Market_Product_Table();

		$id = $market_product_table->insertRow($array);
		$this->setId($id);
		return $this;


	}

	//public $_data;

}


?>