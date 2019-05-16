<?php
global $Config;
require_once $Config->SitePath.'/application/models/directory.php';
require_once $Config->SitePath.'/application/models/directoryuser.php';
require_once $Config->SitePath.'/application/models/directoryitem.php';
require_once $Config->SitePath.'/application/models/location.php';
require_once $Config->SitePath.'/3rd_party/rad/rad_menu.php';


class Admin_NodeController extends Rad_Zend_Controller_Action {


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
		$this->_view->IndexTemplate = 'index_admin.tpl';
		if(!$this->User->isLogined('AdminUser') && $this->_view->action != 'login'){
			//	$this->_redirect('/admin/index/login/');
		}



	}

	/*	public function clearAction(){
	$dir = new DirectoryTree();
	$dir->createRootRecord();
	}*/
	public function nodesAction(){


		$SessionKey = $this->getActionSid();

		$defaultNamespace = new Zend_Session_Namespace();

		if($this->_getParam('node_id')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$SessionKey = $Params;

		}elseif ($this->_getParam('clear')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$SessionKey  = null;
		}else $Params = $defaultNamespace->$SessionKey ;

		$this->_view->Params = $Params;

		$cid = (int) $Params['node_id'];
		if(!$cid) $cid = 1;
		global $InOut;
		$Tree = new DirectoryTree();


		$Path = $Tree->getPathArrayToCid($cid);


		$GridName  = 'admin_categories';
		$Menu = new Rad_Menu();
		if($Path[0]['alias'] == 'available_services' && count($Path) == 1){

			$Menu->addActionMenuItem('Добавить услугу',new Rad_Link(array('admin','banking','add_service')));

		}elseif ($Path[0]['alias'] == 'available_services' && count($Path) > 1){

			$Menu->addActionMenuItem('Добавить запись',new Rad_Link(array('admin','node','listing'),array('type'=>$cid,'a'=>'add','node_id'=>$cid)));
			$Menu->addActionMenuItem('Калькулятор',new Rad_Link(array('admin','banking','create_calculator'),array('type'=>$cid)));

		}elseif ($Path[1]['alias'] == 'system_datatypes' && count($Path) > 3){


			$Menu->addActionMenuItem('Добавить запись',new Rad_Link(array('admin','node','listing'),array('type'=>'datatype','a'=>'add','node_id'=>$cid)));
		}elseif ($Path[1]['alias'] == 'forms_calculator'){
			$Node = new Rad_File_Node();
			$Node->init($cid);
			
		}
		else {

			$Menu->addActionMenuItem('add category',new Rad_Link(array('admin','node','node'),array('a'=>'add','cid'=>$cid)));
			$Menu->addActionMenuItem('add static page',new Rad_Link(array('admin','node','listing'),array('type'=>'static','a'=>'add','node_id'=>$cid)));

		}

		if(!$Node){
			$Node = new Rad_Tree_Node();
			$Node->init($cid);
		}



		$InOut->setObligatoryUrlParam('node_id',$cid);


	

		$this->_view->Actions = $Menu->getActionsMenu();

		$Grid = new CGrid($GridName);


		//echo $GridName;
		$Cats =& $Node->getChildNodes(true);
		$this->_view->TreePath = $Tree->getPathArrayToCid($cid,1);


		$this->_view->cid = $cid;
		$Grid->addData($Cats);
		$this->_view->Grid= $Grid;


		if($this->_getParam('error') == 'has_childs'){
			$this->_view->Message  = 'This category has childs!';
		}
		$this->_response->appendBody($this->_view->render('nodes.tpl'));


	}


	public function nodeAction(){

		$Id = (int) $this->_getParam('cid');
		if(!$Id) $this->_redirect('/error/');


		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Back',new Rad_Link(array('admin','node','nodes')));
		$this->_view->Actions = $Menu->getActionsMenu();
		global $InOut;

		$Tree = new DirectoryTree();
		$Category = $Tree->getCategory($Id);
		if($this->_getParam('delete')){
			//check for childs

			global $Db;


			$Db->DoNotUseListQuery = 1;
			$Cats =& $Tree->getBranch($Id);
			$Parent =& $Tree->getParentCategory($Id);
			$ParentId = $Parent['category_id'];


			//if true  - error

			if($Cats || $Category['is_locked'] || $Parent['alias'] == '_savailable_services'){
				$this->_redirect('/admin/node/nodes/?error=has_childs&node_id='.$ParentId);
			}

			$Tree->deleteCategory($Id);
			$this->_redirect('/admin/node/nodes/?node_id='.$ParentId);
		}

		$Node= new Rad_Tree_Node();



		$Params = new Rad_Form_Params();
		$Params->hasAdditionalFields = true;

		if($this->_getParam('a') == 'add' ){

			$Params->Action = Form2::InsertAction;

		}else {

			$Params->Action = Form2::UpdateAction;
			if($Category['is_locked']) $this->_redirect('/admin/node/nodes/?message=locked');
			$Node->Data = $Tree->getCategory($Id);

		}

		$Node->NodeId = $Id;
		$Source = new Rad_Form_Xml_Source();

		$Source->Class = 'admin';
		$Source->FormName = 'category';
		$Source->init();
		$Params->setSource($Source);



		$Source->AdditionalXml = $Node->getObjectProperties();

		$Params->setObject($Node);

		if($Result  = $this->parseForm($Params)){

			if($Params->Action == Form2::InsertAction ){
				$this->_redirect('/admin/node/nodes/?node_id='.$Id);
			}



		}


		$this->_response->appendBody($this->_view->render('node.tpl'));
	}
	public function listingsAction(){
		global $InOut;
		$cid = (int) $this->_getParam('cid');
		$Sid = $this->getActionSid();
		$DirTree = new DirectoryTree();
		$Cats =& $DirTree->getConvertedTreeArray(true);
		$this->_view->Cats = $Cats[-1];

		$GridName = 'admin_items';
		$Grid = new CGrid($GridName);
		
	
		if($cid < 0 ) $Node = new Rad_File_Node();
			
		else 	$Node = new Rad_Tree_Node();

	
		$InOut->setObligatoryUrlParam('node_id',$cid);
		
		
		global $InOut;
		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Clear search params',new Rad_Link(array('admin','node','nodes'),array('clear'=>1)));
		$this->_view->Actions = $Menu->getActionsMenu();


		$defaultNamespace = new Zend_Session_Namespace();
		if($this->_getParam('post')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$GridName = $Params;

		}elseif ($this->_getParam('clear')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$GridName = null;
		}else $Params = $defaultNamespace->$GridName;

		$Params['order'] = 'creation_date';
		$this->_view->Params = $Params;

		$item = new Article_Item();
		$Result = $item->getItemsSimple($Params);

	//	$Result = $Node->getItems(new Article_Item(),);




		$Grid->addData($Result->Data);
		$this->_view->Grid= $Grid;

		/*@var  $this->_view Zend_View_Smarty*/
		$this->_view->UseIndexTemplate = false;
		$this->_response->appendBody($this->_view->render('listings.tpl'));


	}



	public function listingAction(){

		$Id = (int) $this->_getParam('listing_id');

		$NodeId = (int) $this->_getParam('node_id');
		$Params = new Rad_Form_Params();


		$Type = $this->_getParam('type');
		if(!$Type) $Type = 'static';
		if(!$Id ){
			switch ($Type){


				case 'datatype':
					$Listing = new Datatype_Item();
					break;
				case 17:
					$Listing = new Credit_Item();
					break;
				case 16;
				$Listing = new Deposit_Item();
				break;


				case 'static' :
					$Listing = new Article_Item();
					break;

				default:
					$ServiceNode = new Rad_Tree_Node();
					$ServiceNode->init($Type);
					$Listing = new Custom_Item(array('node'=>$ServiceNode));


					break;
			}


			$Params->Action = Form2::InsertAction;



		}else {


			$Params->Action = Form2::UpdateAction;
			/*$Listing = Rad_Directory_Record::getInstanceById($Id);

			$Listing->init($Id);*/


			$ServiceNode = new Rad_Tree_Node();
			$NodeId = Rad_Tree_Node::getNodeIdByItemId($Id);

			$ServiceNode->init($NodeId);


			$Params->Action = Form2::UpdateAction;
			/*$Listing = Rad_Directory_Record::getInstanceById($Id);

			$Listing->init($Id);*/
			$Listing = Rad_Directory_Record::getInstanceById($Id);

			$Listing->init($Id,null,array('node'=>$ServiceNode));




		}





		$User = new PartnerUser();

		$Users = $User->getUsersList();

		$Params->setPredefinedFieldValue('bluser_id',$Users);

		global $Config;
		require_once $Config->SitePath.'/application/models/banking/currencies.php';
		$Purpose = new Banking_Purposes();
		$Purposes = $Purpose->getItems();
		$Params->setPredefinedFieldValue('purpose_id',$Purposes);

		$Currency = new Banking_Currencies();

		$Currencies = $Currency->getItems();



		$Params->setPredefinedFieldValue('currency_id',$Currencies);
		if($this->_getParam('delete')){
			$Listing->deleteItem();

			$this->_redirect('/admin/node/nodes/?node_id='.$NodeId);
		}
		$Menu = new Rad_Menu();
		if($this->_getParam('s')) $Menu->addActionMenuItem('Back',new Rad_Link(array('admin','banking','items')));
		else $Menu->addActionMenuItem('Back',new Rad_Link(array('admin','node','nodes')));
		$Menu->addActionMenuItem('Delete',new Rad_Link(array('admin','node','nodes'),array('listing_id'=>$Id,'delete'=>1)));
		$this->_view->Actions = $Menu->getActionsMenu();



		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'admin';
		if(!$Listing->FormName) $Source->FormName = 'listing';
		else $Source->FormName = $Listing->FormName;
		$Source->init();

		$AddXml = $Listing->getXmlAdditionalFields();

		if($AddXml) foreach (simplexml_load_string($AddXml)->xpath('//field') as $f){

			/*@var $f Rad_Form_Field*/
			$Id = (string) $f['id'];
			if(preg_match("/list\_(.*)/",$Id,$rez)){

				$ListNode = new Rad_Tree_Node();
				$ListNode->init($rez[1]);

				$Params->setPredefinedFieldValue($Id,$ListNode->getItems(new Datatype_Item(),10,array('join_secondary_table'=>1)));




			}
		}


		$Params->RemovedFields = $Listing->RemoveFormFields;
		$Params->setSource($Source);
		$Params->Source->AdditionalXml = $AddXml;
		$_User = new PartnerUser();

		$Params->setPredefinedFieldValue('bluser_id',$_User->getUsersList());


		if($Params->Action == Form2::UpdateAction ){

			$User = new RegisteredUser();

			$User->authUserById($Listing->Data['bluser_id']);

			$UserInfo  = $User->getUserInfoString();


			$Params->setPredefinedFieldValue('user',$UserInfo);

		}
		$Params->setObject($Listing);




		if($Result  = $this->parseForm($Params)){

			if($Params->Action == Form2::InsertAction){

				//add to Tree
				$Node = new Rad_Tree_Node();
				$Node->NodeId = $NodeId;
				$Node->insertRecord($Listing);
				if($this->_getParam('s')) $this->_redirect('/admin/banking/items/');
				else $this->_redirect('/admin/node/nodes/',array('node_id'=>$NodeId));
			}

		}



		$this->_response->appendBody($this->_view->render('listing.tpl'));
	}


}

?>