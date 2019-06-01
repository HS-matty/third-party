<?php

class  App_Market_Offer_List extends App_Default {

	/**
	 * kind of description
	 *
	 * @param unknown_type $params
	 */
	public function run($params = null){

		/* @var $page Page */
		/* @var $router Router */

		/* @var $workspace Ui_Group */

		//	App_Default::run($params);
		$request = Registry::get('request');
		//$session = Registry::get('');
		$inout = Registry::get('inout');
		$window = Registry::get('window');

		$workspace = $window->workspace;
		$output = $window->workspace->output;

		$action = (string) $request->action;

		$page = Registry::get('page');

		switch ($action){

			
			case 'index':
			default:

		

				$grid = new App_Market_Offer_Ui_Grid();
				
				$grid->onLoad();
			
				
				$link = new Link();
				$link->setLinkParams(array('app','Market','Offer','View'));
		
				
				$grid->setParam('row_url',$link);
		
				$workspace->addElement($grid);

		
		



				break;




		}
	}



}











?>