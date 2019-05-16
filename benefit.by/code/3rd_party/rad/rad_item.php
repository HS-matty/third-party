<?php
abstract class Rad_Item implements iRad_Page_Item {

	public $Data;
	protected $PrimaryTable_Name;
	protected $PrimaryTable_PrimaryKeyName;

	protected $JoinTable_Name;
	protected $JoinTable_PrimaryKeyName;
	protected $ListingType;
	protected $ItemTypeData;
	protected $UseSecondaryTable = true;


	/**
	 * Item Owner
	 *
	 * @var RegisteredUser
	 */
	public $User;


	public function getData(){
		return $this->Data;
	}

	protected function getItemTypeId(){
		return $this->ItemTypeData['listing_type_id'];
	}
	public function getXmlAdditionalFields(){

		global $Db;
		
		$Db->query("SELECT additional_xmlfields FROM listing_type WHERE listing_type_id = {$this->getItemTypeId()}");
		return $Db->fetch_element();

	}
	protected function setSecondaryTableParams($TableName,$PrimaryKeyName){
		$this->JoinTable_Name = $TableName;
		$this->JoinTable_PrimaryKeyName = $PrimaryKeyName;

	}
	public function init($ItemId){

	}

	public function isInitSuccess(){

		if($this->Data && $this->User) return true;
		return false;
	}

	protected function getUserId(){
		return $this->Data['bluser_id'];
	}

	public  function getItemId(){

		return $this->Data[$this->PrimaryTable_PrimaryKeyName];
	}


}




class Rad_Directory_Record extends Rad_Item   implements iRad_Form  {


	protected $PrimaryTable_Name = 'listing';
	protected $PrimaryTable_PrimaryKeyName = 'listing_id';
	protected $PrimaryTableDbFields = array();
	protected $TypeAlias = 'unset';

	public $isExpired;
	public $isClosed;
	public $isPublished;

	protected $_params = array();


	/**
	 * Secondary table fields set in the child classes
	 *
	 * @var array
	 */
	protected $DbFields;

	/**
	 * Form for creating search query
	 *
	 * @var Rad_Form
	 */
	protected $Form;

	public function setParam($ParamName,$Value){
		$this->_params[$ParamName]= $Value;
	}
	public function getParam($ParamName){
		return $this->_params[$ParamName];
	}

