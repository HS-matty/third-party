<?php

/**
	 * Поиск предложений отеля в разрезе отелей (update by matty)
	 */
	public function search_hotels($aData, $iPage = 1, $iLimit = 15, $aSort = array())
	{
		$aWhere = $aParams = $aOrderBy = array();
		
		# Сортировки (new search changes by matty)
		
		if(isset($aSort['price'])){
			$aOrderBy[] = 'order_price_min '.($aSort['price']?'ASC':'DESC');
		}elseif(isset($aSort['hotel'])){
			$aOrderBy[] = 'rate.id_hotel '.($aSort['hotel']?'ASC':'DESC');
		}elseif(isset($aSort['room'])){
			$aOrderBy[] = 'hr.id_ref_room '.($aSort['room']?'ASC':'DESC');
		}elseif(isset($aSort['place'])){
			$aOrderBy[] = 'type_place '.($aSort['place']?'ASC':'DESC');
		}else{
			$aOrderBy[] = 'order_price_min, is_recomended ASC';
		}
		$sOrderBy = implode(',', $aOrderBy);
		
		
		# Страна
		if(!empty($aData['id_ref_country'])){
			$aWhere[]  = 'hotel.id_ref_country = ?';
			$aParams[] = (int)$aData['id_ref_country'];
		}
		
		# Город
		if(!empty($aData['id_ref_city'])){
			$aWhere[]  = 'hotel.id_ref_city = ?';
			$aParams[] = (int)$aData['id_ref_city'];
		}
		
		# Категория
		if(!empty($aData['id_ref_category']) 
				&& $aData['id_ref_category'] != -1)
		{
			#Zend_Debug::dump($aData['id_ref_category']);
			# и выше 
			if(!empty($aData['cat_up'])){
				$aCat = App_Service_Ref_Hotel_Category::getInstance()
							->get($aData['id_ref_category'])->toArray();
				$aWhere[]  = 'ref_category.ord <= ?';
				$aParams[] = (int)$aCat['ord'];
			}else{
				$aWhere[]  = 'hotel.id_ref_category = ?';
				$aParams[] = (int)$aData['id_ref_category'];
			}
		}
		
		# Отель
		if(!empty($aData['id_hotel'])){
			$aWhere[]  = 'rate.id_hotel = ?';
			$aParams[] = (int)$aData['id_hotel'];
		}
		
		# Тип номера (глобальный справочник)
		if(!empty($aData['id_ref_room'])){
			$aWhere[]  = 'ref_hr.id_ref_room = ?';
			$aParams[] = (int)$aData['id_ref_room'];
		}
		
		# Id номера (Редактирование заказа)
		if(!empty($aData['id_room'])){
			$aWhere[]  = 'rate.id_room = ?';
			$aParams[] = (int)$aData['id_room'];
		}
		
		# Id Завтрак (Редактирование заказа)
		if(!empty($aData['id_breakfast'])){
			$aWhere[]  = 'rate.id_breakfast = ?';
			$aParams[] = (int)$aData['id_breakfast'];
		}
		
		# Группа пользователя
		$aWhere[]  = 'rate.id_group = ?';
		$aParams[] = $aData['id_group'] ? (int) $aData['id_group'] : 1;
		
		# Диапазон временного интервала для поиска
		$aWhere[] = '(rate.date >= DATE(?) AND rate.date < DATE(?))';
		$aParams[] = $aData['arrival_date'];
		$aParams[] = $aData['departure_date'];
		
		# Условие непрерывности временного интервала по ценам
		$sHaving = ' _cnt_price_ = DATEDIFF(?, ?) ';
		$aHavingParams = array();
		$aHavingParams[] = $aData['departure_date'];
		$aHavingParams[] = $aData['arrival_date'];
		
		# Максимальная цена за ночь
		if(!empty($aData['max_price']) && (int)$aData['max_price']){
			$sHaving .= ' AND order_price_normalize < ? ';
			$aHavingParams[] = (int)$aData['max_price'] + 1;
		}
		
		# Места в наличии и количество номеров
		if(!empty($aData['places'])){
			$sCondIsPlaces  = '( _cnt_stopsell_ = 0 '
				.' AND (is_quota >= ? OR is_freesell >= ?))';
			$aHavingParams[] = (int)$aData['cnt_room'];
			$aHavingParams[] = (int)$aData['cnt_room'];
			$sHaving .= ' AND ' . $sCondIsPlaces; 
		}
		
		#
		$_sSqlDateDiffBooking = 'DATEDIFF("'
			.$aData['arrival_date'].'","'.date('Y-m-d').'")*24';
		$_sSqlDateDiffOrder = 'DATEDIFF("'
			.$aData['departure_date'].'","'.$aData['arrival_date'].'")';
		
		$sIsQuota = 'IF(params.quota_period <= '.$_sSqlDateDiffBooking.'
			&& Count(quota.date) = '.$_sSqlDateDiffOrder.', '
		. 'Min(quota.value), 0)';
		$sIsFreesell = 'IF(params.quota_period <= '.$_sSqlDateDiffBooking.'
			&& Count(freesell.date) = '.$_sSqlDateDiffOrder.', '
		. 'Min(freesell.value), 0)';
		$sIsStopsell = 'IF(Count(stopsell.date), Max(stopsell.value), 0)';
		
		$iLimit = (int) !empty($iLimit) ? max(1, $iLimit) : 15;
		$iPage 	= (int) !empty($iPage)  ? max(1, $iPage)  : 1;
		
		$oAdapter = $this->getAdapter();
		$oSelect  = $oAdapter
			->select()
			/* Прайсы */
			->from(array('rate' => $this->_name), array(
				'id_hotel', 'id_room', 'id_breakfast', 'partial',
				'_cnt_price_' 	=> 'Count(rate.date)',
				'cnt_ext_a' 	=> new Zend_Db_Expr('IF('.$aData['cnt_adult'].' > `partial`, '.$aData['cnt_adult'].' - `partial`, 0)'),
				# Дети к3 на доп местах
				'cnt_ext_c3' 	=>
					new Zend_Db_Expr('
					if(!'.$aData['cnt_child3'].' || `partial` - '.$aData['cnt_adult'].' >= '.$aData['cnt_child3'].',
						0,
						if(`partial` > '.$aData['cnt_adult'].' && '.$aData['cnt_child3'].' + '.$aData['cnt_adult'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_child3'].' + '.$aData['cnt_adult'].' - `partial`
							, '.$aData['cnt_child3'].'
						) 
					 )'),
				# Дети к2 на доп местах
    			'cnt_ext_c2' 	=>
    				new Zend_Db_Expr('
					if(!'.$aData['cnt_child2'].' || `partial` - '.$aData['cnt_adult'].' - '.$aData['cnt_child3'].' >= '.$aData['cnt_child2'].',
						0,
						if(`partial` > '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' && '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' - `partial`
							, '.$aData['cnt_child2'].'
						) 
					  )'),
				# Дети к1 на доп местах
				'cnt_ext_c1'	=>
					new Zend_Db_Expr('
					if(!'.$aData['cnt_child1'].' || `partial` - '.$aData['cnt_adult'].' - '.$aData['cnt_child3'].' - '.$aData['cnt_child2'].' >= '.$aData['cnt_child1'].',
						0,
						if(`partial` > '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' && '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' + '.$aData['cnt_child1'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' + '.$aData['cnt_child1'].' - `partial`
							, '.$aData['cnt_child1'].'
						) 
					  )'),
				/* поле сортировки нормализованная стоимость */
				'order_price_normalize' => new Zend_Db_Expr('
					AVG(rate.price_normalize)
					-- Взрослые на доп местах
					+ if('.$aData['cnt_adult'].' > `partial`, '.$aData['cnt_adult'].' - `partial`, 0) 
						 * if(`ep`.`price_normalize_adult` IS NOT NULL,`ep`.`price_normalize_adult`,0)
					-- Дети k3 на доп местах
					+ if(!'.$aData['cnt_child3'].' || `partial` - '.$aData['cnt_adult'].' >= '.$aData['cnt_child3'].',
						0, 
						if(`partial` > '.$aData['cnt_adult'].' && '.$aData['cnt_child3'].' + '.$aData['cnt_adult'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_child3'].' + '.$aData['cnt_adult'].' - `partial`
							, '.$aData['cnt_child3'].'
						) 
					  ) * if(`ep`.`price_normalize_child3` IS NOT NULL,`ep`.`price_normalize_child3`,0)
					-- Дети k2 на доп местах
					+ if(!'.$aData['cnt_child2'].' || `partial` - '.$aData['cnt_adult'].' - '.$aData['cnt_child3'].' >= '.$aData['cnt_child2'].',
						0,
						if(`partial` > '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' && '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' - `partial`
							, '.$aData['cnt_child2'].'
						) 
					  ) * if(`ep`.`price_normalize_child2` IS NOT NULL,`ep`.`price_normalize_child2`,0)
					-- Дети k1 на доп местах
					+ if(!'.$aData['cnt_child1'].' || `partial` - '.$aData['cnt_adult'].' - '.$aData['cnt_child3'].' - '.$aData['cnt_child2'].' >= '.$aData['cnt_child1'].',
						0,
						if(`partial` > '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' && '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' + '.$aData['cnt_child1'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' + '.$aData['cnt_child1'].' - `partial`
							, '.$aData['cnt_child1'].'
						) 
					  ) * if(`ep`.`price_normalize_child1` IS NOT NULL,`ep`.`price_normalize_child1`,0)
				'),
				/* end поле сортировки нормализованная стоимость */
				'order_price' 	=> 
					new Zend_Db_Expr('
					AVG(rate.price)
					-- Взрослые на доп местах
					+ if('.$aData['cnt_adult'].' > `partial`, '.$aData['cnt_adult'].' - `partial`, 0) * if(`ep`.`price_adult` IS NOT NULL,`ep`.`price_adult`,0)
					-- Дети k3 на доп местах
					+ if(!'.$aData['cnt_child3'].' || `partial` - '.$aData['cnt_adult'].' >= '.$aData['cnt_child3'].',
						0, 
						if(`partial` > '.$aData['cnt_adult'].' && '.$aData['cnt_child3'].' + '.$aData['cnt_adult'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_child3'].' + '.$aData['cnt_adult'].' - `partial`
							, '.$aData['cnt_child3'].'
						) 
					  ) * if(`ep`.`price_child3` IS NOT NULL,`ep`.`price_child3`,0)
					-- Дети k2 на доп местах
					+ if(!'.$aData['cnt_child2'].' || `partial` - '.$aData['cnt_adult'].' - '.$aData['cnt_child3'].' >= '.$aData['cnt_child2'].',
						0,
						if(`partial` > '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' && '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' - `partial`
							, '.$aData['cnt_child2'].'
						) 
					  ) * if(`ep`.`price_child2` IS NOT NULL,`ep`.`price_child2`,0)
					-- Дети k1 на доп местах
					+ if(!'.$aData['cnt_child1'].' || `partial` - '.$aData['cnt_adult'].' - '.$aData['cnt_child3'].' - '.$aData['cnt_child2'].' >= '.$aData['cnt_child1'].',
						0,
						if(`partial` > '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' && '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' + '.$aData['cnt_child1'].' - `partial`
							/* Частичное поподание на основыне места*/
							, '.$aData['cnt_adult'].' + '.$aData['cnt_child3'].' + '.$aData['cnt_child2'].' + '.$aData['cnt_child1'].' - `partial`
							, '.$aData['cnt_child1'].'
						) 
					  ) * if(`ep`.`price_child1` IS NOT NULL,`ep`.`price_child1`,0)
					 '
					),
				))
			/* Квоты */
			->joinLeft(
				array('quota' => $this->_nameQuota),
				'rate.id_hotel = quota.id_hotel'
				.' AND rate.id_room = quota.id_room'
				.' AND rate.`date` = quota.date'
				, array(
				'_cnt_quota_' => 'Count(quota.date)',
				'is_quota'	  => $sIsQuota,
				))
			/* Свободные продажи */
			->joinLeft(
				array('freesell' => $this->_nameFreeSell),
				'rate.id_hotel = freesell.id_hotel'
				.' AND rate.id_room = freesell.id_room'
				.' AND rate.`date` = freesell.`date`'
				, array(
				'_cnt_freesell_' => 'Count(freesell.date)',
				'is_freesell'	 => $sIsFreesell,
				))
			/* Остановка продаж */
			->joinLeft(
				array('stopsell' => $this->_nameStopSell),
				'rate.id_hotel = stopsell.id_hotel'
				.' AND rate.id_room = stopsell.id_room'
				.' AND rate.`date` = stopsell.`date`'
				, array(
				'_cnt_stopsell_' => 'Count(stopsell.date)',
				'is_stopsell'	 => $sIsStopsell,
				'type_place'	 => 'if('.$sIsStopsell.', 4, if('.$sIsQuota.', 1, if('.$sIsFreesell.', 2, 3)))' 
				))
			/* Дополнительные места */
			->joinLeft(
				array('ep' => $this->_nameExtraBed),
				'`rate`.`id_hotel`=`ep`.`id_hotel`'
				.' AND `rate`.`id_room`=`ep`.`id_room`'
				, array(
				 	'price_ext_a'  => 'price_adult',
 					'price_ext_c1' => 'price_child1',
 					'price_ext_c2' => 'price_child2',
 					'price_ext_c3' => 'price_child3',
				))
			/* Отели */
			->joinInner(array('hotel' => 'catalog_hotel'), 
				'rate.id_hotel=hotel.id_hotel',
				array(
				'id_country' 	=> 'id_ref_country',
				'id_city' 		=> 'id_ref_city',
				'id_category' 	=> 'id_ref_category',
				'hotel_ru' 		=> 'title_ru',
				'hotel_en' 		=> 'title_en',
				'hotel_lt' 		=> 'title_lt',
				'description_ru' => 'description_ru',
				'description_en' => 'description_en',
				'description_lt' => 'description_lt',
				'address_ru' => 'address_ru',
				'address_en' => 'address_en',
				'address_lt' => 'address_lt',
				'gps_longitude' =>'gps_longitude',
				'gps_latitude' => 'gps_latitude',
				'is_recomended' => 'is_recomended'
				
				
				))
			/* Типы номеров отеля */
			->joinInner(array('hr' => 'catalog_hotel_room'),
				'rate.id_hotel=hr.id_hotel AND rate.id_room=hr.id_room',
				array(
			    'max_p'	=> 'IF(hr.seats=partial, partial + hr.additional_bed, partial)',
			    'max_e' => 'additional_bed',
				'room_title_ru' => 'hr.title_ru',
				'room_title_en' => 'hr.title_en',
				'room_title_lt' => 'hr.title_lt',
				))
			/* Типы номеров (глобальный справочник) */
			->joinInner(array('ref_hr' => 'ref_hotel_room'), 
				'hr.id_ref_room=ref_hr.id_ref_room',
				array(
				'room_type_title' 	=> 'title',
				'room_seats' 		=> 'seats',
				))
			/* Категории номеров (глобальный справочник) */
			->joinInner(array('ref_category' => 'ref_hotel_category'),
				'hotel.id_ref_category=ref_category.id_ref_category',
				array(
				'category_title' => 'title_ru',
				'category_title_ru' => 'title_ru',
				'category_title_en' => 'title_en',
				'category_title_lt' => 'title_lt',
				))
			/* Типы завтроков (глобальный справочник) */
			->joinInner(array('breakfast' => 'ref_hotel_breakfast'),
				'rate.id_breakfast=breakfast.id_ref_breakfast',
				array(
				'breakfast_ru' => 'title_ru',
				'breakfast_en' => 'title_en',
				'breakfast_lt' => 'title_lt',
				))
			/* Параметры отелей */
			->joinLeft(array('params' => 'catalog_hotel_param'),
				'rate.id_hotel=params.id_hotel',
				array(
				'currency'
				))
			/* Главное фото отеля */
			->joinLeft(array('hphoto' => 'catalog_hotel_gallery'),
				'(rate.id_hotel=hphoto.id_hotel) AND (hphoto.id_room = 0) AND (hphoto.main = 1) AND (hphoto.active = 1)',
				array(
				'hotel_photo' => 'path'
				))
			/* Главное фото номера */
			->joinLeft(array('rphoto' => 'catalog_hotel_gallery'),
				'(rate.id_hotel=rphoto.id_hotel) AND (rphoto.id_room = rate.id_room) AND (rphoto.main = 1) AND (rphoto.active = 1)',
				array(
				'room_photo' => 'path'
				))
			->where(implode(' AND ', $aWhere))
		//	->order($sOrderBy)
			->group(array(
				'rate.id_hotel', 
				'rate.id_room',
				'rate.id_breakfast', 
				'rate.partial'
			))
			->having($sHaving)
	//		->limit($iLimit, ($iPage-1) * $iLimit)
			
			->where('
			(
			-- по общему количеству мест
			 IF(`rate`.`partial` = `hr`.`seats`, 
			 		('.$aData['cnt_p'].' = `rate`.`partial` + `hr`.`additional_bed`
			 		or 
			 		'.$aData['cnt_p'].' = `rate`.`partial`
			 		), 
			 		'.$aData['cnt_p'].' = `rate`.`partial`) 
			 	
				AND
			-- по количеству для взрослых
			`rate`.`partial` + if(`hr`.`additional_bed`,1,0) >= '.$aData['cnt_adult'].'
			)'/*
			 OR (
			-- без частичного заселения
			!`hr`.`partial_settlement` 
				AND  
			-- по общему количесву мест 
			`hr`.`seats` + if(`hr`.`additional_bed`,  `hr`.`additional_bed`, 0) >= '.$aData['cnt_p'].'
			)
			'*/
			)
			// Дополнительная проверка установки цен на дополнительные мест
			// При возможном подселении на доп места  
			->having('
				if(cnt_ext_c1 || cnt_ext_c2 || cnt_ext_c3 || cnt_ext_a 
  					, (		if(cnt_ext_c1, `ep`.`price_child1` > 0, 1)
						AND if(cnt_ext_c2, `ep`.`price_child2` > 0, 1)
						AND if(cnt_ext_c3, `ep`.`price_child3` > 0, 1)
						AND if(cnt_ext_a, `ep`.`price_adult` > 0, 1)
					)
					, 1
				) 
			')
			;
		
		$sSelect = str_replace(
			array('SELECT ', ' AS `rate`'),
		//	array('SELECT SQL_CALC_FOUND_ROWS ', ' AS `rate` USE KEY(PRIMARY)'),
			array('SELECT ', ' AS `rate` USE KEY(PRIMARY)'),
			$oSelect->assemble()
		);
		
		$global_select = "SELECT SQL_CALC_FOUND_ROWS  id_hotel,hotel_en,gps_longitude,gps_latitude,hotel_ru,hotel_lt,description_ru,description_en, MIN(order_price) as order_price_min,description_lt,address_ru,address_en,address_lt,category_title_ru,category_title_en,category_title_lt,hotel_photo,currency, id_room, id_breakfast,partial,is_recomended from (".$sSelect.") as tt GROUP BY id_hotel ORDER BY {$sOrderBy} LIMIT ". ($iPage-1) * $iLimit .", ".$iLimit;
		
		#Zend_Debug::dump($sSelect, '$sSelect');
		#die();
		return array(
			'rows' => $oAdapter->fetchAll($global_select, array_merge($aParams, $aHavingParams)),
			'cnt'  => $oAdapter->fetchOne('SELECT FOUND_ROWS()')
		);
	}
?>
