<?

/*
*	e-Base Check TRANSACTION STATUS/ check.php.
*	last updated 28 апреля 2004 г. 17:11:32
*	Проверяет состояние заказа по $sid
*
*/

define('WE_ARE_HERE',true);
require('includes/functions.php');
require('includes/cfg.php');
require('includes/class.php');
require('includes/head.php');
require('includes/template.php');



if(!$_GET['sid']) error_msg("Отсутствует идентификатор!");
else $sid = $_GET['sid'];

$sid = htmlspecialchars(substr($sid,0,32)); // мания преследования ;-[]

$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());
unset($host);
unset($user);
unset($password);
$sql = "SELECT session_id FROM transactions WHERE session_id = '$sid'";
$q = mysql_query($sql) OR die(mysql_error());
if(mysql_num_rows($q) == 0) error_msg("Операция с таким идентификатором отсутствует!");

$trans = new trans($db);
list($state,$wm_order_id,$in_account,$status,$time_start,$time_end,$sum,$is_proceed) = $trans->check_order_status($sid); //проверим состояние счета



$time_start = date(" H:i:s d.m.Y ",$time_start);                         
$time_end = date(" H:i:s d.m.Y ",$time_end);
$time = date(" H:i:s d.m.Y ",time());

//print(" Номер выписанного счета: $trans_id<br> WEBMONEY id: $in_account<br>Время выписки счета: $time_start<br>Время //окончания действия: $time_end<br>статус: ");


switch ($status){ //Смотрим статус  транзакции
		case T_INVOICE_KILLED:
			$stat = 'отказ от счета';
			break;
		case T_MONEY_R: // если счет оплачен.
				if(!$trans->get_pin()) error_msg("Ошибка, обратитесь в поддержку!");
				else $stat = 'Счет оплачен, вся необходимая  информация выслана вам по e-mail и wm-почте';
				break;
		case T_MONEY_R_AFTER: //если деньги пришли потом
				if($trans->get_pin_after()) // пытаемя выдать услугу.
					$stat = 'Вы оплатили после указанного времени,cейчас нету доступных пин-карт, обновите окно через 5-10 минут';
				else	$stat = 'Счет оплачен, вся необходимая  информация выслана вам по e-mail и wm-почте';

			break;
		case T_INVOICE_SENT:
			$stat = "Счет был успешно выписан, ждем оплаты";
			break;
		case T_ERROR:
			$stat = "Ошибка функционирования webmoney";
			break;
		case T_PIN_GIVEN:
			$stat = "Услуга оказана.";
			break;
		case T_MONEY_NOT_R:
			$stat = "Счет в указанный период не оплачен";
			break;
		case T_CREATED:
			$stat = "Счет не был выписан";
			break;
		

}
		
$template = new Template("html_x/");
	$template->set_filenames(array(
		'check' => 'check.t',
		'header' => 'header.t',
		'footer' => 'footer.t')
	);
	$template->assign_vars(array(
		"title" => 'e-base.ru - проверка состояния заказа.',
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