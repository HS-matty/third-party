<?php
	
$routes = array(
'post-application'=>array('app_type'=>'user','app_name'=>'job','app_action'=>'post-application'),
'login'=>array('app_type'=>'system','app_name'=>'auth','app_action'=>'login'),
'logout'=>array('app_type'=>'system','app_name'=>'auth','app_action'=>'logout'),
'cp'=>array('app_type'=>'system','app_name'=>'cp','app_action'=>'index'),
	

'register'=>array('app_type'=>'system','app_name'=>'auth','app_action'=>'register'),
'article'=>array('app_type'=>'system','app_name'=>'content','app_action'=>'article'),
'view-application-list'=>array('app_type'=>'user','app_name'=>'job','app_action'=>'view-application-list')
);
	
?>