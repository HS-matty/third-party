<?php 

class DirectoryTree extends Tree {

	public $CategoryLinkTable = "category_listing_assc";
	public $ItemsTable = "listing";
	function __construct(){


		//$Tree = new cd
		$this->FieldNames = array( // ����� ����� �������
		'left' => 'cleft',
		'right'=> 'cright',
		'level'=> 'clevel',
		'title'=> 'short_description',
		);
		$this->IndexTitle = 'category_id';
		$this->TreeTable = 'category';

		/*$Tree = new CDBTreeExt($AltDb,'catalog_categories','cid',$field_names);
		$this->Tree = $Tree;*/
		parent::__construct();

		$this->setParams('short_description');



	}

	
	public function getCategoryIdByAlias($Alias){
		global $Db;
		global $InOut;
		$Alias = mysql_real_escape_string($InOut->_escape($Alias));
		$Sql = "SELECT $this->IndexTitle FROM $this->TreeTable WHERE alias = '$Alias'";
		$Db->query($Sql);
		return $Db->fetch_element();
		
	}
	public  function &getCategoryListByItem($ItemId,$IncludeFullPathStr = false,$ShowRoot = false){

		global $Db;
		
		$Sql = "SELECT * FROM $this->CategoryLinkTable as cc,
			$this->TreeTable as dc
			WHERE cc.listing_id = $ItemId AND cc.category_id = dc.category_id";



		$Db->query($Sql);
		$Arr =&  $Db->fetch_all_assoc();

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

		global $Db;
		$Db->query("SELECT dc.*  FROM $this->CategoryLinkTable as cc,
			$this->CategoryLinkTable as dc,directory_items as di
			WHERE cc.ditem_id = di.ditem_id AND di.duser_id = $UserId AND cc.cid = dc.cid");
		return $Db->fetch_all_assoc();

	}

*/





	static function &search($WordsArray){

		//print_r($WordsArray);
		if(!is_array($WordsArray) || !($WordsArray[0])) return null;
		global $Db;
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
		$Db->query($Sql.$AddSql);
		return  $Db->fetch_all_assoc();


	}


}






?>