<?php


require_once('rad_form_errors.php');
require_once('rad_field_datasource.php');



class Rad_Form_Field{


	

	public $ID;
	public $Title;
	public $isHidden = false;
	public $isRequired = true;
	public $isLocked = false;
	public $isAdditional = false;
	//xml datasource
	public  $Xml;


	/**
	 * Rad Form
	 *
	 * @var Rad_Form
	 */
	public  $Parent;


	/**
	 * Type object
	 *
	 * @var Rad_Field_Type
	 */
	public $Type = '';

	/**
	 * View of the field
	 *
	 * @var Rad_Form_Field_View
	 */
	public $View;


	//	public $ViewObject = null;
	/**
	 * Field Datasource object 
	 * 
	 * @var FieldDatasource
	 */
	public $Datasource;
	public $IsNull = false;
	public $Errors = array();


	public $Class;
	public $isValidated = false;
	public $isValid = false;//if form validation is success

	public $Params ; //additional params
	public $isPrimaryKey = false;

	public function __construct($Parent = null){
		$this->Parent = $Parent;
	}
	public function getValue(){

	
		return $this->Type->getValue();
	}

	/**
	 * Get parent object
	 *
	 * @return Rad_Form
	 */
	public function getParent(){
		return $this->Parent;
	}

	public function setValidationFlag($Flag = false){
		$this->isValid = $Flag;
	}

	/**
	 * Set type for field
	 *
	 * @param string $Type
	 */
	public function setType($Type){
		$ClassName = 'Rad_Field_Type_'.$Type;
		//die($ClassName);
		if(!class_exists($ClassName)) throw new Exception('Couldnt find field type - '.$Type);
		$this->Type = new $ClassName($this);
		$this->Type->setType($Type);
	


	}

	public function isIncludedInInsertAction(){
		if($this->Type->getTypeString() == 'int' && $this->isPrimaryKey) return false;
		return true;
	}
	public function setParams(Rad_UI_Field_Params $Params){
		$this->ID = $Params->Id;
		if(!$this->isAdditional) {
		//	$Params->Title = mb_convert_encoding($$this->Title,"UTF-8","auto");
		}
	
		$this->Title = $Params->Title;

		if($Type  = $Params->getType()) 	$this->setType($Type);

		$this->IsNull = $IsNull;

		$this->Type->Length = $Params->length;
		$this->Type->ListValueTitle = $Params->ListValueTitle;
		$this->Type->ListKeyTitle = $Params->ListKeyTitle;
	//	$this->Type->setValue($Value);

		if($EnumValues){

			$this->Type->setListValues($EnumValues);
		}
		$this->Xml  = $Params->Xml;
		//$Params->IsNull



	}

	/**
	 * Set field type
	 *
	 * @param Rad_Field_Type $Type
	 */
	public function setFieldType(Rad_Field_Type $Type){
		$this->Type = $Type;



	}
	protected function setupView($Xml = null){
		$this->View = new Rad_Form_Field_View($this);

		if($Xml) $this->View->initByXml($Xml);



	}
	public function setParamsFromXml($XmlField){

		$Params = new Rad_UI_Field_Params();
		$Params->Id = (string) $XmlField['id'];;
		if(!$Params->Id) $Params->Id = (string) $XmlField->id;;
		$Params->setTitle($XmlField->title);

		$Params->setType((string) $XmlField->type);
		$Params->IsNull  = (int) $XmlField->is_null;
		$Params->Value =  $XmlField->value;



		$this->Class = (string) $XmlField['class'];

		$this->isLocked = (bool) $XmlField['locked'];

		$Params->Xml = $XmlField;
		$this->isPrimaryKey = (int) $XmlField['primary_key'];
		
		if(isset($XmlField['not_required'])){
			//old style
			$this->isRequired = false;
			
		}
		elseif (isset($XmlField['is_required'])){
			//new style
			$this->isRequired = (int) $XmlField['is_required'];
		}
		$this->setParams($Params);
		if($XmlField->params){
			$this->Params = $XmlField->params;
		}
		$this->setupView($XmlField->view);
		switch ($this->Type->getTypeString()){

			case 'enum':
				$Values = $XmlField->xpath('//values/value');

				if($Values){
					$Arr  = Rad_Xml::simplexml2ISOarray($Values);
					$this->Type->setListValues($Arr);

				}
				break;
			case 'list':
				$this->Type->ListValueTitle = (string) $XmlField->list->value_title ;
				$this->Type->ListKeyTitle = (string) $XmlField->list->key_title ;
	
				break;

		}



	}

