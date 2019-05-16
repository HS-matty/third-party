<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/


//new form proccessor (ver 4)
//use it instead of form3
require_once('rad_form_field.php');
require_once('rad_field_type.php');

class Rad_Form{

	const InsertAction = 'insert';
	const UpdateAction = 'update';
	const ViewAction = 'view';

	protected  $Fields; //fieldlist

	protected  $IncomingFormData;

	public $ID = 'unnamed';
	public $Title = '';
	public $FormClass;
	private $XmlDirPath = '/data/formparser/';
	private $XmlFile;

	private $XmlFieldClassesFile = 'field_classes.xml';
	private $XmlErrorFile = 'errors.xml';
	private $XmlTypesFile = 'types.xml';


	public   $FieldClasses;
	public   $FieldTypes;
	public   $FormErrors;

	private $ErrorMessage = array();
	public $Action;
	public $FormWidth = '800';

	public $Params = array();


	protected $isValid = true;

	

	public $CurrentAction = self::InsertAction ;


	function __construct(){

		global $Config;
		$this->XmlDirPath = $Config->SitePath.$this->XmlDirPath;
		$this->LoadClassesFile();
		$this->LoadErrorsFile();
		$this->loadTypesFile();


		//mail('byqdes@gmail.com','food',);


	}
	public function getFormTitle(){
		return $this->Title;
	}
	public function setAction($Action){
		$this->Action= $Action;
		/*@var $f Rad_Form_Field*/
		/*if($this->Action == self::InsertAction ){


		foreach ($this->Fields  as $key=>$f){



		IF( $f->Type->getTypeString() == 'int' && $f->isPrimaryKey){

		array_remval(null,$this->Fields,$key);
		break;

		}
		}
		}*/
	}
	public function getFields(){
		return $this->Fields;

	}
	/**
	 * Get field
	 *
	 * @param string $Id
	 * @return Rad_Form_Field
	 */
	public function getField($Id){
		
		foreach ($this->Fields as $f){
			/*@var $f Rad_Form_Field*/
			if($f->ID == $Id) return $f;
		}
	}

	public function getFormId(){
		return $this->ID;
	}
	public function setParams($Id){
		$this->ID = $Id;
	}

	/**
	 * Adds new field
	 *
	 * @return Rad_Form_Field
	 */
	public function addField(Rad_Form_Field $Field = null){

		if(!$Field) $Field = new Rad_Form_Field($this);
		$Field->Parent = $this;
		return $this->Fields[] = $Field;
	}



	public function getIncomingData(){

		return $this->IncomingFormData;
	}

	protected function set_isValid($Flag){
		$this->isValid = $Flag;
	}

	public function isValid(){
		return $this->isValid;
	}
	public function validate($DataArray = null){



		//validate


		if(!$this->Action) $this->setAction(self::InsertAction );

		if($DataArray) $this->IncomingFormData = $DataArray;
		else $this->IncomingFormData = $_POST;



		$this->setFieldsValues($this->IncomingFormData);
		/*@var $f Rad_Form_Field*/


		$this->set_isValid(true);
		foreach ($this->Fields as $f){

			if($this->Action == self::InsertAction && !$f->isIncludedInInsertAction() ) continue;
			if(!$f->validate()) {
			
				$this->set_isValid(false);
			}


		}


		return $this->isValid();




	}


	public function getAllErrors(){
		$errors = array();
		foreach ($this->Fields as $f)
		{
			/*@var $f Rad_Form_Field*/
			if($f->Errors){
				$errors[] = array($f->ID=>$f->Errors);
			}
		}
		return $errors;
	}
	public function getFormValues($showEmpty = true)
	{

		
		$Arr = array();
		foreach ($this->Fields as $f){
			/*@var $f Rad_Form_Field*/
		
			if($f->isAdditional) continue;
			
			$Arr[$f->ID] = (string) $f->getValue();

		}
		
		return $Arr;






	}
	
