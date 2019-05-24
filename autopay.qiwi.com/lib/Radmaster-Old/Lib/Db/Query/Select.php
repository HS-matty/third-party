<?php

class Db_Query_Select  extends Db_Query {


	const SEARCH_TYPE_FULLTEXT = 'FULLTEXT';

	const JOIN_TYPE_INNER = 'INNER';
	const JOIN_TYPE_LEFT = 'LEFT';


	/*
	const FULLTEXT = 'FULLTEXT';
	const INNER_JOIN = 'INNER';
	const LEFT_JOIN = 'LEFT';*/




	protected $_what;
	protected $_from = array();
	protected $_where;

	
	/**
	 *  ...
	 *
	 * @var Element
	 */
	protected $_join;
	
	protected $_into_string;

	protected $_default_where_operator = ' AND ';
	protected $_where_groups;
	protected $_having_string;


	protected $_query_flags = array();

	protected $_group_by;



	public function onInit(){
		
		$this->_join = new Std_Array();


	}


	/**
	 * Query Result
	 *
	 * @var Rowset
	 */
	public $_rowset;

	/**
	 * Enter description here...
	 *
	 * @param string $flag
	 * @return Db_Query_Select
	 */
	public function addQueryFlag($flag){
		$this->_query_flags[] = $flag;
		return $this;

	}

	/**
	 * Enter description here...
	 *
	 * @param string $into_string
	 * @return Db_Query_Select
	 */
	public function addIntoString($into_string){

		$this->_into_string = $into_string;
		return $this;
	}

	public function getIntoString(){
		return $this->_into_string;
	}

	public function removeWhere(){
		$this->_where= null;
	}
	public function getQueryFlagsString(){

		$query_flags_string = null;

		if($this->_query_flags){
			$query_flags_string  = '';
			foreach ($this->_query_flags as $key => &$f){
				$query_flags_string .= ' '.$f.' ';

			}
		}

		return $query_flags_string;


	}
	/**
	 * Get where 
	 *
	 * @return RadDbQuery_WhereGroup
	 */
	public function getWhere($index = 0){
		return $this->_where[$index];
	}


	/**
	 * ...
	 *
	 * @param string $field_name
	 * @param string $table_name
	 * @return Db_Query_Select
	 */
	public function addWhat($field_name,$table_name = null){

		$what = array();
		$what['field'] = $field_name;
		if($table_name) $what['table'] = $table_name;
		$this->_what[] = $what;
		return $this;



	}
	public function addHaving($field_name,$value){

		$having = array();
		$having['field'] = $field_name;
		$having['value'] = $value;
		$this->_having[] = $having;
		return $this;

	}

	public function setHavingString($having_string){

		$this->_having_string = $having_string;
	}

	public function setDefaultWhereGroupOperator($operator){
		$this->_default_where_operator = $operator;
	}
	public function getHavingString(){



		/*
		$having_string = '';
		if($this->Having) foreach ($this->Having as $key=>&$f){

		if($key) $String .= ' '.$this->DefaultWhereOperator.' ';
		$String .= "{$f['field']} = \'$\'";


		}*/

		$return_value = null;
		if($this->_having_string) $return_value =& $this->_having_string;
		return $return_value;


	}
	public function getWhatString(){

		$what_string = '';

		if($this->_what) foreach ($this->_what as $key=>&$f){

			if($key) $what_string .= ', ';

			if(@$f['table']) $what_string .= $f['table'].'.';
			$what_string .= $f['field'];


		}

		if(!$what_string) throw new Exception('Empty _What string');
		return $what_string;




	}

	/**
	 * Enter description here...
	 *
	 * @param string $field_name
	 * @param string $table_name
	 * @return Db_Query_Select
	 */
	public function addGroupBy($field_name,$table_name = null){
		$group_by_string = $field_name;
		if($table_name) $group_by_string = $table_name.'.'.$group_by_string;
		$this->_group_by[] = $group_by_string;
		return $this;

	}

	public function getGroupByString(){


		$group_by_string = null;

		if($this->_group_by){
			$group_by_string = 'GROUP BY ';
			foreach ($this->_group_by as $key=>&$f){
				if($key) $group_by_string .= ', ';
				$group_by_string  .=$f;

			}
		}
		return $group_by_string;



	}

	/**
	 * Enter description here...
	 *
	 * @param string $table_name
	 * @return Db_Query_Select
	 */
	public function addFrom($table_name){

		if(array_search($table_name,$this->_from) === false) $this->_from[] = $table_name;
		return $this;

	}
	public function getFromString(){

		$from_string = null;

		if($this->_from){
			$from_string = ' FROM ';
			foreach ($this->_from as $key => &$f){
				if($key) $from_string .= ', ';
				$from_string .= $f;
				
				//check for left/right join
				if(isset($this->_join) && $join_params = $this->_join->findInner('table_name',$f)){
					
					$from_string .= ' '.$join_params['type'].'  JOIN ' . $join_params['join_table_name'].' ON '. $join_params['table_name'].'.'.$join_params['table_field_name']. '='.$join_params['join_table_name'].'.'.$join_params['join_table_field_name'];
					
					
				}


			}
		}

		if(!$from_string) throw new Exception('Empty _From string'); //doubtable
		return $from_string;

	}

	public function getFromArray(){
		return $this->_from;
	}

