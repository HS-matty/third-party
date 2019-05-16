<?PHP
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/


class Config{

	var $DbLogin;
	var $DbPassword;
	var $DbName;
	var $DbHost;
	var $Hostname;
	var $DefaultLang;
	var $SitePath;
	var $GmapKey;

	function Config(){


		$this->DbLogin = 'root';
		$this->DbPassword = '';
		$this->DbName = 'benefit';
		$this->DbHost = 'localhost';
		$this->Hostname = 'http://' . $_SERVER['HTTP_HOST'];
		$this->DefaultLang = 'en';
		$this->SitePath = 'z:/home/benefitby/www';
	
	}


	//if($data) split($data)



}


?>