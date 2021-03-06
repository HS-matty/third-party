<?php
class Logic_Datasource_App_Market_Offer_Query_Select extends Datasource_Query_Select  {



	public function onInit(){


		parent::onInit();

		//$dependency = new Dependency();




		$query = new Db_Query_Select();
		$this->setQuery($query);


		//$dependency = new Db_Table_Dependency();

		$table = new Logic_Datasource_App_Market_Offer_Table();
		$table_2 = new Logic_Datasource_App_Market_Product_Table();

		$table_3 = new Logic_Datasource_App_Market_Aggregator_Table();

		$this->addTable($table);
		
		$this->addTable($table_2);
		$this->addTable($table_3);



		$dependency = new Db_Table_Dependency();
		$dependency->setType(Db_Table_Dependency::Type_Db_Table_Dependency_Inner);
		//$dependency->setDependencyElement($table_2);

		$dependency->setDependencyPrimaryElement($table);
		$dependency->addDependencySecondaryElement($table_2);
		$this->addDependency($dependency);

		$dependency_2 = new Db_Table_Dependency();
		$dependency_2->setType(Db_Table_Dependency::Type_Db_Table_Dependency_Inner);
		//$dependency->setDependencyElement($table_2);

		$dependency_2->setDependencyPrimaryElement($table);
		$dependency_2->addDependencySecondaryElement($table_3);
		$this->addDependency($dependency_2);
		
		
		
		$this->prepareQuery();
		

		//$this->setTable($table);

	}






	


}





?>