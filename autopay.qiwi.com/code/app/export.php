<?php

class App_Export extends App_Default  {





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

		switch ($this->_app_params_string){

			
				case 'download':


				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
				header("Content-Transfer-Encoding: binary;\n");
				header("Content-Disposition: attachment; filename=\"report.csv\";\n");
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header("Content-Description: File Transfer");
				//$file = '/tmp/export-file.csv';
				$file = $session->getParam('export_file');
				//$file = 'z:'.$file;
				header("Content-Length: ".filesize($file).";\n");

				readfile($file);
				exit();
				break;


			case 'download':


				
				$session->getParam(unserialize('export_query'));
				$union_query = new RadUnionQuery();



				$sql = $union_query->getSqlString();
				$db->query($sql);
				//echo $sql;
				//exit();


				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);
				header("Content-Transfer-Encoding: binary;\n");
				header("Content-Disposition: attachment; filename=\"report.csv\";\n");
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header("Content-Description: File Transfer");
				//$file = '/tmp/export-file.csv';
				$file = $session->getParam('export_file');
				//$file = 'z:'.$file;
				header("Content-Length: ".filesize($file).";\n");

				readfile($file);


				//$window->workspace->output->addElement('sql')->setValue($sql)->setTitle('sql');

		}








	}



	public function onInit(){

		Registry::get('log')->addMessage('helloy from '. get_class($this));

	}








}

?>