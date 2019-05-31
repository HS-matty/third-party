<?php
/**
 * Price_RateController
 */
class Price_RateController extends App_Controller_Places {
	
	/**
	 * @var App_Service_Hotel
	 */
	private $_oSrvHotel = null;
	/**
	 * @var App_Service_Hotel_Room
	 */
	private $_oSrvHotelRoom = null;
	/**
	 * @var App_Service_Hotel_Breakfast
	 */
	private $_oSrvHotelBreakfast = null;
	
	/**
	 * @var App_Service_Ref_Room
	 */
	private $_oSrvRefRoom = null;
	/**
	 * @var App_Service_Ref_Breakfast
	 */
	private $_oSrvRefBreakfast = null;
	/**
	 * @var App_Service_User_Outer
	 */
	private $_oSrvUser = null;
	/**
	 * @var App_Service_Price
	 */
	private $_oSrvPrice = null;
	
	public function init()
	{
		$this->_oSrvHotel 		= App_Service_Hotel::getInstance();	
		$this->_oSrvHotelRoom 	= App_Service_Hotel_Room::getInstance();	
		$this->_oSrvHotelBreakfast = App_Service_Hotel_Breakfast::getInstance();	
		$this->_oSrvRefRoom 	= App_Service_Ref_Hotel_Room::getInstance();
		$this->_oSrvRefBreakfast= App_Service_Ref_Hotel_Breakfast::getInstance();
		$this->_oSrvUser 		= App_Service_User_Outer::getInstance();
		$this->_oSrvPrice 		= App_Service_Price::getInstance();
		parent::init();
		$this->buildHotelsTreeMenu('/price/rate/filter/id_hotel/');
	}
	
	public function indexAction(){}
	
	/**
	 * Фильтр сезонов ценовых предложений
	 */
	public function filterAction(){
		$iIdHotel = (int) $this->_getParam('id_hotel');
		if(!$iIdHotel) $this->_redirect('/price/rate/index');
		
		$oHotel 	= $this->_oSrvHotel->get($iIdHotel);
		$aRates		= array();
		$oForm 		= new App_Form_Price_Filter();
		
		if($oForm->isValid($_GET)){
			$aData 	= $oForm->getValues();
			$dB = new Zend_Date($aData['date_start']);
			$dE	= new Zend_Date($aData['date_end']);
			
			# Сезоны
			$aRates = $this->_oSrvPrice
				->getRateSeasonsByPeriod(
					$iIdHotel,
					$dB->get('yyyy-MM-dd'),
					$dE->get('yyyy-MM-dd')
				);
			
			# Месяцы периода
			$aMonths = array();
			$dT = new Zend_Date($dB->get('yyyy-MM-01'));
			while ($dT <= $dE) {
				$aMonths[] 	= $dT->get(Zend_Date::MONTH_NAME_SHORT, "en");			
				$dT->add(1, Zend_Date::MONTH);
			}
			
			$this->assign(array(
				'aRates' 	 => $aRates,
				'sDateStart' => $dB->get('yyyy-MM-01'),
				'sDateEnd'   => $dE->get('yyyy-MM-ddd'),
				'aMonths'    => $aMonths				
			));
		}
		
		$this->view->form = $oForm;
		$this->assign(array(
			'iIdHotel' 	=> $iIdHotel,
			'oHotel'	=> $oHotel,
		));
	}
	
	
	public function copyAction(){
		
		$rate_id = (int) $this->_getParam('id_rate');
		$hotel_id = (int) $this->_getParam('id_hotel');
		
		$this->_oSrvPrice->copyRate($rate_id);
		$this->_redirect('/price/rate/filter/id_hotel/'.$hotel_id);
		
		
		
		
	}
	
	
	/**
	 * Управление сезонами ценовых предложений 
	 * Добавление/Редактирование 
	 */
	public function updateAction(){
		$iIdHotel = (int) $this->_getParam('id_hotel');
		$iIdRate  = (int) $this->_getParam('id_rate');
		if(!$iIdHotel) $this->_forward('filter','rate','price');
		
		$oForm  = new App_Form_Price_Rate_Update();
		$oForm->setHotel($iIdHotel);
		$aBids  = $this->_getParam('bids', array());
		
		if($this->_request->isPost()){
			if($oForm->isValid($_POST)){
				
				$copy_flag = (int) $this->_getParam('is_copy');
				$aData  = $oForm->getValues();
				
				if($copy_flag){
					
					 $new_rate = $this->_oSrvPrice->copyRate($iIdRate);
					 $iIdRate = $new_rate['id_rate'];
					 $aData['id_rate'] = $iIdRate;
				}
				
				$this->_oSrvPrice->setRate($aData, $aBids);
				$this->addMessage(array(
					'message' => 'Сезон успешно сохранён', 
					'status'  => 'success'
				));
				$this->_redirect('/price/rate/filter/id_hotel/'.$iIdHotel);
			}
		}elseif($iIdRate){
			$aRate = $this->_oSrvPrice->get($iIdRate);
			if($aRate){
				$oForm->populate($aRate->toArray());
				$aBids = $this->_oSrvPrice->getRateBids($iIdRate, $iIdHotel);
			}
		}
		
		#Номера отеля
		$aRooms	= $this->_oSrvHotelRoom->getRooms($iIdHotel);
		$aRooms = $this->_fetch($aRooms->toArray(), 'id_room');
		
		#Завтраки номеров отелея
		$aBreakfasts = $this->_oSrvHotelBreakfast
								->getRoomBreakfastByHotel($iIdHotel);
		$aBreakfasts = $this->_fetch_group($aBreakfasts, 'id_ref_breakfast');

		$this->setLayout('admin/admin-tpl');
		$this->view->oForm = $oForm;
		$this->assign(array(
			'aBreakfasts'	=> $aBreakfasts,
			'aRooms'		=> $aRooms,
			'aRefRoom' 		=> $this->_oSrvRefRoom->getRoomsNames(),
			'aRefBreakfast' => $this->_oSrvRefBreakfast->getBreakfastsNames(),
			'aGroup'   		=> $this->_oSrvUser->getAllGroup()->toArray(),
			'iIdHotel' 		=> $iIdHotel,
			'oHotel' 		=> $this->_oSrvHotel->get($iIdHotel),
			'aHotelParams' 	=> $this->_oSrvHotel->getParams($iIdHotel),
			'aBids' 		=> $aBids,
		));
	}
	
