<?
session_start();
define('IN_SHOP', true);
include('functions.php');
include('./cfg/conf.inc');
require_once "class.Template.php";
$tpl = new Template("./tpl2");
include('var.php');
$db = mysql_connect() or die (mysql_error());
mysql_select_db("$db_name") or die (mysql_error());

//$cart_status=cart_status($cart); //check shopping cart status


//--------------------------------------------------------------------------------------//
//---  GREATING ROOT--------------------------------------------------------------------//
//-------------------------------------------------------------------------------------//
//$cid=1;

	if (isset($add) && $add==1 && isset($gid)){ //���� ����� �������� �����...
		if (!session_is_registered("cart")){  //check if shopping cart wasnt inititialised.
			$cart = array();
			session_register("cart");

		}

		if ($query = mysql_query("SELECT * FROM goods WHERE GID=$gid")){
			$z=count($cart); 
			//check if we already have such good in the shopping cart
			$add_good=1;
			for($i=0;$i<$z;$i++){
				if ($cart[$i]==$gid) $add_good=0; //if we do, $add_good=0
				else $add_good=1;//if not, $add_good=1
								
			}
			if ($add_good==1) {
				$cart[count($cart)]=$gid; //adding good if $add_good=1
				$goods_count[$gid]=1;
				session_register("goods_count");
			}
		
		}	

}


if(isset($cart)) $cart_status=cart_status($cart);  //�������� ������� � ���������.
else $cart_status="empty";




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




	if (!isset($cid)) $cid = 0;    //�������, ���� �� ��������� � �������������

// ���� ����, ��  ������ ������ �� ���, � ����� ����������� ��� � ����.
$q = mysql_query("SELECT * from categories ORDER BY CID") or die(mysql_error()) ;
$path = array();// ������, ��� �������� ���� �� $cid, path[$cid]=parent
$cat_names = array();//������, ��� �������� ����� ���������,$cat_names[$cid]=name
$row_num = mysql_num_rows($q);


	for ($i=0; $i<$row_num; $i++){
	$db_array=mysql_fetch_array($q);
	$categories[$db_array['CID']] = $db_array['Parent'];
	$cat_names[$db_array['CID']] = $db_array['Name'];
	if($db_array['Parent'] == $cid)//������� �� $parent, ���������� �� ��� ���������.
		{//���� ��� ��, ��� ����, ��������� ��� ��������� � navigation

					$name = $db_array['Name'];
					$cid_ = $db_array['CID'];
					eval("\$navigation_left .= \"".$tpl->get("navigation")."\";"); 

		}
	}

if(!isset($categories[$cid])) $cid = 0;	
	$path[0] = $cid;//������ ������� ���� �� $cid, c�� $cid
	$i = 1;//�������� ��� � ������� ����������� ����

if ($cid != 0){
	$cid_ = $cid;
	while($categories[$cid_]) //���� �� ��� ��������� ?
		{
		$path[$i] = $categories[$cid_];
		$i++;	
		$cid_ = $categories[$cid_];
		}
	$path[count($path)] = 0;//������ ��������� ��������� 0, �.�. root
	$path = array_reverse($path);//��������������


}

	for($i = 1; $i < count($path); $i++){//������ �� ����� ����.
	$zz=$path[$i];
	$path_2_cat .= "<a href=$PHP_SELF?cid=$zz class='root_text'> $cat_names[$zz]</a>/";//������� ������� ����. 
	}

//-----------------------------
//����������� $path_after
//----------------------------
	$path_after[0] = $cid;// ������ ������ ���� ���� ���� ���������
	$write_offset = 1;
	$read_offset = 0; 

//��������� ���� ����� $path_after
//��� ���� ����� �������� ������, ������� ���������� � ����������� ����������
for($z=$read_offset;$z<count($path_after);$z++){
		for($i=1;$i<count($categories)+1;$i++){	
			if($categories[$i] == $path_after[$z]){

			$path_after[$write_offset] = $i;
			$write_offset++;
			
			}

		}

}
;



$s="SELECT * from goods  ";


$s_=0;
for($i=0;$i<count($path_after);$i++){ //���������� ������.
	if ($s_) $s.="OR ";
	else
		{ $s_=1;
		  $s.=" WHERE ";
	

		}
	$s.="CID=$path_after[$i] ";
}



//������ ������ �� ������, ������� ����� ���� �� ������.
//print "$s<br>";
$query=mysql_query($s." $sort_type") or die(mysql_error()) ;
$row_num=mysql_num_rows($query);
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
		eval("\$index .= \"".$tpl->get("goods")."\";"); 
	}


for ($i=1; $i<count($path);$i++) {
	$title .= " ".$cat_names[$path[$i]]." /"; //generation title
	
}


 

eval("\$head = \"".$tpl->get("head")."\";"); //������ ���������.

ob_start(); 
include "tpl2/footer.tpl"; 
$footer = ob_get_contents(); 
ob_end_clean(); 



eval("print \"".$tpl->get("main")."\";"); // display main template





function error_msg($msg){

}





?>
