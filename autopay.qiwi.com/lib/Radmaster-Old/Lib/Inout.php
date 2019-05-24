<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2013
if you have any questions please visit www.radmaster.net

*/

class Inout{

	//incoming params


	protected $RedirectFlag = 0;
	public  $Lang = 'ru';

	public $tpl_sub;


	private   $ObligatoryUrlParamsArray = array();
	private $ObligatoryUrlParamsString = null;



	public $redirect_url;
	public $is_success;




	protected $uri_alias = array();

	protected  $uri_params;

	public $page_id;
	public $page_id_param;



	public $application_name;
	public $application_param;

	public $application_params = array();

	public $action_name_full;

	public $application_group;



	public $param1;
	public $param2;



	public function setRedirectUrl($url){
		$this->redirect_url = $url;
	}

	public function getRedirectUrl(){
		return $this->redirect_url;
	}

	public function getObligatoryParamsString(){

		if($this->ObligatoryUrlParamsString) return  $this->ObligatoryUrlParamsString;


		if($this->ObligatoryUrlParamsArray){

			foreach ($this->ObligatoryUrlParamsArray as $param => &$value){
				$value = urlencode($value);
				$this->ObligatoryUrlParamsString .= "&$param=$value";

			}
		}
		return  $this->ObligatoryUrlParamsString;
	}



	public function setTemplateSub($tpl_file_name){

		$this->tpl_sub = $tpl_file_name;
	}


	public function setGetPostVar($VarName,$VarValue){
		$_GET[$VarName] = $VarValue;
		$_POST[$VarName] = $VarValue;

	}


	public function setSuccessStatus($flag = 1){
		$this->is_success = $flag;
	}

	function __construct(){
		//todo loadin' alieses code here


		$is_success = $this->getParam('is_success');
		if(is_numeric($is_success)) $this->is_success = (int) $is_success;

		//	$this->PDE = new PostDataErrors();



	}



	public function setObligatoryUrlParam($ParamName,$ParamValue){
		$this->ObligatoryUrlParamsArray[$ParamName] = $ParamValue;



	}


	public function redirectByParams($action_name,$module_name = null,$group_name = null,$page_params = null,$url_params = null){

		global $config;

		$url = $config->Hostname;
		if(!$module_name) $module_name = $this->module_name;
		if(!$group_name) $group_name = $this->group_name;

		if($group_name) $url = $url.'/'.$group_name;
		$url = $url.'/'.$module_name.'/'.$action_name;

		if($page_params)
		foreach ($page_params as $page_param){
			$url = $url .'/'.$page_param;
		}
		if($url_params) {
			$url = $url.'/?';
			foreach ($url_params as $key => $url_param){
				if($key) $url = $url.'&';
				$url .= $key .'='.$page_param;
			}
		}

		if(isset($this->is_success)){
			if(!$url_params) $url = $url.'/?';
			else  $url = $url.'&';
			$url .= 'is_success='.$this->is_success;
		}
		$this->setRedirectUrl($url);

	}

	/**
	* @return void
	* @param unknown $Param
	* @desc 
	*/
	public function generateFullUrl($Module,$Function= null,$Lang = null, $Param = 0, $UrlParams = null,$PageParams = null,$IncludeSuccesStatus = true){

		$UrlParamsVal = null;

		global $Auth;
		$Sid = '';
		if(is_object($Auth)) $Sid = @$Auth->GetSid();



		global $Config;
		//	print("<br> mod is $ModuleId, obj: is $ObjectId, lang is $Lang<br>");


		$Url = $Config->Hostname.'/';

		//	if($this->SideType == BACKEND) $Url .= '/admin';

		if($Module) $Url .= '/'.$Module.'/';
		if(is_array($Function)){
			foreach ($Function as &$f){
				$Url .= $f.'/';
			}
		}
		elseif($Function) $Url .= $Function.'/';

		if(is_array($PageParams)){

			foreach ($PageParams as $key => $param){

				$Url .= $param.'/';


			}

		}
		//	if((int) $Param) $Url .= $Param.'/';
		//	$Url .= $Lang.'/';
		//	if(@$Sid) $Url .= "?sid=$Sid";

		$IncludeSid = 0;
		//print_r($UrlParams);
		//	if(!$UrlParams) $UrlParams = array();
		//	$UrlParams = array_merge($UrlParams,$this->ObligatoryUrlParams);
		//	print_r($UrlParams);
		if(is_array($UrlParams)) {
			$first  = 1;
			$UrlParamsVal = '';
			foreach ($UrlParams as $key=>&$val) {
				//	echo $key.'=>'.$val.'<br>';
				if($first) $UrlParamsVal .= '?'.$key.'='.$val;
				else $UrlParamsVal .= '&'.$key.'='.$val;
				$first = 0;

			}


			//	echo $PageParamsUrl;

		}

		global $Page;
		if(isset($Page) && $Page->SuccessStatus > 0 && $Page->SuccessStatusAddToLinksFlag == true && $IncludeSuccesStatus){

			if($UrlParamsVal) $UrlParamsVal .= "&success=".$Page->SuccessStatus;
			else  $UrlParamsVal .= "?success=".$Page->SuccessStatus;

		}

		//$this->IncludeObligatoryParamsInUrlGeneration;
		/*		if($this->IncludeObligatoryParamsInUrlGeneration){
		$String = $this->getObligatoryParamsString();
		if($UrlParamsVal) $UrlParamsVal .=$String;
		else $UrlParamsVal = '?'.$String;
		}*/




		$Url .= $UrlParamsVal;

		return $Url;

	}


