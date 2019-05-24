<?php


class Ui_Field extends Ui_Element{
	

	const TYPE_TEXT = 'text';
	const Type_FILE = 'file';
	const Type_CAPTCHA = 'captcha';
	const Type_IMAGE = 'image';
	
	
	protected $_is_required = 1;
	//protected $
	
	
	
	public function onInit(){
		
		$this->_value = new Value();
				
		
	}
	
	/**
	 * ...
	 *
	 * @return Value
	 */
	public function getValue($param = null){
		return parent::getValue($param);
	}
	
	/**
	 * ...
	 *
	 * @param mixed $value
	 * @return Ui_Field
	 */
	public function setValue($value){
		if(!$this->_value) $this->_value = new Value();
		$this->_value->setValue($value);
		return $this;
	}
	
	
}


?>