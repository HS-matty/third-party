<?php
	
	class FieldDatasource{

	public $Link;
	public $Type;
	public $XmlDataSource;

	function __construct(SimpleXMLElement $Datasource){


		$this->XmlDataSource= $Datasource;
		switch ((string)$Datasource['type']){
			case 'popup':
				$XmlCore = new XmlCore();
				//$XmlCore-

				$XmlCore->parseXmlLink($Datasource->link);
				$this->Link = $XmlCore->generateLink();
				$this->type = (string)$Datasource['type'];



				break;

		}
	}
	public function reCalculate(){
		$this->__construct($this->XmlDataSource);
	}
	

}
	?>