	//actions: insert, update,
	/*function oldconstruct($XmlField,$Action,$Value = null,$ViewValue = NULL,$PostedValue = Null){



		global $InOut;
		$this->View= new FormFieldView();
		if(!$XmlField) return false;
		//common properties
		$Lang = $InOut->Lang;

		if(!$this->ID = (string) $XmlField->id){
			$this->ID = (string) @$XmlField['id'];
		}
		if(@$XmlField['direction']) $this->TextDirection = (string) $XmlField['direction'];
		$this->Class  = (string) $XmlField['class'];
		$Title = (string) $XmlField->title->{$Lang};
		if(empty($Title)) $Title = (string) $XmlField->title->en;
		if(empty($Title)) $Title = 'Field without title';
		$this->Title = $Title;


		$this->Value = $Value;

		if(@$XmlField['skip']) $this->SkipFlag = true;
		if((int) $XmlField['not_required'] == 1) $this->IsRequired = false;
		$this->XmlField = $XmlField;
		//end of common properties



		if($XmlField->view){


			$this->View->initByXml($XmlField->view);

		}



		//for compatibility
		if(is_array($ViewValue)) $this->ViewValues = $ViewValue;
		else $this->ViewValue = $ViewValue;
		$this->PostedValue = $PostedValue;

		//we can add javascript to the field

		if($XmlField->jscript){
			$this->JavaScript = (string) $XmlField->jscript;

		}

		//
		// if field has primary_key flag, we don't show it in INSERT action
		//
		if(@$XmlField['primary_key']) $this->PrimaryKey = true;

		if(($Action == Form2::InsertAction) && (((int) @$XmlField['skip_insert'] == 1)
		|| (int) @$XmlField['primary_key'] == 1)){

			$this->IncludeInListFlag = false;
			$this->AppendInInsertAction = false;

			return;
		}elseif ($Action == Form2::UpdateAction && @$XmlField['primary_key'] == 1){
			$this->Hidden = 1;

		}

		//if field has another datasource than standart controls

		if($XmlField->datasource) $this->Datasource = new FieldDatasource($XmlField->datasource);


		if($XmlField['access']) $this->Access = (string) $XmlField['access'];




		// how we want to see field in the page

		//if(@$XmlField->view) $this->View = (string) $XmlField->view;
		//echo $this->Title.' - '.$this->View.'</br>';

		//for example like editor
		if($this->View->Type == 'editor'){

			global $Config;
			require_once($Config->SitePath.'/3rd_party/FCKeditor/fckeditor.php');
			$oFCKeditor = new FCKeditor($this->ID);
			$oFCKeditor->Width  = '100%' ;
			$oFCKeditor->Height = '400' ;

			$oFCKeditor->BasePath = $Config->Hostname.'/3rd_party/FCKeditor/';
			$oFCKeditor->Value =& $this->Value;
			$this->ViewObject = $oFCKeditor;



		}


		if($XmlField->enum){
			foreach ($XmlField->enum->values->value as $val){
				$this->EnumList[] = (string) $val;
			}


		}




		$this->IncludeInListFlag = true;
		//for list control, later it's nessesary to add data to the list
		if( ($ListKey = (string) @$XmlField->list->key_title) && ($ListVal = (string) @$XmlField->list->value_title)){

			$this->ListValueTitle = $ListVal;
			$this->ListKeyTitle = $ListKey;
			if((int) @$XmlField->list['not_null'] == 1){
				$this->ListValueIsNullFlag = 1;


			}

		}


		//File field process
		if($Type = (string) @$XmlField->type) $this->Type = $Type;
		//$this->Title = $XmlField->
		if($this->Type == 'file'){

			$this->FilePath = (string) $XmlField->file->path;
			$this->FileType = (string) $XmlField->file->filetype;

		}elseif ($this->Type == 'captcha'){
			global $Config;
			$Link = $InOut->GenerateFullUrl('common','captcha')	;
			$this->ViewValue = $Link;
			//echo $_SESSION['captcha'];




		}



	}*/

