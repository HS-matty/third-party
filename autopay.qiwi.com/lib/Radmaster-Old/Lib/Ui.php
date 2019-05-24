<?php


require_once('Ui/Element.php');
require_once('Ui/Form.php');
require_once('Ui/Grid.php');
require_once('Ui/Menu.php');
require_once('Ui/Window.php');
require_once('Ui/Action.php');
require_once('Ui/Group.php');






class Ui {


	const Type_GRID = 'grid';
	const Type_FORM = 'form';
	const Type_MENU = 'menu';
	const Type_TAB = 'tab';
	const Type_OUTPUT_BOX = 'output_box';
	const Type_STATE_BOX =  'state_box';

	public $_fields = array();

	protected $_ui_type = '';
	protected $_ui_element_schema_xml;


	public function __construct($ui_type = null){
		$this->_ui_type = $ui_type;

	}

	public function loadPrototype($file_xml = null){


		if(!$file_xml)
		switch ($this->_ui_type){
			case self::UI_FORM:
				$file_xml = 'ui-form.xml';
				break;
			case self::UI_GRID:
				$file_xml = 'ui-grid.xml';
				break;
			case self::UI_MENU:
				$file_xml = 'ui-menu.xml';
				break;

			default:
				throw new Exception('wrong ui-type: '.$this->_ui_type);
				break;
		}
		if(!$this->_ui_element_schema_xml = simplexml_load_file(PATH_META_DATA."/@prototype/{$file_xml}.xml")) throw new Exception('cannot load prototype: '.$file_xml .' for ui_type: '.$this->_ui_type);


	}

	public function setField($field_name,$field_value){

		$this->_fields[$field_name] = $field_value;
	}




	public function setRowset(Element $rowset){

		$this->_rowset = $rowset;

	}

	/**
	 * ...
	 *
	 * @param strin  $path kind of /@ui/app/path
	 * @param bool $create_if_not_exists
	 * @return Ui_Element
	 */
	public function loadUiElement($path,$load_default_if_not_exists = true){

		
		$return_value = false;
		$file = $path.'.xml';
		if(!file_exists(PATH_META_DATA.'/'.$file) && $load_default_if_not_exists){

			$ui_type =  null;
			if(ereg('grid',$path)) $ui_type = 'grid';
			elseif (ereg('form',$path)) $ui_type = 'form';
			else  throw new Exception('cannot determine ui element type');

			$path = '/@ui/@default/'.$ui_type;
		}else $return_value = Ui::_init($path);

		//
		return $return_value;


	}


	public static function save(Ui_Element $ui_element){


		$meta_string = "<{$ui_element->type}></{$ui_element->type}>";

		$meta = new SimpleXMLElement($meta_string);

		$meta->addAttribute('name',$ui_element->getName());

		$meta_elements = $meta->addchild('fields');



		foreach ($ui_element->getFields() as  $field){

			$meta_element = $meta_elements->addChild('field');
			//$meta_element->addAttribute('name','name');

			$meta_element->addAttribute('name',$field->name);
			$meta_element->addAttribute('table',$field->getParam('table'));
			$meta_element->addAttribute('is_enabled',$field->getParam('is_enabled'));

			//$name = strtolower(str_replace(' ','_',$title));


			$title_meta = $meta_element->addChild('title');
			$title_meta->addChild('ru');
			$title_meta->addChild('en');
			$title_meta->en = $field->title;
			$title_meta->ru = $field->title;




		}



		$xml_string = $meta->asXml();

		$dom = new DOMDocument("1.0");
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml_string);
		$xml_string =  $dom->saveXML();

		//$file_name_grid = PATH_META_DATA.$path.'adforce_'.$entity_name.'.xml';
		//$file_name_form = 'Z:\\_export\\meta\\form\\'.'adforce_'.$entity_name.'_item.xml';

		$file = PATH_META_DATA.$ui_element->getParam('path').'.xml';

