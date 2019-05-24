<?php

class Logic_Ui_Menu{



	protected $_elements = array();
//	protected $_menu;

	protected $_title;
	 
	public $_element_current_name;


	public function getTitle(){
		return $this->_title;
	}

	public function setCurrentElementName($element_name){
		$this->_element_current_name = $element_name;
	}
	public function getCurrentElementName(){
		return $this->_element_current_name;
	}


	public static  function load($file){

		$meta = simplexml_load_file($file);

		$menu	 = new Logic_Ui_Menu();
		$menu->init($meta);

		return $menu;



	}
	
	public function getCurrentElement(){
		$curr_element = null;
		foreach ($this->_elements as $e){
			if($e['name'] == $this->getCurrentElementName()) {
				
				$curr_element = $e;
				break;
			}
		}
		return $curr_element;
	}

	public function init($xml_meta){

		
		$this->_title = (string) $xml_meta->title->ru;
		
		foreach ($xml_meta as $menu_element){
			$element = array();
			$element['title'] = (string) $menu_element->title->ru;
			$element['name'] = (string) $menu_element['id'];
			$element['group'] = (string)  $menu_element['group_id'];

			if($menu_element->link && false) $link = (string) Link::_init_from_xml($menu_element->link);
			
			else {
				$link = new Link(array($element['name']));
				$element['link'] = (string) $link;
			}


			//check for submenu
			$menu_sub_file = PATH_META_DATA.'/menu/'.$element['name'].'.xml';
			
			if(file_exists($menu_sub_file)){
								

				$element['submenu'] = Logic_Ui_Menu::load($menu_sub_file);
				//print_r($element);
				
			}else $element['submenu'] = null;
			$this->_elements[] = $element;

		}


	}

	public function addMainMenuItem($Title,Rad_Link $Link){

	}

	public function addActionMenuItem($Title,Rad_Link $Link){
		$this->addMenuItem(1,$Title,$Link);

	}

	protected function addMenuItem($Level,$Title,Rad_Link $Link){
		if(!is_array($this->Menu[$Level]))  $this->Menu[$Level] = array();

		$MenuItem['title'] = $Title;
		$MenuItem['link'] =  $Link;
		$this->Menu[$Level][] = $MenuItem;
	}
	public function getActionsMenu()
	{
		return $this->Menu[1];
	}

	/**
	 *  ...
	 
	 * @return Logic_Ui_Menu
	 */
	public function getSubMenu(){
		return $this->_menu;
	}

	public function getMenu($level=0){

		return $this->_elements;

	}
	
	public function getElements(){
		return $this->_elements;
	}
}



?>