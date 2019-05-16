<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007 
You can freely use this file
if you have any questions please visit radmaster.net

*/
require_once('rad_grid_result.php');
class CGrid{

	private $ColumnsNum;
	private $Data;
	/**
	 * Query range object
	 *
	 * @var QueryRange
	 */
	public  $qr; //queryRange object
	public  $XmlDirPath = './data/grid/';
	private $XmlFile;
	private $XmlData;
	public 	$GridId;
	public  $Fields = array();
	public $AdditionalFields = array();
	public $FieldTitleList= array();
	public $GridWidth;
	public $GridAlign;

	private function loadXmlData(){
		$this->XmlFile = $this->GridId.'.xml';
		$Xml = simplexml_load_file($this->XmlDirPath.$this->XmlFile);
		
		if(!$Xml) {
			return false;
			throw new Exception('Error in loading '.$this->XmlDirPath.$this->XmlFile);
		}
		$this->XmlData = $Xml;
		return true;

	}
	public function __construct($GridId = null,$RemoveItemsArray = null){
		global $Db;

		

		if($GridId){
			$this->init($GridId,$RemoveItemsArray);
		}



	}
	public function setPath($Path){
		global $Config;
		$this->XmlDirPath = $Config->SitePath.$Path;
	}

	/**
	 * Add field
	 *
	 * @return GridItem
	 */
	public function addField(){
		
		$obj = new GridItem(null);
		$this->Fields[] = $obj;
		$Header =& $this->FieldTitleList[];
		$Header = array();
		$Header['title'] = '';
		$obj->Header =& $Header['title'];
		
		
		return $obj;
		
	}
	public  function init($GridId = null,$RemoveItemsArray = null){
			global $Db;
				/*@var $qr QueryRange*/
		if($GridId) $this->GridId = $GridId;
		if(!$this->loadXmlData()) return false;

		$qr = $Db->CreateQueryRangeObj();
		$FieldTitleList = array();
		$DefaultOrderField = null;
		if($this->XmlData['width']) $this->GridWidth = (string) $this->XmlData['width'];

		$DefaultOrderField = null;
		if($this->XmlData['align']) $this->GridAlign = (string) $this->XmlData['align'];


		foreach ($this->XmlData->fields->field as $f){
			//print_r($f);

			//echo $f['id'];
			//print_r($RemoveItemsArray);

			//check if field is removed

			if($RemoveItemsArray){
				$ID = (string) $f['id'];
				$Cont = 0;
				foreach ($RemoveItemsArray as &$val){

					if($val == $ID) {
						$Cont = 1;
						break;
					}

				}

				if($Cont) continue;


			}

			$FieldTitle['title'] = (string) @$f->title->en;


			$Field = new GridItem($f);
			if($Field->OrderByFlag){




				$qr->addRange('order',$Field->Table,$Field->ID);
				$FieldTitle['orderby'] = 1;
				$FieldTitle['ID'] = $Field->ID;

			}else {
				$FieldTitle['orderby'] = 0;
			}

			if($Field->Conditions){



				foreach ($Field->Conditions as $Cond)
				$qr->addRange($Field->ID,$Field->Table,null,$Field->VarType,$Cond,null,0,$Field->Title);

			}


			//check is gridItem is visible
			//param is <field isvisible="0">

			$Show = 1;
			if(isset($f['is_visible'])){
				$Show = (int) $f['is_visible'];
			}


			if($Show) array_push($FieldTitleList,$FieldTitle);

			$this->Fields[] = $Field;
			if($Field->OrderByDefault){
				
				$DefaultOrderField = $Field;
			}



		}


		//find default
		if(!$qr->getOrderByArray() && $DefaultOrderField){

			
			
			


			//	$Rez = $this->XmlData->xpath('/grid/fields/field/conditions/condition[@type="orderby" and @default=1]/parent::*');



			//	$Rez = $Rez[0];

			//	if($Rez) $qr->addRange('order',(string) $Rez->orderby['table'],array((string) $Rez['id'],'desc'));
			/*@var $DefaultOrderField GridItem*/
			//	die('d');
			$qr->addRange('order',$DefaultOrderField->Table,array($DefaultOrderField->ID,'desc'));




		}

		$this->FieldTitleList =& $FieldTitleList;

		/*@var $qr QueryRange*/


		$qr->addRange('page');

		$this->qr = $qr;
		//	print_r($qr->AssignedRanges);
		return true;

	}
	private  function addListDataToField($FieldId,$Data){


		//print_r($Data);
		foreach ($this->Fields as &$f){
			//	echo $f->Title;
			/*@var $f GridItem*/
			if($f->ID == $FieldId){
				//die('d');
				$f->addListArray($Data);
			}
		}

	}
	public function removeField($FieldId){
		foreach ($this->Fields as $key=> $f){
			if($f->ID == $FieldId) {
				unset($this->Fields[$key]);
					
				unset($this->FieldTitleList[$key]);
				return ;
				
				
				
				
			}
		}
	}

	public function addListDataToCondition($FieldId,$ConditionId,$Data){


		//return ;
		//print_r($Data);
		foreach ($this->Fields as $f){
			//	echo $f->Title;
			/*@var $f GridItem*/
			
			if($f->ID == $FieldId)
			foreach ($f->Conditions as $c)
			{

				
				/*@var $c GridItemCondition*/
				if($c->ID == $ConditionId){
				
					
					$c->addListArray($Data);
					break 2;
				}
			}
		}

	}
	public function getHTMLUrlParams(){
		global $InOut;

		return $InOut->getObligatoryParamsString();

	}
	/**
	 * Get field object
	 *
	 * @param string $Id
	 * @return GridItem
	 */
	public function getField($Id){
		foreach ($this->Fields as $f){
			if($f->ID == $Id){
				return $f;
			}
		}
	}
	public function &getListHeader(){
		return $this->FieldTitleList;
	}
	private  function addAddionalLink($Title,$Link){

		array_push($this->AdditionalFields,array('title'=>$Title,'link'=>$Link));

	}

