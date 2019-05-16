<?php


global $Config;
require_once($Config->SitePath.'/3rd_party/rad/rad_menu.php');
require_once($Config->SitePath.'/3rd_party/rad/rad_menu.php');

require_once $Config->SitePath.'/application/models/banking/currencies.php';

class Admin_BankingController extends Rad_Zend_Controller_Action
{

	/**
	 * User object
	 *
	 * @var RegisteredUser
	 */
	protected $User;
	protected $_view = null;


	public function init()
	{
		global $Config;





		parent::init();
		$this->_view->IndexTemplate = 'index_admin.tpl';
		if(!$this->User->isLogined('AdminUser') && $this->_view->action != 'login'){
			//		$this->_redirect('/admin/index/login/');
		}



	}



	public function currenciesAction(){



		$GridName = 'admin_currencies';

		$Grid = new CGrid($GridName);



		$Menu = new Rad_Menu();
		//$Menu->addActionMenuItem('Add currency',new Rad_Link(array('admin','banking','currency'),array('act'=>'add')));
		$Menu->addActionMenuItem('Clear search params',new Rad_Link(array('admin','index','users'),array('clear'=>1)));

		$this->_view->Actions = $Menu->getActionsMenu();


		$this->proceedGridSessionData();

		$Currencies = new Banking_Currencies();
		$Items =& $Currencies->getItems();

		$Grid->addData($Items);
		$this->_view->Grid= $Grid;

		$this->_response->appendBody($this->_view->render('currencies.tpl'));


	}
	public function addService2stepAction(){

		global $Config;
		require_once $Config->SitePath.'/application/models/directory.php';

		$num = (int) $this->_getParam('num');
		$id = (int) $this->_getParam('id');


		$num--;
		$Params = new Rad_Form_Params();

		$Source = new Rad_Form_Xml_Source();

		$Params->ProceedData = false;
		$Source->Class = 'banking';
		$Source->FormName = 'custom_item_step2';
		$Source->init();


		$NewForm  = new Rad_Form();
		$NewForm->initFromXmlSource($Source);
		$Sd = $NewForm->getField('short_description');
		$Type = $NewForm->getField('type');
		$Type->Class = 'id';

		$Lists = new Rad_Tree_Node();
		$Lists->initByAlias('system_datatypes_list');
		$ListsArr = array('int'=>'число','string'=>'строка','currency_id'=>'Валюта','purpose_id'=>'Цель');
		$_lists = $Lists->getChildNodes(true);
		if($_lists){
			foreach ($_lists as $l){

				$ListsArr['list_'.$l['category_id']] =$l['short_description'];
			}
		}

		$Type->Type->ListValues = $ListsArr;
		$Type->ID = 'type-0';
		$Sd->ID = 'short_description-0';
		$Type->View->Group = 1;
		for($i=1;$i<=$num;$i++){

			//print_r($Sd);
			//	echo $Sd;\

			$NewSd = clone($Sd);
			$NewSd->Type = clone $NewSd->Type;
			$NewSd->ID = 'short_description-'.$i;
			$NewForm->addField($NewSd);


			$NewType = clone($Type);
			$NewType->Type = clone $NewType->Type;
			$NewType->ID = 'type-'.$i;
			$NewForm->addField($NewType);


			/*			$_IsCritical = clone($IsCritical);
			$_IsCritical->Type = clone $_IsCritical->Type;
			$_IsCritical->ID = 'is_critical-'.$i;
			$NewForm->addField($_IsCritical);


			$_IsDesired = clone($IsDesired);
			$_IsDesired->Type = clone $_IsDesired->Type;
			$_IsDesired->ID = 'is_desired-'.$i;
			$NewForm->addField($_IsDesired);

			$_IsSorted = clone($IsSorted);
			$_IsSorted->Type = clone $_IsSorted->Type;
			$_IsSorted->ID = 'is_sorted-'.$i;
			$NewForm->addField($_IsSorted);

			$_Priority = clone($Priority);
			$_Priority->Type = clone $_Priority->Type;
			$_Priority->ID = 'priority-'.$i;
			$NewForm->addField($_Priority);

			$_Priority = clone($Priority);
			$_Priority->Type = clone $_Priority->Type;
			$_Priority->ID = 'priority-'.$i;
			$NewForm->addField($_Priority);

			$_SortDirection = clone($SortDirection);
			$_SortDirection->Type = clone $_SortDirection->Type;
			$_SortDirection->ID = 'sort_direction-'.$i;
			$NewForm->addField($_SortDirection);
			*/

		}

		//print_r($NewType);

		$Params->setFormCustomObject($NewForm);




		//$Params->setSource($Source);








		if($Result  = $this->parseFormExt($Params)){


			//print_r($_POST);



			//s	die('ddd');

			//creare form


			$fields = array();
			foreach ($NewForm->getFormValues() as $key=>$val){

				//echo $key;
				if(preg_match("/^([a-zA-Z\_]*)\-([0-9]*)$/",$key,$rez)){

					$fields[$rez[2]][$rez[1]] = $val;

				}

			}
			/*			print_r($fields);
			die();*/


			if($fields){

				$ItemForm  = new Rad_Form();
				$PurposeFlag = false;
				$CurrencyFlag  =false;
				$Params = new Rad_UI_Field_Params();
				foreach ($fields as $key=>&$f){
					if($f['type'] == 'purpose_id'){

						if($PurposeFlag){
							unset($fields[$key]);
							continue;
						}
						$f['new_title'] = $f['type'];
						$f['type'] = 'list';
						$PurposeFlag = true;
						$f['id'] = 'purpose_id';


						$Params->ListValueTitle = 'purpose_title_ru';
						$Params->ListKeyTitle = 'purpose_id';
					}
					elseif ($f['type'] =='currency_id'){
						if($CurrencyFlag){
							unset($fields[$key]);
							continue;
						}

						$f['new_title'] = $f['type'];
						$f['type'] = 'list';
						$f['id'] = 'currency_id';
						$CurrencyFlag = true;
						$Params->ListValueTitle = 'cur_title_ru';
						$Params->ListKeyTitle = 'currency_id';
					}
					elseif (preg_match('/list\_(.*)/',$f['type'],$rez)){

						$f['id'] = $f['type'];

						$f['type'] = 'list';
						$Params->ListValueTitle = 'short_description';
						$Params->ListKeyTitle = 'listing_id';


					}elseif ($f['type'] == 'string'){

						$Params->length  = '0-110';
					}

					$field = $ItemForm->addField();



					$Params->setType($f['type']);
					if(!$Params->Id = $f['id']) $Params->Id  = 'field'.$key;
					$field->setParams($Params);
					$field->Title = ($f['short_description']);

				}
				global $Config;
				require_once $Config->SitePath.'/application/models/directory.php';
				$Xml  = $ItemForm->getFormXmlString();


				$Tree = new DirectoryTree();
				$Tree->updateCategoryData(array('category_id'=>$id,'custom_items_xml'=>$Xml));
				$sql  = "CREATE TABLE `service{$id}` (
  				`id` smallint(6) NOT NULL auto_increment,
  				`listing_id` smallint(6) NOT NULL,";

				foreach ($fields as $key=>$val){
					if($val['new_title']) $val['type'] = $val['new_title'];
					switch ($val['type']){
						case 'int':
							$sql  .= "`field{$key}` smallint(6)  NULL ,";
							break;
						case 'string':
							$sql  .= "`field{$key}` varchar(255) NULL 	,";
							break;
						case 'currency_id':
							$sql  .= "`currency_id`smallint(6) NULL 	,";
							break;
						case 'list':
							$sql  .= "`{$val['id']}`smallint(6) NULL 	,";
							break;
						case 'purpose_id':
							$sql  .= "`purpose_id`smallint(6) NULL 	,";
							break;
						default:
							die($val['type']);
							throw new Exception('error');


					}
					//	  `surname` varchar(255) NOT NULL default '',";
				}
				$sql .= "PRIMARY KEY  (`id`)
) TYPE=MyISAM  ;";
				global $Db;
				$Db->query($sql);

				Rad_Directory_Record::addItemType(array('short_description'=>'service'.$id,'alias'=>'service'.$id));


				$this->_redirect('/admin/node/nodes/');


			}



		}

