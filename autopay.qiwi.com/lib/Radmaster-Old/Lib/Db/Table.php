<?php


require_once('Table/Field.php');


class Db_Table extends Element {


	const Engine_MYISAM = 'MyISAM';
	const Engine_INNODB = 'INNODB';
	//const Engine_RSE = 'RADMASTER-STORAGE-ENGINE';


	const Key_PRIMARY = 'PRIMARY';
	const Key_FOREIGN = 'FOREIGN';
	const Index_UNIQUE = 'UNIQUE';
	const Index_FULLTEXT = ' FULLTEXT';

	/*	const  Index_PRIMARY_KEY = 'PRIMARY';
	const  Index_UNIQUE_KEY =  'UNIQUE';*/

	const Param_CHARSET = 'CHARSET';

	const Value_Charset_DEFAULT = 'utf8';

	protected  $_fields = array();

	protected $_engine_name;

	/**
	 * ...
	 *
	 * @var Db_Adapter
	 */
	protected $_adapter;

	protected $_params = array();
	protected $_keys = array();







	public function onInit(){
		
		$this->setAdapter(Registry::get('connection')->mysql);
	}

	/**
	 * ...
	 *
	 * @return Db
	 */
	public function getAdapter(){

		return $this->_adapter;
	}

	public function setAdapter($adapter){
		$this->_adapter = $adapter;
	}


	/**
	 * set engine name
	 *
	 * @param string $engine_name Db_Table::Engine-const
	 * @return Db_Table
	 */
	public function setEngine($engine_name){

		$this->_engine_name = $engine_name;
		return $this;
	}


	/**
	 * add db field
	 *
	 * @return Db_Table_Field
	 */
	public function addField( Db_Table_Field $field = null){

		if(!$field) $field = new Db_Table_Field();
		$this->addElement($field);
		$field->setParent($this);
		return $field;


	}




	/**
		 * Set field key
		 *
		 * @param string $key_type Db_Table::Key-const
		 * @param array $key_type array(Db_Table_Field $field1, Db_Table_Field $field2 ) ...
		 * @return Db_Table
		 */
	public function addKey($key_type,$fields){

		if(!$this->_keys) $this->_keys = new Element('keys');
		$this->_keys->addElement()->setType($key_type)->setValue($fields);
		return $this;

	}

	public function getKeys(){
		return $this->_keys;
	}


	public function getSqlString(){


		if(empty($this->_name)) throw new Exception('table has no name');
		elseif(empty($this->_fields)) throw new Exception('table has no fields');

		//$sql_query = 'CREATE TABLE app_adforce_items (`id` INT AUTO_INCREMENT NOT NULL, `name` VARCHAR(255) NULL,';
		$sql_query_string = 'CREATE TABLE '.$this->_name .' ( ';

		//process field definitions

		/* @var $field Db_Table_Field */
		$count = count($this->_fields);
		foreach ($this->_fields as $key => $field){
			$sql_query_string .= $field->getSqlString();
			if($key < $count) $sql_query_string .= ', ';
		}

		//process key definitions
		//

		if($this->_keys) {

			$i=0;
			$count = count($this->_keys);

			foreach ($this->_keys as $key_type => $key_fields){

				$sql_query_string .= " {$key_type} KEY ";
				if(empty($key_fields)) throw new Exception('empty key fields-list');

				/*@var $key_field Db_Table_Field*/


				$count_key_fields = count($key_fields);

				$sql_query_string .= '(';
				foreach ($key_fields as $j=>$key_field){

					$sql_query_string .= $key_field->getName();


					if($j < ($count_key_fields-1)) $sql_query_string .= ', ';
				}
				$sql_query_string .= ') ';

				if($i < ($count-1)) $sql_query_string .= ', ';

				$i++;
			}

		}

		$sql_query_string .= ')';


		return $sql_query_string;
	}

	public function isExists(){

		$this->getAdapter()->query("SHOW TABLES LIKE '{$this->_name}'");
		return (int) $this->getAdapter()->rows();
	}



	public function createTable(){

		$sql = $this->getSqlString();
		$this->_adapter->query($sql);

	}
	
	public function emptyTable(){
		
	
		return $this->_adapter->query("TRUNCATE TABLE {$this->_name} ; ");
		
	}


	public function load()
	{

		
		$arr =& $this->_adapter->getFieldList($this->_name);

		foreach ($arr as &$field){

			$_field = new Db_Table_Field();
			$_field->setName($field['Field']);
			$_field->setType($field['Type']);
			$this->addField($_field);


		}

		return $this;

	}
	
	
	
	public function update(){
		
		$db_fields  =& $this->_adapter->getFieldList($this->_name);

		
		foreach ($this->getFields as $field){
			
			//todo: finish
			
		}
		
	}



	public function getField($name){
		return $this->getElement($name);
	}

	
	public function getFields(){
		return $this->getElements();
	}
	
	
	

}


?>