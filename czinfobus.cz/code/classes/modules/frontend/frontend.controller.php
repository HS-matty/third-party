<?php


require_once('./classes/modules/busservice/bususerauth.php');

class FrontEndController extends Controller {






	public function GetPageObject($Lang,$SideType,$ViewType = 'common'){


		global $InOut;
		global $Modules;
		global $Auth;
		$Sid = 0;

		if(!is_object($Modules)){

			$Modules = new Modules();

		}

		$Data  = array();


		//var_dump($this->Module->grants);


		$Access = 0;
		//var_dump($this->User);
		//var_dump($Auth);

		//check user access for backend module..
		$B = new Modules();
		$B->GetDataByParams('frontend','index');

		if(!$SelfMod = $B->GetModule()) die('internal error');
		$SelfAccess = $B->AccessModulePage($this->User,$B->GetModule(),$B->GetObject());
		$Access = $Modules->AccessModulePage($this->User,$this->Module,$this->GetObject());






		if(( ($Access == 0) || ($SelfAccess ==0) )  ){


			die('access denied');



			//die('Access Denied');



		}elseif($this->GetModule()->id == 'frontend') {


			//var_dump($this->Object);

			switch ($this->Object->id) {

				case 'index':
				//	echo 'index page';

				require_once('classes/modules/content/article.logic.php');
				require_once('classes/modules/busservice/route.php');

				$Route = new Route();
				$Data['routes'] =  $Route->GetAllRoutes(1,0);

				$Article = new ArticleLogic($Lang);
				$Data['article'] = $Article->GetArticleData(33);
				$Data['news_headers'] = $Article->GetArticleList(2,5);




				break;
				case 'forgot_password':
				$Login = $InOut->pgvar('login');
				if($InOut->pgvar('post')==1 && !empty($Login)){
					
					BusUserAuth::ForgotPassword($Login);
				
				}
				
				break;
				case 'schedule':
				require_once('classes/modules/busservice/intervals.php');
				require_once('classes/modules/busservice/route.php');
				require_once('classes/modules/busservice/days.php');
				require_once('classes/modules/busservice/point.php');
				require_once('classes/modules/busservice/stations.php');
				
				$Route = new Route();
				$Data['routes'] =  $Route->GetAllRoutes(1,0);
				$RouteData = array();
				
				$RouteId = (int) $InOut->pgvar('route_id');
				$DaysNum = (int) $InOut->pgvar('num');
				if(!$DaysNum) $DaysNum = 30;
				$DeparPointId = (int) $InOut->pgvar('departure');
				$ArrivalPointId = (int) $InOut->pgvar('arrival');
				$Data['Points'] = Point::GetPoints($Lang);
				
				if($RouteId) $RouteData = $Route->GetSingleRoute($RouteId,'ru',0);
				if(!empty($RouteData)){
				
						

					//var_dump($RouteData);
					$Data['found_routes'][0]['route_name_ru']  = $RouteData['route_name_ru'];
					$Data['found_routes'][0]['route_name_latin']  = $RouteData['route_name_latin'];
					$Data['found_routes'][0]['schedule'] = $Route->GetRoutesSchedule($RouteId,$DaysNum);
					$Data['found_routes'][0]['article_header'] = 'Shedule';
					
					
				}elseif ($DeparPointId && $ArrivalPointId){
					
					//look for  routes with such stations
					
					$FoundRoutes = Stations::SearchRouteByStations($DeparPointId,$ArrivalPointId);
					
					if(!empty($FoundRoutes)) for($i=0;$i<count($FoundRoutes);$i++){
					
					$RouteData = $Route->GetSingleRoute($FoundRoutes[$i],'ru',0);
					
					$Data['found_routes'][$i]['route_name_ru']  = $RouteData['route_name_ru'];
					$Data['found_routes'][$i]['route_name_latin']  = $RouteData['route_name_latin'];
					$Data['found_routes'][$i]['schedule'] = $Route->GetRoutesSchedule($FoundRoutes[$i],$DaysNum);
					$Data['found_routes'][$i]['article_header'] = 'Shedule';
					
					}
					
					
				}



				break;



				case 'not_found':

				//todo: not found code here


				break;

				case 'register_user':
				//echo 'registerimg user';
				if($InOut->pvar('post') == 1){
					$Form = new Form($Lang);
					$Form->ProceedForm('register_user');
					$Errors = $Form->GetErrorsArray();
					
					if(BusClient::IfLoginExist($Form->GetField('client_login'))){
						
						$Errors[0]['msg'] = 'Such Login exists!';
						
					}


					if(empty($Errors)){
						if($Form->GetField('client_password1') != $Form->GetField('client_password2')){

							$Errors[0]['msg'] = 'Password1 and password2 error!';
						}

					}
					if(empty($Errors)){

						$BusUser = new BusClient();
						$BusUser->RegisterNewUser($Form->GetField('client_name'),$Form->GetField('client_phone1'),$Form->GetField('client_phone2'),$Form->GetField('client_email'),$Form->GetField('client_login'),$Form->GetField('client_password1'));
						$InOut->RedirectAlias('main');

					}else{
						$Data['Errors'] = $Errors;

						$Data['post'] = $Form->GetPostArray();
					}
				}


				break;



				case 'login':

				$LoginForm = new Form($Lang);
				if($LoginForm->GetField('post') ==1){

					$LoginForm->ProceedForm('login_form');
					$Errors =  $LoginForm->GetErrorsArray();

					if(empty($Errors)){

						$BusUserAuth = new BusUserAuth();
						//try login as user
						$BusClient = $BusUserAuth->AuthBusClient($LoginForm->GetField('login'),$LoginForm->GetField('password'));


						if(!empty($BusClient)){
						//try to login as 
						require_once('./classes/modules/busservice/busclient.php');
						$NewAuth = new CAuth();
						$User = $NewAuth->GetUserData('client','client12345678987654321');

						if($NewAuth->RegisterSession($User,$BusClient->ClientId)) die('cannot register session');
						$Params['sid'] = $NewAuth->GetSid();
						$InOut->RedirectByFullParams('busservice','client_page',0,$Params);
						
						
						
						}else{
						
						$BusUser = $BusUserAuth->AuthBusDealer($LoginForm->GetField('login'),$LoginForm->GetField('password'));
						
						}
						//register session
						if(!empty($BusUser)){
							require_once('./classes/modules/busservice/dealer.php');
							$ActiveFlag = Dealer::IsActive($BusUser->Id);
							if($ActiveFlag){
								$NewAuth = new CAuth();
								$User = $NewAuth->GetUserData('partner','partner');

								if($NewAuth->RegisterSession($User,$BusUser->Id)) die('cannot register session');

								$Params['sid'] = $NewAuth->GetSid();


								//	$this->RedirectFlag = 1;
								$InOut->RedirectByFullParams('busservice','partners_page',0,$Params);
							}else{
								$Data['Errors'][0]['msg'] = 'Partner is not active';

							}
							//
						}









					}
					else	$Data['Errors'] = $Errors;

				}


				//	echo 'login_page';

				break;








			}


			// end if backend module switch
			if($this->RedirectFlag == 0){
				//	echo '<br><strong>Debug HERE</strong><br>';
				if(@is_object($Auth)) $Sid = $Auth->GetSid();
				elseif (@is_object($NewAuth)) $Sid = $NewAuth->GetSid();

				if(empty($Sid)) $Sid = null;


				$Data['Modules'] = $Modules->GetUserAvailableModules($this->User);
				$Data['Objects'] = $Modules->GetUserObjects($this->User,$this->Module);

				$Data['Sid'] = $Sid;

				$BackendView = new View($Lang,$SideType,$ViewType);
				echo  $BackendView->GetParsedCode($this->Module->id,$this->Object,$Data);
			}


		}else{


			//todo проверяем и подкючаем ModuleName/modulname.controller.php
			// И запускаем.
			// todo_next: проверка прав на запуска данного модуля.


			$ClassName = $this->Module->id."Controller";
			//echo $ClassName;
			//var_dump($this->Object);
			$Object = new $ClassName($this->Module,$this->Object,$this->User);
			$Object->GetPageObject($Lang,$SideType,$ViewType);
			//lets parse all objects with chosen view

			//check if we need redirect



		}




	}
}


?>