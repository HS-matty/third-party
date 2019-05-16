<?php
abstract class Rad_Field_Type{


	protected  $Type;
	protected   $Value;
	protected $Class;
	protected $IsValid = true;
	protected $FieldClassesRef;
	protected $TypeXml;

	/**
	 * Rad field
	 *
	 * @var Rad_Form_Field
	 */
	public  $Parent;
	abstract public function validate();

	protected function init(){


	}
	/**
	 * Get parent object
	 *
	 * @return Rad_Form_Field
	 */
	public function getParent(){
		return $this->Parent;
	}
	function __construct($Parent){
		$this->Parent = $Parent;
		$this->FieldClassesRef = $this->Parent->Parent->FieldClasses;
		$this->Class = $this->Parent->Class;


		//		/forms/form[@id='{$this->FormName}']"

		$this->init();
		$Exp  = "/types/type[@id='{$this->getTypeString()}']";
		if($TypeXml = $this->Parent->Parent->FieldTypes->xpath($Exp)){
			$this->TypeXml = $TypeXml[0];
		}


	}
	protected function defaultValidate(){

		if($this->Parent->isRequired && $this->Value == ''){

			//echo $this->Parent->ID;
			$this->insertFieldGlobalError('empty');
			return false;
		}
		if(!$this->checkClassValidation()) return false;

		return true;
	}
	public function setValue($Value = null){

		if($this->Parent->Type->getTypeString() == 'bool'){
			//echo $Value;
			//exit();
		}
		if($Value !== null) $this->Value = $Value;

		//echo $Value.'-'.$this->getTypeString();
		//bug here
		/*else {

		$Data = $this->Parent->getParent()->getIncomingData();
		$Id = $this->Parent->ID;
		$this->setValue($Data[$Id]);

		}*/


	}
	/**
	 * Sets validation status of the field
	 *
	 * @param bool $Status
	 */
	protected function setValidationStatus($Status){
		/*	if($this->IsValid == 'not_pr') $this->IsValid = (bool) $Status;
		else 	$this->IsValid = $this->IsValid & $Status;*/
		$this->IsValid = (bool) $Status;

		//if(!$this->IsValid && !$this->Parent->Errors) $this->Parent->addErrorMessage('error');


	}
	public function appendXML($field){

		$field['id'] = $this->Parent->ID;
		if(!$this->Parent->isRequired) $field['is_required'] = 0;
		$Type = $this->getTypeString();
		//	$field->addChild('type',$Type);
		//	$field->addChild('value',$this->getValue());
		$field->type  = $Type;
		
		$field->value = $this->getValue();
		if($this->Length){
			$field->length = $this->Length;
		}
		//$Title = $field->addChild('title');
		if($this->Parent->Xml->title){
			foreach ($this->Parent->Xml->title as $Lang=>$val){
				//$Title->addChild($Lang,$val);
				$field->title->$Lang = $val;

			}
		}

		//$Title->addChild('en',$this->Parent->Title) ;
		$field->title->en  = $this->Parent->Title;
		return $field;



	}
	public function isValid(){
		return $this->IsValid;
	}
	public function setType($Type){
		$this->Type = $Type;
	}

	public function getTypeString(){
		return $this->Type;
	}
	public function getValue(){
		return $this->Value;
	}
	public function __toString() {
		return $this->getTypeString();
	}


