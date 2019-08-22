<?
session_start();
define('IN_SHOP', true);

include ("../functions.php");
include('../var.php');
include('../cfg/conf.inc');
require_once "../class.Template.php";
$tpl = new Template("./tpl");
$msg="";

if(isset($login) && !(empty($login)) && isset($pass) && !(empty($pass)) ){

	$db = mysql_connect() or die (mysql_error());		//if we have  login and password,
	mysql_select_db("$db_name") or die (mysql_error()); //we compare it with
														// database data
	//quering db
	$q = mysql_query("SELECT * from users WHERE login='$login' AND pass='$pass'") or die (mysql_error());
	if ( mysql_num_rows($q) ){	//if we have such login and password...
		session_register("login");
	}else  $msg = "bad login or password!";
				
	
	
}






if(!session_is_registered("login")) {
eval("print \"".$tpl->get("index")."\";"); // Parsing and displaying login template.
}

else print "you're inside!";
	






?>