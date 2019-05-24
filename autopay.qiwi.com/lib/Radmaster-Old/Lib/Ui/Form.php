<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/


//new form proccessor (ver 3)
//use it instead of formext
//require_once('formfieldslist.php');


class Ui_Form extends Ui_Element {


	const Type_Action_VIEW = 'view';
	const Type_Action_EDIT = 'edit';
	
	protected $_error_flag;
	protected $_action_type;
	
	
	public function onInit(){
		$this->_type = 'form';
	}
	
	public function setErrorFlag($flag){
		$this->_error_flag = $flag;
		
	}
	public function getErrorFlag(){
		return $this->_error_flag;
	}
	
	public function setActionType($type){
		$this->_action_type = $type;
	}
	
	public function getActionType(){
		return $this->_action_type;
	}
	public function setData($data){
		
		
		foreach ($data as $key=>$value){
			
			if($field = $this->getField($key)) $field->setValue($value);
			
		}
		
	}
	public function getData(){
		
		$arr = array();
		foreach ($this->getFields() as $field){
			$arr[$field->getName()] = $field->getValue();
			
		}
		return $arr;
		
	}



}

?>