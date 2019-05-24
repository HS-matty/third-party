<?php
/*********************************************************************
************       	  web-sys  ver. 2.3            *******************
************      Sergey Volchek  2013-2014        *******************
************		    matt1@open.by	    	   *******************
********************************************************************/

ob_start();
$path_site = dirname(__FILE__);
define('PATH_ROOT',$path_site);

require_once(PATH_ROOT.'/@include/constants.php');
require_once(PATH_ROOT.'/@include/settings.php');
require_once(PATH_ROOT.'/@include/functions.php');
require_once(PATH_INCLUDE.'/classes.php');


$registry = Registry::getInstance();

$output = new Output('output',true);

$header = $output->getParam('header');
$header->addElement()->setValue('Content-Type: text/html; charset=utf-8');
$output->setType('html');

$log = new Log('log',true);
$config = new Config('config',true);
$config->setParam('lang','en');

//db settings

require_once(PATH_INCLUDE.'/db.php');


$time_start = microtime_float();


$log->setDebugLevel($debug_level);
$log->addMessage('start');
$debug =& $log;


$inout = new InOut();
Registry::set('inout',$inout);
Registry::set('lang','en');




$router = new Element('router',true);

$session = new Session('session',true);

$hash = md5('123456'); //e10adc3949ba59abbe56e057f20f883e

$income_hash = $inout->getParam('hash');


/*if($hash == $income_hash){

	$user = new User();
	$user->id  = '666';
}*/

if($user = $session->getParam('user')){
	$user = unserialize($user);
	Registry::set('user',$user);
}
/*if(!$session->getParam('user_id') && !$user){

	$user = new User;



}
*/

$config->setParam('hostname','http://'.$_SERVER['SERVER_NAME']);


//parse incoming _get params
$request_uri = $_SERVER['REQUEST_URI'];
$request_host= $_SERVER['HTTP_HOST'];

$uri_array = split('\?',$request_uri);
$request_uri = $uri_array[0];

$log->addMessage('requested uri: '.$request_uri);

//$request = new Request('request',true);


if(strlen($request_uri) >1 && $uri_params = split('\/',$request_uri)){

	array_shift($uri_params);

}else $uri_params = array();



//if user not logined


if(!$user->id && !empty($uri_params)){

	$uri_params = array('auth','login');

}
elseif(empty($uri_params)){


	$uri_params = array('front');

}

if(empty($uri_params[count($uri_params)-1])) array_pop($uri_params);


$request = Element::fromArray($uri_params);

Registry::set('request',$request);

foreach ($_REQUEST as $key=>$val){

	$request->setParam($key,$val);

}



$page = new Ui_Page('page',true);
$inout->template_index = 'index_autopay.tpl';

//$page->addParam('class_params_string',$uri_params[0]);
$page->addParam('user',$user);
$page->addParam('log',$log);
$page->addParam('is_success',$inout->is_success);
$page->addParam('user',$user);
$page->addParam('debug',$debug);
$page->addParam('ui',$ui);
$page->addParam('tpl',new Template());

$index = 1;



$app_file = PATH_APP.'/default.php';

$output_string = null ;
$output = Registry::get('output');


//Ui handler - things like grid paging, sorting and etc..

require_once('app/_ui_handler.php');
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




	}catch (Exception $e){

		//	$inout->setRedirectUrl($config->Hostname);
		//	$log->addMessage($e->getMessage());
		echo $e->getMessage();
		echo '<br><br><br>'. var_dump($e->getTrace());
		exit();

	}





}else {

	$inout->setRedirectUrl('/');
	//not found
}

