<?php

class App_Default  extends Std_Class {


	protected $_parent;


	protected $_app_name;
	protected $_action_name;


	public function __construct($parent = null){
		$this->_parent = $parent;
		return parent::__construct();
	}





	static public function load($app_name){

		$class_name_array = split("_",$app_name);
		$class_name_parsed = '';
		if(count($class_name_array) > 1){
			foreach ($class_name_array as $key=> &$_class_name){
				if($key > 0) $class_name_parsed .= '/';
				$class_name_parsed .= $_class_name;
			}

			//	$file = PATH_LIB.'/radmaster/lib/'.$class_name_parsed.'.php';
			$file = PATH_APP.'/'.$class_name_parsed.'.php';
		}
	}

	/**
	 * 
	 *
	 * @param unknown_type $app_params
	 * @param unknown_type $class_params
	 * @return ...
	 */
	static function exec($params = null){






		$request = Registry::get('request');


		$class_name = 'App_Front';
		$app_name = '';

		$app_params = $request->getElements();
		if(empty($app_params)) $class_params = array( (string) $request[0] );



		if(!empty($app_params)){




			$path = null;
			$class_name_custom = 'App';
			$count = count($app_params);

			//getting app name

			$class_params = $app_params[0]->getElements();
			$count = count($class_params);
			if($count == 1){

				$current_class_name = $app_params[0]->getElement()->getValue();
				$file_name = PATH_APP.'/'.$current_class_name.'.php';



			}elseif ($count > 1){
				$current_class_name = '';
				$file_name = PATH_APP;
				foreach ($class_params  as $key=> $param){
					if($key > 0) $current_class_name  .= '_';
					$current_class_name .= ucfirst($param->getValue());
					$file_name .= '/'.$param->getValue();

				}
				$file_name .= '.php';
			}

			else {

				$current_class_name = (string) $app_params[0];
				$file_name = PATH_APP.'/'.$current_class_name.'.php';
			}


			$alias = $current_class_name;



			/*foreach ($app_params  as $i => &$param)
			{


			if($i == ($count-1) ) break;
			$param = strtolower($param);
			$path .= '/'.$param;
			$class_name_custom .= '_'.ucfirst($param);
			$app_name .= $param;
			if($i < ($count-1) ) $app_name .= '_';

			}*/

			$class_name_custom = 'App_'.ucfirst($current_class_name);

			//$file_name = PATH_APP.$path.'.php';

			if(file_exists($file_name))	{

				require_once($file_name);
				$class_name = $class_name_custom;
				//$test = call_user_func(array($class_name, 'run'),$params);
			} else $current_class_name = 'default';


			//process menu
			/*if($window->menu) {

			$curent_menu_element = $window->menu->searchElement(array('value'=>$class_params[0]));
			if($curent_menu_element) {
			$window->menu->setCurrentElement($curent_menu_element->getName());
			$current_sub_menu_element = $curent_menu_element->searchElement(array('value'=>$class_params[1]));
			if($current_sub_menu_element) $curent_menu_element->setCurrentElement($current_sub_menu_element->getName());
			}




			}*/

			//	foreach ($class_params as $val) 	$window->title .= $val .' / '	;

			//misc
			/*
			$count = count($class_params);
			$entity_name = '';
			foreach ($class_params as $i => $class_param){

			$entity_name .= $class_param;
			if($i < ($count-1)) $entity_name .= '_';
			$i++;

			}
			*/


		}








		//set up app;

		$app = new $class_name;

		//set up ui

		$ui = new Ui();

		Registry::set('ui',$ui);

		$window = new Ui_Window();
		$window->setName('window');
		$window->setTitle('web-sys / ');
		$app->addElement($window);


		Registry::set('window',$window);

		$menu = Ui_Menu::init('menu');
		if($current_menu_element = $menu->getMenuElementByAlias($alias)){
			$current_menu_element_name  =  $current_menu_element->getName();
			$menu->setCurrentElement($current_menu_element_name);
			if($sub_elements = $current_menu_element->getElements()){
				$sub_element_alias = $sub_elements[0]->getValue();
				$current_menu_element->setCurrentElement($sub_element_alias);

			}
		}
		$window->addElement($menu);



		//$menu = new Ui_Element(Ui_Element::Type_MENU);
		//$menu->addElement('test')->setTitle('test')->addElement('test-2')->setTitle('title-2')->addElement('setTitle 3');
		//$menu->getElement('data')->addElement()->setName('test')->setTitle('test');




		$workspace = new Ui_Group();
		$workspace->setName('workspace');

		$window->addElement($workspace);
		$workspace->addElement('output')->setTitle('')->setName('output')->setType(UI::Type_OUTPUT_BOX );
		$state_box = $workspace->addElement(new Ui_Element())->setName('state_box')->setType(Ui::Type_STATE_BOX);





		Registry::get('page')->setParam('window',$window);




		Registry::set('app',$app);
		//	$app->_request_string = $request_string;
		$app->run($app_params);




		return $app;



	}