	public function setForm(Rad_Form $Form){
		$this->Form = $Form;
	}
	protected  function initItemTypeData(){

		global $Db;
		$Db->query("SELECT * FROM listing_type WHERE alias = '{$this->TypeAlias}'");
		$this->ItemTypeData = $Db->fetch_assoc();
	}
	function __construct($Params = null){
		$this->initItemTypeData();
		$this->initDbFields($this->PrimaryTable_Name,$this->PrimaryTableDbFields);
		//set item type

	}
	public function getFormData(){
		return $this->Data;
	}
	public function updateFormObject($Data){
		$this->updateItem($Data);

	}
	public function parseAdditionalFields(&$Data,$FieldsXml){
		if($FieldsXml) $Data['params_xml'] = $FieldsXml;

	}
	public function getTitle(){
		return $this->Data['short_description'];
	}
	public function getBody(){
		return $this->Data['long_description'];
	}
	public function getType(){
		return 'static_page';
	}
	public function getTypeId(){
		return $this->ItemTypeData['listing_type_id'];
	}
	protected function initDbFields($Table,&$dbfields_ref){

		global $Db;
		$Db->query("describe $Table");

		$Count = count($arr = $Db->fetch_all_array());




		for ($i=2;$i<=$Count;$i++){
			if( $arr[$i]['Field']) $dbfields_ref[] = $arr[$i]['Field'];
		}
		//	print_r($dbfields_ref);
		//	print_r($arr);
		//print_r($this->DbFields);




	}
	/**
	 * Get field table name
	 *
	 * @param string na $FieldTitle
	 * @param bool $CheckKeys Include primary and secondary keys in the search result
	 * @return string|bool
	 * 
	 */
	protected function getFieldTable($FieldName,$CheckKeys = false){

		foreach ($this->PrimaryTableDbFields as $f){
			if($CheckKeys && ($f == $this->PrimaryTable_Name || $f == $this->JoinTable_PrimaryKeyName)) continue;
			if($FieldName == $f) return $this->PrimaryTable_Name;
		}
		foreach ($this->DbFields as $f){
			if($CheckKeys && ($f == $this->PrimaryTable_Name || $f == $this->JoinTable_PrimaryKeyName)) continue;
			if($FieldName == $f) return $this->JoinTable_Name;
		}
		return null;
	}
	static  function addItem($Data,Rad_Directory_Item $Obj){

		$ItemType = $Data['listing_type_id'];



		/*	switch ($ItemType){

		case self::TypeHouse : $Obj = new Barefoot_House();break;
		case self::TypeItem : $Obj = new Barefoot_Item();break;
		case self::TypeJob : $Obj = new Barefoot_Job();break;
		case self::TypeArticle  : $Obj = new Article_Item();break;
		case self::TypeDeposit : $Obj = new Deposit_Item();break;
		case self::TypeCredit  : $Obj = new credit_Item();break;
		default:


		break;
		}*/





		if(!$Data['bluser_id']) $Data['bluser_id'] = 1;

		global $Config,$Db;
		/*	$Lib = $Config->SitePath.'/3rd_party/googlemapapi/googlemapapi.class.php';
		require_once($Lib);


		$map = new GoogleMapAPI('map');


		// setup database for geocode caching
		$map->dsn = $Db;
		$map->_db_cache_table = 'geocode';
		// enter YOUR Google Map Key
		$map->setAPIKey(GMAP_KEY);
		$AddressStr = $Data['address'].', '.$Data['city'].', '.$Data['state'];
		if($Data['longitude'] && $Data['latitude']){


		//	die('ddd');
		$Geocode =& $map->getGeocodeByCoords($Data['longitude'],$Data['latitude'],$AddressStr);







		}else {


		$Geocode =& $map->getGeocode($AddressStr);





		}
		if(@$Geocode) $GeocodeId = $Geocode['geocode_id'];
		else $GeocodeId = 0;

		$Data['geocode_id'] = $GeocodeId;*/
		$Data['location_id'] = 1;

		unset($Data['latitude']);
		unset($Data['longitude']);
		if($Data['share_email'])	{
			$Data['share_email'] = 0;
		}else $Data['share_email'] = 1;


		if($Data['share_phone'])	{
			$Data['share_phone'] = 0;
		}else $Data['share_phone'] = 1;




		return $Obj->insertItem($Data);


	}
	protected function insertItem($Data){


		$Data['creation_date'] = 'NOW()';

		if($CategoryId  = (int) $Data['category_id']){

			unset($Data['category_id']);
		}

		$Data['listing_type_id'] = $this->getItemTypeId();


		global $Db;
		//get secondary table data and remove it from main table data
		//		$SecondaryTableData = $this->splitUpdateData($Data);




		if($Data){


			$SecondaryTableData = $this->splitUpdateData($Data);






			// update primary table data



			$Id = $Db->sqlgen_insert('listing',$Data,$SqlAdd);

			if($Id) $this->setItemId($Id);

			if($CategoryId && $Id && false){

				//die($ItemData['category_id']);
				CategoryContent::addCategoryContentItem($Id,$CategoryId);


				//get category path for caching
				$Tree = new DirectoryTree();
				$Path = $Tree->getPathArrayToCidString($CategoryId);

				$this->UpdateItemCategoryCache($Id,$Path);


			}
			//add secondary table


			if($SecondaryTableData && $this->UseSecondaryTable){
				$SecondaryTableData[$this->PrimaryTable_PrimaryKeyName] = $Id;


				$SpecId = $Db->sqlgen_insert($this->JoinTable_Name,$SecondaryTableData);


			}



			if(($SpecId && $this->UseSecondaryTable) || ($Id && !$this->UseSecondaryTable)) return $Id;

			return false;

		}else return null;

	}
	public  function UpdateItemCategoryCache($Id,$CacheStr){

		global $Db;
		$Db->sqlgen_update($this->PrimaryTable_Name,array('category_path_cache'=>$CacheStr),"$this->PrimaryTable_PrimaryKeyName = $Id");
	}
	public function insertFormObject($Data){

		return $this->insertItem($Data);

	}
	/**
	 * Split array passed from form  into the main
	 * table data and secondary table data
	 * @param array $Data reference to array with data
	 * @return array Secondary table array
	 */
	protected function splitUpdateData(&$Data){

		$SecondaryTableData = array();
		foreach ($Data as $key=>&$val){
			if(in_array($key,$this->DbFields)){
				$SecondaryTableData[$key] = $val;
				unset($Data[$key]);

			}

		}

		return $SecondaryTableData;
	}
	public   function updateItem($Data){



		$Data['modified_date'] = 'NOW()';

		if($CategoryId  = (int) $Data['category_id']){
			unset($Data['category_id']);
			//die($ItemData['category_id']);
			CategoryContent::updateCategoryContent($this->Data['category_id'],$this->getItemId(),$CategoryId);

			//get category path for caching
			$Tree = new DirectoryTree();
			$Path = $Tree->getPathArrayToCidString($CategoryId);
			$Data['category_path_cache'] = $Path;

		}

		unset($Data['listing_id']);

		global $Db;
		//get secondary table data and remove it from main table data
		$SecondaryTableData = $this->splitUpdateData($Data);


		if($Data){




			// update primary table data

			$SqlAdd = "$this->PrimaryTable_PrimaryKeyName = {$this->getItemId()}";
			$Db->sqlgen_update('listing',$Data,$SqlAdd);
			$MainRows =  $Db->affected_rows();

			//update secondary table

			if($SecondaryTableData){
				$SecondaryTableData[$this->PrimaryTable_PrimaryKeyName] = $this->getItemId();



				$SpecId = $Db->sqlgen_update($this->JoinTable_Name,$SecondaryTableData,"$this->PrimaryTable_PrimaryKeyName = {$this->getItemId()} ");

			}



			if($SpecId && $MainRows) return true;

			return false;

		}else return null;


	}

	static function checkItemTypeByCategory($CategoryId){
		global $Db;
		$Tree= new DirectoryTree();
		$Path = $Tree->getPathArrayToCid($CategoryId,0);

		$RootNode = $Path[0]['category_id'];
		$Node = $Tree->getCategory($RootNode);

		switch ($Node['category_id']){

			case 89: $Type  = self::TypeHouse ;break;
			case 90: $Type  = self::TypeItem  ;break;
			case 91: $Type  = self::TypeJob  ;break;
			default:$Type = null;


		}
		return $Type;


	}
	public function coutItems($UserFieldName,$UserId){

		global $Db;
		$Db->query("select count(*) FROM $this->PrimaryTable_Name WHERE $UserFieldName = $UserId");
		return $Db->get_element();

	}
	public function init($ItemId,RegisteredUser $User =null,array $params = null){

		if(!$ItemId) $ItemId = $this->getItemId();
		/*	$ItemType = $this->getListingType($ItemId);
		if(!$ItemType) return false;
		$this->ItemType = $ItemType;*/
		if($User){
			$this->User = $User;
		}

		$this->getItem($ItemId);


		if(!$this->Data) return false;
		//get user

		if(!$this->User) {
			$User = new RegisteredUser();
			$User->authUserById($this->getUserId());
			$this->User = $User;

		}

		if($this->Data['is_active']) $this->isPublished = true;
		else $this->isPublished = false;

		if($this->Data['is_closed']) $this->isClosed = true;
		else $this->isClosed = false;

		if($this->Data['is_expired']) $this->isExpired= true;
		else $this->isExpired = false;




	}

