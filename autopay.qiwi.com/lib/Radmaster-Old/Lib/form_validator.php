<?php

class Form_Validator extends Element {





	const FIELD_TYPE = 'field_type';
	const FIELD_CLASS = 'field_class';
	const FIELD_COMMON_CHECK = 'field_common_check';


	static $meta_base_path_static;

	/**
	 * form 
	 *
	 * @var Ui_Form
	 */
	protected $_form;


	protected $_errors_meta;
	protected $_types_meta;
	protected $_classes_meta;

	protected $_class_meta;


	protected  $_meta_file_base_path;



	public function onInit(){
		$this->_meta_file_base_path = PATH_META_DATA;
		$this->loadErrorMessageMeta();
		$this->loadTypeMeta();
		$this->loadClassMeta();
	}
	public static function setBaseMetaPath_static($path){

		self::$meta_base_path_static  = $path;

	}

	public function validateForm(Ui_Element $form){

		global $debug;
		$this->_form = $form;


		//$form->setErrorFlag(false);
		//$form->setData($_POST);

		$form->setData($_REQUEST);


		/*@var $field Ui_Form_Field*/
		foreach ($form->getFields() as $field)		{

			//global check

			$name = $field->getName();
			$type = $field->getType();
			
			$value_type = $field->getValue()->getType();
			
			if(!$value_type) $value_type = 'string';
			$value = (string) $field->getValue();

			$type_check_flag = true;

			if($type == 'checkbox'){

				if($value == '') $field->setValue(1);


				else $field->setValue(2);

			}
			elseif(!trim($value) && $field->getParam('is_required') && $type != 'file'){

				$this->addError_field($field,'empty');

				$type_check_flag  = false;

			}

			
			//
			//  validation by class
			//





			if($type_check_flag &&  $field->class){

				$class_meta = $this->_classes_meta->xpath("//class[@id='{$field->class}']");
				if(!$class_meta) throw  new Exception('Coudn\'t find field class '.$field->class);
				//echo $ClassXml[0] = $ClassXml;
				//print_r($ClassXml);
				$this->_class_meta = $class_meta[0];
				$reg_exp = (string) @$class_meta[0]->regexp['value'];
				if(!$reg_exp) {

					$debug->addMessage('No regexp for class: '.$field->class);

				}else{

					/*					$class_meta = $this->_classes_meta->xpath("//class[@id='{$field->class}']");

					if(!$class_meta) throw  new Exception('Coudn\'t find field class '.$field->class);
					$this->_class_meta = $class_meta[0];

					$class_meta = $this->_class_meta;

					$reg_exp = (string) @$class_meta->regexp['value'];*/

					if(!preg_match($reg_exp,$value)){


						$this->addError_field($field,'regexp',self::FIELD_CLASS);

					}


				}

			}

			//
			// end of validation by class
			//



			/*@var $field Ui_Form_Field*/
			if($type_check_flag)
			switch ($value_type){

				case 'string':

					if($field->min || $field->max){

						if(((strlen($value) < $field->min) && $field->min != 'a' && $field->min != 'i')
						|| ((strlen($value)  > $field->max) && $$field->max != 'a' && $field->max != 'i')){

							if(is_numeric($field->min)) $msg = "min: $field->min";
							if(is_numeric($field->max)) {
								if($msg) $msg .= ', ';
								$msg .= " max: $field->max";
							}

							$this->addError_field($field,'length',self::FIELD_COMMON_CHECK ,$msg);

						}
					}

					break;

				case 'bool':


					if($value == 2 || $value == 'true') $value = 1;
					elseif ($value == 1 || $value == 'false') $value = 0;
					else $value = 0;
					break;

				case 'float':
				case 'list':


					if(!is_numeric($value) && $value !== null) {

						$this->addError_field($field,$type,self::FIELD_TYPE);

						break;
					}

					$field->value = (float) $value;


					//echo die($this->Value);
					break;



				case 'int':

					if(!is_numeric($value)) {

						$this->addError_field($field,$type,self::FIELD_TYPE);

						break;
					}
					if($field->max && $field->min){
						$min = $field->min;
						$max = $field->max;

						$add_msg = '';
						if(($value < $min && $min != 'a' && $min != 'i')
						|| ($value  > $max && $max != 'a' && $max != 'i')){

							if(is_numeric($min)) $add_msg = "min: $min";
							if(is_numeric($max)) {

								if($add_msg) $add_msg .= ', ';
								$add_msg .= " max: $max";
							}

							$this->addError_field($field,'range',self::FIELD_COMMON_CHECK,$add_msg);

						}


					}

					$field->setValue((int) $value);


					break;


				case 'date':

					list($day,$month, $year) = split('\/',$value);

					$field->value = mktime(0, 0, 0, $month, $day, $year);



					break;



				case 'file':



					require_once('file-manager.php');

					$FileManager = new FileManager();

					if($FileManager->isFileUploaded($name)){


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
							default:
								$path = PATH_APP_DATA.'/_tmp/';
								if($FileManager->checkUploadedFile($name,'image')){

									$new_file = $FileManager->moveUploadedFile($path);
								}
								$field->setValue($path.$new_file);

								break;




						}




					}elseif ($field->getParam('is_required')){

						
						$this->addError_field($field,'empty');
						
					}else {

						if(isset($_POST[$this->ID.'_image_delete'])){

							$this->Value = '';

						}else {

							$this->SkipFlag = true;
							$this->IncludeInListFlag  = false;
						}




					}





					break;



				case 'captcha':
					/*				echo $this->Value;
					print_r($_SESSION);
					die();*/
					@$_SESSION['old_rnd'] = @$_SESSION['rnd'];
					if($value != @$_SESSION['rnd']) {

						$this->addError_field($field,'captcha',self::FIELD_COMMON_CHECK);
					}

					unset($_SESSION['rnd']);
					//	unset($_SESSION['old_rnd']);
					break;



			}

			//	$this->addError_field($field,'length');
		}



