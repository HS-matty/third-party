<?php

class Logic_Class_App_Finance_Operation extends Logic_Class{
	
	
	public function onInit(){
	
	}
	
	
	
	public $_document;
	
	public $_dependecy = array();
	
	
	public function setDependency(array $dependency){
		return $this->addDependency($dependency);
	}
	
	public function addDependency(array $dependency){
		$this->_dependecy[] = $dependency;
		return $this;
	}
	public function getAllDependency(){
		return $this->_dependecy;
	}
	
	
	
	
	/**
	 * Enter description here...
	 *
	 * @param Logic_Class_App_Finance_Document $document
	 * @return Logic_Class_App_Finance_Operation
	 */
	public function setDocument(Logic_Class_App_Finance_Document $document){
				
		$this->_document = $document;
		return $this;
	}
	
	/**
	 * Enter description here...
	 *
	 * @return Logic_Class_App_Finance_Document
	 */
	public function getDocument(){
		return $this->_document;
	}
	
	
	public function proceed(){
		
		
		
		if(!$document = $this->getDocument()) throw new Exception_App_Finance('document not loaded');
		
		/*@var document Logic_Class_App_Finance_Document*/
		
		$from = $document->getContractorFrom();
		$to = $document->getContractorTo();
		
		$subject = $document->getSubject();
		$sum = $document->getSum();
		$currency  = $document->getCurrency();
		
		$array = array();
		
		$array['subject'] = $subject;
		$array['sum'] = $sum;
		$array['currency'] = $currency;
		
		$array['acl_user_id_from'] = $from->getUser()->getId();
		$array['acl_user_id_to'] = $to->getUser()->getId();
		
		$array['datetime'] = 'NOW()';
		
		$model = $this->getModel('Income');
		foreach ($this->getAllDependency() as $dependency){
			
		//	if($model->getDatasource()->ge;
			$keys= array_keys($dependency);
			$values = array_values($dependency);
			$array[$keys[0]]  = $values[0];
		}
		
		
		$model->add($array);
		
		if(!$model->getId()) throw new Exception_App_Finance('Couldnt add proceed-income-operation');
		return $this;
		
		
				
	}
	
	
	
	

}

?>