	/**
	 * Return item object
	 *
	 * @param int $Type
	 * @return Rad_Directory_Record
	 */
	static function getInstanceByType(array $TypeArr){



		if($ClassName = $TypeArr['class_name']) $Item  = new $ClassName();
		else  $Item = new Custom_Item();
		return $Item;


	}

	/**
	 * Return item by id
	 *
	 * @param int $Type
	 * @return Rad_Directory_Record
	 */
	static function getInstanceById($ItemId){

		$Listing = new Rad_Directory_Record();
		$typeArr = $Listing->getListingTypeArray($ItemId);


		return self::getInstanceByType($typeArr);
	}

	protected function getListingTypeArray($ListingId){

		global $Db;
		$Db->query("SELECT * FROM listing_type t, listing l WHERE l.listing_type_id = t.listing_type_id AND l.listing_id = $ListingId ");
		return $Db->fetch_assoc();

	}
	protected  function &getItem($ItemId,$UserId = null,$is_active = false, $joinCategory = true,$is_expired = 0){
		global $Db;







		$Query = new RadSelectQuery();

		$Query->addWhat('*');

		$Query->addFrom($this->PrimaryTable_Name." LEFT JOIN geocode  ON (geocode.geocode_id = {$this->PrimaryTable_Name}.geocode_id) ");


		if($this->UseSecondaryTable) $Query->addFrom($this->JoinTable_Name);
		/*	$sql = "SELECT * FROM $JoinTable as jt, listing as i
		LEFT JOIN geocode as l ON (l.geocode_id = i.geocode_id),
		bluser";*/

		$Where = $Query->addWhereGroup('AND');

		if($this->UseSecondaryTable) $Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);

