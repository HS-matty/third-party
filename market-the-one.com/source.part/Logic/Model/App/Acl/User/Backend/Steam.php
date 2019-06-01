<?php

class Logic_Model_User_Steam extends Logic_Model_User{
	
	
	public function auth_by_steam_id($steam_id){

		$return_flag = false;
		$this->_data = $this->_datasource->fetchRow(array('steam_id'=>$steam_id));
		if(!empty($this->_data)){

			$this->setVarsFromArray($this->_data);
		}

		if($this->id){

			$return_flag = true;

		}

		return $return_flag;


		//array($form_data['email'],$form_data['password'])

	}
}

?>