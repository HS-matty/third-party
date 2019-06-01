<?php
class Logic_Datasource_App_Market_Product_Query_Select extends Datasource_Query_Select  {



	public function onInit(){


		parent::onInit();

		//$dependency = new Dependency();




		$query = new Db_Query_Select();
		$this->setQuery($query);


		//$dependency = new Db_Table_Dependency();

		$table = new Logic_Datasource_App_Market_Offer_Table();
		$table_2 = new Logic_Datasource_App_Market_Product_Table();


		$this->addTable($table);
		$this->addTable($table_2);



		$dependency = new Db_Table_Dependency();
		$dependency->setType(Db_Table_Dependency::Type_Db_Table_Dependency_Inner);
		//$dependency->setDependencyElement($table_2);

		$dependency->setDependencyPrimaryElement($table);
		$dependency->addDependencySecondaryElement($table_2);
		$this->addDependency($dependency);


		$this->prepareQuery();
		

		//$this->setTable($table);

	}






	


}





?>