<?php
global $Config;
require_once $Config->SitePath.'/application/models/directory.php';
require_once $Config->SitePath.'/application/models/directoryuser.php';
require_once $Config->SitePath.'/application/models/directoryitem.php';
require_once $Config->SitePath.'/application/models/location.php';

class AuthController extends Rad_Zend_Controller_Action
{

	/**
	 * User object
	 *
	 * @var RegisteredUser
	 */
	protected $RadUser;
	protected $_view = null;

	public function init()
	{
		global $Config;

		$this->_view = $this->getInvokeArg('view');
		$this->_view->setModuleName('auth');



		$DirTree = new DirectoryTree();
		$Cats =& $DirTree->getConvertedTreeArray(true);
		$this->_view->Tree = $Cats[-1];
		$this->_view->Types = DirectoryItem::getItemTypes();
		//$this->_view->StartLink  =  'http://zend';
		$this->_view->StartLink  =  $Config->Hostname;
		//$this->_view->HostName  =  'http://zend';
		$this->_view->HostName  =  $Config->Hostname;

		$Locations =& Location::getLocations();
		$this->_view->Locations = $Locations;

		$this->RadUser = $this->_view->User;

		/*
		if(@$_SESSION['user'] && is_object($User= unserialize($_SESSION['user']))){


		$this->_view->User = $User;
		$this->RadUser = $User;


		}else $this->_view->User = new FrontendUser();*/


	}

	// the default action is "indexAction", unless explcitly set to something else
	public function indexAction()  {
		$this->_redirect('/');
	}

	public function registerAction()
	{

		global $Config;

		global $InOut;


		$this->_view->Page = 'Create an Account';

		$Form = new Form2('frontend_register','ucenter');
		$Form->proceedFields(Form2::InsertAction);
		$RegisteredUser  = new RegisteredUser();
	

		if($Form->isFormPost() && $Form->validateForm()){
			

			//check password and password_confirm
			if ($RegisteredUser->isLoginAlreadyRegistered('email',$Form->getField('email')->getValue())){

				$Form->getField('email')->setError('Email is already in the database, use \'Forgot My Password\' to get account details');


			}elseif ($RegisteredUser->isLoginAlreadyRegistered('login',$Form->getField('login')->getValue())){
				$Form->getField('login')->setError('Такой логин уже существует!');
			}
			elseif($Form->getField('password')->getValue() != $Form->getField('confirm_password')->getValue()){

				$Form->getField('password')->setError('Password and Password Confirm missmatch');
			}
			else{
				//	$Form->getField('')



				$PostData = $Form->getFormArrayExt();

				unset($PostData['confirm_password']);
				$PostData['sha_password'] = sha1($PostData['password']);
				unset($PostData['password']);


				$PostData['user_type'] = 'client';
				$Id = $RegisteredUser->addUser($PostData);

				$RegisteredUser->sendConfirmationEmail(md5($PostData['email'].$PostData['sha_password']),$PostData['email']);

				//$this->_redirect('/');
				$this->_response->appendBody($this->_view->render('register_ok.tpl'));
				return ;

			}
		}
		//print_r($Form->FormFieldListObj->getErrorsList());


		$this->_view->Form = $Form;



		// STAGE 5. Choose view and submit presentation model to view.
		$this->_response->appendBody($this->_view->render('register.tpl'));
	}

	private function RegisterSession(RegisteredUser $User){


		$_SESSION['user'] = serialize($User);


		$this->RadUser = $User;



	}
	private function unRegisterSession(){

		unset($_SESSION['user']);
	}

	public function AccountConfirmationAction(){

		global $InOut;
		if(!$sid = $InOut->gvar('sid')){
			$this->_redirect('/not_found');
		}

		$RegisteredUser = new RegisteredUser();
		$RegisteredUser->authByField('md5(CONCAT(email,sha_password))',$sid);
		//	global $Db;
		//	print_r($Db->getSqlLog());
		//	echo md5('9490580e9e57524552c7ff9ec9a7a1f22db79960');
		//die();



		if($RegisteredUser->isAuth()){


			$RegisteredUser->setActive();

			$this->RegisterSession($RegisteredUser);


			//	$this->_view->success = 1;

			//	$this->_response->appendBody($this->_view->render('account_confirmation.tpl'));


		}
		$this->_redirect('/');
	}


	public function logoutAction(){

		unset($_SESSION['user']);
		$this->_redirect('/');

	}
	/*public function loginAction(){

	global $InOut;

	$Login = $InOut->gvar('login');
	$Password = $InOut->gvar('password');

	$Output  = 'not_ok';
	if($Login && $Password) {
	$RegisteredUser = new RegisteredUser();

	if($RegisteredUser->authUser($Login,$Password,false)){

	if(!$RegisteredUser->UserData['user_is_active']){
	$Output = 'not_active';

	}else{
	$this->RegisterSession($RegisteredUser);

	$Output =  'ok';
	}


	}

	}

	ob_end_clean();
	echo $Output;

	exit();


	}*/

