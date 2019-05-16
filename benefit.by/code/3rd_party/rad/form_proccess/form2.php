<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/


//new form proccessor (ver 3)
//use it instead of formext
require_once('formfieldslist.php');
require_once('rad_form_params.php');

class Form2{

	const InsertAction = 'insert';
	const UpdateAction = 'update';
	const SelectAction = 'select';
	const ViewAction = 'view';
	const DevelopAction = 'develop';

	//private $FormFieldList;//FormFieldList list
	/**
	 *  Form field list object
	 *
	 * @var FormFieldList
	 */
	public $FormFieldListObj;//FormFieldList obj

	public $isSingleForm = false;
	public $TextDirection = 'ltr'; //text aligment for languages like hebrew
	public $isActive = 1;
	
	public  $FormName;
	public $FormClass;
	private $XmlDirPath = '/data/formparser/';
	private $XmlFile;
	private $XmlFieldClassesFile = 'field_classes.xml';
	private $XmlErrorFile = 'errors.xml';
	private $XmlTypesFile = 'types.xml';
	public   $FieldClasses;
	public   $FieldTypes;
	public   $FormErrors;

	private $AdditionalXmlFields;



	private $XmlObj;
	private $ErrorMessage = array();
	public  $Lang = 'en';

	public $Action;
	public  $ProceededFields;

	private $GroupFieldNum = array();
	public $FormTitle;
	private $IncludeFieldInArrayFlag = true;

	public $FormWidth = '800';

	private $RemovedFields = array();
	public $ErrorFlag = false;
	private $AddListDataToFieldList = array();



	function __construct($FormName,$FormClass){

		$this->FormName  = $FormName;
		$this->FormClass = $FormClass;
		global $Config;
		$this->XmlDirPath = $Config->SitePath.$this->XmlDirPath;



	}

	public function isError(){
		return $this->ErrorFlag;
	}

	public function removeField($FieldId){

		$this->RemovedFields[$FieldId] = 1;

	}

	public function removeFieldAfter($FieldId){

		$this->FormFieldListObj->removeField($FieldId);

	}
	public function getPartOfArrayRelatedTpXmlSchema(&$Data,$Xml){
		

		$Array = array();
		//print_r($Data);
		foreach ($Xml->xpath('//field') as $f){
			
			if(!$id = (string) $f->id) $id = (string) @$f['id'];
			
			if(array_key_exists($id,$Data)){
				
				$Array[$id] = $Data[$id];
				unset($Data[$id]);
				
			}
			
		}
		
		return $Array;
		
	}
	
	private function isFieldRemoved($FieldId){
		if(@$this->RemovedFields[$FieldId] == 1) return true;
		return false;
	}
	public function addListDataToFieldExt($FieldId,&$Data){

		$this->AddListDataToFieldList[$FieldId] = $Data;
	}


	public function addListDataToField($FieldId,&$Data){
		if(!$this->FormFieldListObj){
			throw new Exception('FieldsList object not found');
		}
		$this->FormFieldListObj->addListDataToField($FieldId,$Data);

	}

	/**
	 * Enter description here...
	 *
	 * @param string $FieldId
	 * @return FormField
	 */
	public function addField(){
		
		return $this->FormFieldListObj->addField();
		
		
	}
	/**
	 * Function validate all loaded fields
	 *
	 * @return bool
	 */
	public function validateForm(){

		//set posted values	to fields

		$this->FormFieldListObj->setFormValues($_POST);

		//validate

		$this->FormFieldListObj->validateFields();

		if($this->ErrorFlag) return false;
		return true;

	}
	public function assignDataToForm($DataArray,$SecondDataArray = null){

	
		
		if($SecondDataArray){
			$DataArray = @array_merge($DataArray,$SecondDataArray);
		}

		$this->FormFieldListObj->setFormValues($DataArray);

	}


	/**
	 * If $DataArray has additional_xmlfields field, parse it
	 * and include data from xml to the $DataArray and return 
	 * @param SimpleXml $DataArray 
	 * @return array $AdditionalArray 
	 */
	public function &parseAdditionalXmlFields($Xml){
		$Null = null;
		$AdditionalData = array();
		if(is_array($Xml)){
			$Xml = $DataArray['additional_xmlfields'];
		}
		
		if(@$Xml){
	
		
			$XmlData = simplexml_load_string(@$Xml);

			foreach ($XmlData->fields->field as $f){



				$AdditionalData[(string)$f['id']] = (string) $f->value;


			}
			unset($DataArray['additional_xmlfields']);
			$this->AdditionalXmlFields = $XmlData;
			

			return $AdditionalData;
		}
		return $Null;
	}
	public function addPostFieldsToAdditionalXmlForm(&$FormArray){

/*		iconv_set_encoding("input_encoding", "UTF-8");
		iconv_set_encoding("internal_encoding", "UTF-8");
		iconv_set_encoding("output_encoding", "UTF-8");*/

	//	var_dump(iconv_get_encoding('all'));

		$TotalValue='';
		if($this->AdditionalXmlFields){


			foreach ($this->AdditionalXmlFields->fields->field as $f){

				if(isset($FormArray[(string) $f['id']])){

					//$f->value = "<![CDATA[".$FormArray[(string)$f['id']]."]]>";//
					$f->value='';
					$TotalValue = $FormArray[(string)$f['id']];
					
					unset($FormArray[(string)$f['id']]);


				}





			}




		}

		
		//echo $new=mb_convert_encoding( ,"UTF-8","auto");
		

		
		if($this->AdditionalXmlFields) $FormArray['additional_xmlfields'] = ($this->AdditionalXmlFields->asXML());

		$FormArray['additional_xmlfields'] = str_replace('<value></value>',"<value>$TotalValue</value>",$FormArray['additional_xmlfields']);
		
		



	}

