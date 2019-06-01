<?php
class Logic_Dev extends Std_Class {


	public $_entity;


	public function onInit(){


		$_entity = new Std_Class();
		$_entity->addElement('id')->setTitle('id');
		$_entity->addElement('name')->setTitle('Name');
		$_entity->addElement('title')->setTitle('Title');

		$this->_entity = $_entity;


	}


	public function createTable($entity_name){

		if($datasource->isTableExists($entity_name)){
			$datasource->setTable($entity_name);

			//$items = $datasource->getItems();

			$query = new Db_Query_Select();
			$query->addFrom($entity_name);
			$query->addWhat('*');

			$db = Registry::get('connection')->mysql;
			$db->performQuery($query);

			if($rowset = $db->getRowset()){
				$arr = $rowset->header;
				$grid->addFields($arr);

			}


			break;

		}

	}

	public function createGrid($entity_name){


	}


	public function createDatasetUI($entity_name){


		$file_name_grid = PATH_META_DATA.'\\grid\\'.$entity_name.'.xml';
		$file_name_form = PATH_META_DATA.'\\form\\'.$entity_name.'.xml';


		$datasource = new Logic_Datasource_Default();
		$table_name = $entity_name;
		if($table == 'default') $table .= '_table';






		$table = new Db_Table();

		$table->setName($entity_name);


		//create table //


		if(!$table->isExists()){

			$table->setEngine(Db_Table::Engine_INNODB)->setParam(Db_Table::Param_CHARSET,Db_Table::Value_Charset_DEFAULT);
			//up standart fields

			$field_1 = $table->addField()->setName('id')->setType(Db_Table_Field::Type_INT)->setFieldParam(Db_Table_Field::Param_AUTOINCREMENT)->setFieldParam(Db_Table_Field::Param_NOT_NULL);
			$field_2 = $table->addField()->setName('name')->setType(Db_Table_Field::Type_VARCHAR)->setTypeParam(Db_Table_Field::Type_Param_LENGTH,255);
			$field_3 = $table->addField()->setName('title')->setType(Db_Table_Field::Type_VARCHAR)->setTypeParam(Db_Table_Field::Type_Param_LENGTH,255);

			$table->addKey(Db_Table::Key_PRIMARY,array($field_1));


			$table->createTable();

			//add some test fields


			$record1 = array('name'=>'test1-name','title'=>'test1-title');
			$record2 = array('name'=>'test2-name','title'=>'test2-title');

			global $db;
			$db->sqlgen_insert($entity_name,$record1);
			$db->sqlgen_insert($entity_name,$record2);

			// end create table

			if(!file_exists($file_name_form) || !file_exists($file_name_grid)){







				$meta = new SimpleXMLElement("<meta></meta>");
				$meta_elements = $meta->addchild('fields');


				$_entity = new Std_Class();
				$_entity->addElement('id')->setTitle('id');
				$_entity->addElement('name')->setTitle('Name');
				$_entity->addElement('title')->setTitle('Title');




				foreach ($_entity->getElements() as $_field){

					$meta_element = $meta_elements->addChild('field');
					//$meta_element->addAttribute('name','name');
					$name = $_field->getName();
					if($name == 'id') $meta_element->addAttribute('primary_key',1);
					$meta_element->addAttribute('id',$name);
					$title = $_field->getTitle();

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




				file_put_contents($file_name_grid,$xml_string);
				file_put_contents($file_name_form,$xml_string);
			}


			/*end of makeup*/












		}

	}
}


?>