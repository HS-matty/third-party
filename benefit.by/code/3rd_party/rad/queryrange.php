<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007 
You can freely use this file
if you have any questions please visit www.radmaster.net

*/

class QueryRange{

	private   $Ranges = array();
	public  $XMLAssignedRanges = array();
	private $AltRangesValues = array();
	private $Limit = array();
	public $TotalRows = 0;

	public $TotalPages = 0;

	public  $RowsPerPage = 30;
	public $PageIndex;

	private $OrderByArray = array();

	public function getRowsPerPage(){
		return $this->RowsPerPage;
	}


	public function getLastIndex(){
		
		if($tp = $this->getTotalPages()) return $tp-1;
		return 0;
		
	}
	public function assignRange($Id,$Title,GridItemCondition $Condition){
		
		$Condition->ParentFieldId = $Id;
		$Condition->ParentFieldTitle = $Title;
		
		$this->XMLAssignedRanges[] = $Condition;
		//print_r($Condition->ListArray);
		


	}
	public function &getXMLAssignedRanges(){
		return $this->XMLAssignedRanges;
	}

	/**
	 * Returns Ranges in the GET format, like 'id=2&name=test'
	 *
	 * @return string
	 */
	public function getHTMLRanges(){

		//print_r($this->Ranges);
		$HtmlRanges = '';

		foreach ($this->Ranges as $key => &$val){
				
				$HtmlRanges .= "$val[Title]={$val['Value']}&";
				

		}
		$Order = $this->getOrderByArray();
		if($Order){
			foreach ($Order as &$ord){

				$HtmlRanges .= "order={$ord['OrderBy']}&direction={$ord['Direction']}&";

			}
		}
		return $HtmlRanges;

	}
	/**
	 * Add alternative ranges values. Expl: you want to get date field divided into day, month, year,
	 * so this params are normally parsing into something like '01-01-2005', but you need your month, day
	 * back to page to show user's choice. 
	 * @param string $Title
	 * @param string $Value
	 */
	public function addAltHTMLValue($Title,$Value){
		$this->AltRangesValues[$Title] = $Value;

	}
	private function  getAltHTMLValue($ItemTitle){
		if(isset($this->AltRangesValues[$ItemTitle])) return $this->AltRangesValues[$ItemTitle];
		return null;

	}
	public function getHTMLvalue($ItemTitle){
		//if(isset($this->Ranges[$ItemTitle])) return $this->Ranges[$ItemTitle]['Value'];
		$this->resetRanges();

		while ($item =& $this->getRangeNextItem()){
			if($item['Title'] == $ItemTitle){
				return $item['Value'];
			}

		}

		return $this->getAltHTMLValue($ItemTitle);

	}
	public  function resetRanges(){
		reset($this->Ranges);
	}

	public function &getOrderByArray(){
		
		return $this->OrderByArray;
	}
	/**
	 * Puts ORDER by $Table.$OrderBy $Direction to the SELECT statement 
	 *
	 * @param 'string' $OrderBy 
	 * @param 'string' $Table
	 * @param 'string' $Direction 'asc','desc'
	 */
	public function AddOrderByElement($OrderBy,$Table,$Direction = 'asc',$Default = 0){
		$Direction = strtolower($Direction);
		if($Direction != 'asc' && $Direction != 'desc' ) $Direction = 'asc';
		$Arr['Direction'] = $Direction;
		$Arr['OrderBy'] = $OrderBy;
		$Arr['Table'] = (string) $Table;
		$Arr['Default'] = $Default;
		array_push($this->OrderByArray,$Arr);
		


	}
	public function clear(){
		
		$this->TotalRows = null;
		$this->TotalPages = null;
		
	}
	public function setRowsPerPage($Rows){
		$this->RowsPerPage = $Rows;
	}
	/**
	 * Add Page index to the SELECT statement into LIMIT clause
	 * corresponding with $this->RowsPerPage value
	 *
	 * @param int $PageIndex
	 */
	public function addPageRange($PageIndex){


		
	 (int) $Start = $this->RowsPerPage * $PageIndex;
	$this->addLimit($Start,$Start + $this->RowsPerPage);
	$this->PageIndex = $PageIndex;



	}
	public function getTotalPages(){
		return ceil($this->TotalRows / $this->RowsPerPage);
	}

	public function setTolalRows($Rows){
		$this->TotalRows = $Rows;
	}
	public function getTotalRows(){
		return $this->TotalRows;
	}
	public function getCurrentPageRowsIndexStart(){
		return $this->getRowsPerPage()*$this->PageIndex+1;
		
	}
	public function getCurrentPageRowsIndexEnd(){
		

		$Val = $this->getRowsPerPage()*$this->PageIndex+$this->getRowsPerPage();
		if($Val > $this->getTotalRows()) return $this->getTotalRows();
		return $Val;
		
		
	}
	public function getLastRows($Number){
		
		
		
		
	}


	//dismissed

	/*	public function &getRangesArray(){
	return $this->Ranges;
	}

	*/
	/**
	 * Add LIMIT $Start, $End to the SELECT statement
	 *
	 * @param int $Start
	 * @param int $End
	 */
	public function addLimit( $Start, $End){
		$Start = (int) $Start;
		$End = (int) $End;
		$this->Limit['start']= $Start;
		$this->Limit['end'] = $End;


	}
	public function getLimitStart(){
		
		return @$this->Limit['start'];
	}
	public function getLimitEnd(){
		return @$this->Limit['end'];
	}

