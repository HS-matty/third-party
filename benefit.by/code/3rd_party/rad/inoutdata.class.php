<?PHP
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/

//require_once('postdataerrors.php');
class InOutData{

	//incoming params


	protected $RedirectFlag = 0;
	public  $Name;
	public  $Lang = 'ru';
	public  $Sid ;
	public  $Action;

	public 	$Module; //object
	public 	$Function; //object

	public  $Object; //object

	public  $SideType = 'not_found';

	public $PDE;//PostDataErrors;
	public $FullUriArray;
	public  $InternalRedirectFlag = 0;
	private $InternalRedirectIndex = 0;
	private $InternalRedirectModule;
	private $InternalRedirectFunction;

	public $IncludeObligatoryParamsInUrlGeneration = 0;

	public $FormAction;
	private   $ObligatoryUrlParamsArray = array();
	private $ObligatoryUrlParamsString = null;

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




	public function setGetPostVar($VarName,$VarValue){
		$_GET[$VarName] = $VarValue;
		$_POST[$VarName] = $VarValue;

	}



	function __construct(){
		//todo loadin' alieses code here



		//	$this->PDE = new PostDataErrors();



	}



	public function setObligatoryUrlParam($ParamName,$ParamValue){
		$this->ObligatoryUrlParamsArray[$ParamName] = $ParamValue;



	}
	/**
	* @return void
	* @param unknown $Param
	* @desc ������ �������� �����...
	*/
	public function GenerateFullUrl($Module,$Function= null,$Lang = null, $Param = 0, $UrlParams = null,$PageParams = null,$IncludeSuccesStatus = true){

		$UrlParamsVal = null;

		global $Auth;
		$Sid = '';
		if(is_object($Auth)) $Sid = @$Auth->GetSid();



		global $Config;
		//	print("<br> mod is $ModuleId, obj: is $ObjectId, lang is $Lang<br>");


		$Url = $Config->Hostname;

		if($this->SideType == BACKEND) $Url .= '/admin';

		$Url .= '/'.$Module.'/';
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
	 * @param string $Url expl: www.somewhere.com
	 */
	public function RedirectUrl($Url){
		global $Debug;

		$Url = strtolower($Url);
		//	if(false){
		if (!headers_sent($filename, $linenum) && !$Debug) {

			header("Location: $Url");
			exit;


		} else {

			echo "<br>Headers already sent " .
			"<br>Cannot redirect, for now please click this <a " .
			"href=\"$Url\">Redirect LINK</a> instead\n";
			//	echo $filename.','.$linenum;
			exit;
		}




	}

















	function gvar($varname,$escape = false) {

		if( isset($_GET[$varname]) ) {

			if($escape) return $this->_escape($_GET[$varname]);
			return $_GET[$varname];
		}
		return false;
	}

	function pvar($varname,$escape = false) {

		if( isset($_POST[$varname]) ) {
			if($escape) return $this->_escape($_POST[$varname]);
			return $_POST[$varname];
		}

		return false;
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


	public function isFormPost($Title = null){
		if($Title){

			if($this->pgvar('post') == $Title) return true;

		}else {
			if($this->pgvar('post')) return true;
		}

		return false;
	}

	public  function _escape($string, $esc_type = 'html', $char_set = 'ISO-8859-1')
	{
		switch ($esc_type) {
			case 'html':
				return htmlspecialchars($string, ENT_QUOTES, $char_set);

			case 'htmlall':
				return htmlentities($string, ENT_QUOTES, $char_set);

			case 'url':
				return rawurlencode($string);

			case 'urlpathinfo':
				return str_replace('%2F','/',rawurlencode($string));

			case 'quotes':
				// escape unescaped single quotes
				return preg_replace("%(?<!\\\\)'%", "\\'", $string);

			case 'hex':
				// escape every character into hex
				$return = '';
				for ($x=0; $x < strlen($string); $x++) {
					$return .= '%' . bin2hex($string[$x]);
				}
				return $return;

			case 'hexentity':
				$return = '';
				for ($x=0; $x < strlen($string); $x++) {
					$return .= '&#x' . bin2hex($string[$x]) . ';';
				}
				return $return;

			case 'decentity':
				$return = '';
				for ($x=0; $x < strlen($string); $x++) {
					$return .= '&#' . ord($string[$x]) . ';';
				}
				return $return;

			case 'javascript':
				// escape quotes and backslashes, newlines, etc.
				return strtr($string, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));

			case 'mail':
				// safe way to display e-mail address on a web page
				return str_replace(array('@', '.'),array(' [AT] ', ' [DOT] '), $string);

			case 'nonstd':
				// escape non-standard chars, such as ms document quotes
				$_res = '';
				for($_i = 0, $_len = strlen($string); $_i < $_len; $_i++) {
					$_ord = ord(substr($string, $_i, 1));
					// non-standard char, escape it
					if($_ord >= 126){
						$_res .= '&#' . $_ord . ';';
					}
					else {
						$_res .= substr($string, $_i, 1);
					}
				}
				return $_res;

			default:
				return $string;
		}
	}






}

/**
    * Remove a value from a array
    * @param string $val
    * @param array $arr
    * @param int $key
    * @return array $array_remval
    */
function array_remval($val, &$arr,$key = null)
{
	$array_remval = $arr;
	for($x=0;$x<count($array_remval);$x++)
	{
		$i = $key;
		if($val) $i=array_search($val,$array_remval);
		if (is_numeric($i)) {
			$array_temp  = array_slice($array_remval, 0, $i );
			$array_temp2 = array_slice($array_remval, $i+1, count($array_remval)-1 );
			$array_remval = array_merge($array_temp, $array_temp2);
		}
	}
	
	return $array_remval;
}

function html_to_utf8 ($data)
    {
    return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '_html_to_utf8("\\1")', $data);
    }

function _html_to_utf8 ($data)
    {
    if ($data > 127)
        {
        $i = 5;
        while (($i--) > 0)
            {
            if ($data != ($a = $data % ($p = pow(64, $i))))
                {
                $ret = chr(base_convert(str_pad(str_repeat(1, $i + 1), 8, "0"), 2, 10) + (($data - $a) / $p));
                for ($i; $i > 0; $i--)
                    $ret .= chr(128 + ((($data % pow(64, $i)) - ($data % ($p = pow(64, $i - 1)))) / $p));
                break;
                }
            }
        }
        else
        $ret = "&#$data;";
    return $ret;
    }


?>