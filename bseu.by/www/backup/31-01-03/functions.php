<?





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


function create_path($cid){

	global $path;
	global $cat_names;
	global $categories;

	$path = array();// массив, где хранится путь до $cid, path[$cid]=parent
	$cat_names = array();//массив, где хранятся имена категорий,$cat_names[$cid]=name

	
	$q = mysql_query("SELECT * from categories ORDER BY CID") or die(mysql_error()) ;
	$row_num = mysql_num_rows($q) ;
	for ($i=0; $i<$row_num; $i++){
		$db_array=mysql_fetch_array($q);
		$categories[$db_array['CID']] = $db_array['Parent'];
		$cat_names[$db_array['CID']] = $db_array['Name'];
		if($db_array['Parent'] == $cid){
										//смотрим на $parent, показывать ли эту категорию.
										//если это то, что надо, добавляем эту категорию в navigation



		}
	}

if(!isset($categories[$cid])) $cid = 0;	
	$path[0] = $cid;//первый элемент пути до $cid, cам $cid
	$i = 1;//учитывем это в расчете дальнейшего пути

if ($cid != 0){
	$cid_ = $cid;
	while($categories[$cid_]) //есть ли еще категории ?
		{
		$path[$i] = $categories[$cid_];
		$i++;	
		$cid_ = $categories[$cid_];
		}
	$path[count($path)] = 0;//делаем последним элементом 0, т.е. root
	$path = array_reverse($path);//переворачиваем

	
}	
	
	
}