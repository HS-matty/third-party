<?php

header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);


//Error_level

define('NO_RECORDS_FOUND',2);
define('RECORD_NOT_EXISTS',3);
define('REALTY_RECORDS_PER_PAGE',30);



require_once('inc/init_user.php');
//require_once('inc/core/postget.class.php');
//require_once('inc/core/auth.class.php');
require_once('inc/core/db.class.php');
require_once('inc/core/log.class.php');
require_once('inc/core/module.class.php');
require_once('inc/core/view.class.php');
require_once('inc/core/parseincdata.class.php');
require_once('inc/core/categories.class.php');
CLog::FileLog('test.txt','test');
$HostName = "http://eng";

$DefaultLang = "ru";
$DefaultCatLangName = 'Главная';


$IncDataObj =& new CParseIncomingData();
//$IncDataObj->DoParseExt();
//die();

$IncData = $IncDataObj->DoParseExt();


$View = $IncDataObj->pgvar('view');
$Sid = $IncDataObj->pgvar('sid');
$Action = $IncDataObj->pgvar('action');

$IncData['Lang'] = 'ru';



if(true) $View = 'common';
else{

	switch ($View){

		case 'print':
		$View = 'print';
		break;

		default:
		$View = 'common';
		break;
	}
}

//var_dump($IncData);
global $Db;
$Db =& new cDB();

if(!$Db->connect('kesso_cms','localhost','root','root')) die('couldn\'t connect to database!');

$Log =& new CLog(INFO);


$CatName = $IncData['CatName'];
//print("<br><br>Cantname is $CatName<br><br><br>");
// Id
//if( (count($IncData['Cats']) > 0) && (!empty($CatName)) ){
if( (!empty($CatName)) ){
	$CatsObj =& new Categories();
	list($CatId,$CatLangName,$IsPage) = $CatsObj->GetCategoryIdByName($CatName,$IncData['Lang']);
	if(empty($CatLangName)) {
		$CatId = 0;
		$CatName = 'index';
		$CatLangName = "Главная";
		$IsPage = 0;
	}

}else{
	$CatId = 0;
	$CatName = 'index';
	$CatLangName = 'Index page';
	$IsPage = 0;

}
//    ()



if(!$CatId && $IncData['CatName']) $IncData['Page'] = 'not_found';

elseif( ( $CatId) && ($IsPage) ){

	//if(!$CatId) {
	//  todo:
	require_once('modules/article/article.logic.php');
	require_once('modules/article/article.view.php');

	if(($IsPage)){

		$IncData['ObjectType'] = 'article';
		$IncData['Page'] = CArticleLogic::GetArticleIdByCatId($CatId,$IncData['Lang']);

		if(! ($IncData['Page']) || $Action ) $IncData['Page'] = 'not_found';

	}
}



if(empty($IncData['Page'])) $IncData['Page'] ='index';
//elseif (empty($IncData['ObjectType'])) $IncData['Page'] ='index';