		if($joinCategory){
			$Query->addFrom('category_listing_assc');
			$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,'category_listing_assc',$this->PrimaryTable_PrimaryKeyName);

		}
		$Where->add($this->PrimaryTable_PrimaryKeyName,$ItemId,$this->PrimaryTable_Name);
		//	if($joinCategory) $sql.=" and cc.listing_id = i.listing_id";

		if($this->User) $UserId = $this->User->getUserId();

		if($UserId) {
			$Where->add('bluser_id',$UserId,$this->PrimaryTable_Name);

		}
		if($is_active){

			$Where->add('is_active',1,$this->PrimaryTable_Name);
		}
		//	$Where->add('location_id',CURRENT_LOCATION_ID,$this->PrimaryTable_Name);
		//	$Where->add('is_expired', $is_expired,$this->PrimaryTable_Name);




		//	echo $Query->getSqlString();
		//	die();


		$Db->query($Query->getSqlString());



		@$this->Data  =& $Db->fetch_assoc();






	}

	protected   function getListingType($ItemId){

		global $Db;

		if($this->ItemType) return $this->ItemType;
		$Db->query("SELECT listing_type_id FROM $this->PrimaryTable_Name WHERE $this->PrimaryTable_PrimaryKeyName = $ItemId ");

		return $this->ItemType = $Db->fetch_element();


	}

	public function setExpiredItems(){

		global $Db;
		$Db->query("UPDATE $this->PrimaryTable_Name SET is_expired = 1  WHERE (TO_DAYS(NOW())+31 - TO_DAYS(published_date)) >=30 AND is_expired = 0 AND is_closed = 0 ");
		return $Db->affected_rows();
	}

	public function publish(){

		return $this->setActiveStatus(1);

	}
	protected function setItemId($Id){
		$this->Data[$this->PrimaryTable_PrimaryKeyName] = $Id;
	}
	protected    function setActiveStatus($ActiveFlag = 1){

		global $Db;


		if($this->isPublished || $this->isClosed || $this->isExpired) return false;

		$Sql = "UPDATE $this->PrimaryTable_Name SET is_active = $ActiveFlag,  published_date = NOW() WHERE $this->PrimaryTable_PrimaryKeyName = {$this->getItemId()}";

		$Db->query($Sql);
		return $Db->affected_rows();

	}

	public function close(){
		return $this->setCloseStatus(1);
	}


	protected   function setCloseStatus($Status = 1){

		global $Db;
		$Db->query("UPDATE $this->PrimaryTable_Name SET is_closed = $Status WHERE $this->PrimaryTable_PrimaryKeyName = {$this->getItemId()} AND bluser_id = {$this->User->getUserId()}");

	}



	public function deleteItems(RegisteredUser $User){

		//get all user items
		$this->User = $User;
		$Keys  =& $this->getItemKeys($User->getUserId());

		//if user has items
		if($Keys) foreach ($Keys as $val){

			$Item  = self::getInstanceById($val[$this->PrimaryTable_PrimaryKeyName]);
			$Item->init($val[$this->PrimaryTable_PrimaryKeyName]);

			$Item->deleteItem();


		}
		return count($Keys);


	}
	protected function &getItemKeys($UserId){
		global $Db;
		$Db->query("SELECT $this->PrimaryTable_PrimaryKeyName FROM $this->PrimaryTable_Name WHERE bluser_id = $UserId");
		return $Db->fetch_all_assoc();
	}
	public  function deleteItem(){

		global $Db,$Config;

		//		if(!$UserId =  $this->User->getUserId()) return false;
		$Db->query("DELETE FROM $this->PrimaryTable_Name WHERE $this->PrimaryTable_PrimaryKeyName = {$this->getItemId()}");//AND bluser_id = $UserId");
		$Rows = $Db->affected_rows();

		if($Rows) {
			//delete pictures and thumbs
			if(@$this->Data['image1']){

				unlink($Config->SitePath.'/images/cat_items/'.$this->Data['image1']);
				unlink($Config->SitePath.'/images/cat_items/thumbs/'.$this->Data['image1']);

			}
			if(@$this->Data['image2']){

				unlink($Config->SitePath.'/images/cat_items/'.$this->Data['image2']);
				unlink($Config->SitePath.'/images/cat_items/thumbs/'.$this->Data['image2']);

			}
			if(@$this->Data['image3']){

				unlink($Config->SitePath.'/images/cat_items/'.$this->Data['image3']);
				unlink($Config->SitePath.'/images/cat_items/thumbs/'.$this->Data['image3']);

			}
			if(@$this->Data['image4']){

				unlink($Config->SitePath.'/images/cat_items/'.$this->Data['image4']);
				unlink($Config->SitePath.'/images/cat_items/thumbs/'.$this->Data['image4']);

			}



			$Db->query("DELETE FROM category_listing_assc WHERE $this->PrimaryTable_PrimaryKeyName = {$this->getItemId()}");

		}
		else return false;
		return $Db->affected_rows();


	}

	public static  function addItemType($Params){
		global $Db;
		return $Db->sqlgen_insert('listing_type',$Params);
	}




	/**
	 * Search corresponding params
	 *
	 * @param int $category_id Category Id
	 * @param array $Words Full text search string
	 * @param int $Type 
	 * @param array $AdditionalParams
	 * @param bool $IncludeSubCats include child categories
	 * @param  bool $is_active
	 * @param  bool $join_users
	 * @return array Result rows
	 */
	public function &search($category_id,$Words,$Type = null,$AdditionalParams = null ,$IncludeSubCats = false,$is_active = false,$join_users = false){

		//print_r($WordsArray);

		global $Db,$InOut;


		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom($this->PrimaryTable_Name." LEFT JOIN geocode  ON (geocode.geocode_id = {$this->PrimaryTable_Name}.geocode_id)");
		//	$Query->addFrom('bluser');//LEFT JOIN geocode  ON (geocode.geocode_id = di.geocode_id)

		$Query->addFrom('category_listing_assc');
		$Where = $Query->addWhereGroup('AND');
		if($join_users){

			$Query->addFrom('bluser');
			$Where->addJoin($this->PrimaryTable_Name,'bluser_id','bluser','bluser_id');

		}


		$Where->addJoin('category_listing_assc',$this->PrimaryTable_PrimaryKeyName,$this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName);
		$Where->add('is_closed',0,$this->PrimaryTable_Name);

		//add categories search

		$CategoriesWhere = $Query->addWhereGroup('AND');

		$CategoriesWhere->setDefaultOperator('OR');

		$CategoriesWhere->add('category_id',$category_id,'category_listing_assc');

		//$Sql = "dc.listing_id = di.listing_id AND di.is_closed = 0 AND bluser.bluser_id = di.bluser_id AND  ( dc.category_id = $category_id ";
		$Db->DoNotUseListQuery =1 ;



		if($IncludeSubCats){
			$Tree = new DirectoryTree();
			$Cats =& $Tree->getBranch($category_id);


			foreach ($Cats as &$c){
				//$Sql .= " OR dc.category_id = $c[category_id]";
				$CategoriesWhere->add('category_id',$c['category_id'],'category_listing_assc');


			}
		}

		/*		$Sql .= ')';
		$AddSql  ='';*/
		$Db->DoNotUseListQuery =0 ;
		//	$FromTable = '';



		if($AdditionalParams['short_description']){
			$Value = mysql_real_escape_string($AdditionalParams['short_descriprion']);
			$InOut->setObligatoryUrlParam('short_description',$Value);

		}



		if($this->getParam('is_advert')){
			$Where->add('is_advert',1,$this->PrimaryTable_Name);
		}



		$this->parseSecondaryTableParams($AdditionalParams,$Query);


		//add search params
		/*		if($FetchParams = $this->getParam('FetchParams')){

		foreach ($FetchParams as $param=>$Value){
		if(!$Table = $this->getFieldTable($param)) continue;


		}

		}*/










		if($is_active) 	$Where->add('is_active',1,$this->PrimaryTable_Name);




		$Words = mysql_real_escape_string($Words);
		if($Words) {

			//$AddSql .= " AND MATCH (di.short_description,di.long_description,tags) AGAINST ('$Words')" ;
			$Where->addSearchFullText(array('short_description','long_description','tags'),$Words,$this->PrimaryTable_Name);
		}
		//$Where->add('location_id',CURRENT_LOCATION_ID,$this->PrimaryTable_Name);
		//$AddSql .= " AND location_id = ".CURRENT_LOCATION_ID;
		$Query->addOrder('listing_id',$this->PrimaryTable_Name,'DESC');

		//$AddSql .= " ORDER BY di.listing_id desc";
		//echo $Sql.$AddSql;
		//$Db->performSelectQuery($What,$From,$Sql.$AddSql);



		$Db->perfromSelectQueryExt($Query);



		return   $Query->QueryResult->Data;




	}

	public function searchBanking($category_id,$Type,Rad_Form $Form){
		global $Db,$InOut;


		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom($this->PrimaryTable_Name);
		//	$Query->addFrom('bluser');//LEFT JOIN geocode  ON (geocode.geocode_id = di.geocode_id)

		$Query->addFrom('category_listing_assc');
		$Where = $Query->addWhereGroup('AND');


		$Query->addFrom('bluser');
		$Where->addJoin($this->PrimaryTable_Name,'bluser_id','bluser','bluser_id');




		$Where->addJoin('category_listing_assc',$this->PrimaryTable_PrimaryKeyName,$this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName);
		$Where->add('is_closed',0,$this->PrimaryTable_Name);

		//add categories search

		$CategoriesWhere = $Query->addWhereGroup('AND');

		$CategoriesWhere->setDefaultOperator('OR');

		$CategoriesWhere->add('category_id',$category_id,'category_listing_assc');

		//$Sql = "dc.listing_id = di.listing_id AND di.is_closed = 0 AND bluser.bluser_id = di.bluser_id AND  ( dc.category_id = $category_id ";
		$Db->DoNotUseListQuery =1 ;



		if($IncludeSubCats){
			$Tree = new DirectoryTree();
			$Cats =& $Tree->getBranch($category_id);


			foreach ($Cats as &$c){
				//$Sql .= " OR dc.category_id = $c[category_id]";
				$CategoriesWhere->add('category_id',$c['category_id'],'category_listing_assc');


			}
		}

		/*		$Sql .= ')';
		$AddSql  ='';*/
		$Db->DoNotUseListQuery =0 ;
		//	$FromTable = '';




		if($AdditionalParams['short_description']){
			$Value = mysql_real_escape_string($AdditionalParams['short_descriprion']);
			$InOut->setObligatoryUrlParam('short_description',$Value);

		}



		if($this->getParam('is_advert')){
			$Where->add('is_advert',1,$this->PrimaryTable_Name);
		}


		$ParamsWhere = $Query->addWhereGroup('and','params');



		$OrderFields = array();
		$VaryFields = array();

		foreach ($Form->getFields() as $f){

			/*@var $f Rad_Form_Field*/
			if($f->Params->is_desired == 1){

				$VaryFields[] = $f->ID;
			}


			if($f->Params->is_sorted == 1){
				if($f->Params->priority) $OrderFields[(int) $f->Params->priority] = $f->ID;
				else $OrderFields[] = $f->ID;
			}

			if(array_search($f->ID,$this->DbFields)){

				$Table = $this->getFieldTable($f->ID);
				$ParamsWhere->add($f->ID,$f->getValue(),$Table);

			}


		}


		//add search params
		/*		if($FetchParams = $this->getParam('FetchParams')){

		foreach ($FetchParams as $param=>$Value){
		if(!$Table = $this->getFieldTable($param)) continue;


		}

		}*/










		if($is_active) 	$Where->add('is_active',1,$this->PrimaryTable_Name);




		if($OrderFields){
			foreach ($OrderFields as $ord) {
				if(!$dir= $Form->getField('order')->Params->sort_direction) $dir = 'desc';

				$Query->addOrder($ord,$this->getFieldTable($ord),$dir);

			}
		}
		else	$Query->addOrder('listing_id',$this->PrimaryTable_Name,'DESC');



		$this->parseSecondaryTableParams($_POST,$Query);
		$Db->perfromSelectQueryExt($Query);
		$VaryResult = array();
		//echo $Query->getSqlString();
		if(!$Query->QueryResult->FetchedRowsNum){


			//nothing found, lets vary
			foreach ($VaryFields as $vary){

				$f = $Form->getField($vary);
				if(!$steps = (int) $f->Params->vary_step_num) $steps = 1;
				if(!$vary_direction = $f->Params->vary_direction) $vary_direction = 'down';
				if(!$step =  (int) $f->Params->vary_step) continue;
				$ParamsWhere = $Query->addWhereGroup('and','params');

				$_POST[$f->ID.'_vary'] = $_POST[$f->ID] - $step;
				$this->parseSecondaryTableParams($_POST,$Query);

				
			
				$Db->perfromSelectQueryExt($Query);



				if($Query->QueryResult->FetchedRowsNum){
					$VaryResult['field_title'] = $f->Title;
					$VaryResult['vary_direction'] = $vary_direction;
					$VaryResult['points'] = $step;
					
				}
			}

		//	echo $Query->getSqlString();


	
			return   array(null,$VaryResult);
		}


		//	echo $Query->getSqlString();

		return   array($Query->QueryResult->Data,$VaryResult);




	}
	public function isFlagged(){

		if($this->Data['flag'] != 'none') return true;
		return false;
	}

	public function isApproved(){
		return  $this->Data['is_approved'] ;

	}

	public  function flagItem($Flag){
		global $Db;
		$Db->query("UPDATE listing SET flag = '$Flag' WHERE listing_id = {$this->getItemId()}");
		return $Db->affected_rows();

	}




	public  function setApproved($Flag = 1){
		global $Db;
		$Db->query("UPDATE listing SET is_approved = '$Flag' WHERE listing_id = {$this->getItemId()}");
		return $Db->affected_rows();

	}
	public function &getItemsStats($UserId){

		$Stats = array();
		global $Db;
		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name WHERE bluser_id = $UserId");
		$Stats['total'] = $Db->fetch_element();
		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name WHERE bluser_id = $UserId AND is_active  = 1");
		$Stats['is_active'] = $Db->fetch_element();

		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name WHERE bluser_id = $UserId AND is_closed  = 1");
		$Stats['is_closed'] = $Db->fetch_element();
		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name WHERE bluser_id = $UserId AND is_expired  = 1");
		$Stats['is_expired'] = $Db->fetch_element();
		return $Stats;

	}
	public function getTotalItemsStats(){



		$Stats = array();
		global $Db;
		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name");
		$Stats['total'] = $Db->fetch_element();
		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name WHERE  is_active  = 1");
		$Stats['is_active'] = $Db->fetch_element();

		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name WHERE  is_closed  = 1");
		$Stats['is_closed'] = $Db->fetch_element();
		$Db->query("SELECT count(*) FROM $this->PrimaryTable_Name WHERE  is_expired  = 1");
		$Stats['is_expired'] = $Db->fetch_element();
		return $Stats;





	}

	/**
	 * Getting list of item's categories 
	 *
	 * @param int $ItemId
	 * @return array $Categories
	 */
	static public function getCategoryIdByItemId($ItemId){

		return CategoryContent::getCategoriesByItemId($ItemId);



	}

	public function getItemsSimpleExt($Params = null){
		$Query =& $this->getItemsSimple($Params);
		return $Query->Data;
		//$Items_
		/*		if($Items){

		}*/
	}
	/**
	 * Get items without joins secondary tables
	 *
	 * @return Rad_Db_Query_Result
	 */
	public  function getItemsSimple($Params = null){

		$Query = new RadSelectQuery();
		$Query->addFrom('listing');
		$Query->addWhat('*');
		global $Db;
		$Where = $Query->addWhereGroup();

		//$Params['cid'] = 1;

		if($Cid = (int) $Params['cid']){


			$Query->addFrom('category_listing_assc');
			$Where->addJoin('category_listing_assc',$this->PrimaryTable_PrimaryKeyName,$this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName);
			$Where->add('category_id',$Cid,'category_listing_assc');

		}
		if($Params['use_item_type']){
			$Where->add('listing_type_id',$this->getTypeId(),$this->PrimaryTable_Name);
		}
		if($UserId = (int)  $Params['user_id']){

			$Where->add('bluser_id',$UserId,$this->PrimaryTable_Name);

		}
		if($Email = $Params['email']){

			$Query->addFrom('bluser');
			$Where->addJoin('bluser','bluser_id',$this->PrimaryTable_Name,'bluser_id');
			$Where->add('email',$Email,'bluser','=','',true);


		}
		if($UserId = $Params['user_id']){

			$Query->addFrom('bluser');
			$Where->addJoin('bluser','bluser_id',$this->PrimaryTable_Name,'bluser_id');
			$Where->add('bluser_id',$UserId,'bluser','=','',true);


		}
		if($Params['join_secondary_table']){

			$this->parseSecondaryTableParams($Params,$Query);


		}
		if($Flag = $Params['flag']){

			$Where->add('flag',$Flag,$this->PrimaryTable_Name,'=','',true);

		}
		if($Limit = (int) $Params['limit']){
			$Limit = $Query->addLimit($Limit);
		}

		if($Order = $Params['order']){
			$Query->addOrder($Order,null,'desc');
		}
	//	die($Query->getSqlString());
		$Db->perfromSelectQueryExt($Query);
		return $Query->QueryResult;

	}
	/**
	 * Get items list by its keys
	 *
	 * @param array $Keys
	 * @param Rad_Query_Params $Params
	 * @return Rad_Db_Query_Result
	 */
	public   function getItemsByKeys($Keys, Rad_Query_Params $Params = null){


		global $Db;
		if(!$Keys) return  null;
		//get items sorted by type;
		//	$Db->query("SELECT listing_type_id FROM listing ORDER BY ")
		/*	$SelectQuery = new RadSelectQuery();
		$SelectQuery->addWhat('listing_type_id');
		$SelectQuery->addFrom('listing');
		$SelectWhere = $SelectQuery->addWhereGroup();
		*/
		//$Keys = array('1','2','3');
		//$Union = new RadUnionQuery();

		$Query = new RadSelectQuery();
		$Query->addFrom($this->PrimaryTable_Name);
		$Query->addFrom('bluser');
		$Query->addWhat('*');
		$Join = $Query->addWhereGroup();
		$Where = $Query->addWhereGroup('and');
		$Join->addJoin($this->PrimaryTable_Name,'bluser_id','bluser','bluser_id');


		foreach ($Keys as $k){
			$Where->setDefaultOperator('OR');
			$Where->add($this->PrimaryTable_PrimaryKeyName,$k,$this->PrimaryTable_Name);
		}

		if($Params) $Union->setQueryParams($Params);
		/*$HouseSelect = $Union->addSelect();
		$ItemSelect = $Union->addSelect();
		$JobSelect = $Union->addSelect();
		$House = new Barefoot_House();
		$Item = new Barefoot_Item();
		$Job = new Barefoot_Job();
		$House->addParamsToSelectQueryForUnion($HouseSelect,$Keys);
		$Item->addParamsToSelectQueryForUnion($ItemSelect,$Keys);
		$Job->addParamsToSelectQueryForUnion($JobSelect,$Keys);*/

		global $Db;

		//		die($Query->getSqlString());
		$Db->perfromSelectQueryExt($Query);


		return $Query->QueryResult->Data;




		return $Array;
	}

	public  function &getItemsByUserId($UserId,$Flag = null){

		$Query = new RadSelectQuery();

		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('short_description as listing_type ','listing_type');
		$Query->addWhat('alias','listing_type');
		$Query->addFrom('listing');
		$Query->addFrom('listing_type');
		$Where = $Query->addWhereGroup();
		$Where->addJoin($this->PrimaryTable_Name,'listing_type_id','listing_type','listing_type_id');
		$Where->add('bluser_id',$UserId,$this->PrimaryTable_Name);


		/*		$sql = "SELECT listing.*, listing_type.short_description as listing_type
		FROM  listing,listing_type WHERE listing.listing_type_id = listing_type.listing_type_id AND   listing.bluser_id = $UserId";*/


		if($Flag)
		switch ($Flag){
			case 'active':
				//	$sql .= " AND listing.is_active = 1 AND listing.is_closed = 0  AND listing.is_expired = 0";
				$Where->add('is_active',1,$this->PrimaryTable_Name);
				$Where->add('is_closed',0,$this->PrimaryTable_Name);
				$Where->add('is_expired',0,$this->PrimaryTable_Name);
				break;
			case 'unpublished':
				$Where->add('is_active',0,$this->PrimaryTable_Name);
				break;
			case 'expired':
				//$sql .= " AND (listing.is_expired = 1 OR listing.is_closed = 1)";

				$WhereGr = $Query->addWhereGroup('AND');
				$WhereGr->setDefaultOperator('OR');;
				$WhereGr->add('is_expired',1,$this->PrimaryTable_Name);
				$WhereGr->add('is_closed',1,$this->PrimaryTable_Name);


				break;
			case 'flagged':
				//	$sql .= " AND listing.flag != 'none' ";
				$Where->add('flag','none',$this->PrimaryTable_Name,'!=');


				break;


		}

		global $Db;

		$Query->addOrder('creation_date',$this->PrimaryTable_Name,'DESC');
		//	die($Query->getSqlString());
		$Db->perfromSelectQueryExt($Query);


		return $Query->QueryResult->Data;

	}

	protected  function parseSecondaryTableParams($Params,RadDbQuery_WhereGroup $WhereGroup){
		throw new Zend_Exception('must be overloaded');
	}


}

