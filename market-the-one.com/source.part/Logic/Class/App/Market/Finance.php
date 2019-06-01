<?php

class Logic_Class_App_Market_Finance extends Logic_Class  {
	
	public $_static_finance;
	
	public function onInit(){


		$class_1=  new Logic_Class_App_Market_Finance_Outcome();
		$class_1->setName('Outcome');
		$class_1=  new Logic_Class_App_Market_Finance_Income();
		$class_1->setName('Income');
		
		
		//$model = new Logic_Model_App_Market_Finance_Outcome();
		// $this->setModel($model);
		//return true;

	}
	
	public function getModel($name=null){
		throw new Exception_Model('method has no realizitation');
	}
	public  function makeIncome(Logic_Class_App_Finance_Document $document){
		
		
	}
	
	public function makeOutcome(Logic_Class_App_Finance_Document $document){
		
	}
	
	
	
	
	
	
}

?>