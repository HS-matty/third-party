<?
/*
*	e-Base MAIN ADMIN PAGE/ adm.php.
*	last updated 28 апреля 2004 г. 17:11:32
*	Список транзакций, статистика.
*
*/

define('WE_ARE_HERE',true);
require('../includes/head.php');
require('../includes/cfg.php');
require('../includes/functions.php');
require('../includes/template.php');

global $db;
$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());
unset($host);
unset($user);
unset($password);

require("hd.php");

// заводим темплейт

$template = new Template("tpl/");
$template->set_filenames(array(
	'body' => 'adm.tpl')
);

$template->assign_vars(array(
		"u_sid" => $u_sid)
	);

//если все испытания пройдены
//считаем сколько всего карт есть
$sql = "SELECT  count(*) as count,a.used, PinT_des FROM pin_list as a,pin_types as b WHERE a.PinT_id=b.PinT_id GROUP BY a.used, b.PinT_id";
$rez = mysql_query($sql) OR die(mysql_error());
while($arr = mysql_fetch_array($rez)){
	if($arr[used] == 0){
		$template->assign_block_vars('AV',	array(
							"pin_name" => $arr['PinT_des'],
							"count" => $arr['count']));
		}
		else{
		$template->assign_block_vars('USED',	array(
							"pin_name" => $arr['PinT_des'],
							"count" => $arr['count']));
		
		
		}

}

// достаем информацию о транзакциях
$sql = "SELECT s.descr,t.email,t.session_ip,t.trans_id, t.session_id, t.in_account, t.time_start,p.PinT_des FROM transactions as t, pin_types as p,t_status as s WHERE t.PinT_id = p.PinT_id AND t.status = s.status ORDER BY t.time_start DESC";
$rez = mysql_query($sql) OR die(mysql_error());

while($arr = mysql_fetch_array($rez) ){
//date(" H:i:s d.m.Y ",$arr['time_start']),
	
	$template->assign_block_vars('TR',	array(
		"id" => $arr[trans_id],
		"name" => $arr[PinT_des],
		"wmid" => $arr[in_account],
		"sid" => $arr['session_id'],
		"email" => $arr['email'],
		"ip" => decode_ip($arr['session_ip']),
		"time_start" => date(" H:i:s d.m.Y ",$arr['time_start']),
		"status" => $arr[descr])
		);


}









$template->pparse("body");


?>