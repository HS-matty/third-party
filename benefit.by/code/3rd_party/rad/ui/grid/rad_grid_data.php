<?php

class Rad_Grid_Data{
	
	
	protected $XmlFieldName = '';
	public function setXmlFieldnName($Name){
		$this->XmlFieldName = $Name;
	}

	protected $Items = array();

	public function getItems(){
		return $this->Items;
	}
	public function init($Data){
		foreach ($Data as &$val){
			$obj = new Rad_Grid_Data_Item();
			if($this->XmlFieldName) $obj->setXmlFieldnName($this->XmlFieldName);
			$obj->init($val);
			$this->Items[] = $obj;
		}



	}


}


class Rad_UI_Item{

}
class Rad_Grid_Data_Item extends Rad_UI_Item {

	protected $XmlFieldName = '';
	public function setXmlFieldnName($Name){
		$this->XmlFieldName = $Name;

	}

	protected $Data;

	public function init($Data){
		$this->Data = $Data;
		
		if($this->XmlFieldName && isset($this->Data[$this->XmlFieldName])){
		
			$Items = Rad_Xml::getFieldsFromXml($this->Data[$this->XmlFieldName]);
			if($Items) $this->Data = array_merge($this->Data,$Items);
			
		}

	}

	public function getContent($id){

	}


}
?>