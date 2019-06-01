<?php
class Logic_Datasource_App_Market_Stats_Log_Query_Select extends Datasource_Query_Select  {



	public function onInit(){


		parent::onInit();

		//$dependency = new Dependency();




		$query = new Db_Query_Select();
		$this->setQuery($query);


		//$dependency = new Db_Table_Dependency();

		$primary_table =  new Logic_Datasource_App_Market_Stats_Log_Table();;
		
		$table_2 =new Logic_Datasource_App_Market_Offer_Table();
		
		
		
		
		$this->addTable($primary_table);
		$this->addTable($table_2);
		

		
		$dependency = new Db_Table_Dependency();
		$dependency->setType(Db_Table_Dependency::Type_Db_Table_Dependency_Inner);
		//$dependency->setDependencyElement($table_2);

		$dependency->setDependencyPrimaryElement($primary_table);
		$dependency->addDependencySecondaryElement($table_2);
		
		$dependency->setParam('primary_table_join_key','entity_id');
		$dependency->setParam('secondary_table_join_key','id');
		
		$this->addDependency($dependency);

		
		
		
		$table_3 = new Logic_Datasource_App_Market_Product_Table();
		
		$this->addTable($table_3);
		
		$dependency_2 = new Db_Table_Dependency();
		$dependency_2->setDependencyPrimaryElement($table_2);
		$dependency_2->addDependencySecondaryElement($table_3);
		
		$this->addDependency($dependency_2);
		
		
		
		
		$table_4 = new Logic_Datasource_App_Acl_User_Table();
		$this->addTable($table_4);
		
		
		$dependency_3 = new Db_Table_Dependency();
		$dependency_3->setDependencyPrimaryElement($primary_table);
		$dependency_3->addDependencySecondaryElement($table_4);
		
		$this->addDependency($dependency_3);
		
		
		
		
		/*$table_3 = new Logic_Datasource_
		
		$this->addTable($table_3);
		
		$dependency_2 = new Db_Table_Dependency();
		$dependency_2->setDependencyPrimaryElement($table_2);
		$dependency_2->addDependencySecondaryElement($table_3);
		
		$this->addDependency($dependency_2);*/
		
		
		
/*		$dependency_2 = new Db_Table_Dependency();
		$dependency_2->setType(Db_Table_Dependency::Type_Db_Table_Dependency_Inner);
		//$dependency->setDependencyElement($table_2);

		$dependency_2->setDependencyPrimaryElement($primary_table);
		$dependency_2->addDependencySecondaryElement($table_3);
		$this->addDependency($dependency_2);
		
		
		
		$dependency_3 = new Db_Table_Dependency();
		$dependency_3->setType(Db_Table_Dependency::Type_Db_Table_Dependency_Inner);
		
		$dependency_2->setDependencyPrimaryElement($primary_table);
		$dependency_2->addDependencySecondaryElement($table_4);
		
		$this->addDependency($dependency_3);
		$this->prepareQuery();
		*/

		//$this->setTable($table);

		$this->prepareQuery();
	}






	


}





?>