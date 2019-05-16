<?php


require_once('formerrors.php');
require_once('field_datasource.php');



class FormFieldView{

	public $Type;

	public function __construct(){

	}

	public function initByXml($Xml){


		if($Xml->type) $this->Type = (string) $Xml->type;
		else $this->Type = (string) $Xml;


	}


}
class FormField{


	public $FieldTypesRef;
	public $GlobalFieldErrorsRef;
	public $FieldClassesRef;


	public $ID;
	public $Title;
	public $Class;
	public $Hidden = 0;
	public $Type = 'string';
	public $Value = '';
	public $ViewValue = '';
	public $ViewValues = array();
	public $ListKeyTitle;
	public $ListValueTitle;
	public $ListValueIsNullFlag = 0;


	public $SkipFlag = false;
	public $ListValue = array();
	public   $IncludeInListFlag = false ;
	public $FilePath;
	public $FileType;
	public $EnumNewStyle = false;
	public $EnumList = array();
	public $View;

	public $ViewObject = null;
	public $Access;
	public $TextDirection = 'ltr'; //text aligment for languages like hebrew
	/**
	 * Field Datasource object 
	 * 
	 * @var FieldDatasource
	 */
	public $Datasource;
	public $PostedValue;
	public $IsRequired = true;
	public $Errors = array();

	protected $XmlField;
	public $AppendInInsertAction = true;
	public $PrimaryKey = false; //is field primary key
	public $ProceedViewValues;

	public $JavaScript;
	public $isValidated = false;


	public function getValue($Escape = true){
		//		if($this->Type =='string') return mysql_real_escape_string($this->Value);
		$this->Value = trim($this->Value);
		if($Escape) return $this->_escape($this->Value);
		return $this->Value;
	}

	public function getViewValue(){
		if($this->ListValue){
	
			foreach ($this->ListValue as $v){
				
				if($v[$this->ListKeyTitle] == $this->Value) 
				return $v[$this->ListValueTitle];
			}
		}
		return $this->getValue();
	}

	public function setFieldValue($Title,$Value,$Type='string'){
/*		if ($this->Type == 'bool'){


			if($Value == 'true') $Value = 1;
			elseif ($Value == 'false') $Value = 0;
			echo ($Value);
			
			
		}*/
		
		$this->Title = $Title;
		$this->Value = $Value;
		$this->Type = $Type;
		
	}


	//actions: insert, update,
	function __construct($XmlField,$Action,$Value = null,$ViewValue = NULL,$PostedValue = Null){


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
		if((int) $XmlField['not_required'] == 1 || (isset($XmlField['is_required']) && (int) 0 == $XmlField['is_required'] )) $this->IsRequired = false;
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
		if(@$XmlField['primary_key']) {


			$this->PrimaryKey = true;
		}


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
			require_once($Config->SitePath.'/3rd_party/fckeditor/fckeditor.php');
			$oFCKeditor = new FCKeditor($this->ID);
			$oFCKeditor->Width  = '100%' ;
			$oFCKeditor->Height = '400' ;

			$oFCKeditor->BasePath = $Config->Hostname.'/3rd_party/fckeditor/';
			$oFCKeditor->Value =& $this->Value;
			$this->ViewObject = $oFCKeditor;



		}


		if($XmlField->enum){

			//new style
			if($XmlField->enum->fields){
				$this->EnumNewStyle  = true;
				foreach ($XmlField->enum->fields->field as $f){
					if(!$Title = (string) @$f->title->$Lang) $Title = (string) @$f->title->en;
					$this->EnumList[$Title] = (string) $f->value;
				}

			}else{
				//old style
				foreach ($XmlField->enum->values->value as $val){
					$this->EnumList[] = (string) $val;
				}
			}


		}




		$this->IncludeInListFlag = true;
		
		//for list control, later it's nessesary to add data to the list
		if( ($ListKey = (string) @$XmlField->list->key_title) && ($ListVal = (string) @$XmlField->list->value_title)){

			
			$this->ListKeyTitle = $ListKey;
			$this->ListValueTitle = $ListVal;
			
		
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



	}