	/**
	 * Управеление ценами на дополнительные места
	 */
	public function extraBedAction(){
		$iIdHotel = (int) $this->_getParam('id_hotel');
		if(!$iIdHotel) $this->_redirect('/price/rate/index');
		$oHotel  = $this->_oSrvHotel->get($iIdHotel);
		$aRooms  = $this->_oSrvHotelRoom->getRooms($iIdHotel);
		$aBids   = $this->_getParam('bids', array());
		$oForm 	 = new App_Form_Price_Rate_ExtraBed();
		
		if($this->_request->isPost()){
			$this->_oSrvPrice->setRateExtraBedBids($iIdHotel, $aBids);
			$this->addMessage(array(
				'message' => 'Информация обновлена',
				'status'  => 'success'
			));
			$this->_redirect('/price/rate/filter/id_hotel/'.$iIdHotel);
		}else{
			$aBids = $this->_oSrvPrice->getRateExtraBedBids($iIdHotel);
		}
		
		$aExtraGroupNames = App_Service_Ref_Hotel_Child::getInstance()
			->getChildNames();
		
		$this->setLayout('admin/admin-tpl');
		$this->view->oForm = $oForm;
		$this->assign(array(
			'iIdHotel' 	=> $iIdHotel,
			'oHotel'	=> $oHotel,
			'aRooms'	=> $aRooms,
			'aGroup'	=> $aExtraGroupNames,
			'aRefRoom' 	=> $this->_oSrvRefRoom->getRoomsNames(),
			'aBids'		=> $aBids,		
		));
	}

	/**
	 * Сортировка сезонов ценовых предложений
	 */
	public function ordAction(){
		$iIdHotel = (int) $this->_getParam('id_hotel');
		$iIdRate  = (int) $this->_getParam('id_rate');
		if(!$iIdHotel || !$iIdRate) 
			$this->_forward('filter','rate','price');
		
		# Напровление сортировки
		$bDirection = (bool) $this->_getParam('direction');
		$r = $this->_oSrvPrice->chOrd($iIdRate, $bDirection);
		if($r){
			$this->addMessage(array(
				'message' => 'Порядок наложения сезонов изменён', 
				'status'  => 'success'
			));
		} else {
			$this->addMessage(array(
				'message' => 'Порядок наложения сезонов НЕ изменён', 
				'status'  => 'error'
			));
		}
		$this->_redirect('/price/rate/filter/id_hotel/'.$iIdHotel);
	}
	
