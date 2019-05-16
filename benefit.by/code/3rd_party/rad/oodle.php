<?php


class Rad_Oodle_Integration{


	public function getItems($Cid =null, $StartTime = 0,$EndTime = 0,$StartIndex = 0,$EndIndex = 0){

		$oodleApi = new OodleApi();

		$sort = array();
		$sort['key'] = 'create_time';

		$Filters = array();
		if($StartTime && $EndTime){
			
			$Filters[0]['type'] = 'create_time';
			$Filters[0]['params']['low'] = $StartTime;
			$Filters[0]['params']['high'] = $EndTime;
			
		}

		// prepare a "get()" method call to the Oodle API
		$method = 'get';
		$params = array(
		'region' => 'sf',
		'q'      => '',
		'sort' => $sort,
		'filters'=>$Filters
		//'id'=> 327003660
		
		);
		if($StartIndex && $EndIndex){
			$params['from'] = $StartIndex;
			$params['to'] = $EndIndex;
			
		}

		
		if($Cid){
			$DirectoryTree = new DirectoryTree();
			$Category =& $DirectoryTree->getCategory($Cid);
			$params['category']= $Category['oodle_path'];
			
		}
		
	

		// make the request
		 $Items = $oodleApi->make_request($method,$params);
	
		 
		return $Items;
		 
		 

		// use PHP's "print_r" to dump the entire data structure we got back


	}
	
	
	

}
?>