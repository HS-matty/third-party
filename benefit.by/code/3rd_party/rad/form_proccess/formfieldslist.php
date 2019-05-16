<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007 
You can freely use this file
if you have any questions please visit radmaster.net

*/

require_once('formfield.php');

class FormFieldList {
	/**
	 * array of of FormField object
	 *
	 * @var array 
	 */
	public  $FieldList = array();
	/**
	 *  Fields XML data (/data/formparser/forms/*)
	 *
	 * @var SimpleXMLElement
	 */
	private $ObjectSchema = null;
	private $FormData;
	private  $Action;
	
	/**
	 * Remove field titles
	 *
	 * @var array
	 */
	private $RemovedFields = array();
	private $ValidateFlag = false;
	public $ValidateSuccessFlag = true;
	/**
	 * Reference to the parent form
	 *
	 * @var Form2
	 */
	public $ParentForm;



	function __construct($ParentForm){
		$this->ParentForm = $ParentForm;

	}


	public function setRemoveFieldsArray($arr){
		$this->RemovedFields  = $arr;

	}
	/**
	 * Check if field is in the remove list
	 *
	 * @param int $FieldId
	 * @return bool
	 */
	private function isFieldRemoved($FieldId){
		if(isset($this->RemovedFields[$FieldId])) return true;
		return false;
	}


	public function initList($XmlSchema,$Action,$FormData = null,$ValidateFlag = false,$AdditionalXmlFields = null){

		$this->ObjectSchema = $XmlSchema;
		//print_r($XmlFile);
		$this->FormData = $FormData;
		
		$this->Action = $Action;
		$this->ValidateFlag = $ValidateFlag;
		$this->createTotalFieldList();
		if($AdditionalXmlFields) {
			
			$this->createTotalFieldList($AdditionalXmlFields);
		}




	}


	/**
	 * Return fields list array
	 *
	 * @return array
	 */
	public function &getFieldList(){
		return $this->FieldList;
	}

	public function getErrorsList(){
		$Errors = array();
		foreach ($this->FieldList as $f){
			if($f->Errors){
				$Errors[$f->ID] = $f->Errors;
			}
			
		}
		return $Errors;
	}
	public function getFieldsSimpleList(){
		$Fields = array();
		foreach ($this->FieldList as $f){
			$Fields[] = "$f->ID = $f->Value";
			
		}
		return $Fields;
	}
	/**
	 * Get Fields values as array(id=>value)
	 *
	 * @return array
	 */
	public function &getFormDataArray(){
		

		
		$arr = array();
		foreach ($this->FieldList as $f){

			/*@var $f FormField*/
			if($f->Type =='captcha' || $f->IncludeInListFlag == false || $f->SkipFlag) continue;
			
			$arr[$f->ID] = $f->getValue(false);

		}
		return $arr;

	}
	/**
	 * Set values to fields. Array($FieldId=>Value) 
	 *
	 * @param array $Data
	 */
	public function setFormValues($Data){
	

		foreach ($this->FieldList as $f){
			

			/*@var $f FormField*/
			if(@$Data[$f->ID])  $f->setValue($Data[$f->ID]);
			$f->proceedViewValues($Data);
			//if($f->)

		}
		
		
		
		
	}

	/**
	 * Validate loaded fields
	 *
	 * @return bool
	 */
	public function validateFields(){
	
		$Error = false;

		foreach ($this->FieldList as $FldObj){
			/*@var $FldObj FormField*/

			$FldObj->validateField();
			if($FldObj->Errors) {
			//	print_r($FldObj->Errors);
				$this->ParentForm->ErrorFlag = true;
				$Error = true;
				//die('errors');
				//print_r($FldObj);
			}
		}
		return $Error;

	}

	public function addFormFields($XmlSchema,$AtBegin = false){
		$this->createTotalFieldList($XmlSchema,$AtBegin);
		
	}
	
