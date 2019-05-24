<?php

class Xml_Element extends Element {


	public $_level;

	public static function load($file_name){



		$meta = simplexml_load_file($file_name);


		if(!$meta) {
			throw new Exception('Error in loading '.$file_name);
		}

		$parser = new Xml_Parser();
		$parser->parse($meta);



		return true;


	}

	public  function parse($meta, Element $Element = null){

		
		
		if (!$element) {
			
			$element = new Xml_Element();
			$level = 0;
			
		}else $level++;

		
		
		$name = $meta->getName();
		
		$element->setName($name);


		$attributes = $meta->attributes();
		$children = $meta->children();

		if($attributes) foreach ($attributes as $key=>$val){
			if($key == 'id') $key = 'name';
			$element->setProperty($key,(string) $val);
		}
		
		if($meta->hasChildren) {
			
			$this->parseChildrenNodes($meta->children(),$element);
		}




		return $element;
	}



}



?>