	/*	public function isIncluded(){
	return $this->IncludeInListFlag;
	}*/

	/**
	 * Set value of the field
	 *
	 * @param misc $Value
	 */
	public function setValue($Value){


		
		if(!is_object($this->Type)) throw new Exception('Setting Form field value before init');
		
		$this->Type->setValue($Value);
		if($this->View->ViewObject){
			$this->View->ViewObject->Value = $this->getValue();
		}
	}

	public function addListArray($Array){
		$this->ListValue =& $Array;
	}

	/**
	 * Validate field value against its type
	 *
	 * @return bool
	 */
	public function validate(){

		
		 return $this->isValid = $this->Type->validate();

		 

	}


	/**
	 * Self-field validate
	 *
	 * @param SimpleXMLElement $Types list of type errors
	 * @param SimpleXMLElement $GlobalFieldErrors list of global errors
	 */
	public function __old__validateField(FormFieldList $Parent = null){

		$this->isValidated = 1;
		$Types = $this->FieldTypesRef;
		$GlobalFieldErrors = $this->GlobalFieldErrorsRef;
		$Classes = $this->FieldClassesRef;



		$Type = $this->Type;

		/**/


		$this->GlobalFieldErrors = $GlobalFieldErrors;
		$TypeXml = $Types->xpath("/types/type[@id='$Type']");
		if(!$TypeXml) throw new Exception("Type $Type not found");
		$TypeXml = $TypeXml[0];
		$XmlType = (string) $TypeXml['id'];






		//
		//				Perform global field check


		if($this->View->Type == 'checkbox'){
			$this->Value;

			if($this->Value == '') $this->Value =1;


			else $this->Value  = 2;

		}
		elseif(!trim($this->Value) && $this->IsRequired && $Type != 'file'){

			$this->insertFieldGlobalError('empty');

			return ;
		}elseif (!trim($this->Value) && !$this->IsRequired && $Type != 'file'){
			return false;
		}


		//		print_r($this->Errors);

		if($Length = (string) $this->XmlField->length){

			preg_match("/^([0-9a]{1,10})-([0-9ai]{1,10})$/",$Length,$LengthArray);
		}




		//		Perform type specific field check


		$Regexp = (string) $TypeXml->regexp['value'];

		if($Regexp && $this->Value){

			if(!preg_match($Regexp,$this->Value)){
				$this->insertFieldTypeError($TypeXml);
				return ;
			}


		}



		if(!$this->checkClassValidation()) return ;
		//echo $XmlType;

		switch ($XmlType){


			case 'captcha':
				/*				echo $this->Value;
				print_r($_SESSION);
				die();*/
				@$_SESSION['old_rnd'] = @$_SESSION['rnd'];
				if($this->Value != @$_SESSION['rnd']  ) {

					$this->insertFieldTypeError($TypeXml);
				}

				break;


			case 'file':



				//file is not requred by default, make <file require="1"></file> in xml

				$FileManager = new FileManager();

				if($FileManager->isFileUploaded($this->ID)){


					//die('d');
					switch ((string) @$this->XmlField->file->filetype){


						case 'video_screenshot':

							if(!$FileManager->checkUploadedFile($this->ID,'png')){
								$this->insertFieldGlobalError('filetype');

							}else {


								//get item
								global $InOut;
								$Item =& DirectoryItem::getItem((int) $InOut->gvar('item_id'));
								if($Item)
								$NewFile = $FileManager->moveUploadedFile((string) @$this->XmlField->file->path,$this->Value,true,$Item['video'],true);
								$this->SkipFlag = true;


							}




							break;
						case 'image':

							if(!$FileManager->checkUploadedFile($this->ID,'image')){
								$this->insertFieldGlobalError('filetype');


							}else {
								$NewFile = $FileManager->moveUploadedFile((string) @$this->XmlField->file->path);
								$FileManager->makeThumbnail($FileManager->Path.$FileManager->MovedFile,$FileManager->Path.'thumbs/'.$FileManager->MovedFile,145,109);
								$this->Value = $NewFile;
							}
							break;

						case 'video':

							$Video = new Video();
							$Video->setFieldname($this->ID);

							if(!$FileName = $Video->uploadNewVideo()){
								$this->insertFieldGlobalError('filetype');


							}else {
								$this->Value = $FileName;


							}
							break 2;


					}




				}elseif ($this->IsRequired)	{

					$this->insertFieldGlobalError('empty');

				}else {

					if(isset($_POST[$this->ID.'_image_delete'])){

						$this->Value = '';

					}else {

						$this->SkipFlag = true;
						$this->IncludeInListFlag  = false;
					}




				}





				break;

			case 'date':

				list($day,$month, $year) = split('\/',$this->Value);

				$this->Value = mktime(0, 0, 0, $month, $day, $year);



				break;

			case 'bool':

				if($this->Value == 2) $this->Value = 1;
				elseif ($this->Value == 1) $this->Value = 0;
				else $this->Value = 0;
				break;
			case 'float':
			case 'list':


				if(!is_numeric($this->Value) && $this->Value !== null) {
					$this->insertFieldTypeError($TypeXml);
					break;
				}

				$this->Value = (float) $this->Value;


				//echo die($this->Value);
				break;
			case 'int':
				if(!is_numeric($this->Value)) {
					$this->insertFieldTypeError($TypeXml);
					break;
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

				$this->Value = (int) $this->Value;


				break;
			case 'string':

				if(@$LengthArray){
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

				break;


		}




	}
	public  function addErrorMessage($Message){
		$this->Errors[] = $Message;
	}
	/**
	 * Insert datatype error (/data/formparser/types.xml or (if emtpy) common global error.
	 *
	 * @param SimpleXMLElement $Type
	 */
	private function insertFieldTypeError(SimpleXMLElement $Type){

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
	private function checkClassValidation(){

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

				$Error = (string) @$ClassXml[0]->message->en;
				if(!$Error) $Error = 'Field validation error';
				$this->Errors[] = $Error;
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
	private function insertFieldGlobalError($ErrorType,$Add2Msg=null){

		$GlobalFieldErrors = $this->GlobalFieldErrors;

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
			$this->Errors[]	= $Msg;




		}
	}




	/**
	 * Sometimes we need to see another values than we get from the database
	 *
	 * @param array $Data
	 */
	public function proceedViewValues($Data){

		$ViewValues = array();
		if($this->XmlField->view_values){


			$arr = array();

			//	print_r($this->XmlField->view_values);
			//	print_r($Data);
			foreach ($this->XmlField->view_values->value_id as $id){


				$Val = @$Data[(string) $id];

				if($Val) $ViewValues[] = $Val;


			}



		}
		$this->ViewValues =$ViewValues;





	}









}
class Rad_Form_Field_View{


	public $Type = '';

	public $ViewObject;
	/**
	 * Parent object
	 *
	 * @var Rad_Form_Field
	 */
	protected $Parent;
	
	
	public function __construct( Rad_Form_Field $Parent){
		$this->Parent = $Parent;
	}
	public function initByXml($Xml){


		if($Xml->type) $this->Type = (string) $Xml->type;
		else $this->Type = (string) $Xml;

		if($this->Type == 'editor'){

			
			global $Config;
			require_once($Config->SitePath.'/3rd_party/fckeditor/fckeditor.php');
			$oFCKeditor = new FCKeditor($this->Parent->ID);
			$oFCKeditor->Width  = '100%' ;
			$oFCKeditor->Height = '400' ;

			$oFCKeditor->BasePath = $Config->Hostname.'/3rd_party/fckeditor/';
			$oFCKeditor->Value =& $this->Parent->getValue();
			$this->ViewObject = $oFCKeditor;

			


		}

	
	}


}
?>