	public function deleteAction(){
		$iIdHotel = (int) $this->_getParam('id_hotel');
		$iIdRate  = (int) $this->_getParam('id_rate');
		if(!$iIdHotel || !$iIdRate) 
			$this->_forward('filter','rate','price');
			
		$this->_oSrvPrice->del($iIdRate);
		$this->addMessage(array(
			'message' => 'Сезон удалён', 
			'status'  => 'success'
		));
		$this->_redirect('/price/rate/filter/id_hotel/'.$iIdHotel);
	}
	
	/**
	 * Экспорт ценовых предложений в Excel
	 */
	public function exportAction(){
		$this->setLayout('admin/admin-tpl');
		
		$oForm = new App_Form_Price_Export();
		$aParams = $this->_getAllParams();
		$oForm->persistData($aParams);
		if($this->_request->isPost()){
			if($oForm->isValid($aParams)){
				$aParams = $oForm->getValues();
				$aExp = array('params' => $aParams)
						+ App_Service_Price::getInstance()
							->getExpRateFilter($aParams);
				$sLang = $aParams['lang'];
				$sTpl = APPLICATION_PATH . '/resource/data/price/templates/rate.xlsx';
				require_once 'App/Model/Billing/Rate/Export/Excel.php';
				$oExport = new App_Model_Billing_Rate_Export_Excel();
				$oExport->build($aExp, $sLang, $sTpl)->output('Price');
				die();
			}
		}
		
		$this->assign(array(
			'form' => $oForm,
		));
	}
	
	public function ajaxChCountryAction(){
		
    	if(!$this->_request->isXmlHttpRequest()) die();
    	
    	$oSrvRefGeo = App_Service_Ref_Hotel_Geo::getInstance();
    	$oSrvHotel  = App_Service_Hotel::getInstance();
    	
    	$idCountry  = $this->_getParam('id_ref_country', 0);
    	$aSearch['id_ref_country'] = $idCountry;
    	
    	$aCities 	= $oSrvRefGeo->getCitiesNames($idCountry, null, $this->_sCurrLang);
    	$idCityF  	= key($aCities);
    	$idCityS  	= $this->_getParam('id_ref_city', 0);
    	$aSearch['id_ref_city'] = 0;
    	
    	$aResult = array(
    		'id_ref_city' 		=> $aCities,
    		'id_ref_category'	=> $oSrvHotel->getSfCategoriesNames($aSearch, $this->_sCurrLang),
    		'id_hotel' 			=> $oSrvHotel->getSfHotelsNames($aSearch, $this->_sCurrLang),
    	);
    	die(Zend_Json::encode($aResult));
	}
	
	public function ajaxChCityAction(){
		
		if(!$this->_request->isXmlHttpRequest()) die();
    	
    	$oSrvRefCat = App_Service_Ref_Hotel_Category::getInstance();
    	$oSrvHotel  = App_Service_Hotel::getInstance();
    	
    	$aSearch = $this->_getExpFilterParams();
    	$aResult = array(
    		'id_ref_category'	=> $oSrvHotel->getSfCategoriesNames($aSearch, $this->_sCurrLang),
    		'id_hotel' 			=> $oSrvHotel->getSfHotelsNames($aSearch, $this->_sCurrLang),
    	);
		die(Zend_Json::encode($aResult));
	}
	
	public function ajaxChCategoryAction(){
		
        if(!$this->_request->isXmlHttpRequest()) die();
    	
    	$oSrvHotel  = App_Service_Hotel::getInstance();
    	
    	$aSearch = $this->_getExpFilterParams();
    	
        $aResult = array(
    		'id_hotel' 			=> $oSrvHotel->getSfHotelsNames($aSearch, $this->_sCurrLang),
    	);
    	die(Zend_Json::encode($aResult));	
	}
	
    private function _getExpFilterParams(){
    	$oForm = new App_Form_Price_Export();
    	$oForm->populate($_POST);
    	return $oForm->getValues();
    }
	
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
	
}