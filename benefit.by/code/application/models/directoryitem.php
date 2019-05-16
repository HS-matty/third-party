<?php
require_once('categorycontent.php');
class DirectoryItem{


	const TypeItem = 1;
	const TypeHouse = 2;
	const TypeJob = 3;
	static function moveItem($ItemId,$Oldcategory_id,$Newcategory_id){

		global $Db;
		///get item data
		$Data =& self::getItem($ItemId);
		if(!$Data) return false;
		$Db->query("UPDATE category_listing_assc SET category_id = $Newcategory_id WHERE category_id = $Oldcategory_id AND listing_id = $ItemId");

		return $Db->affected_rows();


	}
	static function setExpiredItems(){
		
		global $Db;
		$Db->query('UPDATE listing SET is_expired = 1, is_active = 0  WHERE (TO_DAYS(NOW()) - TO_DAYS(published_date)) >=30 AND is_expired = 0 AND is_closed = 0 ');
		return $Db->affected_rows();
	}

	static function setActiveStatus($ItemId, $Active = 1){

		global $Db;
		$Sql = "UPDATE listing SET is_active = $Active,  published_date = NOW() WHERE listing_id = $ItemId";
		
		$Db->query($Sql);

	}

	static function setCloseStatus($ItemId, $Status = 1){

		global $Db;
		$Db->query("UPDATE listing SET is_closed = $Status WHERE listing_id = $ItemId");

	}
	static function &search($category_id,$Words,$Type,$AdditionalParams = null ,$IncludeSubCats = false,$is_active = false){

		//print_r($WordsArray);

		global $Db,$InOut;

		$What = ' * ';
		$From = ' bluser, listing as di LEFT JOIN geocode  ON (geocode.geocode_id = di.geocode_id), category_listing_assc  dc ';
		$Sql = "dc.listing_id = di.listing_id AND di.is_closed = 0 AND bluser.bluser_id = di.bluser_id AND  ( dc.category_id = $category_id ";
		$Db->DoNotUseListQuery =1 ;
		if($IncludeSubCats){
			$Tree = new DirectoryTree();
			$Cats =& $Tree->getBranch($category_id);


			foreach ($Cats as &$c){
				$Sql .= " OR dc.category_id = $c[category_id]";


			}
		}

		$Sql .= ')';
		$AddSql  ='';
		$Db->DoNotUseListQuery =0 ;
		$FromTable = '';


		if($AdditionalParams)
		foreach ($AdditionalParams as $key=>&$val){



			if($key =='zip' && $val) {


				$ZipArr = split(',',$val);
				if($ZipArr){
					$AddSql .=' AND ( ';

					foreach ($ZipArr as $key => &$zval){
						if($key > 0) $AddSql .= ' OR';
						$AddSql .= ' di.zip =  '.intval($zval);
						if($key > 5) break;
					}
					$AddSql .=') ';


				}else {

					$AddSql .= ' AND di.zip =  '.'\''.intval($val).'\'';
				}
				$InOut->setObligatoryUrlParam('zip',$val);
				continue;
			}


			switch ($Type){


				case self::TypeHouse:
					if(!$FromTable) $FromTable ="housing_listing";

					switch ($key){

						case 'bedrooms':
							if($val){

								$AddSql .= ' AND l2.bedrooms >='.(int) $val;
								$InOut->setObligatoryUrlParam('bedrooms',(int) $val);
							}

							break;

						case 'bathrooms':
							if($val){

								$AddSql .= ' AND l2.bathrooms >='.(int) $val;
								$InOut->setObligatoryUrlParam('bathrooms',(int) $val);
							}

							break;
						case 'price':

							if($val){

								$AddSql .= ' AND di.price <='.(float) $val;
								$InOut->setObligatoryUrlParam('price',(float) $val);
							}

					}


					break;

				case self::TypeJob :
					if(!$FromTable) $FromTable = "job_listing";

					switch ($key){

						case 'type':
							if($val) $AddSql .= ' AND l2.position_type = '.'\''.mysql_real_escape_string($val).'\'';
							$InOut->setObligatoryUrlParam($key,$val);
							break;

					}


					break;

				case self::TypeItem :
					if(!$FromTable) $FromTable  ="item_listing";
					switch ($key){
						case 'price':

							if($val){

								$AddSql .= ' AND di.price <='.(float) $val;
								$InOut->setObligatoryUrlParam('price',(float) $val);
							}

							break;
					}








			}
		}
		if($FromTable){

			$From .= ", $FromTable as l2";
			$AddSql .= " AND l2.listing_id = di.listing_id";


		}







		if($is_active) $AddSql .= ' AND di.is_active = 1';


		$Words = mysql_real_escape_string($Words);
		if($Words) $AddSql .= " AND MATCH (di.short_description,di.long_description,tags) AGAINST ('$Words')" ;
		$First = 0;

		$AddSql .= " AND location_id = ".CURRENT_LOCATION_ID;
		$AddSql .= " ORDER BY di.listing_id desc";
		//echo $Sql.$AddSql;
		$Db->performSelectQuery($What,$From,$Sql.$AddSql);

		//echo $Sql.$AddSql;
		$Data =&  $Db->getQrFetchedRows();
		return $Data;



	}




