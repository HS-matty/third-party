<?php


require_once(PATH_ROOT.'/logic/model/adforce.php');

class App_Crawler_Import extends App_Default  {







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

		$workspace = $window->workspace;
		$output = $window->workspace->output;


		switch ($this->_app_params_string){



			/********************************/
			/*  IMPORTING .SQL FILE TO DB  */
			/******************************/



			default:

			case 'get_data':


				$query = 'http://www.cars.com/for-sale/searchresults.action?stkTyp=N&tracktype=newcc&rd=100000&zc=02108&searchSource=TRAIL_HEAD&enableSeo=1';
				$cache_file = PATH_APP_DATA.'/'.md5($query).'.html';

				if(file_exists($cache_file)){

					$html = file_get_contents($cache_file);

				}else{

					require_once(PATH_LIB.'/curl.php');

					$curl = new cURL();
					$query = 'http://www.cars.com/for-sale/searchresults.action?stkTyp=N&tracktype=newcc&rd=100000&zc=02108&searchSource=TRAIL_HEAD&enableSeo=1';
					$html = $curl->get($query);
					file_put_contents($cache_file,$html);
				}



				$html = iconv('ISO-8859-1', 'UTF-8', $html);
				$tidy = new tidy();
				$tidy->ParseString($html);
				$tidy->cleanRepair();

				$doc = new DOMDocument();
				@$doc->loadHTML((string) @$tidy);

				$meta = simplexml_import_dom($doc);



				$rows_meta = $meta->xpath("//div[@class='row vehicle']");
				$element = new Element();
				$xml = '';

				$params = new Element();




				$grid  = new Ui_Grid();



				$rowset = new Rowset();
				$rows = new Std_Array();
				
				foreach ($rows_meta as $row_meta){

					//$xml = $row_meta->asXml();
					$el = new Element()	;
					$row_xml = $row_meta->asXml();
					$_row_meta = simplexml_load_string($row_xml);

					$data  = $_row_meta->xpath("//h4[@class='secondary']");

					$html   = $row_meta->asXml();
					//	preg_replace("/<(.+?)>(.+?)<(.+?)\/>/is", "$3 <br />", $html);
					//$html = preg_replace("/(\<\/.+?\>)/is", "$1 <br>", $html);
					$html = preg_replace("/(\<\/[div|span]\>)/is", "$1 <br>", $html);

					$html = strip_tags($html,'<br><a>');
					$html = preg_replace('~>[\s]+<~', '><', $html);

					$html = html_entity_decode($html, ENT_NOQUOTES, 'UTF-8');

					$lines = split('<br>',$html);
					$html = '';






					//$arr = new Std_Array($lines);




					$arr = array();
					foreach ($lines as $line){
						$count = strlen(trim($line));
						if(trim($line) != '' && $count > 3) {


							//$row_arr = split('<br>',$line);

							$arr[] = $line;
							//$row->addElement()->setValue($line);

							//$html  .= $line.'<br />';
						}

					}
					$rows[] = $arr;
					
				}
				
				$rowset->addRows($rows);

			

				$grid->addData($rowset);
				
					
				$rr = $grid->data;
				$zz = $rr->rowset;
				$dd = $zz->rows;
				$ccc = $dd[0];
				
				$grid->setTitle('Import result');
				$window->workspace->addElement($grid);


				//file_put_contents('z:/data.html',$xml);
				//echo $doc->saveHTML();
				//echo $html;
				//	exit();



				break;






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
			case 'load_report':


				global $db;
				$handle  = fopen(PATH_APP_DATA.'/ad-report.csv','r');
				$i=0 ;
				while (($data = fgetcsv($handle,null,"\t")) !== FALSE) {
					$i++;

					if($i == 1) continue; //skipping header

					$r=34;
					$fields = array('date','keyword_id','clicks_total','clicks_payed','profit_usd');
					$db->sqlgen_insert('_adforce_report',$data,null,false,$fields);

				}

				break;



			case 'db_load':


				$page->addParam('show_old_ui',1);


				//tables data import
				$file = PATH_APP_DATA.'/data.sql';
				$db->importSqlFromFile($file);

				//integrity links import
				$file = PATH_APP_DATA.'/integrity.sql';
				$db->importSqlFromFile($file);




				$file = $session->getParam('upload_file');
				$window->workspace->output->addElement('upload_file')->setValue($file)->setTitle('Uploaded file');




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



				$file_meta = PATH_APP_DATA.'/_meta.xml';
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

				$sql_prepared_handle = fopen($sql_file,'a+');

				$debug_data = '';


				ini_set('auto_detect_line_endings', true);

				//require_once(PATH_LIB.'/csv.php');
				//while (($data = CSV::fgetcsv($handle,null,",")) !== FALSE) {
				while (($data = fgetcsv($handle,null,",")) !== FALSE) {
					//	while (($file_line = fgets($handle)) !== false) {

					//
					//		$data = explode(',',$file_line);
					//implode()



					if($line < 100){
						$debug_data .=  implode(",", $data).PHP_EOL;

					}else file_put_contents(PATH_APP_DATA.'/debug.txt',$debug_data);




					if(count($data) < 2) {

						//check for global info like (Jul 1, 2013-Jul 25, 2013)

						$global_data_string = implode(",", $data);	//  .. back to .. =)



						//check for date interval

						//	preg_match('/\(([A-Za-Z0-9\,\s\-]+)\)/',$global_data_string,$matches);

						if(preg_match("/\((.*)\)/",$global_data_string,$matches)){

							if( count(split('-',$matches[1])) > 1) {
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
						foreach ($data as &$val){

							$header->addElement()->setTitle($val);

						}

						$session->setParam('header',serialize($header));

						$header_is_parsed = true;
						continue;
					}



					/*@var $elements_flat_list Element*/

					$ad_group_title = $elements_flat_list->getElement('ad_group_id')->getTitle();
					$header->searchElement(array('title'=>$ad_group_title));
					$ad_group_id_index = $header->getSearchElementIndex();
					$ad_group_id = $data[$ad_group_id_index];

					$keyword_title = $elements_flat_list->getElement('google_keyword_id')->getTitle();
					$header->searchElement(array('title'=>$keyword_title));
					$keyword_id_index = $header->getSearchElementIndex();
					$keyword_id = $data[$keyword_id_index];


					$campaign_title = $elements_flat_list->getElement('campaign')->getTitle();
					$header->searchElement(array('title'=>$campaign_title));
					$campaign_id_index = $header->getSearchElementIndex();
					$campaign = $data[$campaign_id_index];


					$integrity_sql .= "SELECT  id INTO @keyword_id FROM adforce_keywords WHERE google_keyword_id = ".$keyword_id.';'.PHP_EOL;
					$integrity_sql .= "SELECT  id INTO @category_id FROM adforce_categories WHERE ad_group_id = ".$ad_group_id.';'.PHP_EOL;
					$integrity_sql .= "SELECT  id INTO @campaign_id FROM adforce_campaigns WHERE campaign = '".$campaign.'\';'.PHP_EOL;
					$integrity_sql .= "INSERT INTO  adforce_links  SET campaign_id = @campaign_id, category_id = @category_id, keyword_id = @keyword_id;".PHP_EOL;





					$adv_id_title = $elements_flat_list->getElement('adv_id')->getTitle();
					$adv_id_index = $elements_flat_list->getSearchElementIndex();


					$destination_url_title = $elements_flat_list->getElement('destination_url')->getTitle();
					$header->searchElement(array('title'=>$destination_url_title));
					$destination_url_index = $header->getSearchElementIndex();
					if($destination_url = $data[$destination_url_index]){

						list ($url_request_string,$url_params_string) = split('\?',$destination_url);

						if($url_params_string){
							list($left_part,$adv_id) = split('\=',$url_params_string);
							if($adv_id = (int) $adv_id) {
								if($adv_id < 8000000) $adv_id = null;
								$header->addElement()->setTitle($adv_id_title);
								$data[( count($header->getElements())-1 )] = $adv_id;


								$data[$destination_url_index] = $url_request_string;
							}
						}


					}


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

							$element_title = $elements_flat_list->getElement($name)->getTitle();

							$header->searchElement(array('title'=>$element_title));
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

				fwrite($integrity_handle, $integrity_sql);
				fclose($integrity_handle);


				/***********************/
				/*   data import end  */
				/**********************/



				/*********************************/
				/*  START preparing data for db */
				/*******************************/



				global $db;



				$sql_file = PATH_APP_DATA.'/data.sql';
				if($first_stage && file_exists($sql_file)) unlink($sql_file);


				$sql_prepared_handle = fopen($sql_file,'a+');

				foreach ($_db->getElements() as $_table){


					$table_name = $_table->getName();

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
						fwrite($sql_prepared_handle, $sql_string.';'.PHP_EOL);




						//

					}


					//check for




				}


				$window->workspace->output->addElement($_db);


				if($redirect_next_stage){

					$inout->redirectUrl('/adforce-import/parse/?position='.$position.'&line='.($start_line+$line));
				}else {

					$window->workspace->output->setValue(' ');
					$panel = $window->workspace->addElement('panel');
					/*@var $panel Element*/
					$button = $panel->addElement('button_1')->setTitle('Db-load');
					$button->addAction(new Ui_Action())->setType(Ui_Action::Type_CLICK )->setName('onClick')->setValue('/adforce-import/db_load/');

				}

				/*********************************/
				/*  end preparing data for db */
				/*******************************/






				break;


				/*********************/
				/*  INITIAL UPLOAD  */
				/*******************/

			case 'upload':

				$page->addParam('show_old_ui',0);
				$page->addParam('class_params_string',$this->_class_params_string);
				$app_name = $class_params[count($class_params)-1];



				$form = $workspace->addElement('form_01')->setType('form')->setTitle('get data from sources:');
				$button = $form->addElement('button_01')->setTitle('get')->setType('button');


				$activity = $button->addActivity('onClick');
				$_action = new Ui_Action('action_001');
				$_action->setType = 'message_box';
				$_action->setValue('helloy');


				Registry::set('new_ui',1);

				$registry = Registry::getInstance();

				$ui = $registry->getParam('new_ui');

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





					$file = $form->getField('file')->getValue();


					$window->workspace->output->addElement('file')->setValue($file)->setTitle('File');

					$window->workspace->output->addElement('size')->setValue(filesize($file) / 1024)->setTitle('Size');

					$panel = $window->workspace->addElement('panel');
					/*@var $panel Element*/
					$button = $panel->addElement('button_1')->setTitle('Parse');
					$button->addAction(new Ui_Action())->setType(Ui_Action::Type_CLICK )->setName('onClick')->setValue('/adforce-import/parse/');


					$session->setParam('upload_file',$file);


					/* PARSE-START */


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
					while (($data = fgetcsv($handle,null,',')) !== FALSE) {


						if($i < 20)  {

							if(count($data) < 2) continue;

							if(!$header_is_parsed){
								foreach ($data as $val){
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
							$title = $element->getValue();
							$name = strtolower(str_replace(' ','_',$title));

							$meta_element->addAttribute('name',$name);
							$meta_element->addAttribute('title',$title);



						}

						$xml_string = $meta->asXml();

						$dom = new DOMDocument("1.0");
						$dom->preserveWhiteSpace = false;
						$dom->formatOutput = true;
						$dom->loadXML($xml_string);
						$xml_string =  $dom->saveXML();

						file_put_contents('Z:\meta.xml',$xml_string);




					}


					//open prepared meta with correct tables

					//	$meta = simplexml_load_file('z:/_meta.xml');





					$inout->setRedirectUrl('/adforce-import/parse/');

					break;
























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