<?

/*
*	e-Base Check TRANSACTION STATUS/ check.php.
*	last updated 28 ������ 2004 �. 17:11:32
*	��������� ��������� ������ �� $sid
*
*/

define('WE_ARE_HERE',true);
require('includes/functions.php');
require('includes/cfg.php');
require('includes/class.php');
require('includes/head.php');
require('includes/template.php');



if(!$_GET['sid']) error_msg("����������� �������������!");
else $sid = $_GET['sid'];

$sid = htmlspecialchars(substr($sid,0,32)); // ����� ������������� ;-[]

$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());
unset($host);
unset($user);
unset($password);
$sql = "SELECT session_id FROM transactions WHERE session_id = '$sid'";
$q = mysql_query($sql) OR die(mysql_error());
if(mysql_num_rows($q) == 0) error_msg("�������� � ����� ��������������� �����������!");

$trans = new trans($db);
list($state,$wm_order_id,$in_account,$status,$time_start,$time_end,$sum,$is_proceed) = $trans->check_order_status($sid); //�������� ��������� �����



$time_start = date(" H:i:s d.m.Y ",$time_start);                         
$time_end = date(" H:i:s d.m.Y ",$time_end);
$time = date(" H:i:s d.m.Y ",time());

//print(" ����� ����������� �����: $trans_id<br> WEBMONEY id: $in_account<br>����� ������� �����: $time_start<br>����� //��������� ��������: $time_end<br>������: ");


switch ($status){ //������� ������  ����������
		case T_INVOICE_KILLED:
			$stat = '����� �� �����';
			break;
		case T_MONEY_R: // ���� ���� �������.
				if(!$trans->get_pin()) error_msg("������, ���������� � ���������!");
				else $stat = '���� �������, ��� �����������  ���������� ������� ��� �� e-mail � wm-�����';
				break;
		case T_MONEY_R_AFTER: //���� ������ ������ �����
				if($trans->get_pin_after()) // ������� ������ ������.
					$stat = '�� �������� ����� ���������� �������,c����� ���� ��������� ���-����, �������� ���� ����� 5-10 �����';
				else	$stat = '���� �������, ��� �����������  ���������� ������� ��� �� e-mail � wm-�����';

			break;
		case T_INVOICE_SENT:
			$stat = "���� ��� ������� �������, ���� ������";
			break;
		case T_ERROR:
			$stat = "������ ���������������� webmoney";
			break;
		case T_PIN_GIVEN:
			$stat = "������ �������.";
			break;
		case T_MONEY_NOT_R:
			$stat = "���� � ��������� ������ �� �������";
			break;
		case T_CREATED:
			$stat = "���� �� ��� �������";
			break;
		

}
		
$template = new Template("html_x/");
	$template->set_filenames(array(
		'check' => 'check.t',
		'header' => 'header.t',
		'footer' => 'footer.t')
	);
	$template->assign_vars(array(
		"title" => 'e-base.ru - �������� ��������� ������.',
		"status" => $stat,
		"url" => $url,
		"id" => $in_account,
		"wm_id" => $wm_order_id,
		"time_start" => $time_start,
		"time_end" => $time_end,
		"time" => $time)
	);

	$template->assign_var_from_handle('HEADER','header');
	$template->assign_var_from_handle('FOOTER','footer');
	$template->pparse("check");


?>