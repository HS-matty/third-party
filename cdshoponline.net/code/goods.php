<? //сохранение/изменение категорий

	include("functions.php");

	//соединиться с БД
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	//проверка на санкциaнированный доступ
	session_start();
	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //несанкционированный доступ! Alarm!
		exit;
	};

	if (!isset($ID)) $ID=0;
	if (!isset($cat)) $cat = 0;
	if (!isset($name)) $name = "";
	if (!isset($popularity)) $popularity = 0;
	if (!isset($price)) $price = 0;
	if (!isset($count)) $count = 0;
	if (!isset($picture)) $picture = "none";
	if (!isset($icon)) $icon = "none";
	if (!isset($description)) $description = "";

?>

<html>

<head>
<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Товары</title>
<script>
function confirmDelete($question, $where) {
	temp = window.confirm($question);
	if (temp) { //удалить
		window.location=$where;
	};
};
</script>
</head>

<body bgcolor=#FFFFE2>

<?	function showGoodsForm($cat, $name, $popularity, $price, $description, $picture, $count, $title, $ID, $icon) { //создает форму редактирования/создания товаров ?>

<center><b><font><?=$title; ?></font></b></center>

<form enctype="multipart/form-data" action="goods.php" method=post>

<table width=100% border=0>

<tr>
<td align=right>Категория:</td>
<td>
<select name="cid">
<option value="0">Корень</option>
<? fillTheCList(0,0,$cat); ?>
</select>
</td>
</tr>

<tr>
<td align=right>Название:</td>
<td><input type="text" name="name" value="<?=str_replace("\"","''",$name); ?>"></td>
</tr>

<?	if ($ID) { ?>
<tr>
<td align=right>Рэйтинг:</td>
<td><b><?=$popularity; ?></b></td>
</tr>
<? }; ?>

<tr>
<td align=right>Цена, $<br>(только число):</td>
<td><input type="text" name="price" value=<?=$price; ?>></td>
</tr>

<tr>
<td align=right>Наличие на складе, шт.:</td>
<td><input type="text" name="count" value="
<?
	if ($count<0) echo "0\"></td>\n";
	else echo $count."\"></td>\n";
?>
</tr>

<tr><td>&nbsp;</td></tr>

<tr>
<td align=right>Большая фотография товара:</td>
<td><input type="file" name="picture"></td>
<tr><td></td><td>
<?
	if ($picture && $picture != "none" && file_exists("goods_pictures/".$picture)) {
		echo "<font class=average>посмотреть:</font> <a class=small href=\"goods_pictures/".$picture."\">$picture</a>\n";
		echo "<br><a href=\"javascript:confirmDelete('Удалить фотографию товара?','goods.php?ID=$ID&picture_remove=yes');\">удалить</a>\n";
	}
	else echo "<br><font class=average color=brown>(фотография не закачана)</font><br><br>";
?>
</td>
</tr>

<tr>
<td align=right>Маленькая фотография товара (иконка):</td>
<td><input type="file" name="icon"></td>
<tr><td></td><td>
<?
	if ($icon && $icon != "none" && file_exists("goods_pictures/".$icon)) {
		echo "<font class=average>посмотреть:</font> <a class=small href=\"goods_pictures/".$icon."\">$icon</a>\n";
		echo "<br><a href=\"javascript:confirmDelete('Удалить фотографию-иконку товара?','goods.php?ID=$ID&icon_remove=yes');\">удалить</a>\n";
	}
	else echo "<br><font class=average color=brown>(фотография не закачана)</font>";
?>
</td>
</tr>


<tr><td>&nbsp;</td></tr>

<tr>
<td align=right>Описание<br>(HTML-код):</td>
<td><textarea name="description" rows=10 cols=25><?=$description; ?></textarea></td>
</tr>

</table>
<p><center>
<input type="submit" value="Сохранить" width=5>
<input type="hidden" name="save" value=<?=$ID; ?>>
<input type="button" value="Отмена" onClick="window.close();">
<?	if ($ID) echo "<input type=button value=\"Удалить\" onClick=\"confirmDelete('Удалить товар?','goods.php?ID=".$ID."&del=1');\">"; ?>
</center></p>
</form>

