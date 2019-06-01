<?php

class Logic_Ui_Grid_Test extends Ui_Grid {

	public function onInit(){

		parent::onInit();
		$this->setTitle('Test Grid title');
		$this->addFields(array('field1','field2','field3'));
		$rowset = new Rowset();

		//	$rows = new Std_Array();

		//$rows->addElement('test');

		$row1 = array('value1','value2','value3');
		$row2 = array('value1','value2','value3');
		$row2 = array('value1','value2','value3');

		$rows = array();
		$rows[] = $row1;
		$rows[] = $row2;
		$rows[] = $row3;

		
		$buttons = new Ui_Element(Ui_Element::Type_GROUP);
		$buttons->setName('buttons');
		$button_add = new Ui_Element(Ui_Element::Type_BUTTON );
		$button_add->setTitle('Add');
		$button_add->setParam('link','/Accounting/Invoice/Add');
		$buttons->addElement($button_add);
		$this->addElement($buttons);
		
	
		
		$rowset->addRows($rows);
		$this->addData($rowset);

	}

}

?>