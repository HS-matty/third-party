<?php
class Custom_Item extends Rad_Directory_Record {

	protected $DbFields;
	public $FormName = 'listing';
	public $AdditionalFormData = null;

	/**
	 * Form for creating search query
	 *
	 * @var Rad_Form
	 */
	protected $Form;

	public function setForm(Rad_Form $Form){
		$this->Form = $Form;
	}



	protected function issetDbField($value){
		return array_search($value,$this->DbFields);
	}
	public function getXmlAdditionalFields(){

		return $this->AdditionalFormData;

	}
	public function init_customItem(Rad_Tree_Node $Node){

		//print_r($Node);
		$this->TypeAlias = 'service'.$Node->getId();
		$this->setSecondaryTableParams('service'.$Node->getId(),'id');
		$this->DbFields = $Params['db_fields'];
		$this->AdditionalFormData = $Node->Data['custom_items_xml'];

		$this->initDbFields($this->JoinTable_Name,$this->DbFields);
		//print_r($this->DbFields);


	}
	function __construct(array $Params = null){
		if($Node = $Params['node']) $this->init_customItem($Node);
		/*@var $Node Rad_Tree_Node*/

		/*$this->UseSecondaryTable = true;
		$this->TypeAlias = 'credit';
		$this->setSecondaryTableParams('credit_listing','credit_listing_id');
		*/
		parent::__construct($Params);
		$NodeId = (int) $Params['NodeId'];


	}

	public function init($ItemId,RegisteredUser $User =null,array $params = null){

		if($Node = $params['node']) $this->init_customItem($Node);
		parent::init($ItemId,$User,$params);

	}

	protected function addParamsToSelectQueryForUnion(RadSelectQuery $Query,$Params){

		return false;
		$Query->addWhat('*',$this->PrimaryTable_Name);
		$Query->addWhat('company_name  as param1');
		$Query->addWhat('compensation  as param2');
		$Query->addWhat('compensation_type  as param3');

		$Query->addWhat('geocode.*');
		$Query->addFrom($this->PrimaryTable_Name .' left join geocode on (geocode.geocode_id ='.$this->PrimaryTable_Name.'.geocode_id )');

		$Query->addFrom($this->JoinTable_Name);
		$Where = $Query->addWhereGroup('and');
		$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);
		if($Params){
			$ParamsWhere = $Query->addWhereGroup('AND');
			$ParamsWhere->setDefaultOperator('OR');

			foreach ($Params as $id){
				$ParamsWhere->add($this->PrimaryTable_PrimaryKeyName,$id,$this->PrimaryTable_Name);

			}
		}



	}

	protected  function parseSecondaryTableParams($Params,RadSelectQuery $Query){


		global $InOut;


		$Query->addFrom($this->JoinTable_Name);
		if($Where = $Query->getWhereGroup('params')) {
			$Where->clear();
		}else{
			
			$Where = $Query->addWhereGroup('AND');


			$Where->addJoin($this->PrimaryTable_Name,$this->PrimaryTable_PrimaryKeyName,
			$this->JoinTable_Name,$this->PrimaryTable_PrimaryKeyName);

			if($this->issetDbField('currency_id')){
				$Query->addFrom('banking_currencies');
				$Where->addJoin($this->JoinTable_Name,
				'currency_id','banking_currencies','currency_id');
			}

			if($this->issetDbField('purpose_id')){
				$Query->addFrom('banking_purposes');
				$Where->addJoin($this->JoinTable_Name,
				'purpose_id','banking_purposes','purpose_id');
			}
			//add currency
			/*	$Query->addFrom('banking_currencies');
			$Where->addJoin('banking_currencies','currency_id',$this->JoinTable_Name,'currency_id');*/
		}

		if($this->Form) foreach ($this->Form->getFields() as $f){
			/*@var $f Rad_Form_Field*/
			if(isset($Params[$f->ID]) && $Params[$f->ID] && $$r = array_search($f->ID,$this->DbFields) !== false ){
				$VaryFieldValue = $Params[$f->ID.'_vary'];
				if( $VaryFieldValue)  $Where->add($f->ID,array($Params[$f->ID],$VaryFieldValue),$this->JoinTable_Name,'BETWEEN','',true);
				else  $Where->add($f->ID,$Params[$f->ID],$this->JoinTable_Name,'=','',true);


			}
			//	die('dd');
		}
		//	echo $Query->getSqlString();
		if(false)
		foreach ($Params as $key=>&$val){


			switch ($key){


				case 'sum':
					$val = (float) $val;
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('sum',$val,$this->JoinTable_Name,'>=');
					$InOut->setObligatoryUrlParam($key,$val);

					break;
				case 'term':
					$val = (int) $val;
					//		if($val) $AddSql .= ' AND l2.position_type = '.'\''..'\'';
					$Where->add('term',$val,$this->JoinTable_Name,'>=');
					$InOut->setObligatoryUrlParam($key,$val);
					break;



			}




		}
	}


}
?>