	/**
	 * Insert datatype error (/data/formparser/types.xml or (if emtpy) common global error.
	 *
	 * @param SimpleXMLElement $Type
	 */
	protected  function insertFieldTypeError(){

		$Type = $this->getTypeString();
		//	$this->Parent->Parent->FieldTypes
		if($Message = (string) $Type->error->en){
			$this->Errors[] = $Message;
		}else {
			$this->insertFieldGlobalError('common_error');
		}

	}
	/**
	 * Validation $this->Class (<field class="someclass">) against /data/formparser/field_classes.xml
	 * 
	 * @return bool 
	 */
	protected  function checkClassValidation(){

		global $InOut;
		if(!$this->Class) return true;// no class, always ok


		if($this->FieldClassesRef){

			$ClassXml = $this->FieldClassesRef->xpath("//class[@id='{$this->Class}']");
			if(!$ClassXml) throw  new Exception('Coudn\'t find field class '.$this->Class);
			//echo $ClassXml[0] = $ClassXml;
			//print_r($ClassXml);
			$RegExp = (string) @$ClassXml[0]->regexp['value'];

			if(!$RegExp) return true; // no check, always true
			if(!preg_match($RegExp,$this->Value)){


				//	$Error = (string) @$this->Parent->Parent->FieldClasses->xpath("//message->en");
				if(!$Error) $Error = 'Field validation error';
				$this->Parent->addErrorMessage($Error);
				return false;
			}else return true;



		}else  return false;


	}
	/**
	 * Adds selected global error to the field
	 *
	 * @param string $ErrorType 
	 * @param string $Add2Msg  text which adds to the end of the error mesage
	 */
	public  function insertFieldGlobalError($ErrorType,$Add2Msg=null){


		$GlobalFieldErrors = $this->Parent->Parent->FormErrors;

		if(!$GlobalFieldErrors) $Message = 'Form proceed error';
		else {
			$XmlObj = $GlobalFieldErrors;

			global $InOut;
			$Lang = $InOut->Lang;


			if(!empty($XmlObj->$ErrorType->$Lang)) $Msg = $XmlObj->$ErrorType->$Lang;
			elseif (!empty($XmlObj->$ErrorType->en)) $Msg = $XmlObj->$ErrorType->en;
			elseif (!empty($XmlObj->$ErrorType->common_error->en)) $Msg->$ErrorType->en;
			else $Msg = 'field error';


			//		if(!empty($XmlObj->title->$Lang)) $FieldTitle = $Field->title->$Lang;
			//		elseif (!empty($XmlObj->title->en)) $FieldTitle = $Field->title->en;
			//		else $FieldTitle ='Field';

			if($Add2Msg) $Msg = $Msg.', '.$Add2Msg;
			$Msg = (string) $Msg;
			$this->Parent->addErrorMessage($Msg);




		}
	}






}




class Rad_Field_Type_Int extends Rad_Field_Type {



	protected function init(){
		$this->Type = 'int';
	}

	public function validate(){


		if(!$this->defaultValidate()) return false;

		if($this->Value && !is_numeric(($this->Value))) {
			$this->insertFieldTypeError($this->getTypeString());;
			return false;
		}





		if(@$LengthArray){
			$Min = (string) $LengthArray[1];
			$Max = (string) $LengthArray[2];
			$AddMsg = '';
			if(($this->Value < $Min && $Min != 'a' && $Min != 'i')
			|| ($this->Value  > $Max && $Max != 'a' && $Max != 'i')){
				if(is_numeric($Min)) $AddMsg = "min: $Min";
				if(is_numeric($Max)) {
					if($AddMsg) $AddMsg .= ', ';
					$AddMsg .= " max: $Max";
				}
				$this->insertFieldGlobalError('range',$AddMsg);

			}


		}






		return true;
	}
	public function setValue($Value){
		$this->Value = $Value;




	}


}


class Rad_Field_Type_Float extends Rad_Field_Type_Int  {



	protected function init(){
		$this->Type = 'float';
	}




}

class Rad_Field_Type_String extends Rad_Field_Type {


	protected function init(){
		$this->Type = 'string';
	}

	public function setValue($Value){
		$this->Value = $Value;


		if($this->Parent->View->Type == 'editor'){

			$this->Parent->View->ViewObject->Value = $this->Value;
		}
	}
	public function validate(){
		//$this->setValue();

		$isValidated  =  true;
		if(!is_string($this->Value)) $isValidated = false;

		$this->defaultValidate();

		//print_r($this->Parent->Xml);
		if($Length = (string) $this->Parent->Xml->length ){


	
			preg_match("/^([0-9a]{1,10})-([0-9ai]{1,10})$/",$Length,$LengthArray);
		}

		if(@$LengthArray && $this->Value !== '' && $this->Value !== null){

			$AddMsg = '';
			$Min = (string) $LengthArray[1];
			$Max = (string) $LengthArray[2];
			if(((strlen($this->Value) < $Min) && $Min != 'a' && $Min != 'i')
			|| ((strlen($this->Value)  > $Max) && $Max != 'a' && $Max != 'i')){
				if(is_numeric($Min)) $AddMsg = "min: $Min";
				if(is_numeric($Max)) {
					if($AddMsg) $AddMsg .= ', ';
					$AddMsg .= " max: $Max";
				}


				$this->insertFieldGlobalError('length',$AddMsg);

			}
		}


		$this->setValidationStatus($isValidated);
		return true;

	}


}

class Rad_Field_Type_Enum extends Rad_Field_Type {

	protected function init(){
		$this->Type = 'enum';
	}


	public function getValue(){


		return $this->Value;
	}

	public  $ListValues = array();


	public function setListValues($ListValuesArray){

		$this->ListValues = $ListValuesArray;
	}


