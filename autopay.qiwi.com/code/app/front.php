<?php

class App_Front extends App_Default  {


	function run($params = null){


		$request = Registry::get('request');
		$inout = Registry::get('inout');
		$window = Registry::get('window');

		$workspace = $window->workspace;
		$output = $window->workspace->output;

		$action = (string) $request->getElement(1);
		switch ($action){


			case 'index':
				
				
			default:


				$inout->template_index = 'front.tpl';


				break;




		}
	}






}

?>