	/**
	 * Main form processor function
	 *
	 * @param string $FormAction exmp: form2::InsertAction
	 */
	public function proceedFields($FormAction,$AdditionXmlFields = null,$FormData = null){


		

		if(!$this->XmlObj)	$this->LoadDataFile();
		$this->loadTypesFile();
		$this->LoadErrorsFile();
		$this->LoadClassesFile();
		
		$FormFieldList = new FormFieldList($this);

	

		//if(!$FormData) $FormData = &$_POST;
		$FormObj = array();
		if($this->isSingleForm) $FormObj[0] = $this->XmlObj;
		else  $FormObj  = $this->XmlObj->xpath("/forms/form[@id='{$this->FormName}']");
		if(empty($FormObj)) throw new Exception('No such form exists, '.$this->FormName);
		$this->Action = $FormAction;
		if($this->RemovedFields) $FormFieldList->setRemoveFieldsArray($this->RemovedFields);
		global $InOut;




		

		//global field list init
		$FormFieldList->initList($FormObj[0],$FormAction,$FormData,false,$this->AdditionalXmlFields);


		if($this->AddListDataToFieldList){
			foreach ($this->AddListDataToFieldList as $key => &$value) {
				$FormFieldList->addListDataToField($key,$value);

			}
		}
		$this->FormFieldList =& $FormFieldList->getFieldList();
		$this->FormFieldListObj = $FormFieldList;
		$this->FormTitle = (string) @$FormObj[0]->title->en;

		if($FormObj[0]['width']) $this->FormWidth = (string) $FormObj[0]['width'];
		if($FormObj[0]['direction']) $this->TextDirection = (string) $FormObj[0]['direction'];



	}

	public function LoadDataFile($Path = null){
		if(!$Path) $Path = $this->XmlDirPath.'forms/'.$this->FormClass.'.xml';

		$xml = simplexml_load_file($Path) OR die('error loading xml file '.$this->FormClass.'.xml');
		$this->XmlObj = $xml;


	}
	private function loadTypesFile(){
		$Xml = simplexml_load_file($this->XmlDirPath.$this->XmlTypesFile);
		if(!$Xml) throw new Exception('Error in loading '.$this->XmlDirPath.$this->XmlTypesFile);
		$this->FieldTypes  = $Xml;





	}

	private function LoadErrorsFile(){


		$Xml = simplexml_load_file($this->XmlDirPath.$this->XmlErrorFile);
		if(!$Xml) throw new Exception('Error in loading '.$this->XmlDirPath.$this->XmlErrorFile);
		$this->FormErrors = $Xml;
		//	print_r($Xml);


	}
	private function LoadClassesFile(){


		$Xml = simplexml_load_file($this->XmlDirPath.$this->XmlFieldClassesFile);
		if(!$Xml) throw new Exception('Error in loading '.$this->XmlDirPath.$this->XmlFieldClassesFile);
		$this->FieldClasses = $Xml;
		//	print_r($Xml);


	}
	

	// for calls from smarty templates to generate HTML form
	public function getXMLFormContent(){

		return $this->FormFieldList;

	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $FieldId
	 * @return FormField
	 */
	public function getField($FieldId){
		
		if($Field = $this->FormFieldListObj->getField($FieldId)) return $Field;
		else return new FormField(null,null);
	}

	public function &getFormArrayExt($EscapeFlag = false){

		if(!$this->ErrorFlag) {
			
			$Data =& $this->FormFieldListObj->getFormDataArray();

			return $Data;
		}
		return null;

	}
	public function isFormPost(){

		global $InOut;
		return $InOut->isFormPost();

	}

	public function convertArrayToFormXmlString($Data,$ExistingXml = null){

		global $Page;
		$new = 0;
		if($ExistingXml){
			$Form = simplexml_load_string($ExistingXml);

		}else {

			$d = '<form><fields></fields></form>';
			$Form = new SimpleXMLElement($d);
			
			

		}


		$Type = strtolower($Data['type']);
		switch ($Type){
			case 'text':
				$Type = 'string';
				break;
			case 'boolean':
				$Type = 'bool';
				break;

			default:
				$Type = 'string';
				break;
		}
		
		
		$Id  = $Data['field_id'];


		$field = $Form->fields->addChild('field');


		//$field->addChild('id',$Id);
		$field['id'] = $Id;

		$field->addChild('type',$Type);
		$field->addChild('value',NULL);
		$Title = $field->addChild('title');
		$Title->addChild('en',strtolower($Data['title_en'])) ;






		return $Form->asXml();


	}



}
interface iRad_Form{
	public function getFormData();
	public function updateFormObject($Data);
	public function insertFormObject($Data);
	public function parseAdditionalFields(&$Data,$FieldsXml);
}
?>