	/**
	 * Redirects to URL
	 *
	 * @param string $Url 
	 */
	public function redirectUrl($Url){
		global $debug;

		$Url = strtolower($Url);
		//	if(false){
		if (!headers_sent($filename, $linenum) && !$debug->getDebugLevel()) {

			header("Location: $Url");
			exit;


		} else {

			echo "<br>Headers already sent " .
			"<br>Cannot redirect, for now please click this  <a " .
			"href=\"$Url\">Redirect LINK</a> instead\n";
			//	echo $filename.','.$linenum;
			exit;
		}




	}


	public function getParam($param_name, $escape= false){

		$return_value = null;
		
		if( isset($_REQUEST[$param_name]) ) {
			if($escape) $return_value =  $this->_escape($_REQUEST[$param_name]);
			else $return_value=  $_REQUEST[$param_name];
		}

		return $return_value;

	}


	public function getUriParam($index = 0){
		return @$this->uri_params[$index];
	}

	public function getUriParamCount(){
		return count($this->uri_params);
	}

	function pgvar($varname,$ForDatabase = false) {
		$r = $this->pvar($varname);
		if( $r === false ) {
			$r = $this->gvar($varname);
		}

		if($ForDatabase){
			$r = stripslashes($r);
			$r = mysql_real_escape_string(htmlspecialchars($r));

		}
		return $r;
	}
	function UnsetVar($varname){
		unset($_GET[$varname]);
		unset($_POST[$varname]);


	}

	function ValidateEmail($email)
	{
		// Create the syntactical validation regular expression
		$regexp = "^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
		// Presume that the email is invalid
		$valid = 0;
		// Validate the syntax
		if (eregi($regexp, $email))
		{
			//	list($username,$domaintld) = split("@",$email);
			// Validate the domain
			//	if (getmxrr($domaintld,$mxrecords)){

			$valid = 1;
		} else {
			$valid = 0;
		}
		return $valid;
	}


	public function isFormPost($name = null){
		/*if($name){

			if($this->pgvar('post') == $name) return true;

		}else {
			if($this->pgvar('post')) return true;
		}

		return false;*/
		
		
		return (int) $_REQUEST['post'];
	}



	public function parseUri(){


		$application_name = null;
		$application_action_name = null;
		$application_action_sub_name = null;
		$application_param = null;


		$application_action_sub_list = array('add','edit','view');


		$param1 = null;
		$param2  = null;

		$page_id = null;

		$uri_params = $this->uri_params;

		$uri_count = count($uri_params);

		//check for param.html







		$page_params = split('\.',$uri_params[$uri_count-1]);


		if(@$page_params[1] == 'html') $page_id = $page_params[0];


		elseif($uri_params[0] == 'page'){


			$page_id = $uri_params[1];

		}elseif ($uri_params[0]== 'app'){



			array_shift($uri_params);
 
			//check if app is system or user 
			if($uri_params[0] == 'user'){
				$this->is_user_application  = true;
				array_shift($uri_params);

			}elseif ($uri_params[0]== 'sys'){

				$this->is_sys_application = true;
				array_shift($uri_params);

			}



			//check for numeric param
			$key = count($uri_params)-1;

			if(isset($uri_params[$key]) && is_numeric($uri_params[$key])){

				$application_param = (int) $uri_params[$key];
				array_pop($uri_params);
			}

			//check for other params
			if($uri_params) $this->uri_params = $uri_params;




		}

		$this->page_id = $page_id;

	}

	/*	public function addUriAlias($alias_name_from,$alias_name_to){

	$this->uri_alias[]	= array($alias_name_from=>$alias_name_to);
	}

	*/
	public function setUriParams($uri_params_array){

		global $log;
		$success_flag = true;

		//check for empty param
		if(empty($uri_params_array[count($uri_params_array)-1])) array_pop($uri_params_array);

		//check correction of the requested param
		foreach ($uri_params_array as &$param){

			$param = strtolower($param);
			$pattern = '/^[a-zA-Z0-9\-\_\.]{2,100}$/';
			if(!preg_match($pattern,$param)){

				$uri_params[0] = 'page';
				$uri_params[1] = 'not-found';
				$log->addMessage('incorrect uri param: '.$param);
				$success_flag = false;
				break;


			}

			if($success_flag)  {
				$this->uri_params = $uri_params_array;
			}

			return $success_flag;

		}






	}


}



?>