	public function isIncluded(){
		return $this->IncludeInListFlag;
	}

	public function setValue($Value){

		//echo $this->Type;
		if ($this->Type == 'bool'){


			
			if($Value == 'true') $Value = 1;
			elseif ($Value == 'false') $Value = 0;
			
			
			
		}
		$this->Value  = $Value;
	}

	public function setError($Error){
		$this->Errors[] = $Error;

	}
	public function addListArray($Array){
		/*echo $this->ListKeyTitle;
		echo $this->ListValueTitle;
		print_r($Array);*/
		$this->ListValue = $Array;
	}
	/**
	 * Self-field validate
	 *
	 * @param SimpleXMLElement $Types list of type errors
	 * @param SimpleXMLElement $GlobalFieldErrors list of global errors
	 */
	public function validateField(FormFieldList $Parent = null){

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
				if($this->Value != @$_SESSION['rnd']  && !$_REQUEST['debug_off']) {

					$this->insertFieldTypeError($TypeXml);
				}

				unset($_SESSION['rnd']);
				//	unset($_SESSION['old_rnd']);
				break;


			case 'file':



				//file is not requred by default, make <file require="1"></file> in xml

				$FileManager = new FileManager();

				if($FileManager->isFileUploaded($this->ID)){


					//die('d');
					switch ((string) @$this->XmlField->file->filetype){



						case 'image':

							if(!$FileManager->checkUploadedFile($this->ID,'image')){
								$this->insertFieldGlobalError('filetype');


							}else {
								$NewFile = $FileManager->moveUploadedFile((string) @$this->XmlField->file->path);
								$FileManager->makeThumbnail($FileManager->Path.$FileManager->MovedFile,$FileManager->Path.'thumbs/'.$FileManager->MovedFile,145,109);
								$this->Value = $NewFile;
							}
							break;




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


				if($this->Value == 2 || $this->Value == 'true') $this->Value = 1;
				elseif ($this->Value == 1 || $this->Value == 'false') $this->Value = 0;
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

	protected function _escape($string, $esc_type = 'html', $char_set = 'ISO-8859-1')
	{
		switch ($esc_type) {
			case 'html':
				return htmlspecialchars($string, ENT_QUOTES, $char_set);

			case 'htmlall':
				return htmlentities($string, ENT_QUOTES, $char_set);

			case 'url':
				return rawurlencode($string);

			case 'urlpathinfo':
				return str_replace('%2F','/',rawurlencode($string));

			case 'quotes':
				// escape unescaped single quotes
				return preg_replace("%(?<!\\\\)'%", "\\'", $string);

			case 'hex':
				// escape every character into hex
				$return = '';
				for ($x=0; $x < strlen($string); $x++) {
					$return .= '%' . bin2hex($string[$x]);
				}
				return $return;

			case 'hexentity':
				$return = '';
				for ($x=0; $x < strlen($string); $x++) {
					$return .= '&#x' . bin2hex($string[$x]) . ';';
				}
				return $return;

			case 'decentity':
				$return = '';
				for ($x=0; $x < strlen($string); $x++) {
					$return .= '&#' . ord($string[$x]) . ';';
				}
				return $return;

			case 'javascript':
				// escape quotes and backslashes, newlines, etc.
				return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));

			case 'mail':
				// safe way to display e-mail address on a web page
				return str_replace(array('@', '.'),array(' [AT] ', ' [DOT] '), $string);

			case 'nonstd':
				// escape non-standard chars, such as ms document quotes
				$_res = '';
				for($_i = 0, $_len = strlen($string); $_i < $_len; $_i++) {
					$_ord = ord(substr($string, $_i, 1));
					// non-standard char, escape it
					if($_ord >= 126){
						$_res .= '&#' . $_ord . ';';
					}
					else {
						$_res .= substr($string, $_i, 1);
					}
				}
				return $_res;

			default:
				return $string;
		}
	}









}

?>