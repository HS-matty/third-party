<?php
/*********************************************************************
************       	  web-sys  ver. 2.3            *******************
************      Sergey Volchek  2013-2014        *******************
************		    matt1@open.by	    	   *******************
********************************************************************/
ob_start();




if($_REQUEST['is_debug']){

	$_SESSION['is_debug'] = 1;

}

/*if($_SESSION['is_debug']){
define('IS_DEV',true);
}else define('IS_DEV',false);
*/
//define('IS_DEV',$_SESSION['is_debug']);

$path_site = dirname(__FILE__);
define('PATH_ROOT',$path_site);
require_once(PATH_ROOT.'/@include/constants.php');
require_once(PATH_ROOT.'/@include/settings.php');
require_once(PATH_ROOT.'/@include/functions.php');
require_once(PATH_INCLUDE.'/classes.php');



Registry::set('ui_type',UI_DEFAULT);

//$hash = sha1('12345678');
//echo $hash;
//exit();

$output = new Output('output',true);
$output->setType('html');

Registry::set('output',$output);
Registry::set('debug_level',$debug_level);

$fdd = 33;


function _run(){






	$output = Registry::get('output');
	Std_Class::setDefaultPath(PATH_ROOT);;
	Url::setDefaultHostname(HOST_NAME);


	$registry = Registry::getInstance();



	$header = $output->getParam('header');
	$header->addElement()->setValue('Content-Type: text/html; charset=utf-8');


	$log = new Logic_Log('log',true);
	$config = new Config('config',true);
	$config->setParam('lang','en');




	//db settings

	require_once(PATH_INCLUDE.'/db.php');
	require_once(PATH_INCLUDE.'/Steam-Settings.php');


	$time_start = microtime_float();






	$debug_level = Registry::get('debug_level');
	$log->setDebugLevel($debug_level);;
	$log->addMessage('start');
	$debug =& $log;





	$inout = new InOut();


	$dev = new Dev();

	Registry::set('dev',$dev);
	Registry::set('inout',$inout);
	Registry::set('lang','en');
	Registry::set('debug',$log->getDebugLevel());
	Registry::set('secure_mode_flag',1); // for non-front pages



	require_once(PATH_INCLUDE.'/db_connect.php');



	$router = new Router();

	Registry::set('router',$router);


	require_once(PATH_INCLUDE.'/routes.php');





	//mail('byqdes@gmail.com','test','test');
	//exit();

	
	
	
	//php-session 
	$session = new Session('session',true);





	/* @var $acl Acl */

	$acl = new Logic_Acl();



	Registry::set('acl',$acl);



	/*@var $user Logic_Class_User */



	//get session_id from php-session

//	$session_acl_user_session_id = null;
	$session_acl_user_session_id = (int) $session->getParam('acl_user_session_id');
	//echo $session_acl_user_session_id;
	//exit();
	//$session_acl_user_session_id = 118;
	$acl_user_session_id = $session_acl_user_session_id;


	// Database session
	
	$acl_user_session = new Logic_Class_App_Acl_User_Session();



	///	$acl_user_session_id = 96;



	Registry::set('Acl_User_Session',$acl_user_session);



	$is_auth_passed = false;


	//$acl_token_user_id = null;


	$user = $acl_user_session->getUser();
	
	
	
	if($acl_user_session_id){
		
		$acl_user_session->load($acl_user_session_id);
		$acl_session_id = $acl_user_session->getId();
		if(!$acl_session_id || $acl_user_session->isClosed() ) {

			$session->unsetParam('acl_user_session_id');
			



			//throw new Exception('session not loaded!: ');
		}else{

			//load user

			$acl_user_id = $acl_user_session->getFieldValue('acl_user_id');

			$user->setTypeBackend();

			$user->authById($acl_user_id);
			if($user->getId()) $is_auth_passed = true;

			//else throw new Exception('Couldnt load user with ID: '.$acl_user_id);
		}

	}


	if(!$is_auth_passed)  {

		$user->setTypeFrontend();
		$acl_user_session->loadPublicSession(); //start new public session
		$user->authAsGuest();
		//do not save the public user id in da php-session =)
		$is_register_session = false;

	}

	//php session
	//	$session->setParam('acl_user_session_id',$session_id);

	//$_session->finish();


	//	$event_stuct = new Logic_Class_App_Acl_User_Event_Struct();
	//	$event_stuct->setStruct('start','description',current_datetime(),$acl_user_session->getId());
	//	event($event_stuct);


	//$is_register_session = true;


	
/*	if($hash = $inout->getParam('hash')){

		$user->authByHash($hash);

		if(IS_DEBUG_MODE) $is_register_session = true;
		else $is_register_session = false;

	}*/
	/*
	if(!$user->getId() && $is_register_session && $session_id = $session->getParam('session_id')){

	$user->authBySessionId($session_id);



	}elseif(!$user->getId()) {


	$user->authAsGuest();
	}*/

	
	
	//register user in acl (including setting saving id in php-session)
	
	//print_r($user->getModel()->getData());
	//exit();
	
	Logic_Acl::aclRegisterUser($user,$is_register_session);




	
	//echo $user->getType();
	//exit();


	//Logic_Acl::sendWelcomeMessage($user);


	$config->setParam('hostname','http://'.$_SERVER['SERVER_NAME']);

	/*$user = new Logic_Model_User_Steam();
	$user->auth_by_steam_id(1);
	*/
	//parse incoming _get params
	$request_uri = $_SERVER['REQUEST_URI'];
	$request_host= $_SERVER['HTTP_HOST'];

	$uri_array = split('\?',$request_uri);

	$request_uri = $uri_array[0];
	$request_uri_params = $uri_array[1];




	$log->addMessage('requested uri: '.$request_uri);

	//$request = new Request('request',true);


	if(strlen($request_uri) >1 && $uri_params = split('\/',$request_uri)){

		array_shift($uri_params);

	}else $uri_params = array();


	//check for redirect =)

	if(strtolower(@$uri_params[0]) == 'redirect'){
		Registry::set('is_redirect',1);
		array_shift($uri_params);
	}

	//if user not logined



	if(!$user->getModel()->getId() && !empty($uri_params) && false){

		$uri_params = array('auth','login');

	}
	elseif(empty($uri_params)){


		$uri_params = array('');

	}

	if(empty($uri_params[count($uri_params)-1])) array_pop($uri_params);


	$request = Element::fromArray($uri_params);

	$request->setParam('uri_string',$request_uri);
	$request->setParam('uri_params_string',$request_uri_params);

	Registry::set('request',$request);

	foreach ($_REQUEST as $key=>$val){

		$request->setParam($key,$val);

	}



	$page = new Logic_Ui_Page('page',true);
	//$inout->template_index = '_index.tpl';


	$page->addParam('debug_template',Registry::get('debug_template'));


	//todo remove,make compose it
	//$page->setParam('back_url',$back_url);
	//$page->addParam('class_params_string',$uri_params[0]);
	$page->addParam('user',$user);
	$page->addParam('log',$log);
	$page->addParam('is_success',$inout->is_success);
	$page->addParam('debug',$log->getDebugLevel());
	$page->addParam('log',$log);
	$page->addParam('ui',$ui);
	$page->addParam('tpl',new Logic_Ui_Template());
	$page->addParam('dev',$dev);
	$page->addParam('host_name',HOST_NAME);
	$index = 1;


	//	Logic_Acl::sendWelcomeMessage($user);
	//	exit();


	//$_user = Logic_Class_User::_init(array());

	//print_r($_user);
	//exit();


	$app_file = PATH_APP.'/Default.php';

	$output_string = null ;
	$output = Registry::get('output');


	//Ui handler - things like grid paging, sorting and etc..

	require_once('App/_ui_handler.php');
	_handle_ui();



	if(file_exists($app_file)) {


		require_once(PATH_APP.'/_predefined.php');
		proceed_prefined_page_params();


		require_once($app_file);



		/* @var $app App_Default */


		try {

			$i = 0;
			while($i < 3){
				/*var $app App_Default*/

				//		$shell = new Sys_Shell();

				//		$shell->exec('/devstudio.php',array('import'));


				$app = App_Default::exec();

				if($internal_redirect_params = $router->getParam('internal_redirect')){

					$uri_params = array();


				}else
				break;

				$i++;

			}




		}catch (Logic_Exception $e){

			//	$inout->setRedirectUrl($config->Hostname);
			//	$log->addMessage($e->getMessage());
			echo "<h2>catched logic exception:</h2>";
			echo $e->getMessage().'<br>';
			echo '<br><br><br>'. var_dump($e->getTrace());
			echo '<br> file:'. $e->getFile();;
			echo '<br> line:'. $e->getLine();;

			exit();

		}catch (Exception_Db $e){

			//	$inout->setRedirectUrl($config->Hostname);
			//	$log->addMessage($e->getMessage());
			echo "<h2>catched logic exception:</h2>";
			echo $e->getMessage().'<br>';
			echo '<br><br><br>'. var_dump($e->getTrace());
			echo '<br> file:'. $e->getFile();;
			echo '<br> line:'. $e->getLine();;

			exit();

		}catch (Exception $e){

			//	$inout->setRedirectUrl($config->Hostname);
			//	$log->addMessage($e->getMessage());

			echo '<br><br><h3>'.$e->getMessage().'</h3><br>';
			echo '<br> file:'. $e->getFile();;
			echo '<br> line:'. $e->getLine();;
			//echo '<br><br><br>'. var_dump($e->getTrace());
			exit();

		}





	}else {

		$inout->setRedirectUrl('/');
		//not found
	}


	$is_return = false;

	$output = Registry::get('output');

	if($redirect_url = $inout->getRedirectUrl()){

		$inout->redirectUrl($redirect_url);


	}elseif(Registry::get('output')->getType() == 'html') {



		$path_template = PATH_TEMPLATE_INDEX;

		$ui_type = Registry::get('ui_type');


		if($ui_type) $path_template .= '/'.$ui_type;
		else  $path_template = PATH_TEMPLATE_DEFAULT;
		//		echo PATH_TEMPLATE;
		//	exit();


		//echo $path_template;
		//exit();
		/*@var $page Logic_Ui_Page */
		$page = Registry::get('page');

		/*@var $template Logic_Template_Smarty*/

		$template = $page->getTemplate();

		$template->addParam('host_name',$config->getParam('hostname'));
		$template->addParam('HostName',$Config->Hostname);
		$template->addParam('request_uri',$request_uri);

		$window = Registry::get('window');
		$log = Registry::get('log');

		$template->addParam('window',$window);
		$template->addParam('app',$app);
		$template->addParam('registry',Registry::getInstance());
		$template->addParam('page',$page);
		$template->addParam('log',$log);


		if($template_index = $page->getDefaultTemplateName()){

			$template_index = $path_template.'/'.$template_index;
		}
		elseif (@$inout->template_index){
			$template_index = $path_template.'/'.$inout->template_index;
		}

		else $template_index  = $path_template.'/index.tpl';


		//		echo $template_index;
		//		exit();
		if(!is_readable($template_index)){

			//default index tpl set
			$template_index  = $path_template.'/_index.tpl';

		}
		if($inout->tpl_sub){

			$template_sub =  $path_template.'/'.$application_name.'/'.$inout->tpl_sub;
			//else $template_sub = PATH_TEMPLATE.'/'.$inout->tpl_sub;
		}elseif ($static_page = $page->getStaticPage()){
			
			$template_sub =  PATH_ROOT.$static_page;
			
		}
			
		else{

			/*@var $app App_Default */


			
			
			
			
			
			$template_sub = $path_template.'/';
			$class_params = Registry::get('class_params');
			foreach ($class_params as $class_param){

				$template_sub .=  $class_param.'/';
			}





			if($template_file_name = $page->getParam('template_file')){
				$template_sub .= $template_file_name;
				
			}elseif ($template_name = $page->getParam('template_name')){
				$template_sub .= ucfirst($template_name).'.tpl';
			
			

			}else{
				$template_sub = rtrim($template_sub,'/'); // =)))))))))
				$template_sub .= '.tpl';
			}
			//echo $template_sub;
			//exit();


		}


		
		if(!is_readable($template_sub)){

			$log_message = 'sub template '.$template_sub.' not found.';
			$template_sub = $path_template.'/__default.tpl';
			//else $template_sub = PATH_TEMPLATE.'/default.tpl';
			$log_message .= ' Using '.$template_sub;
			$log->addMessage($log_message);
		}


		$page->addParam('sub_page',$template_sub);

		$page->addParam('template_base_path',$path_template);
		//exit($path_template);

		if($page->getParam('template_left_delimiter')){

			$template->setTemplateDelimiter($page->getParam('template_left_delimiter'),$page->getParam('template_right_delimiter'));
		}

		$template_sub_html = $template->compile($template_sub);

		$template->setTemplateDelimiter();


		$page->addParam('sub_page_html',$template_sub_html);



		$_sys_out = ob_get_contents();

		ob_clean();


		foreach ($header->getElements() as $e){
			header($e->getValue());
		}

		$template->addParam('sys_out',$_sys_out);
		$log->addMessage('end');


		$html = $template->compile(($template_index));


		$time_end  = microtime_float();

		$time = $time_end - $time_start;


		if(false && $log->getDebugLevel()){
			$html .= "<br><font color='blue'>generated ~ {$time} sec</font>";

		}



		$output_string =& $html;

	}elseif (Registry::get('output')->getType() == 'text'){


		$output_string = '';
		foreach (Registry::get('output') as $line){

			$output_string .= $line.PHP_EOL;
		}
		$output_string .= $output->getValue().PHP_EOL;


	}elseif (Registry::get('output')->getType() == 'console'){

		ob_clean();
		ob_start();

		echo 'just started .'.$app->getModule()->getCurrentClassName();

		$output_string = ob_get_contents();

		ob_clean();
		//echo  'swswwwswsw';
		$is_return = true;
	}elseif ($output->getType() == 'json'){
		$output_string = $output->getValueString();


	}

	return $output_string;

}

