<?php
/*
Radmaster Framework 3.0 beta
radmaster.net
Sergey Volchek 1999-2012
*/

class Log  extends Std_Class  {



	const Type_GLOBAL = 'global';
	const Type_SQL = 'sql';

	public  $_level = 1;



	public function addMessage($message, $type = 'global',$add_debug_params = true){



		$var_name = '_messages_'.$type;
		
		if(!$this->$var_name) $this->$var_name = new Element();

		if($add_debug_params){
			$now = date("j.n.Y - H:i");
			$message = $now.' >> '.$message;

		}

		$this->$var_name->addElement()->setValue($message);




	}



	public function &getMessageList($type = 'global'){
		
		$var_name = _messages.'_'.$type;
		return $this->$var_name;
	}

	public function getDebugLevel(){
		return $this->_level;
	}

	public function setDebugLevel($level){
		$this->_level = $level;
	}



}

?>