	/**
	 * Parses ObjectSchema and creates field objects
	 *
	 */
	private function createTotalFieldList($XmlFields = null,$AtBegin = false){
		//print_r($this->ObjectSchema);
		//	print_r($this->TableFields);

		//	print_r($this->ObjectSchema);


		if($XmlFields) {
			$ObjectSchema = $XmlFields;
			
			
		}
		else $ObjectSchema = $this->ObjectSchema;

		foreach ($ObjectSchema->fields->field as $Field){
		//foreach ($ObjectSchema->xpath('//field')->field as $Field){



			$Id = (string)$Field->id;
			if(!$Id) $Id= (string) $Field['id'];

			$ViewValueId = null;
			$ProceedViewValuesFlag = false;

			$ViewValue = null;
			if($Field->view_value_id) {
				//	print_r($this->FormData);
			
				$ViewValueId = (string) $Field->view_value_id;
			$ViewValue = @$this->FormData[$ViewValueId];
//				print_r($this->FormData);
		//		exit();
				
			}elseif ($Field->view_values){
				
				$arr = array();
			
				foreach ($Field->view_values->value_id as $id){
			
							
					$Val = @$this->FormData[(string) $id];

					if($Val) $ViewValue[] = $Val;
					

				}
						$ProceedViewValuesFlag = true;
				

			}

			$PostedValue = (string) @$this->FormData[$Id.'_puser_value'];

			if($this->isFieldRemoved($Id)) continue;


			if(isset($this->FormData[$Id])) $FormValue = $this->FormData[$Id];
			else $FormValue = null;

			//echo $Field->id;
		//	echo ' , '.$ViewValue.'<br>';
			$FldObj = new FormField($Field,$this->Action,$FormValue,$ViewValue,$PostedValue);
			$FldObj->ProceedViewValues = $ProceedViewValuesFlag;

			if(!$FldObj->AppendInInsertAction) continue;


			$FldObj->GlobalFieldErrorsRef = $this->ParentForm->FormErrors;
			$FldObj->FieldClassesRef = $this->ParentForm->FieldClasses;
			$FldObj->FieldTypesRef = $this->ParentForm->FieldTypes;
			
			if($FldObj->Type == 'captcha' && $this->Action != Form2::InsertAction) $FldObj->IncludeInListFlag = false;
			
			if($FldObj->isIncluded()) {
				
				 
				if(!$AtBegin) array_push($this->FieldList,$FldObj);
				else array_unshift($this->FieldList,$FldObj);
			}else {
				
			}
			

		}

//die('ssss');

		//			print_r($this->FieldList);





	}
/*	public function &getTableList(){
		return $this->Tables;
	}*/

	/**
	 * Add list data array to the field
	 *
	 * @param string $FieldId
	 * @param array $Data
	 */
	public function addListDataToField($FieldId,$Data){
		//print_r($Data);
		//die();

		foreach ($this->FieldList as $f){
		
		
			//	echo $f->Title;
			
			if($f->ID == $FieldId){
				//print_r($Data);
				//echo $FieldId;
				/*@var $f FormField*/
	
				
				//die('d');
				$f->addListArray($Data);
			}
		}

	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $FieldId
	 * @return FormField
	 */
	public function addField(){
		return $this->FieldList[] = new FormField(null,null);
	}
	public function removeField($FieldId){
		
		

		foreach ($this->FieldList as $key => $f){
			//	echo $f->Title;
			if($f->ID == $FieldId){
				//die('d');
				unset($this->FieldList[$key]);
				break;
			}
		}

	}
		/**
		 * Enter description here...
		 *
		 * @param string $FieldId
		 * @return FormField
		 */
		public function getField($FieldId){
		
		

		foreach ($this->FieldList as $key => $f){
			//	echo $f->Title;
			if($f->ID == $FieldId){
				//die('d');
				return $f;
				
			}
		}
		
		

	}




}







?>