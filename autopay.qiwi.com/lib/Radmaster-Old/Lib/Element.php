<?php


class Element implements IteratorAggregate, arrayaccess,Countable{

	public	$_name;
	public	$_title;
	public	$_type;

	public $_value;

	public $_key;
	protected $_parent;

	protected $_child_class_name;

	/**
	 * default object type
	 *
	 * @var Element
	 */
	static protected  $_instance;

	protected  $_elements = array();

	protected $_actions = array();


	protected $_current_element_name;
	public  $_current_element;

	protected $_search_element_index;




	/**
	 * @return Element
	 */
	public static function getInstance(){



		if (!self::$_instance) self::$_instance = new self();


		return  self::$_instance;

	}



	public function setChildClassName($class_name){
		$this->_child_class_name = $class_name;
		return $this;
	}

	public function getChildClassName($class_name){
		return $this->_child_class_name;
	}

	public static function factory($name = null,$class_name = null){

		if(!$class_name) $class_name = 'Element';

		if($name) $class_name = $class_name.'_'.ucfirst($name);

		return new $class_name($name);



	}

	public function __construct($element_name = null,$registry_auto_set = false){
		$this->_name = $element_name;
		if($registry_auto_set){
			Registry::set($element_name,$this);
		}
		$this->onInit();

		return $this;

	}

	/**
	 * Enter description here...
	 *
	 * @param array $array
	 * @param string $class
	 * @return Std_Class
	 */
	public static function fromArray($array, $class = 'Std_Class'){

		
		$return_value = new $class;
				
		foreach ($array as $el_string){
			
			if(count($sub_el_array = split('-',$el_string)) > 1){

				$param_el = $return_value->addElement($el_string);
				foreach ($sub_el_array as $sub_el_array_item){
					$param_el->addElement($sub_el_array_item)->setValue($sub_el_array_item);	
				}
				
				


			}else 	$return_value->addElement($el_string)->setValue($el_string);

		}


		return $return_value;

	}

	/*public function fromString($string){



	}
	*/
	public function onInit(){


	}

	/*
	public function __destruct(){

	//$this->onDestroy();

	}*/

	public function onDestroy(){


	}

	/**
	 * Enter description here...
	 *
	 * @param string  $type
	 * @return Element
	 */
	public function setType($type){
		$this->_type = $type;
		return $this;
	}



	public function setParent($parent){
		$this->_parent = $parent;
		return $this;
	}
	public function getParent(){
		return $this->_parent;
	}


	/**
	 * Enter description here...
	 *
	 * @return string
	 */
	public function getType(){
		return $this->_type;
	}




	public function setCurrentElement($name){

		$this->_current_element_name = $name;

		$current_element = null;
		foreach ($this->_elements as $e){

			if($e->getName() == $name) {
				$this->_current_element = $e;
				break;
			}

		}
		return $this;

	}

	public function getCurrentElement(){
		/*@var $e Element*/


		if(!$this->_current_element) $this->_current_element = $this->_elements[0];
		return $this->_current_element;
	}

	/**
	 * Enter description here...
	 *
	 * @param string  $name
	 * @return Ui_Element
	 */
	public function setName($name){
		$this->_name = $name;
		return $this;
	}

	/**
	 * Enter description here...
	 *
	 * @param mixed $value
	 * @return Ui_Element
	 */
	public function setValue($value){
		$this->_value = $value;
		return $this;
	}


	public function setValue_by_reference(&$value){
		$this->_value = $value;
		return $this;
	}

	public function &getValue_by_reference(){
		return $this->_value;
	}

	public function getValue($param = null){

		$return_value = null;
		if(_is_array($this->_value) && $param){

			$return_value = $this->_value->findValue($param);
		}
		else {
			$return_value =  $this->_value;
		}


		return $return_value;
	}
	public function getName(){
		return $this->_name;
	}


	public function getTitle(){
		return $this->_title;
	}


	/**
	 * Enter description here...
	 *
	 * @param string  $title
	 * @return Ui_Element
	 */
	public function setTitle($title){
		$this->_title = $title;
		return $this;
	}

	/**
	 * Enter description here...
	 *
	 * @return array
	 */
	public function getElements(){
		return $this->_elements;
	}


	public function removeElement($element_name){


		$new_elements = array();
		foreach ($this->_elements as $e){
			if($e->getName() != $field_name) $new_fields[] = $field;
		}
		$this->_elements = $new_elements;


	}




	/**
	 * Enter description here...
	 *
	 * @param Ui_Element $element = null | string element_name
	 * @return Element
	 */
	public function addElement($_element = null,$class = 'Std_Class'){



		if(is_string($_element) || !$_element){
			if($_element) $_element = str_replace('-','_',$_element);
			//$element = self::factory($_element,get_class($this));//

			if(is_string($class)) $element = new $class($_element);
			elseif (is_object($class)){
				$element = $class;
				$element->setName($_element);
			}else throw new Exception('wrong params for addElement');


		}
		elseif (is_subclass_of($_element,'Element') || get_class($_element) == 'Element') {
			$element = $_element;

		}
		else  throw new Exception('wrong type for '.$_element);


		$this->_elements[] = $element;

		return $element;


	}