class House_Item extends Rad_Directory_Record  {



	protected $DbFields = array('bedrooms','bathrooms','square_footage','image1','image2','image3','image4');
	function __construct($Params = null){
		$this->TypeAlias = 'housing';
		$this->setSecondaryTableParams('housing_listing','housting_listing_id');
	}


	public  function addParamsToSelectQueryForUnion(RadSelectQuery $Query,$Params){
		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('bedrooms as param1');
		$Query->addWhat('bathrooms  as param2');
		$Query->addWhat('square_footage  as param3');
		$Query->addWhat('geocode.*');



		$Query->addFrom($this->PrimaryTable_Name .' left join geocode on (geocode.geocode_id ='.$this->PrimaryTable_Name.'.geocode_id )');

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('and');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);
		if($Params){
			$ParamsWhere = $Query->addWhereGroup('AND');
			$ParamsWhere->setDefaultOperator('OR');
			foreach ($Params as $id){
				$ParamsWhere->add($this->PrimaryTable_PrimaryKeyName,$id,$this->PrimaryTable_Name);

			}

		}


	}

	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;

		$Query->addFrom($this->JoinTable_Name);

		$Where = $Query->addWhereGroup('AND');

		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);

		if($Params)
		foreach ($Params as $key=>&$val){


			switch ($key){

				case 'bedrooms':
					if($val){

						//	$AddSql .= ' AND l2.bedrooms >='.(int) $val;
						$Where->add('bedrooms',(int) $val,$this->JoinTable_Name);
						$InOut->setObligatoryUrlParam('bedrooms',(int) $val);
					}

					break;

				case 'bathrooms':
					if($val){

						//	$AddSql .= ' AND l2.bathrooms >='.(int) $val;
						$Where->add('bathrooms',(int) $val,$this->JoinTable_Name);
						$InOut->setObligatoryUrlParam('bathrooms',(int) $val);
					}

					break;
				case 'price':

					if($val){

						//$AddSql .= ' AND di.price <='.(float) $val;
						$Where->add('price',(float) $val,$this->PrimaryTable_Name,'<=');
						$InOut->setObligatoryUrlParam('price',(float) $val);
					}

			}




		}
	}




}


