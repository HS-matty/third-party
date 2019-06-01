<?php

class  App_Market_Offer_Ui_Grid extends  Ui_Grid {

	public function onInit(){

		parent::onInit();


		UI::loadUiElement('/ui/App/Market/@Grid/offers.xml',$this);
		


	}
}



function App_Market_Offer_Ui_Grid_onLoad(){


	$grid = ui::getCurrentUiElement();

	

	//$datasource =  new Datasource_Table('advert_offers');
	
	//$datasource = new Logic_Datasource_App_Advert_Offer_Table();
	//$datasource = new Logic_Datasource_App_Advert_Product_Table();

	//	$query_params = Registry::get('query_params');

	$datasource = new Logic_Datasource_App_Market_Offer_Query_Select();
	$rowset = $datasource->fetchRows()->getRowset();
		
/*	$rowset = $datasource->fetchRows()->getRowset();
	
	print_r($rowset->getData());
	
	exit();*/
	
	//print_r($rowset);
	//exit();
	//$rowset = new Rowset();
	//$rowset->addRows($rows);


	$buttons = new Ui_Element(Ui_Element::Type_GROUP);
	$buttons->setName('buttons');

	$button_add = new Ui_Element(Ui_Element::Type_BUTTON );
	$button_add->setTitle('Add');
	$button_add->setParam('link','/app/Market/Offer/Add');
	$buttons->addElement($button_add);
	$grid->addElement($buttons);
	
	$grid->setParam('primary_key_name','market_offer_id');

	$grid->addData($rowset);
	



}

?>