	public function addJoin($table_name_1,$field_name_1,$table_name_2,$field_name_2, $type='INNER'){

		$va1_1 = $table_name_1.'.'.$field_name_1;
		$val_2 = $table_name_2.'.'.$field_name_2;
		
		if($this->_join) $this->_join = new Std_Array();

		if($type == self::JOIN_TYPE_INNER){
			
			/*
			$arr = new Std_Array();
			$arr['table_name'] = $table_name_1;
			$arr['table_field_name'] = $field_name_1;
			$arr['join_table_name'] = $table_name_2;
			$arr['join_table_field_name'] = $field_name_2;
			$arr['type'] = $type;
			$this->_join[] = $arr;*/
			

			$where = $this->addWhereGroup();
			$where->add($va1_1,$val_2,null,null,self::JOIN_TYPE_INNER);

		}elseif ($type == self::JOIN_TYPE_LEFT){
			
			
			
			$arr = new Std_Array();
			$arr['table_name'] = $table_name_1;
			$arr['table_field_name'] = $field_name_1;
			$arr['join_table_name'] = $table_name_2;
			$arr['join_table_field_name'] = $field_name_2;
			$arr['type'] = $type;
			$this->_join[] = $arr;
			
			

		}
		return $this;

	}


	/**
		 * Enter description here...
		 *
		 * @param string $operator sql operator (OR, AND etc)
		 * @param string $group_id Where group id
		 * @return Db_Query_Select_Where_Group
		 */
	public function addWhereGroup($operator = null,$group_id = null){


		$group = null;

		

		$group = new Db_Query_Select_Where_Group();
		
		if($group_id) $this->_where[$group_id] = $group;
		else $this->_where[] = $group;
				
		if($operator) $group->setDefaultOperator($operator);
		
		return $group;



	}
	/**
	 * Get WhereGroup of the Query
	 *
	 * @param string $Name
	 * @return Db_Query_Where_Group
	 */
	public function getWhereGroup($name){
		return $this->_where[$name];
	}



	public function getWhereString(){

		$where_string = '';

		if($this->_where){
		
			foreach ($this->_where as $key=>&$f){
				/*@var $f Db_Query_Where_Group*/

				$sql_string = $f->getSqlString();

				if(!trim($sql_string)) continue;

				//$key ???
				if( $key && $sql_string && $where_string) {

					$where_string .= ' '.$this->_default_where_operator.' ';

				}
					$where_string .= $sql_string;
			}
		}

		if($where_string) $where_string = ' WHERE '.$where_string;

		return $where_string;

	}





	public function getSqlString(){




		return  'SELECT '.$this->getQueryFlagsString().$this->getWhatString().$this->getFromString().$this->getWhereString().$this->getGroupByString().$this->getHavingString().$this->getOrderString().$this->getLimitString().$this->getIntoString();
	}


}


class Db_Query_Select_Where_Group extends Element {

	protected $_where;
	protected $_operators;
	protected $_default_operator = ' AND ';
	protected $_default_table;




	protected $_sql_string;

	public function setDefaultTable($table_name){
		$this->_default_table = $table_name;
		return $this;
	}



	public function clear(){
		$this->_where = null;
	}
	public function addSearchFullText($fields_array,$value,$table_name = null,$alias = null){

		$this->add($fields_array,$value,$table,null,self::FULLTEXT);
		return $this;
	}

	public function setDefaultOperator($operator = 'OR'){

		$this->_default_operator =' '.$operator.' ';
	}



	public function add($field_name,$value,$table_name = null, $operator='=',$type='',$is_escape = false){

		$where = array();
		$where['field'] = $field_name;
		$where['value'] = $value;

		if(!$table_name) $table_name = $this->_default_table;
		$where['table'] = $table_name;

		$where['operator'] = $operator;
		$where['type'] = $type;

		if($is_escape && is_string($where['value'])) $where['value']=  mysql_real_escape_string($where['value']);
		$this->_where[] = $where;

	}

	public function addOperator($operator){

		$this->operators[] = $operator;

	}

	public function addSql($sql_string){

		$this->_sql_string = $sql_string;

	}


	public function getSqlString(){



		$sql_string = '';

		if(!$this->_sql_string && $this->_where){

			$sql_string ='( ';
			foreach ($this->_where as $key=>&$val){

				if($key) $sql_string .= $this->_default_operator;

				if(@$val['type'] == Db_Query_Select::SEARCH_TYPE_FULLTEXT){

					if(!is_array($val['field'])) continue;

					$sql_string .=' MATCH (';

					foreach ($val['field'] as $skey=>$sval) {
						if($skey) $sql_string .=', ';
						$sql_string .= $sval;

					}

					$sql_string .=') AGAINST (\''.$val['value'].'\' ) ';

				}elseif (@$val['type'] == Db_Query_Select::JOIN_TYPE_INNER ){

					$sql_string .=$val['field'].'='.$val['value'] ;

				}elseif (@$val['type'] == Db_Query_Select::JOIN_TYPE_LEFT  ){

					$sql_string .=$val['field'].'='.$val['value'] ;


				}elseif (strtolower($val['operator']) == 'between'){

					if(!is_array($val)) continue;

					sort($val['value']);

					$sql_string .= ' ';
					if(@$val['table']) $sql_string .= $val['table'].'.';
					$sql_string .=$val['field'] .' '.$val['operator']." {$val['value'][0]} AND {$val['value'][1]}";//.'\'';

				}else {

					$sql_string .= ' ';

					if(@$val['table']) $sql_string .= $val['table'].'.';
					$sql_string .= $val['field'].$val['operator'].'\''.$val['value'].'\' ';
				}


			}
			$sql_string .=' ) ';

		}else $sql_string =& $this->_sql_string;

		return $sql_string;
	}



}




?>