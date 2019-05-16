<?php
/*
radMaster Framework 2.2
(c) Sergey Volchek 2003-2007
You can freely use this file
if you have any questions please visit www.radmaster.net

*/

//8.08.2006 added sql log and exception support
// added new class QueryRange
require_once('queryrange.php');

class cDB {

	public  $link;
	public  $result;
	public $Ranges = array();

	public $FetchedRows; //saved rows while getting list items for qr object

	public $SqlLog = array();


	public function &getQrFetchedRows(){
		return $this->FetchedRows;
	}

	public function &perfromSelectQueryExt(RadDbQuery $Query,$isGrid = true){

		/*@var $qr QueryRange*/
		$qr = $this->getQueryRangeObj(0);

		if(!$qr){
			$qr = $this->CreateQueryRangeObj('default');
		}

		$qr->assingLimitToQuery($Query);
		$Query->addQueryFlag('SQL_CALC_FOUND_ROWS');


		$this->query($Query->getSqlString());

		$Rows = 0;
		if($isGrid){
			
			$Arr =& $this->fetch_all_assoc();
			if($Arr){
				$this->query("SELECT FOUND_ROWS()");
				$qr->setTolalRows($Rows = $this->fetch_element());
			}else $qr->setTolalRows(0);

			$Result =  new Rad_Grid_Query_Result();
			$Result->setData($Arr);
			$Result->setTotalRows($Rows);
			//$Result->init($Arr,$Rows);
			$Query->QueryResult = $Result;;
			$Query->QueryResult->FetchedRowsNum = $Rows;
			$this->FetchedRows = $Rows;
		}else {
			
			$Arr =& $this->fetch_assoc();
			$Result = new Rad_Db_Query_Result();
			$Result->Data = $Arr;
			
			$Query->QueryResult = $Result;;
		//	$this->FetchedRows =& $Rows;
			$Query->QueryResult->FetchedRowsNum = $Rows;
			


		}

		return $Query->QueryResult->getData();
		//print_r($Arr);


	}



	public function &perfromSelectQueryExt_new(RadDbQuery $Query){

		/*@var $qr QueryRange*/


		$isGrid = $Query->QueryParams->isGrid();
		if($isGrid) $Query->addQueryFlag('SQL_CALC_FOUND_ROWS');


		$this->query($Query->getSqlString());

		if($isGrid){
			$Result =  new Rad_Grid_Query_Result();
			$Arr =& $this->fetch_all_assoc();
			if($Arr){
				$this->query("SELECT FOUND_ROWS()");
				$Result->setTotalRows($this->fetch_element());
			}else $Result->setTotalRows(0);

			//print_r($Arr);

			$Result->setData($Arr);


			$Query->QueryResult = $Result;
			$Result->CurrentPage = $Query->QueryParams->Page;
			$Result->RowsPerPage = $Query->QueryParams->RowsPerPage;
			//print_r($Query->QueryResult);

			//$this->FetchedRows =& $Arr;
		}else {
			$Arr =& $this->fetch_assoc();
			$Result = new Rad_Db_Query_Result();
			$Result->setData($Arr);

			$Query->QueryResult = $Result;;


		}

		//print_r($Arr);


	}


