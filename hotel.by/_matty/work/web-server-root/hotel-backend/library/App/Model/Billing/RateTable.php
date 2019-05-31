<?php
/**
 * App_Model_Billing_RateTable
 */
require_once 'Zend/Db/Table/Abstract.php';

class App_Model_Billing_RateTable extends Zend_Db_Table_Abstract {

	protected $_name 	= 'billing_hotel_rate';
	protected $_primary = array(
		'id_rate',
		'id_hotel',
		'date_start',
		'date_end',
	);
	
	/**
	 * Получить общие свединия о сезоне
	 * @param int $iIdRate
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL>
	 */
	public function get($iIdRate){
		return $this->fetchRow('id_rate='.(int)$iIdRate);	
	}
	
	/**
	 * Устанавливает сезон ценового предложения отеля
	 * @param array $aRate
	 * @return int|false Return new int $iIdRate or false.
	 */
	public function setRate(array $aRate){
		$iIdRate = (int)$aRate['id_rate'];
		$bResult = $iIdRate
			? $this->_upd($iIdRate, $aRate)
			: $this->_add($aRate);
		return ($bResult !== false) ? $bResult['id_rate'] : false;
	}
	
	protected function _add($aRate){
		unset($aRate['id_rate']);
		$oRate = $this->createRow($aRate)->save();
		if(!$oRate) return false;
		$iIdRate = $oRate['id_rate'];
		$aData = array('ord' => $iIdRate);
		return $this->_upd($iIdRate , $aData);
	}
	
	protected function _upd($iIdRate , $aRate){
		$oRate = $this->get($iIdRate);
		unset($aRate['id_rate']);
		return $oRate->setFromArray($aRate)->save();
	}
	
	
	public function copyRate($rate_id){
		return $this->_copy($rate_id);
	}
	
	
	protected  function _copy($rate_id){
		
		$oRate = $this->get($rate_id);
		$rate_array = $oRate->toArray();
		$rate_array['id_rate'] = null;
		$new_row = $this->createRow();
		 return $new_row->setFromArray($rate_array)->save();
		
		
	}
	
	/**
     * Удаляет ценовые предложения $iIdRate сезона отеля
     * @return int	The number of rows deleted.
     */
	public function delRate($iIdRate){
		return parent::delete('`id_rate` = '.(int)$iIdRate);
	}
	
	/**
	 * Сортировка сезонов
	 * @param int $iIdRate
	 * @param bool $bDir
	 * @return bool
	 */
	public function chOrd($iIdRate, $bDir){
		
		$oAdapter = $this->getAdapter();
		$oCurrent = $this->get($iIdRate)->toArray();
		$iOrd 	  = $oCurrent['ord'];
		$iIdHotel = $oCurrent['id_hotel'];
		
		$oSelect = $oAdapter
			->select()
			->from($this->_name, array(
				'id_rate', 'ord'))
			->where('id_hotel = ?')
			->limit(1);
		
		if( $bDir ){
			$oSelect->where('ord < ?')->order('ord DESC');
		}else{
			$oSelect->where('ord > ?')->order('ord ASC');
		}
		$aResult = $oAdapter->fetchRow($oSelect, array($iIdHotel, $iOrd));
		
		if(!$aResult) return false;
		$tId  = $aResult['id_rate'];
		$tOrd = $aResult['ord'];
		$oAdapter->beginTransaction(); 
		try{
			# Обновление следующего или предидущего элемента 
			$this->update(array('ord' => $iOrd), 'id_rate = '.$tId);
			# Обновление текущего элемента 
			$this->update(array('ord' => $tOrd), 'id_rate = '.$iIdRate);
			$oAdapter->commit();
		}catch(Exception $e){
			$oAdapter->rollBack();
		}
		return true;
	}
	
	
	/**
	 * Возвращает сезоны ценовых предложений отеля за период
	 * @param int $iIdHotel
	 * @param date $dB
	 * @param date $dE
	 * @return array
	 */
	public function getRateSeasonsByPeriod($iIdHotel, $dB, $dE)
	{
		$oSelect = $this->select(false)
			->from($this->_name, array(
				'id_rate',
				'id_hotel',
				'date_start',
				'date_end',
				'is_weekly',
				'LPAD(BIN(week_days_action),7,0) as week_days_action'
			))
			->where(' id_hotel = ? AND '
				.'(   (date_start >= ? AND date_end <= ?)'  # Сезон целиком попадает в интервал
				.' OR (date_start <= ? AND date_end >= ?)'	# начинается раньше, заканчивается позже интервала
				.' OR (date_start <= ? AND date_end >= ?)'	# начинается раньше
				.' OR (date_start <= ? AND date_end >= ?))'	# заканчивается позже
			)
			->order('ord')
			;
		return $this->getAdapter()
		->fetchAll($oSelect, array(
			$iIdHotel, 
			$dB, $dE, 
			$dB, $dE, 
			$dB, $dB, 
			$dE, $dE), 
		2);
	}
}