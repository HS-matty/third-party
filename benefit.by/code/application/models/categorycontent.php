<?php

	class CategoryContent{
		
		
		static function addCategoryContentItem($ItemId,$CategoryId){
			
			global $Db;
			
			$Sql = "INSERT INTO category_listing_assc  (listing_id,category_id) VALUES($ItemId,$CategoryId)";
		
			$Db->query($Sql);
			return $Db->affected_rows();
			
			
		}
		static function &getCategoryContentItem($Cid,$ItemId){
		
			global $Db;	
			$Db->query("SELECT * FROM category_listing_assc WHERE category_id = $Cid AND listing_id = $ItemId");
			
			return $Db->fetch_assoc();
		
		}
		static function &getCategoriesByItemId($ItemId){
		
			global $Db;	
			$Db->query("SELECT category_id FROM category_listing_assc WHERE  listing_id = $ItemId");
			
			return $Db->fetch_all_assoc();
		
		}
		static function updateCategoryContent($Cid,$ItemId,$NewCid){
			global $Db;
			$Db->query("UPDATE category_listing_assc SET category_id = $NewCid WHERE category_id = $Cid AND listing_id = $ItemId");
			return $Db->affected_rows();
		}

		
	}

?>