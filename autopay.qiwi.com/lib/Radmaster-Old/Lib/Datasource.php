<?php
class Datasource extends Std_Class {

	
	
	protected $_data;
	
	/**
	 * Db Adapter
	 *
	 * @var adapter
	 */
	protected $_adapter;
	protected $_schema;
	
	
	protected $_primary_id_field_name = 'id';
	protected $_fields = array();
	
	
	
	
	
	public function onInit(){
		
		
		$this->_schema = new Db_Table($this->_name);
		
		if(!$this->_adapter = Registry::get('connection')->mysql) throw new Exception('cannot get db connection');
		
		
		
	}
	
	
	public function setPrimaryIdFieldName($field_name){
		$this->_primary_id_field_name = $field_name;
		return $this;
	}
	
	public function getPrimaryIdFieldName(){
		return $this->_primary_id_field_name;
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
	public function fetchData($params = null){
		
		$query = new Db_Query_Select();
		
						
		if($this->_fields){
			foreach ($this->_fields as $field_name){

				$query->addWhat($field_name);
								
			}
			
			
		}
		else $query->addWhat('*');
			
		
		$query->addFrom($this->getName())->addLimit(20);

		
		if($params) {
			$where = $query->addWhereGroup('AND');
			
			foreach ($params as $param_name => &$param_value){
			
				$where->add($param_name,$param_value);
			}
						
		}
		
		
		
		/*@var $db adapter */
		
		$sql = $query->getSqlString();
		$this->_adapter->query($sql);
		$this->_data =& $this->_adapter->fetch_all_array();
		return $this;
		
	
				
}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	public function &getData(){
		return $this->_data;
	}
	
	public function insert($params){
		
		
		
	}
	public function deleteRow($params){
				
		
	}
		
	
	
	
	
	
	
	public  function _get($query_string,$query_params = null){
		
		
			$query_string_array = split("\?",$query_string);
			
			$tokens = $this->addElement('tokens');
			$params = $this->addElement('params');
			
			if($query_string_array[0]){
				
				if($query_tokens = split("\/",$query_string_array[0])){
					foreach ($query_tokens as $token_name){
						if($token_name) $tokens->addElement($token_name);
					}
				}
			}
			
			if($query_string_array[1]){
				
				if($query_params = split("\&",$query_string_array[1])){
					foreach ($query_params as $query_param){
						if($query_param){
							if($query_param_array = split('\=',$query_param)){
								$params->addElement($query_param_array[0])->setValue($query_param_array[1]);
							}
							
						}
					}
				}
			}
				
			
			
			$query = new RadSelectQuery();
			$query->addWhat('*');
			foreach ($tokens as $token){
				$token_name = $token->getName();
				$token_name = str_replace('\-','_',$token_name);
				$query->addFrom($token_name);								
				
			}
			
			$where = $query->addWhereGroup();
			foreach ($params as $param){
				$param_name = $param->getName();
				$param_value = $param->getValue();
				if(ereg('sha_',$param_name)){
					$param_value = "SHA1({$param_value})";
				}
				$where->add($param_name,$param_value);
				
			}
			
			$sql = $query->getSqlString();
			
			Registry::get('connection')->mysql->query($sql);
			$row = Registry::get('connection')->mysql->fetch_assoc();
			$element = new Element('user');
			$element->setParams($row);
			return $element;
			
			
		
	}
	
	
	public static function _put($path, $data ){
				
		
		
		
	}

}




?>