		file_put_contents($file,$xml_string);




	}




	public static function _parse($children,Element $parent_element){




/*		if(!self::$_meta) throw new Exception('meta data not loaded');



		$meta = self::$_meta;*/


		if(!$class_name = (string) @$meta_data['class_name']) $class_name = 'Ui_Element';//$class_name = 'Ui_'.ucfirst((string) $meta->getName());
		//$class_name = get_class(new self());

		$lang = Registry::get('lang');





		//if($count == 1) $path_prefix = preg_replace('/\./','',$path_prefix);


		//$count = count($meta_data);

		//	foreach ($meta_data as $meta_data_key =>$meta_data_el){

		foreach ($children as $element_meta){

			if(!$name = (string) $element_meta->getName()) $name = (string) $element_meta->id;
			if(!$class_name = (string) $element_meta['class_name']) $class_name = 'Ui_Element';//$class_name = 'Ui_'.ucfirst($name);

			if ($name == 'field') $class_name = 'Ui_Field';

			$element = new $class_name;


			$element_name = (string) $element_meta['name'];

			$element->setName($name);

			if($element_meta->title) $element->setTitle( (string) $element_meta->title->{$lang});


			foreach ($element_meta->attributes() as $key=>$val){
				$element->setParam($key,(string) $val);
			}


			$value = null;
			if($element_meta->children()){
				if(isset($element_meta->value)) $value = (string) $element_meta->value;

			}else $value = (string) $element_meta;
			$element->setValue(trim($value));

			$parent_element->addElement($element);

			if($children = $element_meta->children() ){

/*				if($path == '/') $path_prepared = $path.$name;
				else {
					$path_prepared = $path;
					if($count > 1) $path_prepared .= '['.($meta_data_key+1).']';
					$path_prepared .= '/'.$name;
				}*/

				self::_parse($children,$element);


			}

		}










	}

	/*	public static function xml2array_parse($xml,$root_element = null){


	foreach ($xml->children() as $parent => $child){

	$element = new Ui_Element();
	$element->setName($parent);
	if($root_element) $root_element->addElement($element);

	$element->addElement(UI::xml2array_parse($child) ? UI::xml2array_parse($child):"$child");
	//$return["$parent"] = UI::xml2array_parse($child) ? UI::xml2array_parse($child):"$child";
	return $element;
	}
	return $root_element;
	}*/


	public  static function _init($path, $meta = null){


		if(!$meta){


			$file = PATH_META_DATA.$path.'.xml';



			if(!$meta = simplexml_load_file($file)) {


				throw new Exception("meta file $file not loaded ...");
			}
			$meta['xmlns'] = '';
		}

		$name= $meta->getName();
		if(!$class_name = (string) $meta['class_name']) {
			if(ereg('grid',$path)) $class_name = 'Ui_Grid';
			elseif (ereg('form',$path)) $class_name = 'Ui_Form';
			
			else $class_name = 'Ui_Element';//$class_name = 'Ui_'.ucfirst($name);
		}
		
		$element = new $class_name;
		$element->setName((string) $meta['name']);
		$element->setType($name);
		$element->setTitle((string) $meta['title']);
		$element->setParam('path',$path);

		if($children = $meta->children()) self::_parse($children,$element);
		return $element;



	}



	public static $level = 0;

	public static $_meta = null;

	static public  function generate($rowset,$path){


		$fields = $rowset->header->getValue();
		$path_array = split('/',$path);
		$name = $path_array[count($path_array)-1];

		if(preg_match_all('/@([a-zA-Z_]+)/',$path,$matches)){

			$meta_tag = $matches[1][count($matches[1])-1];
			$class_name = '';
			foreach ($matches[1] as $key=> $val){
				if($key>0) $class_name .= '_';
				$class_name .= ucfirst($val);
			}
			$meta_string = "<{$meta_tag} class_name='{$class_name}'></{$meta_tag}>";

		}else $meta_string = '<meta></meta>';

		$meta = new SimpleXMLElement($meta_string);

		$meta->addAttribute('name',$name);

		$meta_elements = $meta->addchild('fields');



		foreach ($fields as  $field_name){

			$meta_element = $meta_elements->addChild('field');
			//$meta_element->addAttribute('name','name');

			$meta_element->addAttribute('name',$field_name);

			$title = '';
			if($name_array = split('_',$field_name)){
				foreach ($name_array as $key => $name_item){

					if($key == 0)  $name_item = ucfirst($name_item);
					else $title .= ' ';
					$title .= $name_item;

				}

			}else $title = ucfirst($field_name);


			//$name = strtolower(str_replace(' ','_',$title));

			$title_meta = $meta_element->addChild('title');
			$title_meta->addChild('ru');
			$title_meta->addChild('en');
			$title_meta->en = $title;
			$title_meta->ru = $title;


		}



		$xml_string = $meta->asXml();

		$dom = new DOMDocument("1.0");
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xml_string);
		$xml_string =  $dom->saveXML();

		//$file_name_grid = PATH_META_DATA.$path.'adforce_'.$entity_name.'.xml';
		//$file_name_form = 'Z:\\_export\\meta\\form\\'.'adforce_'.$entity_name.'_item.xml';

		$file = PATH_META_DATA.$path.'.xml';

		if(!file_exists($file)) file_put_contents($file,$xml_string);
		//	file_put_contents($file_name_form,$xml_string);



		/***************/
		/*end of makeup*/
		/**************/



	}
	
	
	

}


?>