	public function onInit(){


		Registry::get('log')->addMessage("onInit {$this->getName()} ... ");
		$config = Registry::get('config');

		//db init



		require_once(PATH_LIB_RADMASTER.'/Db/Adapter.php');

		$db_adapter = new Db_Adapter();
		$db_adapter->setName('mysql');
		$db_adapter->connect($config->db->name,$config->db->host,$config->db->login,$config->db->password);

		Registry::set('connection',new Element('connection'));
		Registry::get('connection')->addElement($db_adapter);


		//setup acl
		$acl = new Element('acl',true);

		//$user = $mysql_db->_get('/auth_users?email=byqdes@gmail.com');
		$db_adapter->query('set names utf8');

		//old code support
		$db = null;
		$db =& $db_adapter;
		global $db;



	}


	function run($params = null){




		/*
		global $page;
		global $inout;
		global $config;
		global $user;
		global $session;
		global $menu;


		global $db;*/

		$request = Registry::get('request');


		$success_flag =  $request->getParam('success');

		if($success_flag !== NULL){
			$page->addParam('success_flag',(int) $success_flag);
		}

		$class_params = $this->getClassParams();



		$window = Registry::get('window');

		$page->addParam('class_params_string',$this->_class_params_string);
		$app_name = $class_params[count($class_params)-1];

		foreach ($class_params as $val){
			$window->title .= $val .' / '	;
		}


		$entity_name = $this->_entity_name;


		$page->addParam('entity_name',$entity_name);

		//parse element-name


		//actions
		$actions = array('add','edit','view');
		if($params){



			if(in_array($params[0],$actions)){


				$action_name = $params[0];
				$request_param = $params[1];
				if($params[2]) $action_param = (int) $params[2];


			}
		}





		if($action_param) $id = $action_param;
		else $id = (int) $inout->getParam('id');


		$page->addParam('id',$id);





		// ---------------

		$request = Registry::get('request');
		$request_elements = $request->getElements();
		if($request_elements[0]->hasElements()){
			$request_param = $request_elements[0]->getLastElement()->getValue();
		}


		// --------------

		switch ($request_param){





			case 'item':




				$page->addParam('form_multiple',1);
				$form = new Ui_Form();


				switch($action_name){

					case 'add':
						$form->setActionType(Ui_Form::ACTION_INSERT );

						break;
					case 'edit':
						$form->setActionType(Ui_Form::ACTION_UPDATE );

						break;
					case 'view':
						$form->setActionType(Ui_Form::ACTION_VIEW  );
						break;

					default:

						throw new Exception('params missing');
						break;



				}
				$page->addParam('action_name',$action_name);


				$form_name = $entity_name.'_item';
				if(!$form->isLoadable($form_name)) $form_name = 'default';

				$form->init($form_name);

				$datasource = new Logic_Datasource_Default();

				if($class_params) $table_prefix = $class_params[0].'_';
				else $table_prefix  = '';
				$datasource->setTablePrefix($table_prefix);

				$table = $entity_name;
				if($table == 'default') $table .= '_table';

				$datasource->setTable($table);

				/*			*/
				/* magic =) */
				/*			*/

				$_table = new Db_Table();
				$_table->setName($table);
				$_table->load();

				//get depended data

				/*@var $f Ui_Form_Field*/
				foreach ($form->getFieldList() as $f){


					$name = $f->getName();
					if(!$_table->getField($name)){

						//add field to database =)))

						if(ereg('_id',$name))	{
							$type = 'INT';
							//ALTER TABLE  `adforce_keywords` ADD UNIQUE (`google_keyword_id`)
							$index_sql = "ALTER TABLE {$table}   add unique (`{$name}`)";
						}else {
							$index_sql = null;
							$type = ' VARCHAR(255)';
						}

						$sql  = "ALTER TABLE $table ADD COLUMN $name $type";
						global $db;
						$db->query($sql);
						//	if($index_sql) $db->query($index_sql);


					}


					if(ereg('_id',$name)) {

						$f->setType(Ui_Form_Field::Type_INT );
						$f->getView()->setType(Ui_Form_Field_View::Type_LIST);

					}


					if($f->getView()->getType() == Ui_Form_Field_View::Type_LIST ){


						$name_array = split('_',$name);

						$table_list = $name_array[0];

						$length = strlen($table_list);

						$str_ending = $table_list[$length-1];
						if($str_ending == 'y'){
							$table_list[$length-1] = 'i';
							$table_list .= 'es';
						}else $table_list .= 's';


						$_datasource = new Logic_Datasource_Default();
						$_datasource->setTablePrefix($table_prefix);
						$_datasource->setTable($table_list);
						$data = $_datasource->getItems();
						$f->addListArray($data);


					}
				}




				if($id){

					$data =& $datasource->getItem($id);
					$form->setData($data);
					$page->addParam('id',$id);

				}


				$form_validator = new Form_Validator();

				$page->addParam('Form',$form);



				if($inout->param1 != 'view' && $inout->isFormPost() && $form_validator->validateForm($form)){


					$data = $form->getData();


					switch($form->action){

						case Ui_Form::ACTION_INSERT :


							$id = $datasource->addItem($data);
							$inout->setSuccessStatus(1);
							//$inout->redirectByParams('record','content','admin',array('view',$new_id));
							$inout->redirectUrl("/{$this->_class_params_string}/?success=1&id=$id");;


							break;

						case Ui_Form::ACTION_UPDATE :

							$data['id'] = $id;
							$datasource->updateItem($data);

							$inout->setSuccessStatus(1);
							//$inout->redirectByParams('record','content','admin',array('view',$id));
							$inout->redirectUrl("/{$this->_class_params_string}/view-item-".$id.'/?success=1');

							break;

						default:

							throw new Exception('params missing');
							break;



					}

				}
				break;





			case 'delete-item':


				if(!$id) throw  new Exception('id param missing');

				$datasource = new Logic_Datasource_Default();
				$table = $this->getClassName();
				if($table == 'default') $table .= '_table';
				$datasource->setTable($table);

				$datasource->deleteRecord($id);

				$inout->redirectUrl('/'.$this->getName());



				break;

			case 'index':
			default:







				$grid = new Ui_Grid();
				//$grid = UI::loadUiElement('/@ui/@default/grid',false);

				if(count($this->getClassParams()) >= 2){

					$grid_name = $entity_name;

					//					if(!$grid->isLoadable($grid_name)) $grid_name = 'default';
					//					$grid->init($grid_name);


					$datasource = new Logic_Datasource_Default();
					$table = $this->getClassName();
					if($table == 'default') $table .= '_table';






					$table = new Db_Table();

					$table->setName($entity_name);

					/*if(!$table->isExists()){

					$table->setEngine(Db_Table::Engine_INNODB)->setParam(Db_Table::Param_CHARSET,Db_Table::Value_Charset_DEFAULT);
					//up standart fields

					$field_1 = $table->addField()->setName('id')->setType(Db_Table_Field::Type_INT)->setFieldParam(Db_Table_Field::Param_AUTOINCREMENT)->setFieldParam(Db_Table_Field::Param_NOT_NULL);
					$field_2 = $table->addField()->setName('name')->setType(Db_Table_Field::Type_VARCHAR)->setTypeParam(Db_Table_Field::Type_Param_LENGTH,255);
					$field_3 = $table->addField()->setName('title')->setType(Db_Table_Field::Type_VARCHAR)->setTypeParam(Db_Table_Field::Type_Param_LENGTH,255);

					$table->addKey(Db_Table::Key_PRIMARY,array($field_1));


					$table->createTable();

					//add some test fields


					$record1 = array('name'=>'test1-name','title'=>'test1-title');
					$record2 = array('name'=>'test2-name','title'=>'test2-title');

					global $db;
					$db->sqlgen_insert($entity_name,$record1);
					$db->sqlgen_insert($entity_name,$record2);
















					}*/


					/* makeup grid and form*/

					$file_name_grid = PATH_META_DATA.'\\grid\\'.$class_params[0].'_'.$class_params[1].'.xml';
					$file_name_form = PATH_META_DATA.'\\form\\'.$class_params[0].'_'.$class_params[1].'_item.xml';


					if(false)
					if(!file_exists($file_name_form) || !file_exists($file_name_grid)){







						$meta = new SimpleXMLElement("<meta></meta>");
						$meta_elements = $meta->addchild('fields');


						$_entity = new Element();
						$_entity->addElement('id')->setTitle('id');
						$_entity->addElement('name')->setTitle('Name');
						$_entity->addElement('title')->setTitle('Title');




						foreach ($_entity->getElements() as $_field){

							$meta_element = $meta_elements->addChild('field');
							//$meta_element->addAttribute('name','name');
							$name = $_field->getName();
							if($name == 'id') $meta_element->addAttribute('primary_key',1);
							$meta_element->addAttribute('id',$name);
							$title = $_field->getTitle();

							//$name = strtolower(str_replace(' ','_',$title));

							$title_meta = $meta_element->addChild('title');
							$title_meta->addChild('ru');
							$title_meta->addChild('en');
							$title_meta->en = $title;
							$title_meta->ru = $title;


						}



						$xml_string = $meta->asXml();

						$dom = new DOMDocument("1.0");
						$dom->preserveWhiteSpace = false;
						$dom->formatOutput = true;
						$dom->loadXML($xml_string);
						$xml_string =  $dom->saveXML();




						file_put_contents($file_name_grid,$xml_string);
						file_put_contents($file_name_form,$xml_string);
					}


					/*end of makeup*/








					if($datasource->isTableExists($entity_name)){
						$datasource->setTable($entity_name);

						//$items = $datasource->getItems();

						$query = new RadSelectQuery();
						$query->addFrom($entity_name);
						$query->addWhat('*');

						$db = Registry::get('connection')->mysql;
						$db->performQuery($query);

						if($rowset = $db->getRowset()){
							$arr = $rowset->header;
							$grid->addFields($arr);

						}



						$grid->addData($rowset);
						$import_button = new Ui_Element(Ui_Element::Type_BUTTON );
						$import_button->setName('import_button')->setTitle('Import');
						$import_button_handler = new Ui_Handler();
						$import_button_handler->setLink(array('import'),array('entity'=>$entity_name));
						$import_button->addAction(new Ui_Action('click'))->setValue($import_button_handler);



						$export_button = new Ui_Element(Ui_Element::Type_BUTTON );
						$export_button->setName('exportButton')->setTitle('Export');
						$export_button_handler = new Ui_Handler();
						$export_button_handler->setLink(array('export'),array('entity'=>$entity_name));

						$export_button->addAction(new Ui_Action('click'))->setValue(new Value('exportButtonModal'))->getValue()->setType('Dialog');
						//$export_button->getValue()->setType('toDialog');



						$modal = new Ui_Element(Ui_Element::Type_MODAL);
						$modal->setName('exportButtonModal')->setTitle('Export');

						$body = 'some kind of body';
						$modal->addParam('body',$body);

						$footer = new Ui_Element(Ui_Element::Type_GROUP);
						$modal->addParam('footer',$footer);

						$buttonSave = new Ui_Element(Ui_Element::Type_BUTTON);
						$buttonSave->setName('buttonSave')->setTitle('Save changes..');
						$buttonSave->addAction(new Ui_Action('click'))->setValue("alert('Save');");

						$buttonCancel = new Ui_Element(Ui_Element::Type_BUTTON);
						$buttonCancel->setName('buttonCancel')->setTitle('Cancel');

						$footer->addElement($buttonSave);
						$footer->addElement($buttonCancel);

						//$aa = $footer->element_buttonCancel->title;
						$aa = $footer->element_buttonSave->actions->click->value;

						$window->workspace->addElement($import_button);
						$window->workspace->addElement($export_button);
						$window->workspace->addElement($modal);

						$window->workspace->addElement($grid);

					}

				}else {

					//just show form with content

					$window->workspace->setValue('<h2>test .. </h2>');



				}







				break;


		}


	}






}

?>