	public function loginAction(){

		$Params = new Rad_Form_Params();
		$Source = new Rad_Form_Xml_Source();
		$Source->Class = 'admin';
		$Source->FormName = 'login';
		$Params->setSource($Source);
		
		$Params->Action = Form2::InsertAction ;
		if($Result  = $this->parseForm($Params)){
			$Data =& $Result->_uiObject->getFormArrayExt();
		
			
			$Login = $Data['login'];
			$Password = $Data['password'];
			$RegisteredUser = new RegisteredUser();
			$RegisteredUser->setLoginField('login');
			if($RegisteredUser->authUser($Login,$Password,false)){
				
				$RealUser = $RegisteredUser->getExtendedUserObject();
				/*print_r($RealUser);
				die();*/
				$this->RegisterSession($RealUser);
				$this->_redirect('/');
				
			}else
			{
				
				$Result->_uiObject->getField('login')->setError('Wrong login/password');
			}


		}
		$this->_view->formname = $Source->FormName;
		$this->_response->appendBody($this->_view->render('login.tpl'));

	}
	public function forgotPasswordAction(){

		//$this->_view->UseIndexTemplate = false;

		$Form = new Form2('password_recover','ucenter');
		$Form->removeField('captcha');	
		$Form->proceedFields(Form2::InsertAction);


		
		$RegisteredUser = new RegisteredUser();
		if($Form->isFormPost() && $Form->validateForm()){
			$Email = $Form->getField('email')->getValue();

			$RegisteredUser->authByField('email',$Email);
			if(!$RegisteredUser->getUserId()){

				$Form->getField('email')->setError('We have no account with that email address.<br /> Please try again.');
			}



			else{
				//	$Form->getField('')





				$RegisteredUser->recoverPassword();

				$this->_view->success = 1;
				//$this->_redirect('/');
				//$this->_response->appendBody($this->_view->render('register_ok.tpl'));


			}
		}


		$this->_view->Form = $Form;



		$this->_response->appendBody($this->_view->render('forgot_password.tpl'));



	}

	public function resendAction(){


		$this->_view->UseIndexTemplate = false;

		$Form = new Form2('password_recover','ucenter');
		$Form->proceedFields(Form2::InsertAction);


		$RegisteredUser = new RegisteredUser();
		if($Form->isFormPost() && $Form->validateForm()){
			$Email = $Form->getField('email')->getValue();

			$RegisteredUser->authByField('email',$Email);
			if(!$RegisteredUser->isLogined()){

				$Form->getField('email')->setError('We have no account with that email address.<br /> Please try again.');
			}



			else{
				//	$Form->getField('')





				$RegisteredUser->sendConfirmationEmail(md5($Email.$RegisteredUser->UserData['sha_password']),$Email);

				$this->_view->success = 1;
				//$this->_redirect('/');
				//$this->_response->appendBody($this->_view->render('register_ok.tpl'));


			}
		}


		$this->_view->Form = $Form;



		$this->_response->appendBody($this->_view->render('resend_registration_email.tpl'));



	}
	public function myAccountAction(){



		if(!$this->RadUser->isUserDataLoaded()) $this->_redirect('/');

		$this->_view->Page = 'Edit an Account';

		$Form = new Form2('frontend_register','ucenter');
		$Form->proceedFields(Form2::InsertAction);

		if($Form->isFormPost() && !$_POST['password']){

			$Form->removeFieldAfter('password');
			$Form->removeFieldAfter('confirm_password');


		}
		$Form->assignDataToForm($this->RadUser->getUserData());

		if($Form->isFormPost() && $Form->validateForm()){





			//check password and password_confirm
			if ($this->RadUser->UserData['email'] != $Form->getField('email')->getValue() && $this->RadUser->isLoginAlreadyRegistered('email',$Form->getField('email')->getValue())){

				$Form->getField('email')->setError('Email is already in the database, use \'Forgot My Password\' to get account details');


			}
			elseif($Form->getField('password') && $Form->getField('password')->getValue() != $Form->getField('confirm_password')->getValue()){

				$Form->getField('password')->setError('Password and Password Confirm missmatch');
			}
			else{
				//	$Form->getField('')



				$PostData = $Form->getFormArrayExt();
				if(@$PostData['password']){
					unset($PostData['confirm_password']);
					$PostData['sha_password'] = sha1($PostData['password']);
					unset($PostData['password']);
				}


				$Id = $this->RadUser->updateUser($this->RadUser->getUserId(),$PostData);
				if($Id) {
					$this->RadUser->refreshUserData();
					$this->RegisterSession($this->RadUser);
				}
				$this->_view->success = 1;




			}
		}


		$this->_view->Form = $Form;


		$this->_response->appendBody($this->_view->render('my_account.tpl'));


	}
	public function getUserDataAction(){

		global $InOut;
		$Field = $InOut->gvar('field');
		$Output = 'no_name';
		$User = $this->_view->User;
		if($User && is_object($User) && $Field){
			/*@var $User RegisteredUser*/
			$Output =  @$User->UserData[$Field];

		}

		ob_end_clean();
		echo $Output;
		//print_r($_SESSION);
		exit();


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


}
?>