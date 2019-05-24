<?php


class App_Sys_Grid extends App_Default  {





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

		Registry::get('output')->setType('text');
		$request = Registry::get('request');
		
		switch ($this->_app_params_string){
			
			case 'update':
					
					$ui = Registry::get('ui');
					$grid = $ui->loadUiElement('/@ui/app/adforce/stats/@grid/report',false);
					foreach ($grid->getFields() as $field){

						$param = $request->getParam($field->getName());
						$field->setParam('is_enabled',(int) $param);							
							
						
					}
					
					UI::save($grid);
					
					
			//		file_put_contents('z:/1.txt',$a);
					//echo 'helloy';
					//exit();
				
				break;
			
		}

	}



	public function onInit(){

		Registry::get('log')->addMessage('helloy from '. get_class($this));

	}

	
	





}

?>