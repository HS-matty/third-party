<?php
$mtime = microtime(true);

header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!11
//todo: modules/function GetDataByParams($Module,$Object)
//
//Error_level

define('REALTY_RECORDS_PER_PAGE',5);

define('NO_RECORDS_FOUND',2);
define('RECORD_NOT_EXISTS',3);

//
//Constats
//
//


// logical parts of site
define("FRONTEND",0);
define("BACKEND",1);


$Weekdays = array();
$Weekdays['ru'][0] = 'Воскресенье';
$Weekdays['ru'][1] = 'Понедельник';
$Weekdays['ru'][2] = 'Вторник';
$Weekdays['ru'][3] = 'Среда';
$Weekdays['ru'][4] = 'Четверг';
$Weekdays['ru'][5] = 'Пятница';
$Weekdays['ru'][6] = 'Суббота';

$Weekdays['en'][0] = 'Sunday';
$Weekdays['en'][1] = 'Monday';
$Weekdays['en'][2] = 'Tuesday';
$Weekdays['en'][3] = 'Wednesday';
$Weekdays['en'][4] = 'Thursday';
$Weekdays['en'][5] = 'Friday';
$Weekdays['en'][6] = 'Saturday';

$Weekdays['cz'][0] = 'Neděli';
$Weekdays['cz'][1] = 'Pondělн';
$Weekdays['cz'][2] = 'Úterý';
$Weekdays['cz'][3] = 'Středa';
$Weekdays['cz'][4] = 'Čtvrtek';
$Weekdays['cz'][5] = 'Pátek';
$Weekdays['cz'][6] = 'Sobota';


//todo   modules, pages,registered_lang
//todo  function  page





//templates defines




function __autoload($ClassName) {
	
	$Names = array();
	preg_match("/^([A-Za-z]*)([A-Z][a-z]*)$/",$ClassName,$Names);	
	@$Names[1] = strtolower(@$Names[1]);
	@$Names[2] = strtolower(@$Names[2]);
    require_once 'classes/modules/'. @$Names[1]. '/'.@$Names[1].'.'.@$Names[2].'.php';
    }

    

require_once('classes/core/auth.class.php');

require_once('classes/core/db.class.php');
require_once('classes/core/log.class.php');
require_once('classes/core/module.class.php');
require_once('classes/core/logic.class.php');
require_once('classes/core/view.class.php');
require_once('classes/core/controller.class.php');
require_once('classes/core/modules.class.php');

require_once('classes/core/inoutdata.class.php');
require_once('classes/core/form.class.php');
require_once('classes/core/categories.class.php');
require_once('classes/core/user.class.php');
require_once('classes/core/config.class.php');
require_once('classes/core/actionslog.class.php');

require_once('classes/modules/backend/backend.controller.php');
require_once('classes/modules/frontend/frontend.controller.php');



//$Categories = new Categories();
//$Categories->GetCategoryContentByName('ddd');
//die();


$Db =& new cDB();
$Config =& new Config();
if(!$Db->connect($Config->DbName,$Config->DbHost,$Config->DbLogin,$Config->DbPassword)) die('couldn\'t connect to database!');
$InOut =& new InOutData();
$Db->query('SET NAMES utf8');

//$arr = ActionsLog::GetLogRecords(4,'te');

//$Bus = new BusserviceController();
//$Bus->GetPageObject('dd','dd','ddd');

//die();



$Auth = new CAuth();

if(empty($InOut->InSid)){

	
	$User = $Auth->GetUserData('user','user');
		
}else{
	// check session
	if(!$Auth->VerifySession($InOut->InSid)){ //no errors
		//yes, we have such active session!

		$User = $Auth->GetUserData(null,null,$Auth->UserId);
			
	}else{
		
		//no, session is incorrect, registering as default user
		
		$User = $Auth->GetUserData('user','user');
	
	}
	
	

}




$HostName = $Config->Hostname;

//var_dump($Auth);
//	ivar_dump($InOut->GetInObject());



if(empty($User->UserId)) die("Access denied!");


switch ($InOut->InSideType){
	
	
	case BACKEND:

	$BackEndController = new BackendController($InOut->GetInModule(),$InOut->GetInObject(),$User);

	$BackEndController->GetPageObject($InOut->InLang,$InOut->InSideType,'common');
	
	
	break;
	
	case FRONTEND:
	
	
	$FrontEndController = new FrontEndController($InOut->GetInModule(),$InOut->GetInObject(),$User);

	$FrontEndController->GetPageObject($InOut->InLang,$InOut->InSideType,'common');
	
	break;

	default:
	//todo: not found here
	die('Internal error! =)');
	break;
		
}


$mtime2 = microtime(true);

$m = $mtime2-$mtime;


//echo '<br>page generated in '.$m.' seconds';



?>
