<?php


require_once(PATH_ROOT.'/logic/model/adforce.php');

class App_Adforce_Import extends App_Default  {







	function run($params = null){

		global $page;
		global $inout;
		global $config;
		global $user;
		global $session;
		global $menu;

		$success_flag =  $inout->getParam('success');
		if($success_flag !== NULL){
			$page->addParam('success_flag',(int) $success_flag);
		}

		$class_params = $this->getClassParams();

		$app_params = $this->_app_params;



		global $window;

		global $db;
		$session = Registry::get('session');



		$output = $window->workspace->output;

		switch ($this->_app_params_string){



			/********************************/
			/*  IMPORTING .SQL FILE TO DB  */
			/******************************/


			case 'empty_db':

				$tables = $db->getTableList();

				foreach ($tables as $table_name){

					if(ereg('adforce_',$table_name[0])){

						$table = new Db_Table();
						$table->setName($table_name[0]);
						$table->emptyTable();

					}

				}

				$table = new Db_Table('adforce_links');
				$table->emptyTable();
				break;


				//loading back-report from other sources




			case 'report-json':



				$return_value = '';
				if($json_string = $inout->getParam('json_string')){
					$json_array = json_decode($json_string,true);
				}

				if(!@$json_array) throw new Exception('json string is incorrect');


				//$json_array = unserialize(file_get_contents(PATH_APP_DATA.'/json.cache'));
				//$json_array = array('date'=>12,'adv_id'=>1,'clicks_total'=>1,'clicks_payed'=>1,'profit_usd'=>'1.22','keyword_id'=>'222');
				$fields = array('date','adv_id','clicks_total','clicks_payed','profit_usd','keyword_id');


				//	file_put_contents(PATH_APP_DATA.'/json.cache',serialize($json_array));

				foreach ($json_array as &$item){

					$array_insert =  array();

					foreach ($fields as $field_name){
						$array_insert[$field_name] = $item[$field_name];
					}



					if($adv_id  = $array_insert['adv_id']){

						$array_insert['keyword_id'] = $adv_id-8000000;


					}
					$array_insert['profit_usd'] = (float) str_replace(',','.',$array_insert['profit_usd']);

					$db->sqlgen_insert('_adforce_report',$array_insert,array('operator'=>'replace'));



				}

				Registry::get('output')->setType('console')->setValue('ok!');


				break;
			case 'report':


				/*
				echo json_encode($arr);

				echo json_encode($arr);*/
				//exit();

				global $db;
				if($json_strinf = $inout->getParam('json')){
					$json_array = json_decode($json_string);
				}
				$handle  = fopen(PATH_APP_DATA.'/adv.csv','r');
				$i=0 ;
				$json_array = array();
				$fields = array('date','adv_id','clicks_total','clicks_payed','profit_usd','keyword_id');

				while (($data = fgetcsv($handle,null,"\t")) !== FALSE) {
					$i++;

					if($i == 1) continue; //skipping header


					foreach ($data as $key =>$val){

						$arr[$fields[$key]]  = $val;
					}



					if($adv_id  = $data[1]){

						$data[] = $adv_id-8000000;


					}




					$db->sqlgen_insert('_adforce_report',$data,array('operator'=>'replace'),false,$fields);

				}

				//	file_put_contents(PATH_APP_DATA.'/json.txt',json_encode($json_array));
				//	exit();

				break;



			case 'db_load':


				$db = Registry::get('connection')->mysql;
				//tables data import
				$file = PATH_APP_DATA.'/data.sql';
				$db->import($file);

				//integrity links import
				$file = PATH_APP_DATA.'/integrity.sql';
				$db->import($file);




				$file = $session->getParam('upload_file');



				//$val = iconv('UCS-2LE', 'windows-1251', $val ."\0") ;

				$window->workspace->output->addElement(new Ui_Element())->setValue($file)->setTitle('Uploaded file')->setType(Ui_Element::Type_TEXT );




				//load file
				//db integrity process END

				break;




				/*************************/
				/*  PARSING IMPORT FILE  */
				/*************************/
			case 'parse':


				$file = $session->getParam('upload_file');
				$window->workspace->output->addElement('upload_file')->setValue($file)->setTitle('Uploaded file');



				//
				//		get document structure from meta-file (xml)
				//


				$service_type = $session->getParam('service_type');

				$file_meta = PATH_APP_DATA."/adforce/{$service_type}.xml";
				$logic = new Logic_Model_Adforce();


				$logic->parseMeta($file_meta);

				$elements_flat_list = $logic->elements_flat_list;
				$_db = $logic->db;



				//generate ui (grids and forms)

				//				$this->generateUI();



				/***************************/
				/* START data import start */
				/**************************/


				$i = 0;
				$row_i = 0;



				$position = (int) $inout->getParam('position');
				$first_stage = true;
				if($position) $first_stage = false;

				$start_line = (int) $inout->getParam('line');
				$line = 0;
				$table_prefix  = 'adforce_';

				$redirect_next_stage = false;
				$handle = fopen($file, "r");


				fseek($handle,$position);

				$arr = array();
				$header_is_parsed = false;


				$additional_fields = new Element('additional_fields');
				/*
				$table_lines = new Db_Table('import_lines');

				if(!$table_lines->isExists()){

				$table_lines->addField()->setName('id')->setType(Db_Table_Field::Type_INT)->setFieldParam(Db_Table_Field::Param_AUTOINCREMENT)->setFieldParam(Db_Table_Field::Param_NOT_NULL);
				$table_lines->addField()->setName('name')->setType(Db_Table_Field::Type_VARCHAR)->setTypeParam(Db_Table_Field::Type_Param_LENGTH,255);
				$table_lines->createTable();;

				}
				if(!$line) $table_lines->emptyTable();*/

				if($start_line){

					$import_date_start = $session->getParam('import_date_start');
					$import_date_end = $session->getParam('import_date_end');


					$additional_fields->addElement('date_start')->setType('date')->setValue($import_date_start);
					$additional_fields->addElement('date_end')->setType('date')->setValue($import_date_end);

				}else {

					$session->unsetParam('import_date_start');
					$session->unsetParam('import_date_end');
				}



				$header_is_parsed = false;

				$integrity_sql_file = PATH_APP_DATA.'/integrity.sql';

				if($first_stage && file_exists($integrity_sql_file)) unlink($integrity_sql_file);

				$integrity_handle = fopen($integrity_sql_file, "a+");
				$integrity_sql = '';



				if($start_line) $header = unserialize($session->getParam('header'));

				//	$sql_prepared_handle = fopen($sql_file,'a+');

				$debug_data = '';


				ini_set('auto_detect_line_endings', true);

				//require_once(PATH_LIB.'/csv.php');
				//while (($data = CSV::fgetcsv($handle,null,",")) !== FALSE) {
				$error_flag = false;
				$error_message = '';
				while (($data = fgetcsv($handle,null,",")) !== FALSE){
					//	while (($file_line = fgets($handle)) !== false) {

					//
					//		$data = explode(',',$file_line);
					//implode()





					//removing new line line ";" , should be done in fgetcsv ?
					$data[count($data)-1] = trim($data[count($data) -1],';');

					if($line < 100){
						$debug_data .=  implode(",", $data).PHP_EOL;

					}else file_put_contents(PATH_APP_DATA.'/debug.txt',$debug_data);




					if(count($data) < 5) {

						//check for global info like (Jul 1, 2013-Jul 25, 2013)

						$global_data_string = implode(",", $data);	//  .. back to .. =)



						//check for date interval

						//	preg_match('/\(([A-Za-Z0-9\,\s\-]+)\)/',$global_data_string,$matches);

						if($service_type == 'google' && preg_match("/\((.*)\)/",$global_data_string,$matches)){

							$dates = split('-',$matches[1]);
							if( count($dates) > 1) {
								$import_date_start = $dates[0];
								$import_date_end = $dates[1];


							}else{

								$import_date_start = $matches[1];
								$import_date_end = $matches[1];

							}

							$session->setParam('import_date_start',$import_date_start);
							$session->setParam('import_date_end',$import_date_end);

							$additional_fields->addElement('date_start')->setType('date')->setValue($import_date_start);
							$additional_fields->addElement('date_end')->setType('date')->setValue($import_date_end);

						}
						//	preg_match("/\((.*)\)/",'(test) ',$matches);
						continue;

					}elseif ($data[0] == '#') continue;

					if(!$start_line && !$header_is_parsed){

						$header_array = &$data;
						$header = new Element('header');
						foreach ($data as $key=> &$val){


							$title = $elements_flat_list->getElement($key)->getTitle();
							$header->addElement()->setTitle($title);

						}

						$session->setParam('header',serialize($header));


						//check for required fields
						foreach ($elements_flat_list as $_el){

							$title = $_el->getTitle();
							if($_el->is_required && !$header->searchElement( array('title'=>$title) )){
								$error_flag = true;
								$error_message = "missing field: $title  ";
								break;
							}

						}


						$header_is_parsed = true;
						continue;
					}



					/*@var $elements_flat_list Element*/


					if($service_type == 'google'){
						$ad_group_title = $elements_flat_list->getElement('ad_group_id')->getTitle();
						$header->searchElement(array('title'=>$ad_group_title));
						$ad_group_id_index = $header->getSearchElementIndex();
						$ad_group_id = $data[$ad_group_id_index];

						$keyword_id_title = $elements_flat_list->getElement('google_keyword_id')->getTitle();
						$header->searchElement(array('title'=>$keyword_id_title));
						$keyword_id_index = $header->getSearchElementIndex();
						$keyword_id = $data[$keyword_id_index];
					}elseif ($service_type == 'yandex'){

						$advert_id_title = $elements_flat_list->getElement('yandex_advert_id')->getTitle();
						$header->searchElement(array('title'=>$advert_id_title));
						$advert_id_index = $header->getSearchElementIndex();
						$advert_id = $data[$adv_id_index];


					}

					$keyword_title = $elements_flat_list->getElement('keyword')->getTitle();
					$header->searchElement(array('title'=>$keyword_title));
					$keyword_index = $header->getSearchElementIndex();
					$keyword = $data[$keyword_index];



					if($service_type == 'google'){
						$campaign_title = $elements_flat_list->getElement('campaign')->getTitle();
						$header->searchElement(array('title'=>$campaign_title));
						$campaign_id_index = $header->getSearchElementIndex();
						$campaign = $data[$campaign_id_index];
					}else $campaign = '';

					$destination_url_title = $elements_flat_list->getElement('destination_url')->getTitle();
					$header->searchElement(array('title'=>$destination_url_title));
					$destination_url_index = $header->getSearchElementIndex();
					$destination_url = $data[$destination_url_index];


					if($destination_url = $data[$destination_url_index]){

						@list ($url_request_string,$url_params_string) = split('\?',$destination_url);

						if($url_params_string){
							list($left_part,$adv_id) = split('\=',$url_params_string);
							if($adv_id = (int) $adv_id) {
								if($adv_id < 8000000) $adv_id = null;
								$header->addElement()->setTitle($adv_id_title);
								$data[( count($header->getElements())-1 )] = $adv_id;


								$data[$destination_url_index] = $url_request_string;
							}
						}else $url_request_string = $destination_url;


					}





					if($service_type == 'google')	$integrity_sql .= "SELECT  id INTO @category_id FROM adforce_categories WHERE ad_group_id = ".$ad_group_id.';'.PHP_EOL;
					if($service_type == 'yandex')	$integrity_sql .= "SELECT  id INTO @advert_id FROM adforce_adverts WHERE  yandex_advert_id = ".$yandex_advert_id.';'.PHP_EOL;


					$integrity_sql .= "SELECT  id INTO @keyword_id FROM adforce_keywords WHERE keyword = '".$keyword."';".PHP_EOL;
					$integrity_sql .= "SELECT  id INTO @campaign_id FROM adforce_campaigns WHERE campaign = '".$campaign."';".PHP_EOL;

					$integrity_sql .= "INSERT IGNORE INTO  adforce_links  SET service_type = '{$service_type}', campaign_id = @campaign_id, keyword_id = @keyword_id, destination_url = '".$url_request_string."'";
					if($service_type == 'google') $integrity_sql .= ", category_id = @category_id";
					elseif($service_type == 'yandex') $integrity_sql .= ", advert_id = @advert_id";
					$integrity_sql .= ';'.PHP_EOL;





					$adv_id_title = $elements_flat_list->getElement('adv_id')->getTitle();
					$adv_id_index = $elements_flat_list->getSearchElementIndex();


					/*$destination_url_title = $elements_flat_list->getElement('destination_url')->getTitle();
					$header->searchElement(array('title'=>$destination_url_title));
					$destination_url_index = $header->getSearchElementIndex();*/

					//adding unique import_line_id to each line

					/*$import_lines_arr = array('name'=>implode(",", $data));
					$db->sqlgen_insert($table_lines->getName(),$import_lines_arr);
					$import_line_id = $db->get_insert_id();*/

					$skip = false;



					foreach($_db->getElements() as $_table){
						//$keywords_index = $_db->getSearchElementIndex();

						$table_name = $_table->getName();
						if($table_name == 'table') continue;

						$_arr = array();
						$i=0;
						$skip = false;

						foreach ($_table->getElements() as $field){



							$name = $field->getName();

							if($name == 'date_start'){

								$ee = 1;
							}
							$element_title = $elements_flat_list->getElement($name)->getTitle();


							//found such field with such title ;)

							if($header->searchElement(array('title'=>$element_title)) || $field->getProperty('is_additional')){
								$_index = $header->getSearchElementIndex();


								if($field->getProperty('is_additional')){
									$field_additional = $additional_fields->getElement($name);

									if($field_additional) {

										$value = $field_additional->getValue();

										if($field_additional->type == 'date'){
											$value = date('Y-m-d',strtotime($value)); //'Y-m-d H:i:s'
										}
										$_arr[$name] = $value;
									}

								}else 	$_arr[$name] = $data[$_index];

								// for unique keys

								//		if(ereg('_id',$name) && !is_numeric($_arr[$name])) continue;



								if( $field->is_unique)	{

									if(ereg('_id',$name)) $field->setProperty('is_key',1);

									foreach ($_table->getValue()->getElements() as $_e){
										$search_for_dups_array = $_e->getValue();
										if(@$search_for_dups_array[$name] == @$data[$_index]){
											$skip = true;
											//		continue ;
										}
									}


								}





							} // not found title in da header - just skip ..
						}

						//remove overall stats - done upper ^^ =)
						/*	$first_element_name = $elements_flat_list->getElement(0)->getName();
						if($_arr[$first_element_name] == '#') $skip = true;*/

						//adding row to rowset

						$table_data = $_table->getValue();
						if(!$skip) {

							//	$_arr['import_line_id'] = $import_line_id;
							$table_data->addElement()->setValue($_arr);
						}

						$i++;
					}


					if($line > 1000){

						$position = ftell($handle);
						$redirect_next_stage = true;
						break;
					}else {

						$redirect_next_stage = false;
						$line++;
					}
				}







				fclose($handle);


				/*	$current_encoding = mb_detect_encoding($integrity_sql, 'auto');
				$integrity_sql = iconv($current_encoding, 'UTF-8', $integrity_sql);*/

				$integrity_sql  = iconv('windows-1251', 'utf-8', $integrity_sql);
				fwrite($integrity_handle, $integrity_sql);
				fclose($integrity_handle);


				/***********************/
				/*   data import end  */
				/**********************/



				/*********************************/
				/*  START preparing data for db */
				/*******************************/


				if(!$error_flag){

					global $db;



					$sql_file = PATH_APP_DATA.'/data.sql';
					if($first_stage && file_exists($sql_file)) unlink($sql_file);


					$sql_prepared_handle = fopen($sql_file,'a+');

					foreach ($_db->getElements() as $_table){


						$table_name = $_table->getName();
						if($table_name == 'table') continue;

						$db_table = new Db_Table();

						$db_table->setName($table_prefix.$table_name);

						if(!$db_table->isExists()){

							$db_table->setEngine(Db_Table::Engine_INNODB)->setParam(Db_Table::Param_CHARSET,Db_Table::Value_Charset_DEFAULT);
							//up standart fields

							$field_1 = $db_table->addField()->setName('id')->setType(Db_Table_Field::Type_INT)->setFieldParam(Db_Table_Field::Param_AUTOINCREMENT)->setFieldParam(Db_Table_Field::Param_NOT_NULL);
							$field_2 = $db_table->addField()->setName('name')->setType(Db_Table_Field::Type_VARCHAR)->setTypeParam(Db_Table_Field::Type_Param_LENGTH,255);

							$db_table->addKey(Db_Table::Key_PRIMARY,array($field_1));


							$db_table->createTable();
						}//else $db_table->emptyTable();


						$db_table->load();


						foreach ($_db->getElement($table_name)->getElements() as $_el){

							$name = $_el->getName();
							//add columns to table if not exists
							if(!$db_field = $db_table->getField($name)){
								if(ereg('_id',$name))	{
									$type = 'BIGINT';
									//ALTER TABLE  `adforce_keywords` ADD UNIQUE (`google_keyword_id`)

									if($_el->is_unique !== 0) $index_sql = "ALTER TABLE {$table_prefix}{$table_name}   add unique (`{$name}`)";
									elseif ($_el->is_index == 1) $index_sql = "ALTER TABLE {$table_prefix}{$table_name}   add index (`{$name}`)";
								}
								elseif ($_el->type == 'date'){

									$type = 'DATE';

								}else {

									$type = ' VARCHAR(255)';
									if($_el->getProperty('is_unique')){
										$index_sql = "ALTER TABLE {$table_prefix}{$table_name}   add unique (`{$name}`)";
									}else $index_sql = null;
								}

								$sql  = "ALTER TABLE {$table_prefix}{$table_name} ADD COLUMN $name $type";
								global $db;
								$db->query($sql);
								if($index_sql) $db->query($index_sql);
							}
							//if($table->get)





						}


						$links_array = array();

						foreach ($_table->getValue()->getElements() as $_el)	{


							//	if($_key_el = $_table->searchElement(array('is_key'=>1))){
							// $_key_name = $_key_el->getName();
							// $where_add_string = " SELECT {$_key_name} FROM {$table->getName()} WHERE NOT EXISTS (SELECT {$_key_name}  FROM {$_table->getName()}  WHERE {$_key_name} = {$_arr[$_key_name]}  limit 1) ";


							///						}


							$_arr =& $_el->getValue_by_reference();






							$sql_string = $db->sqlgen_insert($table_prefix.$table_name,$_arr,array('query_params'=>' IGNORE '),true);

							/*							$current_encoding = mb_detect_encoding($sql_string, 'auto');
							echo $current_encoding;
							exit();*/
							//$sql_string = iconv($current_encoding, 'UTF-8', $sql_string);

							$sql_string = iconv('windows-1251', 'utf-8', $sql_string);

							fwrite($sql_prepared_handle, $sql_string.';'.PHP_EOL);




							//

						}


						//check for




					}


					$window->workspace->output->addElement($_db);


					if($redirect_next_stage){

						$inout->redirectUrl('/adforce-import/parse/?position='.$position.'&line='.($start_line+$line));
					}else {

						//$window->workspace->output->setValue(' ');
						$panel = $window->workspace->addElement(new Ui_Element())->setName('panel_01')->setType(Ui_Element::Type_PANEL);
						/*@var $panel Element*/
						$button = new Ui_Element('button_1');
						$button = $panel->addElement($button)->setTitle('Db-load')->setType(Ui_Element::Type_BUTTON );
						$button->addAction(new Ui_Action())->setType(Ui_Action::Type_CLICK )->setName('onClick')->setValue('/adforce-import/db_load/');

					}

				}else {

					$page->addParam('error_message',$error_message);


				}
				/*********************************/
				/*  end preparing data for db */
				/*******************************/






				break;


				/*********************/
				/*  INITIAL UPLOAD  */
				/*******************/

			case 'upload':
			default:
				//$page->addParam('show_old_ui',1);
				$page->addParam('class_params_string',$this->_class_params_string);
				$app_name = $class_params[count($class_params)-1];


				$form  = new Ui_Form();
				$form->setTitle('import csv:');
				$form->setActionType(Ui_Form::Type_Action_EDIT);

				$select =  new Ui_Field();
				$select->setType(Ui_Element::Type_SELECT )->setName('service_type')->setTitle('Service type');

				$select->addElement()->setTitle('google')->setValue('google');
				$select->addElement()->setTitle('yandex')->setValue('yandex');

				$form->addField($select);

				$file_field = $form->addField();
				$file_field->setName('file')->setType(Ui_Field::Type_FILE)->setTitle('File');
				$file_field->getValue()->setType('file')->setParam('is_required',1);







				$app = Registry::get('app');
				$app->window->workspace->addElement($form);

				//$page->addParam('Form',$form);
				//$page->addParam('form_single',1);


				$form_validator = new Form_Validator();



				if($inout->isFormPost() && $form_validator->validateForm($form)){
					$window->workspace->output->setValue('output: ');

					$form->setActionType('view');
					$page->addParam('success_flag',(int) $success_flag);
					$output = $window->workspace->addElement();
					$output->setName('output');
					/*@var $output Ui_Element*/
					/*			$image = $output->addElement()->setName('image');
					$image->setValue($form->getField('file')->getValue());
					*/


					$service_type = (string) $form->getField('service_type')->getValue();


					$session->setParam('service_type',$service_type);


					$file = (string) $form->getField('file')->getValue();


					$window->workspace->output->addElement('file')->setValue($file)->setTitle('File');

					$window->workspace->output->addElement('size')->setValue(filesize($file) / 1024)->setTitle('Size');

					$panel = $window->workspace->addElement('panel');
					/*@var $panel Element*/
					$button = new Ui_Element('button_1');
					$panel->addElement($button)->setTitle('Parse');
					$button->addAction(new Ui_Action())->setType(Ui_Action::Type_CLICK )->setName('onClick')->setValue('/adforce-import/parse/');


					$session->setParam('upload_file',$file);


					/* PARSE-START */




				/*	var_dump(iconv_get_encoding('all'));
					exit();
*/
					if($service_type == 'yandex'){
						$data = file_get_contents($file);
						//$data = iconv('utf-8','windows-1251', $data);
						$data =   mb_convert_encoding($data,'windows-1251','UCS-2LE');

						file_put_contents($file,$data);

					}

					$handle = fopen($file, "r");



					//





					$field_title_list = array();
					$fields = array();
					$category_data = array();
					$item_data = array();

					$grid = $window->workspace->addElement('grid');
					$grid_header = $grid->addElement('header');
					$grid_data = $grid->addElement('data');

					$header_is_parsed = false;

					$i = 0;
					$row_i = 0;


					if($service_type == 'google') $divider = ',';
					elseif ($service_type == 'yandex') $divider = '\t';
					else  throw new Exception('Wrong csv divider type');

					while (($data = fgetcsv($handle,null,"\t")) !== FALSE) {


						if($i < 20)  {

							if(count($data) < 8) continue;

							if(!$header_is_parsed){
								foreach ($data as $val){

									if($service_type == 'yandex'){
										//$val = iconv('UCS-2LE', 'windows-1251', $val ."\0") ;
										//	$val = mb_convert_encoding($val, "utf-8");

										//	$arr=pack("H*", $val);
										//	$val =  mb_convert_encoding($arr,'UTF-8','UCS-2');
										$val = iconv('UCS-2LE', 'utf-8', $val) ;//($val,"ucs-2","utf-8");

									}

									$grid_header->addElement()->setValue($val);

								}
								$header_is_parsed = true;
								continue;

							}


							$row = $grid_data->addElement('row'.$row_i);
							foreach ($data as $key=> $val){
								$row->addElement()->setValue($val);
							}
							$row_i++;


						}
						else {



							break;





						}
						$i++;

					}
					fclose($handle);



					//make meta for all fields

					$make_meta = false;

					if($make_meta){
						$meta = new SimpleXMLElement('<meta></meta>');
						$meta_elements = $meta->addchild('elements');
						foreach ($grid_header as $element){



							$meta_element = $meta_elements->addChild('element');
							//$meta_element->addAttribute('name','name');
							$meta_element->addAttribute('table','table');
							//	$title = $element->getValue();
							//	$name = strtolower(str_replace(' ','_',$title));

							$name = '';
							$title = '';
							$meta_element->addAttribute('name',$name);
							$meta_element->addAttribute('title',$title);



						}

						$xml_string = $meta->asXml();

						$dom = new DOMDocument("1.0");
						//$dom->encoding = 'UTF-8'; // reset original encoding
						$dom->preserveWhiteSpace = false;
						$dom->formatOutput = true;
						$dom->loadXML($xml_string);
						//$dom->encoding = 'UTF-8'; // reset original encoding
						$xml_string =  $dom->saveXML();

						//$xml_string = utf8_encode($xml_string);
						//	$xml_string = utf8_encode(html_entity_decode($xml_string));
						//						$xml_string = html_entity_decode($xml_string,null,'windows-1251');

						$xml_string = mb_convert_encoding($xml_string, 'HTML-ENTITIES', 'UTF-8');
						file_put_contents(PATH_APP_DATA."/adforce/{$service_type}.xml",$xml_string);




					}


					//open prepared meta with correct tables

					//	$meta = simplexml_load_file('z:/_meta.xml');





					$inout->setRedirectUrl('/adforce-import/parse/');
					/*echo 'yep';
					exit();
					*/
					break;

					//var_dump($data);



					//	print_r($grid->data->row0->field0);
					//	exit();

					//if($data){




					//array_shift($cols);


					/*
					$sql_query = 'CREATE TABLE app_adforce_items (`id` INT AUTO_INCREMENT NOT NULL, `name` VARCHAR(255) NULL,';


					$ui_grid = new Ui(Ui::UI_TYPE_GRID);

					$grid_xml = simplexml_load_file(PATH_META_DATA.'/@prototype/grid.xml');

					$grid_xml->fields->field[0]['id'] = 'id';
					$grid_xml->fields->field[0]->title->en = 'ID';


					$i=0;

					ksort($cols);
					$cols_count = count($cols);
					foreach ($cols as $key=>$val){

					$field_name = 'field'.$i;
					$sql_query .= "`{$field_name}` VARCHAR(255) NULL, ";


					//adding fields to grid



					$field = $grid_xml->fields->addChild('field');

					$field['id'] = $field_name;
					$field->title->ru = $key;
					$field->title->en = $key;




					$i++;
					}
					$sql_query .= "PRIMARY KEY(`id`) )";





					$xml_string = $grid_xml->asXml();

					$dom = new DOMDocument("1.0");
					$dom->preserveWhiteSpace = false;
					$dom->formatOutput = true;
					$dom->loadXML($xml_string);
					$xml_string =  $dom->saveXML();




					file_put_contents(PATH_META_DATA.'/grid/adforce-items-list.xml',$xml_string);
					//					exit();

					$db->select_db('_prj');*/
					//create table
					//			$db->query($sql_query);



					// inserting values


					/*	foreach ($data as $key=>&$val){
					//
					$arr_tmp = array();


					ksort($val);
					$i = 0;
					foreach ($val as $val_tmp) {


					$arr_tmp['field'.$i] = $val_tmp;

					//take from url marker
					if($i == 4){
					$arr_url = split('\=',$val_tmp);

					$arr_tmp['adv_id'] = (int) $arr_url[1];


					}


					$i++;



					if($i == 13) break ;
					}

					$db->sqlgen_insert('app_adforce_items',$arr_tmp);




					}*/
					/* PARSE-END */























				}
		}
	}



	protected function generateUI(){


		/**************************/
		/*  makeup grid and form  */
		/**************************/


		foreach ($this->_db->getElements() as $_entity){

			$meta = new SimpleXMLElement("<meta></meta>");
			$meta_elements = $meta->addchild('fields');



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
			$entity_name = $_entity->getName();

			$file_name_grid = 'Z:\\_export\\meta\\grid\\'.'adforce_'.$entity_name.'.xml';
			$file_name_form = 'Z:\\_export\\meta\\form\\'.'adforce_'.$entity_name.'_item.xml';

			file_put_contents($file_name_grid,$xml_string);
			file_put_contents($file_name_form,$xml_string);

		}

		/***************/
		/*end of makeup*/
		/**************/



	}


}

?>