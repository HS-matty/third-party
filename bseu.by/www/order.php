<?

session_start();
define('IN_SHOP', true);

include('var.php');
include('functions.php');
include('./cfg/conf.inc');
require_once "class.Template.php";

$tpl = new Template("./tpl2");




$db = mysql_connect() or die (mysql_error());
mysql_select_db("$db_name") or die (mysql_error());



if(isset($cart)) $cart_status = cart_status($cart);  //значение корзины в заголовке.
else $cart_status = "empty";


if(isset($login) && $login==1 && isset($password_entered) && isset($login_entered)){
	$query = mysql_query("SELECT * from users where pass='$password_entered' AND login='$login_entered'" );
	if(mysql_num_rows($query)==1) $body="logined";
	else eval("\$body = \"".$tpl->get("order_body")."\";"); 
}
else {
	eval("\$body = \"".$tpl->get("order_body")."\";"); 
}
	
	







eval("\$header = \"".$tpl->get("header")."\";"); //Parsing main header.
eval("\$footer = \"".$tpl->get("footer")."\";"); //Parsing main footer.
eval("print \"".$tpl->get("order")."\";"); // Parsing and displaying main order template.
?>