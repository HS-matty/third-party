<? //корзина пользователя

	session_start();

	//соединиться с БД
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	include("checklogin.php");

	if (isset($add) && $add>0) { //добавить товар в корзину

		if (!isset($log)) { //если пользователь не вошел в свой сеанс, то запоминать, что у него в корзине, будем с помощью переменных сеанса

			//$gids[] -- массив, составленный из ID товаров в корзине
			//$counts[] -- из количеств соответствующих товаров (т.е. $gids[$i]'ому соответствует $counts[$i])
			//если $gids[$i] == 0, то считается, что ячейка пуста -- такое может случиться при удалении товара из корзины
			if (!isset($gids)) {
				$gids = array();
				$counts = array();
			};
			//посмотреть -- есть ли уже такой товар в корзине
			$i=0;
			while ($i<count($gids) && $gids[$i] != $add) $i++;
			if ($i < count($gids)) //такой товар уже есть -- увеличиваем его количество
				$counts[$i]++;
			else { //товара нет -- добавляем его в конец массива
				$gids[count($gids)] = $add;
				$counts[count($counts)] = 1;
			};
			//добавить изменения в сеанс
			session_register("gids");
			session_register("counts");
		}
		else { //пользователь вошел под своим логином => берем содержимое корзины из базы данных и заносим по необходимости изменения в нее
			$q = mysql_query("SELECT * FROM Carts WHERE User='".$log."' AND GID=".$add) or die (mysql_error());
			if ($row = mysql_fetch_row($q)) { //в корзине уже есть такой товар -- поэтому увеличить его количество
				$q = mysql_query("UPDATE Carts SET Quantity=".($row[2]+1)." WHERE User='".$log."' AND GID=".$add) or die (mysql_error());
			}
			else { //добавить товар в корзину
				$q = mysql_query("INSERT INTO Carts VALUES ('".$log."', ".$add.", 1)") or die (mysql_error());
			};
		};

		//оформление заказа опять начинать с 1ого этапа
		if (isset($order_step)) {
			session_unregister("order_step");
			unset($order_step);
		};
	};


	if (isset($remove) && $remove>0) { //удалить товар из корзины -- $remove - это индекс удаляемого товара

		if (isset($log)) $q = mysql_query("DELETE FROM Carts WHERE User='$log' AND GID=".$remove) or die (mysql_error());
		else { //удалить товар "из переменных сеанса"
			$i=0;
			while ($i<count($gids) && $gids[$i] != $remove) $i++;
			if ($i<count($gids)) $gids[$i]=0;
			//добавить изменения в сеанс
			session_register("gids");
			session_register("counts");
		};

		//оформление заказа опять начинать с 1ого этапа
		if (isset($order_step)) {
			session_unregister("order_step");
			unset($order_step);
		};

	};


	if (isset($update)) { //"пересчитать" корзину
		$vars = get_defined_vars();
		foreach ($vars as $key => $val)
			if (strstr($key, "count_")) {
			  if (isset($log)) { //обновить данные в базе данных
				if ($val>0) //$val -- кол-во единиц товара в корзине
					$q = mysql_query("UPDATE Carts SET Quantity=$val WHERE User='$log' AND GID=".str_replace("count_","",$key)."") or die (mysql_error());
				else //$val==0 => удалить товар из корзины
					$q = mysql_query("DELETE FROM Carts WHERE User='$log' AND GID=".str_replace("count_","",$key)."") or die (mysql_error());
			  }
			  else { //в переменных сеанса
				if ($val>0) {
					for ($i=0; $i<count($gids); $i++)
						if ($gids[$i] == str_replace("count_","",$key)) {
							$counts[$i] = $val;
						};
				}
				else { //удалить
					$i=0;
					while ($gids[$i] != str_replace("count_","",$key) && $i<count($gids)) $i++;
					$gids[$i]=0;
					//добавить изменения в сеанс
					session_register("gids");
					session_register("counts");
				};
			  };
			};

		//оформление заказа опять начинать с 1ого этапа
		if (isset($order_step)) {
			session_unregister("order_step");
			unset($order_step);
		};

	};

	if (isset($clear_cart)) { //очистить корзину
		if (isset($log)) $q = mysql_query("DELETE FROM Carts WHERE User='".$log."'") or die (mysql_error());
		else {
			//удалить все переменные саенса
			session_unregister("gids");
			session_unregister("counts");
			unset($gids);
			unset($counts);
		};

		//оформление заказа опять начинать с 1ого этапа
		if (isset($order_step)) {
			session_unregister("order_step");
			unset($order_step);
		};

	};

?>
<html>

<head>
<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>
Shopping cart<? if (isset($log)) echo ": ".$log; ?></title>
<script>

function Order_shopping() { //оформление заказа -- закрыть окно и перейти к странице оформления заказа в главном окне
<?
	echo "window.opener.location = ";
	

		if (isset($log)) echo "\"order.php\";";
		else echo "\"register.php?order=true\";";
		

?>
	window.close();
};

</script>
</head>

<body><center>

<?

