<?php

class Datasource_Table  extends Std_Class {





	protected $_data;

	/**
	 * Db Adapter
	 *
	 * @var Db_Adapter
	 */
	protected $_db_adapter;
	protected $_schema;
	protected $_fields = array();

	public function onInit(){


		$this->_schema = new Db_Table($this->_name);

		if(!$this->_db_adapter = Registry::get('connection')->mysql) throw new Exception('cannot get db connection');



	}


	public function __construct($table_name = null){

		/*	if($table_name){

		$this->setName($table_name);
		$this->fetchData();

		foreach ($this->_data as $key=>$val){

		$this->setParam($name,$val);
		}


		}*/
		$this->setName($table_name);



	}

	public function setFields(array $fields){
		$this->_fields = $fields;
		return $this;
	}

	public function getSchema(){

		return $this->_schema;
	}

	/**
	 * ...
	 *
	 * @param array $params
	 * @return Datasource_Table
	 */
	public function fetchData($params = null,$type = 'array'){

		$query = new Db_Query_Select();


		if($this->_fields){
			foreach ($this->_fields as $field_name){

				$query->addWhat($field_name);

			}


		}
		else $query->addWhat('*');


		$query->addFrom($this->getName());
		if($params['limit']) $query->addLimit((int) $params['limit'] );

		if($params) {
			$where = $query->addWhereGroup();

			foreach ($params as $param_name => &$param_value){

				$where->add($param_name,$param_value);
			}

		}



		/*@var $db Db_Adapter */

		$sql = $query->getSqlString();
		$this->_db_adapter->query($sql);
		if($type == 'assoc') $this->_data =& $this->_db_adapter->fetch_all_assoc();
		else $this->_data =& $this->_db_adapter->fetch_all_array();
		return $this;

		//$query->ad

		//$select_query->

	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	public function &getData(){
		return $this->_data;
	}


	public function getRow($params = array(),$fields = array()){

		$query = new Db_Query_Select();
		$query->addWhat('*');
		$query->addFrom($this->getName());
		if($params) foreach ($params as $key=>$value) {

			$query->addWhereGroup()->add($key,$value,$this->getName());
		}
		$db = Registry::get('connection')->mysql;
		$data = $db->performQuery($query,false);
		/*@var $db Db_Adapter*/
		//$data = $db->fetch_assoc();
		$row = new Std_Class();
		$row->setParam('table_name',$this->getName());
		if(!empty($data)){
			foreach ($data as $key => &$value){
				$row->addParam($key,$value);
			}
		}
		return $row;
	}


	public function insert($params){



	}
	public function deleteRow($params){


	}



}

?>