	public function performSelectQuery($What,$From,$Where = null ,$GroupBy = null,$OrderBy = null,$SingleRow = 0,$LimitVal = null){
		/*@var $qr QueryRange*/
		$qr = $this->getQueryRangeObj(0);

		if(!$qr){
			$qr = $this->CreateQueryRangeObj('default');
		}
		//print_r($qr);





		$WhereSql ="";

		if($Where) $WhereSql .= "WHERE $Where ";




		$Proceed= 0;

		while ($w =& $qr->getRangeNextItem()){

			$w['Value']  = mysql_real_escape_string($w['Value']);
			$Proceed= 1;

			//print_r($w);

			//	$w = mysql_real_escape_string(stripslashes($w));

			if(!$WhereSql) $WhereSql = "WHERE ";
			else   $WhereSql .= " AND ";

			if($w['ExprType'] == 'LIKE'){

				$WhereSql .= "{$w['Table']}.{$w['Title']} {$w['ExprType']} ";
				if($w['AddValue'] == 'full') $WhereSql .= "'%{$w['Value']}%' ";
				else $WhereSql .= "'{$w['Value']}%' ";

			}elseif (($w['ExprType'] == '=') || ($w['ExprType'] == '>=') || ($w['ExprType'] == '<=')){


				$WhereSql .= "{$w['Table']}.{$w['Title']} {$w['ExprType']}";
				if($w['ValueType'] == 'int') $WhereSql .= (int) "{$w['Value']} ";
				else $WhereSql .= " '{$w['Value']}' ";







			}
		}


		$qr->resetRanges();



		if($GroupBy){
			$GroupBy = "GROUP BY $GroupBy ";
		}

		/*		if(!$SingleRow && !$Proceed) $Limit = $qr->getLimitSql();
		elseif ($Proceed) $Limit = "LIMIT {$qr->getRowsPerPage()}";
		else $Limit = null;*/


		//elseif ($Proceed) $Limit =
		if($LimitVal){
			$Limit = "LIMIT $LimitVal";
		}elseif(!$SingleRow) $Limit = $qr->getLimitSql();
		else $Limit = "LIMIT {$qr->getRowsPerPage()}";

		if($OrderBy){
			$OrderBy = "ORDER BY $OrderBy";
		}
		$OrderByArray  =& $qr->getOrderByArray();

		//print_r($OrderByArray);

		if($OrderByArray){
			foreach ($OrderByArray as &$val){

				if($val['Default'] && count($OrderByArray) > 1) {

					continue;
				}
				if($val['Table']) $Dot = '.';
				else $Dot = '';
				if(!$OrderBy) $OrderBy = " ORDER BY {$val['Table']}$Dot{$val['OrderBy']} {$val['Direction']}";
				else $OrderBy .= " , {$val['Table']}$Dot{$val['OrderBy']} {$val['Direction']}";
			}
		}


		$Sql = "SELECT SQL_CALC_FOUND_ROWS  $What  FROM $From $WhereSql $GroupBy $OrderBy $Limit";



		$this->query($Sql);

		if($SingleRow) $Arr =& $this->fetch_assoc();
		else {
			$Arr =& $this->fetch_all_assoc();
			if($Arr){
				$this->query("SELECT FOUND_ROWS()");
				$qr->setTolalRows($this->fetch_element());
			}else $qr->setTolalRows(0);
		}
		$this->FetchedRows =& $Arr;
		return $Arr;


	}
	public function CreateQueryRangeObj($Id = 'default'){
		$qbr = new QueryRange();
		$this->Ranges[$Id] = $qbr;
		return $qbr;
	}

	public function getQueryRangeObj($Id){

		if($Id == 0) return current($this->Ranges);
		elseif (@$this->Ranges[$Id]) return $this->Ranges[$Id];
		return null;
	}
	public function unsetRanges(){
		foreach ($this->Ranges as &$val) $val = null;
	}
	protected  function InsertSqlIntoLog($Sql){
		array_push($this->SqlLog,$Sql);


	}
	public function getSqlLog(){
		return $this->SqlLog;

	}
	//old
	public function Transaction($Operation){

		switch ($Operation){
			case 'start':
				$this->query('SET AUTOCOMMIT=0;');
				$this->query('START TRANSACTION;');
				break;
			case 'rollback':

				$this->query('ROLLBACK;');

				break;

			case 'commit':

				$this->query('COMMIT;');


				break;
		}



	}

	public function startTransaction(){

		$this->query('SET AUTOCOMMIT=0;');
		$this->query('START TRANSACTION;');

	}
	public function rollbackTransaction(){
		$this->query('ROLLBACK;');

	}
	public function commitTransaction(){
		$this->query('COMMIT;');

	}



	function DB () {
		$this->link = false;
	}

	function __destruct(){
		//print_r($this);
	}
	function select_db($db_name) {
		if( !$this->link ) return false;
		return mysql_select_db($db_name,$this->link);
	}

	function disconnect() {
		if( !$this->link ) return false;
		return mysql_close($this->link);
	}

	function connect ($db_name,$host_port='localhost',$user='',$password='') {

		$this->link = mysql_connect($host_port,$user,$password,null,2);
		if( !$this->link ) return false;

		if( !$this->select_db($db_name) ) {
			$this->disconnect();
			return false;
		}

		return true;
	}

