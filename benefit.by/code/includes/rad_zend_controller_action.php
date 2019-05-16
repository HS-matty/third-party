<?php



class Rad_Zend_Controller_Action extends Zend_Controller_Action{


	public function init()
	{
		global $Config;





		$this->_view = $this->getInvokeArg('view');

		$this->_view->action = $this->_request->getActionName();
		$this->User= $this->_view->User;
		$this->_view->IndexTemplate = 'index.tpl';
		if(!$this->User->isLogined('AdminUser') && $this->_view->action != 'login'){
			//	$this->_redirect('/admin/login/');
		}

		$this->_view->setModuleName($this->getRequest()->getModuleName());


	}
	/**
	 * Function which parses all forms
	 *
	 * @param Rad_Form_Params $Params
	 * @return Rad_Form_Result
	 */
	protected function parseForm(Rad_Form_Params $Params,Form2 $Form = null){
		$ProceedData = true;

		if(!$Form){
			$Form = new Form2($Params->Source->FormName,$Params->Source->Class);

			if($Params->Object){

				//$Data = $Form->assignDataToForm($Params->Object->getFormData());
				$Data = $Params->Object->getFormData();
				$AddXml = $Params->Object->AdditionalFormData;
			}else $Data = null;




			$AddData = null;
			if($AddXml || $AddXml = $Params->Source->AdditionalXml){



				$AddData = $Form->parseAdditionalXmlFields($AddXml);


			}


			if($Params->RemovedFields){
				foreach ($Params->RemovedFields as $f){

					$Form->removeField($f);
				}
			}
			$Form->proceedFields($Params->Action);
			$Form->assignDataToForm($Data,$AddData);

			if($Params->PredefinedFieldValues) 		{

				foreach ($Params->PredefinedFieldValues as $key=>$v){

					$Form->FormFieldListObj->addListDataToField($key,$v);
				}
			}

		}else{
				$ProceedData = false;
		}





		$this->_view->Form  = $Form;


		if($Form->isFormPost()){
			if( $Form->validateForm()){


				$Result = new Rad_Form_Result();
				$Result->set_uiObject($Form);

				if($Params->ProceedData && $Params->Object && $ProceedData){

					$Data =& $Form->getFormArrayExt();

					switch ($Params->Action){
						case Form2::InsertAction :


							$Params->Object->insertFormObject($Data);
							break;
						case Form2::UpdateAction :

							$Params->Object->updateFormObject($Data);

							break;
					}
					$Result->isSuccess = true;

					$this->_view->success = 2;


				}

			
				return $Result;

			}else {
				//	print_r($Form->FormFieldListObj->getErrorsList());
				$this->_view->success = 1;

				if(false){
					$Form->FormFieldListObj->setFormValues($Params->Object->getFormData());
				}else 	$Form->FormFieldListObj->setFormValues($_POST);
			}
		}else $Form->assignDataToForm($Data);


		//echo ($Form->getField('category_id')->ViewValue);
		//die();
		return NULL;



	}
	
	/**
	 * Proceed any form object
	 *
	 * @param Form2|Rad_Form $FormObject
	 * @return Rad_Form_Result
	 */
	public function proceedForm($FormObject){
		
		$Class = get_class($FormObject);
		switch ($Class){
			case 'Form2':
				return $this->parseForm(new Rad_Form_Params(),$FormObject);
				break;
			case 'Rad_Form':
				$Params = new Rad_Form_Params();
				$Params->setFormCustomObject($FormObject);;
				return $this->parseFormExt($Params);
				break;
				default:
					throw new Exception('Unkown form type : '.$FormObject);
				break;
		}
		
	}
	/**
	 * Function which parses all forms
	 *
	 * @param Rad_Form_Params $Params
	 * @return Rad_Form_Result
	 */
	protected function parseFormExt(Rad_Form_Params $Params){

		if(!$Form= $Params->getFormCustomObject()){


			$Form = new Rad_Form();


			$Form->initFromXmlSource($Params->Source);

			$Form->setAction($Params->Action);
		}

		if($Params->Object){
			//$Data = $Form->assignDataToForm($Params->Object->getFormData());
			$Data = $Params->Object->getFormData();



		}else $Data = null;


		$AddData = null;






		//print_r($Params->PredefinedFieldValues);

		//	print_r($Form->FormFieldListObj->FieldList);
		//	die();
		$this->_view->Form  = $Form;

		//$Form->setParams()


		if($Form->isFormPost()){

			if( $Form->validate()){



				$Result = new Rad_Form_Result();
				$Result->set_uiObject($Form);



				if($Params->ProceedData && $Params->Object){



					$Data =& $Form->getFormValues();
					if($Params->hasAdditionalFields) $AdditionalDataXml = $Form->getAdditionalFormValuesXml();
					else $AdditionalDataXml = null;
					$Params->Object->parseAdditionalFields($Data,$AdditionalDataXml);

					switch ($Params->Action){
						case Form2::InsertAction :

							//							die('dd');
							$Params->Object->insertFormObject($Data);
							break;
						case Form2::UpdateAction :




							$Params->Object->updateFormObject($Data);

							break;
					}
					$Result->isSuccess = true;

					$this->_view->success = true;


				}



				return $Result;

			}else {

				
				$this->_view->success = false;

				if(false){
					$Form->setFieldsValues($Params->Object->getFormData());

				}else 	$Form->setFieldsValues($_POST);
			}
		}else {


			if($Data) $Form->setFieldsValues($Data,true);

			if($AddData) $Form->setFieldsValues($AddData);
		}



		//echo ($Form->getField('category_id')->ViewValue);
		//die();
		return NULL;



	}
	protected function getActionSid(){
		return md5($this->getRequest()->getModuleName().$this->getRequest()->getControllerName().$this->getRequest()->getActionName());
	}
	protected function proceedGridSessionData(){
		$Sid = $this->getActionSid();
		$defaultNamespace = new Zend_Session_Namespace();
		if($this->_getParam('post')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$Sid = $Params;

		}elseif ($this->_getParam('clear')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$Sid  = null;
		}else $Params = $defaultNamespace->$Sid;

		return $this->_view->Params = $Params;
	}

}
?>