class Goods_Item extends Rad_Directory_Record {



	protected $Oodle_Integration_Fields = array(


	);
	protected $DbFields = array('image1','image2','image3','image4');

	function __construct($Params = null){
		$this->TypeAlias = 'items';

		$this->setSecondaryTableParams('item_listing','item_listing_id');
		parent::__construct($Params);
	}
	public  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('AND');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
		$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);

		if($Params)

		foreach ($Params as $key=>&$val){


			switch ($key){


				case 'price':

					if($val){

						$Where->add('price',(float) $val,$this->PrimaryTable_Name,'<=');
						$InOut->setObligatoryUrlParam('price',(float) $val);
					}

					break;



			}




		}
	}
	protected function addParamsToSelectQueryForUnion(RadSelectQuery $Query,$Params){
		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('null as param1');
		$Query->addWhat('null  as param2');
		$Query->addWhat('null  as param3');


		$Query->addWhat('geocode.*');
		$Query->addFrom($this->PrimaryTable_Name .' left join geocode on (geocode.geocode_id ='.$this->PrimaryTable_Name.'.geocode_id )');

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('and');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);
		if($Params){
			$ParamsWhere = $Query->addWhereGroup('AND');
			$ParamsWhere->setDefaultOperator('OR');
			foreach ($Params as $id){
				$ParamsWhere->add($this->PrimaryTable_PrimaryKeyName,$id,$this->PrimaryTable_Name);

			}

		}


	}
}
class Job_Item extends Rad_Directory_Record {