<?	};

	function fillTheCList($parent,$level,$c) {
				//возвращается массив "родителей" категорий в том порядке, в котором они идут в списке
				//это необходимо для записи новой категории в базу данных (чтобы вычислить CID и Parent новой записи)

		$q = mysql_query("SELECT * FROM Categories WHERE Parent='".$parent."' ORDER BY Name;") or die (mysql_error());

		$a = array(); //массив "родителей"
		while ($row = mysql_fetch_row($q)) {
			//написать имя категории в списке
			echo "<option value=\"".$row[0]."\"";
			if ($c==$row[0]) echo " selected>";
			else echo ">";
			for ($j=0; $j<$level; $j++) echo "&nbsp;&nbsp;";
			echo $row[1]."</option>\n";
			//записать
			$a[count($a)] = $row;
			//обработать все подкатегории данной
			$b = fillTheCList($row[0],$level+1,$c);
			//добавить $b[] в конец $a[]
			for ($j=0; $j<count($b); $j++) {
				$a[count($a)] = $b[$j];
			};
		};
		return $a;
	};


	if (isset($save)) { //сохранить товар в базу данных
		//сначала проверить правильность ввода данных
		$row = array();
		if (!$name) {
			showGoodsForm($cat, $name, $popularity, $price, $description, $picture, $count, "<font color=red>Не введено <u>название</u> товара</font>",$ID, $icon);
			exit;
		};

		if (!$price || $price < 0) $price = 0; //цена и остаток товара на складе не могут быть отрицательными
		if (!$count || $count < 0) $count = 0; 

		if ($picture && $picture != "none") { //upload'ить картинку товара, перед этим поменяв ее имя с $picture_name на новое
					//для избежания случая, когда несколько товаров используют одну и ту же картинку
			$rr = rand() % 1000;
			$picture_name = $rr."_".$picture_name;
			$r = copy(trim($picture), "goods_pictures/".str_replace(" ","_",$picture_name));
			$picture_name = str_replace(" ","_",$picture_name);
			if (!$r) { //неудача...
				echo "<center><font color=red>Товар сохранен в базу данных!";
				echo "<br>Но не удалось закачать фотографию товара на сервер. Возможные причины: нет свободного места на сервере либо на нем не существует директории 'goods_pictures'.</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">Закрыть окно</a></center></body>\n</html>";
				exit;
			};
		};

		//аналогично с иконкой
		if ($icon && $icon != "none") {

			$rr = rand() % 1000;
			$icon_name = $rr."_".$icon_name;
			$r = copy(trim($icon), "goods_pictures/".str_replace(" ","_",$icon_name));
			$icon_name = str_replace(" ","_",$icon_name);
			if (!$r) { //неудача...
				echo "<center><font color=red>Товар сохранен в базу данных!";
				echo "<br>Но не удалось закачать фотографию-иконку товара на сервер. Возможные причины: нет свободного места на сервере либо на нем не существует директории 'goods_pictures'.</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">Закрыть окно</a></center></body>\n</html>";
				exit;
			};
		};



		//сохранить
		if ($save) { //если $save != 0, то обновить характеристики товара

			$q = mysql_query("SELECT * FROM GoodsList WHERE ID=".$save) or die (mysql_error());
			$row = mysql_fetch_row($q);

			//если введено расположение фотографии/иконки в графе "фотография", то изменbть этот параметр у товара в базе данных
			if ($picture && $picture != "none") {
				//удалить старую фотографию
				if ($row[6] != "none" && file_exists("goods_pictures/".$row[6]))
					unlink("goods_pictures/".$row[6]);

				if ($icon && $icon != "none") { //было ли введено имя иконки?
					//удалить старую иконку
					if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
						unlink("goods_pictures/".$row[8]);
					//обновить информацию о товаре в БД
					$q = mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Picture='$picture_name', Description='$description', LeftInWarehouse=$count, SmallPic='$icon_name' WHERE ID=$save") or die (mysql_error());
				}
				else mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Picture='$picture_name', Description='$description', LeftInWarehouse=$count WHERE ID=$save") or die (mysql_error());

			}
			else { //имя новой картинки не введено
				if ($icon && $icon != "none") {
					//удалить старую иконку
					if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
						unlink("goods_pictures/".$row[8]);
					//обновить информацию о товаре в БД
					$q = mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Description='$description', LeftInWarehouse=$count, SmallPic='$icon_name' WHERE ID=$save") or die (mysql_error());
				}
				else mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Description='$description', LeftInWarehouse=$count WHERE ID=$save") or die (mysql_error());

			};

		}
		else { //добавить новый товар в базу данных

			$q = mysql_query("INSERT INTO GoodsList VALUES ($cid, 0,'".str_replace("<","&lt;",$name)."','$description', 0, $price,'$picture_name', $count, '$icon_name', 0, 0);") or die (mysql_error());

		};

		update_Goods_Count_Value_For_Categories(0); //обновить значения GoodsCount для категорий

		//закрыть окно
		echo "<script>\n";
		echo "window.opener.location.reload();\n";
		echo "window.close();\n";
		echo "</script>\n</body>\n</html>";
		exit;
	}
	else {
		$row = array();
		if ($ID) { //взять товар из базы данных

			//проверить, существует ли такой товар
			$q = mysql_query("SELECT * FROM GoodsList WHERE ID=".$ID) or die (mysql_error());
			$row = mysql_fetch_row($q);
			if (!$row) { //товара не существует
				echo "<center><font color=red>Товар не найден в базе данных!";
				echo "<br>Нажмите кнопку \"Обновить\" в броузере, который используется для режима \"Администратор\"</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">Закрыть окно</a></center></body>\n</html>";
				exit;
			};

			if (isset($picture_remove)) { //удалить фотографию товара
				if ($row[6] != "none" && file_exists("goods_pictures/".$row[6]))
					unlink("goods_pictures/".$row[6]);
				$picture = "none";
			};

			if (isset($icon_remove)) { //удалить фотографию товара
				if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
					unlink("goods_pictures/".$row[8]);
				$icon = "none";
			};

			if (isset($del)) { //удалить товар
				//сначала -- его фотографию
				if ($row[6] != "none" && file_exists("goods_pictures/".$row[6]))
					unlink("goods_pictures/".$row[6]);

				//теперь иконку
				if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
					unlink("goods_pictures/".$row[8]);

				//теперь сам товар
				$q = mysql_query("DELETE FROM GoodsList WHERE ID=".$ID) or die (mysql_error());

				update_Goods_Count_Value_For_Categories(0); //обновить категории

				//закрыть окно
				echo "<script>\n";
				echo "window.opener.location.reload();\n";
				echo "window.close();\n";
				echo "</script>\n</body>\n</html>";
				exit;
			};

			$cat = $row[0];
			$name = $row[2];
			$popularity = $row[4];
			$price = $row[5];
			$picture = $row[6];
			$icon = $row[8];
			$count = $row[7];
			$description = $row[3];
			//если дошли до сюда, то товар существует
			$title = $row[2];
		}
		else { //создание нового товара
			$title = "Новый товар";
		};
	};
	showGoodsForm($cat, $name, $popularity, $price, $description, $picture, $count, $title,$ID, $icon);

?>

</body>

</html>