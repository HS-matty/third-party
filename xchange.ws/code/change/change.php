<?
//   change/change.php
//   �������� ������.




define('WE_ARE_HERE',true);

include('../includes/template.php');
include('../includes/head.php');
include('../includes/functions.php');
include('../includes/class.php');
include('../includes/cfg.php');


// vars

$session_id = "";


// �������� �������� ��������.
if((!isset($_POST['sid'])) && (!isset($_GET['sid'])) ) error_msg("��������� ���������� �� <a href='../index.php'> ������� ��������</a> ��� ������ ����� � ����� ������!");

if(isset($_POST['sid']) ) $sid = $_POST['sid'];
else $sid = $_GET['sid'];
$sid = htmlspecialchars(substr ($sid,0,32));





//connect to database,

$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());

unset($host);
unset($user);
unset($password);

//�������� ������ ����������, ���� �� ������� �� ��� ������� � ����� �������
//$sql = "DELETE FROM transactions WHERE time_end < unix_timestamp() AND status = '20'";
//$query = mysql_query($sql) OR die(mysql_error());


//���� ������ � ���������� ���� � ��, �� �������� �� �������
$query = mysql_query("SELECT session_id,invoice_id FROM transactions WHERE session_id = '$sid'") OR die(mysql_error());
if(mysql_num_rows($query) != 1){


	$query = mysql_query("SELECT session_id FROM sessions WHERE session_id = '$sid'") OR die(mysql_error());
	if(!(mysql_num_rows($query))) error_msg("��� ������ ����� ��� ������, ���������� ����� �� <a href=../index.php>������� ��������</a>!");

	if(!isset($_POST['in_cur'])  || !(isset($_POST['out_cur'])) || !(isset($_POST['in_account'])) || !(isset($_POST['out_account'])) ) error_msg("��� ������ ����� ��� ������, ���������� ����� �� <a href=../index.php>������� ��������</a>!");

	//������ ��������� $in_cur � $out_cur,$in_account, $out_accout

	if (isset($_POST['in_cur']) || is_numeric($_POST['in_cur']) == TRUE ) $in_cur_id = $_POST['in_cur'];
	else error_msg("�� ������� ������� ������, ��������� �� <a href='../index.php'> ������� ��������</a> � �������� �� ���������!");

	if ( (isset($_POST['out_cur'])) || (is_numeric($_POST['out_cur']) == TRUE) ) $out_cur_id = $_POST['out_cur'];
	else  error_msg("�� ������� ������� ������, ��������� �� <a href='../index.php'> ������� ��������</a> � �������� �� ���������!");



	//$in_cur = htmlspecialchars(substr($out_cur,0,3));
	//$out_cur = htmlspecialchars(substr($in_cur,0,3));
	//$in_account = htmlspecialchars(substr($_POST['in_account'],0,13));







	$sql = "SELECT cur_id,cur_sname,money_left,min_sum,status FROM currencies WHERE 
	(cur_id = '$in_cur_id' OR cur_id = '$out_cur_id') 
	AND status = '1'";

	$query = mysql_query($sql) OR die(mysql_error());

	if(mysql_num_rows($query) != 2) error_msg("�� ������� ������� ������, ��������� �� <a href='../index.php'> ������� ��������</a> � �������� �� ���������!");

	$in_account = $_POST['in_account'];
	$out_account = $_POST['out_account'];

	while($db_array = mysql_fetch_array($query) ){

		if($db_array['cur_id'] == $in_cur_id){
			if($db_array['cur_sname'] == 'wmz' || $db_array['cur_sname'] == 'wmr'){

				if (!preg_match("/\d{12}/",$in_account) || (strlen($in_account))  != 12 )  error_msg("�������� ������ Webmoney ID!  ��������� ���������� �� <a href='index.php?in_cur=$in_cur_id&out_cur=$out_cur_id'> �������� ������������</a> � 	������� ���������� ������!");
				$in_cur_name = $db_array['cur_sname'];
				$in_min_sum = $db_array['min_sum'];
			}	

		}
		if($db_array['cur_id'] == $out_cur_id){
			if($db_array['cur_sname'] == 'wmz'){
				if (!preg_match("/[z]\d{12}/i",$out_account) || (strlen($out_account))  != 13 )  error_msg("�������� ������ �������� Webmoney!  ��������� ���������� �� <a href='index.php?in_cur=$in_cur_id&out_cur=$out_cur_id'> �������� ������������</a> � ������� ���������� ������!");
			}
			if($db_array['cur_sname'] == 'wmr'){
				if (!preg_match("/[r]\d{12}/i",$out_account) || (strlen($out_account))  != 13 )  error_msg("�������� ������ �������� Webmoney!  ��������� ���������� �� <a href='index.php?in_cur=$in_cur_id&out_cur=$out_cur_id'> �������� ������������</a> � ������� ���������� ������!");
			}

			$out_money_left = $db_array['money_left'];
			$out_cur_name = $db_array['cur_sname'];
			$out_min_sum = $db_array['min_sum'];

		}

	}

	if(!isset($_POST['in_val']) || ($_POST['in_val']) <= 0 || (!is_numeric($_POST['in_val'])) ) error_msg("�� �������� ������ ������ ����� ������! ��������� ���������� �� <a href='index.php?in_cur=$in_cur_id&out_cur=$out_cur_id'> �������� ������������</a> � ������� ����� ������!");
	else $in_val = $_POST['in_val'];

	list($max_sum,$max_time) = max_change($out_cur_id,$out_money_left,$db);




	//��������� ���� $in_cur_id � $out_cur_id

	$sql = "SELECT rate FROM rates WHERE in_cur_id = '$in_cur_id' AND out_cur_id = '$out_cur_id'";
	if(!$query = mysql_query($sql)) error_msg("can't extract rates,db error");
	$row = mysql_fetch_row($query);
	$rate = $row[0];
	$in_val = round($in_val*100)/100;
	$out_val = floor($in_val*$rate*100+0.00001)/100;

	if($max_sum < $out_val) error_msg("��������, �� ������ �� ������ ��������  ������ $max_sum $out_cur_name, ������� ������� ����� ��� ������!");
	if($out_val < $out_min_sum) error_msg("����������� ����� ������ $out_min_sum $out_cur_name");
	if($in_val < $in_min_sum) error_msg("����������� ����� ������ $in_min_sum $in_cur_name");


	$trans = new trans($db);
	$trans->create_trans($sid,$in_cur_id,$in_account,$in_val,$out_cur_id,$out_account,$out_val,$rate,$max_time);

	print("<div align='center'>�� ������ �������� ������ �� ��������� �������: $in_val $in_cur_name �� $out_val $out_cur_name �� ����� $rate?");
	print("<br><a href='change.php?change=1&sid=$sid'>��</a></div>");
	

		


}else{
	$arr = mysql_fetch_array($query);

	$trans = new trans($db);
	$trans->get_trans($sid);
	if(! $trans->get_trans_status() ) error_msg("��������, ����� �������� �������. ����������, ��������� �� ������� �������� � 		��������� ��������� ������");

	elseif($arr['invoice_id'] == 0 && ($trans->status == 20) ){

		if(! ($err = $trans->send_invoice($sid)) ) print("Invoice sent!");
			
		else { 
			print("������ ������� ����: $err");
			print("<br><a href='change.php?sid=$sid'>��������� ��� ���?</a>");
		}
	}
	elseif($trans->status == 0){
		print("���� �$trans->trans_id �������. ���� ������");

	}
	elseif($trans->status == '-1'){
		print("����� ������ ����� �$trans->trans_id �������. ");

	}

	else{

		list($in_cur,,$in_sum) = $trans->get_in_cur();
		list($out_cur,,$out_sum) = $trans->get_out_cur();
		print("<br>in_cur  = $in_cur, out_cur = $out_cur");
	}

	
	
}


mysql_close($db);
?>