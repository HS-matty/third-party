<?php


class Rad_Grid_Result extends Rad_Ui_Result {



	public $isSuccess;
	/**
	 * Form object
	 *
	 * @var Cgrid
	 */
	public $_uiObject;
	public function set_uiObject($obj){
		$this->_uiObject = $obj;
	}
}


class Rad_Grid_Params extends Rad_UI_Params {
	
}

?>