	function performSelectQueryForList($sql){
		$sql = trim($sql);


		//$pattern = "/^SELECT (.*) FROM (.*) (WHERE)? (.*)? (GROUP BY)? (.*) (ORDER)?(.*)?$/";

		//$pattern = "/^SELECT (.*) FROM ([a-z0-9LEFTRIGHTJOIN\(\)\,\_\=\.]\s*)$/";// (WHERE)? ([a-z0-9\(\)\,\_\=\. ]*)?$/";
		//		$pattern = "/^SELECT (.*) FROM ([a-z0-9LEFTRIGHTJOIN\(\)\,\_\=\.\s]*)(WHERE)?([\-\+\'a-z0-9BETWEENAND\(\)\,\_\=\.\s]*)?(GROUP BY)?([a-z0-9\(\)\,\_\-\+\=\.\s]*)(ORDER BY)?([a-z0-9\(\)\,\_\=\.\s]*)?$/";
		$pattern = "/^SELECT (.*) FROM ([a-z0-9LEFTRIGHTJOIN\(\)\,\_\=\.\s]*)(WHERE)?([\-\+\'a-z0-9BETWEENANDOR\(\)\,\_\=\.\s]*)?(GROUP BY)?([a-z0-9\(\)\,\_\-\+\=\.\s]*)(ORDER BY)?([a-z0-9\(\)\,\_\=\.\s]*)(LIMIT)?([0-9\\,\s]*)?$/";
		preg_match($pattern,$sql,$arr)	;
		//print_r($arr);
		$What = $arr[1];
		$From = $arr[2];
		$Where = $arr[4];
		$GroupBy = $arr[6];
		$Order= $arr[8];
		$Limit= $arr[10];


		$Data =& $this->performSelectQuery($What,$From,$Where,$GroupBy,$Order,0,$Limit);



	}
	function query($sql) {
		if( !$this->link ) return false;
		$this->InsertSqlIntoLog($sql);

		//echo $sql;
		if( !$this->result = mysql_query($sql,$this->link) ) {
			if($Err = $this->GetErrorMessage()){
				//throw new Exception('Query error: '.$sql.'<br>'.$Err);
				die($Err.'<br>'. $sql);
			}
			return false;
		}
		//	if(mysql_error()) CLog::FileLog('mysql',mysql_error());




		return true;
	}

	function GetErrorMessage(){
		if($this->link) return mysql_error();
	}

	function &fetch_array() {
		if( !$this->link ) return false;
		$arr =  mysql_fetch_array($this->result);
		if($arr) return $arr;
		return null;
	}

	function &fetch_assoc() {
		if( !$this->link ) return false;

		$arr = mysql_fetch_assoc($this->result);
		return $arr;


	}


	function &fetch_all_array() {
		if( !$this->link ) return false;
		$rows = $this->rows();
		if( $rows!==false ) {
			$res = array();
			for( $i=0; $i<$rows; $i++ ) {
				$r =& $this->fetch_array();
				if( $r===false )
				return false;
				$res[] = $r;
			}
			return $res;
		}
		return false;
	}


	function &fetch_all_assoc() {
		if( !$this->link ) return false;
		$rows = $this->rows();
		if( $rows!==false ) {
			$res = array();
			for( $i=0; $i<$rows; $i++ ) {
				$r =& $this->fetch_assoc();
				if( $r===false )
				return false;
				$res[] = $r;
			}
			return $res;
		}
		return false;
	}



	public function get_element(){
		return $this->fetch_element();
	}
	function fetch_element(){
		if( !$this->link ) return false;
		$arr =& $this->fetch_array();
		return $arr[0];

	}
	function &fetch_object() {
		if( !$this->link ) return false;
		return mysql_fetch_object($this->result);
	}

	function rows() {
		if( !$this->link ) return false;
		return mysql_num_rows($this->result);
	}

	function affected_rows() {
		if( !$this->link ) return false;
		return mysql_affected_rows($this->link);
	}

	function get_insert_id() {
		if( !$this->link ) return false;
		return mysql_insert_id($this->link);
	}

	function sqlgen_insert($tbl,$arr) {
		global $Db;
		$db = $Db;


		if( !isset($db) || !is_string($tbl) || !is_array($arr) ) return false;

		$sql = "insert into $tbl set ";
		$comma = false;
		foreach( $arr as $key => $value ) {
			if( !is_string($key) ) continue;
			if( is_string($value) && $value !='NOW()') { $value = "'".mysql_real_escape_string($value)."'"; }
			if( is_null($value) ) { $value = "null"; }

			/*	if( $comma ) $sql .= ',';
			if( is_bool($value) && !$value )
			$sql .= "$key";
			else
			$sql .= "$key=$value";
			*/
			if( !(is_bool($value) && !$value) ) {
				if( $comma ) $sql .= ',';
				$sql .= "$key=$value";
			}
			$comma = true;
		}

		$db->query($sql);
		return $db->get_insert_id();
	}


	public function updateArray($IdTitle,$Data,$Table){
		$Id = (int) $Data[$IdTitle];
		if(!$Id) throw new Exception($IdTitle.' not set');
		unset($Data[$IdTitle]);
		$this->sqlgen_update($Table,$Data,"$IdTitle = $Id");
	}