		$return_flag = 1;
		if($form->getErrorFlag()) $return_flag = 0;

		return $return_flag;
	}


	/**
	 * Adds selected global error to the field
	 *
	 * @param string $ErrorType 
	 * @param string $Add2Msg  text which adds to the end of the error mesage
	 */

	/**
	 * Adds selected global error to the field
	 *
	 * @param Ui_Form_Field $field
	 * @param string $error_type
	 * @param string $check_type
	 * @param string $message_additional text added to the end of the error mesage
	 */
	private function addError_field(Ui_Element $field,$error_type, $check_type = self::FIELD_COMMON_CHECK, $message_additional = null){


		$errors_meta = $this->_errors_meta;
		$types_meta = $this->_types_meta;
		$classes_meta = $this->_classes_meta;




		$this->_form->setErrorFlag(1);

		global $config;
		global $debug;

		$lang = Registry::get('lang');

		switch ($check_type){

			case self::FIELD_COMMON_CHECK :

				if(!empty($errors_meta->$error_type->$lang)) $msg = $errors_meta->$error_type->$lang;
				elseif (!empty($errors_meta->$error_type->en)) $msg = $errors_meta->$error_type->en;
				elseif (!empty($errors_meta->$error_type->common_error->en)) $msg = $errors_meta->$error_type->common_error->en;
				else $msg = 'field error';

				//		if(!empty($XmlObj->title->$Lang)) $FieldTitle = $Field->title->$Lang;
				//		elseif (!empty($XmlObj->title->en)) $FieldTitle = $Field->title->en;
				//		else $FieldTitle ='Field';

				$msg = (string) $msg;
				if($message_additional) $msg = $msg.', '.$message_additional;

				$field->setErrorMessage($msg);

				break;
			case self::FIELD_TYPE:


				//$type_meta = $this->_types_meta->{$error_type};

				$type_meta = $this->_types_meta->xpath("//type[@id='{$error_type}']");
				if($type_meta) $type_meta = $type_meta[0];
				$error_message = (string) @$type_meta->error->{$lang};
				if(!$error_message) $error_message = (string) @$type_meta->error->en;
				if(!$error_message){
					$debug->addMessage('No error message set for type: '.$error_type);
					$error_message = 'field validation error';
				}

				$field->setErrorMessage($error_message);





				break;

			case self::FIELD_CLASS :


				$class_meta = $this->_class_meta;

				$error_message = (string) @$class_meta->message->{$lang};
				if(!$error_message) $error_message = (string) @$class_meta->message->en;
				if(!$error_message){
					$debug->addMessage('No error message set for class: '.$field->class);
					$error_message = 'field validation error';
				}

				$field->setErrorMessage($error_message);


				break;
		}

	}




	protected  function loadErrorMessageMeta(){

		$file = $this->_meta_file_base_path.'/errors.xml';

		$meta = simplexml_load_file($file);
		if(!$meta) throw new Exception('Error in loading '.$file);

		$this->_errors_meta = $meta;
		//	print_r($Xml);


	}



	protected  function loadTypeMeta(){

		//todo: remove gobal $config  ... later...=)

		global $config;
		$file = $this->_meta_file_base_path.'/types.xml';

		$meta = simplexml_load_file($file);
		if(!$meta) throw new Exception('Error in loading '.$file);

		$this->_types_meta = $meta;
		//	print_r($Xml);


	}

	protected  function loadClassMeta(){

		//todo: remove gobal $config  ... later...=)

		global $config;
		$file = $this->_meta_file_base_path.'/classes.xml';

		$meta = simplexml_load_file($file);
		if(!$meta) throw new Exception('Error in loading '.$file);

		$this->_classes_meta = $meta;
		//	print_r($Xml);


	}



}

?>