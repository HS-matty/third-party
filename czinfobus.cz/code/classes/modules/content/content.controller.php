<?php
require_once('article.logic.php');


class ContentController extends Controller {

	var $SelfModuleName = 'content';

	public  function GetPageObject($Lang,$SideType,$ViewType = 'common'){


		global $InOut;
		global $Auth;
		global $NewAuth;
		global $Modules;


		switch ($this->Object->id) {


			case 'add_article':
			//if(!($ArticleId = (int)$this->Object->param)) $InOut->RedirectByFullParams($this->Module->id,'article_list');
			$Article = new ArticleLogic($Lang);

			if($InOut->pvar('post') ==1){

				$Form = new Form($Lang);
				$Form->ProceedForm('edit_article');
				$Errors = $Form->GetErrorsArray();
				if(empty($Errors)){


					if( !($ArticleLang = $InOut->pvar('articlelang'))) $ArticleLang = 'ru';
					else{
						switch ($ArticleLang) {
							default:
							case 1:
							$ArticleLang='ru';


							break;
							case 2:
							$ArticleLang='cz';


							break;
							case 3:
							$ArticleLang='ua';


							break;



						}
					}

					$Id = $Article->InsertArticle($Form->GetField('article_header'),$Form->GetField('article_descr'),$Form->GetField('article_meta'),$Form->GetField('article_body'),2,$ArticleLang);
					$InOut->RedirectByFullParams($this->Module->id,'article',$Id);

				}else{
					$Data['Post'] = $Form->GetPostArray();
					$Data['Errors'] = $Errors;

				}
			}



			break;

			case 'edit_article':

			if(!($ArticleId = (int)$this->Object->param)) $InOut->RedirectByFullParams($this->Module->id,'article_list');

			$Article = new ArticleLogic($Lang);
			if($InOut->pvar('post') ==1){
				$Form = new Form($Lang);
				$Form->ProceedForm('edit_article');
				$Errors = $Form->GetErrorsArray();
				if(empty($Errors)){

					$Article->UpdateArticle($ArticleId,$Form->GetField('article_header'),$Form->GetField('article_descr'),$Form->GetField('article_meta'),$Form->GetField('article_body'));
					$InOut->RedirectByFullParams($this->Module->id,'article',$ArticleId);

				}else{
					$Data['Errors'] = $Errors;

				}
			}

			//echo $this->Object->param;
			$Data['Article'] = $Article->GetArticleData($ArticleId);

			break;
			case 'article':

			if($this->Object->param){

				$Article = new ArticleLogic($Lang);
				//echo $this->Object->param;
				$Data = $Article->GetArticleData($this->Object->param);
				if(empty($Data)) $Data['IsEmptyArticle'] = 1;
			}else{

				$Data['IsEmptyArticle'] = 1;

			}




			//echo  '<br> '.$this->Object->name.' is running <br>';
			//echo  'param = '.$this->Object->param;


			break;


			case 'article_list':
			
			if($InOut->gvar('action') == 'del'){
			
				if(($ArticleId = (int)$this->Object->param)) {
					
					$Article = new ArticleLogic($Lang);
					$Article->DeleteArticle($ArticleId);
				
				}
				
				$InOut->RedirectByFullParams($this->Module->id,'article_list');
			}

			
			$Data['Cats'] = Categories::GetContentCategories($Lang);
			//var_dump($Data['Cats']);

			if( !($CatId = (int) $InOut->pvar('param'))) $CatId = 0;
			$Data['param'] = $CatId;

			if( !($ArticleLang = $InOut->pvar('articlelang'))) $ArticleLang = 'ru';
			else{
				switch ($ArticleLang) {
					default:
					case 1:
					$ArticleLang='ru';
					$Data['articlelang'] = 1;

					break;
					case 2:
					$ArticleLang='cz';
					$Data['articlelang'] = 2;

					break;
					case 3:
					$ArticleLang='ua';
					$Data['articlelang'] = 3;

					break;



				}

			}


			$ArticleList = new ArticleLogic($ArticleLang);

			$Data['ArticleList'] = $ArticleList->GetArticleList($CatId,30);


			if(empty($Data)) 	$Data['IsEmptyArticle'] = 1;






			break;

			case 'delete_article':

			$Allowed = 0;
			$Owner = 0;

			$Article = new ArticleLogic($Lang);
			if(!$Param = (int) $this->Object->param){

				$InOut->RedirectByFullParams($this->Module->id,'article_list',0);
				exit();

			}


			$AuthorData = $Article->GetArticleAuthorAndGroup($Param);
			if(!$AuthorData) die('internal error!');
			foreach ($this->Object->grants->read->include->users->user as $User) {
				if(trim($User) == 'owner') $Owner = 1;
				if(trim($User) == $AuthorData['user_name']) $Allowed = 1;


			}


			if(($Owner == 1) && $this->User->UserId == $AuthorData['user_id']) $Allowed = 1;

			print('allowed : '.$Allowed);
			if($Allowed) {
				$Article->DeleteArticle($Param);
				echo 'deleted';

			}
			$InOut->RedirectByFullParams($this->Module->id,'article_list',0);
			exit;



			default:


			break;



		}

		if($this->RedirectFlag == 0){

			if(@is_object($Auth)) $Sid = $Auth->GetSid();
			elseif (@is_object($NewAuth)) $Sid = $NewAuth->GetSid();

			if(empty($Sid)) $Sid = null;


			$Data['Modules'] = $Modules->GetUserAvailableModules($this->User);
			$Data['Objects'] = $Modules->GetUserObjects($this->User,$this->Module);
			//var_dump($Data['Objects']);
			$Data['Sid'] = $Sid;

			$BackendView = new View($Lang,$SideType,$ViewType);
			echo  $BackendView->GetParsedCode($this->Module->id,$this->Object,$Data);
		}


	}



}

?>