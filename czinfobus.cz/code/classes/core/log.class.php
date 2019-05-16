<?php


//defing log levels
define("STU",0);
define("INFO",1);
define("WARNING",2);
define("FATAL",3);



class CLog{

	/**
	* @return CLog
	* @desc Логгируем все.
	*/
	var $Message;
	var $Level;
	var $PreferedLevel;
	function CLog($PreferedLevel = 0){

		$this->PreferedLevel = $PreferedLevel;
		//$this->DoLogging("<b>Loggin' started....</b>",INFO);
		

	}
	function FileLog($FileName,$Message){
		
		$Path = "d:\\work\\root\\bus\\www\\logs1234\\";
		
		$today = date("j.n.Y - H:i"); 
		
		$Message = "$today : $Message\n";
		$handle = fopen($Path.$FileName, 'a');
//		if($handle) fwrite($handle,$Message);
				 
	
	}
	function DoLogging($Message, $Level = STU){
		$this->PreferedLevel = FATAL;
		$this->Message = $Message;
		$this->Level = $Level;

		if($this->Message){

			if($this->Level >= $this->PreferedLevel)
			switch ($this->Level){

				case STU:
				print("$this->Message, [stupid level]<br>");
				break;
				case INFO:
				print("$this->Message, [info level]<br>");
				break;
				case WARNING:
				print("$this->Message, [warning level]<br>");
				break;
				case FATAL:
				print("$this->Message, <font color='red'>[FATAL level!]</font><br>");
				break;
				default:
				print("$this->Message, <font color='red'>[UNKNOWN level!]</font><br>");
				break;



			}

		}




	}


}

?>