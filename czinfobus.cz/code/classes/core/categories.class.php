<?php

class Categories{

	private $XmlFile = './data/categories.xml';
	
	function __construct(){
	
	
	}
	function GetCategoryContentByName($CatName){
		
		$xml = simplexml_load_file($this->XmlFile);	
	
		$dd = $xml->content->news;
//		var_dump($dd);
				
	
	}
	public function &GetContentCategories(){
		global  $Db;
		$Sql = "SELECT * FROM content_categories ";
		$Db->query($Sql);
		if($Db->rows()) return $Db->fetch_all_array();
		return 0;
		
	}
	
	
}



?>