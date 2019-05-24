<?php


class Db_Table_Field extends Element  {
	
		const Type_CHAR = 			'CHAR';
		const Type_VARCHAR = 		'VARCHAR';
		const Type_TINYTEXT = 		'VARCHAR';
		const Type_TEXT = 			'VARCHAR';
		const Type_BLOB = 			'VARCHAR';
		const Type_MEDIUMTEXT = 	'VARCHAR';
		const Type_MEDIUMBLOB =	'MEDIUMBLOBR';
		const Type_LONGTEXT = 		'LONGTEXT';
		
		
		
		const Type_INT = 'INT';
		const Type_TINYINT = 'TINYINT';
		const Type_SMALLINT = 'SMALLINT';
		const Type_MEDIUMINT = 'MEDIUMINT';
		const Type_BIGINT = 'BIGINT';
		const Type_FLOAT = 'FLOAT';
		const Type_DOUBLE = 'DOUBLE';
		const Type_DECIMAL = 'DECIMAL';
		
		const Type_DATE = 'DATE';
		const Type_DATETIME = 'DATETIME';
		const Type_TIMESTAMP = 'TIMESTAMP';
		const Type_TIME = 'TIME';
		
		const Type_ENUM = 'ENUM';
		const Type_SET = 'SET';

		
	
		
		const Type_Param_LENGTH = 'LENGTH';
		
		
		const Param_AUTOINCREMENT = 'AUTO_INCREMENT';
		const Param_DEFAULT_VALUE = 'DEFAULT_VALUE';
		
		const Param_NULL = 'NULL';
		const Param_NOT_NULL = 'NOT NULL';
		
		
		
		protected $_type_name;
		protected $_type_param;

		
		
		protected $_field_params = array();
		
		protected $_keys = array();
		
		protected $_default_value;
		
		protected $_parent;
		
		
	

		
		public function setParent($parent){
			$this->_parent = $parent;
		}
		
		

		/**
		 * Enter description here...
		 *
		 * @param string $type_name Db_Table_Field::Type-const 
		 * @return Db_Table_Field
		 */
		public function setType($type){
			
			if(preg_match('/^([a-zA-Z]+)\(([0-9]+)\)?$/',$type,$matches)){
				
				$type = $matches[1];
				$param = (int) $matches[2];
			}
			$this->_type = strtoupper($type);
			if(isset($param)) $this->_type_param = $param;
			
			return $this;
		}
		
		/**
		 * Set field params (attributes) like NOT_NULL, AUTO_INCREMENT and etc ...
		 *
		 * @param string $param_name  Db_Table_Field::Param-const
		 * @param string  $value 	Db_Table_Field::Value-const
		 * @return Db_Table_Field
		 */
		public function setFieldParam($param_name, $value = true){
			
			
			$this->_field_params[$param_name] = $value;
			return $this;
			
		}
		
		/**
		 * Set type param, 4example: varchar ($param_value)
		 *
		 * @param string $param_name Db_Table_Field::Param-const
		 * @param string $value Db_Table_Field::Value-const
		 * @return Db_Table_Field
		 */
		public function setTypeParam($param_name,$value = true){
			$this->_type_param[$param_name] = $value;
			return $this;
		}
		
				
		public function getTypeParam(){
			return $this->_type_param;
		}
			
				
		
		public function getTypeString(){
			
			$type_string = $this->_type_name;
			if($this->_type_param[self::Type_Param_LENGTH]) $type_string .= "({$this->_type_param[self::Type_Param_LENGTH]})";
			return $type_string;
		}
		
		
		public function getSqlString(){
				//$sql_query = 'CREATE TABLE tst555 (`id` INT AUTO_INCREMENT NOT NULL, `name` VARCHAR(255) NULL,';
			
				$sql_string = "`{$this->_name}` {$this->getTypeString()}";
				if($this->_field_params) foreach ($this->_field_params as $param_name => &$value){
					
					$sql_string .= " {$param_name} ";
					if($this->_keys) foreach ($this->_keys as $key){
						
					}
						
					
				}
								
				return $sql_string;
			
			
			
		}

			
		
}


?>