if(($IncData['Page'] != 'index') && ($IncData['Page'] != 'not_found')){


	if(empty($IncData['ObjectType'])) $IncData['ObjectType'] = 'def';

	switch ($IncData['ObjectType']){



		///////////////////////////////
		/// REALTY here
		///////////////////////////////

		case "realty":

		require_once('modules/realty/realty.logic.php');
		require_once('modules/realty/realty.view.php');

		$RealtyLogic =& new RealtyLogic($IncData['Lang']);

		If(@($PageId = (int) $IncData['Page']) != 0)  $IncData['Page'] = 'realty';




		switch ($IncData['Page']) {



			case 'add':


		
			if($Action=='posted'){

				$SourceFilesArr = array();
				for($i=1;$i<4;$i++){

					if($SourceFile = $IncDataObj->CheckUploadedFile("image$i",array('image/jpeg','image/pjpeg'),500000))
					array_push($SourceFilesArr,$SourceFile);
				}


				@$r_array['location'] = $IncDataObj->pgvar('r_location');
				@$r_array['space'] = (int) $IncDataObj->pgvar('r_space');
				@$r_array['address'] = $IncDataObj->pgvar('r_address');
				@$r_array['room_number'] =(int) $IncDataObj->pgvar('r_room_num');
				@$r_array['kitchen_type'] = $IncDataObj->pgvar('r_kitchen_type');
				@$r_array['price'] = (int) $IncDataObj->pgvar('r_price');
				@$r_array['short_description'] = $IncDataObj->pgvar('r_short_descr');
				@$r_array['long_description'] = $IncDataObj->pgvar('r_long_descr');
				
				@$r_array['name'] = $IncDataObj->pgvar('c_name');
				@$r_array['phone1'] = $IncDataObj->pgvar('c_phone1');
				@$r_array['phone2'] = $IncDataObj->pgvar('c_phone2');
				if(empty($r_array['phone2'])) $r_array['phone2'] = 'none';

				@$r_array['email'] = $IncDataObj->pgvar('c_email');



				$FirstTime = 1;
				foreach ($r_array as $key => $value) {

					if(empty($r_array[$key]) && (!is_numeric($key))) {

						if(!@$ErrorMessage) $ErrorMessage = "Errors are:  ";
						if($FirstTime) {
							$ErrorMessage .="some fields are empty";//"<b>$key</b> is empty";
							$FirstTime = 0;
						}
						//	else $ErrorMessage .=", <b>$key</b> is empty";

					}


				}

				if( (!@empty($r_array['email'])) && !(@$IncDataObj->ValidateEmail($r_array['email'])) ){

					if($FirstTime) $ErrorMessage = "Errors are: email not valid!";
					else $ErrorMessage .= ", email not valid!";



				}
				if( $r_array['kitchen_type'] != 2 ) $r_array['kitchen_type'] = 1;







				if(empty($ErrorMessage)){ //We have no errors

				//add realty user to database;

					$RealtyObj =& new RealtyLogic($IncData['Lang']);
					$ClientId = $RealtyObj->AddRealtyClient($r_array['name'],$r_array['phone1'],$r_array['phone2'],$r_array['email']);

					if(!$ClientId) $ErrorMessage = 'Internal error!';//if client no added
					else{

						if(!$Result = $RealtyObj->AddRecord($r_array,$ClientId,$SourceFilesArr)) $ErrorMessage = 'Internal Error';




					}



				}
				
				if(@$ErrorMessage){

					$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
					
					$Data['ErrorMessage'] = $ErrorMessage;
					
					$Data['FormData'] = $r_array;
					echo $RealtyView->GetViewCode($Data,$CatName,$CatLangName,'add');


				}else{
					
					$Data = array();
					$Data['ErrorMessage'] = 0;
					$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
					echo $RealtyView->GetViewCode($Data,$CatName,$CatLangName,'added');

				}



				//			$ClientId = $RealtyObj->GetUserId($UserName);

				//			$Result = $RealtyObj->AddRecord($r_array,$ClientId,$SourceFilesArr);
				//			if(!$Result){
				//				$ReturnArray['ErrorMessage'] = 'Can\'t add record!';
				//				$ReturnArray['ShowPage'] = 'info_page';



				/*		$ReturnArray['ShowPage'] = 'add';
				$ReturnArray['ErrorMessage'] = 'Added!';
				$uri =  $ReturnArray['redirect_uri'] = "$HostName/admin/$CatName/>Lang/index.html?sid=$Auth->Sid";
				$ReturnArray['ShowPage'] = 'redirect';


				*/

				break;




			} //end of if($action)
			else {
				
				$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
				
				$Data = array();
				$Data['ErrorMessage'] = '';
				echo $RealtyView->GetViewCode($Data,$CatName,$CatLangName,$IncData['Page']);


			}
			break;


			case "list":



			if(@!($PageNumber = $IncDataObj->pgvar('pnum'))) $PageNumber = 0;

			$Offset = ($PageNumber) * REALTY_RECORDS_PER_PAGE;




			if(@$IncDataObj->pgvar('sort_by')) $SortBy = $IncDataObj->pgvar('sort_by') ;
			else $SortBy = NULL;
			$FormData['SortBy'] = $SortBy;

			if(@$IncDataObj->pgvar('location')) $LocationFilter = $IncDataObj->pgvar('location') ;
			else $LocationFilter = NULL;
			$FormData['LocationFilter'] = $LocationFilter;

			if(@$IncDataObj->pgvar('price')) $PriceFilter =  (int) $IncDataObj->pgvar('price') ;
			else $PriceFilter = NULL;
			$FormData['PriceFilter'] = $PriceFilter;

			if((int) @$RealtyType = $IncDataObj->pgvar('realty_type')) {
				if(($RealtyType > 10) && ($RealtyType < 20)) {
					$RealtyRoomNum = $RealtyType - 10;
					$RealtyKitchenType = 1;
				}elseif(($RealtyType > 20) && ($RealtyType < 30)){

					$RealtyRoomNum = $RealtyType - 20;
					$RealtyKitchenType = 2;
				}elseif($RealtyType == 10){

					$RealtyRoomNum = null;
					$RealtyKitchenType = 1;
				}elseif ($RealtyType == 20){

					$RealtyRoomNum = null;
					$RealtyKitchenType = 2;

				}else{
					$RealtyRoomNum = null;
					$RealtyKitchenType = null;

				}
			}else{
				$RealtyRoomNum = null;
				$RealtyKitchenType = null;


			}

			$FormData['RealtyType'] = $RealtyRoomNum+$RealtyKitchenType*10;




			$Data = $RealtyLogic->GetRecordsList(1,$LocationFilter,NULL,NULL,$PriceFilter,$RealtyRoomNum,$RealtyKitchenType,$SortBy,REALTY_RECORDS_PER_PAGE,$Offset);

			$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
			echo $RealtyView->GetViewCode($Data,$CatName,$CatLangName,'list',$FormData);

			break;

			case 'realty':

			if($Realty = $RealtyLogic->GetRecordById($PageId)){

				$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
				echo $RealtyView->GetViewCode($Realty,$CatName,$CatLangName,'realty_record');


			}else{

				$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
				echo $RealtyView->GetViewCode($Realty,$CatName,$CatLangName,'NotFound');


			}
			break;


			default:
			/*	if($IncData['Page'] = (int) $IncData['Page']) {
			if($Realty = $RealtyLogic->GetRecordById($IncData['Page'])){

			$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
			echo $RealtyView->GetViewCode($Realty,$CatName,$CatLangName,'realty_record');


			}else{

			$RealtyView =& new RealtyView('common',$IncData['Lang'],'FrontEnd');
			echo $RealtyView->GetViewCode($Realty,$CatName,$CatLangName,'NotFound');


			}





			}else{*/

			$IncData['Page'] = 'not_found';
			//}

			break;

		}








		break;

		///////////////////////////////////
		//Articles here
		/////////////////////////////////////
		case "article":

		//echo "Articles page here";




		$ArticleLogic =& new CArticleLogic($IncData['Lang']);
		$ArticleData = $ArticleLogic->GetArticleData($IncData['Page']);
		

		if(@$ArticleData['ErrorLevel']){

			$IncData['Page'] = 'not_found';

		}else{
			//print_r($ArticleData);

			$ArticleData['ArticleData']['article_body'] = nl2br($ArticleData['ArticleData']['article_body']);
			$ArticleView =& new CArticleView('common',$IncData['Lang']);
			echo $ArticleView->GetViewCode($ArticleData,$CatName,$CatLangName,'ArticleIndex');

		}
		break;




		default:
		//echo 'DEFAULT';
		$IncData['Page'] = 'not_found';
		break;


	}

}
//echo $IncData['Page'];
if($IncData['Page'] == 'index'){

	require_once('modules/index/index.logic.php');
	require_once('modules/index/index.view.php');

	$IndexLogic =& new IndexLogic($IncData['Lang']);

	/*		if($CatName == 'realty'){
	$CatName = 'index';
	$CatLangName = 'index';
	$CatId = 0;
	}*/
	$IndexData['Data'] = $IndexLogic->GetData($CatId,$CatName,$Action);
	
	/*	if($IndexData['ErrorLevel'] == 22) {
	die($IndexData['ErrorMessage']);
	$CatId = 0;
	$CatName = 'index';
	
	}
	*/
	//if($IndexData['ErrorLevel'] == 1) die($IndexData['ErrorMessage']);

	//	print_r($IndexData);
	//	if(!isset($IndexData['ShowPage'])) $IndexData['ShowPage'] = 'def';


	$IndexView =& new IndexView($View, $IncData['Lang'],'FrontEnd');


	echo $ViewParsedCode =& $IndexView->GetViewCode($IndexData['Data'],$CatName, $DefaultCatLangName,$IncData['Page']);


}elseif ($IncData['Page'] == 'not_found'){
//	echo 'NOT_FOUND';
	require_once('modules/index/index.view.php');
	$IndexView =& new IndexView($View, $IncData['Lang'],'FrontEnd');



	$a = array();
	echo  $IndexView->GetViewCode($a,$CatName, $DefaultCatLangName,$IncData['Page']);


}












?>
