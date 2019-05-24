<?php


class Ui_Handler extends Std_Class {
	
	
	
	protected $_link;
	
	public function setLink($params,$additional_params= null){

		$link = new Link();
		$link->setLinkParams($params)->setRequestParams($additional_params);
		$this->_link =  $link;
		
	}
	
	
	
	public function __toString(){
		return (string) $this->_link;
		
	}
	
	
}

?>