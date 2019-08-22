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




	if (!isset($cid))	$cid = 0;    



	create_path($cid); // path[] - path to selected category.
						//also we get arrays: categories[cid]=parent,cat_names[cid]=cid_name
	

	foreach($categories as $key => $val){  //check categories which are children :) of $cid
		if($val==$cid) {					//to show it in navigation.
				$cid_=$key;
				$name=$cat_names[$key];
				eval("\$navigation_left .= \"".$tpl->get("main_navigation")."\";"); 
		}
	}




	// creating path links to selected category
	for($i = 1; $i < count($path); $i++){//пройти по всему пути.
		$element_of_path = $path[$i];
		//выводим элемент пути. 
		$path_2_cat .= "<a href=$PHP_SELF?cid=$element_of_path class='root_text'> $cat_names[$element_of_path]</a>/";
	}

//-----------------------------
//расчитываем $path_after
//----------------------------
	$path_after[0] = $cid;// первый элемет пути вниз сама категория
	$write_offset = 1;
	$read_offset = 0; 

//посчитаем путь после $path_after
//для того чтобы показать товары, которые находяться в нижележащих категориях
for($z=$read_offset;$z<count($path_after);$z++){
		for($i=1;$i<count($categories)+1;$i++){	
			if($categories[$i] == $path_after[$z]){
				$path_after[$write_offset] = $i;
				$write_offset++;
			
			}

		}

}
;



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
	$category = "<a href='$PHP_SELF?cid=$n'>$cat_names[$n]</a>";
	$price = $db_array['price'];
	eval("\$index .= \"".$tpl->get("main_goods")."\";"); 
}


for ($i=1; $i<count($path);$i++) {
	$title .= " ".$cat_names[$path[$i]]." /"; //generation title
	
}


 

eval("\$header = \"".$tpl->get("header")."\";"); //Parsing main header.
eval("\$footer = \"".$tpl->get("footer")."\";"); //Parsing main footer.
eval("print \"".$tpl->get("main_index")."\";"); // Parsing and displaying main template.









?>
