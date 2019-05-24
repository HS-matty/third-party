<?php
class Ui_Element extends Std_Class  {

	const Type_FORM = 'form';
	const Type_GRID = 'grid';
	const Type_MENU = 'menu';
	const Type_WINDOW = 'window';
	const Type_BUTTON = 'button';
	const Type_TAB = 'tab';
	const Type_ACCORDION = 'accordion';
	const Type_CHECKBOX = 'checkbox';
	const Type_SELECT = 'select';
	const Type_TEXT = 'text';
	const Type_FILE = 'file';
	const Type_INPUT = 'input';
	const Type_MODAL = 'modal';
	
	
	const Type_GROUP = 'group';

	
	const Type_PANEL = 'panel';
	



	protected $_actions = array();

	protected $_activities = array();

	protected $_error_messages = array();

	//protected $_data_type = 'string';
	
	protected $_data;
	

public function __construct($param = null){

		$this->setType($param);
		$this->onInit();
		//return parent::__construct($param);
		
	}

	public function onInit(){
		$this->_actions = new Ui_Action();
		//$this->_data_type = Std_Type::Type_STRING;
	}


	/**
	 * 
	 *
	 * @param Ui_Action $action
	 * @return Ui_Action
	 */
	public function addAction(Ui_Action $action){

		if(!$this->_actions) $this->_actions = new Ui_Action();
		$this->_actions->addElement($action);
		return $action;

	}
	
	public function getAction($action_name){

		if($this->actions)
		return $this->_actions->getElement($action_name);
		

	}
	

	/**
	 * ....
	 *
	 * @param string | Ui_Element(?) $activity
	 * @return Ui_Activity
	 */
	public function addActivity($activity){
		$_activity = new Ui_Element($activity);
		$this->_activities[] = $_activity;
		return $_activity;
	}

	public function getActivities(){
		return $this->_activities;
	}



	/**
	 * ...
	 *
	 * @param Ui_Field $field
	 * @return Ui_Field
	 */
	public function addField(Ui_Element $field = null){

		if(!$fields = $this->getElement('fields')){
			$fields = $this->addElement('fields');
		}
		
		
		return $fields->addElement($field,'Ui_Field');

	}

	public function getFields(){
		$return_value = null;

		if($this->getElement('fields')) $return_value = $this->getElement('fields')->getElements();
		else $return_value = $this->getElements();

		return $return_value;
	}

	/**
	 * ....
	 *
	 * @param mixed $param
	 * @return Ui_Field || NULL
	 */
	public function getField($param){
		$return_value = null;

		if($fields = $this->getElement('fields')) $return_value = $fields->getElement($param);
		else $return_value = $this->getElement($param);

		return $return_value;
	}


	public function setErrorMessage($message){
		$this->_error_messages[] = $message;
		return $this;
	}

	public function getErrorMessageList(){
		return $this->_error_messages;

	}

	public function getErrorFlag(){

		$return_value = 0;
		if(!empty($this->_error_messages)) $return_value = 1;
		return $return_value;

	}

	public function addFields($array){


		foreach ($array as $name){
			$title = '';
			if(count($name_array = split('_',$name)) > 1){
				foreach ($name_array as $key =>$val){
					if($key == 0) $title .= ucfirst(strtolower($val));
					else $title .= ' '.strtolower($val);

				}

			}else $title = $name;

			$field = new Ui_Field();
			$field->setName($name)->setTitle($title)->setParam('is_enabled',1);
			$this->addField($field);
		}
	}

	
	public function addData($data){
		
	//	if(!$this->_data) $this->_data = new Std_Class();
		
		foreach ($data as &$item){

			if(!is_array($item)) throw new Exception('$data item must be array');
			$this->addElement()->setTitle($item[1])->setValue($item[0]);
		}
		
	}
	
	
	/*	public function __toString(){

	$return_value = null;
	if(!isset($this->_value) && $this->hasElements()){
	$return_value = (string) $this->getElement(0);
	}else $return_value = (string) $this->_value;

	return $return_value;
	}
	*/






}








?>