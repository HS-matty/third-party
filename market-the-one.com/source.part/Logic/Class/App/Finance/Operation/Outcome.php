<?php 
class Logic_Class_App_Finance_Operation_Outcome extends  Logic_Class_App_Finance_Operation{

	public function onInit(){

		 $model = new Logic_Model_App_Market_Finance_Outcome();
		 $this->setModel($model);
		return true;

	}

}
?>