	public function setValue($Value = null){

		/*if($Value)
		foreach ($this->ListValues as $val){
		if($val == $Value) {
		$this->Value = $Value;
		break;
		}

		}*/
		//echo $this->Parent->ID.'proceed<br>';
		$this->Value = $Value;





		//bug here
		/*else {

		$Data = $this->Parent->getParent()->getIncomingData();
		$Id = $this->Parent->ID;
		$this->setValue($Data[$Id]);

		}*/


	}

	public function validate(){
		//$this->setValue();

		if(!$this->defaultValidate()) return false;
		if(is_string($this->Value)) return true;

		return false;

	}

	public function appendXML($field){

		/*		$field['id'] = $this->Parent->ID;
		$Type = $this->getTypeString();
		$field->addChild('type',$Type);
		$field->addChild('value',$this->getValue());
		$Title = $field->addChild('title');
		$Title->addChild('en',strtolower($this->Parent->Title)) ;*/

		parent::appendXML($field);
		$Enum = $field->addChild('enum')->addChild('values');
		foreach ($this->ListValues as $val){

			$Enum->addChild('value',$val);

		}
		/*
		print_r($field);
		die('dd');*/



	}


}

class Rad_Field_Type_List extends Rad_Field_Type {

	protected function init(){
		$this->Type = 'list';
	}

	public $ListValueTitle;
	public $ListKeyTitle;

	public function getValue(){


		return $this->Value;
	}

	protected $ListValues = array();


	public function setListValues($ListValuesArray,$ListKeyTitle =null,$ListValueTitle = null){

		$this->ListValues = $ListValuesArray;
		$this->ListValueTitle = $ListValueTitle;
		$this->ListKeyTitle = $ListKeyTitle;
	}


	public function setValue($Value = null){

		/*if($Value)
		foreach ($this->ListValues as $val){
		if($val == $Value) {
		$this->Value = $Value;
		break;
		}

		}*/
		//echo $this->Parent->ID.'proceed<br>';
		$this->Value = $Value;





		//bug here
		/*else {

		$Data = $this->Parent->getParent()->getIncomingData();
		$Id = $this->Parent->ID;
		$this->setValue($Data[$Id]);

		}*/


	}

	public function validate(){
		//$this->setValue();


		if(!$this->defaultValidate()) return false;
		if(is_string($this->Value)) return true;
		return false;


	}

	public function appendXML($field){

		/*		$field['id'] = $this->Parent->ID;
		$Type = $this->getTypeString();
		$field->addChild('type',$Type);
		$field->addChild('value',$this->getValue());
		$Title = $field->addChild('title');
		$Title->addChild('en',strtolower($this->Parent->Title)) ;*/

		parent::appendXML($field);
		$field->addChild('list');
		$field->list['not_null']= 1;
		$field->list->key_title = $this->ListKeyTitle;
		$field->list->value_title = $this->ListValueTitle;
		/*
		print_r($field);
		die('dd');*/



	}


}
class Rad_Field_Type_File extends Rad_Field_Type {

	/**
	 * File object
	 *
	 * @var Rad_File
	 */
	public  $File;
	protected function init(){
		$this->Type = 'file';
		$this->addFile();



	}

	/**
	 * Attach file to the Field
	 *
	 * @return Rad_File
	 */
	public function addFile(){

		return $this->File = new Rad_File();

	}










	public function setValue($Value = NULL){



		$this->File->init($Value);





	}

	public function validate(){
		//$this->setValue();

		//if(!$this->defaultValidate()) $this->setValidationStatus(false);
		/*	if(is_string($this->Value)) $this->setValidationStatus(true);
		else $this->setValidationStatus(false);*/
		$this->setValidationStatus(true);
		return true;


	}

	public function appendXML($field){

		/*		$field['id'] = $this->Parent->ID;
		$Type = $this->getTypeString();
		$field->addChild('type',$Type);
		$field->addChild('value',$this->getValue());
		$Title = $field->addChild('title');
		$Title->addChild('en',strtolower($this->Parent->Title)) ;*/

		$this->setValue('test_value');
		parent::appendXML($field);
		$field['not_required'] = 1;
		$field->type = 'file';
		$File = $field->addChild('file');
		$FileType = $File->addChild('filetype',$this->File->FileType);

		$MaxSize = $File->addChild('size','0-8192');
		$Path = $File->addChild('path',$this->File->Path);



		/*
		print_r($field);
		die('dd');*/



	}
	public function isValid(){
		return $this->IsValid;
	}

	public function getValue(){
		return $this->File->Filename;
	}


}


class Rad_Field_Type_Image extends Rad_Field_Type_File {



}

class Rad_Field_Type_Bool extends Rad_Field_Type {


	public function validate(){
		return true;
	}
	public function getValue(){

		return parent::getValue();
	}
}




?>