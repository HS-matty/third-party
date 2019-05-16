<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007 
You can freely use this file
if you have any questions please visit radmaster.net

*/


//by form parser by Sergey Volchek byq@kay.by
/*
Common usage
$Form = new FormExt('login','common');
$Errors = $Form->ProceedForm();
$Array =& $Form->GetFormArray();
*/
//22.11.2006 a lot of changes =)
//25.01.1007 new class form2 created. use it instead formext ;-)))

require_once('formfieldslist.php');
class 
FormExt{



	const InsertAction = 'insert';
	const UpdateAction = 'update';
	const SelectAction = 'select';
	const ViewAction = 'view';
	const DevelopAction = 'develop';

	private $FormFieldList;//FormFieldList list
	private $FormFieldListObj;//FormFieldList obj


	public $isActive = 1;
	public  $FormName;
	public $FormClass;
	private $XmlDirPath = '/data/formparser/';
	private $XmlFile;
	private $XmlFieldClassesFile = 'field_classes.xml';
	private $XmlErrorFile = 'errors.xml';
	private $XmlTypesFile = 'types.xml';
	private  $FieldClasses;
	public   $FieldTypes;
	public   $FormErrors;
	private  $GroupTitle;
	private  $EndGroupFlag = 0;


	private $XmlObj;
	private $ErrorMessage = array();
	private   $i;
	private  $group_i;
	private  $group_max_i = 5;/// maximum number if records for group processing
	public  $Lang;

	public $Action;
	public  $ProceededFields;

	private $GroupFieldNum = array();
	public $FormTitle;
	private $IncludeFieldInArrayFlag = true;

	public $FormWidth;

	private $RemovedFields = array();
	public $ErrorFlag = false;
	private $AddListDataToFieldList = array();

	public function removeField($FieldId){
		
		$this->RemovedFields[$FieldId] = 1;
		
	}

	
	private function isFieldRemoved($FieldId){
		if(@$this->RemovedFields[$FieldId] == 1) return true;
		return false;
	}
	public function addListDataToFieldExt($FieldId,&$Data){
		/*if(!$this->FormFieldListObj){
			throw new Exception('FieldsList object not found');
		}*/
		//$this->FormFieldListObj->addListDataToField($FieldId,$Data);
		$this->AddListDataToFieldList[$FieldId] = $Data;
	}
	
	
	public function addListDataToField($FieldId,&$Data){
		if(!$this->FormFieldListObj){
			throw new Exception('FieldsList object not found');
		}
		$this->FormFieldListObj->addListDataToField($FieldId,$Data);
		
	}
	public function SetGroupMaxNum($Num){


		$this->group_max_i = $Num;

	}

	public function &GetFormArray(){

		return $this->FormArray;
	}



	public function SetGroupFieldNum($GroupName,$Num){

		$this->GroupFieldNum["$GroupName"] = (int) $Num;


	}



	private $FormChecked = 0;


	public function &GetErrorsArray(){

		return $this->ErrorMessage;

	}

	function __construct($FormName,$FormClass,$MaxGroupNum = null){

		$this->FormName  = $FormName;
		$this->FormClass = $FormClass;
		if($MaxGroupNum) $this->SetGroupMaxNum($MaxGroupNum);;

		global $Config;
		$this->XmlDirPath = $Config->SitePath.$this->XmlDirPath;
	


	}
	function __destruct(){



	}



	public function &GetFormGroupsArray($GroupName){

		$Lang = $this->Lang;
		$GroupArray = array();





		$Pattern = "/^".$GroupName."([0-9])_([0-9a-zA-Z-_]*)$/";

		foreach ($_POST as $key => $val){


			preg_match($Pattern,$key,$matches);



			if(!empty($matches)){

				//	print("$matches[2] <br>");
				if(!@$this->ProceededFields[$matches[2]]) continue;
				//	print("proccrd: $matches[2] <br>");
				if(get_magic_quotes_gpc()) $GroupArray[$matches[1]][$matches[2]] = $val;
				else $GroupArray[$matches[1]][$matches[2]] = addslashes($val);

			}

			unset($matches);
		}



		return $GroupArray;




	}
	//$FormFieldData is reference to $_POST[$FieldName], so think before changing $FormFieldData
	private function ValidateField(&$FormFieldData,$Field,$LoopIndex = null){



	
		$FormFieldData = trim(strip_tags($FormFieldData));
		
		$this->IncludeFieldInArrayFlag  = true;

		$this->EndGroupFlag = 0;

		$Type = (string) $Field->type;
		$AddMsg = null;

		if(!is_null($LoopIndex)) $AddMsg = " (col#".($LoopIndex+1).") ";

		if($FormFieldData == NULL){

			if((int) $Field['not_required'] == 0 && $Type != 'file') {
				$this->InsertErrorMessage('empty',$Field,$AddMsg);
				$this->EndGroupFlag = 1;

				return 0;
			}


		}



		


		
		$Lang = $this->Lang;
		

		


		switch ($Type) {

			case 'file':
				$Type = 'file';

				break;

			case 'string':
				$Type = 'string';
				break;
			case 'list':
			
				//$FormFieldData = (int) $FormFieldData;
				//			$FormFieldData = (int) $FormFieldData;
				$Type = 'string';
			if((int) @$Field->list['not_null'] && !($FormFieldData) ){

					$this->InsertErrorMessage('empty',$Field,$AddMsg);
			}
			
			break;
			case 'bool':
			case 'int':
				
				
				if(!is_numeric($FormFieldData)) {
					$this->InsertErrorMessage('int',$Field,$AddMsg);
					return ;
				}
				$FormFieldData = (int) $FormFieldData;
				//			$FormFieldData = (int) $FormFieldData;
				$Type = 'int';
				break;
			case 'float':
				if(!is_numeric($FormFieldData)) {
					$this->InsertErrorMessage('int',$Field,$AddMsg);
					return ;
				}
				$FormFieldData = (float) $FormFieldData;
				$Type = 'float';
				break;


			default:
				$Type = 'string';


		}


		
		if(!@$LengthArray) preg_match("/^([0-9a]{1,10})-([0-9a]{1,10})$/",(string) @$Field->length,$LengthArray);
		if(!empty($LengthArray)){
			$Min = (string) $LengthArray[1];

			$Max = (string) $LengthArray[2];


		}elseif ($Type == 'bool'){
			$Min = 0;
			$Max = 1;
		}
		//length check



		if(($Type == 'string' ) && (!empty($Field->length)) ){



			if(($Min != 'a' && (strlen($FormFieldData)) < (int) $Min) || ($Min != 'a' && (strlen($FormFieldData)) < (int)$Min)){



				$this->InsertErrorMessage('length',$Field,$AddMsg);
				$this->EndGroupFlag = 1;



			}




		}elseif( (($Type == 'int' ) || ($Type== 'float')) && !empty($Field->length)){

			if($LoopIndex >0 ) $Msg = ", loop field #$LoopIndex";
			else $Msg = '';
			//Debug($FormFieldData,'formfielddata');
			if($Type=='int' && !(is_numeric($FormFieldData))) $this->InsertErrorMessage('int',$Field);


			elseif  (($FormFieldData < (int) $Min)  || (($FormFieldData > (int)$Max)) && $Max != 'a'){

				$this->InsertErrorMessage('range',$Field,$AddMsg);
				$this->EndGroupFlag = 1;

			}





		}elseif ($Type == 'file'){

			//file is not requred by default, make <file require="1"></file> in xml

			$FileManager = new FileManager();
			if($FileManager->isFileUploaded((string) $Field->id)){
				//print_r($_FILES);



				if(!$FileManager->checkUploadedFile((string) $Field->id,'image')){
					$this->InsertErrorMessage('filetype',$Field,$AddMsg);


				}else {
					$NewFile = $FileManager->moveUploadedFile((string) @$Field->file->path);
					$FormFieldData = $NewFile;
				}
				
				
			}else {
				
				if(isset($_POST[$Field->id.'_image_delete'])){
					
					$FormFieldData = '';
					
				}else {
					$this->IncludeFieldInArrayFlag  = false;
				}
				
				
			}




		}


		//regular expression check
		$RegExpr ='';
		$FieldClassMessage = '';
		if($Class = (string) $Field['class']){
			$Patt = "/field_classes/class[@id=\"$Class\"]";
			$XmlClass = $this->FieldClasses->xpath($Patt);
			//print_r($XmlClass);
			if($XmlClass){
				$RegExpr = (string) $XmlClass[0]->regexp['value'];
				$FieldClassMessage = (string) @$XmlClass[0]->message->$Lang;
			
				
			}
			
			
		}
		
		if(!$RegExpr) $RegExpr = (string) @$Field->expr;

		if($RegExpr && !empty($FormFieldData)) {

			preg_match($RegExpr,$FormFieldData,$Match);

			//			die('d');
			if(!@$Match[0]) $this->InsertErrorMessage('expr',$Field,$FieldClassMessage);
			$this->EndGroupFlag = 1;



		}





	}


	private function LoadFieldClasses(){


		$Xml = simplexml_load_file($this->XmlDirPath.$this->XmlFieldClassesFile);
		if(!$Xml) throw new Exception('Error in loading '.$this->XmlDirPath.$this->XmlFieldClassesFile);
		$this->FieldClasses  = $Xml;

		


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


	private function LoadDataFile(){

		$xml = simplexml_load_file($this->XmlDirPath.'forms/'.$this->FormClass.'.xml') OR die('error loading xml file '.$this->FormClass.'.xml');
		$this->XmlObj = $xml;


	}
	public function ProceedForm($Action = null,$GroupNum = 15,$Lang = null){

		if(!$Action) $Action = self::SelectAction ;
		global $InOut;

		$this->Action = $Action;
		$this->SetGroupMaxNum($GroupNum);

		if(!$Lang){

			global $InOut;
			$this->Lang = $InOut->Lang;

		}else	$this->Lang = $Lang;

		//load form classes data
		//	$this->LoadFormClasses();
		//	if(empty($this->FormClasses)) die('no classes found');

		//load errors data

		$this->LoadErrorsFile();
		if(empty($this->FormErrors)) die('no errors found');

		//load form data

		$this->LoadDataFile();;
		$this->LoadFieldClasses();

		$xml =& $this->XmlObj;
		//
		$FormName = $this->FormName;


		//check if such form exists

/*		if(!isset($xml->{$this->FormName})) throw new Exception('No such form exists, '.$this->FormName);
*/

		$FormObj  = $xml->xpath("/forms/form[@id='{$FormName}']");
		if(empty($FormObj)) throw new Exception('No such form exists, '.$this->FormName);
		

		
		//echo $FormObj[0]['width'];
		foreach ($FormObj[0]->fields->field as  $Field) {
			//print_r($Field);

			if((string)$Field['access'] == 'read') continue;
			
			if($this->isFieldRemoved((string) $Field->id)) continue;
			$this->ProceededFields[(string)$Field->id] = 1;


			if($this->GroupTitle = (string)$Field->group){
				//check for group


				$this->group_i = 0;


				for ($i=0; $i<$this->group_max_i; $i++){


					$FormGroupId = $this->GroupTitle.$i.'_'.$Field->id;


					@$FormFieldData = $_POST[$FormGroupId];

					$this->ValidateField($FormFieldData,$Field,$i);



				}



			}else{


				//do not check primary key when validation for insert
				if($Action == self::InsertAction &&  ((int) @$Field['primary_key']) == 1){

					continue;
				}
				$FormFieldData =& $InOut->pvar((string)$Field->id);





				//	if(!@$FormFieldData)  $FormFieldData = NULL;

				$this->ValidateField($FormFieldData,$Field);



				if((int) @$Field['not_inc_array'] == 0 && $this->IncludeFieldInArrayFlag){


					$this->FormArray[(string)$Field->id] = $FormFieldData;


				}
			}



		}
		if(!empty($this->ErrorMessage)) {
			global $Page;
			$Page->AddParam('Errors',$this->GetErrorsArray());

			return $this->ErrorMessage;
		}
		return null;







	}



	public function loadFormFieldsList($Action,$FormData = null){

		if(!$this->XmlObj)	$this->LoadDataFile();
	
		$FormFieldList = new FormFieldList($this);

		
		if(!$FormData) $FormData = &$_POST;
		$FormObj  = $this->XmlObj->xpath("/forms/form[@id='{$this->FormName}']");
		if(empty($FormObj)) throw new Exception('No such form exists, '.$this->FormName);
		$this->Action = $Action;
		if($this->RemovedFields) $FormFieldList->setRemoveFieldsArray($this->RemovedFields);
		$FormFieldList->initList($FormObj[0],$Action,$FormData);
		$this->FormFieldList =& $FormFieldList->getFieldList();
		$this->FormFieldListObj = $FormFieldList;
		$this->FormTitle = (string) @$FormObj[0]->title->en;

		if($FormObj[0]['width']) $this->FormWidth = (string) $FormObj[0]['width']; 







	}
	
	//extentded loadfromFieldsList()
	//validation moved from formext to the FormField
/*	public function proceedFormExt($FormAction,$FormData = null){
		
		
		if(!$this->XmlObj)	$this->LoadDataFile();
		$this->loadTypesFile();
		$this->LoadErrorsFile();
		$FormFieldList = new FormFieldList($this);

		
		if(!$FormData) $FormData = &$_POST;
		$FormObj  = $this->XmlObj->xpath("/forms/form[@id='{$this->FormName}']");
		if(empty($FormObj)) throw new Exception('No such form exists, '.$this->FormName);
		$this->Action = $FormAction;
		if($this->RemovedFields) $FormFieldList->setRemoveFieldsArray($this->RemovedFields);
		global $InOut;
		if($InOut->isFormPost()) $Validate = true;
		else $Validate = false;
		$FormFieldList->initList($FormObj[0],$FormAction,$FormData,$Validate);
		if($this->AddListDataToFieldList){
			foreach ($this->AddListDataToFieldList as $key => &$value) {
				$FormFieldList->addListDataToField($key,$value);
				
			}
		}
		$this->FormFieldList =& $FormFieldList->getFieldList();
		$this->FormFieldListObj = $FormFieldList;
		$this->FormTitle = (string) @$FormObj[0]->title->en;

		if($FormObj[0]['width']) $this->FormWidth = (string) $FormObj[0]['width'];
		
		
		
	}*/
/*	public function getFormArrayExt(){
		
		if(!$this->ErrorFlag) return $this->FormFieldListObj->getFormDataArray();
		return null;
		
	}
	*/

	// for calls from smarty templates to generate HTML form
	public function getXMLFormContent(){

		return $this->FormFieldList;

	}

	private function InsertErrorMessage($ErrorType,$Field,$Add2Msg=null){

		if(!$this->FormErrors) $Message = 'Form proceed error';
		else {
			$XmlObj = $this->FormErrors;
			$Lang = $this->Lang;

			if(!empty($XmlObj->$ErrorType->$Lang)) $Msg = $XmlObj->$ErrorType->$Lang;
			elseif (!empty($XmlObj->$ErrorType->en)) $Msg = $XmlObj->$ErrorType->en;
			elseif (!empty($XmlObj->$ErrorType->common_error->en)) $Msg->$ErrorType->en;
			else $Msg = 'field error';

			if(!empty($Field->title->$Lang)) $FieldTitle = $Field->title->$Lang;
			elseif (!empty($Field->title->en)) $FieldTitle = $Field->title->en;
			else $FieldTitle ='Field';

			switch ($ErrorType){
				case 'length':
				case 'range';
				$Req = $Field->length;

				break;

				default:
					$Req = '';


			}

			if(empty($this->i)) $this->i = 0;
			$this->ErrorMessage[$this->i]['Msg'] = (string) $Msg;
			if($Add2Msg) $this->ErrorMessage[$this->i]['Msg'] = $this->ErrorMessage[$this->i]['Msg'].' , '.$Add2Msg;
			$this->ErrorMessage[$this->i]['FieldTitle'] = (string) $FieldTitle;
			$this->ErrorMessage[$this->i]['Req'] = (string) $Req;


			$this->i++;
		}



	}
	public function &GetField($FieldName){

		if(isset($_POST["$FieldName"])) {

			//if (!get_magic_quotes_gpc()) $_POST["$FieldName"] = mysql_real_escape_string(($_POST["$FieldName"]));
			$ReturnValue = &$_POST["$FieldName"];

		}else $ReturnValue = null;

		return $ReturnValue;


	}
	public function isError(){
		if($this->ErrorMessage) return true;
		return false;
	}

	public function isFormSuccess(){
		global $InOut;
		if($InOut->isFormPost('form1') && !$this->ErrorMessage) return true;
		return false;
	}

}

?>