if($output->getType() != 'console'){
	$output_string = _run();
	echo $output_string;
}else {

	//echo '';

}

function _run_test(){

	return '1234';
}

function __autoload($class_name) {


	$is_found = null;

	//check for simple/alias classes

	$file = PATH_LOGIC.'/Class/@/'.$class_name.'.php';

	if(!file_exists($file)) $file = getClassNameFile($class_name);



	if(file_exists($file)){
		require_once($file);
	}

	/// class cache {

	elseif(ereg('^Element_',$class_name) || ($first_char == strtoupper($class_name[0])) && !ereg('^App',$class_name) ){

		$file = PATH_APP_DATA.'/_tmp/class_cache/'.$class_name.'.php';
		if(!file_exists($file)){


			if($class_array = split('_',$class_name)){
				if($class_array[0] && $class_array[1] && count($class_array) > 2) $parent_class = $class_array[0].'_'.$class_array[1];
				else $parent_class = 'Std_Class';
			}


			$class_string = "<?php class {$class_name} extends {$parent_class} {}?>";
			//file_put_contents($file,$class_string);

		}


		require_once($file);


	}else{
		throw new Exception('Couldnt load file '.$file.' for class '.$class_name);
	}
}




function isClassExists($class_name){

	$file = getClassNameFile($class_name);

	return file_exists($file);


}



