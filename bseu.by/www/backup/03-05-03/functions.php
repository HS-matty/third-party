<?

if (!defined('IN_SHOP'))	die();




function connectdb(){
	$db=mysql_connect() or die (mysql_error());
	$db_name='my_shop';
	mysql_select_db("$db_name") or die (mysql_error());
}

function cart_status($cart){
		$z=0;
		foreach ($cart as $key => $val) 		$z+=$val;
		if (!$z) return 'empty';
		elseif ($z==1) return "$z item";
		else return "$z items";
	}




function check_log()
{

	if ((session_is_registered("ses_id")) && (session_is_registered("login")) && (session_is_registered("user_rights"))) 																				return 'true';

	else return 'false';


}

function create_path($cid){
	$path = array();
	global $path; // массив, где хранится путь до $cid, path[$cid]=pare
	global $path_after;
	$parents=array();
	$categories=array();


	$q = mysql_query("SELECT CID, Parent from categories ORDER BY CID") or die(mysql_error()) ;
	$row_num = mysql_num_rows($q) ;


// Создаем два массива categories[$i] = CID
//					   parents[$i] = parents CID
// 
	

	for ($i=0; $i<$row_num; $i++){
		$db_array = mysql_fetch_array($q);
		$categories[$i] = $db_array['CID'];
		$parents[$i] = $db_array['Parent'];

	}




// Смотрим, какой индекс i имеет $cid в обоих массивах (он одинаковый)
//
$cid_=$cid;

$i_cid=0;

for ($i=0;$i<count($categories);$i++){
	if ($categories[$i]==$cid_) {
		$i_cid=$i;
		$i_cid_a=$i;
	}
}

	
	

$path[0]=$categories[$i_cid]; //первые элемемнты пути сама категория и ее родитель.
$path[1]=$parents[$i_cid];

	

	
while ($parents[$i_cid]!=0){

	for ($i=0;$i<count($categories);$i++){
			if($categories[$i]==$parents[$i_cid]) {
				array_push ($path,$parents[$i]);
				$i_cid=$i;
			}
	}
}

	
$path = array_reverse($path);//переворачиваем


//Находим все категории, которые лежат ниже $cid, для того чтобы выводить товары в
// категориях без товаров.
// cid'ы категорий записываются в массив path_after[]
$path_after[0]=$cid;
$cid_=$cid;

	for ($i=1;$i<count($categories);$i++){
		for ($j=0;$j<count($parents);$j++){
			if ($parents[$j]==$cid_) array_push ($path_after,$categories[$j]);
		}
		if (isset($path_after[$i])) $cid_=$path_after[$i];
	}




}

?>
