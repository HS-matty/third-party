<?php


require_once(PATH_ROOT.'/logic/model/adforce.php');

class App_Adforce_Export extends App_Default  {





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

		//	require_once(PATH_LIB.'/radmaster-lib/db/query.php');
		$output = $window->workspace->output;

		switch ($this->_app_params_string){



			case 'download':


				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
				header("Content-Transfer-Encoding: binary;\n");
				//$filename = 'report_'.time().'.csv';
				$now = date('(d-m-Y)-(H-i)',time());
				$filename = 'export-'.$session->getParam('export_file_name_full').'-'.$now.'.csv';
				header("Content-Disposition: attachment; filename=\"$filename\";\n");
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header("Content-Description: File Transfer");
				//$file = '/tmp/export-file.csv';
				$file = $session->getParam('export_file');
				//$file = 'z:'.$file;
				header("Content-Length: ".filesize($file).";\n");

				readfile($file);
				exit();
				break;


			default:






				$filter = new Ui_Form('filter');
				$filter = $window->workspace->addElement($filter);//->setType(Ui::Type_FORM );

				
				$field_divider_select = $filter->addField()->setType(Ui_Element::Type_SELECT)->setTitle('Fields divided by')->setName('field_divider');
				
				$field_divider_data = array(array('comma','comma (,)'),array('tab','tab  (\t)'),array('space','space  ( )'));
				$field_divider_select->addData($field_divider_data);
				
				if(!$inout->getParam('post')){
					$field_divider_select->setValue('comma');
				}
				$field_divider_select->setParam('is_required',1);
				//$field_divider_select->
				
				
				$campaign_select = $filter->addField();
				$campaign_select->setType(Ui_Element::Type_SELECT)->setName('campaign_id')->setTitle('Campaign');
				$campaign_select->setValue($campaign_id)->setParam('is_test',1);
				$campaign_select->setParam('is_required',1);

				$campaign_select->getValue()->setType('int');







				//$category_select = new Ui_Element();
				$category_select = $filter->addField();
				$category_select->setType(Ui_Element::Type_SELECT)->setName('category_id')->setTitle('Category')->setParam('is_multiple',1)->setParam('size',8);
				$category_select->setParam('is_required',0);



				/*				$campaign_id = (int) $inout->getParam('campaign_id');

				$category_id_array = new Std_Array($inout->getParam('category_id'));*/

				//	$page->addParam('category_id',$category_id);

				$form_validator = new Form_Validator();
				if($inout->isFormPost() && $form_validator->validateForm($filter)){


					//$campaign_id = (int) $filter->getField('campaign_id')->getValue();
					$campaign_id = (int) $inout->getParam('campaign_id');
					$category_id_array = $filter->getField('category_id')->getValue()->getValue();

					$field_divider = (string) $filter->getField('field_divider')->getValue();
					
					$field_divider_db = '';
					switch ($field_divider){

						case 'tab':
							$field_divider_db = '\t';
							break;
							
						case 'space':
						$field_divider_db = ' ';
							break;
						case 'comma':
						default:
							$field_divider_db  = ',';
							break;					
						
						
					}
					if(!$campaign_id) throw new Exception('capmaign_id not set');

					$file_meta = PATH_APP_DATA.'/_meta.xml';

					$logic = new Logic_Model_Adforce();
					$logic->parseMeta($file_meta);

					$elements = $logic->elements_flat_list;
					/*@var $elements Element*/

					$_db = $logic->db;

					$query = new RadSelectQuery();

					$header = new RadSelectQuery();
					$query->addFrom('adforce_links');


					foreach ($_db->getElements() as $table){

						if($table->getName() == 'table') continue;
						$query->addFrom('adforce_'.$table->getName());

					}

					
					
				/*	$titles = array('Action','Keyword,'state, Keyword Match type Campaign Ad group Ad group ID
Destination URL Keyword ID*/
					foreach ($elements as $element){


						if(!$element->export_skip) {

							if($element->name == 'destination_url'){

								$query->addWhat("CONCAT(adforce_links.{$element->name}, '?aid=', (adforce_links.id) + 9000000) as {$element->name}");

							}elseif ($element->name == 'action'){
								
							$query->addWhat("'set' as action");
							}else $query->addWhat($element->name,'adforce_'.$element->table_name);
							$header->addWhat("'$element->title'");
						}



					}

					$where_group = $query->addWhereGroup();
					$where_group->addJoin('adforce_links','keyword_id','adforce_keywords','id');
					$where_group->addJoin('adforce_links','category_id','adforce_categories','id');
					$where_group->addJoin('adforce_links','campaign_id','adforce_campaigns','id');
					$where_group->addJoin('adforce_stats_google','google_keyword_id','adforce_keywords','google_keyword_id');


					if($campaign_id) {

						$where_campaign_filter = $query->addWhereGroup('AND');
						$where_campaign_filter->add('campaign_id',$campaign_id,'adforce_links');
						
						$campaigns_datasource = new Datasource_Table('adforce_campaigns');
						$data = $campaigns_datasource->fetchData(array('id'=>$campaign_id),'assoc')->getData();

						$campaign_name = $data[0]['campaign'];
						$campaign_name_ansi = iconv("utf-8", "windows-1251", $campaign_name);
						$campaign_name_en = str2url($campaign_name_ansi);
					
						
						

					}
					
					if(!$category_id_array[0]) $count_categories = 0;
					else $count_categories = count($category_id_array);

					
					
					if($category_id_array) {

						
						
						$where_category_filter = $query->addWhereGroup('AND');
						$where_category_filter->setDefaultOperator('OR');
						foreach ($category_id_array as $category_id){
							$category_id = (int) $category_id;
							if($category_id !=0) $where_category_filter->add('category_id',$category_id,'adforce_links');
						}
					}

					$export_file_name_full = $campaign_name_en;
					if($count_categories) $export_file_name_full .= '__'.$count_categories.'-categories';
					$session->setParam('export_file_name_full',$export_file_name_full);
					
					//$query->addLimit('1000');
					$query->addOrder('id','adforce_links');
					
				//	exit($query->getSqlString());
					$filename = md5(time());
					$file = PATH_APP_DATA."/{$filename}.csv";

					$session->setParam('export_file',$file);


					if(file_exists($file)) unlink($file);

					$file = str_replace('\\','/',$file);
					$into = " INTO OUTFILE '{$file}' FIELDS TERMINATED BY '{$field_divider_db}'  ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
					$query->addIntoString($into);


					$union_query = new RadUnionQuery();
					$union_query->addSelect($header);
					$union_query->addSelect($query);


					$sql = $union_query->getSqlString();
					$db->query($sql);


					
					$data = file_get_contents($file);
					$data = str_replace("\\N",'',$data);
					//$data = mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
					$data = chr(255).chr(254).mb_convert_encoding( $data, 'UTF-16LE', 'UTF-8');
					/*header("Content-type: application/octet-stream");
					header("Content-Transfer-Encoding: binary");
					header("Content-Disposition: attachment; filename=report.xls");

					// assume $tmpString contains UTF-8 encoded CSV:
					$tmpString =  iconv ( 'UTF-8', 'UTF-16LE//IGNORE', $tmpString );

					print chr(255).chr(254).$tmpString;*/
					file_put_contents($file,$data);


					//echo $sql;
					//exit();


					/*					if($inout->getParam('export_file_type') == 'excel'){

					require_once(PATH_LIB.'/php-excel/Classes/PHPExcel.php');
					$excel_export = new PHPExcel();
					$page = $excel_export->setActiveSheetIndex(0);

					$page->setCellValue("B2", "�����");
					$page->setCellValue("C5", "������, � �������");
					$page->setCellValue("A8", "��������� ������� mysql");
					$page->setTitle("export");
					$objWriter = PHPExcel_IOFactory::createWriter($excel_export, 'Excel2007');
					$objWriter->save(PATH_APP_DATA."/test.xlsx");


					}*/


					//replace \N




					$inout->redirectUrl('/adforce-export/download/');
					//$window->workspace->output->addElement('sql')->setValue($sql)->setTitle('sql');

				}


				$datasource = new Datasource_Table('adforce_campaigns');
				$data =& $datasource->setFields(array('id,campaign'))->fetchData()->getData();

				$campaign_select->addData($data);

				if($campaign_id){

					require_once(PATH_ROOT.'/logic/datasource/adforce/category.php');
					$datasource = new Logic_Datasource_Adforce_Category($datasource_name);

					$data = $datasource->setFields(array('adforce_categories.id','adforce_categories.ad_group'))->fetchData(array('campaign_id'=>$campaign_id))->getData();

					$category_select->addData($data);

				}


				$category_select->setValue($category_id_array);
				//634










				/*
				$export = $filter->addField()->setType(Ui_Element::Type_CHECKBOX);
				$export->setTitle('Export');
				$export->setName('export');
				$export->setParam('default_value',0);
				$export->setValue(0);*/


				/*		$filter = new Ui_Form('filter');


				$filter->setType(UI::Type_FORM );



				$param0 = $filter->addField()->setName('export_file_type')->setTitle('Type');
				$param0->setType('select');
				$param0->addElement()->setTitle('csv')->setValue('csv');
				$param0->addElement()->setTitle('excel')->setValue('excel');



				$table = new Db_Table('categories');

				$table->getAdapter()->query('Select id,ad_group as title from adforce_categories ORDER BY ad_group ASC');

				$rows =& $table->getAdapter()->fetch_all_assoc();


				$param1 = $filter->addField()->setName('category_id');
				$param1->setValue($category_id);
				$param1->setTitle('Category');
				$param1->setType('select');
				$param1->is_multiple = 1;


				$param1->addElement()->setTitle('All')->setValue(0);
				foreach ($rows as $row){

				$param1->addElement()->setTitle($row['title'])->setValue($row['id']);
				}


				$window->workspace->addElement($filter);*/




		}
	}



	public function onInit(){

		Registry::get('log')->addMessage('helloy from '. get_class($this));

	}








}

?>