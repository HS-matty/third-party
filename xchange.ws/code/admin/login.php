<?

define('WE_ARE_HERE',true);
include('../includes/template.php');
include('../includes/head.php');
include('../includes/functions.php');
include('../includes/cfg.php');

if(isset ($_POST['login']) && isset($_POST['pwd']) ){
	
	global $db;
	$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
	mysql_select_db("$db_name") OR die (mysql_error());
	$login_passed = 0;
	$login = htmlspecialchars(substr($_POST['login'],0,10));
	$pwd = htmlspecialchars(substr($_POST['pwd'],0,10));
	// �������� ��������� �� �����, ��� ���� ����� �� ��������� passw
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
	print("<div align='center'>logined<br><a href='index.php?u_sid=$u_sid'> move to admin page</a></div>");

	}

mysql_close($db);
exit();
}else draw_form();






function	draw_form(){
?>
<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
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