	public function getLimitSql(){
		// $dd = "LIMIT {$this->getLimitStart()}, {$this->RowsPerPage}";
		if($this->getLimitEnd())	return " LIMIT {$this->getLimitStart()}, {$this->RowsPerPage} ";
		//echo $dd;

	}

	public function assingLimitToQuery(RadDbQuery $Query){
		
		if($this->getLimitEnd()) $Query->addLimit($this->RowsPerPage,$this->getLimitStart());
		
	}
	
	/**
	 * Methdod parses start_date (start_year,start_month,start_day), end_date (end_year,end_month,end_day) 
	 * from GET AND POST  and put it to $qr (QueryRange) WHERE clause corresponding with FieldTitle and FieldTable
	 *
	 * @param string $FieldTitle
	 * @param string $FieldTable
	 */
	public function addStartEndDateRange($FieldTitle,$FieldTable){

		$StartYear  = (int) $this->getRangeFromGetPost('start_year');
		$StartMonth  = (int) $this->getRangeFromGetPost('start_month');
		$StartDay  = (int) $this->getRangeFromGetPost('start_day');
		$StartDate = null;
		if($StartDay && $StartMonth && $StartYear){
			$StartDate = sprintf('%d-%d-%d', $StartYear,$StartMonth,$StartDay);
			$this->addAltHTMLValue('start_year',$StartYear);
			$this->addAltHTMLValue('start_month',$StartMonth);
			$this->addAltHTMLValue('start_day',$StartDay);


		}

		if($StartDate) $this->addToRangeList($FieldTitle,$StartDate,$FieldTable,'string','>=');

		//get end date

		$EndYear  = (int) $this->getRangeFromGetPost('end_year');
		$EndMonth  = (int) $this->getRangeFromGetPost('end_month');
		$EndDay  = (int) $this->getRangeFromGetPost('end_day');
		$EndDate = null;
		if($EndDay && $EndMonth && $EndYear){
			$EndDate = sprintf('%d-%d-%d', $EndYear,$EndMonth,$EndDay);
			$this->addAltHTMLValue('end_month',$EndMonth);
			$this->addAltHTMLValue('end_day',$EndDay);
			$this->addAltHTMLValue('end_year',$EndYear);


		}
		//get
		if($EndDate) $this->addToRangeList($FieldTitle,$EndDate,$FieldTable,'string','<=');


	}
	/**
	 * Parses incoming params, getting data from _POST & _GET correspong to this params,
	 * adds data to the Ranges which use in performSelect ($Db) in WHERE clouse 
	 *
	 * @param string $RangeTitle Field title (the same in form and table)
	 * @param string $RangeTable Field table 
	 * @param unknown_type $AddData 
	 * @param unknown_type $ValueType  can be 'int' or 'sring'
	 * @param string $ExprType can be '=','like','>=' and so on
	 * @param unknown_type $AddValue 
	 */
	public function addRange($RangeTitle,$RangeTable = null,$AddData = null,$ValueType = 'int', $ExprType = '=',$AddValue = null,$Default = 0,$LangTitle = null){
		global $InOut;

		

		if(is_a($ExprType,'GridItemCondition')){
			/*@var $ConditionObject GridFieldCondition*/
			$ConditionObject = $ExprType;
			$ExprType = $ConditionObject->Type;
			
		}
		
		//get range from post
		$RangeValue = $this->getRangeFromGetPost($RangeTitle);

		if($RangeTitle == 'page') {
			if($AddData) $this->RowsPerPage = (int) $AddData;
			$RangeValue = abs((int) $RangeValue);
			$this->addPageRange((int) $RangeValue);
		}elseif ($RangeTitle =='order')	{
		//	die('d');
			if($AddData == ($RangeValue = $this->getRangeFromGetPost($RangeTitle))){
				//check for user sorting data


				
				$Direction = substr($InOut->gvar('direction'),0,4);
				$this->AddOrderByElement($RangeValue,$RangeTable,$Direction);



			}elseif (is_array($AddData) && !empty($AddData)){
				//default sorting

				list($OrderBy,$Direction) = $AddData;
				$this->AddOrderByElement($OrderBy,$RangeTable,$Direction,1);


			}

		}
		else{
			//just common range
			
			if(!$LangTitle) $LangTitle = $RangeTitle;
			
			$this->assignRange($RangeTitle,$LangTitle,$ConditionObject);
			if($RangeValue) {

				$this->addToRangeList($RangeTitle,$RangeValue,$RangeTable,$ValueType,$ExprType,$AddValue);
			}
		}






	}
	private function addToRangeList($RangeTitle,$Value,$Table,$ValueType='int',$ExprType = '=',$AddValue = null){

		if($ValueType == 'int')	$Value = (int) $Value;
		elseif($ValueType == 'string') {

		}


		$arr = array (
		'Value' => $Value,
		'ValueType' => $ValueType,
		'ExprType' => $ExprType,
		'AddValue' => $AddValue,
		'Table' => $Table,
		'Title' => $RangeTitle
		);
		array_push($this->Ranges,$arr);




	}
	public function &getRangeNextItem(){


		list($key,$value) = each($this->Ranges);
		return $value;

	}

	private function getRangeFromGetPost($RangeTitle){
		global $InOut;
		$Range = $InOut->pgvar($RangeTitle);
		if($Range && preg_match('/[0-9a-zA-Z_\-]/', substr($RangeTitle,0,20))){

			return $Range;

		}
		return NULL;
	}


}



?>