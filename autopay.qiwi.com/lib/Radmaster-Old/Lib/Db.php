<?php
/*
radmaster library 2.3
Sergey Volchek 2003-2013
www.radmaster.net

*/

//8.08.2006 added sql log and exception support
// added new class QueryRange

//13.11.2012 updates-updates =)


class Db extends Element {



	protected $_adapter;
	



	public function onInit(){

		
		$this->setAdapter(Registry::get('connection')->mysql);
	}



	public function setAdapter($adapter){
		$this->_adapter = $adapter;
		return $this;
	}
	public function getAdapter(){
		return $this->_adapater;
	}

	public function load(){
		if(!$this->_name) throw new Exception('Database name not set');

		if(!$this->_adapter) throw new Exception('Db-Adapter not set');
			

		$arr =& $this->_adapter->getTableList($this->_name);

		foreach ($arr as &$table_arr){

			$table = new Db_Table($table_arr[0]);
			$table->load();
			$this->addElement($table);


		}
		
		return $this;

	}
	
	public function getTables(){
		return $this->_elements;
	}
	
	public function addTable(Db_Table $table = null){
		return $this->addElement($table);
	}
	
	




}

?>