	static function &getItemsByUserId($UserId,$Flag = null){


		global $Db;
		//	$sql = "SELECT * FROM directory_categories as dc,category_listing_assc, listing LEFT  JOIN directory_membership ON (directory_membership.mid = listing.mid)  LEFT JOIN directory_locations ON (directory_locations.lid = listing.lid) WHERE listing.listing_id = category_listing_assc.listing_id  AND listing.duser_id = $UserId AND dc.category_id = category_listing_assc.category_id";
		$sql = "SELECT listing.*, listing_type.short_description as listing_type FROM  listing,listing_type WHERE listing.listing_type_id = listing_type.listing_type_id AND   listing.bluser_id = $UserId";

		if($Flag)
		switch ($Flag){
			case 'active':
				$sql .= " AND listing.is_active = 1 AND listing.is_closed = 0  AND listing.is_expired = 0";
				break;
			case 'unpublished':
				$sql .= " AND listing.is_active = 0 ";
				break;
			case 'expired':
				$sql .= " AND (listing.is_expired = 1 OR listing.is_closed = 1)";

				break;
			case 'flagged':
				$sql .= " AND listing.flag != 'none' ";
				break;


		}


		$Db->performSelectQueryForList($sql);

		return $Db->getQrFetchedRows();

	}

	static function deleteItem($ItemId,$FuserId = null){

		global $Db;

		if($FuserId) {

			$Db->query("SELECT listing_id FROM listing WHERE bluser_id = $FuserId AND listing_id = $ItemId");
			if(!$Db->rows()) return false;
		}

		$Db->query("DELETE FROM category_listing_assc WHERE listing_id = $ItemId");
		$Db->query("DELETE FROM listing WHERE listing_id = $ItemId");
		return $Db->affected_rows();


	}
	static function &getItemsByUserIdSimple($UserId){

		global $Db;
		$sql = "SELECT * FROM  listing LEFT  JOIN directory_membership ON (directory_membership.mid = listing.mid)   WHERE  listing.fuser_id = $UserId";
		$Db->performSelectQueryForList($sql);
		return $Db->getQrFetchedRows();


	}

	/*	static function &getItems($CategoryId,$is_active = false){


	global $Db;
	$sql = "SELECT * FROM listing LEFT  JOIN directory_membership ON (directory_membership.mid = listing.mid) LEFT JOIN directory_locations ON (directory_locations.lid = listing.lid) WHERE directoty_cat_content.listing_id = listing.listing_id ";
	if($CategoryId) $sql .= " AND category_listing_assc.category_id = $CategoryId";
	if($is_active) $sql .= " AND listing.is_active = 1";

	$Db->performSelectQueryForList($sql);
	return $Db->getQrFetchedRows();

	}*/

