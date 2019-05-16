<?php
global $Config;

require_once $Config->SitePath.'/application/models/directory.php';
require_once $Config->SitePath.'/application/models/directoryuser.php';
require_once $Config->SitePath.'/application/models/directoryitem.php';
require_once $Config->SitePath.'/application/models/location.php';


class IndexController extends Rad_Zend_Controller_Action
{
	protected $_view = null;

	public function init()
	{
		// maps to arg 'view' from: $frontController->setParam('view', $view);
		parent::init();
		$this->_view = $this->getInvokeArg('view');


		$this->_view->setModuleName('default');
		$Node = new Rad_Tree_Node();
		$Node->initByAlias('available_services');
		$this->_view->services = $Node->getChildNodes(true,true);

		/*		if(@$_SESSION['user'] && is_object($User= unserialize($_SESSION['user']))){


		$this->_view->User = $User;


		}else $this->_view->User = new FrontendUser();*/



	}

	// the default action is "indexAction", unless explcitly set to something else
	public function indexAction(){
		//if($this->_view->User->isLogined('RegisteredUser')) die('d');

		$this->_forward('node',null,null,array('alias'=>'pages'));
	}
	public function usersAction(){


		$GridName = 'admin_users';
		$Grid = new CGrid($GridName);



		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Clear search params',new Rad_Link(array('admin','listings'),array('clear'=>1)));

		$this->_view->Actions = $Menu->getActionsMenu();


		$defaultNamespace = new Zend_Session_Namespace();
		if($this->_getParam('post')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$GridName = $Params;

		}elseif ($this->_getParam('clear')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$GridName = null;
		}else $Params = $defaultNamespace->$GridName;

		$this->_view->Params = $Params;
		$RegisteredUser = new RegisteredUser();

		$Users=$RegisteredUser->getUsersList($Params);


		$Grid->addData($Users);
		$this->_view->Grid= $Grid;

		$this->_response->appendBody($this->_view->render('users.tpl'));


	}
	public function listingsAction(){

		$DirTree = new DirectoryTree();
		$Cats =& $DirTree->getConvertedTreeArray(true);
		$this->_view->Cats = $Cats[-1];

		$GridName = 'admin_items';
		$Grid = new CGrid($GridName);
		$item = new Barefoot_Item();

		global $InOut;
		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Clear search params',new Rad_Link(array('admin','listings'),array('clear'=>1)));
		$this->_view->Actions = $Menu->getActionsMenu();


		$defaultNamespace = new Zend_Session_Namespace();
		if($this->_getParam('post')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$GridName = $Params;

		}elseif ($this->_getParam('clear')){
			$Params = $this->_getAllParams();
			$defaultNamespace->$GridName = null;
		}else $Params = $defaultNamespace->$GridName;

		$this->_view->Params = $Params;
		$Result = $item->getItemsSimple($Params);





		$Grid->addData($Result->Data);
		$this->_view->Grid= $Grid;

		$this->_response->appendBody($this->_view->render('listings.tpl'));


	}
	public function categoriesAction()
	{

		global $Config;

		global $InOut;
		// STAGE 3.  Choose, create, and optionally update models using business logic.
		$this->_view->Types = DirectoryItem::getItemTypes();

		$this->_view->StartLink  =  $Config->Hostname;

		$this->_view->HostName  =   $Config->Hostname;




		$DirTree = new DirectoryTree();
		$Cats =& $DirTree->getConvertedTreeArray(true);


		//print_r($Cats[-1]);
		$Cid = $InOut->gvar('cid');
		$Search = $InOut->gvar('search');
		$this->_view->cid  = $Cid;
		$Housing =& $Cats[-1]['a_tree'][0];

		$SaleItems =& $Cats[-1]['a_tree'][1];
		$Jobs =& $Cats[-1]['a_tree'][2];

		$this->_view->Page = 'index';
		$this->_view->Housing = $Housing;
		$this->_view->Jobs = $Jobs;
		$this->_view->SaleItems = $SaleItems;

		$this->_view->Tree = $Cats[-1];



		// STAGE 5. Choose view and submit presentation model to view.
		$this->_response->appendBody($this->_view->render('index.tpl'));
	}

