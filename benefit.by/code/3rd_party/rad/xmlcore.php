<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007 
You can freely use this file
if you have any questions please visit www.radmaster.net

*/

class XmlCore{
	private  $LinkData = array();

	public function &getLinkParam($ParamName){
		$Var =  @$this->LinkData[$ParamName];
		return $Var;
	}
	public function getModuleTitle(){
		return $this->getLinkParam('Module');
	}
	public function &getGridLinkUrlParams(){
		return $this->getLinkParam('GridLinkUrlParams');
	}
	public function &getInOutLinkUrlParams(){
		return $this->getLinkParam('InOutLinkUrlParams');
	}
	public function &getUrlLinkParams(){
		return $this->getLinkParam('LinkParams');
	}
	public function generateLink(){
		global $InOut;
		
		return $InOut->GenerateFullUrl($this->getModuleTitle(),$this->getUrlLinkParams(),null,null,$this->getInOutLinkUrlParams(),null,false);
	}
	public function parseXmlLink(SimpleXMLElement $Link){
		$Module  = (string) $Link->module;
		$this->LinkData['Module'] = $Module;
		$this->LinkData['GridLinkUrlParams'] = array();
		$this->LinkData['InOutLinkUrlParams'] = array();
		$this->LinkData['LinkParams'] = array();
		if($Link['includeObligatoryParams']) {
			//$IncludeObligatoryParams = 1;
			$this->LinkData['ObligatoryParams'] = (int) $Link['includeObligatoryParams']; ;
		}
		foreach ($Link->params->param as $p){

			array_push($this->LinkData['LinkParams'],((string)$p['value']));


		}
		
		if ($Link->urlparams->param) {
			foreach ($Link->urlparams->param as $up){
	
				
				 $Title = (string) @$up['title'];
				$Value = (string) @$up['value'];
				
				$DataField = (string) @$up['data_field'];
	
				array_push($this->LinkData['GridLinkUrlParams'],array('Title'=>$Title,'Value'=>$Value,'DataField'=>$DataField));
				$this->LinkData['InOutLinkUrlParams'][$Title] = $Value;
	
	
			}
		}
		


	}

}
?>