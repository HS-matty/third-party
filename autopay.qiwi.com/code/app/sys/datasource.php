<?php


class App_Sys_Datasource extends App_Default  {





	function run($params = null){



		Registry::get('output')->setType('text');

		$request = Registry::get('request');

		switch ($this->_app_params_string){



			default:


				require_once(PATH_ROOT.'/logic/datasource/adforce/category.php');
				$inout = Registry::get('inout');
				//if($datasource_name = $inout->getParam('datasource')){


				$id = (int) $inout->getParam('id');
				if($id){
					//$datasource_name = 'adforce_categories';
					$datasource = new Logic_Datasource_Adforce_Category($datasource_name);
					
					$data = $datasource->setFields(array('adforce_categories.id','adforce_categories.ad_group'))->fetchData(array('campaign_id'=>$id))->getData();

					$json_string = json_encode($data);
				}else $json_string = 'error: id missing';

				Registry::get('output')->setType('console')->setValue($json_string);

				break;



		}

	}



	public function onInit(){

		Registry::get('log')->addMessage('helloy from '. get_class($this));

	}








}

?>