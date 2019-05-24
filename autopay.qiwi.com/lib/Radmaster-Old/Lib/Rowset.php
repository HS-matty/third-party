<?php

class Rowset extends Std_Class {



	protected $_header;
	protected $_rows;
	
	protected $_count_rows_fetched;
	protected $_count_rows_total;
	
	protected $_count_pages_total;

	public function onInit(){

		$this->_rows = new Std_Array();
		//$this->_header = new Std_Array();

	}
	
	

	public function addData($data){

		foreach ($data as $key=>&$row){

			if(!is_array($row)) break;

			if($key == 0){
				$header_fields = array_keys($row);
				if(!empty($header_fields) && !is_numeric($header_fields[0]) )	$this->_header = new Std_Array($header_fields);
			}

			$_row = new Std_Array($row);
			$this->_rows[] = $_row;

		}

	}
	
	public function addRows($rows){
		
		
		if(!$this->_count_rows_fetched){
			
			$count = count($rows);
			$this->_count_rows_fetched = $count;
			$this->_count_rows_total = $count;
			$this->_count_pages_total = 1;
			
						
		}else {
			
			$this->_count_rows_fetched = 0;
			$this->_count_rows_total = 0;
			$this->_count_pages_total = 0;
			
			
		}
		$this->_rows = $rows;
		
	}


}

?>