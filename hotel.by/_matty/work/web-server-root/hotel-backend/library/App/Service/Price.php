<?php
/**
 * App_Service_Price
 */ 
class App_Service_Price
{
	/**
	 * @var App_Model_Billing_RateTable
	 */
	private $_tblRate = null;
	/**
	 * @var App_Model_Billing_Rate_StateTable
	 */
	private $_tblRateState = null;
	/**
	 * @var App_Model_Billing_Rate_ProcessingTable
	 */
	private $_tblRateProcessing = null;
	/**
	 * @var App_Model_Billing_Rate_ExtraBedTable
	 */
	private $_tblRateExtra = null;

	/**
	 * @var App_Service_Price
	 */
	private static $_instance = null;
	
	/**
	 * @return App_Service_Price
	 */
	public static function getInstance(){
		if(null === self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct(){
		$this->_tblRate		 	  = new App_Model_Billing_RateTable();
		$this->_tblRateState 	  = new App_Model_Billing_Rate_StateTable();
		$this->_tblRateProcessing = new App_Model_Billing_Rate_ProcessingTable();
		$this->_tblRateExtra 	  = new App_Model_Billing_Rate_ExtraBedTable();
	}
	
	
	/**
	 * Возвращает общую информацию о сезоне 
	 * @param int $iIdRate
	 * @return Zend_Db_Table_Row
	 */
	public function get($iIdRate){
		return $this->_tblRate->get($iIdRate);
	}
	
	/**
	 * Возвращает сезон ценовых продложений
	 * @param int $iIdRate
	 * @param int $iIdHotel
	 */
	public function getRateBids($iIdRate, $iIdHotel){
		$aRoomsSettlement = App_Service_Hotel_Room::getInstance()
			->getRoomsSettlement($iIdHotel);
		return $this->_tblRateState->getRateCompile($iIdRate, $aRoomsSettlement);
	}
	
	/**
	 * Сохранение сезона
	 * @param array $aRate
	 * @param array $aBids
	 * @return boolean
	 */
	public function setRate(array $aRate, array $aBids){
		#Cлучай уменьшения интервала сезона
		$dB = $dE = null;
		if(!empty($aRate['id_rate'])){
			$oRate = $this->get($aRate['id_rate']);
			if(!$oRate) return false;
			# Обновление по максимуму
			$dB = ($oRate->date_start > $aRate['date_start'])
					? $aRate['date_start'] : $oRate->date_start;
			$dE = ($oRate->date_end > $aRate['date_end'])
					? $oRate->date_end : $aRate['date_end'];
			unset($oRate);
		}
		
		$iIdRate = $this->_tblRate->setRate($aRate);
		if(!$iIdRate) return false;
		
		$oRate = $this->_tblRate->get($iIdRate);
		if($oRate){
			$iIdHotel = $oRate->id_hotel;
			$dB		  = $dB ? $dB : $oRate->date_start;
			$dE		  = $dE ? $dE : $oRate->date_end;
			$iCrossRate = App_Service_Exchange::getInstance()
				->getCrossRateNormalizeByHotel($iIdHotel);
			$this->_setRateState($iIdRate, $iIdHotel, $aBids, $iCrossRate);
			$this->_setRateProcessing($iIdHotel, $dB, $dE);
		}
		return $iIdRate;
	}
	
	
	public function copyRate($rate_id){
		
		return  $this->_tblRate->copyRate($rate_id);
		
	}
	
	
	/**
	 * Сохранение состояния ценовых предложений сезона
	 * @param int $iIdRate
	 * @param int $iIdHotel
	 * @param array $aBids
	 */
	protected function _setRateState($iIdRate, $iIdHotel, $aBids = array(), 
										$iCrossRate = 1)
	{
		$aRoomsSettlement = App_Service_Hotel_Room::getInstance()
				->getRoomsSettlement($iIdHotel);
		return $this->_tblRateState->setRate(
			$iIdRate, 
			$iIdHotel, 
			$aBids, 
			$iCrossRate, 
			$aRoomsSettlement
		);
	}
	
	/**
	 * Обновление процессинговой таблицы ценовых предложений
	 * @param int $iIdHotel
	 * @param date $dB
	 * @param date $dE
	 */
	protected function _setRateProcessing($iIdHotel, $dB, $dE){
		# Выборка суммарного состояния (сезоны поподающие в интервал дат)
		$aRates = $this->_tblRateState->getRatesSummary($iIdHotel, $dB, $dE);
		# Подготовка процессинговых данных (Объединение сезонов)
		$aMergeRates = $this->_prfSaveProcessing($aRates, $dB, $dE);
		# Сохронение суммарного состояния
		return $this->_tblRateProcessing->updRate($iIdHotel, $aMergeRates, $dB, $dE);
	}
	
	/**
	 * Предподготовка к сохранению суммарного состояния ставок
	 * @param array $aRates
	 * @param date $dB
	 * @param date $dE
	 * @return array
	 */
	protected function _prfSaveProcessing($aRates, $dB, $dE){
		settype($aRates, 'array');
		$aDates = $this->buildDateOfWeek($dB, $dE);
		$aMergeRates = array();
		foreach ($aDates as $sDate => $iDay){
			foreach ($aRates as $aRate){
				$iIdHotel 		= $aRate['id_hotel'];
				$iIdRoom 		= $aRate['id_room'];
				$iIdBreakfast 	= $aRate['id_breakfast'];
				$iPartial 		= $aRate['partial'];
				$iIdGroup 		= $aRate['id_group'];
				
				//Для еженедельных сезонов 
				$bAction        = (int)$aRate['is_weekly']
					? (int)$aRate['week_days_action'][$iDay]
					: 1;
				
				$isPresent
					= isset(
						$aMergeRates
							[$iIdHotel]
								[$iIdRoom]
									[$iIdBreakfast]
										[$iPartial]
											[$sDate]
												[$iIdGroup]);
				
				#Попадание в сезон и не опоределен раннее
				if(!$isPresent 
					&& $sDate >= $aRate['date_start'] 
					&& $sDate <= $aRate['date_end']
					&& $bAction
				) {
					$aMergeRates
						[$iIdHotel]
							[$iIdRoom]
								[$iIdBreakfast]
									[$iPartial]
										[$sDate]
											[$iIdGroup] = array(
												'price' => $aRate['price'],
												'price_normalize' 	
													=> $aRate['price_normalize'],
											);
				}
			}
		}
		return $aMergeRates;
	}
	
	/**
	 * Сортировака сезонов
	 * @param int $iIdRate
	 * @param boolean $bDirection
	 * @return boolean
	 */
	public function chOrd($iIdRate, $bDirection){
		$bResult = $this->_tblRate->chOrd($iIdRate, $bDirection);
		#Обновление состояния
		if($bResult){
			$oRate = $this->get($iIdRate);
			$this->_setRateProcessing(
				$oRate->id_hotel,
				$oRate->date_start, 
				$oRate->date_end);
		}
		return $bResult;
	}
	
	/**
	 * Удаление сезона
	 * @param int $iIdRate
	 */
	public function del($iIdRate){
		$oRate = $this->get($iIdRate);
		if(!$oRate) return false;
		
		$this->_tblRateState->delRateState($iIdRate);
		$this->_tblRate->delRate($iIdRate);
		
		$this->_setRateProcessing(
				$oRate->id_hotel,
				$oRate->date_start,
				$oRate->date_end);
		
		return true;
	}
	
	 /**
	 * обновление начала сезона на дату $sDateStart
	 * @param int $iIdRate
	 */
	public function updateStart($iIdRate, $sDateStart) {
		$oRate = $this->get($iIdRate);
		if(!$oRate) return false;

		$this->_tblRate->setRate(array('id_rate' => $iIdRate, 'date_start' => $sDateStart));
		
		$this->_tblRateProcessing->deleteHotelRateByDate($oRate->id_hotel, $oRate->date_start, $sDateStart);
	
		$this->_setRateProcessing(
				$oRate->id_hotel,
				$sDateStart,
				$oRate->date_end);
	
		return true;	
	}
	
	
	/**
	 * Выборка ценовых предложений отелей для экспорта
	 */
	public function getExpRateFilter($aParams = array()){
		// @var App_Service_Hotel
		$oSrvHotel 		= App_Service_Hotel::getInstance();
		// @var App_Service_Hotel_Room
		$oSrvHotelRooms = App_Service_Hotel_Room::getInstance();
		// @var App_Service_Ref_Hotel_Breakfast
		$oSrvRefBreakfast = App_Service_Ref_Hotel_Breakfast::getInstance();
		// @var App_Service_Ref_Hotel_Room
		$oSrvRefRoom = App_Service_Ref_Hotel_Room::getInstance();
		
		$aSeasons	= array();
		$aIdHotels 	= (array)$aParams['id_hotel'];
		foreach ($aIdHotels as $idHotel){
			
			# Выборка сопутствующей информации об отеле
			$aSeasons[$idHotel] = array(
				'info'	=> $oSrvHotel->getHotelSummary($idHotel, $aParams['lang']),
				'params'=> $oSrvHotel->getParams($idHotel),
				'rooms'	=> $oSrvHotelRooms->getRoomsNames($idHotel, $aParams['lang']),
				'rooms_type' => $oSrvHotelRooms->getRoomsRefTypeIds($idHotel),
			);
			
			# Выборка сезонов ценовых предложений
			$aSeasons[$idHotel]['rates'] = $this->getExpRateHotel(
				(int)$idHotel, 
				$aParams['date_start'], 
				$aParams['date_end'], 
				(int)$aParams['id_group']
			);
			#Zend_Debug::dump($aSeasons[$idHotel]['rates'], '$aSeasons[$idHotel][rates]');
		}
		return array(
			'breakfasts' 	=> $oSrvRefBreakfast->getBreakfastsNames($aParams['lang']),
			'rooms' 		=> $oSrvRefRoom->getRoomsNames(),
			'hotels' 		=> $aSeasons
		);
	}
	
	/**
	 * Получить сезоны для экспорта ценовых предложений конкретного отеля
	 * @param int $idHotel
	 * @param date $dB
	 * @param date $dE
	 */
	public function getExpRateHotel($idHotel, $dB, $dE, $idGroup){
		
		$aIdsGroup = ($idGroup != 1)
			? array(1, $idGroup)
			: array(1);
		
		$aRatesPrices = $this->_tblRateState->getRatesSummaryGroup(
			$idHotel, 
			$dB, $dE, 
			$aIdsGroup
		);
		
		$aRatesHash = $this->_prfRateHeaders(
			$idHotel, $dB, $dE
		);
		
		$aSeasons = $this->_prfRatePacket(
			$aRatesHash, $aRatesPrices
		);
		
		return $aSeasons; 
	}
	
	/**
	 * Определение вновь образованных сезонов ценовых предложений 
	 * оброзовавшихся в результате слияния групп сезонов 
	 * с предоворительной группировкой на основании лишь номеров сливаемых сезонов
	 * (уплотнения периодов)
	 * @param $idHotel
	 * @param $dB
	 * @param $dE
	 */
	protected function _prfRateHeaders($idHotel, $dB, $dE)
	{
		# Получение заголовков сезонов поподающих в интервал выборки
		$aRates = $this->_tblRate->getRateSeasonsByPeriod($idHotel, $dB, $dE);
		#Zend_Debug::dump($aRates, '$aRates');
		
		$aDates     = $this->buildDateOfWeek($dB, $dE);
		$aHashRates = array();
		foreach ($aDates as $sDate => $iDay)
		{
			$aIdRates = array();
			foreach ($aRates as $aRate)
			{
				$bAction = (int)$aRate['is_weekly']
					? (int)$aRate['week_days_action'][$iDay]
					: 1 
				;
				if( $bAction
				 && $sDate >= $aRate['date_start']
				 && $sDate <= $aRate['date_end']
				){
					$aIdRates[] = $aRate['id_rate'];
				}
			}
			$sHash = md5(implode('-', $aIdRates));
			$aHashRates[$sHash]['rates']   = $aIdRates;
			$aHashRates[$sHash]['dates'][] = $sDate;
		}
		
		return $aHashRates;
	}
	
	/**
	 * Группировка сезонов(ценовых предложений) 
	 * на основании эквивалентности цен
	 * @param array $aHeaders
	 * @param array $aRates
	 * @return array
	 */
	protected function _prfRatePacket($aHeaders, $aRates)
	{
		$aHashPrices = array();
		foreach ($aHeaders as $sHashRate => &$aSegment)
		{
			$aRate = $this->_prfRateCompile(
				$aRates, 
				$aSegment['rates']
			);
			$sHashPrice = md5(serialize($aRate));
			$aHashPrices[$sHashPrice]['price'] = $aRate;
			$aHashPrices[$sHashPrice]['rates_hash'][] = $sHashRate;
		}
		
		#Слиание смежных эквивалентных сезонов 
		foreach ($aHashPrices as $sHashPrice => &$aSegment){
			$aSegment['dates'] = array();
			foreach ($aSegment['rates_hash'] as $sHashRate){
				$aSegment['dates'] = array_merge(
					$aSegment['dates'], $aHeaders[$sHashRate]['dates']
				);
			}
			unset($aSegment['rates_hash']);
		}
		
		//Упаковка дат сезонов, 
		foreach ($aHashPrices as &$aSegment)
		{
			$iSeason   = 0;
			$aSeasons  = array();
			$sDateLast = null;
			asort($aSegment['dates']);
			foreach ($aSegment['dates'] as $sDate)
			{
				$dn = new DateTime($sDate);
				$dn->modify("-1 day");
				if($dn->format("Y-m-d") != $sDateLast){
					$aSeasons[++$iSeason]['date_start'] = $sDate;
				}
				$aSeasons[$iSeason]['date_end'] = $sDate;
				$sDateLast = $sDate;
			}
			$aSegment['segments'] = $aSeasons;
			unset($aSegment['dates']);
		}
		
		return $aHashPrices;
	}
	
	/**
	 * Выборка необходимых ценовых предложений 
	 * в соответсвии с провилами слияния сезонов
	 * из общего массива сезонов
	 * @param array $aRates
	 * @param array $aIdRatesAction
	 * @return array
	 */
	protected function _prfRateCompile(&$aRates, &$aIdRatesAction){
		$aSeason = array();
		foreach ($aRates as $aBid){
			$idRoom 		= $aBid['id_room'];
			$idBreakfast 	= $aBid['id_breakfast'];
			$iPartial 		= $aBid['partial'];
			$idGroup 		= $aBid['id_group'];
			$fPrice 		= (float)$aBid['price'];
			
			$bAction = in_array($aBid['id_rate'], $aIdRatesAction);
			$isEmpty = empty($aSeason[$idBreakfast][$idRoom][$iPartial][$idGroup]);
			
			if($bAction && $isEmpty) {
				$aSeason[$idBreakfast]
							[$idRoom]
								[$iPartial]
									[$idGroup] = $fPrice
				;
			}
		}
		return $aSeason;
	}
	
	/**
	 * Возвращает сезоны ценовых предложений по отелю за период
	 */
	public function getRateSeasonsByPeriod($iIdHotel, $dB, $dE) {
		return $this->_tblRate->getRateSeasonsByPeriod($iIdHotel, $dB, $dE);
	}
	
	/**
	 * Return array all days betwin begin and end 
	 * @param DateTime $dB
	 * @param DateTime $dE
	 * @return array
	 */
	public function buildDateOfWeek($dB, $dE){
		$aD   = array();
		$dB = new DateTime($dB);
		$dE = new DateTime($dE);
		$dE->modify("+1 day");
		while($dE > $dB)
		{
			$aD[$dB->format('Y-m-d')] = $dB->format('w'); 
			$dB->modify("+1 day");
		}
		return $aD;
	}
	
	/**
	 * Вспомагательная функция преобразует масиив $a
	 * в ассоциативный массив записей с ключём $k   
	 * @param array $a
	 * @param string $k
	 * @return Ambigous <multitype:, array>
	 */
	private function _fetch($a, $k){
		$r = array();
		foreach($a as $v) $r[$v[$k]] = $v;
		return $r;
	}
	
	private function _fetch_group($a, $k){
		$r = array();
		foreach($a as $v) $r[$v[$k]][] = $v;
		return $r;
	}
	
	public function getMinMaxPriceByDate($iIdHotel, $dB, $dE, $iIdGroup) 
	{
		$aPrice = $this->_tblRateProcessing
			->getMinMaxPriceByDate($iIdHotel, $dB, $dE, $iIdGroup); 
		return $this->_fetch($aPrice, 'id_room');
	}
	
	/**
	 * Поиск ценовых предложений
	 * @param array $aData
	 * @return array
	 */
	public function search($aData, $iPage = 1, $iLimit = 15, $aSort = array())
	{
		$aData['id_group'] 	 = isset($aData['id_group'])  ?intval($aData['id_group']):1;
		$aData['cnt_room'] 	 = isset($aData['cnt_room'])  ?intval($aData['cnt_room']):1;
		$aData['cnt_adult']  = isset($aData['cnt_adult']) ?intval($aData['cnt_adult']):1;
		$aData['cnt_child1'] = isset($aData['cnt_child1'])?intval($aData['cnt_child1']):0;
		$aData['cnt_child2'] = isset($aData['cnt_child2'])?intval($aData['cnt_child2']):0;
		$aData['cnt_child3'] = isset($aData['cnt_child3'])?intval($aData['cnt_child3']):0;
		
		# Количество ночей
		$iCntNight 	= $this->getCountNight(
			$aData['arrival_date'],
			$aData['departure_date']
		);
		
		$aData['cnt_n']	= (int) $iCntNight;
		$aData['cnt_p']	= (int)$aData['cnt_adult']
			+ (int)$aData['cnt_child1']
			+ (int)$aData['cnt_child2']
			+ (int)$aData['cnt_child3'];
		
		# Максимальная цена за ночь
		if(!empty($aData['max_price'])){
			$sCurrency = !empty($aData['currency']) ? $aData['currency'] : 'USD';
			$aData['max_price'] = App_Service_Exchange::getInstance()
				->convert(
					floatval($aData['max_price']), 
					$sCurrency, 
					'USD', 
					$aData['id_group']
				);
		}
		
		# Поиск ценовых предложений
		$aRates = $this->_tblRateProcessing->search($aData, $iPage, $iLimit, $aSort);
		
		# Количество номеров
		$iTicket = (int) $aData['cnt_room'];
		
		// Установка типа заказа с учетом 
		// количества номеров и непрерывности интервалов 
		// по Квотам, по Свободным продажам 
		// и наличием Остановки продаж
		foreach ($aRates['rows'] as &$aBid){
			#$aBid['order_price'] *= $iTicket;
			if($aBid['_cnt_stopsell_']){
				$aBid['type'] = 'stopsell';
				continue;
			}
			if($aBid['is_quota'] >= $iTicket){
				$aBid['type'] = 'quota';
				continue;
			}
			if($aBid['is_freesell'] >= $iTicket){
				$aBid['type'] = 'freesell';
				continue;
			}
			$aBid['type'] = 'request';
		}
		return $aRates;
	}
	
	/**
	 * Количество ночей между датами
	 * @param date $dB
	 * @param date $dE
	 * @return int
	 */
	public function getCountNight($dB, $dE){
		Zend_Date::setOptions(array('fix_dst' => false));
		$dB = new Zend_Date($dB, Zend_Date::DATES);
		$dE = new Zend_Date($dE, Zend_Date::DATES);
		return bcdiv((string)$dE->sub($dB)->toValue(), '86400');
	}
	
	/**
	 * Количество ночей между датами 
	 * Расчетное с учетом заездов
	 * @param date $dB
	 * @param date $dE
	 * @return float
	 */
	public function getCountNightCustom($dB, $dE, $iEarly = 0, $iLate = 0){
	    $iCnt  = $this->getCountNight($dB, $dE);
		$iAdd = (int)$iEarly * 0.5 + (int)$iLate *0.5; 
		return $iCnt + $iAdd;
	}
	
	/**
	 * Возвращает ценовые предложения по дополнительным местам отеля
	 * @param int $iIdHotel
	 * @return array
	 */
	public function getRateExtraBedBids($iIdHotel){
		return $this->_tblRateExtra->getRateCompile($iIdHotel);
	}
	
	/**
	 * Сохранение ценовых предложений для доплнительных мест
	 * @param int $iIdHotel
	 * @param array $aBids
	 * @return boolean
	 */
	public function setRateExtraBedBids($iIdHotel, array $aBids){
		$iCrossRate = App_Service_Exchange::getInstance()
				->getCrossRateNormalizeByHotel($iIdHotel);
		$bResult = $this->_tblRateExtra->setRate($iIdHotel, $aBids, $iCrossRate);
		return $bResult;
	}
	
	/**
	 * Нормализация ценовых предложений Отеля
	 * @param int $iIdHotel
	 * @param float $iCrossRate
	 * 
	 */
	public function normalize($iIdHotel){
		
		$iCrossRate = App_Service_Exchange::getInstance()
				->getCrossRateNormalizeByHotel($iIdHotel);
		
		$oAdapter = $this->_tblRateProcessing->getAdapter();
		$oAdapter->beginTransaction();
		
		# Обновление billing_hotel_rate_extra_bed
		$this->_tblRateExtra->normalize($iIdHotel, $iCrossRate);
		
		# Обновление billing_hotel_rate_state
		$this->_tblRateState->normalize($iIdHotel, $iCrossRate);
		
		# Обновление billing_hotel_rate_processing
		$this->_tblRateProcessing->normalize($iIdHotel, $iCrossRate);
		
		$oAdapter->commit();
		return true;
	}
	
	public function checkOfferTime($aOfferTime, $oHotelParams){
		$aData = array(
			'is_arrival_early' 	=> 0,
			'is_departure_late' => 0,
		);
		
		if(!$aOfferTime)
			return $aData;
		
		if($oHotelParams['arrival_time'] > $aOfferTime['arrival_time']){
            $aData['is_arrival_early'] = 1;
            if($oHotelParams['arrival_time_early'] > $aOfferTime['arrival_time']){
                $aData['is_arrival_early'] = 2;
            }
		}
		if($oHotelParams['departure_time'] < $aOfferTime['departure_time']){
			$aData['is_departure_late'] = 1;
    		if($oHotelParams['departure_time_late'] < $aOfferTime['departure_time']){
    			$aData['is_departure_late'] = 2;
    		}
		}
		return $aData;
	}
	
	/**
	 * Расчет размещения в номере
	 * @param $aOfferKeys
	 * @param $oRoomParams
	 */
	public function getOfferAccom($aOfferKeys, $oRoomParams){
		$iCntRoom		= (int)$aOfferKeys['cnt_room'];
		$iCntAdult 		= (int)$aOfferKeys['cnt_adult'];
		$iCntChildC1 	= (int)$aOfferKeys['cnt_child1'];
		$iCntChildC2 	= (int)$aOfferKeys['cnt_child2'];
		$iCntChildC3 	= (int)$aOfferKeys['cnt_child3'];
		
		$iCntPerson 	= $iCntAdult 
			+ $iCntChildC1 + $iCntChildC2 + $iCntChildC3;
		
		$iCntMax = $oRoomParams['seats'] + $oRoomParams['additional_bed'];
		if($iCntMax < $iCntPerson)
				return false;
		
		$iCntMaxAdult = $oRoomParams['seats'] + ($oRoomParams['additional_bed'] ? 1:0);
		if($iCntMaxAdult < $iCntAdult)
				return false;
		
		if($aOfferKeys['partial'] < $oRoomParams['seats']
				&& $iCntPerson > $oRoomParams['seats'])
				return false;
		
		$iFreeBasic   = 0;
		$iCntExtAdult = 0;
		if($iCntAdult > $oRoomParams['seats']){
			$iCntExtAdult = $iCntAdult - $oRoomParams['seats'];
		}else{
			$iFreeBasic = $oRoomParams['seats'] - $iCntAdult;
		}
		
		$iCntExtChildC3 = $iCntChildC3;
		if($iFreeBasic && $iCntChildC3){
			if($iFreeBasic >= $iCntChildC3){
				$iCntExtChildC3 = 0;
				$iFreeBasic -= $iCntChildC3;
			}else{
				$iCntExtChildC3 = $iCntChildC3-$iFreeBasic;
				$iFreeBasic = 0;
			}
		}
		$iCntExtChildC2 = $iCntChildC2;
		if($iFreeBasic && $iCntChildC2){
			if($iFreeBasic >= $iCntChildC2){
				$iCntExtChildC2 = 0;
				$iFreeBasic -= $iCntChildC2;
			}else{
				$iCntExtChildC2 = $iCntChildC2-$iFreeBasic;
				$iFreeBasic = 0;
			}
		}
		$iCntExtChildC1 = $iCntChildC1;
		if($iFreeBasic && $iCntChildC1){
			if($iFreeBasic >= $iCntChildC1){
				$iCntExtChildC1 = 0;
				$iFreeBasic -= $iCntChildC1;
			}else{
				$iCntExtChildC1 = $iCntChildC1-$iFreeBasic;
				$iFreeBasic = 0;
			}
		}
		
		$isExtraBreakfast = 0;
		if(isset($aOfferKeys['extra_breakfast'])){
          $isExtraBreakfast = (int)$aOfferKeys['extra_breakfast'];
		}
		return array(
			'cnt_room'		=> $iCntRoom,
			'cnt_adult'		=> $iCntAdult,
			'cnt_child1' 	=> $iCntChildC1,
			'cnt_child2' 	=> $iCntChildC2,
			'cnt_child3' 	=> $iCntChildC3,
		
			'cnt_person'	=> $iCntPerson,
			'cnt_ext_a'		=> $iCntExtAdult,
			'cnt_ext_c1'	=> $iCntExtChildC1,
			'cnt_ext_c2'	=> $iCntExtChildC2,
			'cnt_ext_c3'	=> $iCntExtChildC3,
		    'extra_breakfast' => $isExtraBreakfast,
		);
	}
	
	/**
	 * Получить подробное ценовое предложение
	 * @param array $aOfferKeys
	 * @param array $oHotelParams
	 */
	public function getOffer($aOfferKeys, $oHotelParams){
		
		$aPrice = $this->getPriceOffer($aOfferKeys);
		if(!$aPrice) return false;
		
		$aOffer = array();
		$aOffer['price']   = $aPrice;
		$aOffer['penalty'] = $this->calcPenalty($aPrice, $oHotelParams);
		$aOffer['type']	   = $this->getPriceType(
			$aPrice,
			(int)$aOfferKeys['cnt_room'],
			$oHotelParams
		);
		
		return $aOffer;
	}
	
	/**
	 * Получить инф. о предложении
	 * @param array $aOfferKeys
	 * @param string $sLang
	 * @return array
	 */
	public function getOfferParams($aOfferKeys, $sLang = 'ru'){
		
		$oHotel			= App_Service_Hotel::getInstance()
							->getHotelInfo($aOfferKeys['id_hotel'], $sLang);
		$oHotelParams	= App_Service_Hotel::getInstance()
							->getParams($aOfferKeys['id_hotel']);
		$oRoom			= App_Service_Hotel_Room::getInstance()
							->getRoom($aOfferKeys['id_room'], true);
		$oBreakfast		= App_Service_Ref_Hotel_Breakfast::getInstance()
								->get($aOfferKeys['id_breakfast'], true);
							
		return array(
			'hotel' 		=> $oHotel,
			'hotel_params' 	=> $oHotelParams,
			'room' 			=> $oRoom,
			'breakfast' 	=> $oBreakfast,
		);
	}
	
	/**
	 * Стоимость основных, дополнительных мест номера по дням
	 * @param array	$aOfferKeys
	 * @param bool 	$bContinuity Проверка на непрерывность
	 * @return array
	 */
	public function getPriceOffer($aOfferKeys, $bContinuity = true)
	{
		# Выборка price, qouta, freesell, stopsell
		$aPrice = $this->_tblRateProcessing->getExtPriceOrder($aOfferKeys);
		$aPriceGrouped = $this->_fetch($aPrice, 'date');
		
		# Поверка на непрырывность (исключение для календаря)
		if($bContinuity){
			$iCntNight = $this->getCountNight(
			  $aOfferKeys['arrival_date'], 
			  $aOfferKeys['departure_date']
			);
			$iCntPrice = count($aPriceGrouped);
			return $iCntNight == $iCntPrice 
				? $aPriceGrouped 
				: false;
		}
		return $aPriceGrouped;
	}
	
	/**
	 * Определение типа заказа
	 * @param array $aPrice
	 * @param количество номеров $iTicket
	 * @return string
	 */
	public function getPriceType($aPrice, $iTicket, $oHotelParams){
		
		$oHotelParams['quota_period'] = !empty($oHotelParams['quota_period'])
			? (int)$oHotelParams['quota_period'] : 0;
		
		$dB = new Zend_Date();
		$sDateQuoted = $dB
			->addHour($oHotelParams['quota_period'])
			->toString('yyyy-MM-dd');
		
		$iCntDate 	= 0;
		$aTypeCnt 	= array(
			'stopsell' 	=> 0,
			'request' 	=> 0,
			'quota' 	=> 0,
			'freesell' 	=> 0,
		);
		foreach($aPrice as $sKeyDate => $aDate){
			$iCntDate++;
			if($aDate['_cnt_stopsell_']){
				$aTypeCnt['stopsell']++;
			}elseif($sDateQuoted > $sKeyDate){
				$aTypeCnt['request']++;
			}elseif($aDate['_cnt_quota_'] >= $iTicket){
				$aTypeCnt['quota']++;
			}elseif($aDate['_cnt_freesell_'] >= $iTicket){
				$aTypeCnt['freesell']++;
			}else{
				$aTypeCnt['request']++;
			}
		}
		
		if($aTypeCnt['stopsell']){
			$sType = 'stopsell';
		}elseif($aTypeCnt['request']){
			$sType = 'request';
		}elseif($aTypeCnt['quota'] == $iCntDate){
			$sType = 'quota';
		}elseif($aTypeCnt['freesell'] == $iCntDate){
			$sType = 'freesell';
		}else{
			$sType = 'request';
		}
		
		return $sType;
	}
	/**
	 * Подсчет стоимости заказа
	 * @param array $aPrices
	 * @param array $aAccomodation
	 * @param float $iCrossRate
	 * @return number
	 */
	public function calcPrice($aOffer, $aAccomodation, $iCrossRate = 1)
	{
		$fPrice    	= 0;
		$fAddPrice 	= 0;
		$iCntNight 	= 0;
		$aPrices   	= $aOffer['price'];
		$aPenalty  	= $aOffer['penalty'];
		$aPriceF   	= current($aPrices);	$sKeyPriceF = key($aPrices);
		$aPriceE   	= end($aPrices);		$sKeyPriceE = key($aPrices);
		
		#Доплата за доп. места
		if($aAccomodation['cnt_ext_a'])
			$fAddPrice += round($aPriceF['price_adult'])  * $aAccomodation['cnt_ext_a'];
		if($aAccomodation['cnt_ext_c1'])
			$fAddPrice += round($aPriceF['price_child1']) * $aAccomodation['cnt_ext_c1'];
		if($aAccomodation['cnt_ext_c2'])
			$fAddPrice += round($aPriceF['price_child2']) * $aAccomodation['cnt_ext_c2'];
		if($aAccomodation['cnt_ext_c3'])
			$fAddPrice += round($aPriceF['price_child3']) * $aAccomodation['cnt_ext_c3'];
		
		#Стоимость заказа по дням
		$aPricesDate = array();
		foreach ($aPrices as $sDate => $aPrice){
			$iCntNight++;
			$fPrice += round($aPrice['price']);
			$aPricesDate[$sDate] = array(
				'date' 	=> $sDate,
				'price' => (round($aPrice['price']) + $fAddPrice) * $iCrossRate,
			);
		}
		$fAddPrice *= $iCntNight;
		
		#Доплата за доп. завтрак
		$fAddBreakfast = 0;
		if($aAccomodation['extra_breakfast']){
		    $fBreakfastPrice = round($aPenalty['extra_breakfast']);
    		if($aAccomodation['cnt_adult']){
    			$fAddBreakfast += $fBreakfastPrice * $aAccomodation['cnt_adult'];
    			$aPricesDate[$sKeyPriceF]['price'] 
    	          += $fBreakfastPrice * $aAccomodation['cnt_adult'] * $iCrossRate;
    		}
    		#Первая категория детей не учитывается	
    		if($aAccomodation['cnt_child2']){
    			$fAddBreakfast += $fBreakfastPrice * $aAccomodation['cnt_child2'];
    			$aPricesDate[$sKeyPriceF]['price'] 
    	          += $fBreakfastPrice * $aAccomodation['cnt_child2'] * $iCrossRate;
    		}
    		if($aAccomodation['cnt_child3']){
    			$fAddBreakfast += $fBreakfastPrice * $aAccomodation['cnt_child3'];
    			$aPricesDate[$sKeyPriceF]['price'] 
    	          += $fBreakfastPrice * $aAccomodation['cnt_child3'] * $iCrossRate;
    		}
		}
		$fAddPrice += $fAddBreakfast;
		
		#Доплаты за ранний заезд 
		if($aAccomodation['is_arrival_early'] == 1){
			$fAddPrice += $aPenalty['arrival'];
			$aPricesDate[$sKeyPriceF]['price'] 
				+= $aPenalty['arrival'] * $iCrossRate;
		}elseif($aAccomodation['is_arrival_early'] == 2){
			$fAddPrice += $aPenalty['arrival_extra'];
			$aPricesDate[$sKeyPriceF]['price']
				+= $aPenalty['arrival_extra'] * $iCrossRate;
		}
		#Доплаты за поздний выезд
		if($aAccomodation['is_departure_late'] == 1){
			$fAddPrice += $aPenalty['departure'];
			$aPricesDate[$sKeyPriceE]['price'] 
				+= $aPenalty['departure'] * $iCrossRate;
		}elseif($aAccomodation['is_departure_late'] == 2){
			$fAddPrice += $aPenalty['departure_extra'];
			$aPricesDate[$sKeyPriceE]['price'] 
				+= $aPenalty['departure_extra'] * $iCrossRate;
		}
		
		$fPrice = (($fPrice + $fAddPrice) * $aAccomodation['cnt_room']) * $iCrossRate;
		return array($fPrice, $aPricesDate);
	}
	
	/**
	 * Календарь стоимастей по неделям дням
	 * @return array
	 */
	public function calcPriceCalendar($aOfferKey, $aAccomodation, $iCrossRate)
	{
		# Начало недели 
		$dB     = $aOfferKey['arrival_date'];
		$dBWeek = new Zend_Date($dB);
		$dBWeek->setWeekDay(1);
		# Конец  недели 
		$dE		= $aOfferKey['departure_date'];
		$dEWeek = new Zend_Date($dE);
		$dEWeek->setWeekDay(7)->addDay(1);
		
		$aKeyPriceOfferWeek = array_merge(
			$aOfferKey, array(
			'arrival_date'	 => $dBWeek->toString('yyyy-MM-dd'),
			'departure_date' => $dEWeek->toString('yyyy-MM-dd'),
			)
		);
		
		$aPrice = $this->getPriceOffer($aKeyPriceOfferWeek, false);
		#Zend_Debug::dump($aPrice, '$aPrice');
		
		$aWeekPrice = array();
		$iBWeek = $dBWeek->toValue('ww');
		while ($dBWeek < $dEWeek){
			#Неделя
	        $iWeek 	  = $dBWeek->toValue('ww') - $iBWeek;
	        #День недели
			$iWeekDay = $dBWeek->toValue('e');
			
			$sDate = date('Y-m-d', $dBWeek->getTimestamp());
			$aWeekPrice[$iWeek][$sDate] = $aPrice[$sDate];
			if(!empty($aPrice[$sDate])){
				$fPrice = ($aPrice[$sDate]['price']
					+ $aAccomodation['cnt_ext_a']  
						* $aPrice[$sDate]['price_adult']
					+ $aAccomodation['cnt_ext_c1'] 
						* $aPrice[$sDate]['price_child1']
					+ $aAccomodation['cnt_ext_c2'] 
						* $aPrice[$sDate]['price_child2']
					+ $aAccomodation['cnt_ext_c3'] 
						* $aPrice[$sDate]['price_child3'])
							* $aAccomodation['cnt_room']
							* $iCrossRate;
				
				$aWeekPrice[$iWeek][$sDate]['price'] = $fPrice;
				
				#Тип заказа на день
				if($aPrice[$sDate]['_cnt_stopsell_']){
					$sType = 'stopsell';
				}elseif($aPrice[$sDate]['_cnt_quota_']){ 	
					$sType = 'quota';
				}elseif($aPrice[$sDate]['_cnt_freesell_']){ 	
					$sType = 'freesell';
				}else{
					$sType = 'request';
				}
				$aWeekPrice[$iWeek][$sDate]['type'] = $sType;
			}else{
				$aWeekPrice[$iWeek][$sDate]['price'] = '-';
				$aWeekPrice[$iWeek][$sDate]['type']  = 'request';
			}
			
			$isInclude = $sDate >= $dB && $sDate < $dE;
			$aWeekPrice[$iWeek][$sDate]['booking'] = $isInclude; 
			
			$dBWeek->addDay(1);
		}
		return $aWeekPrice;
	}
	
	/**
	 * Подсчёт штрафов 
	 * @param array $aPrice
	 * @param array $oHotelParams
	 */
	public function calcPenalty($aPrice, $oHotelParams){
		$aPenalty 	 = array();
		$aPriceFirst = current($aPrice);
		$aPriceLast  = end($aPrice);
		
		$penaltyArrivalParm   = (int)$oHotelParams['payment_arrival_early'];
		$penaltyDepartureParm = (int)$oHotelParams['payment_departure_late'];
        $aPenalty['arrival']         = round($aPriceFirst['price'] * $penaltyArrivalParm / 100);
		$aPenalty['arrival_extra']   = round($aPriceFirst['price']);
		$aPenalty['departure']	     = round($aPriceLast['price'] * $penaltyDepartureParm / 100);
		$aPenalty['departure_extra'] = round($aPriceLast['price']);
		$aPenalty['cancel']	         = round($aPriceFirst['price'] * (int)$oHotelParams['penalty_not_show']);
		
		$aPenalty['extra_breakfast'] = 0;
		if($oHotelParams['allow_extra_breakfast']){
		  $aPenalty['extra_breakfast'] = round($oHotelParams['extra_breakfast_price']);
		}
		
		return $aPenalty;
	}
}