<?php

class  App_Market_Offer_Ui_Form extends Ui_Form {


	public function onInit(){

		parent::onInit();

		//load form meta
		UI::loadUiElement('/ui/App/Market/@Form/offer.xml',$this);

	}


}





function App_Market_Offer_Ui_Form_onLoad(){


	$window = Registry::get('window');

	$inout = Registry::get('inout');

	/*@var $form Ui_Form */
	$form = ui::getCurrentUiElement();
	//echo $form->getField('id')->getParam('primary_key');
	//exit();


	//$primary_key_field = $form->getPrimaryKeyField();
	//echo $primary_key_field;
	//exit();
	
	$action = $form->getActionType();

	switch ($action){


		case Ui_Form::Type_Form_Action_ADD:

			//check for primary_id
			if($field_id = $form->getField('id')) {

				$form->removeField('id');
				

			}



			break;


		case Ui_Form::Type_Form_Action_VIEW:
		case Ui_Form::Type_Form_Action_EDIT :

			$id = (int) $inout->getParam('id');

		//	$datasource = new Datasource_Table('market_offer');
			
			$datasource = new Logic_Datasource_App_Market_Offer_Query_Select();
		
			//$datasource = new Logic_Datasource_Advert_Offer();

			$row = $datasource->fetchRow(array('market_offer.id'=>$id))->getRow();
			
			//print_r($row);
			//exit();


			

			//echo $form->style;
			$form->setData($row);

			break;



		default:
			break;
	}






}


function App_Market_Offer_Ui_Form_onSubmit(){
	$test = 'd';

	/*@var $form Ui_Form */

	$form = ui::getCurrentUiElement();
	$validator = new Validate_Form();
	$form_data = null;

	$acl = Registry::get('acl');;
	$window = Registry::get('window');
	$inout = Registry::get('inout');
	$session = Registry::get('session');


	$id = $form->getId();


	//$form->setActionType('edit');
	switch ($form->getActionType()){


		case Ui_Form::Type_Form_Action_ADD:

			if($validator->validateForm($form)){

				//$form->setSuccessStatus(1);

				$form_data = $form->getData();

				$datasource = new Datasource_Table('market_offer');
				
				
				if($id = $datasource->insertRow($form_data)){

					
					
					$inout->setRedirectUrl('/app/Market/Offers');

				}else{

					$form->setErrorMessage("Error!");

				}

			}else		$form->setSuccessStatus(0);






			break;

		case Ui_Form::Type_Form_Action_EDIT:




			if($validator->validateForm($form)){

				//$form->setSuccessStatus(1);

				
				$id = (int) $form->getField('id')->getValueString();
				
				if(!$id)  throw new Exception_Application('Primary key not set');
				
				//print_r($_POST);
				//echo $id;
				//exit();
				//$form->removeField('id');
				
				$form_data = $form->getData();
				unset($form_data['id']);
				

				//print_r($form_data);
				
				$datasource = new Datasource_Table('market_offer');
				//$datasource->insertRow()
				
				if($datasource->updateRow(array('id'=>$id),$form_data)){

					$form->setStatus(Ui_Element::Type_Status_Success);
					

				}else{

					$form->setStatus(Ui_Element::Type_Status_Not_Success);

				}

			}else		$form->setSuccessStatus(0);





			break;

		case Ui_Form::Type_Form_Action_VIEW:

			/*	$data = $acl->getUser()->getData();
			$form->setData($data);
			*/
			break;

		case Ui_Form::Type_Form_Action_CLOSE :

			//$inout->setRedirectUrl('/app/User/List');
			break;

		default:
			throw new Exception_Logic('Unknown form type: '.$form->getType());
			break;


	}
	//	$form->setParam('url',$form_url_string);

	Log_Output::add(print_r($errors,1));

}

