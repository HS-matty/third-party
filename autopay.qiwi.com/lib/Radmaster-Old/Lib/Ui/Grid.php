<?php
/*
radmaster library 2.3
Sergey Volchek 2003-2013
radmaster.net

*/


class Ui_Grid extends Ui_Element {
	
	
	public function onInit(){
		
		$this->setType(Ui_Element::Type_GRID );
	}
	
	public function addData($rowset){

		
		$this->addElement('data')->addElement($rowset)->setName('rowset');
		
	}

	
	

}


//under construction





?>