		$this->_response->appendBody($this->_view->render('formext.tpl'));
	}
	public function addServiceAction(){



		$Menu = new Rad_Menu();
		$Menu->addActionMenuItem('Back',new Rad_Link(array('admin','banking','services')));
		$this->_view->Actions = $Menu->getActionsMenu();
		global $InOut;
		global $Config;
		require_once $Config->SitePath.'/application/models/directory.php';
		$Tree = new DirectoryTree();

		$Node= new Rad_Tree_Node();
		$Node->initByAlias('available_services');
		$Nodes = $Node->getChildNodes(true);


		$Params = new Rad_Form_Params();


		$Params->Action = Form2::InsertAction;
		$Params->setPredefinedFieldValue('category_id',$Nodes);



		$Source = new Rad_Form_Xml_Source();

		$Source->Class = 'banking';
		$Source->FormName = 'custom_item_step1';
		$Source->init();
		$Params->setSource($Source);




		$Params->ProceedData = false;


		if($Result  = $this->parseForm($Params)){

			$Data  =& $Result->_uiObject->getFormArrayExt();
			$FieldsNum = $Data['fields_num'];
			unset($Data['fields_num']);
			//create node


			$Id = $Tree->insertCategory($Node->getId(),$Data);

			$Tree->updateCategoryData(array('category_id'=>$Id,'alias'=>'service'.$Id));
			$this->_redirect("/admin/banking/add_service_2step/?num=$FieldsNum&id=$Id");


		}

		$this->_response->appendBody($this->_view->render('form.tpl'));
	}
	public function servicesAction(){

		/*	global $Config;
		require_once $Config->SitePath.'/application/models/directory.php';
		require_once $Config->SitePath.'/application/models/custom_item.php';
		$Grid = new CGrid('admin_items2');





		$Tree = new DirectoryTree();

		$this->proceedGridSessionData();

		$Menu = new Rad_Menu();
		//$Menu->addActionMenuItem('Add currency',new Rad_Link(array('admin','banking','purpose'),array('act'=>'add')));
		$Menu->addActionMenuItem('Добавить услугу',new Rad_Link(array('admin','banking','add_service')));
		$Menu->addActionMenuItem('Clear search params',new Rad_Link(array('admin','banking','services'),array('clear'=>1)));

		$this->_view->Actions = $Menu->getActionsMenu();
		$Node  = new Rad_Tree_Node();
		$Node->initByAlias('available_services');


		$Items =  $Node->getChildNodes(true);

		//$Items =&  $Item->getItemsSimpleExt(array('user_id'=>(int) $this->_getParam('user_id'),'use_item_type'=>true,'join_secondary_table'=>true));

		$Grid->addData($Items);
		$this->_view->Grid= $Grid;


		$this->_response->appendBody($this->_view->render('currencies.tpl'));*/

	}

	public function createCalculatorAction(){
		global $Config;
		require_once $Config->SitePath.'/application/models/directory.php';
		$NodeId = (int) $this->_getParam('type');
		$Node = new Rad_Tree_Node();
		$Node->init($NodeId);

		$Params = new Rad_Form_Params();


		$Source = new Rad_Form_Xml_Source();

		$Params->ProceedData = false;
		$Source->Class = 'admin';
		$Source->FormName = 'listing';
		$Source->init();

		$Source2 = new Rad_Form_Xml_Source();
		$Source2->setXml($Node->Data['custom_items_xml']);
		$Source2->init();

		$NewForm  = new Rad_Form();
		$NewForm->initFromXmlSource($Source);
		$NewForm->initFromXmlSource($Source2);
		$fields = $NewForm->getFields();
		/*	foreach ($fields = $NewForm->getFields() as $f){
		//	echo $f->ID;
		}*/
		//exit();
		$num = count($fields);
		//loading


		/*
		$Sd = $NewForm->getField('short_description');
		$Type = $NewForm->getField('type');
		$Type->Class = 'id';
		$Type->ListValues = array('int'=>'число','string'=>'строка','currency_id'=>'Валюта','purpose_id'=>'Цель');
		$Type->ID = 'type-0';
		$Sd->ID = 'short_description-0';*/
		$ViewForm = new Rad_Form();




		//get types
		$Lists = new Rad_Tree_Node();
		$Lists->initByAlias('system_datatypes_list');
		$ListsArr = array('int'=>'число','string'=>'строка','currency_id'=>'Валюта','purpose_id'=>'Цель');
		$_lists = $Lists->getChildNodes(true);
		if($_lists){
			foreach ($_lists as $l){

				$ListsArr['list_'.$l['category_id']] =$l['short_description'];
			}
		}

		for($i=1;$i<count($fields);$i++){


			$f1 = $ViewForm->addField();
			$f1->setType('bool');

			$f1->Title = 'вкл. \''.$fields[$i]->Title.'\'';

			$f1->ID = $fields[$i]->ID;

			$f2 = $ViewForm->addField();
			$f2->Title = 'Тип';
			$f2->setType('enum');
			$f2->ID = $fields[$i]->ID.'_type';
			$f2->isRequired= false;
			$f2->Type->ListValues =$ListsArr;




			$f3 = $ViewForm->addField();
			$f3->setType('bool');
			$f3->Title = 'Калькулятор';
			$f3->ID =  $fields[$i]->ID.'_calc';

			$f3 = $ViewForm->addField();
			$f3->setType('bool');
			$f3->Title = 'Вывод в результатах поиска';
			$f3->ID =  $fields[$i]->ID.'_search';

			$f4 = $ViewForm->addField();
			$f4->setType('bool');
			$f4->Title = 'Вывод записи fullview';
			$f4->ID =  $fields[$i]->ID.'_fullview';




			//echo $fields[$i]->Type->getTypeString();
			if($fields[$i]->Type->getTypeString() != 'int') {
				$f4->View->Group =1 ;
				continue;
			}
			$Operand = $ViewForm->addField();
			$Operand->setType('enum');
			$Operand->Type->ListValues = array('low_equal' => '<=','equal'=> '=','high_equal'=> '>=');
			$Operand->ID = $fields[$i]->ID.'_operand';

			$Operand->Title= 'Операнд';

			$Operand->isRequired = false;

			$IsDesired = $ViewForm->addField();
			$IsDesired->setType('bool');
			$IsDesired->ID  = $fields[$i]->ID.'_is_desired';
			$IsDesired->Title = 'Варьировать?';


			$VaryStep = $ViewForm->addField();
			$VaryStep->setType('float');
			$VaryStep->ID  = $fields[$i]->ID.'_vary_step';
			$VaryStep->isRequired = false;
			$VaryStep->Title = 'Шаг вариации';

			$VaryStepNum = $ViewForm->addField();
			$VaryStepNum->setType('int');
			$VaryStepNum->ID  = $fields[$i]->ID.'_vary_step_num';
			$VaryStepNum->isRequired = false;
			$VaryStepNum->Title = 'Кол-Во шагов вариации';

			$VaryDirection = $ViewForm->addField();
			$VaryDirection->Title = 'Направление вариации';
			$VaryDirection->setType('enum');
			$VaryDirection->ID = $fields[$i]->ID.'_vary_direction';
			$VaryDirection->isRequired= false;
			$VaryDirection->Type->ListValues = array('up'=>'увеличение','down'=>'уменьшение');


			$IsSorted = $ViewForm->addField();
			$IsSorted->setType('bool');
			$IsSorted->ID = $fields[$i]->ID.'_is_sorted';
			$IsSorted->Title = 'Сортировать?';

			$Priority = $ViewForm->addField();
			$Priority->ID = $fields[$i]->ID.'_priority';
			$Priority->setType('int');
			$Priority->isRequired = false;
			$Priority->Title = 'Приоритет сортировки';

			$SortDirection = $ViewForm->addField();
			$SortDirection->setType('enum');
			$SortDirection->Type->ListValues = array('desc'=> 'по убыванию','asc'=> 'по возрастанию');
			$SortDirection->ID = $fields[$i]->ID.'_sort_direction';
			$SortDirection->View->Group = 1;
			$SortDirection->Title= 'Направление сортировки';
			$SortDirection->isRequired = false;
			$SortDirection->View->Group = 1;



			//	print_r($f2->Type->ListValues);
			//print_r($Sd);
			//	echo $Sd;\

			/*			$NewSd = clone($Sd);
			$NewSd->Type = clone $NewSd->Type;


			$NewSd->ID = 'short_description-'.$i;

			$NewType = clone($Type);
			$NewType->Type = clone $NewType->Type;
			$NewType->ID = 'type-'.$i;
			$NewForm->addField($NewSd);
			$NewForm->addField($NewType);*/

		}



		//	print_r($ViewForm->getFormValues());

		$Params->setFormCustomObject($ViewForm);




		//	$Params->setSource($Source);











		$ParamFields = array('operand','is_desired','is_sorted','priority','sort_direction','vary_step','vary_step_num','vary_direction','fullview');

		if($Result  = $this->parseFormExt($Params)){
			$Obj = $Result->_uiObject;
			/*@var $Obj Rad_Form*/
			$Arr = $Obj->getFormValues();
			//create grid and form for calculator


			//$Grid = new SimpleXMLElement()
			$Form = new Rad_Form();
			$FullViewForm = new Rad_Form();
			//	print_r($Arr);
			$Str = "<grid><fields></fields></grid>";
			$Grid = new SimpleXMLElement($Str);

			foreach ($fields = $NewForm->getFields() as $f){




				/*@var $f Rad_Form_Field*/
				$id = $f->ID;
				if(!$Arr[$id]) continue;

				$GridTitle = null;


				$new_field = new Rad_Form_Field();
				
				//include in the calculator form
				if($Arr[$id.'_search']) $FullViewForm->addField($new_field);
				
				//include in the fullview form
				if($Arr[$id.'_calc']) $Form->addField($new_field);
				
				$new_field->ID = $id;
				$new_field->Title = $f->Title;
				$new_field->isRequired = false;
				$Type = $Arr[$id.'_type'];

				$GridOutput = true;

				if(!$Type) continue;
				if($Type == 'currency_id'){
					$new_field->ID = 'currency_id';
					$Type = 'list';
					$new_field->setType($Type);
					$new_field->Type->ListValueTitle = 'cur_title_ru';
					$new_field->Type->ListKeyTitle= 'currency_id';
					$GridTitle = 'cur_title_ru';;
				}elseif ($Type == 'purpose_id')
				{

					$new_field->ID = 'purpose_id';
					$Type = 'list';
					$new_field->setType($Type);
					$new_field->Type->ListValueTitle = 'purpose_title_ru';
					$new_field->Type->ListKeyTitle = 'purpose_id';
					$GridTitle  = 'purpose_title_ru';
					//	$new_field->setType($Type);

				}elseif (preg_match('/list\_(.*)/',$Type,$rez)){

					$new_field->ID = $Type;

					$new_field->setType('list');
					$new_field->Type->ListValueTitle = 'short_description';
					$new_field->Type->ListKeyTitle = 'listing_id';
					$GridTitle  = $Type.'_short_description';
					$GridOutput = false;


				}elseif ($Type == 'string'){

					$new_field->setType($Type);
					$new_field->Type->Length = '3-10';


				}elseif ($Type == 'is_critical'){

				}
				else $new_field->setType($Type);

				//generate grid

				if($Arr[$id.'_search'] && $GridOutput){
					$g_field = $Grid->fields->addChild('field');
					if($GridTitle) $g_field['id'] = $GridTitle;
					else $g_field['id'] = $new_field->ID;
					$g_field->title->en = $f->Title;
				}


			}



			//parse additinal params
			$ParamsXml = array();
			foreach ($Form->getFields() as $f){
				foreach ($ParamFields as $p){
					if(isset($Arr[$f->ID.'_'.$p])){
						$f->Params[$p] = $Arr[$f->ID.'_'.$p];
					}
				}

			}


			$FormXml = $Form->getFormXmlString();
			$FullViewFormXml = $FullViewForm->getFormXmlString();

			global $Config;
			file_put_contents($Config->SitePath.'/application/forms/search_form'.$NodeId.'.xml',$FormXml);
			file_put_contents($Config->SitePath.'/application/forms/fullview_form'.$NodeId.'.xml',$FullViewFormXml);
			file_put_contents($Config->SitePath.'/application/grids/search_grid'.$NodeId.'.xml',$Grid->asXml());



			//	$this->_redirect('/admin/node/nodes/?node_id='.$NodeId);

		}

		$this->_response->appendBody($this->_view->render('formext.tpl'));



	}
	public function itemsAction(){

		global $Config;
		require_once $Config->SitePath.'/application/models/directory.php';
		require_once $Config->SitePath.'/application/models/custom_item.php';






		$Tree = new DirectoryTree();
		$Node  = new Rad_Tree_Node();
		$Node->initByAlias('available_services');


		$this->_view->services = $Node->getChildNodes(true);
		$this->proceedGridSessionData();
		$ServiceType = $this->_view->Params['service'];
		if(!$ServiceType) $ServiceType = 16;

		switch ($ServiceType){
			case '16':
				$Item = new Deposit_Item();
				$NodeId = 16;
				break;
			default:
				$ServiceType = 'credit';
			case '17':
				$NodeId = 17;

				$Item = new Credit_Item();
				break;
			default:

				$ServiceNode = new Rad_Tree_Node();
				$ServiceNode->init($ServiceType);

				$Item = new Custom_Item(array('node'=>$ServiceNode));
				$NodeId= $ServiceType;

		}
		$this->_view->service = $ServiceType;

		$Grid = new CGrid();
		$Grid->setPath('/application/grids/');
		if(!$Grid->init('search_grid'.$NodeId)){
			$Grid->setPath('/data/grid/');
			$Grid->init('admin_services');
		}else {
			$grid_field = $Grid->addField();
			$grid_field->ID = '#edit';
			$grid_field->setIsAdditional();;
			$grid_field->setTitle('edit');
			$grid_field->setLink('/admin/node/listing/');
			$grid_field->setLinkParams('listing_id','listing_id');
			$grid_field->setLinkParams('s',null,'1');
			$grid_field->setLinkParams('act',null,'edit');
		}
		$Menu = new Rad_Menu();
		//$Menu->addActionMenuItem('Add currency',new Rad_Link(array('admin','banking','purpose'),array('act'=>'add')));

		$Menu->addActionMenuItem('Добавить запись',new Rad_Link(array('admin','node','listing'),array('type'=>$ServiceType,'a'=>'add','node_id'=>$NodeId,'s'=>1)));
		$Menu->addActionMenuItem('Clear search params',new Rad_Link(array('admin','banking','items'),array('clear'=>1)));

		$this->_view->Actions = $Menu->getActionsMenu();
		$this->_view->service = $ServiceType;
		$User = new PartnerUser();
		$this->_view->users = $User->getUsersList();
		$Items =&  $Item->getItemsSimpleExt(array('user_id'=>(int) $this->_view->Params['user_id'],'use_item_type'=>true,'join_secondary_table'=>true));

		$Grid->addData($Items);
		$this->_view->Grid= $Grid;


		$this->_response->appendBody($this->_view->render('services.tpl'));

	}
	public function purposesAction(){



		//throw new Exception('tes');
		$GridName = 'admin_banking_purpose';

		$Grid = new CGrid($GridName);



		$Menu = new Rad_Menu();
		//$Menu->addActionMenuItem('Add currency',new Rad_Link(array('admin','banking','purpose'),array('act'=>'add')));
		$Menu->addActionMenuItem('Clear search params',new Rad_Link(array('admin','banking','purposes'),array('clear'=>1)));

		$this->_view->Actions = $Menu->getActionsMenu();

		$this->proceedGridSessionData();

		$Currencies = new Banking_Purposes();
		$Items =& $Currencies->getItems();

		$Grid->addData($Items);
		$this->_view->Grid= $Grid;


		$this->_response->appendBody($this->_view->render('currencies.tpl'));


	}










	// the default action is "indexAction", unless explcitly set to something else
	public function indexAction()  {


	}


	// redirect bogus URLs back to the application's "home" page
	public function noRouteAction()
	{
		$this->_redirect('/');
	}




	public function __call($methodName, $args)
	{
		/*		if (empty($methodName)) {
		$msg = 'No action specified and no default action has been defined in __call() for '
		. get_class($this);
		} else {

		$this->_redirect('/not_found');
		}*/

		throw new Zend_Controller_Action_Exception($msg);
	}




}
?>