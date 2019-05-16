<? //сохранение/изменение категорий

	include("functions.php");

	//соединиться с БД
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	//проверка на санкцианированный доступ
	session_start();
	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //несанкционированный доступ! Alarm!
		exit;
	};

?>

<html>

<head>
<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Категории</title>
<script>
function confirmDelete() {
	temp = window.confirm('Удалить категорию и все ее подкатегории\n(все товары будут перенесены в корень)?');
	if (temp) { //удалить
		window.location='category.php?c_id=<?=$c_id;?>&del=1';
	};
};
</script>
</head>

<body bgcolor=#D2D2FF>

<?
	function deleteSubCategories($parent) { //удаляет все категории с передаваемым $parent'ом
		//теперь все ее подкатегории
		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$parent.";") or die (mysql_error());
		while ($row = mysql_fetch_row($q)) {
			deleteSubCategories($row[0]);
		};
		$q = mysql_query("DELETE FROM Categories WHERE Parent=".$parent.";") or die (mysql_error());

		//все товары этой категории переместить в корень (корень здесь что-то вроде temporary folder)
		$q = mysql_query("UPDATE GoodsList SET CID=0 WHERE CID=".$parent) or die (mysql_error());
	};

	function category_Moves_To_Its_SubDirectories($cid, $new_parent) {
		//функция возвращает true, если категрию передвигают в какую-то из ее подкатегорий

		$a = false;
		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$cid." ORDER BY Name;") or die (mysql_error());
		while ($row = mysql_fetch_row($q)) {
			if ($row[0]==$new_parent) $a = true;
			else $a = category_Moves_To_Its_SubDirectories($row[0],$new_parent);
		};
		return $a;
	};

	function fillTheList($parent,$level,$add2list,$c) {
				//возвращается массив "родителей" категорий в том порядке, в котором они идут в списке
				//это необходимо для записи новой категории в базу данных (чтобы вычислить CID и Parent новой записи)
				//если $add2list!=0 то также заполняет список категориями
				//функция аналогична processCategories() в admin.php

		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$parent." ORDER BY Name;") or die (mysql_error());

		$a = array(); //массив "родителей"
		while ($row = mysql_fetch_row($q)) {
			//написать имя категории в таблице
			if ($add2list) {
				echo "<option value=\"".$row[0]."\"";
				if ($c==$row[0]) echo " selected>";
				else echo ">";
				for ($j=0; $j<$level; $j++) echo "&nbsp;&nbsp;";
				echo $row[1]."</option>\n";
			};
			//записать
			$a[count($a)] = $row;
			//обработать все подкатегории данной
			$b = fillTheList($row[0],$level+1,$add2list,$c);
			//добавить $b[] в конец $a[]
			for ($j=0; $j<count($b); $j++) {
				$a[count($a)] = $b[$j];
			};
		};
		return $a;
	};

	if (!isset($w)) $w=-1;

	if (isset($save) && $name) { //сохранить запись в базу данных и закрыть окно

		if (!isset($must_delete)) { //добавить новую запись
			$q = mysql_query("INSERT INTO Categories VALUES (0,'".str_replace("<","&lt;",$name)."',".$parent.",0)") or die (mysql_error());
		}
		else { //обновить существующую -- т.е. поменять имя и/или перенести в другую категорию, имя которой указано в option'ах

			if ($must_delete != $parent) { //если категорию не переносят "саму в себя"

				//здесь возможны 2 варианта: либо категорию переносят в какую-то из ее подкатегорий, либо нет
				//в первом случае мы должны передвинуть подкатегории данной категории на уровень вверх
				
				if (category_Moves_To_Its_SubDirectories($must_delete, $parent)) { //1ый случай

					//определим все подкатегории 1ого уровня редактируемой категории

					//для этого сначала сохраним старого родителя данной категории в $r[2]
					$q = mysql_query("SELECT * FROM Categories WHERE CID=$must_delete") or die (mysql_error());
					$r = mysql_fetch_row($q);

					//передвинуть все подкатегории 1ого уровня данной категории на уровень выше
					$q = mysql_query("UPDATE Categories SET Parent=".$r[2]." WHERE Parent=".$must_delete) or die (mysql_error());

					//передвинуть редактируемую категорию
					$q = mysql_query("UPDATE Categories SET Name='".str_replace("<","&lt;",$name)."', Parent=".$parent." WHERE CID=".$must_delete) or die (mysql_error());

				}
				else //передвинуть подкатегории без изменения ее подкатегорий
					$q = mysql_query("UPDATE Categories SET Name='".str_replace("<","&lt;",$name)."', Parent=".$parent." WHERE CID=".$must_delete) or die (mysql_error());

			};
		};

		//далее необходимо обновить кол-во товаров для каждой категории
		update_Goods_Count_Value_For_Categories(0);

		//теперь закрыть окно
		echo "<script>\n";
		echo "window.opener.location.reload();\n";
		echo "window.close();\n";
		echo "</script>\n</body>\n</html>";
	}
	else { //показать форму редактирования категории

		if (isset($c_id)) { //редактирование...
			$q = mysql_query("SELECT * FROM Categories WHERE CID=".$c_id) or die (mysql_error());
			$row = mysql_fetch_row($q);
			if (!$row) { //ошибка! категории не существует!
				echo "<center><font color=red>Категория не найдена в базе данных!";
				echo "<br>Нажмите кнопку \"Обновить\" в броузере, который используется для режима \"Администратор\"</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">Закрыть окно</a></center></body>\n</html>";
				exit;
			};
			$title = "Категория <b>".$row[1]."</b>";
			$n = $row[1];

			if (isset($del)) { //удалить запись...
				//сначала саму запись
				$q = mysql_query("DELETE FROM Categories WHERE CID=".$c_id) or die (mysql_error());
				//теперь все ее подкатегории
				deleteSubCategories($c_id);
				//закрыть окно
				echo "<script>\n";
				echo "window.opener.location.reload();\n";
				echo "window.close();";
				echo "</script>\n</body>\n</html>";
			};
		}
		else { //создание новой категории
			$title = "Создать новую категорию";
			$n = "";
		};

?>

<center><font color=purple><?=$title; ?></font></center>
<form action="category.php" method=post>
<table width=100% border=0>

<tr>
<td align=right>
<?
	if (!isset($c_id)) echo "Родитель:";
	else echo "Переместить в:";
?>
</td>
<td width=5%></td>
<td>
<select name="parent"> <!-- значение элемента списка -- CID данной категории -->
<option value="0">Корень</option>
<? //загрузить список всех категорий для отображения в списке
	fillTheList(0,0,1,$w);
?>
</select>
</td>
</tr>

<tr>
<td align=right>Название категории:</td>
<td></td>
<td><input type="text" name="name" value="<?=str_replace("\"","''",$n); ?>" size=13></td>
</tr>

</table>
<p><center>
<input type="submit" value="Сохранить" width=5>
<input type="hidden" name="save" value="1">
<input type="button" value="Отмена" onClick="window.close();">
<?	//если редактируем запись, то запрос должен быть UPDATE вместо INSERT
	if (isset($c_id)) {
		echo "<input type=\"hidden\" name=\"must_delete\" value=\"".$c_id."\">\n";
		echo "<input type=\"button\" value=\"Удалить\" onClick=\"confirmDelete();\"";
	};
?>
</center></p>
</form>

</body>

</html>
<? }; ?>