	protected $DbFields = array('company_name','compensation','compensation_type','position_type','application_instructions','image1','image2','image3','image4');
	function __construct($Params = null){
		$this->TypeAlias = 'jobs';

		$this->setSecondaryTableParams('job_listing','job_listing_id');
		self::__construct($Params);
	}


	protected function addParamsToSelectQueryForUnion(RadSelectQuery $Query,$Params){
		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('company_name  as param1');
		$Query->addWhat('compensation  as param2');
		$Query->addWhat('compensation_type  as param3');

		$Query->addWhat('geocode.*');
		$Query->addFrom($this->PrimaryTable_Name .' left join geocode on (geocode.geocode_id ='.$this->PrimaryTable_Name.'.geocode_id )');

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('and');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);
		if($Params){
			$ParamsWhere = $Query->addWhereGroup('AND');
			$ParamsWhere->setDefaultOperator('OR');

			foreach ($Params as $id){
				$ParamsWhere->add($this->PrimaryTable_PrimaryKeyName,$id,$this->PrimaryTable_Name);

			}
		}



	}
	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('AND');

		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
		$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);

		if($Params)
		foreach ($Params as $key=>&$val){


			switch ($key){


				case 'type':
					$val = mysql_real_escape_string($val);
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('position_type',$val,$this->JoinTable_Name);
					$InOut->setObligatoryUrlParam($key,$val);
					break;



			}




		}
	}



}

class Article_Item extends Rad_Directory_Record {

	protected $DbFields = array('article_text');
	function __construct($Params = null){
		$this->UseSecondaryTable = false;
		$this->TypeAlias = 'articles';
		$this->setSecondaryTableParams('article_listing','article_listing_id');
		parent::__construct($Params);
	}


	protected function addParamsToSelectQueryForUnion(RadSelectQuery $Query,$Params){
		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('company_name  as param1');
		$Query->addWhat('compensation  as param2');
		$Query->addWhat('compensation_type  as param3');

		$Query->addWhat('geocode.*');
		$Query->addFrom($this->PrimaryTable_Name .' left join geocode on (geocode.geocode_id ='.$this->PrimaryTable_Name.'.geocode_id )');

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('and');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);
		if($Params){
			$ParamsWhere = $Query->addWhereGroup('AND');
			$ParamsWhere->setDefaultOperator('OR');

			foreach ($Params as $id){
				$ParamsWhere->add($this->PrimaryTable_PrimaryKeyName,$id,$this->PrimaryTable_Name);

			}
		}



	}
	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('AND');

		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
		$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);


		if($Params)
		foreach ($Params as $key=>&$val){


			switch ($key){


				case 'type':
					$val = mysql_real_escape_string($val);
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('position_type',$val,$this->JoinTable_Name);
					$InOut->setObligatoryUrlParam($key,$val);
					break;



			}




		}
	}


}

