<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit radmaster.net

*/

class RadDbQuery_WhereGroup{




	protected $Where;
	protected $Operators;
	protected $DefaultOperator = ' AND ';
	protected $DefaultTable;

	protected $SqlString;

	const FULLTEXT = 'FULLTEXT';
	const INNER_JOIN = 'INNER_JOIN';


	public function setDefaultTable($Table){
		$this->DefaultTable;
	}



	public function clear(){
		$this->Where = null;
	}
	public function addSearchFullText($FieldsArray,$Value,$Table = null,$Alias = null){

		/*			$ft['field']  = $FieldsArray;
		$ft['value'] = $Value;
		$ft['table'] = $Table;
		$this->FullTextSearch[] = $ft;*/

		$this->add($FieldsArray,$Value,$Table,null,self::FULLTEXT );
	}

	public function setDefaultOperator($Operator = 'OR'){

		$this->DefaultOperator =' '.$Operator.' ';
	}

	public function addJoin($Table1,$Field1,$Table2,$Field2){
		$va11 = $Table1.'.'.$Field1;
		$val2 = $Table2.'.'.$Field2;
		$this->add($va11,$val2,null,null,self::INNER_JOIN);

	}

	public function add($Field,$Value,$Table = null,$Operator='=',$Type='',$Escape = false){
		$where = array();
		$where['field'] = $Field;
		$where['value'] = $Value;

		if(!$Table) $Table = $this->DefaultTable;
		$where['table'] = $Table;

		$where['operator'] = $Operator;
		$where['type'] = $Type;
		if($Escape && is_string($where['value'])) $where['value']=  mysql_real_escape_string($where['value']);
		$this->Where[] = $where;

	}
	
	public function addOperator($Operator){

		$this->Operators[] = $Operator;

	}

	public function addSql($Sql){

		$this->SqlString = $Sql;

	}


	public function getSqlString(){

		if($this->SqlString) return $this->SqlString;


		if(!$this->Where) return '';
		$where ='( ';
		foreach ($this->Where as $key=>&$val){
			if($key) $where .= $this->DefaultOperator;

			if(@$val['type'] == self::FULLTEXT ){

				if(!is_array($val['field'])) continue;

				$where .=' MATCH (';
				foreach ($val['field'] as $skey=>$sval) {
					if($skey) $where .=', ';
					$where.= $sval;

				}

				$where .=') AGAINST (\''.$val['value'].'\' ) ';

				//. $val['field'] .$val['operator'].'\''.$val['value'].'\' ';
			}elseif (@$val['type'] == self::INNER_JOIN){

				$where.=$val['field'].'='.$val['value'] ;


			}elseif (strtolower($val['operator']) == 'between'){

				if(!is_array($val)) continue;
				 sort($val['value']);
				$where .=' ';
				if(@$val['table']) $where .= $val['table'].'.';
				//print_r($val);
				$where .=$val['field'] .' '.$val['operator']." {$val['value'][0]} AND {$val['value'][1]}";//.'\'';
				
				
				//$where .='\' ';
				
			}else {



				$where .=' ';
				if(@$val['table']) $where .= $val['table'].'.';
				$where .=$val['field'] .$val['operator'].'\''.$val['value'].'\' ';
			}


		}
		$where .=' ) ';
		return $where;
	}







}




class  Rad_Db_Query_Result{

	public $FetchedRowsNum;
	public $Data;
	public function &getData(){
		return $this->Data;
	}


}

class Rad_Grid_Query_Result extends Rad_Db_Query_Result   {



	public $CurrentPage;
	public $PagesNum;
	public $TotalRows;
	public $RowsPerPage;


	public function setData($Data){
		$this->Data = $Data;
	}
	public function setRowsPerPage($rows){
		$this->RowsPerPage = $rows;

	}
	public function getTotalPages(){
		return ceil($this->TotalRows / $this->RowsPerPage);
	}

	public function setTotalRows($Rows){
		$this->TotalRows = $Rows;
	}
	public function getTotalRows(){
		return $this->TotalRows;
	}
	public function getCurrentPageRowsIndexStart(){
		return $this->RowsPerPage*$this->CurrentPage+1;

	}
	public function getCurrentPageRowsIndexEnd(){


		//print_r($this);



		$Val = $this->RowsPerPage*($this->CurrentPage)+$this->RowsPerPage;
		//return $Val.'zzz';

		if($Val >= $this->RowsPerPage ) return   $this->TotalRows;
		return $Val;


	}



}

