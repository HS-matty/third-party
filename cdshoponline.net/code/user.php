<? //информация о пользователе

	//проверка на санкцианированный доступ
	session_start();

	//соединиться с БД
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //несанкционированный доступ! Alarm!
		exit;
	};

	if (!isset($uLogin)) $uLogin="";
?>

<html>

<head>
<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Пользователи</title>
<script>
function confirmDelete() {
	temp = window.confirm('Удалить пользователя?');
	if (temp) { //удалить
		window.location='user.php?uLogin=<?=$uLogin;?>&del=1';
	};
};
</script>
</head>

<body bgcolor=#FFECEC>
<center>

<?
	if (isset($del) && strcmp($uLogin,"MANAGER")) { //удалить
		//сначала отправить уведомление об этом самому пользователю
		$q = mysql_query("SELECT * FROM Users WHERE Login='".$uLogin."';") or die (mysql_error());
		$row = mysql_fetch_row($q);
		$q = mysql_query("SELECT Email FROM Users WHERE Login='MANAGER'") or die (mysql_error());
		$r = mysql_fetch_row($q);

		include("cfg/settings.inc");
		mail($row[2],"Ваш аккаунт закрыт :(","Здравствуйте!\n\nПо воле менеджера магазина Ваш аккаунт был удален из списка наших заказчиков! По всем вопросам обращайтесь на $r[0]\n\nС уважением, $shopname.\n$shopurl", "From: $shopname<$r[0]>;\nContent-Type: text/plain; charset=\"windows-1251\"");

		$q = mysql_query("DELETE FROM Users WHERE Login='$uLogin';") or die (mysql_error());
		//закрыть окно
		echo "<script>\n";
		echo "window.opener.location.reload();\n";
		echo "window.close();";
		echo "</script>\n</body>\n</html>";
		exit;
	};

	$q = mysql_query("SELECT * FROM Users WHERE Login='$uLogin';") or die (mysql_error());
	$row = mysql_fetch_row($q);
	if (!$row) { //пользователя не существует
		echo "<font color=red>Пользователь не найден в базе данных!";
		echo "<br>Нажмите кнопку \"Обновить\" в броузере, который используется для режима \"Администратор\"</font>\n<br><br>\n";
		echo "<a href=\"javascript:window.close();\">Закрыть окно</a></center></body>\n</html>";
		exit;
	};

?>

<table border=0 cellspacing=3 width=100%>

<tr>
<td align=right width=40%>Логин:</td>
<td><b><?=str_replace("<","&lt;",$row[0]); ?></b></td>
</tr>

<tr>
<td align=right>Пароль:</td>
<td><b><?=str_replace("<","&lt;",$row[1]); ?></b></td>
</tr>

<tr>
<td align=right>Пароль:</td>
<td><b><?=str_replace("<","&lt;",$row[1]); ?></b></td>
</tr>

<tr>
<td align=right>E-mail:</td>
<td><a href="mailto:<?=str_replace("<","&lt;",$row[2]); ?>"><?=str_replace("<","&lt;",$row[2]); ?></a></td>
</tr>

<tr>
<td align=right>Полное имя:</td>
<td><b><?=str_replace("<","&lt;",$row[7]); ?></b></td>
</tr>

<tr>
<td align=right>Страна:</td>
<td><b><?=str_replace("<","&lt;",$row[3]); ?></b></td>
</tr>

<tr>
<td align=right>Город:</td>
<td><b><?=str_replace("<","&lt;",$row[4]); ?></b></td>
</tr>

<tr>
<td align=right>Адрес:</td>
<td><b><?=str_replace("<","&lt;",$row[5]); ?></b></td>
</tr>

<tr>
<td align=right>Телефон:</td>
<td><b><?=str_replace("<","&lt;",$row[6]); ?></b></td>
</tr>

</table>

<form>
<input type="button" value="Закрыть" onClick="window.close();">
<?
	if (strcmp($row[0],"MANAGER")) echo "<input type=\"button\" value=\"Удалить\" onClick=\"confirmDelete();\">\n";
?>
</form>

</center>
</body>

</html>