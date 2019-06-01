<?php


class  App_{$app_name} extends App_Default {

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
		$inout = Registry::get('inout');
		$window = Registry::get('window');

		$workspace = $window->workspace;
		$output = $window->workspace->output;

		$page = Registry::get('page');


		$action = (string) (strtolower($request->getLastElement()));

	
		switch ($action){

			default:
			case 'index':
				
				
			
				$form = new App_Market_Offer_Ui_Form();
				$form->setActionType($action);

				$current_url = new Link();
				$current_url->setLinkParams(array('app','Market','Offer'));

				$back_url = new Link();
				$back_url->setLinkParams(array('app','Market','Offer','List'));

				$form->addParam('current_url',$current_url);
				$form->addParam('back_url',(string) $back_url);
				//echo $link;
				

				if($inout->getParam('post')){

					$form->onLoad();
					$form->onSubmit();



				}else $form->onLoad();

				$workspace->addElement($form);


				break;




		}
	}



}











?>