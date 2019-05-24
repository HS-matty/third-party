<?php

class App_Dashboard extends App_Default  {


	public function run($params = null){


		$request = Registry::get('request');
		$inout = Registry::get('inout');
		$window = Registry::get('window');

		$workspace = $window->workspace;
		$output = $window->workspace->output;

		$action = (string) $request->getElement(1);
		switch ($action){


			case 'index':
			default:
			

				
				
			break;
			
			


		}
	}






}

?>