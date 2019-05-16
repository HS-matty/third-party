<?php
global $Config;



class ErrorController extends Zend_Controller_Action
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

		//die('Page not found');


		///	$this->_view->action = $this->_request->getActionName();

		//	$this->_view->$IndexTemplate = 'admin_index.tpl';
		$this->User= $this->_view->User;


	}

	public function errorAction()
	{
		
		$errors = $this->_getParam('error_handler');
		//print_r($errors);


		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				// ошибка 404 - не найден контроллер или действие
				
				//$this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');

				echo 'Page not found!';
				exit();
				
				// ... получение данных для отображения...
				break;
			default:
				// ошибка приложения; выводим страницу ошибки,
				// но не меняем код статуса

				// ...

				// Журналируем исключение:
				$exception = $errors->exception;
				Zend_Loader::loadClass('Zend_Log');
				Zend_Loader::loadClass('Zend_Log_Writer_Stream');
				$log = new Zend_Log(new Zend_Log_Writer_Stream('/tmp/applicationException.log'));
				$log->debug($exception->getMessage() . "\n" .  $exception->getTraceAsString());
				echo 'Internal error!';
				//exit();
				break;
		}
	}















	// the default action is "indexAction", unless explcitly set to something else
	public function indexAction()  {

	}


	// redirect bogus URLs back to the application's "home" page
	public function noRouteAction()
	{
		$this->_redirect('/');
	}




	public function __call($methodName, $args)
	{


		throw new Zend_Controller_Action_Exception($msg);
	}


}
?>