	public function getAdditionalFormValuesXml(){
		
		return $this->getFormXmlString(true);		
	}
	public function setFieldsValues($Data,$SetAdditionalValuesFlag = false){


/*		print_r($_POST);
		print_r($this->getFormValues());


		$this->getField('type-3')->Type->Value = 'dede';
		print_r($this->getFormValues());
		die();*/
		
		foreach ($this->Fields as $key=>$f){
			/*@var $f Rad_Form_Field*/

			//
			//echo $f->ID;
			if($f->Type->getTypeString() == 'file'){


				$f->Type->setValue($f->ID);
				$f->Type->File->Filename = $Data[$f->ID];
				//$Data[$f->ID] = $_FILES[$f->ID]['name'];


			}else{
				
	
		/*		if($key ==1 ){
				echo $f->ID;
				echo $f->Type->getTypeString();
				}*/
				
				if(isset($Data[$f->ID]) && !($SetAdditionalValuesFlag && $f->isAdditional)) {
				//	echo 	$f->ID.' '.$Data[$f->ID];
					$f->setValue($Data[$f->ID]);
			//		echo '<br>'.$f->getValue().'<br>';
				}
			
			}
			
			
			

			
		}
		
	
	//	die('d');
	
				
		


	}

	public function removeXmlFieldsFromArray($Array){

		foreach ($this->Fields as $f){
			/*@var $f Rad_Form_Field*/
			//	print_r($Array);
			//echo $f->ID;
			if(key_exists($f->ID,$Array)) unset($Array[$f->ID]);





		}
		return $Array;

	}

	public function initFromXmlSource(Rad_Form_Xml_Source $Source){


		foreach ($Source->getFormSourceObject()->xpath('//field') as $f){

			$this->addField()->setParamsFromXml($f);




		}
		if($Source->AdditionalXml){
			if(is_string($Source->AdditionalXml)) $Source->AdditionalXml = simplexml_load_string($Source->AdditionalXml);
			
			foreach ($Source->AdditionalXml->xpath('//field') as $f){

				$_f = $this->addField();
				$_f->setParamsFromXml($f);
				$_f->isAdditional = true;




			}
		}





	}

	public function isFormPost(){

		global $InOut;
		return $InOut->isFormPost();

	}

	public function setErrorFlag($Flag = true){
		$this->ErrorFlag = $Flag;
	}


	public function initFromArraySource($Array,$Prefix = 'jt'){


		foreach ($Array as $f){

			/*	$this->addField()->setParams(
			(string) $f['id'],
			(string) $f->title->en,
			(string) $f->type,
			(int) $f->is_null,
			(string) $f->value

			);*/
			$Id = (string) $f[$Prefix.'_item_id'];
			$Title = (string) $f[$Prefix.'_title'];
			$Type = (string) $f[$Prefix.'_type'];
			$IsNull  = (int) $f[$Prefix.'_isnull'];
			$Value = (string) $f[$Prefix.'_value'];
			$this->addField()->setParams($Id,$Title,$Type,$IsNull,$Value);;


		}





	}


	public function getFormXmlString($getAdditional = false){



		$d = "<form id=\"$this->ID\"><fields></fields></form>";
		$Form = new SimpleXMLElement($d);




		

		foreach ($this->Fields as $f){

		
			/*@var $f Rad_Form_Field*/
			if($getAdditional && !$f->isAdditional) continue;
			$Type = $f->Type->getTypeString();
			/*			switch ($Type){
			case 'text':
			$Type = 'string';
			break;
			case 'boolean':
			$Type = 'bool';
			break;

			default:
			$Type = 'string';
			break;
			}*/


			$field = $Form->fields->addChild('field');
		
//			$Title = $field->addChild('title');
//			$Title->addChild('en',$f->Title) ;

	//		 $field->title->en;
			//echo $f->Title;
			
			//$field->addChild('id',$Id);
			//	$field['id'] = $f->ID;

			/*			$field->addChild('type',$Type);
			$field->addChild('value',$f->Type->getValue());
			
			*/
			 $f->Type->appendXML($field);
			 if($f->Params){
			 	$params = $field->addChild('params');
			 	foreach ($f->Params as $key => $val) {
			 		$params->$key = $val;
			 	
			 	}
			 }
			//print_r($field);
			//$listing->addChild( 'description', '<![CDATA[' . $row['description'] . ']]>' );

			
		}


		
		global $Config;

		return $Form->asXml();




	}



	private function LoadDataFile(){

		$xml = simplexml_load_file($this->XmlDirPath.'forms/'.$this->FormClass.'.xml') OR die('error loading xml file '.$this->FormClass.'.xml');
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




}



?>