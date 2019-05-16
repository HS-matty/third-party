<?
// /www/change/index.php
// страница с калькулятором
//


define('WE_ARE_HERE',true);

include('../includes/template.php');
include('../includes/head.php');
include('../includes/functions.php');
include('../includes/cfg.php');
// vars


$session_id = "";


//connect to database,
$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());

unset($host);
unset($user);
unset($password);

$user_ip = encode_ip(check_user_ip());


//

if(!$query=mysql_query("SELECT active FROM config")) die();
$db_array = mysql_fetch_row($query);
if($db_array[0] != 1) exit;



// Проверка входящих значений.


//проверка входящих валют
//Смотрим, чтобы in_cur и out_cur присутствовали, иначе error

if (isset($_GET['in_cur'])){
	if (is_numeric($_GET['in_cur'])  == TRUE  ) $in_cur = $_GET['in_cur'];
	else error_msg("Ошибка!");
}

else error_msg("Пожалуйста, выберите валюты для обмена <a href = '../index.php'> на главной странице!</a>");

if (isset($_GET['out_cur']) ){
	if(is_numeric($_GET['out_cur']) == TRUE)  $out_cur = $_GET['out_cur'];
	else 	 error_msg("Ошибка!");
}

else  error_msg("Пожалуйста, выберите валюты для обмена <a href = '../index.php'> на главной странице!</a>");


//теперь фильтруем in_cur и out_cur
$in_cur = htmlspecialchars(substr($in_cur,0,5));
$out_cur = htmlspecialchars(substr($out_cur,0,5));

$sql = "SELECT cur_id,cur_sname,status,money_left FROM currencies WHERE 
(cur_id = '$in_cur' OR cur_id = '$out_cur') 
AND status = '1'";

$query = mysql_query($sql) OR die(mysql_error());
if(mysql_num_rows($query) != 2) error_msg("error!");
while($db_array = mysql_fetch_array($query)){
	if($db_array['cur_id'] == $in_cur) {
		$in_cur_name = $db_array['cur_sname'];
		$in_money_left = $db_array['money_left'];
	}
	if($db_array['cur_id'] == $out_cur){
		$out_cur_name = $db_array['cur_sname'];
		$out_money_left = $db_array['money_left'];
	}
}

list($max_sum,$max_time) = max_change($out_cur,$out_money_left,$db);
if($max_sum == 0) error_msg("Извините, но сейчас запас $out_cur_name исчерпан."); 


while($db_array = mysql_fetch_array($query)){
	if ($db_array['cur_sname'] == $out_cur) {
		$money_left = $db_array['money_left'];
		break;
	}
}

// Извлекаем курс.

$sql = "SELECT rate FROM rates where in_cur_id='$in_cur' AND out_cur_id='$out_cur'";
$query = mysql_query($sql) OR die(mysql_error());
if(mysql_num_rows($query) != 1) error_msg("something wrong!");
$db_array  = mysql_fetch_row($query) OR die();
$rate = $db_array[0];

//смотрим, была ли зарегистрирована сессия.
if(isset($_GET['sid'])){
	$sid = $_GET['sid'];
	$sid = htmlspecialchars(substr ($sid,0,32));
	$sql = "SELECT session_id from sessions WHERE session_id = '$sid'";
	$query = mysql_query("$sql") OR die(mysql_error());
	if(!mysql_num_rows($query)) $sid = "";
}
else $sid = "";

if(!$sid)	{
	$session_id = create_session(0,$user_ip);
	$sid = "$session_id";
	print("new sid is $sid");

}



$template = new Template("../templates/");

// загружаем currencies template для каждого варианта обмена
// ex: wmz -> wmr ==> wmz_wmr.tpl


$currs_template = $in_cur_name."_".$out_cur_name.".tpl";

$template->set_filenames(array(
	'change' => 'change_index.tpl',
	'wmz_wmr'=> $currs_template)
);





$money_left = 0;


$template->assign_var_from_handle('CURRS','wmz_wmr');


$template->assign_vars(array(
		"TITLE" => 'e-Base.ru/change',
		"IN_CUR" => $in_cur,
		"OUT_CUR" => $out_cur,
		"MONEY_LEFT" => $max_sum,
		"SID" => $sid,
		"IN_CUR_NAME" => $in_cur_name,
		"OUT_CUR_NAME" => $out_cur_name,
		"RATE" => $rate)

	);

$template->pparse('change');




mysql_close($db);




?>