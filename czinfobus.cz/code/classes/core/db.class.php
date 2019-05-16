<?php

class cDB {

	var $link;
	var $result;

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
	function DB () {
		$this->link = false;
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

		$this->link = @mysql_connect($host_port,$user,$password);
		if( !$this->link ) return false;

		if( !$this->select_db($db_name) ) {
			$this->disconnect();
			return false;
		}

		return true;
	}

	function query($sql) {
		if( !$this->link ) return false;
		if( !$this->result = mysql_query($sql,$this->link) ) {
			echo $this->GetErrorMessage();
			if(mysql_error()) CLog::FileLog('mysql',mysql_error());

			return false;
		}

		return true;
	}
	
	function GetErrorMessage(){
		if($this->link) return mysql_error();
	}

	function &fetch_array() {
		if( !$this->link ) return false;
		return mysql_fetch_array($this->result);
	}

	function &fetch_all_array() {
		if( !$this->link ) return false;
		$rows = $this->rows();
		if( $rows!==false ) {
			$res = array();
			for( $i=0; $i<$rows; $i++ ) {
				$r = $this->fetch_array();
				if( $r===false )
				return false;
				$res[] = $r;
			}
			return $res;
		}
		return false;
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
	if( is_string($value) ) { $value = "'".mysql_escape_string($value)."'"; }
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
	//echo $sql;
    return $db->query($sql);
}


function sqlgen_update($tbl,$arr,$cond='') {
    global $Db;
    $db = $Db;

    if( !isset($db) || !is_string($tbl) || !is_array($arr) || !is_string($cond) ) return false;

    $sql = "update $tbl set ";
    $comma = false;
    foreach( $arr as $key => $value ) {
	if( !is_string($key) ) continue;
	if( is_string($value) ) { $value = "'".mysql_escape_string($value)."'"; }
	if( is_null($value) ) { $value = "null"; }
	if( $comma ) $sql .= ',';
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