	// redirect bogus URLs back to the application's "home" page
	public function noRouteAction()
	{
		$this->_redirect('/');
	}
	public function bankingAction(){
		global $Config;

		$node = new Rad_Tree_Node();
		$Alias = $this->_getParam('service');
		if(!$node->initByAlias($Alias)) $this->_redirect('/');

		switch ($Alias){
			case 'deposit':
				$Listing = new Deposit_Item();
				break;
			case 'credit':
				$Listing = new Credit_Item();
				break;
			default:

				$Listing = new Custom_Item(array('node'=>$node));

				break;

		}


		$Form = new Rad_Form();
		$Source = new Rad_Form_Xml_Source();
		global $Config;
		$Source->setDir('/forms/');
		$Source->FormName = 'search_form'.$node->getId();
		if(!$Source->init()) {
			throw new Exception('Calculator fields not generated for servive '.$node->Data['short_description']);
		}

		$Form->initFromXmlSource($Source);
		global $Db;
		$Params = new Rad_Form_Params();
		$Params->setFormCustomObject($Form);
		require_once $Config->SitePath.'/application/models/banking/currencies.php';
		$Purpose = new Banking_Purposes();
		$Purposes = $Purpose->getItems();
		//$Params->setPredefinedFieldValue('purpose_id',$Purposes);

		$Currency = new Banking_Currencies();

		$Currencies = $Currency->getItems();
		//	$Db->unsetRanges();





		$Grid = new CGrid();

		$Grid->GridId = 'search_grid'.$node->getId();
		$Grid->XmlDirPath = $Config->SitePath.'/application/grids/';
		if(!$Grid->init()) throw new Exception('Grid not found');
		$grid_field = $Grid->addField();
		$grid_field->Header = 'Действие';
		$grid_field->ID = '#view';
		$grid_field->setIsAdditional();;
		$grid_field->setTitle('просмотреть');
		$grid_field->setLink($Config->Hostname.'/go/item/');
		$grid_field->setLinkParams('listing_id','listing_id');





		//	print_r($items);


		$Listing->setForm($Form);




		$this->_view->params = $_POST;
		$this->_view->items = $items;
		$Params->setPredefinedFieldValue('currency_id',$Currencies);
		$Form->getField('currency_id')->ListValue = $Currencies;
		$Form->getField('purpose_id')->ListValue = $Purposes;

		foreach ($Form->getFields() as $f){

			/*@var $f Rad_Form_Field*/
			if(preg_match('/list\_(.*)/',$f->ID,$rez)){

				$ListNode = new Rad_Tree_Node();
				$ListNode->init($rez[1]);
				$f->ListValue =  $ListNode->getItems(new Datatype_Item(),10,array('join_secondary_table'=>1));



			}
		}


		$Params->Action = Form2::InsertAction ;


		if($Result  = $this->parseFormExt($Params)){

			if($this->User->isLogined('RegisteredUser')) {
				list($SearchResult,$VaryResult) = $Listing->searchBanking($node->getId(),$Listing->getTypeId(),$Form);
				$this->_view->items = $SearchResult;
				$this->_view->vary = $VaryResult;
				$Grid->addData($SearchResult);
			}
			else {
				$Listing->setParam('is_advert',1);
				$this->_view->vary = $VaryResult;
				list($SearchResult,$VaryResult) = $Listing->searchBanking($node->getId(),$Listing->getTypeId(),$Form);
				$this->_view->items = $SearchResult;
				$this->_view->vary = $VaryResult;
				//s	print_r($VaryResult);
				$Grid->addData($SearchResult);
				//$this->_view->items = $Listing->search($node->getId(),null,$Listing->getTypeId(),$_POST,true,true,true);


			}

		}
		$this->_view->Grid= $Grid;

		$this->_response->appendBody($this->_view->render('banking.tpl'));
	}
	public function itemAction(){

		$Id = (int) $this->_getParam('listing_id');
		if(!$Id) $this->_redirect('/');

		if($this->_getParam('cart')) $this->User->Searches->addListingSearch('default',$Id);
		$ServiceNode = new Rad_Tree_Node();
		$NodeId = Rad_Tree_Node::getNodeIdByItemId($Id);

		$ServiceNode->init($NodeId);

		$Params = new Rad_Form_Params();
		$Params->Action = Form2::UpdateAction;
		/*$Listing = Rad_Directory_Record::getInstanceById($Id);

		$Listing->init($Id);*/
		$Listing = Rad_Directory_Record::getInstanceById($Id);

		$Listing->init($Id,null,array('node'=>$ServiceNode));
		$this->_view->Listing = $Listing;
		if(!$Listing->isInitSuccess())  $this->_redirect('/');


		global $Config;
		require_once $Config->SitePath.'/application/models/banking/currencies.php';

		
		$Form = new Form2(null,null);
		$Form->isSingleForm = true;
		global $Config;
		$Form->LoadDataFile($Config->SitePath.'/application/forms/fullview_form'.$NodeId.'.xml');
		$Form->Action = Form2::ViewAction ;
		$AddXml = $Listing->getXmlAdditionalFields();
		$Form->proceedFields(Form2::ViewAction,$AddXml,$Listing->getFormData());


		foreach ($Form->FormFieldListObj->FieldList as $f){
			/*@var $f FormField*/


		
			
			if($f->ID == 'bluser_id'){
				$_User = new PartnerUser();

				
				$Form->FormFieldListObj->addListDataToField($f->ID,$_User->getUsersList());
				
			}elseif ($f->ID == 'purpose_id'){
				$Purpose = new Banking_Purposes();
				$Purposes = $Purpose->getItems();
				$Form->FormFieldListObj->addListDataToField($f->ID,$Purposes);
			}elseif ($f->ID == 'currency_id'){
				$Currency = new Banking_Currencies();

				$Currencies = $Currency->getItems();
				$Form->FormFieldListObj->addListDataToField($f->ID,$Currencies);


			}elseif (preg_match('/list\_(.*)/',$f->ID,$rez)){
				$ListNode = new Rad_Tree_Node();
				$ListNode->init($rez[1]);
			
				$Form->FormFieldListObj->addListDataToField($f->ID,$ListNode->getItems(new Datatype_Item(),10,array('join_secondary_table'=>1)));
			}
		}




		;


;
		






		$Params->setObject($Listing);

		if($Result  = $this->parseForm(new Rad_Form_Params(),$Form)){


		}
		$this->_response->appendBody($this->_view->render('listing.tpl'));




	}
	public function errorAction(){
		$this->_response->appendBody($this->_view->render('error.tpl'));
	}
	public function commentsAction(){
		$ListingId  = (int) $this->_getParam('id');
		if(!$ListingId) $this->_redirect('/index/error/');
		$Listing = new Article_Item();
		$Listing->init($ListingId);

		$Node = new Rad_Tree_Node();

		if(!$Node->initByAlias('comments_'.$ListingId)){
			$ParentNode = new Rad_Tree_Node();
			if(!$ParentNode->initByAlias('comments')) $this->_redirect('/index/error/');

			$ParentNode->insertFormObject(array('short_description'=>'comments for listing №'.$ListingId,'alias'=>'comments_'.$ListingId));
			if(!$Node->initByAlias('comments_'.$ListingId)) $this->_redirect('/index/error/');


		}

		if($Node->Data && $Listing->isInitSuccess()) {

			$this->_view->Listing = $Listing;
			$Grid = new CGrid();
			$Grid->setPath('/application/grids/');
			$Grid->init('comments');
			$this->_view->Items = $Node->getItems(new Article_Item(),10);

			$this->_view->Grid = $Grid;


		}else $this->_redirect('/index/error/');

		$Form = new Rad_Form();
		$source = new Rad_Form_Xml_Source();
		$source->init('comment');
		$Form->initFromXmlSource($source);

		if($Result = $this->proceedForm($Form)){
			$Data = $Form->getFormValues();
			$Article = new Article_Item();


			$Id = $Article->insertFormObject($Data);


			//			$Article->init($Id);

			$Node->insertRecord($Article);;
			$this->_redirect('/go/comments/?id='.$ListingId);
		}
		$this->_response->appendBody($this->_view->render('comments.tpl'));
	}
	public function nodeAction(){

		$nodeId = (int) $this->_getParam('node_id');
		$AliasFlag = false;
		$Service = $this->_getParam('service');
		$Alias = $this->_getParam('alias');


		if($Service ) {


			$this->_forward('banking');
			$this->_view->UsePath = 1;
			$this->_view->search = 1;
			return ;
		}elseif ($Alias == 'comments'){
			$this->_forward('comments');
			return ;
		}elseif ($Alias == 'item'){
			$this->_forward('item');
			return ;
		}elseif ($Alias== 'cart'){

			$this->_forward('cart','UserController');
		}

		$NewsNode = new Rad_Page_Node();
		$NewsNode->initByAlias('news');
		$this->_view->NewsNode = $NewsNode;


		$Node = new Rad_Page_Node();

		if($Alias){
			if(!$Node->initByAlias($Alias)) $this->_redirect('/');
		}
		elseif ($nodeId) {



			if(!$Node->init($nodeId)) $this->_redirect('/');

		}
		//	$Node->getItems(null,null);
		if($Alias == 'pages') $this->_view->path = 1;
		else{
			$Tree = new DirectoryTree();
			$this->_view->path = $Tree->getPathArrayToCid($Node->getId());
		}

		$this->_view->Record = $Node;

		$this->_response->appendBody($this->_view->render('index.tpl'));

	}
	public function recordAction(){
		$id = (int) $this->_getParam('record_id');
		if(!$id) $this->_redirect('/');
		$Record = Rad_Directory_Record::getInstanceById($id);


		$this->_view->RecordAction = 1;
		$Tree = new DirectoryTree();
		$Cats =& Rad_Directory_Record::getCategoryIdByItemId($id);
		if(!$Cats) $this->_redirect('/');
		$Node = new Rad_Tree_Node();
		$NodeId = $Cats[0]['category_id'];
		$Node->init($NodeId);
		$Record->init($id,null,array('node'=>$Node));





		$this->_view->path = $Tree->getPathArrayToCid($NodeId);

		$Tree = new DirectoryTree();
		$Path = $Tree->getPathArrayToCid($Node->getId());
		if($Path[0]['alias'] == 'available_services' && count($Path) >1) $this->_redirect('/');

		$this->_view->Record = $Record;


		$this->_response->appendBody($this->_view->render('index.tpl'));

	}
	public function testAction(){
		$this->_response->appendBody($this->_view->render('wow.tpl'));

	}
}
?>