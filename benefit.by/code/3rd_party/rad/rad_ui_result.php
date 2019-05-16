<?php


abstract class Rad_Ui_Result{
	public $isSuccess;
	
	public $_uiObject;
	abstract public function set_uiObject($obj);
	
}
?>