<?
/*
*	e-Base ORDER PAGE/  order.php.
*	last updated 28 ������ 2004 �. 17:11:32
*	���������� ������.
*
*/

define('WE_ARE_HERE',true);
session_start();
require('includes/head.php');
require('includes/functions.php');
require('includes/cfg.php');
require('includes/class.php');
require('includes/template.php');


$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());
unset($host);
unset($user);
unset($password);


$PinT_id = 0;
$pin_name = 0;
$pin_price = 0;
$wid = 0;
$email = 0;

//�������� �� ������� ���� ���� �������� ���������� � �� ������������.




if( check_income_data(array($_POST['wid'],$_POST['order'],$_POST['email']) ) == TRUE){ //������ ���, 
																					// ��� ������� ��������,

	$wid = $_POST['wid'] ;
	$PinT_id = $_POST['order'];
	$email = $_POST['email'];
	unset($_POST['wid']);
	unset($_POST['order']);
	unset($_POST['email']);
	
	if (!preg_match("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$^",$email))  {
		$_SESSION['step1'] = 0;
		error_msg("�������� ������ ������������ ������!  ��������� ���������� �� <a href='order.php?order=$PinT_id'> �������� ������</a> � 	������� ���������� ������!");
	}
	
	
	if (!preg_match("/\d{12}/",$wid) || (strlen($wid))  != 12 )  {
		$_SESSION['step1'] = 0;
		error_msg("�������� ������ Webmoney ID!  ��������� ���������� �� <a href='order.php?order=$PinT_id'> �������� ������</a> � 	������� ���������� ������!");
	}

	list($pin_name,$pin_price) = check_PinT_id($PinT_id);																			
	if(!$pin_name) {
		$_SESSION['step1'] = 0;
		error_msg("�������� ������ ��������� ������!  ��������� ���������� �� <a href='index.php'> �������� ������</a> � 	������� ���������� ������!");
	}
	
	$trans = new trans($db); // ������� ����� ����������
	if(!$trans->is_can_create($PinT_id)) error_msg("� ���������, �� ���� ������� �������� ��� ���� �������� �����, ���������� ��������� ����� ����� 5-10 �����!");

	$trans->create_trans($PinT_id,0,$wid,$pin_price,$email);
	list($flag,$err) = $trans->send_invoice();
	if(!$flag) {
		$_SESSION['is_t'] = 0;
		error_msg("��������� ��������� ������, ���� �� ��� �������, ���������� �������� ������ �����!<br>");
	}
	else{ // ���� ���� ��� ������� �������:
		$_SESSION['is_t'] = 1;
		$sid = $trans->get_sid();
		//���� email �� ����� ������.
		$msg = "�� ������� ����� � ����������� �������� e-Base.ru\n��� �����: $pin_name\n����: $pin_price wmz\n";
		$msg .= "�������� ��������� ������: http://www.e-base.ru/check.php?sid=$sid\r\n          � ���������, ������������� e-Base.ru";
		$subj = "����� �� www.e-Base.ru";
		
		mail($email, $subj, $msg,"From: support@e-base.ru\r\nReply-To: support@e-base.ru\r\n");

		header("Location: check.php?sid=$sid");
		print("<br><div align='center'>��������� <a href=\"check.php?sid=$sid\">��������� ������</a></div><br>");
				
	}




}


elseif (isset($_GET['order']) && (!$_SESSION['is_t']) ){ //���� ������ ���....
	if (is_numeric($_GET['order'])  == TRUE  ) $PinT_id = $_GET['order']; //�������� ���� �������� �� ��������
	else error_msg("������!1234");

	$PinT_id = htmlspecialchars(substr($PinT_id,0,5)); // ����� ������������� ;-[]
	//connect to database,

	//----------------------------------------------------------------
	//----- �������� �� ������� ����� �����--------
	//

//	print  ("income id is : $PinT_id<br>");


	list($pin_name,$pin_price) = check_PinT_id($PinT_id);
	if(!count_pin($PinT_id)) error_msg("��������, �� �������� ��� ���� ���� � �������!");
	$trans = new trans($db);
	if(!$trans->is_can_create($PinT_id)) 
		error_msg("��������, �� �� ��� �������� �������  ���� ��� ������� �����, ���������� ��������� ������� ����� 5-15 �����!");
	
	$template = new Template("html_x/");
	$template->set_filenames(array(
		'order' => 'order.t',
		'header' => 'header.t',
		'footer' => 'footer.t')
	);
	$template->assign_vars(array(
		"title" => 'e-base.ru - ����� ������',
		"pin_name" => $pin_name,
		"id" => $PinT_id,
		"srok" => WAIT_TIME/60,
		"url" => $url,
		"pin_price" => $pin_price)
	);

	$template->assign_var_from_handle('HEADER','header');
	$template->assign_var_from_handle('FOOTER','footer');
	$template->pparse("order");

	
//	include("html_x/order.html");

//	print("<div align='center'>�� ������ ������ $pin_name �� ���� $pin_price wmz?<br>");
//	print("<a href=\"order.php?order=$PinT_id&agree=1\">��</a></div>");

}
elseif($_SESSION['is_t'] == 1){

	print("��� ����� ��� ������! <a href='index.php'>������� ����� �����</a>");
}

else{
error_msg("������ ������� ������!");
	

}


if($db) mysql_close($db);





?>
