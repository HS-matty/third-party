<?php

require('days.php');
require('route.php');
require('stations.php');
require('tickets.php');
require('bus.php');
require('dealer.php');
require('point.php');
require('busowners.php');
require('bustypes.php');
require('dclients.php');
require('intervals.php');
//require('busclient.php');

//glucks: не хочет добавлять два дня
// todo: проверка

class BusserviceController extends Controller  {

	public  function GetPageObject($Lang,$SideType,$ViewType = 'common'){



		global $InOut;
		global $Auth;
		global $NewAuth;
		global $Modules;
		$Data = array();

		global $LogData;

		$LogData['id'] = 25;
		$LogData['User'] = '';



		switch ($this->Object->id){

			case 'client_tickets':
			$BusAuth = new BusUserAuth();
			$TicketObj = new Tickets();
			$ClientData = $BusAuth->GetUserData($Auth->GetParam(),'client');
			if(empty($ClientData)) die('no access!');

			
			



			$Tickets = Tickets::GetClientTickets($Auth->GetParam(),0);
			$Data['tickets'] = $Tickets;
			//var_dump($Tickets);
			//var_dump($Tickets);
				
			
			break;
			//reserve ticket for client
			case 'c_rticket':
			@$TicketParam = $this->Object->param;
			if( empty($TicketParam)) die('access denied');
			$UserData = BusUserAuth::GetUserData($Auth->GetParam(),'client');
			if(empty($UserData)) die('Access denied');
			
			$UnpayedTicketNum = Tickets::GetTicketCount($Auth->GetParam());
			if($UnpayedTicketNum != 0) {
				die('Hackers?');
			}
			
			preg_match("/^([0-9]*)_([0-9]*)$/",$TicketParam,$Result);
			if(empty($Result)) $InOut->RedirectByFullParams($this->Module->id,'partners_page');
			$TicketPlace = (int)$Result[1];
			$BusId = (int)$Result[2];

			$DayId = Bus::GetBusDaysId($BusId);
			
			$Bus = new Bus();
			Intervals::LoadIntervals($DayId,1);
			$Data['intervals'] = Intervals::GetIntervals();
			
			$ClientData = BusUserAuth::GetUserData($Auth->GetParam(),'client');
			if(empty($ClientData)) die('access denied');
			else $ClientId = $Auth->GetParam();
					

			if(!$BusData = $Bus->GetBus($BusId)) die('bad bus');


			//			$Form = new Form($Lang);
			//			$Member = $Form->GetField('member');
			//			if(!$Member) $Errors[0]['msg'] = 'Bad name!';

			
			if($InOut->pvar('post') == 1 && (empty($Errors))){
			
				
				
				//check user id
				
				
				



				$TicketObj = new Tickets();
				
				$TicketData = $TicketObj->GetTicketInfo($BusId,$TicketPlace);
				//var_dump($TicketData);
				if(!empty($TicketData))
				if(@$TicketData['ticket_status'] != 'free' ) die('ticket error'); //redirect here
				//delete free ticket
				if(!empty($TicketData)) {
					$BusAuth = new BusUserAuth();
				//	$LogData['id'] = $Auth->GetParam();
				//	$LogData['User'] = 'dealer';

					$TicketObj->DeleteTicket($TicketData['ticket_id']);
				}

				if($TicketObj->IsTicketExistsExt($BusId,$TicketPlace) || (!$Bus->CanAddNewTicket($BusId))){

					$InOut->RedirectByFullParams($this->Module->id,'ptickets');
				}
				
				


				$NewTicketId = $TicketObj->AddTicket($BusId,'waiting','user',$ClientId,$TicketPlace);
				list($CurrencyId,$IntervalId)  = split('_',$InOut->pgvar('currency_id'));
								
				
				
				$ClientData = BusClient::GetFullUserDataExt($ClientId);
				
				
				
				if(!(@$CurrencyId) || !(@$IntervalId)  || !(@$ClientId)) die('error');

				//reserve ticket

				$TicketPrice = Intervals::GetPriceValue($IntervalId,$CurrencyId);
				$IntervalInfo = Intervals::GetIntervalInfo($IntervalId);

				
				$CurrencyTitle = $Currency = Intervals::GetCurrencyTitle($CurrencyId);
				Tickets::ReserveTicket($NewTicketId,$ClientId,$TicketPrice['price_value'],$CurrencyTitle,$IntervalInfo['title'],1);
				
				
				$InOut->RedirectByFullParams($this->Module->id,'client_tickets',$NewTicketId);




			}
			//	echo 'are you shure?';
			$Data['bus'] = $BusData;
			$Data['TicketPlace'] = $TicketPlace;
			//	var_dump($Data);






			




			
			break;
			case 'client_page':
			$ClientData = BusClient::GetFullUserDataExt($Auth->GetParam());
			
			if(empty($ClientData)) die('access denied!');
			$Data['client_data'] = $ClientData;
			
				
			//if we want to logout
			if(( string) $InOut->InAction == 'logout'){


				$Auth->CloseSession();

				$Auth->KillSid();


				$InOut->RedirectAlias('main');
				exit();

			}
			$UnpayedTicketNum = Tickets::GetTicketCount($Auth->GetParam());
			if($UnpayedTicketNum != 0) {
				$Data['Errors'][0]['msg'] = "You have reserved ticket!";
			}
			elseif($InOut->pvar('post')==1){

				$AddForm = new Form($Lang);
				$AddForm->ProceedForm('addbus');
				$Errors = $AddForm->GetErrorsArray();
				$Routes = new Route();
				$Bus = new Bus();

				if(empty($Errors)){

					$Route = $AddForm->GetField("SelRoute");

					$Year = $AddForm->GetField("SelYear");
					$Month = $AddForm->GetField("SelMonth");
					$Day = $AddForm->GetField("SelDay");

					//check if we can create bus with such day
					$OurRoute = $Routes->GetSingleRoute($Route);


					if(empty($OurRoute)){

						$Data['Errors'][count($Data['Errors'])]['msg'] = "No such route";
					}else{

						$Found = 0;
						$GiveTime = mktime(0,0,0,$Month,$Day,$Year);
						$GivenWeekDay = date('w',$GiveTime);


						$Found = 0;
						if(!empty($OurRoute['days'])) foreach ($OurRoute['days'] as $Day) {
							//	echo $Day['day_departure'].'<br>';
							if($Day['day_departure'] == $GivenWeekDay) {
								$FoundDay = $Day;
								$Found = 1;
								break;
							}

						}



						if($Found  == 1) {

							//check if such bus exists in that date
							if($GiveTime< time()) $Data['Errors'][0]['msg'] = "Bus creating error!";

							else {

								//	if($Bus->InsertBus($OurRoute,$FoundDay,$GiveTime,$this->User->User)) die('database error');
								//$InOut->RedirectByFullParams($this->Module->id,'buses');
								//echo 'Yep';

								if($BusId = $Bus->GetBusByParams($GiveTime,$Route)) {

									$InOut->RedirectByFullParams($this->Module->id,'cbusmanage',$BusId);

								}
								else{
									//	echo 'dddd';
									//							exit();
									//echo 'bus no exist';
									$BusAuth = new BusUserAuth();
									$ClientData = $BusAuth->GetUserData($Auth->GetParam(),'client');

									if($Id = $Bus->InsertBus($OurRoute,$FoundDay,$GiveTime,$ClientData->Name)) {

										$InOut->RedirectByFullParams($this->Module->id,'cbusmanage',$Id);
										exit();
									}else{
										$InOut->RedirectByFullParams($this->Module->id,'client_page');
									}




								}
								//	var_dump($OurRoute);
								//var_dump($FoundDay);

							}


						}else {
							$Data['Errors'][0]['msg'] = 'Can\'t find such day';



						}
					}
				}else $Data['Errors'] = $Errors;
			}
			$BusAuth = new BusUserAuth();
			$Bus = new Bus();
			
			
			
			$Routes = new Route();
			$RoutesData = $Routes->GetAllRoutes(1);
			//			var_dump($RoutesData);

			
			$JString = $Bus->CreateRouteArray(time(),mktime(0,0,0,12,29,2005),$RoutesData);

			$Data['Jstring'] = $JString;
			//var_dump($Data['Errors']);
			break;
			
			case 'clients':
			$Data['clients'] = BusClient::GetClients(0);


			break;

			case 'register_client':

			if($InOut->pvar('post') == 1){
				$Form = new Form($Lang);
				$Form->ProceedForm('register_user');
				$Errors = $Form->GetErrorsArray();


				if(empty($Errors)){
					if($Form->GetField('client_password1') != $Form->GetField('client_password2')){

						$Errors[0]['msg'] = 'Password1 and password2 error!';
					}

				}
				if(empty($Errors)){

					$BusUser = new BusClient();
					$Id = $BusUser->RegisterNewUser($Form->GetField('client_name'),$Form->GetField('client_phone1'),$Form->GetField('client_phone2'),$Form->GetField('client_email'),$Form->GetField('client_login'),$Form->GetField('client_password1'));


					$InOut->RedirectByFullParams($this->Module->id,'client',$Id);


				}else{
					$Data['Errors'] = $Errors;

					$Data['post'] = $Form->GetPostArray();
				}
			}





			break;

			case 'client':

			if(!$ClientId = (int) $this->Object->param) die('no param');
			if($InOut->pgvar('delete')==1){
				// check for user history

				$Tickets = Tickets::GetClientTickets($ClientId,0);
				if (!empty($Tickets)) $Data['Errors']['0']['msg'] = 'cannot delete client. Some ticket history exists';
				else{

					BusClient::DeleteClient($ClientId);
					$InOut->RedirectByFullParams($this->Module->id,'clients');



				}




			}

			$Client = BusClient::GetFullUserDataExt($ClientId,0);

			if(empty($Client)) $Data['Errors'][0]['msg'] = 'No such client';
			else $Data['client'] = $Client;
			$Data['tickets'] = Tickets::GetClientTickets($ClientId,0);
			$Data['discount'] = BusClient::GetClientDiscount($ClientId);
			
			//var_dump($Data['tickets']);

			break;

			case 'edit_client':
			if(! ((int) $ClientId = $this->Object->param)) die('no param'); //create redirect

			if($InOut->pvar('post') == 1){
				if(empty($_POST['client_password1'])){

					$_POST['client_password1'] = 'empty';
					$_POST['client_password2'] = 'empty';

				}
				$Form = new Form($Lang);
				$Form->FormArrayFlag = 1;
				$Form->ProceedForm('register_user');
				$Errors = $Form->GetErrorsArray();


				if(empty($Errors)){
					if($Form->GetField('client_password1') != $Form->GetField('client_password2')){

						$Errors[0]['msg'] = 'Password1 and password2 error!';
					}

				}
				if(empty($Errors)){

					$ClientArray = $Form->GetFormArray();
					if($ClientArray['client_password1'] == 'empty') {

					}else{

						$ClientArray['client_password'] = md5($ClientArray['client_password1']);


					}
					unset($ClientArray['client_password1']);
					unset($ClientArray['client_password2']);



					//var_dump($ClientArray);
					BusClient::UpdateClientData($ClientId,$ClientArray);


					$InOut->RedirectByFullParams($this->Module->id,'client',$ClientId);


				}else{
					$Data['Errors'] = $Errors;

					$Data['post'] = $Form->GetPostArray();
				}
			}


			$Data['client'] = BusClient::GetFullUserDataExt($ClientId);
			


			break;


			case 'print_ticket':

			$BusAuth = new BusUserAuth();
			if(! ((int) $TicketId = $this->Object->param)) die('no param'); //create redirect




			$TicketObj = new Tickets();
			$NewTicketId = $TicketId;

			$NewTicketData = $TicketObj->GetTicketExt($TicketId,0);
			if(empty($NewTicketData)) die('wrong ticket');

			$BusData = Bus::GetBus($NewTicketData['bus_id']);

			$Data['ticket_id'] = $TicketId;
			$Data['now_date'] = date('d',time());

			$Data['now_year'] = date('Y',time());

			$Data['now_month'] = date('m',time());
			$Data['now_month'] .= " ";
			$Data['route_id'] = $BusData['route_id'];
			$this->Object->template = 'ticket_print.tmpl';
			$Data['dealer_corp_name'] = 'Infobus Praha';
			$StationsObj = new Stations();
			$Stations = $StationsObj->GetAllStations($BusData['route_id'],$Lang);
			$Data['depar_station'] = $Stations[0]['point_latin_name'];
			$Index = count($Stations)-1;
			$Data['arrival_station'] = $Stations[$Index]['point_latin_name'];

			if($NewTicketData['user_type'] != 1) die('test');

			$ClientData = BusClient::GetFullUserDataExt($NewTicketData['dclient_id']);
			//var_dump($ClientData);
			$Data['member']  = $ClientData['client_name'];

			$Data['depar_time'] = $BusData['bus_time_depar'];
			$DateArray = split('-',$BusData['bus_day_depar']);
			$Data['depar_year'] = $DateArray[0];
			$Data['depar_month'] = $DateArray[1];
			$Data['depar_day'] = $DateArray[2];
			$Discount = BusClient::GetClientDiscount($ClientData['client_id']);
			if($Discount >0){
				$NewTicketData['ticket_price'] = $NewTicketData['ticket_price'] * ($Discount/100+1);;
				
				
				
			}
			$Data['discount'] = $Discount;
			$Data['ticket_price'] = $NewTicketData['ticket_price'].' '.$NewTicketData['ticket_currency_title'];
			
			$Data['user_id'] = $ClientData['client_id'];
			
			
			
			$Data['pdf'] = 1;
			






			break;


			case 'reserveticket':

			if( !($TicketParam = $this->Object->param)) $InOut->RedirectByFullParams($this->Module->id,'buses');
			preg_match("/^([0-9]*)_([0-9]*)$/",$TicketParam,$Result);
			if(empty($Result)) $InOut->RedirectByFullParams($this->Module->id,'partners_page');
			$TicketPlace = (int)$Result[1];
			$BusId = (int)$Result[2];

			$DayId = Bus::GetBusDaysId($BusId);
			
			$Bus = new Bus();
			Intervals::LoadIntervals($DayId,1);
			$Data['intervals'] = Intervals::GetIntervals();
			
			$PartnerData = BusUserAuth::GetUserData($Auth->GetParam(),'partner');
			if(empty($PartnerData)) die('access denied');
			else $PartnerId = $Auth->GetParam();
			$Data['clients'] = BusClient::GetClients(0);
			

			if(!$BusData = $Bus->GetBus($BusId)) die('bad bus');


			//			$Form = new Form($Lang);
			//			$Member = $Form->GetField('member');
			//			if(!$Member) $Errors[0]['msg'] = 'Bad name!';

			
			if($InOut->pvar('post') == 1 && (empty($Errors))){
			
				$ClientId = (int) $InOut->pgvar('client_id');
				if(!$ClientId) die('Choose client name');
				
				//check user id
				
				
				



				$TicketObj = new Tickets();
				
				$TicketData = $TicketObj->GetTicketInfo($BusId,$TicketPlace);
				//var_dump($TicketData);
				if(!empty($TicketData))
				if(@$TicketData['ticket_status'] != 'free' ) die('ticket error'); //redirect here
				//delete free ticket
				if(!empty($TicketData)) {
					$BusAuth = new BusUserAuth();
					$LogData['id'] = $Auth->GetParam();
					$LogData['User'] = 'dealer';

					$TicketObj->DeleteTicket($TicketData['ticket_id']);
				}

				if($TicketObj->IsTicketExistsExt($BusId,$TicketPlace) || (!$Bus->CanAddNewTicket($BusId))){

					$InOut->RedirectByFullParams($this->Module->id,'ptickets');
				}
				$BusAuth = new BusUserAuth();
				$PartnerData = $BusAuth->GetUserData($Auth->GetParam(),'partner');


				$NewTicketId = $TicketObj->AddTicket($BusId,'reserved','dealer',$PartnerData->Id,$TicketPlace);
				list($CurrencyId,$IntervalId)  = split('_',$InOut->pgvar('currency_id'));
								
				
				
				$ClientData = BusClient::GetFullUserDataExt($ClientId,$Auth->GetParam());
				
				
				
				if(!(@$CurrencyId) || !(@$IntervalId)  || !(@$ClientId)) die('error');

				//reserve ticket

				$TicketPrice = Intervals::GetPriceValue($IntervalId,$CurrencyId);
				$IntervalInfo = Intervals::GetIntervalInfo($IntervalId);

				
				$CurrencyTitle = $Currency = Intervals::GetCurrencyTitle($CurrencyId);
				Tickets::ReserveTicket($NewTicketId,$ClientId,$TicketPrice['price_value'],$CurrencyTitle,$IntervalInfo['title'],1);
				
				
				$InOut->RedirectByFullParams($this->Module->id,'dticket',$NewTicketId);




			}
			//	echo 'are you shure?';
			$Data['bus'] = $BusData;
			$Data['TicketPlace'] = $TicketPlace;
			//	var_dump($Data);






			break;

			case 'busmanage': //for users and dealers
			//check data

			if((int) $this->Object->param == 0) die('no param'); //create redirect

			else $BusId = (int) $this->Object->param;
			$UserData = BusUserAuth::GetUserData($Auth->GetParam(),'partner');
			if(empty($UserData)) die('Access denied');
		

			$Bus = new Bus();
			$Data['Bus'] = $Bus->GetBus($BusId);


			$Ticket = new Tickets();
			$PlacesRange = $Data['Bus']['places_range'];
			$PlacesRangeArray = split(',',$PlacesRange);

			if(!empty($PlacesRangeArray)){


				
				$Data['Tickets'] = $Ticket->GetTickets($BusId,$PlacesRangeArray,0,'free');

				$Data['bus_places_num'] = $Ticket->GetPlacesNum();
			}else{

				$Data['Errors'][0] = 'Something wrong with places range!';

			}

			//var_dump($Errors);
			break;
			
			case 'cbusmanage': //for users and dealers
			//check data
			

			if((int) $this->Object->param == 0) die('no param'); //create redirect

			else $BusId = (int) $this->Object->param;
			
			$UserData = BusUserAuth::GetUserData($Auth->GetParam(),'client');
			if(empty($UserData)) die('Access denied');
		
			
			
			$Bus = new Bus();
			$Data['Bus'] = $Bus->GetBus($BusId);


			$Ticket = new Tickets();
			$PlacesRange = $Data['Bus']['places_range'];
			$PlacesRangeArray = split(',',$PlacesRange);

			if(!empty($PlacesRangeArray)){


				
				$Data['Tickets'] = $Ticket->GetTickets($BusId,$PlacesRangeArray,0,'free');

				$Data['bus_places_num'] = $Ticket->GetPlacesNum();
			}else{

				$Data['Errors'][0] = 'Something wrong with places range!';

			}

			//var_dump($Errors);
			break;
			
			

			case 'dticket':

			$BusAuth = new BusUserAuth();
			if(! ((int) $TicketId = $this->Object->param)) die('no param'); //create redirect

		

			$Id = $Auth->GetParam();
			$PartnerData = $BusAuth->GetUserData($Id,'partner');
			if(!$PartnerData) die('access denied!');

			
			if($InOut->gvar('action') == 'print'){

	
			if(! ((int) $TicketId = $this->Object->param)) die('no param'); //create redirect



			
			
			$TicketObj = new Tickets();
			$NewTicketId = $TicketId;

			$NewTicketData = $TicketObj->GetTicketExt($TicketId,$Id);
			
			if(empty($NewTicketData)) die('no ticket data');

			$BusData = Bus::GetBus($NewTicketData['bus_id']);

			$Data['ticket_id'] = $TicketId;
			$Data['now_date'] = date('d',time());

			$Data['now_year'] = date('Y',time());

			$Data['now_month'] = date('m',time());
			$Data['now_month'] .= " ";
			$Data['route_id'] = $BusData['route_id'];
			$this->Object->template = 'ticket_print.tmpl';
			
			$Data['dealer_corp_name'] = $PartnerData->CorpName;
			$StationsObj = new Stations();
			$Stations = $StationsObj->GetAllStations($BusData['route_id'],$Lang);
			$Data['depar_station'] = $Stations[0]['point_latin_name'];
			$Index = count($Stations)-1;
			$Data['arrival_station'] = $Stations[$Index]['point_latin_name'];

			if($NewTicketData['user_type'] != 1) die('test');

			$ClientData = BusClient::GetFullUserDataExt($NewTicketData['dclient_id']);
			//var_dump($ClientData);
			$Data['member']  = $ClientData['client_name'];

			$Data['depar_time'] = $BusData['bus_time_depar'];
			$DateArray = split('-',$BusData['bus_day_depar']);
			$Data['depar_year'] = $DateArray[0];
			$Data['depar_month'] = $DateArray[1];
			$Data['depar_day'] = $DateArray[2];
			$Discount = BusClient::GetClientDiscount($ClientData['client_id']);
			if($Discount >0){
				$NewTicketData['ticket_price'] = $NewTicketData['ticket_price'] *($Discount/100+1);
				
				
				
			}
			$Data['discount'] = $Discount;
			
			$Data['ticket_price'] = $NewTicketData['ticket_price'].' '.$NewTicketData['ticket_currency_title'];
			$Data['user_id'] = $ClientData['client_id'];
			
			
			$Data['pdf'] = 1;






			}else{

				$Data['Ticket'] = Tickets::GetTicketExt($TicketId,$Id);
				$Discount = BusClient::GetClientDiscount($Data['Ticket']['dclient_id']);
				if ($Discount > 0) $Data['ticket_price_with_discount'] = $Data['Ticket']['ticket_price'] *($Discount/100+1);
				else $Data['ticket_price_with_discount'] = $Data['Ticket']['ticket_price'];
				$Data['discount'] = $Discount;
				if(empty($Data['Ticket'])) die('no access!');
				
				
				//$Data['client'] = BusClient::GetFullUserDataExt($Data['Ticket']['']$Id)
			//	var_dump($Data['Ticket']);
				
			}

			break;

			case 'ptickets':
			//get all tickets that partner reserved

			$BusAuth = new BusUserAuth();
			$TicketObj = new Tickets();
			$PartnerData = $BusAuth->GetUserData($Auth->GetParam(),'partner');
			if(empty($PartnerData)) die('no access!');

			if($RollBackTicketid = (int) $InOut->gvar('rollback')){
				$Ticket = $TicketObj->GetTicket($RollBackTicketid,$Owner = 'dealer',$PartnerData->Id);

				if(!empty($Ticket)){
					$LogData['id'] = $Auth->GetParam();
					$LogData['User'] = 'dealer';

					$TicketObj->DeleteTicket($RollBackTicketid,$Auth->GetParam());


				}



			}



			$Tickets = $TicketObj->GetDealerTickets($PartnerData->Id,1);
			$Data['tickets'] = $Tickets;
			//var_dump($Tickets);
			//var_dump($Tickets);




			break;

			case 'dclient':
			$BusAuth = new BusUserAuth();
			if(! ((int) $ClientId = $this->Object->param)) die('no param'); //create redirect



			$Id = $Auth->GetParam();
			$PartnerData = $BusAuth->GetUserData($Id,'partner');
			if(!$PartnerData) die('access denied!');
			if($InOut->pvar('post') == 1){

				if(($InOut->pvar('dclient_name')) && ($InOut->pvar('dclient_info'))){
					$arr['dclient_name'] = $InOut->pvar('dclient_name');
					$arr['dclient_info'] = $InOut->pvar('dclient_info');

					dClients::UpdateClientInfo($ClientId,$Id,$arr);

				}




			}
			$Data['PartnerData'] = $PartnerData;

			$Data['ClientData'] = BusClient::GetFullUserDataExt($ClientId,$Id);
			
			
			if(!empty($Data['ClientData'])) $Data['tickets'] = Tickets::GetClientTickets($ClientId,$Id);

			break;

			case 'dclients':

			$BusAuth = new BusUserAuth();

			$Id = $Auth->GetParam();
			$PartnerData = $BusAuth->GetUserData($Id,'partner');
			if(!$PartnerData) die('access denied!');



			if((int) $InOut->pvar('post') == 1){
				$Form = new Form($Lang);
				$Form->FormArrayFlag = 1;
				$Form->ProceedForm('register_user');
				$Errors = $Form->GetErrorsArray();

				if(empty($Errors)) 
				if($Form->GetField('client_password1') != $Form->GetField('client_password2')){

						$Errors[0]['msg'] = 'Password1 and password2 error!';
					}
					
				if(empty($Errors)){
					$arr = $Form->GetFormArray();
					$arr['dealer_id'] = $Id;
					
						
				

				

				$arr['client_password'] = md5($arr['client_password1']);

				
					unset($arr['client_password1']);
					unset($arr['client_password2']);

					//var_dump($arr);
					//dClients::AddClient($arr);
					var_dump($arr);
					
					BusClient::AddClient($arr);
					
					
				}
				else{
					$Data['Errors'] = $Errors;
					$Data['post'] = $Form->GetPostArray();
				}


			}elseif($DeleteId = (int) $InOut->gvar('delete')){
				$ClientData = BusClient::GetFullUserDataExt($DeleteId,$Id);
				
				$Tickets = Tickets::GetClientTickets($DeleteId,$Id);
				
				if(empty($ClientData)){
					$Data['Errors'][0]['msg'] = "Couldn't delete client.";
				}
				elseif (!empty($Tickets)){

					$Data['Errors'][0]['msg'] = "Couldn't delete client because of ticket history!";
				}else{
					
					BusClient::DeleteClient($DeleteId);
				
				}

			}

			$dClients = BusClient::GetClients(0);

			$Data['clients'] = $dClients;
			

			break;


			case 'partners_page':

			$InOut->InAction;
			//if we want to logout
			if(( string) $InOut->InAction == 'logout'){


				$Auth->CloseSession();

				$Auth->KillSid();


				$InOut->RedirectAlias('main');
				exit();

			}
			if($InOut->pvar('post')==1){

				$AddForm = new Form($Lang);
				$AddForm->ProceedForm('addbus');
				$Errors = $AddForm->GetErrorsArray();
				$Routes = new Route();
				$Bus = new Bus();

				if(empty($Errors)){

					$Route = $AddForm->GetField("SelRoute");

					$Year = $AddForm->GetField("SelYear");
					$Month = $AddForm->GetField("SelMonth");
					$Day = $AddForm->GetField("SelDay");

					//check if we can create bus with such day
					$OurRoute = $Routes->GetSingleRoute($Route);


					if(empty($OurRoute)){

						$Data['Errors'][count($Data['Errors'])]['msg'] = "No such route";
					}else{

						$Found = 0;
						$GiveTime = mktime(0,0,0,$Month,$Day,$Year);
						$GivenWeekDay = date('w',$GiveTime);


						$Found = 0;
						if(!empty($OurRoute['days'])) foreach ($OurRoute['days'] as $Day) {
							//	echo $Day['day_departure'].'<br>';
							if($Day['day_departure'] == $GivenWeekDay) {
								$FoundDay = $Day;
								$Found = 1;
								break;
							}

						}



						if($Found  == 1) {

							//check if such bus exists in that date
							if($GiveTime< time()) $Data['Errors'][0]['msg'] = "Bus creating error!";

							else {

								//	if($Bus->InsertBus($OurRoute,$FoundDay,$GiveTime,$this->User->User)) die('database error');
								//$InOut->RedirectByFullParams($this->Module->id,'buses');
								//echo 'Yep';

								if($BusId = $Bus->GetBusByParams($GiveTime,$Route)) {

									$InOut->RedirectByFullParams($this->Module->id,'busmanage',$BusId);

								}
								else{
									//	echo 'dddd';
									//							exit();
									//echo 'bus no exist';
									$BusAuth = new BusUserAuth();
									$PartnerData = $BusAuth->GetUserData($Auth->GetParam(),'partner');

									if($Id = $Bus->InsertBus($OurRoute,$FoundDay,$GiveTime,$PartnerData->CorpName)) {

										$InOut->RedirectByFullParams($this->Module->id,'busmanage',$Id);
										exit();
									}else{
										$InOut->RedirectByFullParams($this->Module->id,'partners_page');
									}




								}
								//	var_dump($OurRoute);
								//var_dump($FoundDay);

							}


						}else {
							$Data['Errors'][0]['msg'] = 'Can\'t find such day';



						}
					}
				}else $Data['Errors'] = $Errors;
			}
			$BusAuth = new BusUserAuth();
			$Bus = new Bus();
			$Auth->GetParam();
			$PartnerData = $BusAuth->GetUserData($Auth->GetParam(),'partner');
			if(!$PartnerData) die('access denied!');

			$Routes = new Route();
			$RoutesData = $Routes->GetAllRoutes(1);
			//			var_dump($RoutesData);

			$Data['Data'] = get_object_vars($PartnerData);
			$JString = $Bus->CreateRouteArray(time(),mktime(0,0,0,12,29,2005),$RoutesData);

			$Data['Jstring'] = $JString;
			//var_dump($Data['Errors']);



			break;
			case 'bus_types':
			$BusTypes = new BusTypes();
			$Data['bus_types'] = $BusTypes->GetBusTypes();
			$Data['bus_owners'] = $BusTypes->GetBusOwners();


			if($InOut->pvar('post')) {

				$Form = new Form($Lang);
				$Form->ProceedForm('addbustype');
				$Errors = $Form->GetErrorsArray();
				//	var_dump($_POST);
				//check for file upload
				$Pic = 0;
				if(empty($Errors)){
					$types[0] = 'image/pjpeg';
					$types[1] = 'image/jpeg';
					$Jpg = $InOut->CheckUploadedFile('bustype_pic',$types,300000);
					if(!empty($Jpg)) {
						//$Errors['0']['msg'] = 'No file found';
						$Pic = 1;

					}



				}
				if(empty($Errors)){


					$InsertId = $BusTypes->InsertBusType($Form->GetField('bustype_title'),$Form->GetField('bustype_places_num'),(int) $Form->GetField('bustype_tv'),(int)$Form->GetField('bustype_toilet'),(int) $Form->GetField('bustype_cond'),(int) $Form->GetField('bustype_bar'),$Form->GetField('busowner_id'),$Pic);
					if($InsertId && $Pic ==1){

						copy($Jpg,$_SERVER['DOCUMENT_ROOT']."/images/bus_img/$InsertId.jpg");

					}
					$InOut->RedirectByFullParams($this->Module->id,'bus_types');


				}else{
					$Data['post'] = $Form->GetPostArray();
					$Data['Errors'] = $Errors;

				}

			}


			break;
			case 'bus_owners':

			$BusTypes = new BusTypes();
			$Data['bus_owners'] = $BusTypes->GetBusOwners();

			if($InOut->pvar('post')) {

				$Form = new Form($Lang);
				$Form->ProceedForm('addbusowner');
				$Errors = $Form->GetErrorsArray();
				if(empty($Errors)){


					$BusTypes->InsertBusOwner($Form->GetField('busowner_title'),$Form->GetField('busowner_inn'),$Form->GetField('busowner_address'),$Form->GetField('busowner_phone1'),$Form->GetField('busowner_phone2'),$Form->GetField('busowner_fax'),$Form->GetField('busowner_email'));
					$InOut->RedirectByFullParams($this->Module->id,'bus_owners');


				}else{
					$Data['post'] = $Form->GetPostArray();
					$Data['Errors'] = $Errors;

				}

			}



			break;

			case 'editroute':

			if(!$RouteId = $this->Object->param) $InOut->RedirectByFullParams($this->Module->id,'routes');

			$RoutesObj = new Route();
			if(!$RoutesObj->IsRouteExist($RouteId)) $InOut->RedirectByFullParams($this->Module->id,'notfound');
			$EditForm = new Form($Lang);
			
			$Data['routes'] = $RoutesObj->GetSingleRoute($RouteId);
			$Data['days'] = &$Data['routes']['days'];
			
			if($EditForm->GetField('post') ==1){
				$RealDaysNum = Days::CountDays($RouteId);

				$EditForm->SetGroupFieldNum('day',$RealDaysNum);
				$EditForm->ProceedForm('addroute',$RealDaysNum);
				$Errors = $EditForm->GetErrorsArray();
				//

				if(empty($Errors)){
					//update data
					//todo: update data

					$RouteObj = new Route();

					$DaysArray = $EditForm->GetFormGroupsArray('addroute','day');

					$RouteObj->UpdateRoute($RouteId,$EditForm->GetField('route_name_latin'),$EditForm->GetField('route_name_ru'),$DaysArray);

					$InOut->RedirectByFullParams($this->Module->id,'editroute',$RouteId);

				}else	$Data['Errors'] = $Errors;

			}elseif($DeleteDaysId = (int) $InOut->gvar('delete')){

				Days::DeleteDay($DeleteDaysId);
				

			}elseif ($DeleteStationId = (int) $InOut->gvar('delete_station')){
				Stations::DeleteStation($DeleteStationId);
				Intervals::DeleteRouteIntervals($RouteId);
				if(!empty($Data['days']))
				foreach ($Data['days'] as &$Day) {
					
					Stations::DeleteTimings($Day['days_id']);
					
				
				}
				

			}
//			convert_cyr_string()
			if(!empty($Data['days']))
			foreach ($Data['days'] as &$Day) {

				$arr = split(':',$Day['time_departure']) ;
				$arr2 = split(':',$Day['time_arrival']) ;
				$Day['time_departure_hours'] = $arr[0];
				$Day['time_departure_minute'] = $arr[1];
				$Day['time_arrival_hours'] = $arr2[0];
				$Day['time_arrival_minute'] = $arr2[1];
				$Day['bustype_id2'] = $Day['bustype_id'];


			}
			$BusTypesObj = new BusTypes();

			$Data['bus_types'] = $BusTypesObj->GetBusTypes();

			$Data['days_num'] = count($Data['days']);
			$Stations = new Stations();
			$Data['stations'] = $Stations->GetAllStations($RouteId,$Lang);


			break;
			case 'newticket':
			@$TicketParam = (string) $this->Object->param;
			if(empty($TicketParam)) $InOut->RedirectByFullParams($this->Module->id,'buses');
			preg_match("/^([0-9]*)_([0-9]*)$/",$TicketParam,$Result);
			if(empty($Result)) $InOut->RedirectByFullParams($this->Module->id,'buses');
			$TicketPlace = (int)$Result[1];
			$BusId = (int)$Result[2];
			$Ticket = new Tickets();
			$Bus = new Bus();
			if($Ticket->IsTicketExistsExt($BusId,$TicketPlace) || (!$Bus->CanAddNewTicket($BusId))){
				$InOut->RedirectByFullParams($this->Module->id,'buses');
				die('bad');
			}


			if($NewTicketId = $Ticket->AddTicket($BusId,'free','admin',$this->User->UserId,$TicketPlace)){

				//success

				$InOut->RedirectByFullParams($this->Module->id,'ticket',$NewTicketId);

			}else{
				die('ccc');
			}

			break;
			case 'ticket':


			$Action = $InOut->gvar('action');

			$Tickets = new Tickets();
			if((int) ($TicketId = $this->Object->param) == 0) $InOut->RedirectByFullParams($this->Module->id,'buses');
			if(!$Tickets->IsTicketExists($TicketId)) $InOut->RedirectByFullParams($this->Module->id,'buses');
			
			$Ticket = $Tickets->GetTicket($TicketId);
			



			switch ($Action) {
				case 'app':

				$Tickets->SetTicketStatus($TicketId,'reserved');
				$InOut->RedirectByFullParams($this->Module->id,'ticket',$TicketId);


				break;

				case 'notapp':
				$Tickets->SetTicketStatus($TicketId,'waiting');
				$InOut->RedirectByFullParams($this->Module->id,'ticket',$TicketId);

				break;
				case 'del';
				$Tickets->DeleteTicket($TicketId,$Auth->GetUserId());

				$InOut->RedirectByFullParams($this->Module->id,'bus',$Ticket['bus_id']);
				break;
				case 'wait':
				$Tickets->SetTicketStatus($TicketId,'waiting');
				$InOut->RedirectByFullParams($this->Module->id,'ticket',$TicketId);

				break;
				case 'setpayed':

				$Tickets->SetTicketPayed($TicketId,1);
				$InOut->RedirectByFullParams($this->Module->id,'ticket',$TicketId);

				break;

				case 'setunpayed':

				$Tickets->SetTicketPayed($TicketId,0);
				$InOut->RedirectByFullParams($this->Module->id,'ticket',$TicketId);

				break;


			}




			//check if sucj tikcet exists




			$BusObj = new Bus();
			
			$Bus = $BusObj->GetBus($Ticket['bus_id']);
			
			$Owner = $Ticket['ticket_owner'];
			if($Ticket['ticket_status'] == 'waiting') $Data['waiting_status'] = 1;
			elseif ($Ticket['ticket_status'] == 'reserved') $Data['reserved_status'] = 1;
			elseif ($Ticket['ticket_status'] == 'free') $Data['free_status'] = 1;
			$OwnerId = $Ticket['ticket_owner_id'];

			switch ($Owner){
				case 'dealer':
				$DealerObj = new Dealer();
				$Data['owner'] =  $DealerObj->GetDealer($OwnerId);

				break;
				case 'admin':

				$Data['user_name'] =  $Auth->GetUserName($OwnerId);


				break;

				case 'free':
				$OwnerData['free'] = 1;
				break;
				//todo case user



			}






			if(empty($Bus)) $InOut->RedirectByFullParams($this->Module->id,'buses');

			$Data['bus'] = $Bus;


			switch ($Ticket['ticket_status']) {
				case 'free':
				$Ticket['status'] = 1;
				break;

				case 'waiting':
				$Ticket['status'] = 2;
				break;

				case 'reserved':
				$Ticket['status'] = 3;
				break;

			}

			$Data['ticket'] = $Ticket;
			$Discount = BusClient::GetClientDiscount($Data['ticket']['dclient_id']);
			if ($Discount > 0) $Data['ticket_price_with_discount'] = $Data['ticket']['ticket_price'] *($Discount/100+1);
			else $Data['ticket_price_with_discount'] = $Data['ticket']['ticket_price'];
			$Data['discount'] = $Discount;
			
			switch ($Ticket['user_type']){
				case 1: //common users

				$Client = BusClient::GetFullUserDataExt(($Ticket['dclient_id']));
				break;
				case 2: //dealer  user
				break;

			}
			//var_dump($Data);
			//			var_dump($Client);
			//todo: history;
			if(isset($Client)) $Data['client'] = $Client;





			break;
			
			
			case 'partner':
			if((int) $this->Object->param == 0) $DealerId = 1;
			else 	$DealerId = $this->Object->param;
			$Partner = new Dealer();
			if($Action = $InOut->gvar('action'))
			switch ($Action) {
				case 'active':

				$Partner->SetActiveFlag($DealerId,1);
				break;
				case 'notactive':

				$Partner->SetActiveFlag($DealerId,0);
				break;

				default:
				break;
			}

			$Data['Dealer'] = $Partner->GetDealer($DealerId);
			//$Partner->GetDealerTickers($DealerId);
			$Tickets = new Tickets();
			$Data['tickets'] = $Tickets->GetDealerTickets($DealerId);
			$Data['Log'] = ActionsLog::GetLogRecords($DealerId,'dealer');
			//$Data['stats'] = $Tickets->GetPayedDealerTicketsCount($DealerId);

			//var_dump($Data['Log']);


			break;

			case 'editpartner':
			$Password = null;
			if(( (int) $PartnerId =$this->Object->param) == 0) $InOut->RedirectByFullParams($this->Module->id,'partners');
			$PartnerObj = new Dealer();
			$Data['Partner'] = $PartnerObj->GetDealer($PartnerId);
			$Form = new Form($Lang);
			if($Form->GetField('post') == 1){

				$Form->ProceedForm('editpartner');

				$Errors = $Form->GetErrorsArray();
				if(empty($Errors)){
					@$Pass1 = $Form->GetField('dealer_password1');
					if(!empty($Pass1)){
						if($Pass1 != $Form->GetField('dealer_password2')) $Errors[0]['msg'] = "Passsword1 != Password2!";
						else $Password = $Pass1;

					}


				}

				if (empty($Errors)){

					$PartnerObj->UpdateDealer($PartnerId,$Form->GetField('currency_id'),$Form->GetField('dealer_corp_name'),$Form->GetField('dealer_inn'),$Form->GetField('dealer_address'),$Form->GetField('dealer_phone1'),$Form->GetField('dealer_phone2'),$Form->GetField('dealer_email'),$Form->GetField('dealer_login'),$Password);

					$InOut->RedirectByFullParams($this->Module->id,'partner',$PartnerId);
				}else $Data['Errors'] = $Errors;
			}
			$Data['currs'] = Intervals::GetCurrencies();

			break;

			case 'addpartner':



			$AddPartnerForm = new Form($Lang);

			if($AddPartnerForm->GetField('post') == 1){

				$AddPartnerForm->ProceedForm('addpartner');

				$Errors = $AddPartnerForm->GetErrorsArray();
				$AddPartnerForm->GetField('password1');
				$AddPartnerForm->GetField('password2');
				if(empty($Errors)){
					if($AddPartnerForm->GetField('dealer_password1') != $AddPartnerForm->GetField('dealer_password2')){
						$Errors[0]['msg'] = 'Password 1 and password 2 are the same';

					}



				}


				if(empty($Errors)){
					$Dealer = new Dealer();
					$Dealer->InsertDealer($AddPartnerForm->GetField('dealer_corp_name'),$AddPartnerForm->GetField('dealer_inn'),$AddPartnerForm->GetField('dealer_address'),$AddPartnerForm->GetField('dealer_phone1'),$AddPartnerForm->GetField('dealer_phone2'),$AddPartnerForm->GetField('dealer_email'),$AddPartnerForm->GetField('dealer_login'),$AddPartnerForm->GetField('dealer_password1'),$AddPartnerForm->GetField('currency_id'));
					$InOut->RedirectByFullParams($this->Module->id,'partners');
					exit();


				}else {
					$Data['Errors'] = $Errors;
					$Data['Post'] = $AddPartnerForm->GetPostArray();
				}

			}

			$Data['currs'] = Intervals::GetCurrencies();
			break;

			case 'partners':
			$Partner = new Dealer();

			$Data['Partners'] = $Partner->GetDealers();

			break;

			case 'bus':

			if((int) $this->Object->param == 0) $BusId = 1; //create redirect

			else $BusId = (int) $this->Object->param;

			$Bus = new Bus();
			$Data['Bus'] = $Bus->GetBus($BusId);
			$Ticket = new Tickets();
			$PlacesRange = $Data['Bus']['places_range'];
			//preg_match("/^([0-9]*)\-([0-9]*)$/",$PlacesRange,$Range);
			$PlacesRangeArray = split(',',$PlacesRange);

			if(!empty($PlacesRangeArray)){



				$Data['Tickets'] = $Ticket->GetTickets($BusId,$PlacesRangeArray);

				$Data['bus_places_num'] = $Ticket->GetPlacesNum();
			}else{

				$Data['Errors'][0] = 'Something wrong with places range!';

			}


			break;
			case 'addpoint':
			if($InOut->pvar('post')){

				$AddForm = new Form($Lang);
				$AddForm->ProceedForm('addpoint');
				$Errors = $AddForm->GetErrorsArray();
				//var_dump($Errors);
				//die();

				if(empty($Errors)){
					$PointObj = new Point();
					$PointObj->AddPoint($AddForm->GetField('point_latin_name'),$AddForm->GetField('point_ru_name')
					,$AddForm->GetField('point_is_cz'));
					$InOut->RedirectByFullParams($this->Module->id,'points');
				}else{
					$Data['Errors'] = $Errors;

				}
			}
			break;

			case 'buses':
			$Bus = new Bus();
			$Data['Buses'] = $Bus->GetAllBuses();
			//var_dump($Data['Buses']);
			break;

			case 'points':
			$Point = new Point();
			if((int) $PointId = $InOut->gvar('delete')){
				//check if staitaion exists
				if(Route::CheckRouteByPoint($PointId)){

					$Errors[0]['msg'] = 'Cannot delete point. Some route has station with that point!';
					$Data['Errors'] = $Errors;

				}
				else $Point->DeletePoint($PointId);
			}



			$Data['Points'] = $Point->GetPoints($Lang);


			break;

//admin page
			case 'reserve_ticket':
			$Step = (int) $InOut->pgvar('step');


			switch ($Step){
				default:
				case 1:

				$this->Object->template = 'addbus.tmpl';

				$RoutesData = Route::GetAllRoutes();
				$JString = Bus::CreateRouteArray(time(),mktime(0,0,0,12,29,2005),$RoutesData);

				$Data['Jstring'] = $JString;
				$Data['Addbus'] = 1;


				case 2:
				//check  all stuff
				$AddForm = new Form($Lang);
				if($AddForm->GetField("post") ==1) {

					$AddForm->ProceedForm('addbus');
					$Errors = $AddForm->GetErrorsArray();

					if(empty($Errors)){

						$Route = $AddForm->GetField("SelRoute");
						$Year = $AddForm->GetField("SelYear");
						$Month = $AddForm->GetField("SelMonth");
						$Day = $AddForm->GetField("SelDay");

						//check if we can create bus with such day
						$OurRoute = Route::GetSingleRoute($Route);
						if(empty($OurRoute)){

							$Data['Errors'][count($Data['Errors'])]['msg'] = "No such route";
						}else{
							$Found = 0;
							$GiveTime = mktime(0,0,0,$Month,$Day,$Year);
							$GivenWeekDay = date('w',$GiveTime);



							if(!empty($OurRoute['days'])) foreach ($OurRoute['days'] as $Day) {
								//	echo $Day['day_departure'].'<br>';
								if($Day['day_departure'] == $GivenWeekDay) {
									$FoundDay = $Day;
									$Found = 1;
									break;
								}

							}
							if($Found  == 1) {

								//check if such bus exists in that date
								if($GiveTime< time()) $Data['Errors'][0]['msg'] = "Bus creating error!";

								else {

									$BusId = Bus::GetBusByParams($GiveTime,$Route);

									if(!$BusId) $BusId = Bus::InsertBus($OurRoute,$FoundDay,$GiveTime,$this->User->User);
									if(!$BusId) die('database error while adding bus');
									$InOut->RedirectByFullParams($this->Module->id,'bus',$BusId);

									//	var_dump($OurRoute);
									//var_dump($FoundDay);


								}


							}else {
								$Data['Errors'][0]['msg'] = 'Can\'t find such day';



							}


						}

					}else{
						$Step =1;
						$Data['Errors'] = $Errors;

					}
				}
				

				break;

				case 3:
				//check if there free tickets

				$BusId = (int) $InOut->gvar('bus_id');
				$BusData = Bus::GetBus($BusId);
				//var_dump($BusData);

				break;
				case 4:

				//break; //reserve ticket

				$TicketId = (int) $InOut->gvar('ticket_id');

				$this->Object->template = 'rticket_step4.tmpl';
				$Data['clients'] = BusClient::GetClients(0);
				$Data['ticket'] = Tickets::GetTicket($TicketId);
				
				$IntervalObj= new Intervals();
				
				$DaysId = Bus::GetBusDaysId($Data['ticket']['bus_id']);
				$IntervalObj->LoadIntervals($DaysId,1);
				$Data['intervals'] = $IntervalObj->GetIntervals();
				//var_dump($Data['intervals'] );
				break;

				case 5:

				$ClientId = (int) $InOut->pgvar('client_id');
				
				@list($CurrencyId,$IntervalId)  = split('_',$InOut->pgvar('currency_id'));
				$TicketId = (int)$InOut->pgvar('ticket_id');


				if(!((int) @$CurrencyId) || !((int) @$IntervalId)  || !(@$ClientId)) die('error');

				//reserve ticket

				$TicketPrice = Intervals::GetPriceValue($IntervalId,$CurrencyId);
				$IntervalInfo = Intervals::GetIntervalInfo($IntervalId);


				$CurrencyTitle = $Currency = Intervals::GetCurrencyTitle($CurrencyId);
				Tickets::ReserveTicket($TicketId,$ClientId,$TicketPrice['price_value'],$CurrencyTitle,$IntervalInfo['title'],1);
				Tickets::SetTicketStatus($TicketId,'waiting');
				$InOut->RedirectByFullParams($this->Module->id,'ticket',$TicketId);

				//get yu


				break;







			}


			switch ($Step){
				default:
				case 1:
				$this->Object->template = 'addbus.tmpl';
				break;
				case 2:
				$Arr = array('bus_id'=>$BusId,'step'=>3);
				$InOut->RedirectByFullParams($this->Module->id,'reserve_ticket',0,$Arr);

				break;
				case 4:
				break;

			}

			break;



			case 'stations':
			if(!$RouteId = (int) $this->Object->param)  $InOut->RedirectByFullParams($this->Module->id,'notfound');
			elseif(!Route::IsRouteExist($RouteId)) $InOut->RedirectByFullParams($this->Module->id,'notfound');

			$StationsObj = new Stations();
			$Data['stations'] = $StationsObj->GetAllStations($RouteId,$Lang);


			break;
			case 'addstations':


			if(!$this->Object->param)  $InOut->RedirectByFullParams($this->Module->id,'buses');
			$RouteId = $this->Object->param; //todo: check if such RouteId exists
			if(!Route::IsRouteExist($RouteId)) $InOut->RedirectByFullParams($this->Module->id,'buses');


			$StationsNum = (int) $InOut->pvar('num');
			if($StationsNum<1) $StationsNum = 1;
			$OldStationsNum = Stations::GetStationsNum($RouteId);
			$Data['old_num'] = $OldStationsNum;
			$StationIndex = Stations::GetLastOrderIndex($RouteId);

			$Data['num'] = $StationsNum;

			$Data['RouteId'] = $RouteId;
			$StationsForm = new Form($Lang);




			$StationsForm->SetGroupFieldNum('point',$StationsNum);
			$Point = new Point();
			$Data['Points'] = $Point->GetPoints($Lang);

			if($StationsForm->GetField('post') == 1){

				$StationsForm->ProceedForm('addstations');
				$Errors = $StationsForm->GetErrorsArray();
				//var_dump($Errors);
				//exit();
				if(empty($Errors)){ //try to insert data

				$StationsArray = $StationsForm->GetFormGroupsArray('addstations','point');
				$Stations = new Stations();
				$Error = 0;
				foreach ($StationsArray as $Station) {
					if($Stations->IsStationExist($RouteId,$Station['station_order'])) {
						$Error = 1;
						break;
					}

				}
				//var_dump($StationsArray);
				//echo 'err'.$Error;
				if(!$Error){ //double click protection


				$Stations->InsertStations($RouteId,$StationsArray);
				$InOut->RedirectByFullParams($this->Module->id,'editroute',$RouteId);

				}

				//$InOut->RedirectByFullParams($this->Module->id,'routes');
				//	exit();
				//todo insert station


				}else $Data['Errors'] = $Errors;


			}
			$j=$StationIndex;
			for($i=0;$i<$StationsNum;$i++){

				$Data['StationsNum'][$i]['val'] = 0;
				$Data['StationsNum'][$i]['Order'] = $j;
				$j = $j + 10;

			}


			break;

			case 'routes': //get all routes




			$Routes = new Route();
			@$RouteId = $InOut->gvar('delete');
			$SetActiveRouteId =(int) @$InOut->gvar('active');
			$SetNonActiveRouteId =(int) @$InOut->gvar('nonactive');
			if((int) $RouteId ){
				if($Routes->IsRouteExist($RouteId)){

					$Routes->DeleteRoute($RouteId);

				}

			}
			if($SetActiveRouteId){
				$Routes->SetActiveFlag(1,$SetActiveRouteId);
			}elseif ($SetNonActiveRouteId){
				$Routes->SetActiveFlag(0,$SetNonActiveRouteId);
			}
			$Data['Routes'] = $Routes->GetAllRoutes();
			//		print_r($Data['Routes']);



			break;
			case 'adddays':


			if(!$RouteId = (int) $this->Object->param) $InOut->RedirectByFullParams($this->Module->id,'routes');

			$RoutesObj = new Route();

			if(!$RoutesObj->IsRouteExist($RouteId)) $InOut->RedirectByFullParams($this->Module->id,'notfound');
			$DaysNum = (int) $InOut->pvar('num');

			//exit();
			if(!$DaysNum) $DaysNum = 1;

			$Data['num'] = $DaysNum;


			$BusTypesObj = new BusTypes();
			$Data['bus_types'] = $BusTypesObj->GetBusTypes();
			//cho '<br>';
			//var_dump($_POST);
			//exit();
			$Data['route_id'] = $RouteId;


			$Form = new Form($Lang);

			if($Form->GetField('post') ==1){
				$Form->SetGroupFieldNum('day',$DaysNum);
				$Form->ProceedForm('addroute');
				$Errors = $Form->GetErrorsArray();

				if(empty($Errors)){

					$DaysObj = new Days();
					$DayArray = $Form->GetFormGroupsArray('addroute','day');

					$DaysObj->InsertDays($RouteId,$DayArray);

					$InOut->RedirectByFullParams($this->Module->id,'editroute',$RouteId);


				}else{
					$Data['Errors'] = $Errors;
				}

			}


			for($i=0;$i<$DaysNum;$i++){

				$Data['DaysNum'][$i]['val'] =0;


			}

			if($Form->GetField('post') == 1) $Data['PostData'] = $Form->GetPostArray();
			unset($Data['PostData']['route_id']);



			break;
			case 'view_station_t':

			if((int) $DeleteDaysId = $InOut->gvar('delete')) {
				Stations::DeleteTimings($DeleteDaysId);
				$RouteId = Route::GetRouteByDayId($DeleteDaysId);

				$InOut->RedirectByFullParams($this->Module->id,'editroute',$RouteId);



			}

			if(!$DaysId = (int) $this->Object->param) $InOut->RedirectByFullParams($this->Module->id,'routes');
			$Data['days_id'] = $DaysId;
			$Data['timings'] = Stations::GetStationTimings($DaysId);
			//Intervals::CreateIntervals($DaysId);




			break;

			case 'edit_price':
			$Data['days_id'] = (int) $InOut->gvar('days_id');
			if($InOut->pvar('post') == 1){

				$PriceValue = (float) $InOut->pvar("price_value");
				$PriceId = (int) $InOut->pvar("price_id");

				$IntervalObj = new Intervals();
				$IntervalObj->UpdatePriceValue($PriceId,$PriceValue);

				$InOut->RedirectByFullParams($this->Module->id,'intervals',(int) $InOut->pvar('days_id'));


			}
			if(!($PriceId = (int) ($this->Object->param) )) $InOut->RedirectByFullParams($this->Module->id,'routes');

			//$Data['interval_id'] = $IntervalId;
			//$Data['currency_id'] =

			$IntervalObj = new Intervals();
			$Data['price_value'] = $IntervalObj->GetPriceValueExt($PriceId);
			$Data['price_id'] = $PriceId;





			break;

			case 'intervals':

			if(!$DayId = (int) $this->Object->param) $InOut->RedirectByFullParams($this->Module->id,'routes');

			if(!$RouteId = Route::GetRouteByDayId($DayId)) $InOut->RedirectByFullParams($this->Module->id,'routes');

			$Data['RouteId'] = $RouteId;


			//check if intervals exist
			$IntervalObj = new Intervals();
			if((int) $Id = $InOut->gvar('delete')) {
				$IntervalObj->DeleteIntervals($Id);
				$InOut->RedirectByFullParams($this->Module->id,'editroute',$RouteId);
			}
			if($IntervalObj->IfIntervalsExist($DayId) == 0) $IntervalObj->CreateIntervals($DayId);
			$IntervalObj->LoadIntervals($DayId);
			$Data['intervals'] = $IntervalObj->GetIntervals();
			$Data['days_id'] = $DayId;

			//var_dump($IntervalObj);



			break;

			case 'add_station_t':
			//check param;
			if(!$DayId = (int) $this->Object->param) $InOut->RedirectByFullParams($this->Module->id,'routes');
			//check  route

			if(!$RouteId = Route::GetRouteByDayId($DayId)) $InOut->RedirectByFullParams($this->Module->id,'routes');

			if (Stations::IsTimingsExist($DayId)) $InOut->RedirectByFullParams($this->Module->id,'view_station_t',$DayId);

			//get stations

			$Stations = Stations::GetAllStations($RouteId,$Lang);
			$Data['days_id'] = $DayId;
			$Data['Stations'] = $Stations;

			if($InOut->pvar('post')){

				$Form = new Form($Lang);
				$Form->SetGroupFieldNum('st',count($Stations));
				$Form->ProceedForm('station_timing');
				$Errors = $Form->GetErrorsArray();
				if(empty($Errors)){
					$arr = $Form->GetFormGroupsArray('station_timing','st');

					Stations::InsertStationTiming($arr);
					$InOut->RedirectByFullParams($this->Module->id,'editroute',$RouteId);


				}else{
					$Data['Errors'] = $Errors;
				}


			}





			break;
			case 'addroute':
			$DaysNum = 0;

			$AddForm = new Form($Lang);
			$PostDaysNum = (int) $InOut->pvar('num');
			if(!empty($this->Object->param)) $ParamDaysNum = (int) $this->Object->param;

			if($ParamDaysNum) $DaysNum = $ParamDaysNum;
			elseif($PostDaysNum) $DaysNum = $PostDaysNum;
			else $DaysNum = 0;



			if ($DaysNum > 30) $DaysNum = 1;





			$Data['days_num'] = (int)$DaysNum;


			$AddForm->SetGroupFieldNum('day',$DaysNum);
			$BusTypes = new BusTypes();
			$Data['bus_types'] = $BusTypes->GetBusTypes();
			//var_dump($Data['bus_types']);

			for($i=0;$i<$DaysNum;$i++){

				$Data['DaysNum'][$i]['val'] =0;




			}
			if($AddForm->GetField('post') == 1) $Data['PostData'] = $AddForm->GetPostArray();


			if($AddForm->GetField('post') == 1){

				//error_reporting(0)

				$AddForm->ProceedForm('addroute');
				$Errors = $AddForm->GetErrorsArray();
				$Routes = new Route();


				if(empty($Errors)) {
					$i=0;
					if($Routes->IsRouteWithGivenNameExist($AddForm->GetField('route_name_latin'),$AddForm->GetField('route_name_ru')))
					$Errors[$i]['msg'] = 'Route with such name exists';




				}

				//var_dump($Errors);

				if(empty($Errors)) {


					$NamesArray['ru'] = $AddForm->GetField('routename');
					$DaysArray = $AddForm->GetFormGroupsArray('addroute','day');


					$Routes->AddRoute($this->GetUser()->User,$AddForm->GetField('route_name_latin'),$AddForm->GetField('route_name_ru'),$DaysArray);


					$InOut->RedirectByFullParams($this->Module->id,'routes');

				}else $Data['Errors'] = $Errors;



			}






			break;





		}

		$Data['Modules'] = $Modules->GetUserAvailableModules($this->User);
		$Data['Objects'] = $Modules->GetUserObjects($this->User,$this->Module);
		//var_dump($Data['Objects']);
		$Data['Sid'] = $Auth->GetSid();
		$Data['Sid'] = $Auth->GetSid();
		$BusView = new View($Lang,$SideType,$ViewType);
		$Output =  $BusView->GetParsedCode($this->Module->id,$this->Object,$Data);
		if(!empty($Output)) echo $Output; 



	}
}
?>