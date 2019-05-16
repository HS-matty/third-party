<?php

class Rad_Form_Params extends Rad_UI_Params {


	public $PredefinedFieldValues = array();
	public $RemovedFields = array();
	
	public $hasAdditionalFields = false;

	public $ProceedData = true;
	/**
	 * Objects which has methods for insert,update form data
	 *
	 * @var iRad_Form
	 */
	public $Object;
	public $Action;
	public $CustomFormObject;
	/**
	 * Form source object 
	 *
	 * @var Rad_Form_Xml_Source
	 */
	public $Source;
	/**
	 * Set Form Source object
	 *
	 * @param Rad_Form_Xml_Source $Source
	 */
	public function setSource(Rad_Form_Xml_Source $Source){
		$this->Source = $Source;

	}
	public function setObject(iRad_Form $Object){
		//if(!$Object instanceof iRad_Form ) throw new Exception('Wrong object');
		$this->Object = $Object;
	}
	public function setFormCustomObject(Rad_Form $Form){
		$this->CustomFormObject = $Form;
	}
	public function getFormCustomObject(){
		return $this->CustomFormObject;
	}
	public function setPredefinedFieldValue($FieldId,$Value){
		$this->PredefinedFieldValues[$FieldId] = $Value;
	}
	public function setRemovedFields(){

	}


}

class Rad_UI_Source  {


}
class Rad_Form_Xml_Source extends Rad_UI_Source {

	
	protected $Dir = '/forms';

	protected $XmlString;
	public $FormSourceObject;

	public $Class;
	public $FormName;
	public $AdditionalXml;
	public function setDir($Dir = '/forms'){
		$this->Dir = $Dir;
	}
	public function setXml($XmlSting){
		$this->XmlString = $XmlSting;
	}


	/**
	 * Returns FormObject
	 *
	 * @return SimpleXMLElement
	 */
	public function getFormSourceObject(){
		return $this->FormSourceObject;
	}
	public function init($FormName  = null){
		if($this->XmlString) {
			$this->FormSourceObject = simplexml_load_string($this->XmlString);
			return true;
		}
		else{
			global $Config;
			if($FormName) $this->FormName = $FormName;
			$File = $Config->SitePath.'/application'.$this->Dir.'/'.strtolower($this->FormName).'.xml';
			if($this->FormSourceObject = @simplexml_load_file($File)) return true;
			
		}
		return false;



	}



}



class Rad_Form_Result extends Rad_Ui_Result  {

	public $isSuccess;
	/**
	 * Form object
	 *
	 * @var Form2
	 */
	public $_uiObject;
	public function set_uiObject($obj){
		$this->_uiObject = $obj;
	}
}
?>