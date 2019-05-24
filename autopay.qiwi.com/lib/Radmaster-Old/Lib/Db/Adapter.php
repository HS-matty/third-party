<?php
/**********************

radmaster library
Sergey Volchek 2003-2014
www.radmaster.net

***********************/


class Db_Adapter extends Std_Class  {






	protected   $_link;
	protected	$_sql_log = array();
	protected	$_rowset;




	public function performSelectQuery($sql_string){

		$sql_string = trim($sql_string);
		$pattern = "/^SELECT (.*) FROM ([a-zA-Z0-9LEFTRIGHTJOIN\(\)\,\_\=\.\s]*)(WHERE)?([\-\+\'a-z0-9BETWEENANDOR\(\)\,\_\=\.\s]*)?(GROUP BY)?([a-z0-9\(\)\,\_\-\+\=\.\s]*)(ORDER BY)?([a-z0-9\(\)\,\_\=\.\s]*)(LIMIT)?([0-9\\,\s]*)?$/";


		preg_match($pattern,$sql_string,$arr);




		$What = $arr[1];
		$From = $arr[2];
		$Where = $arr[4];
		$GroupBy = $arr[6];
		$Order= $arr[8];
		$Limit= $arr[10];


		$query = new RadSelectQuery();
		$query->addWhat($What);
		$query->addFrom($From);
		if($Where) $query->addWhereGroup()->add($Where);
		if($GroupBy) $query->addGroupBy($GroupBy);
		if($Limit) $query->addLimit($Limit);

		$this->performQuery($query);
		return $this;


	}

	public function &performQuery($query,$is_grid = true,$is_single = true){

		/*@var $qr QueryRange*/



		if($is_grid) {

			$query->addQueryFlag('SQL_CALC_FOUND_ROWS');


			if($query_params = Registry::get('query_params')){

				if($query_params->getParam('order_by')) $query->addOrder($query_params->getParam('order_by'),null,$query_params->getParam('direction'));
				if($limit = $query_params->getParam('limit')) $query->addLimit($limit->rows_number,$limit->start);

			}else{
				$query->addLimit('50');
				$query->addOrder('id');

			}

			if(!$query->getLimitString()) $query->addLimit(200,0);


			$sql = $query->getSqlString();
			$this->query($sql);


			$rowset = $this->fetchRows();

			if($rowset->count_rows_fetched){
				$this->query("SELECT FOUND_ROWS()");
				$total_rows = $this->fetch_element();


			}else $total_rows = 0;

			$rowset->setParam('count_rows_total',$total_rows);

			if($limit->rows_number){


				$rowset->setParam('count_pages_total',(int) ceil($total_rows / $limit->rows_number));


			}

		}else {

			$sql = $query->getSqlString();
			$this->query($sql);
			if($is_single) $rowset = $this->fetch_assoc();
			else  $rowset = $this->fetch_all_assoc();
			//$rowset = $this->fetchRows();

		}


		$this->_rowset =  $rowset;

		return $rowset;


	}


	public function select_db($db_name) {
		mysqli_select_db($db_name,$this->_link);
		return $this;
	}

	public function close_connection() {
		mysqli_close($this->_link);
		return $this;
	}

	public function connect($db_name,$host_port='localhost',$user='',$password='') {

		$this->_link = mysqli_connect($host_port,$user,$password,$db_name);


		if( !$this->_link) throw new Exception(mysqli_connect_error());

		return $this;
	}



	public function query($sql_string) {


		//$this->_sql_log = $sql_string;

		$log = Registry::get('log');


		$log->addMessage($sql_string,'sql');
		if(!$this->result = mysqli_query($this->_link,$sql_string))
		throw new Exception('db query error: '.$this->_link->error.' . <br>sql-query: '.$sql);



		return $this->result;
	}





	function getErrorMessage(){
		if($this->_link) {

			return mysqli_error();
		}
	}

	function &fetch_array() {
		if( !$this->_link ) return false;
		$arr =  mysqli_fetch_array($this->result,MYSQLI_NUM);
		if($arr) return $arr;
		return null;
	}

