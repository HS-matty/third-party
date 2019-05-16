<?
if(!defined('WE_ARE_HERE'))  die();	
if(isset($_GET['u_sid']) || isset($_POST['u_sid']) ){
	if(!$_GET['u_sid']) $u_sid = $_POST['u_sid'];
	else $u_sid = $_GET['u_sid'];
	$u_sid = htmlspecialchars(substr($u_sid,0,32));
	$rez = mysql_query("SELECT u_sid FROM users_sessions WHERE u_sid = '$u_sid' AND time_logout = 0 AND (time_login+12000)>unix_timestamp()") OR die(mysql_error());
	if(!mysql_num_rows($rez)) die("вы хамло");
}
else{
die("вы хамло");
}
?>