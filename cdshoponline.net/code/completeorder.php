<? //завершение оформления заказа

	session_start();

	include("head.incl");

	if (!isset($log)) exit;

	//проверить наличие товаров в корзине, т.е. посчитать их ($k):
	$k=0;
	$q = mysql_query("SELECT * FROM Carts WHERE User='".$log."'") or die (mysql_error());
	while ($row = mysql_fetch_row($q)) $k++;
	if (!$k) {
		echo "<center><font>Your shopping basket is empty!</font></center>";
		exit;
	};

	if (!isset($comment)) $comment="";

	//записать заказ в базу данных в таблицу Orders
	$timestamp = time();
	$payment="Credit Card";
	//добавить новый заказ в базу данных
	mysql_query("INSERT INTO Orders VALUES ('$log', '$payment', '$comment','".(strftime("%c", $timestamp))."',0);") or die (mysql_error());
	$OID = mysql_insert_id();


	//отправить уведомление о новом заказе администратору по эл. почте
	$q = mysql_query("SELECT Email FROM Users WHERE Login='MANAGER'") or die (mysql_error());
	$rr = mysql_fetch_row($q);
	$q = mysql_query("SELECT * FROM Users WHERE Login='$log'") or die (mysql_error());
	$r = mysql_fetch_row($q);

	$s1 = "Поступил новый заказ!\n\n";
	$s1 .= "Заказчик: $r[7] ($r[2])\n";
	$s1 .= "Адрес: $r[3], $r[4], $r[5]\n";
	$s1 .= "Телефон: $r[6]\n\n";
	$s1 .= "Заказ:\n";

	include("cfg/settings.inc");

	//товары корзины пользователя (из таблицы Carts) передвинуть в таблицу OrderedCart
	$k=0;
	$s="";
	$q = mysql_query("SELECT * FROM Carts WHERE User='$log'") or die (mysql_error());
	while ($row = mysql_fetch_row($q)) {
		mysql_query("INSERT INTO OrderedCarts VALUES ($row[1],$row[2],$OID)") or die (mysql_error());
		$p = mysql_query("SELECT * FROM GoodsList WHERE ID=$row[1]") or die (mysql_error());
		$ro = mysql_fetch_row($p);
		$k += $row[2]*$ro[5];
		$s .= "$ro[2] ($row[2])\n";
	};
	
	$s.= "\nCost: $k$\n Method of payment: Credit Card\n";
	$tt=$k+$shipping;
	if(isset($shipping))  $s.="Shipping: $shipping$\nTotal cost: $tt$\n";
	else  $s.= "Total cost: $k$+shipping\n";
//	print "$s";
	

	 
	
	mail($rr[0], "Новый заказ!", $s1.$s, "From: $shopname<>;\nContent-Type: text/plain; charset=\"windows-1251\"");
	mail($r[2], "Your order!", "Hello!\n\nThank you for your order:\n$s\n\n $shopname team.\n$shopurl", "From: $shopname<$rr[0]>;\nContent-Type: text/plain; charset=\"windows-1251\"");

	//товары из корзины пользователя удалить
	mysql_query("DELETE FROM Carts WHERE User='$log'") or die (mysql_error());
	session_unregister("order_step");

?>
<table border=0 width=100% cellspacing=5 cellpadding=5>

<tr><td width=120 valign=top>
<table border=0 cellspacing=2 width=120>
<?

	$path = calculatePath($categories, $CID); //посчитать путь до выбранной категории
	processCategories($categories,0,$path,$CID);
?>
</table><br><br>

<!-- реклама -->

</td>
<td align=center width=90%>
<b>Your order is passed!<br></b>
</td>
</tr>
</table>
<?
	showNavigation($shopname);
?>
</body>
</html>