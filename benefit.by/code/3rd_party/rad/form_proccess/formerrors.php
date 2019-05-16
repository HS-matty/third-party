<?php
	
	class FormErrors{
	private $XmlDirPath = '/data/formparser/';
	private $XmlFile;
	private $XmlFieldClassesFile = 'field_classes.xml';
	private $XmlErrorFile = 'errors.xml';
	private function LoadErrorsFile(){


		$Xml = simplexml_load_file($this->XmlDirPath.$this->XmlErrorFile);
		if(!$Xml) throw new Exception('Error in loading '.$this->XmlDirPath.$this->XmlErrorFile);
		$this->FormErrors = $Xml;
		//	print_r($Xml);


	}


}

	
	?>