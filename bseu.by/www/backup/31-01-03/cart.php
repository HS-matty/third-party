<?
session_start();
define('IN_SHOP', true);


include('functions.php');
include('./cfg/conf.inc');
include('var.php');
require_once "class.Template.php";




$tpl = new Template("./tpl2");
$db = mysql_connect() or die (mysql_error());
mysql_select_db("$db_name") or die (mysql_error());




$title .= " shopping cart /";


//check if user modifies goods count
if (isset($rc) && $rc==1){
	$vars = get_defined_vars();
	foreach ($vars as $key => $val)
	if (strstr($key, "count_")) {
			
			$cart[str_replace ("count_","",$key)]=substr($val, 0, 2);
	}
}                    

// delete items with goods_count=0
if (isset($cart)){
		foreach ($cart as $key => $val){
			if ($val==0) {
				unset($cart[$key]);
			}
		}
}

	

//check if $cart still initialised  :)
if(isset($cart) && ($cart)){ 
	
	$gids="";
	$i = 0;
	foreach ($cart as $key => $val){
		if ($i==0) {
			$gids = " GID=$key ";
			$i = 1;
		}
		else $gids .= " OR GID=$key ";

	}
	
	$sql = "SELECT * from goods WHERE $gids";   //достаем товары по данным из корзины.
//	print "$sql<br>";
	$query = mysql_query($sql) or die(mysql_error());


	$row_num = mysql_num_rows($query) or die(mysql_error());
	$nb = 1;
	$name = "";
	$price = "";
	$total_cost="0";
	for($i=0;$i<$row_num;$i++){
		$db_array = mysql_fetch_array($query);
		$name = $db_array['name'];

		$gid = $db_array['GID'];

		
		$number = $cart[$gid];
			

		if ($number > 0) {
				$price = (($db_array['price'])*$number);	
				$total_cost += $price;
				eval("\$goods_in_cart .= \"".$tpl->get("goods_in_cart")."\";"); //get head.tpl
				$nb++;
			}else{
				unset($cart[$gid]);

			}
	}
	$total_cost += $shipping;
	if(count($cart)) $cart_status=cart_status($cart);
	else $cart_status="empty";

	eval("\$cart_head = \"".$tpl->get("cart_head")."\";"); //get header of shopping cart
	eval("\$cart_foot = \"".$tpl->get("cart_foot")."\";"); //get footer of shopping cart

}else{
	if(isset($cart) && ($cart)) $cart_status=cart_status($cart);
	else $cart_status="empty";

	$goods_in_cart="<tr><td><div align=center style=\"font-size:14px;color:red\"><br><br> Your shopping cart is empty</div></td></tr>";
	$cart_head="";
	$cart_foot="";

}






eval("\$header = \"".$tpl->get("header")."\";"); //Parse main header.
eval("\$footer = \"".$tpl->get("footer")."\";"); //Parse main footer.
eval("print \"".$tpl->get("cart")."\";"); // display main template




?>
