function getClassNameFile($class_name){

	$class_name_array = explode("_",$class_name);
	$class_name_parsed = '';

	if(count($class_name_array) > 1){


		//get class path
		$count = count($class_name_array);

		foreach ($class_name_array as $key=> $_class_name){
			if($key > 0) $class_name_parsed .= '/';

			$_class_name = ucfirst(strtolower($_class_name));

			//if Directory-Name /Table , /Query make it /_Table, /_Query

			if(($class_name_array[0] == 'Logic') && ($_class_name == 'Table' || $_class_name == 'Query') && ($key != $count-1) ){
				$_class_name = '_'.$_class_name;
			}

			if(@$class_name_array[0] == 'App' && ($_class_name == 'Ui' || $_class_name == 'Default')) $_class_name = '@'.$_class_name;
			$class_name_parsed .= $_class_name;
		}


		if((@$class_name_array[0] == 'App'  ||  @$class_name_array[0] == 'Model' || @$class_name_array[0] == 'Logic') && (count($class_name_array) > 2) ){

			$file = PATH_ROOT.'/'.$class_name_parsed.'.php';


		}else	$file = PATH_LIB_RADMASTER.'/'.$class_name_parsed.'.php';




	}else 	$file = PATH_LIB_RADMASTER.'/'.$class_name.'.php'; //$file = PATH_LIB.'/radmaster/lib/'.$class_name.'.php';


	return $file;


}



