<?

global $categories;
$log='manager';
session_start();
session_register("log");

include('functions.php');
include('./cfg/conf.inc');
require_once "class.Template.php";
$tpl = new Template("./tpl");
//$tpl->load("main,navigation,goods"); // 


$db=mysql_connect() or die (mysql_error());
mysql_select_db("$db_name") or die (mysql_error());

$up_left="<a href='$PHP_SELF' class='root_text'>Root/</a>";
$up_right="ziz iz right_shit";
$navigation_left="";
$down="";
$goods="";
//$category="test";
$price=0;


//--------------------------------------------------------------------------------------//
//---  GREATING ROOT--------------------------------------------------------------------//
//-------------------------------------------------------------------------------------//
//$cid=1;

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
	$sort_type=' ORDER BY name asc';
	$sort_="<option value=\"by_name\" selected>name</option><option value=\"by_price\">price</option>";
}




	if (!isset($cid)) $cid=0;    //�������, ���� �� ��������� � �������������

// ���� ����, ��  ������ ������ �� ���, � ����� ����������� ��� � ����.
$q=mysql_query("SELECT * from categories ORDER BY CID") or die(mysql_error()) ;
$path=array();// ������, ��� �������� ���� �� $cid, path[$cid]=parent
$cat_names=array();//������, ��� �������� ����� ���������,$cat_names[$cid]=name
$row_num=mysql_num_rows($q);


	for ($i=0;$i<$row_num;$i++){
	$db_array=mysql_fetch_array($q);
	$categories[$db_array['CID']]=$db_array['Parent'];
	$cat_names[$db_array['CID']]=$db_array['Name'];
	if($db_array['Parent']==$cid)//������� �� $parent, ���������� �� ��� ���������.
		{//���� ��� ��, ��� ����, ��������� ��� ��������� � navigation

					$name=$db_array['Name'];
					$cid_=$db_array['CID'];
					eval("\$navigation_left .= \"".$tpl->get("navigation")."\";"); 

		}
	}


if(!isset($categories[$cid])) $cid=0;	
	$path[0]=$cid;//������ ������� ���� �� $cid, c�� $cid
	$i=1;//�������� ��� � ������� ����������� ����

if ($cid!=0){
	$cid_=$cid;
	while($categories[$cid_]) //���� �� ��� ��������� ?
		{
		$path[$i++]=$categories[$cid_];
		$cid_=$categories[$cid_];
		}
	$path[count($path)]=0;//������ ��������� ��������� 0, �.�. root
	$path = array_reverse($path);//��������������

}

	for($i=1;$i<count($path);$i++){//������ �� ����� ����.
	$zz=$path[$i];
	$up_left.="<a href=$PHP_SELF?cid=$zz class='root_text'> $cat_names[$zz]</a>/";//������� ������� ����. 
	}

//-----------------------------
//����������� $path_after
//----------------------------
	$path_after[0]=$cid;// ������ ������ ���� ���� ���� ���������
	$write_offset=1;
//print "wo=$write_offset<br>";
	$read_offset=0; // 
for($z=$read_offset;$z<count($path_after);$z++){
		for($i=1;$i<count($categories)+1;$i++){	//��������� ���� ����� $path_after
			if($categories[$i]==$path_after[$z]){
			$path_after[$write_offset]=$i;
			$write_offset++;
			
			}

		}

}
//print "ro=$read_offset<br>";
//print "wo=$write_offset<br>";



$s="SELECT * from goods  ";


$s_=0;
for($i=0;$i<count($path_after);$i++){ //���������� ������.
	if ($s_) $s.="OR ";
	else
		{ $s_=1;
		  $s.=" WHERE (";
	

		}
	$s.="CID=$path_after[$i] ";
}
//
//search
//
 
 if(isset($search_str)){ //���� ���� �����, ��...

$search_str=trim(str_replace("'","",stripslashes($search_str)));
$search_str=(str_replace("+","",$search_str));

$search=explode(" ",$search_str);

$s.=" ) and name LIKE '%$search[0]%' ";

for ($i=1;$i<count($search);$i++){

$s.=" OR name LIKE '%$search[$i]%'  ";
}
//$s.=")";

}	
else $s.=")";





//������ ������ �� ������, ������� ����� ���� �� ������.
print "$s<br>";
$query=mysql_query($s." $sort_type") or die(mysql_error()) ;
$row_num=mysql_num_rows($query);
	for($i=0;$i<$row_num;$i++){
	$db_array=mysql_fetch_array($query);
	$gname=$db_array['name'];
	$gdescription=$db_array['description'];
	$n=$db_array['CID'];
	$category="<a href='$PHP_SELF?cid=$n'>$cat_names[$n]</a>";
	$price=$db_array['price'];
	eval("\$goods .= \"".$tpl->get("goods")."\";"); 
		}







eval("print \"".$tpl->get("main")."\";"); // display main template





function error_msg($msg){

}





?>
