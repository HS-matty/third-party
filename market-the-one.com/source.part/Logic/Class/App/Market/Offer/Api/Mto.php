<?php

//market the one api

class Logic_Class_App_Market_Offer_Api_Mto extends  Logic_Class_App_Market_Offer{
	
	
	public $_prefix = 'mto';
	
	public $_fields = array(
		'market_offer_id'=>'offer_id',
		//'market_offer_status'=>'offer_status',
		'market_offer_revenue_value'=>'offer_revenue_value', // -10%
		'market_offer_revenue_type'=>'offer_revenue_type', // -10%
		'market_offer_revenue_currency'=>'offer_revenue_currency', // -10%
		//'market_offer_payout_type'=>'offer_payout_type',
		//'market_offer_expiration_date'=>'expiration_date',
		//'market_offer_restriction'=>'restrictions',
		'mto_tracking_url'=>'offer_tracking_url', // +mto
		//'product_id'=>'market_product_id',
		'market_product_name'=>'product_name',
		'market_product_description'=>'product_description',
		'market_product_type'=>'product_type', //no-incent | incent
		'market_product_platform'=>'product_platform',
		'market_product_country'=>'product_country',
		'market_product_preview_url'=>'product_preview_url',
		'product_tags'=>'product_tag',
		//'market_category_id',
		'market_category_name'=>'product_category_name',
		);
	
	
	public function onInit(){
		parent::onInit();
	}
	
	
	
	public function getDataFieldsFilter(){
		
		//$this->getModel()->getData();
	}
	
	public function market_offer_revenue_value($key,$value,$array){
		
		//-10%
		$value_10_percent = $array[$key] / 100 * 10;
		$new_value = $array[$key] - $value_10_percent;
		return $new_value;
		
	}
	public function mto_tracking_url($key,$val,$array){
		
		/*@var Logic_Class_User $user*/
		$user = Registry::get('user');
		
		
		if(!$user_id = $user->getId()) throw new Exception_Application('user_id not set:' .$this->getCurrentClassName() );;
		
		return $mto_tracking_url = HOST_NAME.'/redirect/offer/?mto_offer_id='.$array['market_offer_id'].'&partner_id='.$user_id;
		
		//http://market-the-one.com/redirect/offer/?mto_offer_id=1&partner_id=1&hash={hash} //  adds by partner &partner_click_id={id click}&partner_click_id={source id)
		
	}
	
	public function filterFieldsRows($rows_array){
		
	
		$new_rows = array();
		foreach ($rows_array as $row) {
			$new_rows[] = $this->filterFields($row);
		}
		
		return $new_rows;
		
	}
	
	public function filterFields($array){
		
		$new_array = array();
		
		foreach ($this->getFields() as $key => $val){
			
			if(@$array[$key]){
				
				$new_array[$val] = $array[$key];
				
			}else $new_array[$val] = '';;
			
			
			if (method_exists($this,$key)){
				
				$new_array[$val] = $this->$key($key,$val,$array);
			
			}
						
			
		}
		
		return $new_array;
		
	}
	
	
	
	
	
	
	



}

?>