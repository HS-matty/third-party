<?php

require_once('./classes/core/template.class.php');
require_once('./classes/core/html2pdf/html2fpdf.php');



class View{


	protected  $Lang;
	protected $View;
	protected $SideType;
	protected $SideDir;
	
	
	
	
		


	function __construct($Lang, $SideType,$ViewType = 'common'){
		
		
			
		global $Log;
		global $Db;
		global $Auth;
	
		$this->SideDir[FRONTEND] = 'frontend';
		$this->SideDir[BACKEND] = 'backend';
		


	
	
		$this->Lang = $Lang;
		$this->ViewType = $ViewType;
		$this->SideType = $SideType;
		
	
					


	}


	function GetParsedCode($ModuleId,$PageObject, &$LogicArray = null){

		
				
		$Lang = $this->Lang;
		global $Config;
		//var_dump($LogicArray);
		
		//get availlable modules to view
		
		
			
		//print_r($LogicArray);
		$tmpl = new Template("./tmpl/".$Lang."/".$ModuleId."/".$this->SideDir[$this->SideType]."/".$this->ViewType."/".$PageObject->template);

		
		//foreach data from Logic classes
		if(!empty($LogicArray))
		
		foreach ($LogicArray as $key=> &$val) {
			
			if(!is_array($val)) {
				$tmpl->param($key,$val);
			}
				
				
			
			
				
			else{
								
					foreach ($val as $ArrKey => &$ArrVal) {
						if(is_array($ArrVal)) {
						
							$tmpl->param($key,$val);
							break;
						}
	
						$tmpl->param($ArrKey,$ArrVal);
						

					}

			}

		}
	
		


		//foreach objects params. Modules.xml->module->object->page_params

		foreach ($PageObject->page_params as $Params) {

			foreach ($Params as $key=> $val) {

				if($val->$Lang)
				$tmpl->param('object_title',$val->$Lang);
				//elseif here to add new params
				else $tmpl->param($key,$val);

			}

			//

		}

		
		if(isset($PageObject->name->$Lang)) $tmpl->param('object_title',$PageObject->name->$Lang);
		else  $tmpl->param('object_title',$PageObject->name->en);
		$tmpl->param('lang',$this->Lang);
		
		$tmpl->param('HostName',$Config->Hostname);

	//	var_dump($tmpl);


		$Html =&    $tmpl->parse();
		
		if(!empty($LogicArray['pdf'])) {
		
			
		
		
			$pdf = new HTML2FPDF();
			$pdf->AddPage();
			$pdf->WriteHTML($Html);
			$pdf->Output('ticket.pdf','I');
			return 0;
			
			
		}


		return  $Html;

	}


}

?>