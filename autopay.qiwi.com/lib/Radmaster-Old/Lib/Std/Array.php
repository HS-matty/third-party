<?php

class Std_Array extends Element{


	const  Element_FIRST = 'ARRAY_FIRST';
	const  Element_LAST = 'ARRAY_LAST';

	protected $_data = array();

	public function __construct($param = null){
		if(is_array($param) && !empty($param)){
			foreach ($param as $key=>$val){

				if(is_numeric($key)) $this->_data[] = $val;
				else $this->_data[$key] = $val;

			}

		}

	}

	public function offsetSet($offset, $value) {


		//if($offset && !is_numeric($offset)) throw  new Exception('offset has to be numeric in array (use hash instead) ');

		if (is_null($offset)) 	$this->_data[] = $value;

		else $this->_data[$offset] = $value;

	}
	public function offsetExists($offset) {
		return isset($this->_data[$offset]);

	}


	public function offsetUnset($offset) {
		unset($this->_data[$offset]);
	}
	public function offsetGet($offset) {
		return isset($this->_data[$offset]) ? $this->_data[$offset] : null;
	}


	public function findInner($key,$value){
		$return_value = null;
		foreach ($this->_data as  &$_val){
			if(_is_array($_val) && $_val[$key] == $value){

				$return_value = $_val;
				break;

			}

		}

		return $return_value;
	}



	public function findValue($value){
		$return_value = null;
		foreach ($this->_data as  &$el){
			if( $el == $value){

				$return_value = $value;
				break;

			}

		}

		return $return_value;
	}

	
	public function getData(){
		return $this->_data;
	}
	
	
	public function getIterator() {
        return new ArrayIterator($this->_data);
    }
	

	//iterator interface

	public function rewind()
	{

		reset($this->_data);
	}

	public function current()
	{
		$var = current($this->_data);

		return $var;
	}

	public function key()
	{
		$var = key($this->_data);

		return $var;
	}

	public function next()
	{
		$var = next($this->_data);

		return $var;
	}

	public function valid()
	{
		$key = key($this->_data);
		$var = ($key !== NULL && $key !== FALSE);
		return $var;
	}

	
	 public function __toArray(){
	 	return $this->_data;
	 }


	 //countable interface realization
	 
	 public function count(){
	 	return count($this->_data);
	 }
}

?>