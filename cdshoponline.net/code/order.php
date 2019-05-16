<? //оформление заказа

	session_start();
	include("head.incl"); //логотип и форма входа для зарегистрированных пользователей
?>

<!--основная таблица-->
<table border=0 width=100% cellspacing=0>
<tr><td width=120 valign=top>

<table border=0 cellspacing=2 width=120>
<?
	$path = array(); $path[0] = 0;
	processCategories($categories,0,$path,0);
?>
</table><br><br>

<!-- рекламу хорошо размещать здесь -->

<!-- хватит рекламы -->


</td>
<td align=center width=90%>

<? //показать все товары в корзине

	$showTotal = false; //показывать итог (общую стоимость корзины) и кнопку продолжения оформления

	if (!isset($log)) { //берем корзину из $gids

	   //посчитать количество товаров в корзине
	   $k = 0;
	   if (isset($gids)) {
		for ($i=0; $i<count($gids); $i++)
			if ($gids[$i] != 0) $k++;
	   };

	   if ($k) { //корзина не пуста

?>
<font  size=12 color=red><b><u>Order checking</u></b></font><br><br>
<b>Is everything right?</b><br><br>

<table border=0 cellspacing=1 cellpadding=2 bgcolor=#E1E6FC width=70%>
<tr bgcolor=#D1D9F8 align=center>
<td width=40%>Name</td>
<td width=20%>Number</td>
<td width=40% colspan=2>Price, $</td>
</tr>
<?
		$showTotal = true;
		$s = 0;
		for ($i=0; $i<count($gids); $i++) 
		 if ($gids[$i]) {
			$q = mysql_query("SELECT * FROM GoodsList WHERE ID=$gids[$i]") or die (mysql_error());
			if ($r = mysql_fetch_row($q)) {
				echo "<tr bgcolor=#FFFFFF>\n";
				echo "<td>$r[2]</td>\n";
				echo "<td align=center>$counts[$i]</td>\n";
				echo "<td align=center colspan=2>".($r[5]*$counts[$i])."</td>\n";
				echo "</tr>\n";
				$s = $s+$r[5]*$counts[$i]; //считаем итоговую цену
			};
		 };
	   }
	   else echo "Your shopping basket is empty";

	}
	else { //из базы данных
		$q = mysql_query("SELECT * FROM Carts WHERE User='".$log."'") or die (mysql_error());
		$i=0;
		$result = array();
		while ($row = mysql_fetch_row($q)) $result[$i++] = $row;

		if ($i) { //корзина не пуста
			$showTotal = true;

?>
<font class=cat color=red><b><u>Order check</u></b></font><br><br>
<b>Is everything right?</b><br><br>

<table border=0 cellspacing=1 cellpadding=2 bgcolor=#E1E6FC width=70%>
<tr bgcolor=#D1D9F8 align=center>
<td width=40%>Name</td>
<td width=20%>Number</td>
<td width=40% colspan=2>Price, $</td>
</tr>
<?
			$s=0; //общая стоимость корзины
			for ($i=0; $i<count($result); $i++) {
				$q = mysql_query("SELECT * FROM GoodsList WHERE ID='".$result[$i][1]."'") or die (mysql_error());
				if ($r = mysql_fetch_row($q)) {
					echo "<tr bgcolor=white >\n<td>".$r[2]."</td>\n";
					echo "<td align=center>".$result[$i][2]."</td>\n";
					echo "<td align=center colspan=2>".($result[$i][2]*$r[5])."</td>\n";

					$s += $result[$i][2]*$r[5];
				};
			};
		}
		else echo "Your shopping basket is empty";
	};

	if ($showTotal) {

?>

<?  //считаем общую стоимость + доставку

if(isset($log)){
$q = mysql_query("SELECT country FROM Users WHERE login='".$log."'") or die(mysql_error());
$r = mysql_fetch_row($q) or die (mysql_error());
if ($r[0]=='USA'){
	$shipping=5;
	$t_cost=$s+5;
	}else{
	$t_cost=$s+7.5;
	$shipping=7.5;
	}
}else{
	$t_cost=$s;
}


?>
<tr bgcolor=#FFFFFF>
<td>shipping</td>
<td></td>
<td colspan=2  align=center><?=$shipping; ?>$</td></tr>

<tr bgcolor=#FFFFFF>
<td><b>Total cost with shipping:</b></td>
<td></td>
<td colspan=2 bgcolor=#F1F6FC align=center><b><?=$t_cost; ?>$</b></td></tr>

</table>

<table border=0 width=70%>

<tr bgcolor=white>
<td width=40%>&nbsp;</td>
<td width=20%>&nbsp;</td>
</tr>










<tr bgcolor=#f1f6fc><td align=right>

<?
	$q = mysql_query("SELECT * FROM Users WHERE Login='$log'");
	$row = mysql_fetch_row($q);
	echo "Your order will be deliver to the address:</td><td align=center><b>$row[3], $row[4], $row[5]</b></td></tr>";
	echo "<tr bgcolor=#f1f6fc><td align=right>Customer:</td><td align=center><b>$row[7]</b>";
?>

</td></tr>

</table>


<form action="completeorder.php" method=post>
<?
print 	"<input type='hidden' name='shipping' value='$shipping'>";
	?>
<table width=70%>
<tr>
<td bgcolor='#F1F6FC' width='60%'>
<div align=center>Any addition information?</div>
</td>
<td align=right width='40%'>
<textarea name="comment" rows=5 cols=25>
</textarea>
</td>
</tr>
<tr>
<? //<input type=button class=bluebutton value="Your cart" onClick="open_window('cart.php',400,300);"> ?>
<td></td>
<td align=right><input type=submit class=redbutton value="<Proceed to checkout>"></td>
</tr>

</table>
</form>

<? }; ?>

</td></tr>
</table>





<?

	showNavigation($shopname);
?>

</body>
</html>