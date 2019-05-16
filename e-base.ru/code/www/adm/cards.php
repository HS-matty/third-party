<?
/*
*	e-Base MAIN card-service/ cards.php.
*	last updated 28 апреля 2004 г. 17:11:32
*	Список транзакций, статистика.
*
*/

define('WE_ARE_HERE',true);
require('../includes/head.php');
require('../includes/cfg.php');
require('../includes/functions.php');

global $db;
$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());
unset($host);
unset($user);
unset($password);

require("hd.php"); //проверим права на просмотр данной страницы.

//получим список доступных карточек





if(isset($_POST['id']) && isset($_POST['data']) && !empty($_POST['data']) ){



$id = sprintf("%d",$_POST['id']);
$data = htmlspecialchars(substr($_POST['data'],0,75));

$sql = "INSERT INTO pin_list (PinT_id,Pin_content,used) values('$id','$data',0)";
$rez = mysql_query($sql) OR die(mysql_error());
form($u_sid,'ADDED');
unset($_POST['id']);
unset($_POST['data']);

}
else form($u_sid);








function form($u_sid,$added=''){
	$sql  = "SELECT PinT_id, PinT_des,PinT_nominal FROM pin_types";
	$rez = mysql_query($sql) OR die(mysql_error());
	?>
	<html>
	<head>

	<title>add card</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	</head>
	<body bgcolor="#FFFFFF" text="#000000">
	<br><br><br>
	<div align='center'><font color='red'><?echo $added?></font><form name="form1" method="post" action="cards.php">
	<input type='hidden' name='u_sid' value="<? echo $u_sid ?>">
	<select name="id" size="1">
	<?
	
	while($arr = mysql_fetch_array($rez)){
	    print("<option value=\"$arr[PinT_id]\">$arr[PinT_des]//номинал $arr[PinT_nominal]</option>");
		
	}

	?>
	  </select>
		<br><input type="text" name="data" size='75'>
<br><input type="submit" name="Submit" value="Submit">

	  </div>
	</form>
	</body>
	</html>
<?

}


?>
