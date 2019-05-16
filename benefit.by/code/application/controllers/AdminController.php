<?php
global $Config;
require_once $Config->SitePath.'/application/models/directory.php';
require_once $Config->SitePath.'/application/models/directoryuser.php';
require_once $Config->SitePath.'/application/models/directoryitem.php';
require_once $Config->SitePath.'/application/models/location.php';
require_once $Config->SitePath.'/3rd_party/rad/rad_menu.php';


class AdminController extends Zend_Controller_Action
{

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



		$this->_view = $this->getInvokeArg('view');

		$this->_view->action = $this->_request->getActionName();
		$this->User= $this->_view->User;
		$this->_view->IndexTemplate = 'index_admin.tpl';
		if(!$this->User->isLogined('AdminUser') && $this->_view->action != 'login'){
			$this->_redirect('/admin/login/');
		}

		$this->_view->setModuleName('admin');


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
	public function regionsAction(){

		$DirTree = new DirectoryTree();
		$Cats =& $DirTree->getConvertedTreeArray(true);
		$this->_view->Cats = $Cats[-1];

		$GridName = 'admin_locations';
		$Grid = new CGrid($GridName);
		$Loc = new Location();

		global $InOut;
		$Menu = new Rad_Menu();
$Menu->addActionMenuItem('Add region',new Rad_Link(array('admin','location'),array('a'=>'add')));
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
		$Data =& $Loc->getLocationsExt();





		$Grid->addData($Data);
		$this->_view->Grid= $Grid;

		$this->_response->appendBody($this->_view->render('regions.tpl'));


	}
	public function categoriesAction(){


		$Menu = new Rad_Menu();

		$cid = (int) $this->_getParam('category_id');
		if(!$cid) $cid = 1;
		global $InOut;
		$InOut->setObligatoryUrlParam('category_id',$cid);
		$Menu->addActionMenuItem('Add category',new Rad_Link(array('admin','category'),array('a'=>'add','cid'=>$cid)));

		$this->_view->Actions = $Menu->getActionsMenu();

		$Grid = new CGrid('admin_categories');
		$Tree = new DirectoryTree();
		$Cats =& $Tree->getCategories($cid);
		$this->_view->TreePath = $Tree->getPathArrayToCid($cid,1);


		$Grid->addData($Cats);
		$this->_view->Grid= $Grid;


		if($this->_getParam('error') == 'has_childs'){
			$this->_view->Message  = 'This category has childs!';
		}
		$this->_response->appendBody($this->_view->render('categories.tpl'));


	}



	public function userAction(){

		
		
		$Id = (int) $this->_getParam('bluser_id');
		if(!$Id) $this->_redirect('/error/');
		
		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Back',new Rad_Link(array('admin','users')));

		$Menu->addActionMenuItem('Delete',new Rad_Link(array('admin','user'),array('bluser_id'=>$Id,'delete'=>1)));
		
		$this->_view->Actions = $Menu->getActionsMenu();
		$this->_view->user_id = $Id;
		$RegisteredUser = new RegisteredUser();
		$RegisteredUser->authUserById($Id);

		if($this->_getParam('delete')){
			
			$Listing = new Rad_Directory_Record();
			$Listing->deleteItems($RegisteredUser);
			$RegisteredUser->deleteUser($Id);
			$this->_redirect('/admin/users/');
		}
		$this->_view->Stats = $RegisteredUser->getItemsStats();

		
		$Params = new Rad_Form_Params();
		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'admin';
		$Source->FormName = 'user';
		$Params->setSource($Source);
		$Params->Action = Form2::UpdateAction;

		$Params->setObject($RegisteredUser);
		if($Result  = $this->parseForm($Params)){



		}

		$this->_response->appendBody($this->_view->render('user.tpl'));
	}

	public function categoryAction(){

		$Id = (int) $this->_getParam('cid');
		if(!$Id) $this->_redirect('/error/');
		
		global $InOut;
		
		$Tree = new DirectoryTree();
		if($this->_getParam('delete')){
			//check for childs 
		
			global $Db;
			$Db->DoNotUseListQuery = 1;
			$Cats =& $Tree->getBranch($Id);
			$Parent =& $Tree->getParentCategory($Id);
			$ParentId = $Parent['category_id'];
			
			//if true  - error
			if($Cats){
				$this->_redirect('/admin/categories/?error=has_childs&category_id='.$ParentId);
			}
			$Tree->deleteCategory($Id);
			$this->_redirect('/admin/categories/?category_id='.$ParentId);
		}
		
		$Node= new Rad_Tree_Node();


		$Params = new Rad_Form_Params();


		if($this->_getParam('a') == 'add' ){

			$Params->Action = Form2::InsertAction;

		}else {

			$Params->Action = Form2::UpdateAction;
			$Node->Data = $Tree->getCategory($Id);

		}

		$Node->Id = $Id;
		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'admin';
		$Source->FormName = 'category';
		$Params->setSource($Source);


		$Params->setObject($Node);

		if($Result  = $this->parseForm($Params)){

			if($Params->Action == Form2::InsertAction ){
				$this->_redirect('/admin/categories/?category_id='.$Id);
			}



		}

		$this->_response->appendBody($this->_view->render('login.tpl'));
	}

