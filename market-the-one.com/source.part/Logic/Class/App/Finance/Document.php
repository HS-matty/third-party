<?php

class Logic_Class_App_Finance_Document extends Logic_Class{
	
	
	
	
	public $_subject = '';
	
	public $_sum;
	
	public $_currency = 'USD';
	
	public function onInit(){

/*
		$class_1=  new Logic_Class_App_Market_Finance_Outcome();
		$class_1->setName('Outcome');
		$this->addClass('Outcome');
		
		$class_1=  new Logic_Class_App_Market_Finance_Income();
		$class_1->setName('Income');
		$this->addClass('Income');
		return ;*/
		
				
	
	}
	
	public function setCurrency($currency){
		$this->_currency = $currency;
		return $this;
	}
	
	public function getCurrency(){
		return $this->_currency;
	}
	
	
	
	public function setSubject($subject){
		$this->_subject = $subject;
		return $this;
	}
	
	public function getSubject(){
		return $this->_subject;
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param float $sum
	 * @return Logic_Class_App_Finance_Document
	 */
	public function setSum($sum){
		$this->_sum = $sum;
		return $this;
	}
	
	
	public function getSum(){
		return $this->_sum;	
		
	}
	
	
	public function setType($type){
		return ;
		
	}
	public function setOperation($operation){
		
	}
	
	public function setContractorFrom(Logic_Class_App_Finance_Contractor $contractor){
		
			$contractor->setName('From');
			$this->setClass($contractor);
			return $this;
			
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @return Logic_Class_App_Finance_Contractor
	 */
	public function getContractorFrom(){
			return $this->getClass('From');
				
	}
	
	
	public function setContractorTo(Logic_Class_App_Finance_Contractor $contractor){
		
			$contractor->setName('To');
			$this->setClass($contractor);
			return $this;

			
	}
		/**
	 * Enter description here...
	 *
	 * @return Logic_Class_App_Finance_Contractor
	 */
	public function getContractorTo(){
			return $this->getClass('To');
				
	}
	
	
}

?>