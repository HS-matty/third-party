<?php

class App_Auth extends App_Default  {




	public function run($params = null){


		$request = Registry::get('request');;
		$session = Registry::get('session');
		$inout = Registry::get('inout');


		$action = (string) $request->getElement(1);
		switch ($action){




			case 'loginx':

				$user = new Logic_Model_User(array('id'=>2));

				if($user->id){

					$session->setParam('user',serialize($user));
					$session->setParam('user_id',$user->id);

					Registry::get('acl')->addElement($user);
					//		$session->unsetParam('user');
					//		$session->setParam('user',$auth_user);





					Registry::get('session')->save('request',Registry::getParam('request'));
					//$inout->setRedirectUrl('/front');

					$response = 1;
				}else $response  = '-1';
				
				Registry::get('output')->setType('console')->setValue(json_encode($response));


				break;
			case 'login':

				//	$users = new Datasource_Table('auth_users');
				//	$user = $users->getRow(array('id'=>2));

				$user = new Logic_Model_User(array('id'=>2));

				if($user->id){

					$session->setParam('user',serialize($user));
					$session->setParam('user_id',$user->id);

					Registry::get('acl')->addElement($user);
					//		$session->unsetParam('user');
					//		$session->setParam('user',$auth_user);





					Registry::get('session')->save('request',Registry::getParam('request'));
					$inout->setRedirectUrl('/front');

				}

				break;

			case 'logout':
				$session->unsetParam('user_id');
				$session->unsetParam('user');
				$inout->setRedirectUrl('/');

				break;
			case 'index':
			default:




				break;


		}


		//	print_r($user);
		//	exit();
		/*$user = new Element('user');
		$user->id = 666;
		$user->setParam('email','test@user');
		$session->unsetParam('user_id');
		$session->unsetParam('user');
		$inout->setRedirectUrl('/');

		if($user->id){

		$session->setParam('user',serialize($user));
		$session->setParam('user_id',$user->id);

		Registry::get('acl')->addElement($user);
		//		$session->unsetParam('user');
		//		$session->setParam('user',$auth_user);





		Registry::get('session')->save('request',Registry::getParam('request'));
		$inout->setRedirectUrl('/front');

		}*/






		/*	//	$page->addParam('show_old_ui',1);

		$success_flag =  $inout->getParam('success');
		if($success_flag !== NULL){
		$page->addParam('success_flag',(int) $success_flag);
		}

		$class_params = $this->getClassParams();


		global $window;

		$page->addParam('class_params_string',$this->_class_params_string);
		$app_name = $class_params[count($class_params)-1];

		foreach ($class_params as $val){
		$window->title .= $val .' / '	;
		}


		$entity_name = $this->_entity_name;


		$page->addParam('entity_name',$entity_name);

		//parse element-name


		//actions
		$actions = array('add','edit','view');
		if($params){



		if(in_array($params[0],$actions)){


		$action_name = $params[0];
		$request_param = $params[1];
		if($params[2]) $action_param = (int) $params[2];


		}
		}





		if($action_param) $id = $action_param;
		else $id = (int) $inout->getParam('id');


		$page->addParam('id',$id);



		$app = Registry::get('app');
		$workspace = $app->window->workspace;

		$ui = Registry::get('ui');

		$request = Registry::get('request');
		$page = Registry::get('page');
		$request_param = $request->getElement(1);
		//$request_param = $this->_app_params_string;
		switch ($request_param){



		case 'default':
		case 'login':


		$form = UI::loadUiElement('/@ui/app/auth/@form/login',false);


		$form_validator = new Form_Validator();



		$el = $form->getElement('fields');
		//$title =  $el->title;

		//$ru = $title->ru;
		//$d = (string) $d;

		$page->addParam('Form',$form);

		if($inout->isFormPost() && $form_validator->validateForm($form)){


		$data = $form->getData();




		//	if($auth_user->authUser($data['login'],$data['password'])){
		//if($user_auth->auth($data['login'],$data['password'],true)){
		$datasource = Registry::get('datasource');

		//	$user = $datasource->db->_get('/auth_users?login='.$data['login']);
		$user = new Element('user');
		$user->id = 666;
		$user->setParam('email','adforce@user');
		if($user->id){

		$session->setParam('user',serialize($user));
		$session->setParam('user_id',$user->id);

		Registry::get('acl')->addElement($user);
		//		$session->unsetParam('user');
		//		$session->setParam('user',$auth_user);





		Registry::get('session')->save('request',Registry::getParam('request'));
		$inout->setRedirectUrl('/start');



		}else {


		$form->getField('login')->setErrorMessage('wrong login/password combination');
		$form->setErrorFlag(true);


		}



		}else {


		$form->getField('login')->setValue('adforce-user');
		$form->getField('password')->setValue('adforce-password');


		}





		break;



		case 'logout':
		$session->unsetParam('user_id');
		$session->unsetParam('user');
		$inout->setRedirectUrl('/');

		break;







		}*/


	}


}

?>