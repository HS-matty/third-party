<?php

abstract class User_Searches{

	/**
	 * User
	 *
	 * @var RadUser
	 */
	protected $User;
	public function __construct(RadUser $User){
		$this->User = $User;

	}

	protected $Items;

	/*	abstract public function addFolder();
	abstract public function addFolderItem($SearchId);
	abstract public function getFolders();
	abstract public function getItems($FolderId);
	abstract public function deleteFolder($Id);
	abstract public function deleteItem($Id);*/



}

class Session_User_Searches extends User_Searches {

	/**
	 * Zend session 
	 *
	 * @var Zend_Session_Namespace
	 */
	private  $Session;
	public function __construct(RadUser $User){
		parent::__construct($User);


		require_once 'Zend/Session/Namespace.php';
		$this->Session = new Zend_Session_Namespace('User_Searches');


	}
	public function hasListingSearches(){

		if(!empty($this->Session->items)) return true;
		return false;

	}
	public function deleteAllFolders(){
		unset($this->Session->folders);
		unset($this->Session->items);
	}
	public function addFolder($Name){

		$arr = $this->Session->folders;
		//$arr = rsort($arr);
		$id = 0;
		foreach ($this->Session->folders  as $key=> $f){
			if(!$key) $id = $f['search_id'];
			else{

				if($f['search_id'] > $id) $id = $f['search_id'];


			}

		}

		$NewId  = $id + 1;
		/*		print_r($arr);
		echo $NewId;
		die('dd');*/

		$this->Session->folders[] = array('search_id'=>$NewId,'short_description' => $Name);
		$this->clearFolder($Id);
		return $Id;
	}



	public  function clearFolder($FolderId){
		unset($this->Session->items[$FolderId]);

	}
	public function renameFolder($Id,$Name){


		foreach ($this->Session->folders as $key=> &$f ){
			if($f['search_id'] == $Id){

				$f['short_description'] = $Name;
				break;

			}


		}




	}
	public function addListingSearch($FolderId,$SearchId){
		if(!$this->Session->items) $this->Session->items =  array();
		$IncludeFlag = true;
		foreach ($this->Session->items[$FolderId] as $item) {
			if($SearchId == $item){
				$IncludeFlag= false;
				continue;
			}

		}
		if($IncludeFlag) $this->Session->items[$FolderId][] = $SearchId;


	}



	public function getFolders(){

		require_once 'Zend/Session/Namespace.php';
		$Namespace = new Zend_Session_Namespace('User_Searches');
		$Folders = array(
		array('search_id'=>0,'short_description'=>'Default')
		/*	array('search_id'=>1,'short_description'=>'folder2'),
		array('search_id'=>2,'short_description'=>'folder3')*/
		);
		if(!$Namespace->folders){
			$Namespace->folders = $Folders;

		}

		return $Namespace->folders;



		return $Folders;
	}
	public function getItems($FolderId,$FetchItems  = false){



		$Items =  @$this->Session->items[$FolderId];
		if($FetchItems && $Items){
			$Listing = new Rad_Directory_Record();

			return  $Listing->getItemsByKeys($this->Session->items[$FolderId]);
		}
		return $Items;
		//print_r($items);


	}
	public function deleteFolder($Id){

		$this->clearFolder($Id);
		foreach ($this->Session->folders as $key=>$val){
			if($val['search_id'] == $Id){
				$NewArr = array();
				unset($this->Session->folders[$key]);

				foreach ($this->Session->folders as $val){
					$NewArr[] = $val;

				}
				$this->Session->folders = $NewArr;





				break;
			}

		}




	}

	public function deleteListingSearch($FolderId,$ListingId){


		//print_r($this->Session->items);
		foreach ($this->Session->items[$FolderId] as $key =>  $i) {

			if($i== $ListingId) {

				unset ($this->Session->items[$FolderId][$key]);
				break;
			}
		}





	}

}
class Database_User_Searches extends User_Searches {


