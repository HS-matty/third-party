<?
//change fin settings


define('WE_ARE_HERE',true);

include('../includes/template.php');
include('../includes/head.php');
include('../includes/functions.php');
include('../includes/cfg.php');


$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());

if(!isset($_GET['u_sid']) && (!isset($_POST['u_sid'])) ) die();
else {
	if(isset($_GET['u_sid'])) $u_sid = $_GET['u_sid'];
	else $u_sid = $_POST['u_sid'];
}

$u_sid = check_admin_session($u_sid);
$sid_add = "&u_sid=$u_sid";




//если меняем курсы валют
if(isset($_GET['change_rates']) || (isset($_POST['rate_submited'])) ){
	
	if(isset($_GET['rate_id']) && (is_numeric($_GET['rate_id'])) ) $rate_id = htmlspecialchars($_GET['rate_id']);

	

	if(isset($_POST['rate_submited'])){
										//если уже форма отправлена, то меняем курс валюты

		if(!isset($_POST['rate']) || (!is_numeric($_POST['rate'])) ) die();
		else $rate = $_POST['rate'];
		if(!isset($_POST['rate_id']) || (!is_numeric($_POST['rate_id'])) ) die();
		else $rate_id = $_POST['rate_id'];

			
		$query = mysql_query("UPDATE rates SET rate='$rate' WHERE rate_id = '$rate_id'") OR die(mysql_error());
		print("<div align='center'>new rate is $rate,    <a href='index.php?$sid_add'> back to main</a></div>");


		
	}else{//если нет, то выводим форму.
		$template = new Template("../templates/admin386sx/");	

	
		$template->set_filenames(array(
			'header' => 'head.tpl',
			'change_rates' => 'change_rates.tpl') );

		$query = mysql_query("SELECT cur_id,cur_sname FROM currencies") OR die(mysql_error());
		while($arr = mysql_fetch_array($query)){
			$cur_names[$arr['cur_id']] = $arr['cur_sname'];
		}
	

	
		$query = mysql_query("SELECT * FROM rates WHERE rate_id='$rate_id'") OR die(mysql_error());
		while($db_array = mysql_fetch_array($query) ){
			
			$template->assign_block_vars('RATES',	array(
				"in_cur_name" => $cur_names[$db_array['in_cur_id']],
				"out_cur_name" => $cur_names[$db_array['out_cur_id']],
				"rate_id" => $db_array['rate_id'],
				"rate" => $db_array['rate'])
				);
	
	
		}

	$template->assign_vars(array(
			"U_SID" => "$u_sid",
			"TITLE" => 'e-Base.ru/admin')
		);

	$template->pparse('change_rates');
	}

}
//
//Если решили поменять статус валюты
//
elseif( isset($_GET['change_status']) || isset($_POST['change_status'] ) ){
	
	//если форма отправлена
	if(isset($_POST['select']) ){
		if(!isset($_POST['cur_id']) && (!is_numeric($_POST['cur_id'])) )  die('error!'); 
		else $cur_id = $_POST['cur_id'];

		$select = $_POST['select'];
		if(  ($select>1) || ($select<0)   ) die('ошибка статуса!');
		else {
			$query = mysql_query("UPDATE currencies SET status = '$select' WHERE cur_id ='$cur_id'") OR die(mysql_error());
			print("<div align='center'>сделано! <a href='index.php?$sid_add'> на главную </a></div>");
		}

	//если нет, то выводим форму
	}else{
	
		if( (!isset($_GET['cur_id']) ) || (!is_numeric($_GET['cur_id'])) )  die();
		else $cur_id = $_GET['cur_id'];
	
		$template = new Template("../templates/admin386sx/");	
		$template->set_filenames(array(
		'change_curs' => 'change_curs.tpl',
		'header' => 'head.tpl')
		);
	
		$query = mysql_query("SELECT cur_sname FROM currencies WHERE cur_id = '$cur_id'") OR 	die(mysql_error());
		$row = mysql_fetch_row($query); //
	
		$template->assign_vars(array(
			'CUR_ID' => $cur_id,
			'U_SID' => $u_sid,
			'CUR_NAME' => "$row[0]")
		);

		$template->pparse('change_curs');

	}
}




mysql_close($db);
?>