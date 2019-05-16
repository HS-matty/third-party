<? //регистрация нового пользователя


function showFinalStep($log) { //показать следующий шаг оформления -- выбор способа оплаты и задание комментария по поводу доставки
?>
<br><center><font class=cat color=red><b><u>Choose your method of payment and delivery.</u></b></font><br><br><br>

<form action="completeorder.php">

<center>
<table>
<tr>
<td align=right>
Choose your method of order payment:
</td>
<td>
<option value="Кредитная картa">Credit card</option>
</select>
</td>
</tr>
<tr>
<td align=right>
Any addition information?<br>
</td>
<td>
<textarea name="comment" rows=5 cols=25>
</textarea>
</td>
</tr>

<tr>
<td></td>
<td>
<input type=submit class=redbutton value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
</td>
</tr>
</table><br><br>

<table>
<tr><td color=#DDDDDD>
<?
	$q = mysql_query("SELECT * FROM Users WHERE Login='$log'");
	$row = mysql_fetch_row($q);
	echo "Your order will be deliver to the address:</td><td><b>$row[3], $row[4], $row[5]</b></td></tr>";
	echo "<tr><td>Customer:</td><td><b>$row[7]</b>";
?>
</td></tr>
</table>

</center>

</form>

</td></tr>
</table>

<?
	include("cfg/settings.inc");
	showNavigation($shopname);

	echo "</body>\n</html>";
};



