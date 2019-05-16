<?PHP
	
	class Config{
	
		
		var $DbLogin;
		var $DbPassword;
		var $DbName;
		var $DbHost;
		var $Hostname;
		var $DefaultLang;
		
		
		function Config(){
		
			$this->DbLogin = 'root';
			$this->DbPassword = 'root';
			$this->DbName = 'bus_temp';
			$this->DbHost = 'localhost';
			$this->Hostname = 'http://bus';
			$this->DefaultLang = 'en';
					
			
		
		
		}
	
	}


?>