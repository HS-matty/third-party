<?php

class Logic_Datasource_App_Market_Offer_Curl extends Datasource_Curl  {

	
	public $_title_xpath = '';
	
	
	public function onInit(){


		parent::onInit();


		/*$fields = array ( 0 => 'id', 1 => 'market_product_id', 2 => 'name', 3 => 'title', 4 => 'description', 5 => 'link_preview', 6 => 'category', 7 => 'payout', 8 => 'payout_type', 9 => 'clicks', 10 => 'conversions' );
		$this->setFields($fields);*/
		//$table_name = $this->getName();

		//$api_key = '8523fcd75c8276d7b9ed3fdfa5a4d24cb1fb2b8d';
		$api_key = '3794e647fab983856aeacc6d61c24c090f2c69df';
		
		$this->setName('affise-com');

		$request = $this->addRequest();

		$request->setBaseUrl('http://api.cpatoday.affise.com/2.1')->setQueryString('/offers');
		$request->setHeader('API-Key',$api_key);
		//3794e647fab983856aeacc6d61c24c090f2c69df


	}


	
	public function fetchRows(){
		throw new Exception('not implemented');
	}

	

	public function __fetchData($query_params = null,$type = 'array'){

		
		
		$this->query();
		
		$request = $this->getRequest();
		$response = $this->getResponse();


		$url = $request->getUrl();
		//	echo ("url: {$url}");

		$response_string = $response->getResponseString();


		//echo $request_string;

		//$data = json_decode($response_string,true);
		return $response_array =  $response->getResponseArray();

		//print_r($data);
		//exit();
		//$xml = simplexml_load_file('D:\default.xml');
		
		$xml = array2xml($response_array);
		
		
		$xml_path_rows = 'offers->element';
		
		/*$_xml = $xml->xpath("//offers/element");
		print_r($_xml);
		exit();*/
		
		//echo $xml->offers->element[0]->asXml();
		
		//foreach ($xml->$xml_path_rows as $row){
		foreach ($xml->xpath("//offers/element") as $row){
			echo $row->title.'<br><br>';;
			
		}
		
		file_put_contents('d:\data.xml',$xml->asXml());
		
		//print_r($xml);
		exit();
		
		//$category =  ($data['offers'][0]['full_categories'][0]['title']);
		


	}


}


?>