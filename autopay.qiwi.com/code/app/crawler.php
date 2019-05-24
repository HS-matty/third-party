<?php


require_once(PATH_ROOT.'/logic/model/adforce.php');

class App_Crawler extends App_Default  {







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

		//$class_params = $this->getClassParams();

		//	$app_params = $this->_app_params;

		$request = Registry::get('request');
		$inout = Registry::get('inout');



		$window = Registry::get('window');

		global $db;

		$workspace = $window->workspace;
		$output = $window->workspace->output;


		$action = (string) $request->getElement(1);
		switch ($action){



			default:

			case 'results':


				$sites_arr = array('cars.com','autotrader.com','craigslist.com','backpage.com'); //
				$cars_arr = new Std_Array(array('Toyota (4Runner) / 2000-2008 ','Chevy Duramax Diesel Any GMC / 2000-2006','Lexus (RX) / 1998-2006','BMW (325xi, 330xi) / 2000-2006',' Audi (A4 quattro) / 2000-2005','Ford truck (F250, F350) / 2000-2003','Grand Cherokee diesel 7.3L / 2000-2008'));


				$sites = unserialize(file_get_contents(PATH_APP_DATA.'/crawler/sites.cache'));

				$form = new Ui_Form('search');
				$field = $form->addField();
				$field->setName('site')->setType(Ui_Element::Type_SELECT)->setTitle('Site');
				$field->getValue()->setType('string');



				$field2 = $form->addField();
				$field2->setName('car')->setType(Ui_Element::Type_SELECT)->setTitle('Car');
				/*foreach ($sites_arr as $site){
				$field->addElement()->setTitle(ucfirst($site))->setValue($site);
				}*/

				/*$field3 = $form->addField();
				$field3->setName('model')->setType(Ui_Element::Type_SELECT)->setTitle('Model')->setParam('is_required',1);
				*/

				/*
				foreach ($cars_arr as $car){
				$field3->addElement()->setTitle(ucfirst($car))->setValue($car);
				}*/


				foreach ($sites as $site){

					$field->addElement()->setTitle(ucfirst($site->getTitle()))->setValue($site->getName());



				}

				foreach ($site->search->cars as $car){

					$vendor = (string) $car->getElement('vendor');
					$model = (string) $car->getElement('model');
					$field2->addElement()->setTitle($vendor.'-'.(string) $model)->setValue($vendor.'-'.(string) $model);
				}
				
				


				//	$field2 = $form->addField();
				//	$field2->setName('zip_code')->setType(Ui_Element::Type_INPUT)->setTitle('Zip Code')->setParam('is_required',1)->setValue('80111')->getValue()->setType('string');;
				//$field2->getValue()->setType('string');







				






				$validator = new Form_Validator();
				//$window->workspace->addElement($form);

				$page->addParam('form',$form);
				$grid  = new Ui_Grid();

				if($inout->getParam('post') && $validator->validateForm($form)){

					//exit('success');

				
					$site_name = (string)$form->getField('site')->getValue();
					$car = (string) $form->getField('car')->getValue();









					//http://redirect.me/
					//				if(!$id = (int)$inout->getParam('id')) $id = 1;





					//$site_name = 'autotrader.com';
					//$site_name = 'craigslist.org';

					//$site_name = $sites_arr[$id];
					//$html = file_get_contents(PATH_APP_DATA.'/crawler/craigslist.com-Toyota-4Runner.html');
					//		$html = file_get_contents(PATH_APP_DATA.'/crawler/cars.com-Audi-A4.html');
					$html = file_get_contents(PATH_APP_DATA."/crawler/".$site_name.'/'.((string) $car).".html");
					$html = iconv('ISO-8859-1', 'UTF-8', $html);
					$tidy = new tidy();
					$tidy->ParseString($html);
					$tidy->cleanRepair();

					$doc = new DOMDocument();
					@$doc->loadHTML((string) @$tidy);

					$meta = simplexml_import_dom($doc);



					//$rows_meta = $meta->xpath("//div[@class='row vehicle']");
					//listing-findcar listing-private
					//	$rows_meta = $meta->xpath("//div[[contains(concat(' ', normalize-space(@class), ' '), ' listing-findcar ')][contains(concat(' ', normalize-space(@class), ' '), ' listing-findcar ')]]");
					//class="listing listing-findcar listing-dealer "
					//[contains(concat(' ', normalize-space(@class), ' '), ' atag ')][contains(concat(' ', normalize-space(@class), ' '), ' atag ')]
					//$rows_meta = $meta->xpath("//div[contains(@class ,'listing-findcar')");




					$params = new Std_Class();



					$rowset = new Rowset();
					$rows = new Std_Array();

					$base_url = $site_name;
					switch ($site_name){



						case 'backpage.com':

							$rows_meta = $meta->xpath("//div[@class='cat summary']");
							$element = new Element();
							$xml = '';

							foreach ($rows_meta as $row_meta){



								//$xml = $row_meta->asXml();
								$el = new Element()	;
								$row_xml = $row_meta->asXml();
								$_row_meta = simplexml_load_string($row_xml);

								$data  = $_row_meta->xpath("//h4[@class='secondary']");

								$html   = $row_meta->asXml();
								file_put_contents('z:\dd.html',$html);
								//	preg_replace("/<(.+?)>(.+?)<(.+?)\/>/is", "$3 <br />", $html);
								//$html = preg_replace("/(\<\/.+?\>)/is", "$1 <br>", $html);
								$html = preg_replace("/(\<\/[div|span]\>)/is", "$1 <br>", $html);

								$html = strip_tags($html,'<br><a><img>');
								$html = str_replace('data-def-src','src',$html);
								//$html = preg_replace("/src=\"([a-z\-\.\\\/\]+)spacer.gif\"/", '', $html);

								//$html = preg_replace('spacer.gif', '', $html);

								//$html = str_replace('src=\"http:\/\/graphics.cars.com\/images\/spacer.gif\"','',$html);;
								$html = str_replace('src="http://graphics.cars.com/images/spacer.gif"','',$html);;
								//$html = str_replace('href="','href="http://'.$base_url,$html);;
								$html = preg_replace('~>[\s]+<~', '><', $html);



								$html = html_entity_decode($html, ENT_NOQUOTES, 'UTF-8');

								$lines = split('<br>',$html);
								$html = '';






								//$arr = new Std_Array($lines);




								$arr = array();
								if(count($lines) == 2){
									$arr[] = 'NO PIC';
								}
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




							break;

						case 'craigslist.com':


							$rows_meta = $meta->xpath("//p[@class='row']");
							$element = new Element();
							$xml = '';

							foreach ($rows_meta as $row_meta){



								//$xml = $row_meta->asXml();
								$el = new Element()	;
								$row_xml = $row_meta->asXml();
								$_row_meta = simplexml_load_string($row_xml);

								$data  = $_row_meta->xpath("//h4[@class='secondary']");

								$html   = $row_meta->asXml();
								file_put_contents('z:\dd.html',$html);
								//	preg_replace("/<(.+?)>(.+?)<(.+?)\/>/is", "$3 <br />", $html);
								//$html = preg_replace("/(\<\/.+?\>)/is", "$1 <br>", $html);
								$html = preg_replace("/(\<\/[div|span]\>)/is", "$1 <br>", $html);

								$html = strip_tags($html,'<br><a><img>');
								$html = str_replace('data-def-src','src',$html);
								//$html = preg_replace("/src=\"([a-z\-\.\\\/\]+)spacer.gif\"/", '', $html);

								//$html = preg_replace('spacer.gif', '', $html);

								//$html = str_replace('src=\"http:\/\/graphics.cars.com\/images\/spacer.gif\"','',$html);;
								$html = str_replace('src="http://graphics.cars.com/images/spacer.gif"','',$html);;
								$html = str_replace('href="','href="http://denver.'.$base_url,$html);;
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






							break;

						case 'autotrader.com':



							$rows_meta = $meta->xpath("//div[@id > 3531]");
							$element = new Element();
							$xml = '';

							foreach ($rows_meta as $row_meta){



								//$xml = $row_meta->asXml();
								$el = new Element()	;
								$row_xml = $row_meta->asXml();
								$_row_meta = simplexml_load_string($row_xml);

								$data  = $_row_meta->xpath("//h4[@class='secondary']");

								$html   = $row_meta->asXml();
								file_put_contents('z:\dd.html',$html);
								//	preg_replace("/<(.+?)>(.+?)<(.+?)\/>/is", "$3 <br />", $html);
								//$html = preg_replace("/(\<\/.+?\>)/is", "$1 <br>", $html);
								$html = preg_replace("/(\<\/[div|span]\>)/is", "$1 <br>", $html);

								$html = strip_tags($html,'<br><a><img>');
								$html = str_replace('data-def-src','src',$html);
								//$html = preg_replace("/src=\"([a-z\-\.\\\/\]+)spacer.gif\"/", '', $html);

								//$html = preg_replace('spacer.gif', '', $html);

								//$html = str_replace('src=\"http:\/\/graphics.cars.com\/images\/spacer.gif\"','',$html);;
								$html = str_replace('src="http://graphics.cars.com/images/spacer.gif"','',$html);;
								$html = str_replace('href="','href="http://'.$base_url,$html);;
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







							break;








						case 'cars.com':


							$rows_meta = $meta->xpath("//div[@class='row vehicle']");
							$element = new Element();
							$xml = '';

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

								$html = strip_tags($html,'<br><a><img>');
								$html = str_replace('data-def-src','src',$html);
								//$html = preg_replace("/src=\"([a-z\-\.\\\/\]+)spacer.gif\"/", '', $html);

								//$html = preg_replace('spacer.gif', '', $html);

								//$html = str_replace('src=\"http:\/\/graphics.cars.com\/images\/spacer.gif\"','',$html);;
								$html = str_replace('src="http://graphics.cars.com/images/spacer.gif"','',$html);;
								$html = str_replace('href="','href="http://'.$base_url,$html);;
								$html = preg_replace('~>[\s]+<~', '><', $html);



								$html = html_entity_decode($html, ENT_NOQUOTES, 'UTF-8');

								$lines = split('<br>',$html);
								$html = '';






								//$arr = new Std_Array($lines);




								$arr = array();
								foreach ($lines as $key=> $line){
									$count = strlen(trim($line));
									if(trim($line) != '' && $count > 3) {


										//$row_arr = split('<br>',$line);

										if($key == 8) continue;
										$line = trim($line);
										if($key == 7){
											
											list($list,$whatever) = split("\.",$line);
											
										}
										$arr[] = $line;
										//$row->addElement()->setValue($line);

										//$html  .= $line.'<br />';
									}

								}
								$rows[] = $arr;

							}

							break;
					}
					//	print_r($rows);
					//	exit();

					$rowset->addRows($rows);



					$grid->addData($rowset);


					$rr = $grid->data;
					$zz = $rr->rowset;
					$dd = $zz->rows;
					$ccc = $dd[0];

				}
				$grid->setTitle('Import result');
				$window->workspace->addElement($grid);

				break;


			case 'search':



				$site_index = (int) $inout->getParam('site_index');
				$car_index = (int) $inout->getParam('car_index');

				require_once(PATH_LOGIC.'/app/crawler.php');

				/*	$file = PATH_TEMPLATE.'/@ui/@element/form/@element/select.tpl';
				echo file_get_contents($file);
				exit();*/


				$sites_arr = new Std_Array(array('cars.com','autotrader.com','craigslist.com','backpage.com')); //'backpage.com'
				$cars_arr = new Std_Array(array('Toyota (4Runner) / 2000-2008 ','Chevy Duramax Diesel Any GMC / 2000-2006','Lexus (RX) / 1998-2006','BMW (325xi, 330xi) / 2000-2006',' Audi (A4 quattro) / 2000-2005','Ford truck (F250, F350) / 2000-2003','Grand Cherokee diesel 7.3L / 2000-2008'));

				$sites = new Std_Class('sites');

				$arr = array(array('vendor','model'),array('year_start','year_end'));

				$is_fetch = 1;

				$sites_count = count($sites_arr);
				for($i=$site_index;$i < $sites_count; $i++){
					//foreach ($sites_arr  as $key => $site_name){

					$site_name = $sites_arr[$i];
				if($i >0 ) break;

					$site = $sites->addElement($site_name)->setTitle(ucfirst($site_name));
					$search_elements = $site->addElement('search');
					$cars = $search_elements->addElement('cars');

					for($j=0;$j < count($cars_arr); $j++){
						//foreach ($cars_arr as $_key => &$car_string){

						$car_string = $cars_arr[$j];
						if($_key > 0) break;
						$car = Expression::parse($car_string,$arr,'std');
						$cars->addElement($car);


						$dir = PATH_APP_DATA.'/crawler/'.$site_name.'/';

						if (!file_exists($dir)) {
							mkdir($dir);
						}
						if($is_fetch)	Logic_App_Crawler::fetch($site_name,$car);
						$file = $dir . (string) $car->getElement('vendor').'-'.(string) $car->getElement('model');
						//$file = PATH_APP_DATA.'/crawler/'.$site_name.'-'.(string) $car->getElement('vendor').'-'.(string) $car->getElement('model');

						if($is_fetch){
							file_put_contents($file.'.html',$car->getParam('html'));
							file_put_contents($file.'.png',base64_decode($car->getParam('screenshot')));
						}


					}






					$next_i = $i+1;

					if($next_i != $sites_count && $is_fetch){

						$inout->redirectUrl('/crawler/search/?site_index='.$next_i);
						break;
					}


				}


				$sites_class = serialize($sites);

				//file_put_contents(PATH_APP_DATA.'/crawler/sites.cache',$sites_class);
				exit();







				/*

				$form = new Ui_Form('search');
				$field = $form->addField();
				$field->setName('sites')->setType(Ui_Element::Type_SELECT)->setTitle('Sites');
				$field->getValue()->setType('string');
				foreach ($sites as $site){
				$field->addElement()->setTitle(ucfirst($site))->setValue($site);
				}




				$field2 = $form->addField();
				$field2->setName('zip_code')->setType(Ui_Element::Type_INPUT)->setTitle('Zip Code')->setParam('is_required',1)->setValue('80111')->getValue()->setType('string');*/
				//$field2->getValue()->setType('string');



				//	$field3 = $form->addField();
				//	$field3->setName('car')->setType(Ui_Element::Type_SELECT)->setTitle('Car')->setParam('is_required',1)->setParam('is_multiple',1)->setParam('size',5);









				$validator = new Form_Validator();




				if($inout->getParam('post') && $validator->validateForm($form)){

					exit('success');

				}


				$page->addParam('form',$form);



		}
	}






}

?>