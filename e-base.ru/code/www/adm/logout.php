<?
/*
*	e-Base ADMIN LOGOUT PAGE / logout.php. by rabbit
*	last updated 28 апреля 2004 г. 17:11:32
*	Выход из админовской страницы.
*
*/
define('WE_ARE_HERE',true);
require('../includes/head.php');
require('../includes/cfg.php');
require('../includes/functions.php');

if( isset($_GET['u_sid'])  ){
	$u_sid = $_GET['u_sid'];
	$u_sid = htmlspecialchars(substr($u_sid,0,32));
	$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
	mysql_select_db("$db_name") OR die (mysql_error());
	unset($host);
	unset($user);
	unset($password);
	$rez = mysql_query("SELECT u_sid FROM users_sessions WHERE u_sid = '$u_sid' AND time_logout = 0 AND (time_login+12000)>unix_timestamp()") OR die(mysql_error());
	if(!mysql_num_rows($rez)) die("нету такого sid'a");
	else{
		$rez = mysql_query("UPDATE users_sessions SET time_logout = unix_timestamp() WHERE u_sid = '$u_sid'") OR die(mysql_error());
		print("You logged out!");
	}

}
else print("Ты чего сюда пришел?");


?>