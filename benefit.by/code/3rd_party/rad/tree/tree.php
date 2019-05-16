<?php

/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit radmaster.net

*/
require_once('phpdb/dbtree.php');
require_once('phpdb/database.php');
require_once('rad_tree_node.php');




abstract class Tree{

	/**
	 * real tree
	 *
	 * @var CDBTreeExt
	 */
	protected  $Tree;
	protected $FieldNames;
	protected $IndexTitle;
	protected   $TreeTable;
	public function setParams($ParamTitle){
		$this->Tree->setParams($ParamTitle);
	}
	function __construct(){

		/*
		must  be set in child class

		$this->FieldNames = array( //
		'left' => 'cleft',
		'right'=> 'cright',
		'level'=> 'clevel',
		);
		$this->IndexTitle = 'cid';
		$this->TreeTable = 'catalog_categories';
		parent::__construct();
		*/

		global $Db;
		$AltDb = new CDatabase($Db->link);

		//$Tree = new cd

		$Tree = new CDBTreeExt($AltDb,$this->TreeTable,$this->IndexTitle,$this->FieldNames);

		$this->Tree = $Tree;




	}
	public   function createRootRecord(){
		/*@var Tree CDBTreeExt*/
		$this->Tree->clear();

	}
	public function getCategories($ParentId,$Limit = null,$OrderBy = null,$IsActive = false){

		global $Db;
		$Tree = $this->Tree;

		$params = array();
		if($IsActive) $params['is_active']  = 1;
		$Tree->enumChildren($ParentId,1,1,$Limit,$OrderBy,$params);

		$Data =& $Db->getQrFetchedRows();
		//print_r($Data);


		return $Data;

	}

	public function getParentCategory($Id){
		/*@var $Tree CDBTreeExt*/
		global $Db;
		$Tree = $this->Tree;
		return $Tree->getParent($Id);



	}
	public function insertCategory($ParentId,$Data){

		/*@var $Tree CDBTreeExt*/
		global $Db;
		$Tree = $this->Tree;
		return $Tree->insert($ParentId,$Data);


	}

	public function &getCategory($Id){

		/*@var $Tree CDBTreeExt*/
		global $Db;
		$Tree =& $this->Tree;
		$Node =& $Tree->getNodeInfoExt($Id);
		return $Node;


	}
	public function getCategoryId_Oodle($CategoryTitle){

		global $Db;
		$CategoryTitle = mysql_real_escape_string(trim($CategoryTitle));
		//	echo $CategoryTitle;
		$Db->query("SELECT {$this->IndexTitle} FROM {$this->TreeTable} WHERE oodle_path = '$CategoryTitle' ");
		return $Db->fetch_element();
	}

	public function deleteCategory($Id){

		/*@var $Tree CDBTreeExt*/
		$Tree = $this->Tree;







		if($Tree->ifCategoryExists($Id) && !$Tree->enumChildren($Id)) return $Tree->delete($Id);



	}

	public function getPathArrayToCid($Id,$showRoot = 0){

		/*@var $Tree CDBTreeExt*/

		$Tree = $this->Tree;

		return $Tree->enumPathExt($Id,$showRoot);


	}

	public function getPathArrayToCidString($Id,$showRoot = 0){


		$Path = '';
		$PathArray = $this->getPathArrayToCid($Id,$showRoot);
		if($PathArray){


			foreach ($PathArray as $key=>&$i){
				if($key) $Path .=' > ';

				$Path .= $i[$this->FieldNames['title']];



			}


		}
		return $Path;


	}
	public function &getBranch($Cid,$AsTree = false){


		$Data =&  $this->Tree->enumChildrenAll($Cid);
		if($AsTree) return $this->Tree->transformArrayToTree($Data);
		return $Data;



	}
	public function &getTreeArray(){




		return $this->Tree->getTreeArray();


	}
	public function &getConvertedTreeArray($AsArray = false){
		return  $this->Tree->getConvertedTreeArray($AsArray);

	}


	public function &getCategoryArray($Id){

		global $Db;

		$Sql = "SELECT * FROM $this->TreeTable WHERE $this->IndexTitle = $Id";
		$Db->query($Sql);
		return $Db->fetch_assoc();

	}
	public function updateCategoryData($Data){


		$Id = (int) $Data[$this->IndexTitle];
		unset($Data[$this->IndexTitle]);
		global $Db;


		//check for additional fields


		$Db->sqlgen_update($this->TreeTable,$Data,"$this->IndexTitle = $Id");
		return  $Db->affected_rows();

	}






}

?>