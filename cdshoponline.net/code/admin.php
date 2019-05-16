<? //администрирование базы данных: добавление/редактирование товаров, категорий, пользоавтелей
	session_start();

	//соединиться с БД
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //несанкционированный доступ! Alarm! перейти на index.php
		exit;
	};

function processCategories($list, $parent,$level) { //рисует таблицу с категориями

	for ($i=0; $i<count($list); $i++)
	 if ($list[$i][2] == $parent) {

		//написать имя категории в таблице
		echo "<tr><td>";
		for ($j=0; $j<$level; $j++) echo "&nbsp;&nbsp;";
		echo "&nbsp;<a";
		if ($level) echo " class=\"standard\"";
		echo " href=\"javascript:open_window('category.php?c_id=".$list[$i][0]."&w=".$list[$i][2]."',350,180);\">".str_replace("<","&lt;",$list[$i][1])."</a> (".$list[$i][3].")</td>\n"; //w -- CID родителя редактируемой категории
		echo "<td align=right><font color=red>[</font><a class=small href=\"admin.php?CID=".$list[$i][0]."&path=1\">=></a><font color=red>]</font></td></tr>\n";
		//обработать все подкатегории данной
		processCategories($list, $list[$i][0],$level+1);
	 };

};

?>
<html>

<head>

<script> //java-скрипт, открывающий новое окно для редактированием категорий, товаров, и т.п.
	function confirmDelete(oid) {
		temp = window.confirm('Удалить заказ?');
		if (temp) { //удалить
			window.location='admin.php?delete='+oid;
		};
	};
	function open_window(link,w,h) {
		var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
		newWin = window.open(link,'newWin',win);
	};
</script>

<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>АДМИНИСТРАТОР</title>
</head>

<body><center>
<h1>АДМИНИСТРАТОР</h1>

