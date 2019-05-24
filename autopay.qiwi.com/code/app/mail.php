<?php


class App_Mail extends App_Default{
	
	
	
	function run($params = null){

		
		$request = Registry::get('request');
		
		$page = Registry::get('page');
		
		
		
		$request_param = $request->getLastElement();
		
		if($request_param->hasElements()){
			
			
			
		}
		$request_param_string = (string) $request_param;
		switch ($request_param_string){
			
			case 'inbox':
			
				
					$page->console->addElement()->setValue('test ...');
			
				
				break;
				
			
		}
		
		
		
	}
	
	
	
	

}

?>