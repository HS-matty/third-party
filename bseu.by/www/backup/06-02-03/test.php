<?

session_start();

$db_name='4vanya';
$db = mysql_connect() or die (mysql_error());
mysql_select_db("$db_name") or die (mysql_error());


if (!session_is_registered("logined")  ){

	if(isset($login) && ($login) && isset($log) && ($log) && isset($pass) && ($pass)){


	substr($log, 0, 20);
	substr($pass, 0, 20);
	$log = trim(str_replace("'","",stripslashes($log)));
	$pass = trim(str_replace("'","",stripslashes($pass)));

		$q = mysql_query("SELECT * FROM users WHERE name='$log' AND password='$pass'") or die(mysql_error());
		if(!mysql_num_rows($q)) {
			print "wrong login or password!, try again!<br>";
			sh_html($PHP_SELF);
			exit;
		}else {
			print "ok! logined!";
			$db_array=mysql_fetch_array($q);
			$logined=1;
			$name_reg=$db_array["name"];			
			session_register("name_reg");
			session_register("logined");
			print "You logined as <b>$db_array[name]</b><br>";
			print "your information is <b>$db_array[info]</b><br>";
			print "thnx";

			exit;
		}
	}

	else sh_html($PHP_SELF);
}else print "you logined!";







function sh_html($PHP_SELF){

	print "<form name='check password' method='post' action=\"$PHP_SELF?login=1\">";
	?>
	Enter login: <input type='text' name='log' size=20 maxlength='40'>
	 <br>  Enter password: <input type='password' name='pass' size='20' maxlength='40'>
	 <br><input type='submit' name='Submit' value='Submit'></form>
	<?
	}

?>