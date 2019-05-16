<?php
class Rad_UI_Field_Params{
	public $Id;
	public $Title;
	private  $Type;
	public $IsNull = false;
	public $Value = null;
	public $EnumValues = null;
	public $Xml;

	public function setType($Type){
		$this->Type = $Type;

	}
	public function getType(){
		return $this->Type;
	}
	public function setTitle($Title){
		if(is_object($Title)){
			global $InOut;
			$TitleStr = (string) $Title->{$InOut->Lang};
			if(!$TitleStr)
			{
				
				$TitleStr= (string) $Title->en;
			}
		}else $TitleStr = $Title;
		$this->Title = $TitleStr;
	}
}
?>