	public function __construct(RadUser $User){
		parent::__construct($User);


	}
	public function addFolder($Name){


		global $Db;
		$Data = array('short_description'=>$Name,'bluser_id'=>$this->User->getUserId());
		return $Db->sqlgen_insert('search',$Data);



	}

	public  function clearFolder($FolderId){
		global $Db;
		//check if folder belong to the user
		$FolderId = (int) $FolderId;
		if(!$FolderId) return null;
		$Db->query("SELECT bluser_id FROM search WHERE search_id = $FolderId AND bluser_id = {$this->User->getUserId()}");
		if($Db->rows()){
			$Db->query("DELETE FROM saved_listing  WHERE search_id = $FolderId ");
		}


	}
	public function renameFolder($Id,$Name){
		$Id = (int) $Id;
		if(!$Id) return false;

		global $Db;
		$Name = mysql_real_escape_string($Name);
		$Db->query("UPDATE search set short_description = '$Name' WHERE search_id = $Id");
		return $Db->affected_rows();
	}
	public function getFolderByName($Name){
		global $Db;
		$Db->query("SELECT search_id FROM search  WHERE short_description = '$Name'");
		if ($Id = $Db->get_element()) return $Id;

		return null;



	}
	public function addFoldersAndSearches($Data){
		if(!$Data) return null;
		foreach ($Data as $key =>&$i) {
			$Id = null;

			if($i['short_description'] == 'Default') {
				$Id =  $this->getFolderByName('Default');
			}
			if(!$Id) $Id = $this->addFolder($i['short_description']);
			if($i['items'])		foreach ($i['items'] as $sId){

				$this->addListingSearch($Id,$sId);


			}


		}


	}
	public function addListingSearch($FolderId,$SearchId){

		$FolderId = (int) $FolderId;
		if(!$FolderId) return false;
		$arr = array('search_id'=>$FolderId,'listing_id'=>$SearchId);
		global $Db;
		$Db->sqlgen_insert('saved_listing',$arr);
		return $Db->get_insert_id();

	}
	public function getFolders(){


		global $Db;
		$Db->query("SELECT * FROM search WHERE bluser_id = {$this->User->getUserId()} ORDER BY search_id ASC");
		$arr =& $Db->fetch_all_assoc();
		if(!$arr){
			$this->addFolder('Default');
			$Db->query("SELECT * FROM search WHERE bluser_id = {$this->User->getUserId()} ORDER BY search_id ASC");
			$arr =& $Db->fetch_all_assoc();

		}
		return $arr;



	}
	public function getItems($FolderId){

		global $Db;
		$FolderId = (int) $FolderId ;
		if(!$FolderId) return null;
		$sql = "SELECT sl.listing_id FROM saved_listing sl , search s WHERE sl.search_id = $FolderId AND  s.search_id = sl.search_id AND s.bluser_id = {$this->User->getUserId()}";

		$Db->query($sql);
		$arr =& $Db->fetch_all_assoc();
		$result = array();
		if($arr){
			foreach ($arr as &$i){
				$result[] = $i['listing_id'];
			}
		}

		return $result;

	}
	public function deleteFolder($Id){

		$Id= (int) $Id;
		if(!$Id) return false;
		global $Db;
		$Db->query("DELETE  FROM search WHERE search_id = $Id AND bluser_id = {$this->User->getUserId()}");
		if($Db->affected_rows()){
			$this->clearFolder($Id,false);

		}
		return $Db->fetch_all_assoc();





	}


	public function deleteListingSearch($FolderId,$ListingId){

		global $Db;
		$FolderId = (int) $FolderId;
		$ListingId = (int) $ListingId;
		$Sql = "SELECT s.search_id FROM search s, saved_listing sl where sl.listing_id = $ListingId AND sl.search_id = $FolderId  and sl.search_id = s.search_id and s.bluser_id= {$this->User->getUserId()} ";

		$Db->query($Sql);
		if($SearchId = $Db->fetch_element()){
			$Db->query("DELETE FROM saved_listing WHERE listing_id = $ListingId and search_id = $SearchId ");
		}



	}


}

?>