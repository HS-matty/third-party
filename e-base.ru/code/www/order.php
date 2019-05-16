<?
/*
*	e-Base ORDER PAGE/  order.php.
*	last updated 28 апреля 2004 г. 17:11:32
*	Оформление заказа.
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

//проверка на наличие кода типа карточки предоплаты и ее корректность.




if( check_income_data(array($_POST['wid'],$_POST['order'],$_POST['email']) ) == TRUE){ //второй шаг, 
																					// уже выбрана карточка,

	$wid = $_POST['wid'] ;
	$PinT_id = $_POST['order'];
	$email = $_POST['email'];
	unset($_POST['wid']);
	unset($_POST['order']);
	unset($_POST['email']);
	
	if (!preg_match("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$^",$email))  {
		$_SESSION['step1'] = 0;
		error_msg("Неверный формат электронного адреса!  Вернитесь пожалуйста на <a href='order.php?order=$PinT_id'> страницу заказа</a> и 	введите корректные данные!");
	}
	
	
	if (!preg_match("/\d{12}/",$wid) || (strlen($wid))  != 12 )  {
		$_SESSION['step1'] = 0;
		error_msg("Неверный формат Webmoney ID!  Вернитесь пожалуйста на <a href='order.php?order=$PinT_id'> страницу заказа</a> и 	введите корректные данные!");
	}

	list($pin_name,$pin_price) = check_PinT_id($PinT_id);																			
	if(!$pin_name) {
		$_SESSION['step1'] = 0;
		error_msg("Неверный формат введенных данных!  Вернитесь пожалуйста на <a href='index.php'> страницу заказа</a> и 	введите корректные данные!");
	}
	
	$trans = new trans($db); // создаем новую транзакцию
	if(!$trans->is_can_create($PinT_id)) error_msg("К сожалению, на весь остаток карточек уже были выписаны счета, попробуйте повторить заказ через 5-10 минут!");

	$trans->create_trans($PinT_id,0,$wid,$pin_price,$email);
	list($flag,$err) = $trans->send_invoice();
	if(!$flag) {
		$_SESSION['is_t'] = 0;
		error_msg("Произошла внутрення ошибка, счет не был выписан, попробуйте заказать услугу позже!<br>");
	}
	else{ // если счет был успешно выписан:
		$_SESSION['is_t'] = 1;
		$sid = $trans->get_sid();
		//шлем email по этому поводу.
		$msg = "Вы сделали заказ в электронном магазине e-Base.ru\nВаш заказ: $pin_name\nЦена: $pin_price wmz\n";
		$msg .= "Проверка состояния заказа: http://www.e-base.ru/check.php?sid=$sid\r\n          С уважением, администрация e-Base.ru";
		$subj = "Заказ на www.e-Base.ru";
		
		mail($email, $subj, $msg,"From: support@e-base.ru\r\nReply-To: support@e-base.ru\r\n");

		header("Location: check.php?sid=$sid");
		print("<br><div align='center'>проверить <a href=\"check.php?sid=$sid\">состояние заказа</a></div><br>");
				
	}




}


elseif (isset($_GET['order']) && (!$_SESSION['is_t']) ){ //если первый шаг....
	if (is_numeric($_GET['order'])  == TRUE  ) $PinT_id = $_GET['order']; //проверим типа карточки на вшивость
	else error_msg("Ошибка!1234");

	$PinT_id = htmlspecialchars(substr($PinT_id,0,5)); // мания преследования ;-[]
	//connect to database,

	//----------------------------------------------------------------
	//----- Проверка на наличие такой карты--------
	//

//	print  ("income id is : $PinT_id<br>");


	list($pin_name,$pin_price) = check_PinT_id($PinT_id);
	if(!count_pin($PinT_id)) error_msg("Извините, но карточек это типа нету в наличии!");
	$trans = new trans($db);
	if(!$trans->is_can_create($PinT_id)) 
		error_msg("Извините, но на все карточки данного  типа уже высланы счета, попробуйте повторить попытку через 5-15 минут!");
	
	$template = new Template("html_x/");
	$template->set_filenames(array(
		'order' => 'order.t',
		'header' => 'header.t',
		'footer' => 'footer.t')
	);
	$template->assign_vars(array(
		"title" => 'e-base.ru - заказ товара',
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

//	print("<div align='center'>Вы готовы купить $pin_name по цене $pin_price wmz?<br>");
//	print("<a href=\"order.php?order=$PinT_id&agree=1\">да</a></div>");

}
elseif($_SESSION['is_t'] == 1){

	print("Ваш заказ уже принят! <a href='index.php'>Сделать новый заказ</a>");
}

else{
error_msg("Ошибка входных данных!");
	

}


if($db) mysql_close($db);





?>