class Rad_Query_Params{

	protected $isGrid = false;
	public function isGrid(){
		return $this->isGrid;
	}
	public function setIsGrid($Flag){
		$this->isGrid = $Flag;
	}


}
class Rad_Grid_Query_Params extends Rad_Query_Params {

	public $Page;
	public $RowsPerPage;
	protected $isGrid = true;

	public function getRowsStartFrom(){

		return $this->Page * $this->RowsPerPage;
	}
	public function getRowsPerPage(){
		return $this->RowsPerPage;
	}




}
class RadDbQuery{


	protected $Order;
	protected  $Limit;

	/**
	 * Query Result
	 *
	 * @var Rad_Db_Query_Result
	 */
	public $QueryResult;


	/**
	 * Query params like page
	 *
	 * @var Rad_Grid_Query_Params
	 */
	public $QueryParams;

	protected $QueryFlags;

	public function setQueryParams(Rad_Query_Params $Params){
		$this->QueryParams = $Params;
	}

	public  function addQueryFlag($Flag){

	}
	public function __construct(){

		$this->QueryParams = new Rad_Query_Params();
	}

	function __clone()
	{
		// Force a copy of this->object, otherwise
		// it will point to same object.
		foreach ($this as $key=> $val){
			if(is_object($val) ) {

				$this->$key = clone $this->$key;
			}elseif (is_array($val)){
				foreach ($val as $skey => $sval){
					if(is_object($sval) ) {

						$this->$key[$skey] = clone $sval;
					}


				}
			}
		}

	}




	public function addOrder($Field,$Table = null,$Direction = 'ASC'){
		$order = array();
		$order['field'] = $Field;
		$order['table'] = $Table;
		$order['direction'] = $Direction;
		$this->Order[] = $order;

	}

	public function getOrderString(){
		if(!$this->Order) return '';
		$OrderString = ' ORDER BY ';
		foreach ($this->Order as $key => $f){
			if($key) $OrderString .=', ' ;
			if($f['table']) $OrderString.=$f['table'].'.';
			$OrderString .= $f['field'];
			if(@$f['direction']) $OrderString .= ' '.$f['direction'];
		}

		return $OrderString;

	}
	public function removeLimit(){
		$this->Limit = null;
	}
	public function removeOrder(){
		$this->Order = null;
	}
	public function addLimit($Rows,$Start = null){
		$limit = array();
		$limit['rows'] = $Rows;
		if($Start) $limit['start'] = $Start;
		$this->Limit = $limit;

	}
	public function getLimitString(){

		if(!$this->Limit) return '';
		if(@$this->Limit['start']) $Limit = ' LIMIT '. $this->Limit['start'];
		if(@$Limit) $Limit .= ', ';
		else $Limit = ' LIMIT ';
		$Limit .= $this->Limit['rows'];

		return $Limit;

	}













}
class RadSelectQuery extends RadDbQuery {

	protected  $What;
	protected  $From = array();
	protected  $Where;
	protected 	$DefaultWhereOperator = ' OR ';
	protected  $WhereGroups;
	protected $HavingString;


	protected $GroupBy;



	/**
	 * Query Result
	 *
	 * @var Rad_Db_Query_Result
	 */
	public $QueryResult;

	public function addQueryFlag($Flag){
		$this->QueryFlags[] = $Flag;

	}
	public function removeWhere(){
		$this->Where = null;
	}
	public function getQueryFlagsString(){

		if(!$this->QueryFlags) return '';
		$QueryFlags  = '';
		foreach ($this->QueryFlags as $key => &$f){
			$QueryFlags .= ' '.$f.' ';

		}

		return $QueryFlags;


	}
	/**
	 * Get WHERE GROUP object
	 *
	 * @return RadDbQuery_WhereGroup
	 */
	public function getWhere($Index=0){
		return $this->Where[$Index];
	}

	public function addWhat($Field,$Table = null){

		$what = array();
		$what['field'] = $Field;
		if($Table) $what['table'] = $Table;
		$this->What[] = $what;



	}
	public function addHaving($Field,$Value){

		$Having = array();
		$Having['field'] = $Field;
		$Having['value'] = $Value;

	}