	/**
	 * get field by name
	 *
	 * @param string $name | int $index 
	 * @return Element
	 */
	public function getElement($param,$field_name = 'name'){



		if(is_numeric($param)) $_arr = array('index'=>$param);
		elseif(is_string($param)) $_arr = array($field_name=>$param);
		else $_arr =& $param;

		return $this->searchElement($_arr);


	}


	public function getAction($name){

		$return_value = null;
		foreach ($this->_actions as $action){
			if($action->getName() == $name){
				$return_value = $action;
				break;
			}

		}

		return $return_value;

	}


	/**
	 * ..
	 *
	 * @return Element || NULL
	 */
	public function getFirstElement(){

		return $this->_elements[0];

	}

	/**
	 * ..
	 *
	 * @return Element || NULL
	 */
	public function getLastElement(){

		$return_value = null;

		if($count = count($this->_elements)){
			$return_value = $this->_elements[$count-1];
		}

		return $return_value;

	}


	/**
	 * ..
	 *
	 * @return Element || NULL
	 */
	public function searchElement($params){



		/*@var $f Ui_Element*/
		$search_result = null;

		$this->_search_element_index = null;
		//todo: make multiparams search


		$keys = array_keys($params);

		if($keys[0] == 'index'){
			$search_result = $this->_elements[$params[$keys[0]]];
			if($search_result) $this->_search_element_index = $params[$keys[0]];


		}else
		foreach ($this->_elements as $i => $e){



			if ($e->$keys[0] == $params[$keys[0]]) {
				$this->_search_element_index = $i;
				$search_result = $e;
				break;
			}

			/*
			foreach($params as  $param){

			if($e->$param[0] == $param[1]) {
			$search_result = $e;
			break;
			}
			}*/
		}
		return $search_result;

	}

	public function __get($var_name)
	{


		$return_value = null;

		if(ereg("^element_(.*)",$var_name,$result)){
			$var_name = $result[1];
		}

		if(!preg_match('/^\_/',$var_name)) {
			$_var_name = '_'.$var_name;

			if(property_exists($this,$_var_name) && ($this->$_var_name !== NULL)){
				$return_value = $this->$_var_name;
			}else{
				$return_value = $this->getElement($var_name);
			}

		}



		return $return_value;
	}



	public function addParam($name,$value){

		return $this->setProperty($name,$value);
	}
	public function setParam($name,$value){

		return $this->setProperty($name,$value);
	}

	public function getParam($name){

		return $this->getProperty($name);
	}

	public function setParams($params){

		foreach ($params as $key=>&$value){
			$this->addParam($key,$value);

		}

	}

	public function setProperty($name,$value){
		$name = '_'.$name;
		$this->$name  = $value;
		return $this;

	}

	public function getProperty($name){
		$name = '_'.$name;
		return $this->$name;
	}

	public function __toString(){
		return (string) $this->_value;
	}


	/* array access implementation */


	public function getIterator() {
		return new ArrayIterator($this->_elements);
	}


	public function hasElements(){
		$return_value = false;
		if(!empty($this->_elements)) $return_value = true;

		return $return_value;
	}


	public function getSearchElementIndex(){
		return $this->_search_element_index;

	}

	public function getParams() {
		$arr = get_object_vars($this);
		$new_arr = array();
		foreach ($arr as $key=>&$val){
			if(preg_match('/^_(.*)/',$key,$matches)){
				$new_arr[$matches[1]] = $val;
			}

		}

		return $new_arr;

	}



	//array access interface

	public function offsetSet($offset, $value) {

		if(is_a($value,'Element')){

			$el = $value;
		}else{
			$el = new Element();
			$el->setValue($value);
		}


		if (is_null($offset)) {
			$this->_elements[] = $el;
		} else {
			$this->_elements[$offset] = $value;
		}
	}
	public function offsetExists($offset) {
		return isset($this->_elements[$offset]);
	}
	public function offsetUnset($offset) {
		unset($this->_elements[$offset]);
	}
	public function offsetGet($offset) {
		return isset($this->_elements[$offset]) ? $this->_elements[$offset] : null;
	}



	public static function set($param_name,$value){

		self::getInstance()->setParam($param_name,$value);
	}

	/**
	 *  ...
	 *
	 * @param string $param_name
	 * @return Std_Class
	 */
	public static function get($param_name){
		return self::getInstance()->getParam($param_name);
	}



	//countable interface realization;

	public function count(){
		return count($this->_elements);
	}



}

?>