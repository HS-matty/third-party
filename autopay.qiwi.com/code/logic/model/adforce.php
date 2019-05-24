<?php

class Logic_Model_Adforce extends Element {


	public  $_elements_flat_list;
	public  $_db;

	
	public  function parseMeta($file){


		$meta = simplexml_load_file($file);
		$_db = new Element('db');
		$_db->setValue('db schema');


		$i=0;

		$elements_flat_list = new Element('list');

		foreach ($meta->elements->element as $element){

			//if($element['skip']) continue;

			$name = (string) $element['name'];
			$table_name = (string) $element['table'];
			$title = (string) $element['title'];


			//	$is_additional = (int) $element['additional'];



			if(!$_table = $_db->getElement($table_name)){
				$_table = $_db->addElement($table_name);
			}
			if(!$_field = $_table->getElement($name)){
				$_field = $_table->addElement($name);


				$_field->addElement('index')->setValue($i);
				if(!$elements_flat_list->getElement($name)) {
					
					$elements_flat_list->addElement($_field);
					$_field->setProperty('table_name',$_table->getName());
				}

			}

			$_field->setProperty('is_additional',(int) @$element['is_additional']);


			//if($element['is_unique']){
			$_field->setProperty('is_unique',(int) @$element['is_unique']);
			$_field->setProperty('is_required',(int) @$element['is_required']);
			$_field->setProperty('is_index',(int) @$element['is_index']);
			$_field->setProperty('is_import_skip',(int) @$element['is_import_skip']);
			$_field->setProperty('export_skip',(int) @$element['export_skip']);
			//$_field->setProperty('is_unique',(int) @$element['is_unique']);
			//	}

			$_field->setType((string) @$element['type']);

			$_field->setTitle($title);



			$_table->setValue(new Element('data'));




			$i++;
		}



		$this->_db = $_db;
		$this->_elements_flat_list = $elements_flat_list;


	}
	
}

?>