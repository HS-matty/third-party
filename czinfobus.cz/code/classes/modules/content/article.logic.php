<?php



class ArticleLogic extends Logic  {








	function &GetArticleData($ArticleId){


		global $Db;
		$ArticleData['ErrorLevel'] = 0;
		//$GLOBALS[Log]->DoLogging("Class: CArticle, Method: GetArticelData()");

		//$Article =& new ArticleRecord();
		//$Article->ArticleIntro = 'test';

		$Sql = "SELECT a.article_id, a.article_header, a.article_meta, a.article_descr, a.article_body,
		DATE_FORMAT(a.article_timedate, '%d.%m.%y, %H.%i') AS article_timedate, s.user_name  FROM content_articles as a, auth_users as s WHERE article_id = $ArticleId 
		AND a.user_id = s.user_id LIMIT 1";

		$Db->query($Sql);

		if($Db->affected_rows()) {

			$ArticleData = $Db->fetch_array();


		}else{
			
			$ArticleData = null;

		}



		return $ArticleData;

	}
	
	
	function &GetArticleAuthorAndGroup($ArticleId){
	
		global $Db;
		 $Sql = "SELECT u.user_id,u.user_name,u.group_id,g.group_name FROM 
		content_articles as a,auth_users as u,auth_groups as g 
		WHERE a.article_id = '$ArticleId'
		AND a.user_id = u.user_id
		AND u.group_id = g.group_id
		";
		$Db->query($Sql);
		if($Db->rows()){
			
			return  $Db->fetch_array();
				
		
		}
		return null;
			
	}
	
	
	
	function DeleteArticle($ArticleId){

		global $Db;
		$Sql = "DELETE FROM content_articles WHERE article_id = $ArticleId AND cat_id != 1";
		$Db->query($Sql);
		if($Db->affected_rows()) return 1;
		return 0;


	}
	function InsertArticle($Header,$Descr,$Meta, $Body,$Cat_id,$Lang){
		global $Db, $Auth;
		$UserId = $Auth->GetUserId();
		if($UserId){
			
			$Sql = "INSERT INTO content_articles (article_header,article_descr,article_meta,article_body,cat_id,user_id,article_lang)
		VALUES ('$Header','$Descr','$Meta','$Body',$Cat_id, $UserId,'$Lang')";
		
			//echo $Sql;
			$Db->query($Sql);

			if($Db->affected_rows()) return  $Db->get_insert_id();
		}
		return 0;

	}
	function UpdateArticle($ArticleId,$Header,$Descr,$Meta, $Body){
		global $Db;
		
		$Sql = "UPDATE content_articles SET article_header = '$Header',article_descr = '$Descr',
		article_meta = '$Meta',article_body ='$Body' WHERE article_id = $ArticleId";
		//	echo $Sql;
		$Db->query($Sql);

		if($Db->affected_rows()) return 1;
		return 0;

	}

	function GetArticleIdByCatId($CatId,$Lang){

		global $Db;
		$Db->query("SELECT article_id FROM articles_$Lang WHERE cat_id = $CatId  ORDER BY article_id DESC LIMIT 1");

		if($Db->rows()) {
			$arr = $Db->fetch_array();
			return $arr[0];
		}
		return 0;



	}
	function GetCatIdByCatName($CatName){
		
		global $Db;
		$Sql = "SELECT cat_id FROM categories_$this->Lang WHERE cat_name='$CatName'";
		$Db->query($Sql);
		if ($Db->rows()) {
			$arr = $Db->fetch_array();
			return $arr['cat_id'];
		}
		return 0;
	
	}

	function &GetArticleList($CatId,$Limit = 0 ){

		//if($this->Lang == 'ru') $ReturnArray['ArticleList'] = '1, 2, 3';
		//else $ReturnArray['ArticleList'] = 'article1,article2,article3';
		global $Db;
		global $Auth;
		$UserId = $Auth->GetUserId();

		$Sql = "SELECT a.article_id, a.article_header,a.article_descr,DATE_FORMAT(a.article_timedate, '%d.%m.%y, %H.%i') AS article_timedate,s.user_name FROM content_articles AS a, auth_users AS s
		WHERE a.user_id = s.user_id 
		AND a.article_lang = '$this->Lang'";
		
		if($CatId) $Sql .= " AND cat_id = $CatId";
		$Sql .= " ORDER BY article_id DESC";
		if( (int) $Limit) $Sql .= " LIMIT $Limit";
		


		$Db->query($Sql);
		if(@$Db->rows()) $ReturnArray = $Db->fetch_all_array();
		else {

			//		$ReturnArray['ErrorLevel'] = NO_RECORDS_FOUND;

		}

		//	print_r($ReturnArray);

		return $ReturnArray;

	}


}

?>