function DrawForm($login,$pw,$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,$error,$log) { 
			$referer = getenv("HTTP_REFERER");
			if (strstr($referer,'order.php')){
				$go_2_order=1;
			}else{
				$go_2_order=0;
			}

//создает форму введения данных для регистрации
		//$order_step -- текущий шаг оформления
		//$edit = 0, если находимся в режиме регистрации, а не изменения личных данных
		//$error = true, если допущена ошибка при вводе данных

	if ($order_step == 1) { //пользователю необходимо зарегистрироваться или пойти под своим логином
	  if (!$error) {
		echo "<center><font class=cat size=12 color=red><b><u>Shop entry </u></b></font><br><br>\n";
		
		echo "To begin checkout, please sign in or create a new account.</center><br><br>\n";
	  };
		echo "<table width=100%>\n<tr>\n<td align=center>\n";
	}

	if ($order_step == 2 && !$edit) { //последний этап -- выбор оплаты + комментарии по доставке
		showFinalStep($log);
	}
	else {

	//форма регистрации нового пользователя или изменения данных существующего
	echo "<form action=\"register.php\" method=\"POST\">\n\n";

	if (!$error)
	 if ($edit) echo "<b>$login ::Private information<br><br></b>\n\n";
	 else echo "<b>Registration of new user<br><br></b>\n\n";

	echo "<font color=gray>// all fields are necessary  //</font><br><br>\n";

	echo "<table border=0 cellspacing=3 width=70%>\n";

	if (strcmp($login,"MANAGER") || !$edit) {
		echo "<tr>\n<td align=right>Login:</td>\n";
		echo "<td><input type=\"text\" name=\"login\" value=\"".stripslashes(str_replace("\"","&quot;",$login))."\"><br>\n";
		echo "<font class=\"average\" color=brown><b>&lt;20</b> symbols</font></td>\n</tr>\n\n";
	}
	else {
		echo "<input type=\"hidden\" name=\"login\" value=\"MANAGER\">\n";
	};

	echo "<tr>\n<td align=right>Password:</td>\n";
	echo "<td><input type=\"password\" name=\"pw\"";
	if ($edit) echo " value=\"$pw\"";
	echo "><br>\n";
	echo "<font class=\"average\" color=brown><b>&lt;15</b> symbols</font></td>\n</tr>\n\n";

	echo "<tr>\n<td align=right>Retype password:</td>\n";
	echo "<td><input type=\"password\" name=\"_pw\"";
	if ($edit) echo " value=\"$pw\"";
	echo "></td>\n</tr>\n\n";

	echo "<tr>\n<td align=right>E-mail:</td>\n";
	echo "<td><input type=\"text\" name=\"email\" value=\"".stripslashes(str_replace("\"","&quot;",$email))."\" size=35></td>\n</tr>\n\n";

	echo "<tr>\n<td align=right>Full name:</td>\n";
	echo "<td><input type=\"text\" name=\"fullname\" value=\"".stripslashes(str_replace("\"","&quot;",$fullname))."\"></td>\n</tr>\n\n";

$country_=stripslashes(str_replace("\"","&quot;",$country));
	
//	echo "<tr>\n<td align=right>Country:</td>\n";
//	echo "<td><input type=\"text\" name=\"country\" //value=\"".stripslashes(str_replace("\"","&quot;",$country))."\"></td>\n</tr>\n\n";
	echo "<tr>\n<td align=right>Country:</td>\n";
echo "<td><SELECT NAME=country><OPTION SELECTED>$country_<OPTION>"; 
?>
USA<OPTION>Albania<OPTION>Algeria<OPTION>Andorra<OPTION>Angola<OPTION>Anguilla<OPTION>Antigua & Barbuda<OPTION>Argentina<OPTION>Armenia<OPTION>Aruba<OPTION>Australia<OPTION>Austria<OPTION>Azerbaijan<OPTION>Azores<OPTION>Bahamas<OPTION>Bahrain<OPTION>Bangladesh<OPTION>Barbados<OPTION>Barbuda<OPTION>Belarus<OPTION>Belgium<OPTION>Belize<OPTION>Benin<OPTION>Bermuda<OPTION>Bhutan<OPTION>Bolivia<OPTION>Bosnia-Herzegovina<OPTION>Botswana<OPTION>Brazil<OPTION>British Virgin Islands<OPTION>Brunei Darussalam<OPTION>Bulgaria<OPTION>Burkina Faso<OPTION>Burma<OPTION>Burundi<OPTION>Cameroon<OPTION>Canada<OPTION>Cape Verde<OPTION>Cayman Islands<OPTION>Central African Republic<OPTION>Chad<OPTION>Chile<OPTION>China<OPTION>Colombia<OPTION>Comoros<OPTION>Congo<OPTION>Corsica<OPTION>Costa Rica<OPTION>Cote D'Ivoire<OPTION>Croatia<OPTION>Cyprus<OPTION>Czech Republic<OPTION>Denmark<OPTION>Djibouti<OPTION>Dominica<OPTION>Dominican Republic<OPTION>Ecuador<OPTION>Egypt<OPTION>El Salvador<OPTION>Equatorial Guinea<OPTION>Eritrea<OPTION>Estonia<OPTION>Ethiopia<OPTION>Faroe Islands<OPTION>Fiji<OPTION>Finland<OPTION>France<OPTION>French Guiana<OPTION>French Polynesia<OPTION>Gabon<OPTION>Gambia<OPTION>Georgia, Republic of<OPTION>Germany<OPTION>Ghana<OPTION>Gibraltar<OPTION>Greece<OPTION>Greenland<OPTION>Grenada<OPTION>Guadeloupe<OPTION>Guatemala<OPTION>Guinea<OPTION>Guinea-Bissau<OPTION>Guyana<OPTION>Haiti<OPTION>Honduras<OPTION>Hong Kong<OPTION>Hungary<OPTION>Iceland<OPTION>India<OPTION>Indonesia<OPTION>Iran<OPTION>Ireland<OPTION>Israel<OPTION>Italy<OPTION>Jamaica<OPTION>Japan<OPTION>Jordan<OPTION>Kazakhstan<OPTION>Kenya<OPTION>Kiribati<OPTION>Korea, Republic of<OPTION>Kuwait<OPTION>Kyrgystan<OPTION>Laos<OPTION>Latvia<OPTION>Lebanon<OPTION>Lesotho<OPTION>Libya<OPTION>Liechtenstein<OPTION>Lithuania<OPTION>Luxembourg<OPTION>Macao<OPTION>Macedonia<OPTION>Madagascar<OPTION>Madeira Islands<OPTION>Malawi<OPTION>Malaysia<OPTION>Maldives<OPTION>Mali<OPTION>Malta<OPTION>Manua Islands<OPTION>Martinique<OPTION>Mauritania<OPTION>Mauritius<OPTION>Mexico<OPTION>Moldova<OPTION>Monaco<OPTION>Montserrat<OPTION>Morocco<OPTION>Mozambique<OPTION>Namibia<OPTION>Nauru<OPTION>Nepal<OPTION>Netherlands<OPTION>Netherlands Antilles<OPTION>Nevis<OPTION>New Caledonia<OPTION>New Zealand<OPTION>Nicaragua<OPTION>Niger<OPTION>Nigeria<OPTION>Norway<OPTION>Oman<OPTION>Pakistan<OPTION>Panama<OPTION>Papua New Guinea<OPTION>Paraguay<OPTION>Peru<OPTION>Philippines<OPTION>Pitcairn Islands<OPTION>Poland<OPTION>Portugal<OPTION>Qatar<OPTION>Reunion<OPTION>Romania<OPTION>Russia<OPTION>Rwanda<OPTION>Saint Christopher<OPTION>Samoa, American<OPTION>San Marino<OPTION>Saudi Arabia<OPTION>Senegal<OPTION>Seychelles<OPTION>Sierra Leone<OPTION>Singapore<OPTION>Slovak Republic<OPTION>Slovenia<OPTION>Solomon Islands<OPTION>Somalia<OPTION>South Africa<OPTION>South Korea<OPTION>Spain<OPTION>Sri Lanka<OPTION>St Christopher & Nevis<OPTION>St Helena<OPTION>St Kitts<OPTION>St Lucia<OPTION>St Pierre & Miquelon<OPTION>St Vincent & Grenadines<OPTION>Sudan<OPTION>Suriname<OPTION>Swaziland<OPTION>Sweden<OPTION>Switzerland<OPTION>Syrian Arab Republic<OPTION>Taiwan<OPTION>Tajikistan<OPTION>Tanzania<OPTION>Thailand<OPTION>Togo<OPTION>Tonga<OPTION>Trinidad & Tobago<OPTION>Tristan De Cunha<OPTION>Tunisia<OPTION>Turkey<OPTION>Turkmenistan<OPTION>Turks and Caicos Is<OPTION>Tuvalu<OPTION>Uganda<OPTION>Ukraine<OPTION>United Arab Emirates<OPTION>United Kingdom<OPTION>Uruguay<OPTION>Uzbekistan<OPTION>Vanuatu<OPTION>Vatican city<OPTION>Venezuela<OPTION>Vietnam<OPTION>Wallis & Futuna Islands<OPTION>Western Samoa<OPTION>Yemen, Republic of<OPTION>Zaire<OPTION>Zambia<OPTION>Zimbabwe</select><?
	
	
	
	
	
	
	
	echo "<tr>\n<td align=right>City:</td>\n";
	echo "<td><input type=\"text\" name=\"city\" value=\"".stripslashes(str_replace("\"","&quot;",$city))."\"></td>\n</tr>\n\n";

	echo "<tr>\n<td align=right>Address:</td>\n";
	echo "<td><input type=\"text\" name=\"address\" value=\"".stripslashes(str_replace("\"","&quot;",$address))."\" size=35></td>\n</tr>\n\n";

	echo "<tr>\n<td align=right>Phone number:</td>\n";
	echo "<td><input type=\"text\" name=\"phone\" value=\"".stripslashes(str_replace("\"","&quot;",$phone))."\"></td>\n</tr>\n\n";

	echo "</table>\n\n";

	echo "<p><center><input type=\"submit\" value=\"submit\">\n";
	echo "<input type=\"hidden\" name=\"go_2_order\" value=\"$go_2_order\">";
	if ($edit) echo "<input type=\"hidden\" name=\"edit\" value=\"true\">";
	echo "<input type=\"hidden\" name=\"p\" value=\"";
	echo $edit ? "1\">\n" : "0\">\n";
	echo "<input type=\"reset\" value=\"clear the form\"></p>\n";
	echo "</form>\n";
	if ($order_step==1) { //показать форму входа пользователя

		echo "</td>\n<td align=center valign=top>\n";
		echo "<form action=\"register.php\" method=post>\n<table width=120 border=0 cellspacing=1 cellpadding=2 bgcolor=#E1E6FC>\n";
		echo "<tr bgcolor=#D1D9F8><td colspan=2 align=center>Enter for registered users</td></tr>\n";
		echo "<tr bgcolor=white><td align=right>Login:<br>password:<br></td>\n";
		echo "<td><input type=\"text\" name=\"user_login\" size=13><br><input type=\"password\" name=\"user_pw\" size=13></td></tr>\n";
		echo "<tr bgcolor=white><td colspan=2 align=center><input type=submit value=\"Login\"></td></tr>";
		echo "</table>\n";
		echo "<input type=\"hidden\" name=\"enter1\" value=\"1\">\n";
		echo "</form>";

		echo "</td></tr></table>\n";
	};

	if ($edit && strcmp($login,"MANAGER")) //кнопка "Удалить"
	echo "<a href=\"javascript:confirmDelete()\" class=small>удалить аккаунт</a>";

	echo "</td>\n</tr>\n</table>\n\n";

	include("cfg/settings.inc");
	showNavigation($shopname);

	echo "</body>\n</html>";

	};
};



	include("head.incl");