	function sqlgen_update($tbl,$arr,$cond='') {

		global $Db;
		$db = $Db;

		if( !isset($db) || !is_string($tbl) || !is_array($arr) || !is_string($cond) ) return false;

		$sql = "update $tbl set ";
		$comma = false;
		foreach( $arr as $key => $value ) {
			if( !is_string($key) ) continue;
			if( is_string($value) ) { $value = "'".mysql_real_escape_string($value)."'"; }
			if( is_null($value) ) { $value = "null"; }
			if( $comma ) $sql .= ', ';
			$sql .= "$key=$value";
			$comma = true;
		}

		if( strlen($cond)>0 )
		$sql .= " where $cond";



		

		return $db->query($sql);
	}

	function sqlgen_delete($tbl,$cond='') {
		global $db;

		if( !isset($db) || !is_string($tbl) || !is_string($cond) ) return false;

		$sql = "delete from $tbl";
		if( strlen($cond)>0 )
		$sql .= " where $cond";

		return $db->query($sql);
	}


}


class Rad_Db_Moving_to_Zend_Db extends cDB {

	/**
	 * Pdo object
	 *
	 * @var PDO
	 */
	public $link;

	/**
	 * Result
	 *
	 * @var PDOStatement 
	 */
	public $result;

	function query($sql) {
		if( !$this->link ) return false;
		$this->InsertSqlIntoLog($sql);

		//echo $sql;
		if( !$this->result = $this->link->query($sql) ) {

			if($Err = $this->GetErrorMessage()){
				//throw new Exception('Query error: '.$sql.'<br>'.$Err);
				die($Err.'<br>'. $sql);
			}
			return false;
		}
		//	if(mysql_error()) CLog::FileLog('mysql',mysql_error());




		return true;
	}

	function GetErrorMessage(){
		if($this->link) return $this->link->errorCode();
	}

	function &fetch_array() {
		if( !$this->link ) return false;

		return $this->result->fetch();
	}

	function &fetch_assoc() {
		if( !$this->link ) return false;

		return $this->result->fetch();


	}


	function &fetch_all_array() {

		return $this->result->fetchAll();
	}


	function &fetch_all_assoc() {
		return $this->result->fetchAll();

	}



	public function get_element(){
		$arr = $this->result->fetch();

		return $arr[0];
	}
	function fetch_element(){
		$arr = $this->result->fetch();

		return $arr[0];

	}
	function &fetch_object() {

		return $this->result->fetchObject();
	}

	function rows() {
		return $this->result->rowCount();
	}

	function affected_rows() {
		return $this->result->rowCount();
	}

	function get_insert_id() {
		return $this->link->lastInsertId();
	}

	function sqlgen_insert($tbl,$arr) {
		global $Db;
		$db = $Db;


		if( !isset($db) || !is_string($tbl) || !is_array($arr) ) return false;

		$sql = "insert into $tbl set ";
		$comma = false;
		foreach( $arr as $key => $value ) {
			if( !is_string($key) ) continue;
			if( is_string($value) && $value !='NOW()') { $value = "'".mysql_real_escape_string($value)."'"; }
			if( is_null($value) ) { $value = "null"; }

			/*	if( $comma ) $sql .= ',';
			if( is_bool($value) && !$value )
			$sql .= "$key";
			else
			$sql .= "$key=$value";
			*/
			if( !(is_bool($value) && !$value) ) {
				if( $comma ) $sql .= ',';
				$sql .= "$key=$value";
			}
			$comma = true;
		}

		$db->query($sql);
		return $db->get_insert_id();
	}


	public function updateArray($IdTitle,$Data,$Table){
		$Id = (int) $Data[$IdTitle];
		if(!$Id) throw new Exception($IdTitle.' not set');
		unset($Data[$IdTitle]);
		$this->sqlgen_update($Table,$Data,"$IdTitle = $Id");
	}

	function sqlgen_update($tbl,$arr,$cond='') {

		global $Db;
		$db = $Db;

		if( !isset($db) || !is_string($tbl) || !is_array($arr) || !is_string($cond) ) return false;

		$sql = "update $tbl set ";
		$comma = false;
		foreach( $arr as $key => $value ) {
			if( !is_string($key) ) continue;
			if( is_string($value) ) { $value = "'".mysql_real_escape_string($value)."'"; }
			if( is_null($value) ) { $value = "null"; }
			if( $comma ) $sql .= ', ';
			$sql .= "$key=$value";
			$comma = true;
		}

		if( strlen($cond)>0 )
		$sql .= " where $cond";




		return $db->query($sql);
	}

	function sqlgen_delete($tbl,$cond='') {
		global $db;

		if( !isset($db) || !is_string($tbl) || !is_string($cond) ) return false;

		$sql = "delete from $tbl";
		if( strlen($cond)>0 )
		$sql .= " where $cond";

		return $db->query($sql);
	}

}
?>