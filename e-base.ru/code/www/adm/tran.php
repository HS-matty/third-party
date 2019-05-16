<?
/*
*	e-Base VIEW TRANSACTION CONTENT / tran.php. by rabbit
*	last updated 28 апреля 2004 г. 17:11:32
*	Простотр всех событий,связанных с контертной транзакцией ($sid)
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

//Проверим наличие транзакции с таким SID.
if(!isset($_GET['sid'])) die('нету сида');				//если нет - то выход.
$sid = htmlspecialchars(substr($_GET[sid],0,32));
$template = new Template("tpl/");
$template->set_filenames(array(
	'body' => 'msg.tpl')
);

// Извлекаем из базы все сообщение, относящиеся к данной транзакции по $sid.
$sql = "SELECT t_message, t_time FROM t_messages WHERE session_id = '$sid'";
$rez = mysql_query($sql) OR die(mysql_error());
while($arr = mysql_fetch_array($rez)){
	$template->assign_block_vars('MSG',	array(
							"body" => $arr['t_message'],
							"time" => date(" H:i:s d.m.Y ",$arr['t_time']))
		);
}
	


$template->pparse("body");//парсим темлейт

?>