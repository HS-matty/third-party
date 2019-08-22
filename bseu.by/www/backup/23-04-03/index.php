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










//--------------------------------------------------------------------------------------//
//---  GREATING ROOT--------------------------------------------------------------------//
//-------------------------------------------------------------------------------------//
//$cid=1;


// Check if we want to add good in shopping cart

	if (isset($add) && $add==1 && isset($gid)){ 
		if (!session_is_registered("cart")){  //check if shopping cart wasnt initialised.
			$cart = array();
			session_register("cart");

		}

		if ($query = mysql_query("SELECT * FROM goods WHERE GID=$gid")){


//check if we already have such good in the shopping cart
// if not, add one.
			if (!isset($cart[$gid]) || $cart[$gid]==0) {
				$cart[$gid] = 1; 
			
			}else $cart[$gid]++; // 
		
		}	

}


if(isset($cart)) $cart_status = cart_status($cart);  //значение корзины в заголовке.
else $cart_status = "empty";


if(isset($sort)){
	
	if($sort=='by_name') {
		$sort_type=' ORDER BY name asc';
		$sort_="<option value=\"by_name\" selected>name</option><option value=\"by_price\">price</option>";
	}
	if($sort=='by_price')	{
		$sort_type=' ORDER BY price asc';
		$sort_="<option value=\"by_name\" >name</option><option value=\"by_price\" selected>price</option>";
	}
	else {
			$sort_type=' ORDER BY name desc';
			$sort_="<option value=\"by_name\" selected>name</option><option value=\"by_price\">price</option>";
	}
}

else 	{
	$sort_type = ' ORDER BY name asc';
	$sort_ = "<option value=\"by_name\" selected>name</option><option value=\"by_price\">price</option>";
}


//$cid=11;

if (!isset($cid))	$cid = 0;    



if ($cid) create_path($cid); // path[] - path to selected category.
						//also we get arrays: categories[cid]=parent,cat_names[cid]=cid_name
else $path[0]  = 0;

	

//выводим навигацию

$q = mysql_query ("SELECT cid,name FROM categories WHERE parent=$cid") or die(mysql_error());
$num_rows = mysql_num_rows ($q);

for ($i=0;$i<$num_rows;$i++){
	$row = mysql_fetch_row($q);
	$cid_ = $row[0];
	$name = $row[1];
	eval("\$navigation_left .= \"".$tpl->get("main_navigation")."\";"); 
}


//если есть $cid, то строим путь до $cid	
if($cid) {

	$q_add = "SELECT CID ,name  FROM categories WHERE ";
	for($i=0;$i<count($path);$i++){
		if ($i == 0) $q_add .= "CID=$path[$i]";
		else $q_add .= " OR CID=$path[$i] ";
	}

//print "<br>$q_add";

	$q = mysql_query ("$q_add") or die(mysql_error()); // Делаем запрос для вычисления пути до категории

	$num_rows = mysql_num_rows($q);
	// print "<br> numrows is $num_rows<br>";

	// creating path links to selected category
	$categories_names = array(); //два массива - с именами
	$categories_cids = array();// и CID'ами

	for	($i = 0; $i < $num_rows; $i++){//пройти по всему пути.
	//	print "<br>i = $i<br>";
		$row  = mysql_fetch_row($q);
		$categories_cids[$i] = $row[0];
		$categories_names[$i] = $row[1]; //заполняем массивы
	}

	for($i=1;$i<count($path);$i++){  //переводим массив path[] в вид ссылок..

		$cid_=$path[$i];
			for($j=0;$j<count($categories_cids);$j++){
				if($categories_cids[$j] == $cid_) {
				$name_=$categories_names[$j];
				$path_2_cat .= "<a href=$PHP_SELF?cid=$cid_ class='root_text'> $name_</a>/";
			}

		}

	}

}



if (isset($path_after)){
	$s="SELECT * FROM goods  ";
	$s_=0;
	for($i=0;$i<count($path_after);$i++){ //соображаем запрос.
		if ($s_) $s.="OR ";
		else
			{ $s_=1;
			  $s.=" WHERE ";
	
	
			}
		$s.="CID=$path_after[$i] ";
	}
}
else
	{ 
		$s="SELECT * FROM goods  ";
	}




//делаем запрос на товары, которые лежат ниже по дереву.
//print "$s<br>";
$query = mysql_query($s." $sort_type") or die(mysql_error()) ;
$row_num = mysql_num_rows($query);	

if(!$row_num)  	eval("\$index = \"".$tpl->get("main_no_goods")."\";"); 

for($i=0;$i<$row_num;$i++){
	$db_array = mysql_fetch_array($query);
	$gname = $db_array['name'];
	$gid = $db_array['GID'];
	if ($cid != 0) $cid_ = $path_after[0];
	else $cid_ = 0;
	$gdescription = $db_array['description'];
	$n = $db_array['CID'];
//	$category = "<a href='$PHP_SELF?cid=$n'>$cat_names[$n]</a>";
	$price = $db_array['price'];
	eval("\$index .= \"".$tpl->get("main_goods")."\";"); 
}


for ($i=1; $i<count($path);$i++) {
//	$title .= " ".$cat_names[$path[$i]]." /"; //generation title
	
}


 

eval("\$header = \"".$tpl->get("header")."\";"); //Parsing main header.
eval("\$footer = \"".$tpl->get("footer")."\";"); //Parsing main footer.
eval("print \"".$tpl->get("main_index")."\";"); // Parsing and displaying main template.









?>