if (isset($log)) { //взять корзину из базы данных

	$q = mysql_query("SELECT * FROM Carts WHERE User='".$log."'") or die (mysql_error());
	$i=0;
	$result = array();
	while ($row = mysql_fetch_row($q)) $result[$i++] = $row;

	if ($i) { //корзина не пуста -- показать товары

		echo "<table width=100%><tr><td><font color=#3551C7><b>Your shopping basket:</b></font></td>\n";
		echo "<td align=right><a href=\"cart.php?clear_cart=yes\"><font color=#2531A7><img src=\"images/remove.jpg\" border=0 > <u>Clear</u></font></a></td></table>\n";

		echo "<form action=\"cart.php?update=yes\" method=post>";
		echo "<table width=100% border=0 cellspacing=1 cellpadding=2 bgcolor=#E1E6FC>\n<tr align=center bgcolor=#D1D9F8>\n";
		echo "<td><font color=#3551C7>Name</font></td>\n<td><font color=#3551C7>Number</font></td><td><font color=#3551C7>Price, $</font></td><td width=20></td></tr>\n";
		$k=0; //общая стоимость корзины
		for ($i=0; $i<count($result); $i++) {
			$q = mysql_query("SELECT * FROM GoodsList WHERE ID='".$result[$i][1]."'") or die (mysql_error());
			if ($r = mysql_fetch_row($q)) {
				echo "<tr bgcolor=white >\n<td>".$r[2]."</td>\n";
				echo "<td align=center><input type=\"text\" name=\"count_".$result[$i][1]."\" size=5 value=\"".$result[$i][2]."\"></td>\n";
				echo "<td align=center>".($result[$i][2]*$r[5])."</td>\n";
				echo "<td align=center><a href=\"cart.php?remove=".$result[$i][1]."\"><img src=\"images/remove.jpg\" border=0 alt=\"remove\"></a></td>\n</tr>\n";

				$k += $result[$i][2]*$r[5];
			};
		};
		//итого...
		echo "<tr bgcolor=white><td><font class=cat><b>Total:</b></font></td><td><br><br></td><td bgcolor=#F1F6FC align=center><font class=cat><b>".$k."$</b></font></td><td></td></tr>\n";

		echo "</table>\n";
		echo "<table width=100% border=0>\n";
		echo "<tr><td align=right><input type=\"submit\" class=bluebutton value=\"recount\"></td></tr>\n";
		echo "</table>\n";
		echo "</form>\n";

		echo "<form action=\"javascript:Order_shopping();\" method=post>\n";
		echo "<table width=100% border=0>\n";
		echo "<tr><td align=center><input type=\"submit\" class=\"redbutton\" value=\"Buy now!\"></td>\n";
		echo "<td align=center><input type=\"button\" class=\"bluebutton\" value=\"Close\" onClick=\"window.close();\"></td>\n";
		echo "</table>\n";
		echo "</form>\n";

	}
	else { //пусто!
		echo "<font>Your shopping basket!</font><br><br>\n";
		echo "<form><input type=\"button\" class=\"bluebutton\" value=\"close\" onClick=\"window.close();\"></form>\n";
	};
}
else { //список элементов корзины -- берем из $gids[]

	//посчитаем кол-во товаров в корзине
	$c=0;
	if (isset($gids))
		for ($j=0; $j<count($gids); $j++) if ($gids[$j]) $c++;

	//если корзинa не пуста
	if (isset($gids) && $c) {
		echo "<table width=100%><tr><td><font color=#3551C7><b>Your shopping basket:</b></font></td>\n";
		echo "<td align=right><a href=\"cart.php?clear_cart=yes\"><font color=#2531A7><img src=\"images/remove.jpg\" border=0> <u>Clear</u></font></a></td></table>\n";

		echo "<form action=\"cart.php?update=yes\" method=post>";
		echo "<table border=0 cellspacing=1 cellpadding=2 bgcolor=#E1E6FC width=100%>\n<tr align=center bgcolor=#D1D9F8>\n";
		echo "<td><font color=#3551C7>Name</font></td>\n<td><font color=#3551C7>Number</font></td><td><font color=#3551C7>Price, $</font></td><td width=20></td></tr>\n";
		$k=0; //общая стоимость корзины
		for ($i=0; $i<count($gids); $i++)
		  if ($gids[$i]) {
			$q = mysql_query("SELECT * FROM GoodsList WHERE ID='".$gids[$i]."'") or die (mysql_error());
			if ($r = mysql_fetch_row($q)) {
				echo "<tr bgcolor=white >\n<td>".$r[2]."</td>\n";
				echo "<td align=center>\n";
				echo "<input type=\"text\" name=\"count_$gids[$i]\" size=5 value=\"".$counts[$i]."\">\n</td>\n";
				echo "<td align=center>".($counts[$i]*$r[5])."</td>\n";
				echo "<td align=center><a href=\"cart.php?remove=$gids[$i]\" class=small><img src=\"images/remove.jpg\" border=0 alt=\"remove\"></a></td>\n</tr>\n";

				$k += $counts[$i]*$r[5];
			};
		  };
		//итого...
		echo "<tr bgcolor=white><td><font class=cat><b>Total:</b></font></td><td><br><br></td><td bgcolor=#F1F6FC align=center><font class=cat><b>".$k."$</b></font></td><td></td></tr>\n";

		echo "</table>\n";

		echo "<table width=100% border=0>\n";
		echo "<tr><td align=right><input class=\"bluebutton\" type=\"submit\" value=\"recount\"></td></tr>\n";
		echo "</table>\n";
		echo "</form>\n";

		echo "<form action=\"javascript:Order_shopping();\" method=post>\n";
		echo "<table width=100% border=0>\n";
		echo "<tr><td align=center><input type=\"submit\" class=\"redbutton\" value=\"Buy now!\"></td>\n";
		echo "<td align=center><input type=\"button\" class=\"bluebutton\" value=\"Close\" onClick=\"window.close();\"></td>\n";
		echo "</table>\n";

		echo "</form>\n";

	}
	else {
		echo "<p><font>Your shopping basket is empty!</font></p>\n";
		echo "<form><input type=\"button\" class=\"bluebutton\" value=\"Close\" onClick=\"window.close();\"></form>\n";
	};

};

?>
</center></body>

</html>