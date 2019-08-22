<?
$log='manager';
session_start();
session_register("log");

include('functions.php');
include('./cfg/conf.inc');
require_once "class.Template.php";
$tpl = new Template("./tpl");
$tpl->load("main"); // шаблон осново
$tpl->load("navigation");


$db_host="localhost";
$db_user="";
$db_pw="";
$db_name='my_shop';

$db=mysql_connect() or die (mysql_error());
mysql_select_db("$db_name") or die (mysql_error());

$up_left="ziz iz left_shit";
$up_right="ziz iz right_shit";
$navigation_left="";
$down="down_shit";
$shop_links="4";
;
	if (isset($cid)){    //смотрим, есть ли обращение к поддиректории
		draw_path($cid);		
		$query=mysql_query("SELECT * FROM categories where parent=$cid") or die(mysql_error());
		$row_num=mysql_num_rows($query);
		for ($i=0; $i<$row_num;$i++){
		$db_array=mysql_fetch_array($query) or die(mysql_error());
		$name=$db_array['Name'];
		$cid_=$db_array['CID'];
		eval("\$navigation_left .= \"".$tpl->get("navigation")."\";"); 
}

		


	}else{ //если нет, то выводим основные разделы, где $parent=0.
//$query=mysql_query("SELECT * FROM categories WHERE Parent=0") or die(mysql_error()) ;
//$row_num=mysql_num_rows($query);
//for ($i=0; $i<$row_num;$i++){
//		$db_array=mysql_fetch_array($query) or die(mysql_error());
//		$name=$db_array['Name'];
//		$cid_=$db_array['CID'];
//		eval("\$navigation_left .= \"".$tpl->get("navigation")."\";"); 
}
	}


eval("print \"".$tpl->get("main")."\";");


function draw_path($cid){

//достаем список категорий из базы, где $categories[$cid]=$parent
$q=mysql_query("SELECT * from categories ORDER BY NAMES");
$path=array();
$cat_names=array();
while ($row=mysql_fetch_array($q)){
	$categories[$row['cid']]=$row['parent'];
	$cat_names[$row['cid']]=$row['name'];
	if($row['parent']=$cid)
		{
					$name=$db_array['Name'];
					$cid_=$db_array['CID'];
					eval("\$navigation_left .= \"".$tpl->get("navigation")."\";"); 
		}
	}

// if ($categories[$cid]){
	$path[0]=$cid;
	$i=1;
	while($categories[$cid])
		{
		$path[$i++]=$categories[$cid];
		$cid=$categories[$cid];
		}
$path[count($path)]=0;
$path = array_reverse($path);
//	} //end of while

	for($i=1;$i<count($path);$i++){
	$zz=$path[$i];
	print "$cat_names[$zz]=>";
}


}//end of function draw_path


function error_msg($msg){

}





?>