?>
<!-- основная таблица: здесь список категорий, форма регистрации и т.д. -->
<table border=0 width=100% cellspacing=0>
<tr><td width=120 valign=top>

<table border=0 cellspacing=2>
<?
	$path = array(); $path[0]=0;
	processCategories($categories,0,$path,0);
?>
</table><br><br>

<!-- рекламу хорошо размещать здесь -->

<!-- хватит рекламы -->

</td><td align=center>

<?

	if (isset($order)) { //если $order==true, то продолжаем оформление заказа -- этап рeгистрации
		if ($order_step == -1) $order_step=0;
	} else if (!$order_step) $order_step=-1;


	if (!isset($edit)) $edit=false; //$edit==true, если пользователь меняет свои настройки

	if ($edit && isset($log) && !isset($p)) { //изменение адреса и других настроек пользователя - взять информацию о нем из БД


		$q = mysql_query("SELECT * FROM Users WHERE Login='".$log."';") or die (mysql_error());
		if ($row = mysql_fetch_row($q)) {
			$login = addslashes($row[0]);
			$fullname = addslashes($row[7]);
			$email = addslashes($row[2]);
			$country = addslashes($row[3]);
			$city = addslashes($row[4]);
			$address = addslashes($row[5]);
			$phone = addslashes($row[6]);
		};
	};

	//проверка и запись введенной информации в базу данных
	//инициализация переменных формы
	if (!isset($login)) $login="";
	if (!isset($pw))
		if (isset($pass)) $pw=$pass;
		else $pw="";
	if (!isset($email)) $email="";
	if (!isset($fullname)) $fullname="";
	if (!isset($country)) $country="";
	if (!isset($city)) $city="";
	if (!isset($address)) $address="";
	if (!isset($phone)) $phone="";

	if (isset($enter1)) { //нажата кнопка входа пользователя при оформлении заказа

		//ищем пользователя в базе данных
		$q = mysql_query("SELECT * FROM Users WHERE Login='".$user_login."'") or die (mysql_error());
		if (($row = mysql_fetch_row($q)) && (!strcmp($row[0],stripslashes($user_login))) && (!strcmp($row[1],stripslashes($user_pw)))) {
			//ползователь существует -- зарегистрировать сессию

			$log = $user_login;
			$pass = stripslashes($user_pw);
			session_register("log");
			session_register("pass");

			//продолжаем оформление заказa
			$order_step = 2;

			//в корзине пользователя (если он уже когда-то зарегистрировался) могли остаться товары. Удалить их от туда
			$q = mysql_query("DELETE FROM Carts WHERE User='".$log."'") or die(mysql_error());

			//теперь все товары, лежащие сейчас в корзине, переместить в базу данных
			if (isset($gids)) {
				for ($i=0; $i<count($gids); $i++)
				  if ($gids[$i]) $q = mysql_query("INSERT INTO Carts VALUES ('$log',".$gids[$i].",".$counts[$i].")");
				session_unregister("gids");
				session_unregister("counts");
			};
//			header("order.php");
//			showFinalStep($log);
print "<script language='javascript'>window.location=\"order.php\"</script>";
			exit;

		}
		else { //ошибка входа!
			echo "<p><center><font color=red><b>Wrong login or password</b></font></center></p>\n";
		};
	};

	if (isset($p) && $order_step<=1) { //была нажата кнопка "Готово" -- проверить правильность ввода данных

		echo "<br>\n";
		if ($login && (strlen($login)<=20) && ((ord($login)>=ord("a")) && (ord($login)<=ord("z"))) ||
			((ord($login)>=ord("A")) && (ord($login)<=ord("Z")))) {
			//проверить существование пользователя с таким же логином
			$q = mysql_query("SELECT * FROM Users WHERE Login=\"".$login."\"") or die (mysql_error);
			$r = mysql_fetch_row($q);
			if ($r && !$edit) {
				if ($order_step == 1) { //была совершена ошибка при регистрации на этапу оформления заказа
					echo "<center><font class=cat color=red><b><u>Shop entry</u></b></font><br><br>\n";
		
					echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";

				};
				echo "<center><font color=red><b>This login is already in use, please try another.</b></font</center><br>\n";
				DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
				exit;
			};
		}
		else {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u>Enter  the shop</u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";
			};
			echo "<center><font color=red><b>Wrong <u>login</u></b> (use latin letters)</font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//поле пароля пустое либо больше 15 символов
		if (!$pw || strlen($pw)>15) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u>Shop entry</u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";
			};
			echo "<center><font color=red><b>incorrect <u>password</u> field! </b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//пароль повторен верно?
		if (strcmp($pw,$_pw)) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";

			};
			echo "<center><font color=red><b>Incorrect <u>retyped </u>password!   </b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//email?
		if (!$email) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";

			};
			echo "<center><font color=red><b>Incorrect <u>e-mail</u> address!</b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//имя?
		if (!$fullname) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";

			};
			echo "<center><font color=red><b>Incorrect <u>name!</u></b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//страна?
		if (!isset($country) || !$country) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";

			};
			echo "<center><font color=red><b>Field <u>country</u> is empty!</b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//город?
		if (!$city) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";
			};
			echo "<center><font color=red><b>Incorrect <u>city!</u></b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//адрес?
		if (!$address) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";
			};
			echo "<center><font color=red><b>Incorrect <u>address!</u></b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//страна?
		if (!$country) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";
			};
			echo "<center><font color=red><b>Incorrect <u>country!</u></b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};

		//телефон?
		if (!$phone) {
			if ($order_step == 1) { //была совершена ошибка при регистрации на этапe оформления заказа
				echo "<center><font class=cat color=red><b><u></u></b></font><br><br>\n";
				echo "For continuing ordering You have to <u>register</u>.<br>If you've already done it - use the form on the right with your login and password.</center><br><br>\n";
			};
			echo "<center><font color=red><b>Incorrect <u>phone number!</u></b></font></center><br>\n";
			DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,1,"");
			exit;
		};


		//дошли до сюда => поля введены верно (по крайней мере не пусты!)

		if (!$p) { //добавить нового пользователя

			//добавить пользователя
			$s = "INSERT INTO Users (Login, Password, Email, Fullname, Country, City, Address, Phone) VALUES ";
			$s = $s."('".$login."','".$pw."','".$email."','".$fullname."','".$country."','".$city."','".$address."','".$phone."');";
			$q = mysql_query($s) or die (mysql_error());

			//показать сообщение об успешной регистрации
			echo "<center><b>Congratulations! You have successfully registered!<br>Message with your information sent to your e-mail address.</b></center>\n";

			$s = "Hello!\n\n";
			$s = $s."You have successfully registered in $shopname!\n\n";
			$s = $s."Your registration data:\n\n";
			$s = $s."Login: ".$login."\n";
			$s = $s."Password: ".$pw."\n\n";
			$s = $s."Name: ".$fullname."\n";
			$s = $s."Address: ".$country.", ".$city.", ".$address."\n";
			if ($phone) $s = $s."Phone number: ".$phone."\n\n";
			$s = $s."We hope you'll enjoy our service, $shopname.\n$shopurl";
			$q = mysql_query("SELECT Email FROM Users WHERE Login='MANAGER'");
			$row = mysql_fetch_row($q);

			mail($email,"Registration in $shopname", $s, "From: webmaster@$shopname<$row[0]>;\nContent-Type: text/plain; charset=\"windows-1251\"");

			if ($order_step == 1) { //показать продолжение оформления -- последний этап

				//создать сеанс для пользователя
				$log = $login;
				$pass = stripslashes($pw);
				session_register("log");
				session_register("pass");

				//пересетить корзину из переменных сеанса в БД
				for ($i=0; $i<count($gids); $i++)
					if ($gids[$i]) $q = mysql_query("INSERT INTO Carts Values ('$log',$gids[$i],$counts[$i])");

				session_unregister("gids");
				session_unregister("counts");

				$order_step = 2;
//			showFinalStep($log);
			print "<script language='javascript'>window.location=\"order.php\"</script>";
				exit;
			}
			else {
				echo "</td>\n</tr>\n</table>\n";

				showNavigation($shopname);

				echo "</body>\n</html>";
				exit;
			};
		}
		else { //изменить настройки уже существующего пользователя

			$s = "UPDATE Users SET Login='$login', Password='$pw', Email='$email', Fullname='$fullname', Country='$country',";
			$s .= " City='$city', Address='$address', Phone='$phone' WHERE Login='$log'";
			$q = mysql_query($s) or die (mysql_error());

			$pass = $pw;
			session_register("pass");
			if ($go_2_order){				
			print "<script language='javascript'>window.location=\"order.php\"</script>";
			exit;
			}
				

			//показать сообщение об успешной регистрации
			echo "<center><b>Information successfully updated!</b></center>\n";

			
			echo "</td>\n</tr>\n</table>\n";

			showNavigation($shopname);

			echo "</body>\n</html>";
			exit;
		};

	};

	if (isset($order) || $order_step>0) { //показать продолжение оформления
	 switch ($order_step) {

	  case 0: //перeходим на второй этап входа в магазин -- для этого надо проверить корзину на наличие товаров

		//проверить наличие товаров в корзине, т.е. посчитать их ($k):
		$k=0;
		if (!isset($log)) {
			if (isset($gids))
			  for ($i=0; $i<count($gids); $i++)
				if ($gids[$i]) $k++;
		}
		else {
			$q = mysql_query("SELECT * FROM Carts WHERE User='".$log."'") or die (mysql_error());
			while ($row = mysql_fetch_row($q)) $k++;
		};

		if (!isset($log)) { //показывать этап входа в магазин, если корзина не пуста

			if ($k) { //корзина не пуста -- переходим на след. этап (входа в магазин)
				$order_step = 1;
				session_register("order_step");
			} //сказать, что корзина пуста!
			else {
				$order_step = 0;
				session_register("order_step");
				echo "<center><font color=>Your basket is empty !</font></center></td></tr></table>\n";

				showNavigation($shopname);
				exit;
			};
		}
		else { //следующий этап -- выбор оплаты + комментарии по доставке
			$order_step=2;
			session_register("order_step");
		};
	   break;

	   case 1: //вход в систему
		session_register("order_step");
	   break;

	   case 2: //завершение (оплата + комментарии)
		session_register("order_step");
	   break;

	  };

	 };

	if (!isset($log)) $log="";
	if (!isset($newUser)) //регистрация нового пользователя
		DrawForm($login,$pw,$email,$fullname,$country,$city,$address,$phone,$edit,$order_step,0,$log);
	else
		DrawForm($login,"",$email,$fullname,$country,$city,$address,$phone,$edit,0,0,$log);

?>