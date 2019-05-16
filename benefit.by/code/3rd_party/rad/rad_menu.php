<?php

class Rad_Menu{
	protected $Menu = array();

	public function addMainMenuItem($Title,Rad_Link $Link){

	}

	public function addActionMenuItem($Title,Rad_Link $Link){
		$this->addMenuItem(1,$Title,$Link);

	}

	protected function addMenuItem($Level,$Title,Rad_Link $Link){
		if(!is_array($this->Menu[$Level]))  $this->Menu[$Level] = array();

		$MenuItem['title'] = $Title;
		$MenuItem['link'] =  $Link;
		$this->Menu[$Level][] = $MenuItem;
	}
	public function getActionsMenu()
	{
		return $this->Menu[1];
	}
}
class Rad_Link{
	protected $Link;
	public function __construct($Params,$UrlPararms = null){
		global $Config;
		$Link = $Config->Hostname.'/';
		if($Params) {
			
			foreach ($Params as $p){

				$Link .= $p.'/';
			}
		}

		if($UrlPararms) {
			$Link .= '?';
			foreach ($UrlPararms AS $key=>$val){
				$Link .= "$key=$val&";
			}
		}


		$this->Link = $Link;
	}
	public function __toString(){
		return $this->Link;
	}
	public function get(){
		return $this->Link;
	}
}



?>