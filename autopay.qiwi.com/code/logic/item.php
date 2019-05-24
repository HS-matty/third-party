<?php
	
abstract class Logic_Model{
	
	public static $table = 'app_job_apply';
	public static $primary_key = 'app_job_apply_id';

	static public function getItems(){

		global $Db;
		$table = self::$table;

		return $Db->performSelectQueryForList("SELECT * FROM {$table}");

		

	}
	public function getItemsExt(){

		global $Db;
		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom(self::$table);

		return  $Db->perfromSelectQueryExt($Query);



	}
	public function addItem($data){
		
		$data_filtered = array();
		$fields = array('first_name','last_name','middle_name','date_birth','age','sex','profession');

		foreach ($fields as $field){
			
			if(isset($data[$field])) $data_filtered[$field] = $data[$field];
			//else $data_filtered[$field] = null;
			
		}
		global $Db;
		return $Db->sqlgen_insert(self::$table,$data_filtered);



	}

	public function editItem($data){

		$id = (int) $data[self::$primary_key];
		unset($Data[self::$primary_key]);

		global $Db;
		return $Db->sqlgen_update(self::$table,$data);

	}

	static function getItemByParams($params){


		global $Db;

		global $Db;
		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom(self::$table);

		$where = $Query->addWhereGroup();
		foreach ($params as $key => $val){
			$where->setDefaultOperator('AND');

			$where->add($key,$val,self::$table);
		}

		return  $Db->perfromSelectQueryExt($Query);

	}
	public function &getItem($id){
		global $Db;
		$id = (int) $id;
		$table = self::$table;
		$key = self::$primary_key;
		$Db->query("SELECT * FROM {$table} WHERE {$key}  = {$id} ");
		return $Db->fetch_assoc();
	}
	public function updateItem($data){
		global $Db;
		$id = (int) $data[self::$primary_key];
		
		unset($data[self::$primary_key]);
		
		return $Db->sqlgen_update(self::$table,$data,self::$primary_key." = $id");

	}
	
	
}	
	
?>