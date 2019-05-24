<?php 


class Logic_Tree_Content extends Tree {

	public $CategoryLinkTable = "category_listing_assc";
	public $ItemsTable = "listing";
	function __construct(){


		//$Tree = new cd
		$this->FieldNames = array( // ����� ����� �������
		'left' => 'cleft',
		'right'=> 'cright',
		'level'=> 'clevel',
		'title'=> 'title',
		);
		$this->IndexTitle = 'node_id';
		$this->TreeTable = 'content_tree';

		/*$Tree = new CDBTreeExt($AltDb,'catalog_categories','cid',$field_names);
		$this->Tree = $Tree;*/
		parent::__construct();

		$this->setParams('short_description');



	}


	public function getCategoryIdByAlias($Alias){
		global $db;
		global $InOut;
		$Alias = mysql_real_escape_string(_escape($Alias));
		$Sql = "SELECT $this->IndexTitle FROM $this->TreeTable WHERE alias = '$Alias'";
		$db->query($Sql);
		return $db->fetch_element();

	}


	public function getCategoryByAlias($alias){
		global $db;
		global $InOut;
		$alias = mysql_real_escape_string(_escape($alias));
		$Sql = "SELECT * FROM $this->TreeTable WHERE alias = '$alias' limit 1";
		$db->query($Sql);
		return $db->fetch_assoc();

	}
	public  function &getCategoryListByItem($ItemId,$IncludeFullPathStr = false,$ShowRoot = false){

		global $db;

		$Sql = "SELECT * FROM $this->CategoryLinkTable as cc,
			$this->TreeTable as dc
			WHERE cc.listing_id = $ItemId AND cc.category_id = dc.category_id";



		$db->query($Sql);
		$Arr =&  $db->fetch_all_assoc();

		if($IncludeFullPathStr){
			//get location tree
			$Tree = new DirectoryTree();

			foreach ($Arr as &$Cat) {

				$CatArr =& $Tree->getPathArrayToCid($Cat['cid'],$ShowRoot);
				$PathStr = null;
				foreach ($CatArr as &$Val){
					if($PathStr) $PathStr .= ' / ';
					$PathStr .= $Val['title'];
				}

				$Cat['PathStr'] = $PathStr;
			}

		}
		return $Arr;



	}

	/*	static function &getCategoryListByUserId($UserId){

	global $db;
	$db->query("SELECT dc.*  FROM $this->CategoryLinkTable as cc,
	$this->CategoryLinkTable as dc,directory_items as di
	WHERE cc.ditem_id = di.ditem_id AND di.duser_id = $UserId AND cc.cid = dc.cid");
	return $db->fetch_all_assoc();

	}

	*/





	static function &search($WordsArray){

		//print_r($WordsArray);
		if(!is_array($WordsArray) || !($WordsArray[0])) return null;
		global $db;
		$Sql = "SELECT * FROM directory_categories WHERE ";
		$First = 1;
		$AddSql  ='';
		foreach ($WordsArray as &$k){
			$len = strlen($k);
			if( $len < 3 || $len > 20) continue;
			$k  = mysql_real_escape_string(trim($k));
			if(!$First) $AddSql .= " OR ";
			$AddSql .= "(title LIKE '%$k%')" ;
			$First = 0;
		}
		if(!$AddSql) return null;
		$db->query($Sql.$AddSql);
		return  $db->fetch_all_assoc();


	}


}






?>