	static function &getItemTypes(){
		global $Db;
		$Db->query('SELECT * FROM listing_type');
		return $Db->fetch_all_assoc();
	}
	static function &getItemType($TypeId){
		global $Db;
		$Db->query("SELECT * FROM listing_type WHERE listing_type_id = $TypeId");
		return $Db->fetch_assoc();

	}
	static function flagItem($ItemId,$Flag){
		global $Db;
		$Db->query("UPDATE listing SET flag = '$Flag' WHERE listing_id = $ItemId");
		return $Db->affected_rows();

	}
	static function setApproved($ItemId,$Flag = 1){
		global $Db;
		$Db->query("UPDATE listing SET is_approved = '$Flag' WHERE listing_id = $ItemId");
		return $Db->affected_rows();

	}

	static function &getItems($CategoryId,$is_active = false,$is_expired = 0){


		global $Db;
		$SqlAdd ='';
		//LEFT JOIN directory_locations ON (directory_locations.lid = listing.lid)";
		if($CategoryId){
			$sql = "SELECT * FROM category_listing_assc ,listing
		
		LEFT  JOIN bluser  ON (bluser.bluser_id = listing.bluser_id)";
			$SqlAdd = " WHERE category_listing_assc.category_id = $CategoryId AND listing.listing_id = category_listing_assc.listing_id  ";
		}
		else {
			$sql = "SELECT bluser.*, listing.*,count(category_listing_assc.category_id) as count FROM listing
			LEFT JOIN  category_listing_assc ON (category_listing_assc.listing_id =  listing.listing_id)
			LEFT  JOIN bluser ON (bluser.fuser_id = listing.fuser_id)  

			GROUP BY listing.listing_id";


		}

		/*
		LEFT  JOIN directory_membership ON (directory_membership.mid = listing.mid)
		LEFT JOIN directory_locations ON (directory_locations.lid = listing.lid)
		*/
		if(!$SqlAdd) $SqlAdd .=" WHERE 1";
		if($is_active) {
			
			
			$SqlAdd .= " AND listing.is_active = 1";
		}

		

			$SqlAdd .= " AND listing.is_expired = $is_expired";
			
			
		




		$Db->performSelectQueryForList($sql.$SqlAdd);
		return $Db->getQrFetchedRows();

	}

	static function countItems($UserId,$MembershipId = null){

		global $Db;
		$Sql = "SELECT count(*) FROM listing WHERE duser_id = $UserId";
		if($MembershipId) $Sql .= " AND mid = $MembershipId";
		$Db->query($Sql);
		return $Db->fetch_element();

	}