	public function setHavingString($String){

		$this->HavingString= $String;
	}
	public function getHavingString(){

		$String = '';

		/*if($this->Having) foreach ($this->Having as $key=>&$f){

		if($key) $String .= ' '.$this->DefaultWhereOperator.' ';
		$String .= "{$f['field']} = \'$\'";


		}*/

		if(!$this->HavingString) return null;
		return ' HAVING '.$this->HavingString;

	}
	public function getWhatString(){

		$What = '';

		if($this->What) foreach ($this->What as $key=>&$f){

			if($key) $What .= ', ';
			if(@$f['table']) $What .= $f['table'].'.';
			$What .= $f['field'];


		}

		if(!$What) throw new DbQueryException('Empty _What string');
		return $What;




	}

	public function addGroupBy($Field,$Table = null){
		$GroupBy = $Table.'.'.$Field;
		$this->GroupBy[] = $GroupBy;

	}

	public function getGroupByString(){
		if(!$this->GroupBy)	return '';

		$GroupBy = 'GROUP BY ';
		foreach ($this->GroupBy as $key=>&$f){
			if($key) $GroupBy.=', ';
			$GroupBy .=$f;

		}
		return $GroupBy;



	}

	public function addFrom($Table){

		if(!array_search($Table,$this->From))$this->From[] = $Table;

	}
	public function getFromString(){
		if(!$this->From) return '';
		$From = ' FROM ';
		if($this->From) foreach ($this->From as $key => &$f){
			if($key) $From .= ', ';
			$From .= $f;


		}

		if(!$From) throw new DbQueryException('Empty _From string');
		return $From;

	}


	/**
		 * Enter description here...
		 *
		 * @param string $Operator sql operator (OR, AND etc)
		 * @param string $GroupId Where group id
		 * @return RadDbQuery_WhereGroup
		 */
	public function addWhereGroup($Operator = null,$GroupId = null){


		if($Operator) $this->DefaultWhereOperator = $Operator;
		if($GroupId) return $this->Where[$GroupId] = new RadDbQuery_WhereGroup();
		return $this->Where[] = new RadDbQuery_WhereGroup();



	}
	/**
	 * Get WhereGroup of the Query
	 *
	 * @param string $Name
	 * @return RadDbQuery_WhereGroup
	 */
	public function getWhereGroup($Name){
		return $this->Where[$Name];
	}



	public function getWhereString(){
		if(!$this->Where) return '';


		$WhereString ='';


		foreach ($this->Where as $key=>$f){

			$String = $f->getSqlString();
			if(!trim($String)) continue;
			//echo $key.'='.$String.'<br>';
			if($key && $String && $WhereString) {

				$WhereString .= ' '.$this->DefaultWhereOperator.' ';

			}

			/*@var $f RadDbQuery_WhereGroup*/
			$WhereString .= $String;
			//echo $key.'='.$WhereString.'<br>';

		}

		//	die();
		if($WhereString) $WhereString = ' WHERE '.$WhereString;


		return $WhereString;

		/*
		$Where = '';

		foreach ($this->Where)
		*/

	}





	public function getSqlString(){




		return  'SELECT '.$this->getQueryFlagsString().$this->getWhatString().$this->getFromString().$this->getWhereString().$this->getGroupByString().$this->getHavingString().$this->getOrderString().$this->getLimitString();
	}


}


class DbQueryException extends Exception {

}


class RadUnionQuery extends RadDbQuery  {

	protected $Selects;


	/**
	 * Query Result
	 *
	 * @var Rad_Grid_Query_Result
	 */
	public $QueryResult;

	public function addQueryFlag($Flag){
		if($this->Selects) {

			$this->Selects[0]->addQueryFlag($Flag);
		}


	}
	/**
	 * Adds new SELECT to the UNION
	 *
	 * @return RadSelectQuery
	 */

	public function addSelect($Obj = null){

		if(!$Obj) return $this->Selects[] = new RadSelectQuery();
		else return $this->Selects[] = $Obj;



	}


	public function getSqlString(){

		if(!$this->Selects) return null;

		$UnionSql = '';

		if($LimitParams = $this->QueryParams->getRowsPerPage()){

			$this->addLimit($LimitParams,$this->QueryParams->getRowsStartFrom());
		}

		foreach ($this->Selects as $key=>$s){
			/*@var $s RadSelectQuery*/
			if($key) $UnionSql.= ' UNION DISTINCT';
			$UnionSql .= '('.$s->getSqlString().')';



		}

		//die($UnionSql.$this->getOrderString().$this->getLimitString());
		return $UnionSql.$this->getOrderString().$this->getLimitString();

	}




}





?>