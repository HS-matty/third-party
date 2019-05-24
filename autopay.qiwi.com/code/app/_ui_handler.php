<?php


function _handle_ui(){
	/* @var $db Db*/
	$inout = Registry::get('inout');
	$page = Registry::get('page');
	
		
	$page_number = (int) $inout->getParam('page');
	
	
	$rows_per_page = 30;
	
	$order_by = $inout->getParam('order_by');
	
	if(!ereg("[a-zA-Z\_\-].",$order_by)) $order_by = null;
	
	
	
	
	
	$direction_arr = array('asc','desc');
	$direction = $inout->getParam('direction');
	
	if(!in_array($direction,$direction_arr)) $direction = $direction_arr[0];
	
	if($direction == 'asc') $new_direction = 'desc';
	else $new_direction = 'asc';
	
	$page->addParam('next_direction',$new_direction);
	
	
	
	//CAST(COL as SIGNED)
	
	
	$query_params = new Element('query_params');
	$query_params->setParam('order_by',$order_by);
	$limit = new Element('limit');
	$limit->setParam('start',$page_number * $rows_per_page);
	$limit->setParam('rows_number',$rows_per_page);
	$query_params->setParam('limit',$limit);
	$query_params->setParam('direction',$direction);
	
	registry::set('query_params',$query_params);	
	
	$page->addParam('order_by',$order_by);
	$page->addParam('direction',$direction);
	$page->addParam('page_number',$page_number);
	$page->addParam('rows_per_page',$rows_per_page);
	$page->addParam('current_page',$page_number);
	
	
	
}

?>