	static function countItemsByCategoryId($CategoryId){

		global $Db;
		$Sql = "SELECT count(*) FROM listing as i, category_listing_assc as cc WHERE i.listing_id = cc.listing_id AND cc.category_id = $CategoryId AND  location_id = ".CURRENT_LOCATION_ID;;

		$Db->query($Sql);
		return $Db->fetch_element();

	}
	static function addItem($Type,$Data,$SpecificItemData){

		global $Db,$Page;

		$category_id= @$Data['category_id'];
		if(!$category_id) throw new Exception('cannot add new listing, cagegory stage');

		
		if($category_id){
			$Tree = new DirectoryTree();
			$Path = $Tree->getPathArrayToCidString($category_id);
			$Data['category_path_cache'] = $Path;
		}
		unset($Data['category_id']);

		$Data['location_id'] = CURRENT_LOCATION_ID;

		$Data['creation_date'] = 'NOW()';

		if(!$ItemId =  $Db->sqlgen_insert('listing',$Data)) throw new Rad_Db_Exception('Cannot add new listing');


		$SpecificItemData['listing_id'] = $ItemId;


		switch ($Type){

			case self::TypeHouse :
				$Table = 'housing_listing';
				break;
			case self::TypeItem :
				$Table = 'item_listing';
				break;
			case self::TypeJob  :
				$Table = 'job_listing';
				break;

			default:
				throw new Exception('wrong item type');



		}


		$SpecId = $Db->sqlgen_insert($Table,$SpecificItemData);


		if(!$SpecId) throw new Exception('cannot add new listing, stage2');



		if($ItemId && $category_id && $SpecId) {


			if(CategoryContent::addCategoryContentItem($ItemId,$category_id)) return $ItemId;

		}else throw new Exception('Error while adding new listing');

		return false;

	}
	static function getListingType($ItemId){

		global $Db;
		$Db->query("SELECT listing_type_id FROM listing WHERE listing_id = $ItemId ");
		return $Db->fetch_element();

	}
	static function &getItem($ItemId,$UserId = null,$is_active = false, $joinCategory = true,$is_expired = 0){
		global $Db;


		//get type
		$Type = self::getListingType($ItemId);
		//dom_document_loadxml()

		if(!$Type) return false;

		switch ($Type){
			case self::TypeJob :
				$JoinTable = 'job_listing';break;
			case self::TypeItem :
				$JoinTable = 'item_listing';break;
			case self::TypeHouse:
				$JoinTable = 'housing_listing';break;
			default: throw new Exception('Unknown listing type');

		}


		$sql = "SELECT * FROM $JoinTable as jt, listing as i
		LEFT JOIN geocode as l ON (l.geocode_id = i.geocode_id), 
		bluser";

		if($joinCategory) $sql .= ',category_listing_assc as cc';
		$sql .= " WHERE bluser.bluser_id = i.bluser_id AND i.listing_id = $ItemId and jt.listing_id = i.listing_id";
		if($joinCategory) $sql.=" and cc.listing_id = i.listing_id";
		if($UserId) $sql .= " AND i.bluser_id = $UserId";
		if($is_active) $sql .= " AND i.is_active = 1";
		$sql .= " AND i.location_id = ".CURRENT_LOCATION_ID;


		$sql .= " AND i.is_expired = $is_expired";



		$Db->query($sql);

		$Item =& $Db->fetch_assoc();


		//get location tree
		/*$DirTree = new DirectoryTree();
		$Arr =& $DirTree->getPathArrayTocategory_id($Item['category_id']);

		$PathStr = null;
		foreach ($Arr as &$Val){
		if($PathStr) $PathStr .= ' / ';
		$PathStr .= $Val['loc_title'];
		}*/

		//get
		if($Item){
			$Tree = new DirectoryTree();

			$Category = $Tree->getCategoryListByItem($Item['listing_id']);




			//get path
			$Path = $Tree->getPathArrayToCidString($Category[0]['category_id']);
			$Item['path_str'] =$Path;

		}

		return $Item;



	}

	static  function updateItem($Type,$Data,$SpecificListingData = null,$UseUserProtection = true,$ItemData = null){

		$ItemId = (int) $Data['listing_id'];
		$UserId = (int) @$Data['bluser_id'];

		//print_r($Data);
		//die();

		$Data['modified_date'] = 'NOW()';
		if($CategoryId  = (int) $Data['category_id']){
			unset($Data['category_id']);
			//die($ItemData['category_id']);
			CategoryContent::updateCategoryContent($ItemData['category_id'],$ItemId,$CategoryId);

			//get category path for caching
			$Tree = new DirectoryTree();
			$Path = $Tree->getPathArrayToCidString($CategoryId);
			$Data['category_path_cache'] = $Path;
			
		}
		unset($Data['listing_id']);
		if($UserId && $UseUserProtection){

			unset($Data['bluser_id']);
			$SqlAdd = "listing_id = $ItemId AND bluser_id = $UserId";
		}else {
			$SqlAdd = "listing_id = $ItemId";
		}
		global $Db;
		if($Data){

			//get category_cache_path



			$Db->sqlgen_update('listing',$Data,$SqlAdd);
			$MainRows =  $Db->affected_rows();
			$SpecificListingData['listing_id'] = $ItemId;

			switch ($Type){

				case self::TypeHouse :
					$Table = 'housing_listing';
					break;
				case self::TypeItem :
					$Table = 'item_listing';
					break;
				case self::TypeJob  :
					$Table = 'job_listing';
					break;

				default:
					throw new Exception('wrong item type');



			}

			$SpecId = $Db->sqlgen_update($Table,$SpecificListingData,"listing_id = $ItemId");




			if($SpecId && $MainRows) return true;
			return false;

		}else return null;


	}
	static function deleteFromCategory($ItemId,$CategoryId){

		global $Db;
		$Db->query("DELETE FROM category_listing_assc WHERE category_id=$CategoryId && listing_id = $ItemId");
		return $Db->affected_rows();

	}

}

?>