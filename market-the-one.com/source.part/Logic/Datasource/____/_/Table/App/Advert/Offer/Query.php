<?php
class Logic_Datasource_App_Advert_Offer_Query extends Datasource_Query {



	
	
	
	public function onInit(){


		parent::onInit();
		
		//$dependency = new Dependency();
		

		
		$dependency = new Db_Table_Dependency();
		
		//$table_1 = new Logic_Datasource_App_Advert_Offer_Table();
		
		$dependency->setCenterElement($table_1);
		
		//$table_2 = new
		


	}
	
	
		/**
	 * Enter description here...
	 *
	 * @return Db_Query_Select
	 */
	public function setQuery(Db_Query $query){
		$this->_query = $query;
		return $query;
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @return Db_Query_Select
	 */
	public function getQuery(){
		return $this->_query;
	}
	
	/**
	 * ...
	 *
	 * @param array $params
	 * @return Datasource_Table
	 */
	public function fetchRows($query_params = null,$type = 'array'){

		$query = new Db_Query_Select();


		if($this->_fields){
			foreach ($this->_fields as $field_name){

				$query->addWhat($field_name,$this->getName());

			}


		}
		else $query->addWhat('*',$this->getName());


		$query->addFrom($this->getName());
		if($params['limit']) $query->addLimit((int) $params['limit'] );

		if($query_params) {
			$where = $query->addWhereGroup();

			foreach ($query_params as $param_name => $param_value){

				$where->add($param_name,$param_value);
			}

		}



		/*@var $db Db_Adapter */

		//$sql = $query->getSqlString();
		$this->_db_adapter->performQuery($query);

		return $this;


	}


}



class Dependency_Element extends Std_Class {
	
	
}

?>