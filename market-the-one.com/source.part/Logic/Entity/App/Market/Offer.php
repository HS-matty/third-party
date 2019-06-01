<?php

class Logic_Entity_Offer extends Logic_Entity {

	
	public $_fields = array(
		'market_offer_id','market_offer_status','market_offer_payout','market_offer_payout_type','market_offer_expiration_date','market_offer_restriction','market_tracking_url',
		'market_product_id','market_product_name','market_product_description','market_product_type','market_product_platform','market_product_country','market_product_preview_url','market_product_tag',
		'market_category_id','market_category_name'
		);
	
		
	

	public function onInit(){
		
		$this->setClass(new Logic_Class_App_Market_Offer());
		return $this;
		
	}
	
	
	
	
	
	
	






}



?>