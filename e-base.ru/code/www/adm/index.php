<?
/*
*	e-Base ADMIN LOGIN PAGE / index.php. by rabbit
*	last updated 28 апреля 2004 г. 17:11:32
*	авторизация.
*
*/

define('WE_ARE_HERE',true);
require('../includes/head.php');
require('../includes/cfg.php');
require('../includes/functions.php');

global $db;
$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());

if(isset($_GET['u_sid']) || isset($_POST['u_sid']) ){
	if(!$_GET['u_sid']) $u_sid = $_POST['u_sid'];
	else $u_sid = $_GET['u_sid'];
	$u_sid = htmlspecialchars(substr($u_sid,0,32));
	$rez = mysql_query("SELECT u_sid FROM users_sessions WHERE u_sid = '$u_sid' AND time_logout = 0 AND (time_login+12000)>unix_timestamp()");
	if(!mysql_num_rows($rez)) die("Ваша сессия анулирована!");
	else print("Вы уже зашли, вам <a href='adm.php?u_sid=$u_sid'>сюда</a>");
}

elseif(isset ($_POST['login']) && isset($_POST['pwd']) ){
	

	$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
	mysql_select_db("$db_name") OR die (mysql_error());
	$login_passed = 0;
	$login = htmlspecialchars(substr($_POST['login'],0,10));
	$pwd = htmlspecialchars(substr($_POST['pwd'],0,10));
	// проверка совпадает ли логин, для того чтобы не подобрали passw
	$query = mysql_query("SELECT u_id FROM users WHERE login = '$login'") OR die();
	
	if( mysql_num_rows($query) ) $login_passed = 1;
	else {
		draw_form();	
	}
	
	$query = mysql_query("SELECT u_id FROM users WHERE login = '$login' AND pwd = '$pwd' AND attempts<'5'") OR die();
	if(!mysql_num_rows($query)){
		$query = mysql_query("UPDATE users SET attempts=attempts+1") OR die();
		draw_form();
	}else{
	$row = mysql_fetch_row($query);
	$u_id = $row[0];
	$u_sid = md5(uniqid(rand(), true));
	$u_ip = encode_ip(check_user_ip());
	
	$query = mysql_query("INSERT INTO users_sessions (u_sid,u_id,u_ip,time_login) values ('$u_sid','$u_id','$u_ip',unix_timestamp())") OR die(mysql_error()) ;
	print("<div align='center'>logined<br><a href='adm.php?u_sid=$u_sid'> move to admin page</a></div>");

	}

if(!$db) mysql_close($db);
exit();
}else draw_form();






function	draw_form(){
?>
<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="index.php">
  <p> login 
    <input type="text" name="login">
    <br>
    pwd 
    <input type="password" name="pwd">
  </p>
  <p>
    <input type="submit" name="Submit" value="Submit">
  </p>
  <p>&nbsp; </p>
</form>

<?
exit();

}



?>