	public function addData($Data){

		if(!is_array(@$Data[0]))	{
			Debug('clist object','data is not array');
			return null;
		}


		$this->Data = $Data;


		//echo 	$this->ColumnsNum = count($Data[0]);






	}

	protected function proceedCondition(){


	}
	public function getList(){
		return $this->Data;
	}










}

class GridItem{
	public $ID;
	public $Title;
	public $Link;
	public $Type = 'DbField';
	public $VarType = 'string';
	public $DbField;
	public $LinkParams = array();
	public $OrderByFlag = 0;
	public $Table;
	public $OrderByDefault = false ;
	public $Conditions = array();
	public $ObligatoryParams = false;
	public $ListArray;
	public $ListValueTitle;
	public $ListKeyTitle;
	public $isVisible = 1;
	public $Postfix;

	
	/**
	 * Parent object
	 *
	 * @var CGrid
	 */
	public $_parent;

	function __construct($XmlGridItem,CGrid $Parent = null){

		$this->_parent = $Parent;
		if(!$XmlGridItem) return false;


		$UrlParams = null;
		$this->ID = (string) $XmlGridItem['id'];
		$this->DbField = (string) @$XmlGridItem['db_field'];
		if(@$XmlGridItem->type) $this->Type = (string) $XmlGridItem->type;
		else $this->Type = 'string';
		if(isset($XmlGridItem['isvisible']))	$this->isVisible  = (int) $XmlGridItem['isvisible'];
		$this->Table = (string) $XmlGridItem['table'];

		$this->Postfix = (string) $XmlGridItem->postfix;
		if(@$XmlGridItem->conditions)

		foreach ($XmlGridItem->conditions->condition as $c){

			$Cond  = new GridItemCondition($c);
			//print_r($Cond);
			if($Cond->OrderByFlag){

				$this->OrderByDefault = $Cond->OrderByDefault;
				$this->OrderByFlag = 1;

			}else {
				$this->Conditions[] = $Cond;

			}



		}



		$IncludeObligatoryParams = 0;
		if(@$XmlGridItem->link){





			$XmlCore = new XmlCore();
			$XmlCore->parseXmlLink($XmlGridItem->link);

			$Module = $XmlCore->getModuleTitle();

			$Params = $XmlCore->getUrlLinkParams();
			

			
			$this->LinkParams = $XmlCore->getGridLinkUrlParams();

		
			//print_r($UrlParams);

			$this->ObligatoryParams =  $XmlCore->getLinkParam('ObligatoryParams');
			global $InOut;

			//$InOut->IncludeObligatoryParamsInUrlGeneration = $IncludeObligatoryParams;

			global $InOut;
			$this->Link = $InOut->GenerateFullUrl($Module,$Params,null,null,$UrlParams);



		}

		$this->Title = (string) $XmlGridItem->title->en;
		$this->Type = (string) @$XmlGridItem['type'];
		if(!$this->Type)  $this->Type = 'string';








	}
	public function setLinkParams($fieldTitle,$DataFieldTitle = null ,$Value=null){
		$this->LinkParams[] = array('Title'=>$fieldTitle,'DataField'=>$DataFieldTitle,'Value'=>$Value);
	}


	public function addListArray($Array){
		$this->ListArray =& $Array;
	}

	public function setIsAdditional(){
		$this->Type = 'additional';
	}

	public function setLink($Link){
		$this->Link = $Link;
	}
	public function setTitle($Title){
		$this->Title = $Title;
	}
}
//under construction


class GridSearchCondition{
	
	
	const SearchEq = 'EQ';
	const SearchLike = 'LIKE';
	
	
	const InputAsText = 'text';
	const InputAsList = 'list';
	
	public $FieldId;
	public $Table;
	public $InputType;
	public $Value;
	
	public function __construct($XmlData){
		
		
		
		
		
	}
	
	
	
}


class GridItemCondition{

	public $ID;
	public $Type;
	public $ParentFieldIdId;
	public $ParentFieldIdTitle;
	public $ViewType = 'text';
	public $isVisible = 1;
	public $ListArray = array();
	public $ListValueTitle;
	public $ListKeyTitle;
	public $OrderByFlag = false;
	public $OrderByDefault = false;
	
	
	
	
	function __construct($XmlData){
		
		if($XmlData['id']) $this->ID = (string) $XmlData['id'];
		if((string) $XmlData['view_type'] == 'list'){
			$this->ViewType = 'list';
			$this->ListValueTitle = (string) $XmlData->list->value_title;
			$this->ListKeyTitle = (string) $XmlData->list->key_title;

		}else $this->ViewType = 'text';

		switch ((string) $XmlData['type']){
			case 'orderby':
				
				
				$this->OrderByFlag =1;
				if(@$XmlData['default']){
					
					
					$this->OrderByDefault = true;

				}
				break;


			default:

				$this->Type = (string) $XmlData['type'];
				//if($this->Condition['var_type']) $this->VarType = (string) $this->Condition['var_type'];

				break;

		}



	}
	public function addListArray($Array){
		$this->ListArray =& $Array;
		
	}
}

?>