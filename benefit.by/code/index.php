<?php   
//session_start();
//ini_set("include_path", ":/home/radadmin/public_html/zf/library");


require_once 'Zend/Session.php';
error_reporting(E_ALL ^ E_NOTICE);
Zend_Session::start();

require_once 'Zend/Session/Namespace.php';
$defaultNamespace = new Zend_Session_Namespace();
//$defaultNamespace->setExpirationSeconds('');

if (!isset($defaultNamespace->initialized)) {
	Zend_Session::regenerateId();
	$defaultNamespace->initialized = true;
}


//echo (iconv("UTF-8", "UTF-8",'&#x50C43;&#x43C43;&#x3AC38;'));
//die();

define("FRONTEND",0);
define("BACKEND",1);

function Debug($a,$b){

}
require_once('3rd_party/rad/config.class.php');
require_once('3rd_party/rad/rad_ui_params.php');
require_once('3rd_party/rad/rad_ui_result.php');
require_once('3rd_party/rad/db.class.php');
require_once('3rd_party/rad/inoutdata.class.php');
require_once('3rd_party/rad/filemanager.php');
require_once('3rd_party/rad/form_proccess/form2.php');
require_once('3rd_party/rad/irad_page_item.php');
require_once('3rd_party/rad/tree/tree.php');
require_once('3rd_party/rad/grid/cgrid.php');
require_once('3rd_party/rad/raduser.php');
require_once('3rd_party/rad/rad_file.php');
require_once('3rd_party/rad/ui/rad_ui.php');

require_once('3rd_party/rad/radquery/raddbquery.php');
require_once('3rd_party/rad/rad_item.php');

require_once('3rd_party/rad/rad_message.php');

require_once('3rd_party/rad/xmlcore.php');
require_once('application/models/ucenter/frontenduser.php');
require_once('application/models/ucenter/registereduser.php');
require_once('application/models/ucenter/adminuser.php');
require_once('application/models/custom_item.php');






$InOut = new InOutData();
$Config = new Config();
$Config->SitePath = dirname(realpath($_SERVER['SCRIPT_FILENAME']));
//$Config->Hostname .= '/benefit';


require_once 'Zend/Loader.php';
//moving from radmaster db to Zend_Db
/*require_once 'Zend/Db.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

$zdb = new Zend_Db_Adapter_Pdo_Mysql(array(
    'host'     => $Config->DbHost,
    'username' => $Config->DbLogin,
    'password' => $Config->DbPassword,
    'dbname'   => $Config->DbName
));*/



//$Db = new Rad_Db_Moving_to_Zend_Db();

//$Db->link = $zdb->getConnection();
$Db = new cDB();
if(!$Db->connect($Config->DbName,$Config->DbHost,$Config->DbLogin,$Config->DbPassword)) die('couldn\'t connect to database!');
Zend_Loader::loadClass('Zend_Registry');
//Zend_Loader::loadClass('Zend_Db_Table_Abstract');
//Zend_Registry::set('zdb',$zdb);
//Zend_Registry::set('raddb',$Db);
//Zend_Db_Table_Abstract::setDefaultAdapter($zdb);
require_once 'application/models/location.php';

//define('CURRENT_LOCATION_ID',Location::getCurrentLocationId());
$Db->query('SET NAMES utf8');
define('DEBUG',0);

define('ADMIN_EMAIL_ADDRESS','dd@dd.com');


bootstrap(); // i.e. run the main program!

function bootstrap()
{
	global $Config;
	//   require 'Zend/Version.php';
	/*    if (Zend_Version::compareVersion('0.9.0') > 0) {
	echo "Please upgrade to a newer version of ZF for this demo.\n";
	}
	*/
	// STAGE 1. Prepare the front (primary) controller.

	$cwd = realpath(dirname(__FILE__));
	define('ROOT_PATH',$cwd);
	require 'Zend/Controller/Front.php';
	require_once('./includes/rad_zend_controller_action.php');
	$frontController = Zend_Controller_Front::getInstance(); // manages the overall workflow

	$router = $frontController->getRouter(); // по умолчанию возвращает rewrite router
	$node_route = new Zend_Controller_Router_Route(
	'content/node/:node_id',
	array(
	'controller' => 'index',
	'action'     => 'node'
	)
	);
	$record_route = new Zend_Controller_Router_Route(
	'content/record/:record_id',
	array(
	'controller' => 'index',
	'action'     => 'record'
	)
	);
	$alias_route = new Zend_Controller_Router_Route(
	'go/:alias',
	array(
	'controller' => 'index',
	'action'     => 'node'
	)
	);
		$service_route = new Zend_Controller_Router_Route(
	'service/:service',
	array(
	'controller' => 'index',
	'action'     => 'node'
	)
	);
		$router->addRoute('service_route', $service_route);

	$router->addRoute('node', $node_route);
		$router->addRoute('record', $record_route);
		$router->addRoute('alias_route', $alias_route);
		


	$frontController->setControllerDirectory(ROOT_PATH.'/application/controllers/');


	$frontController->setControllerDirectory(array(
	'default' => $Config->SitePath.'/application/controllers/',
	'admin'    => $Config->SitePath.'/application/modules/admin/controllers/'

	));


	
	$frontController->setDefaultControllerName('index');
	$frontController->setDefaultAction('index');

	$frontController->setParam('useDefaultControllerAlways', false);
	Zend_Controller_Action_HelperBroker::removeHelper('viewRenderer');
	$frontController->setParam('noViewRenderer', true);

	//$frontController->setControllerDirectory($cwd);
	//$frontController->setParam('useDefaultControllerAlways', true);//

	
	/*@var $Request Zend_Controller_Request_Abstract*/
	//	$Request = $frontController->getRequest();
	//	global $Config;
	
		
    
		
		

	// Initialize views
	require_once('Zend/View.php');
	require($Config->SitePath.'/includes/smarty_zend_view.php');

	$view = new Zend_View_Smarty();
	$view->setPreScriptPath($Config->SitePath.'/application/views/'); // defaults to same location as controller (bug: default not working)
	//$view->setScriptPath($cwd.'/application/views/frontend/_index/');
	//$view->setScriptPath($cwd.'/application/views/frontend/directory/');

	$defaultNamespace = new Zend_Session_Namespace();

	if(@$_SESSION['user'] && is_object($User= unserialize($_SESSION['user']))){

		$view->User = $User;



	}else $view->User = new FrontendUser();

	$view->Config = $Config;
	$frontController->setParam('view', $view);


	// STAGE 2. Find the right action and execute it.
	$frontController->returnResponse(true); // return the response (do not echo it)


	// Dispatch calculated actions of the selected controllers
	$response = $frontController->dispatch(); // similar to "running" the configured MVC "program"

	// STAGES 3 to 5 occur in IndexController.php
	//   STAGE 3: Choose, create, and optionally update models using business logic.
	//   STAGE 4: Apply business logic to create a presentation model for the view.
	//   STAGE 5: Choose view template and submit presentation model to view template for rendering.

	// STAGE 6 occurs in indexIndex.tpl.php
	//   STAGE 6: Render results in response to request.

	// STAGE 7. Render results in response to request.
	$response->renderExceptions(true); // show any excpetions in the visible output (i.e. debug mode)
	$response->sendResponse(); // send final results to browser, including headers
}

?>