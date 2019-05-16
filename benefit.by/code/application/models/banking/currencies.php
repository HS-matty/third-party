<?php

class Banking_Currencies {
	
	protected $_name = 'banking_currencies';
	
	protected $_primary = 'currency_id';
	
	public function &getItems(){
		global $Db;
		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom('banking_currencies');
		$Query->QueryParams->setIsGrid(true);
		 $Db->perfromSelectQueryExt($Query);
		return $Query->QueryResult->Data;
		
	}
	
	
	
	
	
	
	
	
}


class Banking_Purposes {
	
	protected $_name = 'banking_purposes';
	
	protected $_primary = 'purpose_id';
	
	public function &getItems(){
		global $Db;
		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom('banking_purposes');
		$Query->QueryParams->setIsGrid(true);
		 $Db->perfromSelectQueryExt($Query);
		return $Query->QueryResult->Data;
		
	}
	
	
	
	
	
	
	
	
}
?>