<?php



class BackendController extends Controller {






	public function GetPageObject($Lang,$SideType,$ViewType = 'common'){


		global $InOut;
		global $Modules;
		global $Auth;
		$Sid = 0;

		if(!is_object($Modules)){

			$Modules = new Modules();

		}

		$Data  = array();


		//var_dump($this->Module->grants);


		$Access = 0;
		//var_dump($this->User);
		//var_dump($Auth);

		//check user access for backend module..
		$B = new Modules();
		$B->GetDataByParams('backend','index');
		if(!$BackendMod = $B->GetModule()) die('internal error');
		$BackendAccess = $B->AccessModulePage($this->User,$B->GetModule(),$B->GetObject());
		$Access = $Modules->AccessModulePage($this->User,$this->Module,$this->GetObject());
		//$BackendAccess = 1;
		
		
		
	//	print("<BR>ACCESS = $Access ,BackendAccess = $BackendAccess <br> ");
		
		

		if(( ($Access == 0) || ($BackendAccess ==0) ) && !( (@$this->Object->id == 'login_page') || (@$this->Object->id == 'auth')) ){


			$InOut->RedirectAlias('login');
				
				

			//die('Access Denied');



		}elseif($this->GetModule()->id == 'backend') {

		


				switch ($this->Object->id) {

					case 'index':
						$InOut->InAction;
						//if we want to logout
						if(( string) $InOut->InAction == 'logout'){
							
							$Auth->CloseSession();
							$InOut->RedirectAlias('login');			
						
						}
					
					
					
					// no logic yet. Just show welcome page

					break;


					case 'not_found':

					//todo: not found code here


					break;


					default:

					die('Object not found'); //todo: move to not found page

					break;

					// process login and password
					case 'auth':


					$LoginForm = new Form($Lang);
					$LoginForm->ProceedForm('login_form');

					//if form data not valid, draw login form with ErrorMesages

					if(!empty($LoginForm->i)) {

						$LoginUrl = $InOut->GenerateFullUrl('backend','auth',$Lang);

						$Data['Errors'] = $LoginForm->GetErrorsArray();

						$Data['LoginUrl'] = $LoginUrl;

						$Mod = new Modules();
						$Mod->GetDataByAlias('login',$Lang);
						$this->Module = $Mod->GetModule();
						$this->Object = $Mod->GetObject();

						//		print_r($Data);

					}else {


						$NewAuth = new CAuth();


						$User = $NewAuth->GetUserData($LoginForm->GetField('login'),$LoginForm->GetField('password'));

						if(is_object($User)){


							foreach ($this->Module->grants->read->include->groups->group as $PermitedGroup) {

								if($User->Group == $PermitedGroup){

									if($NewAuth->RegisterSession($User)) die('cannot register session');

									else {
										
										$Params['sid'] = $NewAuth->GetSid();
										$this->RedirectFlag = 1;
										$InOut->RedirectByFullParams($this->Module->id,'index',0,$Params);

									}

								}else{

									die('Access denied!'); //todo

								}


							}//end of foreeach
						}else{ //if user with entered login and password not found

						$LoginUrl = $InOut->GenerateFullUrl('backend','auth',$Lang);

						$Data['Errors'][0]['msg'] = 'Incorect login or password';

						$Data['LoginUrl'] = $LoginUrl;
						$Mod = new Modules();
						$Mod->GetDataByAlias('login',$Lang);
						$this->Module = $Mod->GetModule();
						$this->Object  = $Mod->GetObject();

						}



					}


					break;


					case 'login_page':

					$LoginUrl = $InOut->GenerateFullUrl('backend','auth',$Lang);
					$Data['LoginUrl'] = $LoginUrl;

					break;

				}


				// end if backend module switch
				if($this->RedirectFlag == 0){
				//	echo '<br><strong>Debug HERE</strong><br>';
					if(@is_object($Auth)) $Sid = $Auth->GetSid();
					elseif (@is_object($NewAuth)) $Sid = $NewAuth->GetSid();

					if(empty($Sid)) $Sid = null;


					$Data['Modules'] = $Modules->GetUserAvailableModules($this->User);
					$Data['Objects'] = $Modules->GetUserObjects($this->User,$this->Module);
					
					$Data['Sid'] = $Sid;

					$BackendView = new View($Lang,$SideType,$ViewType);
					echo  $BackendView->GetParsedCode($this->Module->id,$this->Object,$Data);
				}


			}else{


				//todo проверяем и подкючаем ModuleName/modulname.controller.php
				// И запускаем.
				// todo_next: проверка прав на запуска данного модуля.


				$ClassName = $this->Module->id."Controller";
				//echo $ClassName;
				//var_dump($this->Object);
				$Object = new $ClassName($this->Module,$this->Object,$this->User);
				$Object->GetPageObject($Lang,$SideType,$ViewType);
				//lets parse all objects with chosen view

				//check if we need redirect



			}


		

	}
}


?>