<?
/*
*	e-Base MAIN PAGE/ index.php.
*	last updated 28 апреля 2004 г. 17:11:32
*	Выводит список доступных карт.
*
*/

define('WE_ARE_HERE',true);
require('includes/functions.php');
require('includes/cfg.php');
require('includes/class.php');
require('includes/head.php');
require('includes/template.php');


$db = mysql_connect("$host","$user","$password") OR die(mysql_error());
mysql_select_db("$db_name") OR die (mysql_error());
unset($host);
unset($user);
unset($password);
$trans = new trans($db);
//найдем транзакции, время которых истекло и переведем их в статус неоплаченных
$trans->check_unpayed_trans();

// загрузим template'ы
$template = new Template("html_x/");
$template->set_filenames(array(
	'index' => 'index.t',
	'header' => 'header.t',
	'footer' => 'footer.t')
);



// достанем из базы данные о доступных типах карт
$sql = "SELECT * FROM pin_types WHERE is_active=1";
$rez = mysql_query($sql) OR die(mysql_error());
$bgcol = '#F3F3F3';

$template->assign_vars(array(
		"title" => 'e-Base.ru - электронная коммерция в Беларуси',
		"url" => $url)
	);


while($arr = mysql_fetch_array($rez) ){

	$trans->is_can_create($arr[PinT_id]);
	if($trans->get_is_aval_flag() || $trans->is_can_create($arr[PinT_id])){
		if($trans->get_is_aval_flag()) $zakaz = "<a class='nav' href = 'order.php?order=$arr[PinT_id]'>заказать!</a>";
		else $zakaz = "нет в наличии!";
		$template->assign_block_vars('MAIN',	array(
			"id" => $arr['PinT_id'],
			"des" => $arr['PinT_des'],
			"price" => $arr['PinT_price'],
			"nom" => $arr['PinT_nominal'],
			"bgcol" => $bgcol,
			"zakaz" => $zakaz,
			"pic" => $arr['PinT_pic'])
		);

	}

	if($bgcol === '#F3F3F3') $bgcol = '#F9F9F9'; //чтобы полоски на главной странице были разноцветные ;-)
	elseif($bgcol === '#F9F9F9') $bgcol = '#F3F3F3';
}



mysql_close($db);

session_start();
$_SESSION['is_t'] = 0;

$template->assign_var_from_handle('HEADER','header');
$template->assign_var_from_handle('FOOTER','footer');
$template->pparse("index");

//print("<div align='center'><a href='order.php?order=3'>Карточка СОЛО!</a>");



?>