	public function locationAction(){

		$Id = (int) $this->_getParam('location_id');
		

		

		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Back',new Rad_Link(array('admin','regions')));
		$this->_view->Actions = $Menu->getActionsMenu();
		$Params = new Rad_Form_Params();

		$Location = new Location();
		$Location->LocationId = $Id;
		if($this->_getParam('a') == 'add' ){

			$Params->Action = Form2::InsertAction;

		}else {

			$Params->Action = Form2::UpdateAction;
			

		}

	
		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'admin';
		$Source->FormName = 'location';
		$Params->setSource($Source);


		$Params->setObject($Location);

		if($Result  = $this->parseForm($Params)){

			if($Params->Action == Form2::InsertAction ){
				$this->_redirect('/admin/regions/');
			}



		}

		$this->_response->appendBody($this->_view->render('login.tpl'));
	}


	public function listingAction(){

		$Id = (int) $this->_getParam('listing_id');
		if(!$Id) $this->_redirect('/error/');
		$Listing = Rad_Directory_Record::getInstanceById($Id);
		$Listing->init($Id);

		if($this->_getParam('delete')){
			$Listing->deleteItem();
			$this->_redirect('/admin/listings/');
		}
		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Back',new Rad_Link(array('admin','listings')));
		$Menu->addActionMenuItem('Delete',new Rad_Link(array('admin','listing'),array('listing_id'=>$Id,'delete'=>1)));
		$this->_view->Actions = $Menu->getActionsMenu();


		$Params = new Rad_Form_Params();
		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'admin';
		$Source->FormName = 'listing';

		$AddXml = $Listing->getXmlAdditionalFields();

		$Params->AdditionalXml = $AddXml;


		$Params->setSource($Source);
		$Params->Action = Form2::UpdateAction;


		$User = new RegisteredUser();
		$User->authUserById($Listing->Data['bluser_id']);
		$UserInfo  = $User->getUserInfoString();
		$Params->setPredefinedFieldValue('user',$UserInfo);
		$Params->setObject($Listing);

		if($Result  = $this->parseForm($Params)){



		}

		$this->_response->appendBody($this->_view->render('listing.tpl'));
	}


	public function loginAction(){

		$Params = new Rad_Form_Params();
		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'admin';
		$Source->FormName = 'login';
		$Params->setSource($Source);
		$Params->Action = Form2::InsertAction ;
		if($Result  = $this->parseForm($Params)){
			$Data =& $Result->Form->getFormArrayExt();
			if($Data['login'] == 'login' && $Data['password'] = 'password'){
				$_SESSION['user'] = serialize(new AdminUser());
				$this->_redirect('/admin/');
			}else
			{
				$Result->Form->getField('login')->setError('Wrong login/password');
			}


		}

		$this->_response->appendBody($this->_view->render('login.tpl'));

	}
	public function logoutAction(){
		$this->User->logout();
		$this->_redirect('/');

	}


	public function browseCategoriesAction(){
		$Cid = (int) $this->_getParam('cid');
		if(!$Cid) $Cid = 1;

		$DirTree= new DirectoryTree();
		$this->_view->TreePath = $DirTree->getPathArrayToCid($Cid,1);

		$this->_view->PathStr = $DirTree->getPathArrayToCidString($Cid);

		$this->_view->Categories  = $DirTree->getCategories($Cid);

		$Node =& $DirTree->getCategory($Cid);;
		$this->_view->Node = $Node;



		$this->_view->IndexTemplate  = 'popup_index.tpl';
		$this->_view->id = $this->_getParam('id');

		$this->_response->appendBody($this->_view->render('browse_categories.tpl'));


	}







	// the default action is "indexAction", unless explcitly set to something else
	public function indexAction()  {
		$RegisteredUser = new RegisteredUser();
		$this->_view->UsersStats = $RegisteredUser->getTotalUsersStats();
		$Item  = new Rad_Directory_Record();
		$this->_view->ItemsStats = $Item->getTotalItemsStats();
		$this->_response->appendBody($this->_view->render('index.tpl'));
	}


	// redirect bogus URLs back to the application's "home" page
	public function noRouteAction()
	{
		$this->_redirect('/');
	}




	public function __call($methodName, $args)
	{
		if (empty($methodName)) {
			$msg = 'No action specified and no default action has been defined in __call() for '
			. get_class($this);
		} else {

			$this->_redirect('/not_found');
		}

		throw new Zend_Controller_Action_Exception($msg);
	}



	/**
	 * Function which parses all forms in the admin area
	 *
	 * @param Rad_Form_Params $Params
	 * @return Rad_Form_Result
	 */
	protected function parseForm(Rad_Form_Params $Params){


		$Form = new Form2($Params->Source->FormName,$Params->Source->Class);

		if($Params->Object){
			//$Data = $Form->assignDataToForm($Params->Object->getFormData());
			$Data = $Params->Object->getFormData();
		}else $Data = null;


		if($Params->AdditionalXml){

			$Form->parseAdditionalXmlFields($Params->AdditionalXml);
		}

		$Form->proceedFields($Params->Action,null,$Data);



		//print_r($Params->PredefinedFieldValues);

		if($Params->PredefinedFieldValues) 		$Form->FormFieldListObj->setFormValues($Params->PredefinedFieldValues);

		//	print_r($Form->FormFieldListObj->FieldList);
		//	die();
		$this->_view->Form  = $Form;


		if($Form->isFormPost()){
			if( $Form->validateForm()){

				$Result = new Rad_Form_Result();
				$Result->setForm($Form);

				if($Params->ProceedData && $Params->Object){

					switch ($Params->Action){
						case Form2::InsertAction :

							$Params->Object->insertFormObject($Form->getFormArrayExt());
							break;
						case Form2::UpdateAction :
							$Params->Object->updateFormObject($Form->getFormArrayExt());

							break;
					}
					$Result->isSuccess = true;

					$this->_view->success = 2;


				}

				return $Result;

			}else {
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
}
?>