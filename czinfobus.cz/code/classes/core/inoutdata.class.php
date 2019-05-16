<?PHP
class InOutData{

	//incoming params


	protected $RedirectFlag = 0;
	public  $InCatName;
	public  $InLang;
	public  $InView = 'common';
	public  $InSid ;
	public  $InAction;

	public 	$InModule; //object
	public  $InObject; //object

	public  $InObjectParam;
	public  $InParams;

	public  $InSideType = 'not_found';

	public  $InParamsArray = array();




	function __construct(){
		//todo loadin' alieses code here

		$this->ParseUri();



		if(!get_magic_quotes_gpc()) {
			$this->AddMagicQ($_GET);
			$this->AddMagicQ($_POST);
		}

		//if(!($this->InLang == 'ru' || $this->InLang == 'en' || $this->InLang == 'cz') ) $this->InLang='ru';
		$this->InLang='ru';
		if($this->pgvar('action')) $this->InAction = $this->pgvar('action');
		else $this->InAction = 0;

		if($this->pgvar('sid')) $this->InSid = $this->pgvar('sid');
		else $this->InSid = 0;

		$this->InView = 'common';



	}

	function GetInModule(){

		return $this->InModule;

	}
	function GetInObject(){


		return $this->InObject;

	}



	/**
	* @return void
	* @param unknown $Param
	* @desc Внести описание здесь...
	*/
	public function GenerateFullUrl($ModuleId,$ObjectId,$Lang, $Param = 0, &$PageParams = null){

		global $Auth;
		$Sid = '';
		if(is_object($Auth)) $Sid = @$Auth->GetSid();



		global $Config;
		//	print("<br> mod is $ModuleId, obj: is $ObjectId, lang is $Lang<br>");


		$Url = $Config->Hostname;

		if($this->InSideType == BACKEND) $Url .= '/admin';

		$Url .= '/'.$ModuleId.'/'.$ObjectId.'/';

		if((int) $Param) $Url .= $Param.'/';
		$Url .= $Lang.'/';
		if(@$Sid) $Url .= "?sid=$Sid";
		
		if(is_array($PageParams)) {
			$first  = 1;
			$PageParamsUrl = '';
			foreach ($PageParams as $key=>$val) {
				if($first && (!@$Sid) ) $PageParamsUrl .= '?'.$key.'='.$val;
				else $PageParamsUrl .= '&'.$key.'='.$val;
				$first = 0;

			}
			//	echo $PageParamsUrl;
			$Url .= $PageParamsUrl;
		}

		

		return $Url;

	}


	public function RedirectByFullParams($ModuleId,$ObjectId,$ObjectParam = 0, &$PageParams= null){

		$Url = $this->GenerateFullUrl($ModuleId,$ObjectId,$this->InLang,$ObjectParam,$PageParams);
		//	echo $Url;

		$this->RedirectUrl($Url);
		
	}
	
	public function RedirectUrl($Url){

		$Url = strtolower($Url);
		if(false){
	//	if (!headers_sent($filename, $linenum)) {
			header("Location: $Url");
			exit;


		} else {

			echo "<br>Headers already sent " .
			"<br>Cannot redirect, for now please click this <a " .
			"href=\"$Url\">Redirect LINK</a> instead\n";
			exit;
		}




	}


	public function RedirectAlias($Alias){


		$Modules =  new Modules();
		if(!$Modules->GetDataByAlias($Alias,$this->InLang)){ //no errors found
		//var_dump($Modules->GetObject());
		if(!$Param = @$Modules->GetObject()->param) $Param = 0;
		if(!empty($Modules->GetModule()->alt_id)) $Module = $Modules->GetModule()->alt_id;
		else $Module = $Modules->GetModule()->id;
		$Url = $this->GenerateFullUrl($Module,$Modules->GetObject()->id,$this->InLang,$Param);
		$this->RedirectUrl($Url);

		}else{
			//todo: go to not found page
			if($this->RedirectFlag == 0){
				$this->RedirectFlag = 1;
				$this->RedirectAlias('not_found');
			}else die('Bad redirect');

		}
	}













	}

	function gvar($varname) {

		if( isset($_GET[$varname]) ) {
			return $_GET[$varname];
		}
		return false;
	}

	function pvar($varname) {

		if( isset($_POST[$varname]) ) {
			return $_POST[$varname];
		}

		return false;
	}

	function pgvar($varname) {
		$r = $this->pvar($varname);
		if( $r === false ) {
			$r = $this->gvar($varname);
		}

		return $r;
	}
	function UnsetVar($varname){
		unset($_GET[$varname]);
		unset($_POST[$varname]);


	}

	function CheckUploadedFile($File, $PrefTypes,$Size){
		//	print_r($_FILES);
		//echo $_FILES[$File]['name'];
		//print("<br>");
		//print("$Size<br>");

		if( empty($_FILES[$File]['name'])) {


			return 0;

		}elseif($_FILES[$File]['size'] > $Size ) {

			return 0;
		}

		else {
			$i=0;

			while(!empty($PrefTypes[$i]) ){

				if($_FILES[$File]['type'] == $PrefTypes[$i]) return  $_FILES[$File]['tmp_name'];

				++$i;
			}


		}


		return 0;
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

	function AddMagicQ($arr) {
		reset($arr);
		while( list($key,$value) = each($arr) ) {
			if( is_array($value) )
			$arr[$key] = addslashes($value);
			else {
				if( is_string($value) )
				$arr[$key] = addslashes($value);
			}
		}
		return $arr;
	}


}


?>