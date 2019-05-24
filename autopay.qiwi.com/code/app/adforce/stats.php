<?php

class App_Adforce_Stats extends App_Default  {



	protected $_elements_flat_list;
	protected $_db;




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

		$workspace = $window->workspace;

		$tab = $workspace->addElement('tab')->setTitle('Stats')->setType(Ui::Type_TAB);
		$tab->addElement('button_1')->setTitle('Report')->setName('report')->setParam('link','/adforce-stats/report/');
		$tab->addElement('button_2')->setTitle('Affilates')->setName('affilates')->setParam('link','/adforce-stats/affilates/');
		$tab->addElement('button_3')->setTitle('Google')->setName('google')->setParam('link','/adforce-stats/google/');
		$tab->setCurrentElement($this->_app_params_string);

		/*@var $db Db_Adapter*/

		$page->addParam('workspace',$workspace);

		switch ($this->_app_params_string){




			case 'google':


				$query = new RadSelectQuery();
				$query->addWhat('distinct date_start');
				$query->addWhat('date_end');
				$query->addFrom('adforce_stats_google');


				//$db->perfromSelectQueryExt_new($query);
				$db->performQuery($query);
				$rowset = $db->getRowset();

				$ui = Registry::get('ui');

				/*@var $ui Ui*/
				$ui->setRowset($rowset);
				$grid = $ui->loadUiElement('/@ui/app/adforce/stats/@grid/'.$this->_app_params_string,true);
				$grid->addElement('data')->addElement($rowset);

				//$grid->setParam('row_option_select',1);


				$window->workspace->addElement($grid);





				break;


			case 'affilates':


				//$sort_by  = $inout->getParam('sort_by');
				//$direction = $inout->getParam('direction');


				
				$text = new Ui_Element();
				$text->setName('text_01')->setType(Ui_Element::Type_TEXT)->setValue('Page is under reconstruction %-[');
				$window->workspace->addElement($text);

				break;
				
				$form = new Ui_Form();
				$form->setName('upload_aff_stats');
				$f = $form->addField()->setName('file');
				$f->setTitle('CSV file');
				$f->setType(Ui_Element::Type_FILE);

				$window->workspace->addElement($form);


				$ui = Registry::get('ui');



				$form_validator = new Form_Validator();
				if($inout->isFormPost() && $form_validator->validateForm($form)){

					$data = $form->getData();


					$file = $data['file'];
					if($handle  = fopen($file,'r')){
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

					}

				}



				$grid = $ui->loadUiElement('/@ui/app/adforce/stats/@grid/'.$this->_app_params_string);
				
				//$grid = new Ui_Grid();

				
			
				
				$query = new RadSelectQuery();


				foreach ($grid->getFields() as $field ){

					if($table = $field->getParam('table')) $query->addFrom($table);
					$query->addWhat($field->name,$table);


				}


				if($query_params = Registry::get('query_params')){

					if($query_params->getParam('order_by')) $query->addOrder($query_params->getParam('order_by'),null,$query_params->getParam('direction'));

				}
				///$query->addFrom('adforce_keywords');
				//$query->addFrom('_adforce_report');

				$where = $query->addWhereGroup();
				$where->addJoin('adforce_keywords','id','_adforce_report','keyword_id');

				//if($sort_by && $direction) $query->addOrder($sort_by,'k',$direction);
				$sql = $query->getSqlString();



				//$db->query($sql);
				//$db->perfromSelectQueryExt_new($query);
				/*@var $db Db_Adapter */
				$db->performQuery($query);

				/*@var $db Db*/
				//	$db->performSelectQueryForList($sql);

				$rowset = $db->getRowset();

				if($rowset){
					$arr = $rowset->header->getValue();
					$grid->addFields($arr);

				}

				//$header = $rowset->header->getValue();





				/*@var $ui Ui*/
				$ui->setRowset($rowset);


				$window->workspace->addElement($grid);
				$grid->addElement('data')->addElement($rowset);






				break;


			default:
				$this->_app_params_string = 'report';
			case 'report':


				$ui = Registry::get('ui');
				$tab->setCurrentElement('report');

				$query_params = new Element('params');
				//$query_params->addElement('id')->setType('int')->setParam('table','adforce_stats_google')->setParam('exp','=');
				$query_params->addElement('date_start')->setType('date')->setParam('table','adforce_stats_google')->setParam('exp','>=');
				$query_params->addElement('date_end')->setType('date')->setParam('table','adforce_stats_google')->setParam('exp','<=');
				$query_params->addElement('date_start')->setType('date')->setParam('table','_adforce_report')->setParam('exp','>=')->setParam('field_name','date');
				$query_params->addElement('date_end')->setType('date')->setParam('table','_adforce_report')->setParam('exp','<=')->setParam('field_name','date');


				//is form posted


				$grid = $ui->loadUiElement('/@ui/app/adforce/stats/@grid/'.$this->_app_params_string,false);

				if($inout->getParam('post')){

					$page->addParam('post',1);

					$order_by  = $inout->getParam('order_by');
					$direction = $inout->getParam('direction');

					if($direction == 'asc') $page->addParam('direction','desc');
					elseif($direction == 'desc') $page->addParam('direction','asc');
					else $page->addParam('direction','asc');

					$adv_id = (int) $inout->getParam('adv_id');
					$campaign_id = (int) $inout->getParam('campaign_id');
					$is_calculated = (int) $inout->getParam('is_calculated');


					$category_id_array = new Std_Array($inout->getParam('category_id'));


					$query = new Db_Query_Select();




					foreach ($grid->fields->getElements() as $_el){


						if($_el->getParam('is_enabled') == 0) continue;

						$name = $_el->name;
						$table = $_el->table;

						$type = $_el->group;

						switch ($name){

							case 'clicks_count_total':
								$name = 'sum(_adforce_report.clicks_total) AS clicks_count_total';
								$table = null;
								break;

							case 'clicks_payed_total':
								$name = 'sum(_adforce_report.clicks_payed) AS clicks_payed_total';
								$table = null;
								break;

							case 'profit_usd_total':
								$name = 'sum(_adforce_report.profit_usd) AS profit_usd_total';
								$table = null;

								break;

							case 'impressions':
								$name = 'sum(adforce_stats_google.impressions) AS impressions';
								$table = null;

								break;
							case 'ctr':
								$name = 'sum(adforce_stats_google.ctr) AS ctr';
								$table = null;

								break;
							case 'target_cpa':
								$name = 'sum(adforce_stats_google.target_cpa) AS target_cpa';
								$table = null;

								break;

							case 'adv_id':
								$name = "adforce_keywords.id+8000000 as adv_id";
								$table = null;

								break;
							case 'destination_url':
								$name = "CONCAT(adforce_keywords.destination_url, '?aid=', (adforce_keywords.id) + 8000000) as destination_url";
								$table = null;

								break;
							default:

								break;
						}
						$query->addWhat($name,$table);
						if($table) $query->addFrom($table);




					}



					$query->addFrom('adforce_keywords');
					$query->addFrom('adforce_stats_google');
					$query->addFrom('_adforce_report');








					$query->addGroupBy('id','adforce_keywords');

					$where = $query->addWhereGroup('AND');

					if($campaign_id){

						$where->add('campaign_id',$campaign_id,'adforce_links');

					}

					if($category_id_array){

						$where_group = $query->addWhereGroup('OR');
						foreach ($category_id_array as $category_id){

							$category_id = (int) $category_id;
						
							$where_group->add('category_id',$category_id,'adforce_links');


						}

					}


					if($is_calculated){
						$query->addFrom('_adforce_report');
						$query->addJoin('_adforce_report','keyword_id','adforce_keywords','id');

					}
					else $query->addJoin('adforce_keywords','id','_adforce_report','keyword_id',Db_Query_Select::JOIN_TYPE_LEFT );

					$query->addJoin('adforce_stats_google','google_keyword_id','adforce_keywords','google_keyword_id');
					//$query->addJoin('adforce_keywords','id','_adforce_report','keyword_id');


					$from_array = $query->getFromArray();
					
					
					if(array_search('adforce_categories',$from_array)){
						$query->addFrom('adforce_links');
						$query->addJoin('adforce_links','category_id','adforce_categories','id');
						$query->addJoin('adforce_links','keyword_id','adforce_keywords','id');


					}

					if(array_search('adforce_campaigns',$from_array)){
						$query->addFrom('adforce_links');
						$query->addJoin('adforce_links','campaign_id','adforce_campaigns','id');
						$query->addJoin('adforce_links','keyword_id','adforce_keywords','id');


					}


					foreach ($query_params as $param){

						$name = $param->getName();
						if($param_string = $inout->getParam($name)){

							switch ($param->type){

								case 'int':
									$param_string = (int) $param_string;
									break;
								case 'date':
									$param_string = date('Y-m-d',strtotime($param_string));
									break;
								default:
									//todo add regexp
									$param_string  = addslashes($param_string);
									break;



							}

							$param->setValue($param_string);
							if(!$field_name = $param->getParam('field_name')) $field_name = $param->getName();
							$where->add($field_name,$param_string,$param->getParam('table'),$param->getParam('exp'));

						}

					}



					if($adv_id) $where->add('adforce_keywords.id',$adv_id-8000000);
					//$query->addLimit('3');

					if($order_by){

						$query->addOrder($order_by,null,$direction);

					}

					$sql  = $query->getSqlString();


//						exit($sql);




					$export_flag = (int) $inout->getParam('export');
					if($export_flag){

						$header = new RadSelectQuery();

						foreach ($grid->fields->getElements() as $field){

							if($field->getParam('is_enabled')) $header->addWhat("'$field->title'");

						}



						$filename = md5(time());
						$file = PATH_APP_DATA."/{$filename}.csv";

						$session->setParam('export_file',$file);


						if(file_exists($file)) unlink($file);

						$file = str_replace('\\','/',$file);
						$into = " INTO OUTFILE '{$file}' FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' ";
						$query->addIntoString($into);







						$union_query = new RadUnionQuery();
						$union_query->addSelect($header);
						$union_query->addSelect($query);
						//	$sql = $query->getSqlString();
						$db->query($union_query->getSqlString());
						//		echo $sql;
						//		exit();

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


						$inout->redirectUrl('/adforce-export/download/');

					}

					/*@var $db Db_Adapter*/
					//$db->perfromSelectQueryExt_new($query);
					$db->performQuery($query);

					$rowset = $db->getRowset();


					$grid = $ui->loadUiElement('/@ui/app/adforce/stats/@grid/'.$this->_app_params_string,false);
					$grid->setType('grid');










					//$_grid = Ui_Element::_init('/@ui/app/adforce/stats/form01');


					//$grid->addElement('data')->addElement($rowset);
					$grid->addData($rowset);

				}

				
				
				
				
				//////
				//		GUI
				////
				
				
				
				
				$filter = new Ui_Form('filter');
				$filter = $window->workspace->addElement($filter);//->setType(Ui::Type_FORM );
				$param1 = $filter->addField()->setName('adv_id');
				$param1->setTitle('Adv ID');
				$param1->setType('input');

				if($adv_id) $param1->setValue($adv_id);


				$campaign_select = new Ui_Element();
				$campaign_select->setType(Ui_Element::Type_SELECT)->setName('campaign_id')->setTitle('Campaign');
				$campaign_select->setValue($campaign_id)->setParam('is_test',1);


				$filter->addField($campaign_select);


				$datasource = new Datasource_Table('adforce_campaigns');
				$data =& $datasource->setFields(array('id,campaign'))->fetchData()->getData();

				$campaign_select->addData($data);
				

				$category_select = new Ui_Element();
				$category_select->setType(Ui_Element::Type_SELECT)->setName('category_id')->setTitle('Category')->setParam('is_multiple',1)->setParam('size',5);

				if($campaign_id){

					require_once(PATH_ROOT.'/logic/datasource/adforce/category.php');
					$datasource = new Logic_Datasource_Adforce_Category($datasource_name);

					$data = $datasource->setFields(array('adforce_categories.id','adforce_categories.ad_group'))->fetchData(array('campaign_id'=>$campaign_id))->getData();

					$category_select->addData($data);

				}
				

				$category_select->setValue($category_id_array);
				//634

			
				
				
				$filter->addField($category_select);



				$param2 = $filter->addField()->setName('date_start');
				$param2->setTitle('Date start');
				$param2->setType('date');
				if($date_start = $query_params->getElement('date_start')->getValue()) $param2->setValue($date_start);

				$param3 = $filter->addField()->setName('date_end');
				$param3->setTitle('Date end');
				$param3->setType('date');
				if($date_end= $query_params->getElement('date_end')->getValue()) $param3->setValue($date_end);


				$export = $filter->addField()->setType(Ui_Element::Type_CHECKBOX);
				$export->setTitle('Export');
				$export->setName('export');
				$export->setParam('default_value',0);
				$export->setValue(0);


				$calculated = $filter->addField()->setType(Ui_Element::Type_CHECKBOX);
				$calculated->setTitle('Calculated');
				$calculated->setName('is_calculated');
				$calculated->setParam('default_value',1);
				$calculated->setValue($is_calculated);


				$window->workspace->addElement($grid);


				$params_url = '';
				foreach ($filter as $item){

					$params_url .= "{$item->name}={$item->getValue()}&";

				}

				$page->addParam('form_params_string',$params_url);


				//$workspace->addElement($grid);


				//	$form_grid_settings = new Ui_Element(UI::Type_FORM);


				$accordion = new Ui_Element(Ui_Element::Type_ACCORDION);

				//$accordion->setTitle('Columns');
				$accordion->setName('accordion')->setTitle('Grid settings');

				/*	$accordion->addElement(Ui_Element::Type_TEXT)->setTitle('Text')->setValue('text 1')->setName('01');
				$accordion->addElement(Ui_Element::Type_TEXT)->setTitle('Text')->setValue('text 2')->setName('02');*/




				$acc_form = $accordion->addElement(Ui_Element::Type_FORM )->setTitle('Columns')->setValue('Columns')->setName('columns');
				foreach ($grid->getFields() as $key=>  $field){

					$check_box = new Ui_Element(Ui_Element::Type_CHECKBOX);
					$check_box->setName($field->getName());
					$check_box->setTitle($field->getTitle());
					$check_box->setValue($field->is_enabled);
					$acc_form->addElement($check_box);

				}


				//		$grid->addElement($accordion);
				$workspace->addElement($accordion);




				/* @var $filter Ui_Element*/


				//$grid = $window->workspace->addElement('grid');











		}
	}






}

?>