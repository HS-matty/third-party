<?php



$config  = Registry::get('config');

$db = new Std_Class('db');
$config->addParam('db',$db);
$db->host_name = 'localhost';
$db->login = 'root';
$db->password = '';
$db->name  = '_prj';




?>