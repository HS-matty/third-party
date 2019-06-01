<?php

class Logic_Class_App_Market_Offer extends Logic_Class  {


	
	
	
	

	/**
	 * Enter description here...
	 *
	 * @var Logic_Model_App_Market_Offer
	 */
	public $_model;





	public function onInit(){

		$this->init();
		return true;

	}




	public function init(array $params = null){

		if(!$model = $params['model']){
			$model = new Logic_Model_App_Market_Offer();

		}
		$this->setModel($model);

		return $this;

	}
	
	
	
	


}


?>