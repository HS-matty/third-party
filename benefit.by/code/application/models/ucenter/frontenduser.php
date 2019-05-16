<?php

require_once('user_searches.php');
class FrontendUser extends RadUser {

	

	/**
	 * User searhes object
	 *
	 * @var Session_User_Searches
	 */
	public $Searches;
	function __construct(){
		
		$this->Searches = new Session_User_Searches($this);
		

	}
	public function logout(){
		unset($_SESSION['user']);
	}
	public  function generateSidForAnonymousPosting($ListingId){
		
		return sha1($ListingId.'23Az#45___s');
		
	}

	

	


	

}



?>