class File_Exception extends Exception {

}

class Db_Exception extends Exception {

}

class Exception_Db extends Exception {

}
class Ui_Exception extends Exception {

}



class Acl_Exception extends Exception {

}

class Class_Exception extends Exception {

}

class Exception_Call extends  Exception {

}


class Exception_Application extends Exception {


}


class Exception_App extends Exception {

}


class Exception_Logic extends Exception {
	
}

class Exception_Model extends Exception {

}


class Exception_Datasource extends Exception {

}


class Exception_Logic_Model extends Exception_Logic  {

}



class Exception_Logic_Class extends Exception_Logic  {

}


class Exception_App_Finance extends Exception {
	
}

//require_once($class_name) . '.php';



	/*$acl_user_event  = new Logic_Datasource_App_Acl_User_Event_Table;
	$test = array('name'=>'test event','description'=>'test decription','datetime'=>'NOW()','acl_user_session_id'=>1);
	$acl_user_event->insertRow($test);*/

	//$acl_user_event = new Logic_Model_App_Acl_User_Event();
	//	$acl_user_event = new Logic_Class_App_Acl_User_Event();


	//	$test = array('name'=>'__test event_','description'=>'test decription_','datetime'=>'NOW()','acl_user_session_id'=>1);
	//	$acl_user_event->getModel('Event')->add($test);
	//$acl_user_event->add($test);

	//	$test_token = array('name'=>'___test token','description'=>'test decription','datetime'=>'NOW()','start_datetime'=>'NOW()','end_datetime'=>'NOW()','acl_user_id'=>1,'value'=>'test_token');

	//	$token = new Logic_Class_App_Acl_User_Token();

	//	$token->getModel('Token')->add($test_token);


	//$user_session  = new Logic_Class_App_Acl_User_Session();

	//$user_session->load(2);
	//$user_session->start();
	//$user_session->finish();


	//exit('dd');
	//	$acl_user_token  = new Logic_Datasource_App_Acl_User_Token_Table();
	//	$test_token = array('name'=>'test token','description'=>'test decription','datetime'=>'NOW()','start_datetime'=>'NOW()','end_datetime'=>'NOW()','acl_user_id'=>1,'value'=>'test_token');
	//	$acl_user_token->insertRow($test_token);


?>