class Deposit_Item extends Rad_Directory_Record {

	public $FormName = 'credit_item';

	protected $DbFields = array('rate','sum','term','currency_id','purpose_id');
	function __construct($Params = null){
		$this->UseSecondaryTable = true;
		$this->TypeAlias = 'deposit';
		$this->setSecondaryTableParams('deposit_listing','deposit_listing_id');
		parent::__construct($Params);
	}


	protected function addParamsToSelectQueryForUnion(RadSelectQuery $Query,$Params){

		return false;
		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('company_name  as param1');
		$Query->addWhat('compensation  as param2');
		$Query->addWhat('compensation_type  as param3');

		$Query->addWhat('geocode.*');
		$Query->addFrom($this->PrimaryTable_Name .' left join geocode on (geocode.geocode_id ='.$this->PrimaryTable_Name.'.geocode_id )');

		$Query->addFrom($this->JoinTable_Name);

		$Where = $Query->addWhereGroup('and');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);

		$Query->addFrom('banking_currencies');
		$Where->addJoin('banking_currencies','currency_id',$this->JoinTable_Name,'currency_id');

		if($Params){
			$ParamsWhere = $Query->addWhereGroup('AND');
			$ParamsWhere->setDefaultOperator('OR');

			foreach ($Params as $id){
				$ParamsWhere->add($this->PrimaryTable_PrimaryKeyName,$id,$this->PrimaryTable_Name);

			}
		}



	}
	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;


		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('AND');

		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
		$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);
		//add currency
		$Query->addFrom('banking_currencies');
		$Where->addJoin('banking_currencies','currency_id',$this->JoinTable_Name,'currency_id');

		if($Params)
		foreach ($Params as $key=>&$val){



			switch ($key){


				case 'sum':

					$val = (float) $val;
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('sum',$val,$this->JoinTable_Name,'>=');
					$InOut->setObligatoryUrlParam($key,$val);

					break;
				case 'term':
					$val = (int) $val;
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('term',$val,$this->JoinTable_Name,'>=');
					$InOut->setObligatoryUrlParam($key,$val);
					break;



			}



		}
	}


}
class Credit_Item extends Rad_Directory_Record {

	protected $DbFields = array('rate','sum','term','currency_id','purpose_id');
	public $FormName = 'credit_item';
	function __construct($Params = null){
		$this->UseSecondaryTable = true;
		$this->TypeAlias = 'credit';
		$this->setSecondaryTableParams('credit_listing','credit_listing_id');
		parent::__construct($Params);
	}


	protected function addParamsToSelectQueryForUnion(RadSelectQuery $Query,$Params){

		return false;
		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('company_name  as param1');
		$Query->addWhat('compensation  as param2');
		$Query->addWhat('compensation_type  as param3');

		$Query->addWhat('geocode.*');
		$Query->addFrom($this->PrimaryTable_Name .' left join geocode on (geocode.geocode_id ='.$this->PrimaryTable_Name.'.geocode_id )');

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('and');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);
		if($Params){
			$ParamsWhere = $Query->addWhereGroup('AND');
			$ParamsWhere->setDefaultOperator('OR');

			foreach ($Params as $id){
				$ParamsWhere->add($this->PrimaryTable_PrimaryKeyName,$id,$this->PrimaryTable_Name);

			}
		}



	}
	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;


		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('AND');

		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
		$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);

		//add currency
		$Query->addFrom('banking_currencies');
		$Where->addJoin('banking_currencies','currency_id',$this->JoinTable_Name,'currency_id');
		if($Params)
		foreach ($Params as $key=>&$val){


			switch ($key){


				case 'sum':
					$val = (float) $val;
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('sum',$val,$this->JoinTable_Name,'>=');
					$InOut->setObligatoryUrlParam($key,$val);

					break;
				case 'term':
					$val = (int) $val;
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('term',$val,$this->JoinTable_Name,'>=');
					$InOut->setObligatoryUrlParam($key,$val);
					break;



			}




		}
	}
	
	


}

class Datatype_Item extends Rad_Directory_Record {

	protected $DbFields = array('value');
	public $RemoveFormFields = array('long_description','main_image','bluser_id','is_advert','is_active');
	function __construct($Params = null){
		$this->UseSecondaryTable = true;
		$this->TypeAlias = 'datatype';
		$this->setSecondaryTableParams('datatypes','datatype_id');
		parent::__construct($Params);
	}



	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('AND');

		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
		$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);


/*		if($Params)
		foreach ($Params as $key=>&$val){


			switch ($key){


				case 'type':
					$val = mysql_real_escape_string($val);
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('position_type',$val,$this->JoinTable_Name);
					$InOut->setObligatoryUrlParam($key,$val);
					break;



			}




		}*/
	}


}



class Object_Item extends Rad_Directory_Record {

	protected $DbFields = array('value');
	public $RemoveFormFields = array('long_description','main_image','bluser_id','is_advert','is_active');
	function __construct($Params = null){
		$this->UseSecondaryTable = true;
		$this->TypeAlias = 'datatype';
		$this->setSecondaryTableParams('datatypes','datatype_id');
		parent::__construct($Params);
	}



	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('AND');

		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
		$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);


/*		if($Params)
		foreach ($Params as $key=>&$val){


			switch ($key){


				case 'type':
					$val = mysql_real_escape_string($val);
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('position_type',$val,$this->JoinTable_Name);
					$InOut->setObligatoryUrlParam($key,$val);
					break;



			}




		}*/
	}


}
?>