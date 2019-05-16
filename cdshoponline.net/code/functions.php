<? //библиотека функций

	function update_Goods_Count_Value_For_Categories($parent) { //проходит по всем категориям и обновляет значение GoodsCount для каждой категории.
											//Изменения сохраняются в базу данных

		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$parent." ORDER BY Name;") or die (mysql_error());
		$goods_count = 0;

		while ($row = mysql_fetch_row($q)) {

			//обработать все подкатегории данной

			//кол-во товаров в данной катогрии ($goods_count) будет складываться из кол-ва товаров в ее подкатегориях: ...
			$goods_count += update_Goods_Count_Value_For_Categories($row[0]);

		};

		//...и из кол-ва товаров в самой категории:
		$p = mysql_query("SELECT * FROM GoodsList WHERE CID=".$parent) or die (mysql_error());
		while (mysql_fetch_row($p)) $goods_count++;

		//сохранить посчитанное в БД
		if ($parent)
			mysql_query("UPDATE Categories SET GoodsCount=".$goods_count." WHERE CID=".$parent) or die (mysql_error());

		return $goods_count;

	};


?>