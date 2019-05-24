<?php

class App_Autopay extends App_Default  {


	function run($params = null){


		$request = Registry::get('request');
		$inout = Registry::get('inout');
		$window = Registry::get('window');
		$page = Registry::get('page');

		$workspace = $window->workspace;
		$output = $window->workspace->output;

		$action = (string) $request->getElement(1);


		$page->addParam('title','AutoPAY');
		$page->addParam('action',strtolower($action));



		//**********

		$query = new Db_Query_Select();
		$query->addWhat('autopay_contractors.title as contractor_title');
		$query->addWhat('autopay_types.title as types_title');
		$query->addWhat('autopay_payments.sum as payments_sum');
		$query->addWhat('autopay_payments.id as id');
		$query->addWhat('autopay_payments.datetime as datetime');
		$query->addWhat('autopay_types.title as type');
		$query->addWhat('autopay_payments.status as status');

		$query->addWhat('autopay_payments.sum as sum');

		$query->addFrom('autopay_payments');
		$query->addFrom('autopay_contractors');
		$query->addFrom('autopay_types');
		$query->addFrom('autopay_types_contractors');

		$query->addJoin('autopay_payments','types_contractors_id','autopay_types_contractors','id');
		$query->addJoin('autopay_types_contractors','contractor_id','autopay_contractors','id');
		$query->addJoin('autopay_types_contractors','type_id','autopay_types','id');

		$query->addOrder('id','autopay_payments','desc');
		$db = Registry::get('connection')->mysql;
		$db->performQuery($query);
		$payments_rowset = $db->getRowset();

		
		$count  = $payments_rowset->count_rows_total;
		$page->addParam('payments_count',$count);
		$page->addParam('rowset_payments',$payments_rowset);
		

		//*****



		switch ($action){


			case 'Dashboard':


				$grid = UI::loadUiElement('/@ui/@default/grid',false);

				/*@var $grid Ui_Grid*/

				$query = new Db_Query_Select();

				$query->addFrom('autopay_services');
				$query->addFrom('autopay_types');
				$query->addFrom('autopay_contractors');
				$query->addFrom('autopay_types_contractors');
				//	$query->addFrom('autopay_types');

				$query->addWhat('autopay_services.phone_number as phone_number');
				$query->addWhat('autopay_services.balance as balance');

				$query->addWhat('autopay_services.id as service_id');


				$query->addWhat('autopay_contractors.title as contractor_title');

				/*	$query->addWhat('autopay_types.title as types_title');
				$query->addWhat('autopay_payments.sum as payments_sum');
				$query->addWhat('autopay_payments.id as id');
				$query->addWhat('autopay_payments.datetime as datetime');
				$query->addWhat('autopay_types.title as type');
				$query->addWhat('autopay_payments.status as status');*/



				$query->addJoin('autopay_services','type_contractor_id','autopay_types_contractors','id');

				$query->addJoin('autopay_types','id','autopay_types_contractors','type_id');
				$query->addJoin('autopay_contractors','id','autopay_types_contractors','contractor_id');
				$query->addOrder('id','autopay_services','desc');
				//	$query->addJoin('autopay_payments','type_id','autopay_types','id');
				//	$query->addJoin('autopay_payments','contractor_id','autopay_contractors','id');
				//	$sql = $query->getSqlString();
				//	echo $sql;
				//	exit();
				$db = Registry::get('connection')->mysql;
				$db->performQuery($query);
				$rowset = $db->getRowset();


				$page->addParam('rowset',$rowset);
				$grid->addData($rowset);

				/*			$modal = new Ui_Element(Ui_Element::Type_MODAL);
				$modal->setName('exportButtonModal')->setTitle('Export');

				$body = 'some kind of body';
				$modal->addParam('body',$body);
				//$window->workspace->addElement($modal);
				$window->workspace->addElement($grid);*/

				break;
			case 'Payments':


				$grid = UI::loadUiElement('/@ui/@default/grid',false);

				/*@var $grid Ui_Grid*/


				$grid->addData($rowset);

				$modal = new Ui_Element(Ui_Element::Type_MODAL);
				$modal->setName('exportButtonModal')->setTitle('Export');

				$body = 'some kind of body';
				$modal->addParam('body',$body);
				//$window->workspace->addElement($modal);
				$window->workspace->addElement($grid);



			case 'index':
			default:




				break;




		}
	}






}

?>