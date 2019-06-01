<?php

class App_{$app_name} extends App_Default  {


	/**
	 * kind of description
	 *
	 * @param unknown_type $params
	 */
	public function run($params = null){

		/* @var $page Page */
		/* @var $router $Router */
		
	//	App_Default::run($params);
		$request = Registry::get('request');
		$inout = Registry::get('inout');
		$window = Registry::get('window');

		$workspace = $window->workspace;
		$output = $window->workspace->output;

		$action = (string) $request->action;
		
		$page = Registry::get('page');
		
		switch ($action){


			
			case 'test':
				
				break;
				
				
			case 'index':
			default:
			
				
				//$inout->setRedirectUrl('/app/{$app_name}');

			
				
			break;
			
			


		}
	}






}

?>