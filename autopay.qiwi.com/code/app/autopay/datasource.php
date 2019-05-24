<?php


class App_Autopay_Datasource extends App_Default  {





	function run($params = null){


		/*@var $db Db_Adapter*/


		Registry::get('output')->setType('text');

		$request = Registry::get('request');
		$inout = Registry::get('inout');
		$user = Registry::get('user');
		$session = Registry::get('session');
		$db = Registry::get('connection')->mysql;


		$action = (string) $request->getElement(1);

		switch ($action){



			default:


				/*				require_once(PATH_ROOT.'/logic/datasource/adforce/category.php');
				$inout = Registry::get('inout');
				//if($datasource_name = $inout->getParam('datasource')){


				$id = (int) $inout->getParam('id');
				if($id){
				//$datasource_name = 'adforce_categories';
				$datasource = new Logic_Datasource_Adforce_Category($datasource_name);

				$data = $datasource->setFields(array('adforce_categories.id','adforce_categories.ad_group'))->fetchData(array('campaign_id'=>$id))->getData();

				$json_string = json_encode($data);
				}else $json_string = 'error: id missing';*/

				$json_string = json_encode(array('test'=>1));
				Registry::get('output')->setType('console')->setValue($json_string);

				break;




			case 'addpayment':
				//	$json_string = json_encode($data);

				$contractor_id = (int) $inout->getParam('contractor');
				$type_id = (int) $inout->getParam('type');
				$phone_number = $inout->getParam('phone_number');
				$password = $inout->getParam('password');


				//get id

				$sql = "select id from autopay_types_contractors where type_id = {$type_id} and contractor_id = {$contractor_id} ";
				$db->query($sql);
				if(!$id = $db->get_element()){
					$response  = '-1';
				}else{

					$sql = "insert into autopay_services values (null,'{$phone_number}',$id,'{$password}','-50')";

					$db->query($sql);
					$response = '1';


				}




				Registry::get('output')->setType('console')->setValue(json_encode($response));
				break;


			case 'addSchedule':

				$period = $inout->getParam('period');
				$date = $inout->getParam('date');
				$service_id = $inout->getParam('service_id');

				$sql = "insert into autopay_schedule (period, date , types_contractors_id ) values ('$period','{$date}',$service_id)";
				$db->query($sql);

				Registry::get('output')->setType('console')->setValue(json_encode($db->affected_rows()));

				break;
			case 'getSchedule':

				$service_id = (int)$inout->getParam('service_id');

				$sql = "select * from autopay_schedule WHERE types_contractors_id = $service_id";
				$db->query($sql);

				$array = $db->fetch_assoc();

				Registry::get('output')->setType('console')->setValue(json_encode($array));

				break;
			case 'addInforming':

				$sum = $inout->getParam('sum');
				$service_id = (int) $inout->getParam('service_id');

				$by_sms = (int) $inout->getParam('by_sms');
				$by_email = (int) $inout->getParam('by_email');
				$sql = "insert into autopay_informing(sum, types_contractors_id,by_email,by_sms ) values ($sum,$service_id,$by_email,$by_sms)";
				$db->query($sql);

				Registry::get('output')->setType('console')->setValue(json_encode($db->affected_rows()));

				break;
			case 'getInforming':

				$service_id = (int)$inout->getParam('service_id');

				$sql = "select * from autopay_informing WHERE types_contractors_id = $service_id";
				$db->query($sql);

				$array = $db->fetch_assoc();

				Registry::get('output')->setType('console')->setValue(json_encode($array));

				break;

			case 'doPayment':


				$amount = (int) $inout->getParam('amount');


				$service_id = (int) $inout->getParam('service_id');
				
				$sql = "select type_contractor_id from autopay_services where id = $service_id";
				$db->query($sql);
				
				$types_contractors_id = $db->get_element();
				
				$user->update();


				$balance = $user->getParam('balance');
				if( $balance < $amount) {
					$response = 'sum too large';
				}else{

					$response = $user->pay($service_id,$amount);
					$user->update();
					$session->setParam('user',serialize($user));
					$session->setParam('user_id',$user->id);
					
					
					$sql  = "insert into autopay_payments (status,sum,types_contractors_id,datetime) VALUES ('success',{$amount},$types_contractors_id,NOW());";
					$db->query($sql);
					
					$response = 1;
				}

				
				
				Registry::get('output')->setType('console')->setValue(json_encode($response));

				break;
			case 'contractors':


				$id = (int) $inout->getParam('type_id');

				$query = new Db_Query_Select();
				$query->addWhat('autopay_contractors.id as id');
				$query->addWhat('autopay_contractors.title as title');
				$query->addFrom('autopay_types');
				$query->addFrom('autopay_contractors');
				$query->addFrom('autopay_types_contractors');

				$query->addJoin('autopay_types','id','autopay_types_contractors','type_id');
				$query->addJoin('autopay_contractors','id','autopay_types_contractors','contractor_id');
				$query->addWhereGroup()->add('id',$id,'autopay_types');
				//		$query->addJoin('autopay_payments','contractor_id','autopay_contractors','id');
				$db = Registry::get('connection')->mysql;
				$data = $db->performQuery($query,false,false);
				//$rowset = $db->getRowset();
				//$data = $rowset->data;
				$json_string = json_encode($data);

				Registry::get('output')->setType('console')->setValue($json_string);

				break;
			case 'types':

				$query = new Db_Query_Select();
				$query->addWhat('*');
				$query->addFrom('autopay_types');

				//		$query->addJoin('autopay_payments','type_id','autopay_types','id');
				//		$query->addJoin('autopay_payments','contractor_id','autopay_contractors','id');
				$db = Registry::get('connection')->mysql;
				$data = $db->performQuery($query,false,false);
				//$rowset = $db->getRowset();
				//$data = $rowset->data;
				$json_string = json_encode($data);

				Registry::get('output')->setType('console')->setValue($json_string);

				break;



		}

	}



	public function onInit(){

		parent::onInit();;
		Registry::get('log')->addMessage('helloy from '. get_class($this));

	}








}

?>