<?	//взять из БД весь список категорий
	$q = mysql_query("SELECT * FROM Categories ORDER BY Name;") or die (mysql_error());
	$cats = array(); $i=0;
	while ($row = mysql_fetch_row($q)) $cats[$i++] = $row;

	if (!isset($path) || $path<0 || $path>3) $path=0;

	if (isset($sys_save)) { //сохранить системные настройки
		$f = fopen("cfg/settings.inc","w");
		fputs($f,"<?\n\t\$courseN = $curse1;\n");
		fputs($f,"\t\$courseB = $curse2;\n");
		fputs($f,"\t\$NSP = $tax;\n");
		fputs($f,"\t\$shopname = \"$shop_name\";\n");
		fputs($f,"\t\$shopurl = \"$shop_url\";\n?>");
		$path=0;
	};

	if ($path==0) { //показать только таблицу с новыми заказами

		if (isset($done)) { //была нажата кнопка "Заказ(ы) выполнены" -- удалить их из таблицы Orders и уменьшить остаток
					//соответствующих товаров на складе (LeftInWareHouse--)
			$vars = get_defined_vars();
			foreach ($vars as $key => $val)
			  if(strstr($key, "sel_") !== false) {
				$q = mysql_query("SELECT * FROM Orders WHERE OID=$val") or die (mysql_error());
				$row = mysql_fetch_row($q);
				$q = mysql_query("SELECT * FROM OrderedCarts WHERE OID=$val") or die (mysql_error());
				while ($r = mysql_fetch_row($q))
					mysql_query("UPDATE GoodsList SET LeftInWareHouse=LeftInWareHouse-$r[1], Sold=Sold+$r[1] WHERE ID=$r[0]") or die (mysql_error());
				mysql_query("DELETE FROM OrderedCarts WHERE OID=$val") or die (mysql_error());
				mysql_query("DELETE FROM Orders WHERE OID=$val") or die (mysql_error());
			  };
			
		}
		else if (isset($delete) && $delete) { //удалить заказ без уменьшения остатка стовара на складе (LeftInWareHouse)
				$q = mysql_query("DELETE FROM OrderedCarts WHERE OID=$delete") or die (mysql_error());
				mysql_query("DELETE FROM Orders WHERE OID=$delete") or die (mysql_error());
		};

?>

[ <a href="admin.php?path=1">Редактировать товары и категории</a> ]<br>
[ <a href="admin.php?path=2">Статистика</a> ]<br>
[ <a href="admin.php?path=3">Системные настройки</a> ]<br>

<? //выбрать из базы данных все заказы
	$q = mysql_query("SELECT * FROM Orders") or die (mysql_error());
	$result=array(); $i=0;
	while ($row = mysql_fetch_row($q)) $result[$i++] = $row;
	if ($i) {
?>
<form method=post action="admin.php">
<p><b><font>Новые заказы:</font></b></p>
<table width=95% border=0 cellspacing=1 cellpadding=2 bgcolor=#DDDDDD>
<tr bgcolor=#CCCCCC>
<td><b>Заказчик</b></td><td><b>E-mail</b></td><td><b>Адрес</b></td><td><b>Телефон</b></td><td><b>Заказанные товары</b></td>
<td><b>Стоимость заказа</b></td><td><b>Форма оплаты</b></td><td><b>Время заказа</b></td><td><b>Комментарии</b></td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
<?
	for ($i=0; $i<count($result); $i++) {
		$p = mysql_query("SELECT * FROM Users WHERE Login='".addslashes($result[$i][0])."';") or die(mysql_error());
		if (!$r = mysql_fetch_row($p)) { //если пользователь не найден в таблице пользователей, то удалить его заказ
			$p = mysql_query("DELETE FROM Orders WHERE User='".addslashes($result[$i][0])."'") or die (mysql_error());
		}
		else {
			echo "<tr bgcolor=#F3F3F3>\n";
			echo "<td>$r[7]</td>\n";
			echo "<td><a href=\"mailto:$r[2]\">$r[2]</a></td>\n";
			echo "<td>$r[3], $r[4], $r[5]</td>\n";
			echo "<td>$r[6]</td>\n<td>\n";
			//показать товары в корзине заказчика
			$p = mysql_query("SELECT * FROM OrderedCarts WHERE OID='".$result[$i][4]."'") or die (mysql_error());
			$sum=0;
			while ($r = mysql_fetch_row($p)) {
				$s = mysql_query("SELECT * FROM GoodsList WHERE ID=$r[0]") or die (mysql_error());
				$k = mysql_fetch_row($s);
				echo "$k[2] ($r[1] шт.";
				if ($k[7]<$r[1]) { //на складе осталось меньше, чем заказали!
					echo " <font color=red>// ";
					echo ($k[7]<0) ? "0" : $k[7];
					echo " на складе //</font> )<br>\n";
				}
				else echo ")<br>\n";
				$sum += $r[1]*$k[5];
			};
			echo "</td>\n";
			echo "<td>$sum$</td>\n";
			echo "<td>".$result[$i][1]."</td>\n";
			echo "<td>".$result[$i][3]."</td>\n";
			echo "<td>".str_replace("<","&lt;",$result[$i][2])."</td>\n";
			echo "<td><input type=\"checkbox\" name=\"sel_".$result[$i][4]."\" value=\"".$result[$i][4]."\"></td>\n";
			echo "<td><a href=\"javascript:confirmDelete(".$result[$i][4].");\"><img src=\"images/remove.jpg\" border=0 alt=\"Отменить заказ\"></a></td>\n";
			echo "</tr>\n";
		};
	};
?>
<tr bgcolor=#E5E5E5>
<td colspan=10 align=right>
<input type="submit" value="Заказ(ы) выполнены">
<input type="hidden" name="done" value="1">
</td>
<td>&nbsp;</td>
</tr>
</table>
</form>
<? }
   else echo "<br><br><font>&lt;новых заказов нет></font>";
?>

<? } else if ($path==1) { //редактирвание базы данных: категории, товары, пользователи ?>



[ <a href="admin.php">Новые заказы</a> ]<br>
[ <a href="admin.php?path=2">Статистика</a> ]<br>
[ <a href="admin.php?path=3">Системные настройки</a> ]<br>

<p>
<table width=300 height=40 bgcolor=#D2FFD2 border=0>
<tr><td align=center>
<a href="index.php">>> вернуться в магазин &lt;&lt;</a>
</td></tr>
</table>
</p>

<table width=100% border=0>

<tr>
<td width=20% bgcolor=#D2D2FF align=center><b>Категории</b></td>
<td width=33% bgcolor=#F5F5B2 align=center><b>Товары</b></td>
<td width=25% bgcolor=#FFDCDC align=center><b>Пользователи</b></td>
</tr>



<tr>
<td bgcolor=#E2E2FF><!-- редактирование списка категорий товаров -->
<table width=100%>
<tr>
<td><b>Корень</b> (<?
	//посчитать сколько товаров находится в корне
	$q = mysql_query("SELECT * FROM GoodsList WHERE CID=0;") or die (mysql_error());
	$i=0;
	while ($row = mysql_fetch_row($q)) $i++;
	echo $i;
?>
)</td>
<td align=right><font color=red>[</font><a class=small href="admin.php?CID=0&path=1">=></a><font color=red>]</font></td>
</tr>
<?	//показать все категории
	processCategories($cats,0,0);
	echo "</table>\n";
	echo "<br><center>[ <a href=\"javascript:open_window('category.php?w=-1',350,180);\">добавить</a> ]</center><br>";
?>
</td>




<td bgcolor=#FFFFE2 align=center><!-- редактирование таблицы товаров -->
<?

	//написать путь к категории и ее название как заголовок
	$row = array();
	if (!isset($CID) || !$CID) {
		$CID = 0;
		$row[1] = "Корень";
	}
	else { //если как параметр передается CID категории, а такой категории нет, то также переходим в корень
		$q = mysql_query("SELECT * FROM Categories WHERE CID='".$CID."';") or die (mysql_error());
		$row = mysql_fetch_row($q);
		if (!$row) {
			$CID = 0;
			$row[1] = "Корень";
		};
	};
	echo "<br><center><b>".$row[1].":</b></center><br>\n";

	if (!$CID) { //предупреждение
		echo "<font color=red>Все товары, находящиеся в корнe, не будут видны пользователям!</font><br><br>\n";
	};

	//выбрать из БД все товары текущей категории
	$q = mysql_query("SELECT * FROM GoodsList WHERE CID='".$CID."'  ORDER BY Name;") or die (mysql_error());
	$result = array();
	$i=0;
	while ($row = mysql_fetch_row($q)) $result[$i++] = $row;

	if (!$i) echo "<center>&lt;пусто></center>";
	else { //показать товары
		echo "<table border=1 cellspacing=0 cellpadding=3 bordercolor=#C3BD7C bordercolordark=#FFFFE2 width=70%>\n";
		echo "<tr bgcolor=#F5F5C5 align=center><td>Название</td><td>Рэйтинг</td><td>Цена, $</td>";
		echo "<td>Наличие на складе, шт.</td><td>Фото</td><td>Иконка</td><td>Продано, шт.</td></tr>\n";
		for ($i=0; $i<count($result); $i++) {
			echo "<tr><td>\n";
			echo "<a href=\"javascript:open_window('goods.php?ID=".$result[$i][1]."',550,570);\">".$result[$i][2]."</a>";
			echo "</td>\n";

			echo "<td align=right>\n";
			echo $result[$i][4];
			echo "</td>\n";

			echo "<td align=right>\n";
			echo $result[$i][5];
			echo "</td>\n";

			echo "<td align=right>\n";
			//остаток товара на складе -- если 0, то выделить красным цветом
			if ($result[$i][7]<=0) echo "<font color=red>0</font>";
			else echo $result[$i][7];
			echo "</td>\n";


			echo "<td align=center>\n";
			if ($result[$i][6] && file_exists("goods_pictures/".$result[$i][6]))
				echo "есть";
			else echo "<font color=red>нет</font>";
			echo "</td>\n";
			echo "<td align=center>\n";
			if ($result[$i][8] && file_exists("goods_pictures/".$result[$i][8]))
				echo "есть";
			else echo "<font color=red>нет</font>";
			echo "</td>\n";

			echo "<td align=right>".$result[$i][10]."</td>\n</tr>\n";
		};
		echo "</table>\n";
	};
	echo "<br><center>[ <a href=\"javascript:open_window('goods.php?cat=".$CID."',550,570);\">добавить</a> ]</center><br>";

?>
</td>




<td bgcolor=#FFECEC><!-- список пользователей -->
<?

	if (!isset($letter)) $letter="A";
	if (!$letter) echo "Все пользователи:<br><br>";
	else echo "<b>".$letter.":</b><br><br>";

	$q = mysql_query("SELECT * FROM Users WHERE Login LIKE '".$letter."%' ORDER BY Login;") or die (mysql_error());
	$i=0;
	while ($row = mysql_fetch_row($q)) {
		echo "&nbsp<a href=\"javascript:open_window('user.php?uLogin=".str_replace("\"","&quot;",addslashes($row[0]))."',270,350);\">";
		echo str_replace("<","&lt;",str_replace("\"","&quot;",$row[0]))."</a><br>\n";
		$i++;
	};
	if ($i==0) echo "<center>&lt;пусто></center><br>";
	echo "<br><center>Быстрая навигация:<br>[ ";


	//навигатор
	for ($j="A", $i=0; $i<26; $j++, $i++) 
	  if ($j != $letter) echo "<a href=\"admin.php?letter=".$j."&path=1\" class=\"small\">".$j."</a> |\n";
	  else echo $j." |\n";
	echo "<a href=\"admin.php?path=1&letter=\">все</a> ]</center>\n";


?>
</td>
</tr>
</table>

<? } else if ($path==2) { //показать статистику
	echo "[ <a href=\"admin.php\">Новые заказы</a> ]<br>";
	echo "[ <a href=\"admin.php?path=1\">Редактировать товары и категории</a> ]<br>";
	echo "[ <a href=\"admin.php?path=3\">Системные настройки</a> ]<br><br>";

	echo "<p><b><font>Самые <u>популярные</u> товары:</font></b></p>";
	$q = mysql_query("SELECT Name, Popularity, Votes, Sold FROM GoodsList ORDER BY Popularity DESC") or die (mysql_error());
	echo "<table bgcolor=#E1E6FC cellspacing=1 cellpadding=3>\n";
	echo "<tr bgcolor=#D1D9F8><td>Наименование</td><td><b>Популярность</b></td><td>Голосов за товар</td><td>Продано, шт.</td></tr>";
	$i=0;
	while ($i<10 && $row = mysql_fetch_row($q)) {
		echo "<tr bgcolor=#FFFFFF>\n";
		echo "<td>".$row[0]."</td>\n";
		echo "<td align=right><b>".$row[1]."</b></td>\n";
		echo "<td align=right>".$row[2]."</td>\n";
		echo "<td align=right>".$row[3]."</td>\n";
		echo "</tr>\n";
		$i++;
	};
	echo "</table>\n";

	echo "<p><b><font>Самые <u>продаваемые</u> товары:</font></b></p>";
	$q = mysql_query("SELECT Name, Popularity, Votes, Sold FROM GoodsList ORDER BY Sold DESC") or die (mysql_error());
	echo "<table bgcolor=#E1E6FC cellspacing=1 cellpadding=3>\n";
	echo "<tr bgcolor=#D1D9F8><td>Наименование</td><td>Популярность</td><td>Голосов за товар</td><td><b>Продано, шт.</b></td></tr>";
	$i=0;
	while ($i<10 && $row = mysql_fetch_row($q)) {
		echo "<tr bgcolor=#FFFFFF>\n";
		echo "<td>".$row[0]."</td>\n";
		echo "<td align=right>".$row[1]."</td>\n";
		echo "<td align=right>".$row[2]."</td>\n";
		echo "<td align=right><b>".$row[3]."</b></td>\n";
		echo "</tr>\n";
		$i++;
	};
	echo "</table>\n";
} else {

	include("cfg/settings.inc")

?>

[ <a href="admin.php">Новые заказы</a> ]<br>
[ <a href="admin.php?path=1">Редактировать товары и категории</a> ]<br>
[ <a href="admin.php?path=2">Статистика</a> ]<br>

<form action="admin.php?path=3" method=post>
<table>

<tr>
<td align=right>Курс доллара при<br>оплате наличными:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=curse1 value="<?=$courseN; ?>"> рублей</td>
</tr>

<tr>
<td align=right>Курс доллара при<br>оплате безналичными:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=curse2 value="<?=$courseB; ?>"> рублей</td>
</tr>



<tr>
<td align=right>Налог:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=tax value="<?=$NSP; ?>"> %</td>
</tr>

<tr>
<td align=right>Название магазина:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=shop_name value="<?=$shopname; ?>"></td>
</tr>

<tr>
<td align=right>URL магазина:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=shop_url value="<?=$shopurl; ?>"></td>
</tr>

</table><br>

<input type=submit value=Сохранить>
<input type=hidden name=sys_save value=1>

</form>


<? }; ?>
<p>
<table width=300 height=40 bgcolor=#D2FFD2 border=0>
<tr><td align=center>
<a href="index.php">>> вернуться в магазин &lt;&lt;</a>
</td></tr>
</table>
</p>

</center></body>

</html>