	function &fetch_assoc() {
		if( !$this->_link ) return false;

		$arr = mysqli_fetch_assoc($this->result);
		return $arr;


	}




	/**
	 * ...
	 *
	 * @return Element
	 */
	public function fetchRows(){


		$rows_count = $this->rows();
		$rowset = new Rowset('rowset');
		$rowset->setParam('count_rows_fetched',$rows_count);

		/*		$header = $rowset->addElement('header');

		if($rows_count){

		for($i=0;$i<$rows_count;$i++){
		$row =& $this->fetch_assoc();
		if($i == 0){
		$header_fields = array_keys($row);
		$header->setValue($header_fields);
		}
		$rows->addElement('row_'.$i)->setValue($row);
		}


		}*/

		$data =& $this->fetch_all_assoc();
		$rowset->addData($data);

		$this->_rowset = $rowset;
		return $rowset;

	}


	function &fetch_all_assoc() {


		$rows_count = $this->rows();
		$return_result = array();
		if($rows_count) {

			for( $i=0; $i<$rows_count; $i++ ) {
				$r =& $this->fetch_assoc();
				$return_result[] = $r;

			}

		}

		return $return_result;
	}

	function &fetch_all_array() {


		$rows_count = $this->rows();
		$return_result = array();
		if($rows_count) {

			for( $i=0; $i<$rows_count; $i++ ) {
				$r =& $this->fetch_array();
				$return_result[] = $r;

			}

		}

		return $return_result;
	}




	public function getRowset(){
		return $this->_rowset;
	}


	function rows() {
		if( !$this->_link ) return false;
		return mysqli_num_rows($this->result);
	}

	function affected_rows() {
		if( !$this->_link ) return false;
		return mysqli_affected_rows($this->_link);
	}

	function get_insert_id() {
		if( !$this->_link ) return false;
		return mysqli_insert_id($this->_link);
	}


	public function get_element(){
		return $this->fetch_element();
	}
	function fetch_element(){
		$arr =& $this->fetch_array();
		return $arr[0];

	}

	function sqlgen_insert($table_name,$data, $params = null,$return_as_string = false,$fields = null) {

		$db =& $this;


		$query_params = @$params['query_params'];
		if(!$operator = @$params['operator']) $operator = 'insert';

		$sql = "$operator {$query_params} into `$table_name` set ";
		$comma = false;
		foreach( $data as $key => $value ) {
			//if( !is_string($key) ) continue;
			if( is_string($value) && $value !='NOW()') { $value = "'".($value)."'"; }
			if( is_null($value) ) { $value = "null"; }

			/*	if( $comma ) $sql .= ',';
			if( is_bool($value) && !$value )
			$sql .= "$key";
			else
			$sql .= "$key=$value";
			*/
			if( !(is_bool($value) && !$value) ) {
				if( $comma ) $sql .= ',';

				if($fields) $key_name = $fields[$key];
				else $key_name = $key;

				$sql .= "$key_name=$value";
			}
			$comma = true;
		}


		if(@$params['where']){

			$sql .= $params['where'];
		}

		$return_value = null;
		if($return_as_string){
			$return_value = $sql;
		}else{
			$db->query($sql);

			if($message = $db->getErrorMessage()) throw new Exception($message);
			$return_value = $db->get_insert_id();
		}
		return $return_value;

	}


	public function import($sql_file){


		if(!$handle = fopen($sql_file, 'rb')) throw new Exception('couldnt open file '.$sql_file);

		while (!feof($handle)) {

			$buffer = stream_get_line($handle, 1000000, ";".PHP_EOL);

			$this->_link->query($buffer);
		}


	}


	public function &getTableList($db_name = null){
		$sql = 'SHOW TABLES';
		if($db_name) $sql .= ' FROM ' . $db_name;
		$this->query($sql);
		return  $this->fetch_all_array();

	}
	public function &getFieldList($table_name){

		$sql = 'SHOW COLUMNS FROM ' . $table_name;
		$this->query($sql);
		return  $this->fetch_all_assoc();

	}



}

?>