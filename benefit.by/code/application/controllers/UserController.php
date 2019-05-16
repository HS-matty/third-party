<?php
global $Config;
require_once $Config->SitePath.'/application/models/directory.php';
require_once $Config->SitePath.'/application/models/directoryuser.php';
require_once $Config->SitePath.'/application/models/directoryitem.php';
require_once $Config->SitePath.'/application/models/location.php';
require_once $Config->SitePath.'/3rd_party/rad/rad_menu.php';


class UserController extends Rad_Zend_Controller_Action {


	/**
	 * User object
	 *
	 * @var RegisteredUser
	 */
	protected $User;
	protected $_view = null;


	public function init()
	{
		global $Config;




		parent::init();
	
		if(!$this->User->isLogined('RegisteredUser') && $this->_view->action != 'login' &&   $this->_view->action != 'cart'){
				$this->_redirect('/auth/login/');
		}

		$this->_view->Controller = 'user';


	}

	/*	public function clearAction(){
	$dir = new DirectoryTree();
	$dir->createRootRecord();
	}*/
	
	public function addItemAction(){
		
		$Node = new Rad_Tree_Node();
		$Node->initByAlias('available_services');
		$this->_view->services  = $Node->getChildNodes(true,true);
		$this->_response->appendBody($this->_view->render('add.tpl'));
		
		
	}
	public function itemAction(){

		$Id = (int) $this->_getParam('listing_id');

		$NodeId = (int) $this->_getParam('type');

		
	
		$Params = new Rad_Form_Params();



		if(!$NodeId) $NodeId = '17';
		if(!$Id ){
			switch ($NodeId){
				case 17:
					$Listing = new Credit_Item();
					break;
				case 16;
				$Listing = new Deposit_Item();
				
				break;
				
							
				default:
					$ServiceNode = new Rad_Tree_Node();
					$ServiceNode->init($NodeId);
					$Listing = new Custom_Item(array('node'=>$ServiceNode));

					
					break;
			}


			
			$Action = Form2::InsertAction;



		}else {


			$Action = Form2::UpdateAction;
			/*$Listing = Rad_Directory_Record::getInstanceById($Id);

			$Listing->init($Id);*/
			
					
			$ServiceNode = new Rad_Tree_Node();
			$NodeId = Rad_Tree_Node::getNodeIdByItemId($Id);
			
			$ServiceNode->init($NodeId);
		
		
			$Action= Form2::UpdateAction;
			/*$Listing = Rad_Directory_Record::getInstanceById($Id);

			$Listing->init($Id);*/
			$Listing = Rad_Directory_Record::getInstanceById($Id);

			$Listing->init($Id,$this->User,array('node'=>$ServiceNode));
			

		



		}

		if(!$Listing->FormName) $FormName = 'listing';
		else $FormName = $Listing->FormName;
		$Form  = new Form2($FormName,'admin');
	
		

		

		$Form->removeField('bluser_id');
		$Form->removeField('is_active');
		$AddXml = $Listing->getXmlAdditionalFields();
		$AddData = $Form->parseAdditionalXmlFields($AddXml);
		
		$Form->proceedFields($Action);
		
		$Form->assignDataToForm($Listing->getFormData());
		
		
		
		$Params = new Rad_Form_Params();
		

		global $Config;
		require_once $Config->SitePath.'/application/models/banking/currencies.php';
		$Purpose = new Banking_Purposes();
		$Purposes = $Purpose->getItems();
		$Form->FormFieldListObj->addListDataToField('purpose_id',$Purposes);

		$Currency = new Banking_Currencies();

		$Currencies = $Currency->getItems();

		
		$Form->FormFieldListObj->addListDataToField('currency_id',$Currencies);


		 $Form->getField('long_description')->View->Type = 'textarea';
		



		if($Params->Action == Form2::UpdateAction ){

			
			$User = new RegisteredUser();

			$User->authUserById($Listing->Data['bluser_id']);

			$UserInfo  = $User->getUserInfoString();


			

		}else $Params->ProceedData = false;
		//$Params->setObject($Listing);

		


		

		if($Result  = $this->parseForm($Params,$Form)){

			$Data = $Result->_uiObject->getFormArrayExt();
			$Data['bluser_id'] = $this->User->getUserId();
			
			if($Action == Form2::InsertAction){
				$Listing->insertFormObject($Data);
				//add to Tree
				$Node = new Rad_Tree_Node();
				 $Node->NodeId = $NodeId;
			
				$Node->insertRecord($Listing);
	/*			print_r($Listing);
				print_r($Node);*/

				 $this->_redirect('/user/items/?service='.$NodeId);
			}elseif ($Action == Form2::UpdateAction ){
				$Listing->updateFormObject($Data);
				$this->_redirect('/user/items/?service='.$NodeId);
				
			}

		}



		$this->_response->appendBody($this->_view->render('listing.tpl'));
	}
	public function cartAction(){
		$id = (int) $this->_getParam('id');
	//	$this->User->Searches->deleteFolder('default');
		$delete = $this->_getParam('delete');
		if($id && $delete) $this->User->Searches->deleteListingSearch('default',$id);
		
		$item_keys = $this->User->Searches->getItems('default');
		$Listing = new Rad_Directory_Record();
		if($item_keys) $this->_view->Items = $Listing->getItemsByKeys($item_keys);
		//print_r($this->_view->Items);
		 $this->_response->appendBody($this->_view->render('cart.tpl'));
	} 
	public function editAction(){
		
		
		
		$Id = (int) $this->User->getUserId();

		$NodeId = (int) $this->_getParam('node_id');
		$Params = new Rad_Form_Params();

		

		$Params->Action = Form2::UpdateAction ;



	






		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'ucenter';
		$Source->FormName = 'frontend_register';

		$Params->RemovedFields = array('password','confirm_password','login');


		$Params->setSource($Source);



		

		$Params->setObject($this->User);

		if($Result  = $this->parseForm($Params)){
			if($Params->Action = Form2::UpdateAction ){
				
				
				

			}

		}

		$this->_response->appendBody($this->_view->render('form.tpl'));
		
		
	}

	public function itemsAction(){
		
		global $Config;
		require_once $Config->SitePath.'/application/models/directory.php';
		require_once $Config->SitePath.'/application/models/custom_item.php';
		$Grid = new CGrid('user_items2');





		$Tree = new DirectoryTree();
		$Node  = new Rad_Tree_Node();
		$Node->initByAlias('available_services');
		

		$this->_view->services = $Node->getChildNodes(true);
		$this->proceedGridSessionData();
		 $ServiceType = $this->_getParam('service');
		if(!$ServiceType) $ServiceType = 16;

		switch ($ServiceType){
			case '16':
				$Item = new Deposit_Item();
				$NodeId = 16;
				break;
			default:
				$ServiceType = 'credit';
			case '17':
				$NodeId = 17;
				
				$Item = new Credit_Item();
				break;
			default:
			
				$ServiceNode = new Rad_Tree_Node();
				$ServiceNode->init($ServiceType);
				
				$Item = new Custom_Item(array('node'=>$ServiceNode));
				$NodeId= $ServiceType;

		}
		 $this->_view->service = $ServiceType;

	

		$this->_view->service = $ServiceType;
		$User = new PartnerUser();
		$Items =&  $Item->getItemsSimpleExt(array('user_id'=>$this->User->getUserId(),'use_item_type'=>true,'join_secondary_table'=>true));

		$Grid->addData($Items);
		$this->_view->Grid= $Grid;


		$this->_response->appendBody($this->_view->render('services.tpl'));
	}
	





}

?>