<?php
class Rad_Tree_Node implements iRad_Form,iRad_Object_Properties{
	public $Data;

	public $NodeId;

	public $Id;

	protected  $ParamsXml;
	public function getFormData(){
		if($this->ParamsXml = $this->Data['params_xml']) {
			unset($this->Data['params_xml']);
		}
		return $this->Data;
	}
	public function parseAdditionalFields(&$Data,$FieldsXml){
		if($FieldsXml) $Data['params_xml'] = $FieldsXml;

	}

	public function updateFormObject($Data){
		$tree = new DirectoryTree();
		return $tree->updateCategoryData($Data);

	}
	public function init($NodeId){
		$Tree = new DirectoryTree();
		if($this->Data = $Tree->getCategory($NodeId)){
			$this->NodeId = $this->Data['category_id'];
			return true;
		}
		return false;
	}
	public function initByAlias($Alias){
		$Tree = new DirectoryTree();
		$NodeId = $Tree->getCategoryIdByAlias($Alias);
		$this->NodeId = $NodeId;
		if($NodeId && $this->Data = $Tree->getCategory($NodeId)) return true;
		return false;
	}
	public function initByData($Data){
		if(!$this->NodeId = $Data['category_id']) return false;
		$this->Data = $Data;
		return true;

	}
	public function insertFormObject($Data){

 		$cid = $this->NodeId;

		$tree = new DirectoryTree();
		return $tree->insertCategory($cid,$Data);


	}

	public function getNodeObjects(){
		
		$Objects  = array();
		$tree = new DirectoryTree();
		$Path = $tree->getPathArrayToCid($this->NodeId);
	
		
		
		
		
	}
	public static function getNodeIdByItemId($ItemId){
		global $Db;
		$Sql = "SELECT ca.category_id from category_listing_assc ca,category c,listing l
		WHERE ca.category_id = c.category_id AND ca.listing_id = l.listing_id AND l.listing_id = $ItemId LIMIT 1";
		$Db->query($Sql);
		return  $Db->fetch_element();
		
	}
	public function insertRecord(Rad_Directory_Record $Item){


		CategoryContent::addCategoryContentItem($Item->getItemId(),$this->NodeId);

		//get category path for caching
		$Tree = new DirectoryTree();
		$Path = $Tree->getPathArrayToCidString($this->NodeId);

		$Item->UpdateItemCategoryCache($Item->getItemId(),$Path);

	}
	public function getId(){
		return $this->Data['category_id'];
	}
	public function getChildNodes($ReturnAsArray = false, $isActive  = false){
		$Tree = new DirectoryTree();
		$Nodes = array();
		$Cats =& $Tree->getCategories($this->NodeId,null,null,$isActive);
		if($ReturnAsArray) return $Cats;
		if($Cats){
			foreach ($Cats as &$c) {
				$Node = new Rad_Page_Node();
				if($Node->initByData($c)) $Nodes[] = $Node;

			}
		}
		return $Nodes;
	}
	public function getItems($Item = null ,$records_number = 10,$params = null){
		if(!$Item) $Item = new Rad_Directory_Record();
		$_p = array('cid'=>$this->NodeId,'limit'=>$records_number,'order'=>'creation_date');
		if($params) $_p = array_merge($params,$_p);
		
		return $Item->getItemsSimpleExt($_p);
	}
	public function getObjectProperties(){
		return $this->Data['params_xml'];

	}
	public function parseObjectProperties(){


	}



}
class Rad_Page_Node extends Rad_Tree_Node implements iRad_Page_Item  {
	public function getTitle(){
		return $this->Data['short_description'];

	}
	public function getBody(){
		return $this->Data['body'];

	}
	public function getType(){
		return $this->Data['node_type'];
	}



}
class Rad_File_Node extends Rad_Tree_Node {
	
	public function getChildNodes(){
		
		$arr = array();
		$arr[0]['short_description'] = 'node1';
		$arr[0]['category_id'] = -$this->NodeId;
		$arr[1]['short_description'] = 'node2';
		$arr[1]['category_id'] = -$this->NodeId;
		$arr[2]['short_description'] = 'node3';
		$arr[2]['category_id'] = -$this->NodeId;
		return $arr;
		
	}
	public function getItems($Item = null ,$records_number = 10,$params = null){
		$arr = array();
		$arr[0]['short_description'] = 'item1';
		$arr[1]['short_description'] = 'item2';
		$arr[2]['short_description'] = 'item3';
		return $arr;
		
	}
	public function init($NodeId){
		$this->NodeId = $NodeId;
	}
	
}
interface iRad_Object_Properties{
	public function getObjectProperties();
}


?>