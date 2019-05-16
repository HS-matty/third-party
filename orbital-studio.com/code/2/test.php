<?
session_start();

if (!session_is_registered("login")){
	print "<a href=login.php>please login!</a>";
	exit;
}

?>




