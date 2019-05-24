<?php

class  Logic_Datasource_Adforce_Category extends Datasource  {





	public function onInit(){

		$this->setName('adforce_categories');
		parent::onInit();
	}

	public function fetchData($params = null){

		$query = new Db_Query_Select();

		$query->setDefaultWhereGroupOperator('AND');;

		if($this->_fields){
			foreach ($this->_fields as $field_name){

				$query->addWhat($field_name);

			}


		}
		else $query->addWhat('*');


		//	$query->addFrom($this->getName())->addLimit(20);
		$query->addFrom($this->getName());
		if($params['limit']) $query->addLimit((int) $params['limit'] );
		$query->addFrom('adforce_campaigns');
		$query->addFrom('adforce_links');
		$query->addQueryFlag('DISTINCT');
		$where = $query->addWhereGroup();
		/*
		if($params) {
		$where = $query->addWhereGroup();

		foreach ($params as $param_name => &$param_value){

		$where->add($param_name,$param_value);
		}

		}
		*/
		//
		$query->addJoin($this->getName(),$this->getPrimaryIdFieldName(),'adforce_links','category_id');

		if($campaign_id = (int) $params['campaign_id']){

			$query->addJoin('adforce_links','campaign_id','adforce_campaigns','id');
			$where->add('id',$campaign_id,'adforce_campaigns');
		}





		/*@var $db adapter */

		$sql = $query->getSqlString();
		$this->_adapter->query($sql);
		$this->_data =& $this->_adapter->fetch_all_array();
		return $this;



	}




	public function setTablePrefix($table_prefix){

		$this->_table_prefix = $table_prefix;

	}

	public function isTableExists($table_name){
		global $db;
		$db->query("SHOW TABLES LIKE '{$table_name}'");
		return (int) $db->rows();
	}
	public function setTable($table_name){
		$this->_table = $table_name;
	}

	public function setPrimaryKey($primary_key_name){
		$this->_primary_key = $this->_primary_key;
	}


	public function getItems(){

		global $db;

		//ORDER BY id DESC LIMIT 50
		$db->performSelectQuery("SELECT * FROM {$this->_table_prefix}{$this->_table}");
		return $db->fetchRows();



	}
	public function getItemsExt(){

		global $Db;
		$Query = new RadSelectQuery();
		$Query->addWhat('*');
		$Query->addFrom($this->_table);

		return  $Db->perfromSelectQueryExt($Query);



	}
	public function addItem($data){

		global $Db;
		return $Db->sqlgen_insert($this->_table,$data);



	}

	public function editItem($data){

		$id = (int) $data[$this->_primary_key];
		unset($Data[$this->_primary_key]);

		global $Db;
		return $Db->sqlgen_update($this->_table,$data);

	}

	public  function getItemsByParams($query_params = null,$tables = null){


		global $db;

		$Query = new RadSelectQuery();
		$Query->addWhat('*');

		$where = $Query->addWhereGroup();

		$where->setDefaultOperator('AND');

		$table_prefix = $this->_table_prefix;

		if(empty($tables)) $Query->addFrom($table_prefix.$this->_table);
		else {




			$_table = null;

			foreach ($tables  as $i=> $table){


				$Query->addFrom($table_prefix.$table);
				if($i) {

					$where->addJoin($table_prefix.$_table,'id',$table_prefix.$table,$_table_key_name);
				}


				$count = strlen($table);
				$_table_key_name = substr($table,0,$count-1).'_id';
				$_table = $table;


			}


		}

		$where = $Query->addWhereGroup();
		foreach ($params as $key => $val){


			$where->add($key,$val,$this->_table);
		}

		//$Query->addOrder('id',null,'desc');

		return  $db->perfromSelectQueryExt($Query);

	}


	public function &getItem($id){
		global $Db;
		$id = (int) $id;
		$table = $this->_table;
		$key = $this->_primary_key;
		$Db->query("SELECT * FROM {$table} WHERE {$key}  = {$id} ");
		return $Db->fetch_assoc();
	}
	public function updateItem($data){
		global $db;
		$id = (int) $data[$this->_primary_key];

		unset($data[$this->_primary_key]);

		return $db->sqlgen_update($this->_table,$data,$this->_primary_key." = $id");

	}


	public function deleteRecord($record_id){

		global $db;


		return $db->query("delete from {$this->_table} WHERE {$this->_primary_key} = {$record_id}");

	}


}

?>