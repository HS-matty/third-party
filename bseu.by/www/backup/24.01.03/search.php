<?

session_start();
define('IN_SHOP', true);

include('var.php');
include('functions.php');
include('./cfg/conf.inc');
require_once "class.Template.php";

$tpl = new Template("./tpl2");
$title .= " Search /";



$db = mysql_connect() or die (mysql_error());
mysql_select_db("$db_name") or die (mysql_error());

if(isset($cart)) $cart_status=cart_status($cart);  //значение корзины в заголовке.
else $cart_status="empty";


if(isset($search_string)){

	substr($search_string, 0, 100);
	$search_string = trim(str_replace("'","",stripslashes($search_string)));
	$search = explode(" ",$search_string);
	$sql = "SELECT * FROM goods 	WHERE name LIKE '%".$search[0]."%'";
	for ($i=1; $i<count($search); $i++){
		$sql .= "OR name LIKE '%".$search[$i]."%' ";
		}


	$result = mysql_query("$sql");
	if(!$result) die(mysql_error());
		
	$search_result="";	
	$num_rows = mysql_num_rows($result);
	for($i=0;$i<$num_rows;$i++){
		$search_array = mysql_fetch_array($result);
		$gname = $search_array['name'];
		$price = $search_array['price'];		
		eval("\$search_result .= \"".$tpl->get("search_body")."\";"); //Parsing search_body header.
	}

}else {
	$search_result="";
	$num_rows="";
}






							





eval("\$header = \"".$tpl->get("header")."\";"); //Parsing main header.
eval("\$footer = \"".$tpl->get("footer")."\";"); //Parsing main footer.
eval("print \"".$tpl->get("search")."\";"); // Parsing and displaying main template.






?>