if($redirect_url = $inout->getRedirectUrl()){

	$inout->redirectUrl($redirect_url);


}elseif(Registry::get('output')->getType() == 'html') {




	require_once(PATH_LIB.'/smarty/Smarty.class.php');



	$smarty  = new Smarty();

	$smarty->caching = false;


	$smarty->compile_dir = PATH_APP_DATA.'/_tmp/smarty/templates_c';
	$smarty->config_dir = PATH_APP_DATA.'/_tmp/smarty/configs';
	$smarty->cache_dir =  PATH_APP_DATA.'/_tmp/smarty/cache';
	$smarty->template_dir = PATH_TEMPLATE;

	$smarty->assign('host_name',$config->getParam('hostname'));
	$smarty->assign('HostName',$Config->Hostname);
	$window = Registry::get('window');
	$smarty->assign('window',$window);
	$smarty->assign('app',$app);

	$smarty->assign('registry',Registry::getInstance());

	$smarty->assign('page',$page);



	if(@$inout->template_index) $template_index = PATH_TEMPLATE.'/'.$inout->template_index;

	else $template_index  = PATH_TEMPLATE.'/index.tpl';


	if(!is_readable($template_index)){

		//default index tpl set
		$template_index  = PATH_TEMPLATE.'/_index.tpl';

	}
	if($inout->tpl_sub){

		$template_sub =  PATH_TEMPLATE.'/'.$application_name.'/'.$inout->tpl_sub;
		//else $template_sub = PATH_TEMPLATE.'/'.$inout->tpl_sub;
	}
	else{

		/*@var $app App_Default */
		//	if($group_name) $template_sub = PATH_TEMPLATE.'/'.$group_name.'/'.$application_name.'/'.$action_name.'.tpl';
		//$template_sub = PATH_TEMPLATE.'/'.$application_name.'/'.$action_name.'.tpl';
		//	$class_params = $app->getClassParams();
		$template_sub = PATH_TEMPLATE.'/';
		foreach ($request->getElements() as $el){
			
			if($el->hasElements()){
				
				foreach ($el->getElements() as $_el){
					
					$template_sub .=  $_el->getName().'/';
				}
			}else $template_sub .=  $el->getName().'/';
			
						
		}

		$template_sub = rtrim($template_sub,'/'); // =)))))))))
		$template_sub .= '.tpl';
		

	}

	if(!is_readable($template_sub)){

		$log_message = 'sub template '.$template_sub.' not found.';
		$template_sub = PATH_TEMPLATE.'/__default.tpl';
		//else $template_sub = PATH_TEMPLATE.'/default.tpl';
		$log_message .= ' Using '.$template_sub;
		$log->addMessage($log_message);
	}


	$page->addParam('sub_page',$template_sub);



	$params =& $page->getParams();
	foreach ($params as $key => $value) {
		$smarty->assign($key,$value);
	}




	$_sys_out = ob_get_contents();

	ob_clean();;
	
	foreach ($header->getElements() as $e){
		header($e->getValue());
	}
	
	$smarty->assign('sys_out',$_sys_out);
	$log->addMessage('end');
	$html = $smarty->fetch($template_index);


	$time_end  = microtime_float();

	$time = $time_end - $time_start;


	if(false && $log->getDebugLevel()){
		$html .= "<br><font color='blue'>generated ~ {$time} sec</font>";

	}

	$output_string =& $html;

}elseif (Registry::get('output')->getType() == 'console' || Registry::get('output')->getType() == 'text'){


	$output_string = '';
	foreach (Registry::get('output') as $line){

		$output_string .= $line.PHP_EOL;
	}
	$output_string .= $output->getValue().PHP_EOL;


}

echo $output_string;




function __autoload($class_name) {



	$class_name_array = split("_",$class_name);
	$class_name_parsed = '';
	if(count($class_name_array) > 1){
		foreach ($class_name_array as $key=> &$_class_name){
			if($key > 0) $class_name_parsed .= '/';
			$class_name_parsed .= $_class_name;
		}

	//	$file = PATH_LIB.'/radmaster/lib/'.$class_name_parsed.'.php';
	$file = PATH_LIB_RADMASTER.'/'.$class_name_parsed.'.php';


	}else 	$file = PATH_LIB_RADMASTER.'/'.$class_name.'.php'; //$file = PATH_LIB.'/radmaster/lib/'.$class_name.'.php';

	$first_char = $class_name[0];

	if(file_exists($file)){
		require_once($file);
	}

	elseif(ereg('^Element_',$class_name) || ($first_char == strtoupper($class_name[0])) && !ereg('^App',$class_name) ){

		$file = PATH_APP_DATA.'/_tmp/class_cache/'.$class_name.'.php';
		if(!file_exists($file)){


			if($class_array = split('_',$class_name)){
				if($class_array[0] && $class_array[1] && count($class_array) > 2) $parent_class = $class_array[0].'_'.$class_array[1];
				else $parent_class = 'Element';
			}


			$class_string = "<?php class {$class_name} extends {$parent_class} {}?>";
			file_put_contents($file,$class_string);

		}


		require_once($file);


	}





	//require_once($class_name) . '.php';
}


?>