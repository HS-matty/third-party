<?
/*
/	MAIN TRANSACTION CLASS by rabbit
/	last updated 28 апреля 2004 г. 17:09:30
/
*/
if(!defined('WE_ARE_HERE'))  die();

require("wm.inc");
require("wmconst.inc");
define('UPDATE_TRANS_TIME',120); // время, через которое будет вызываться функция-мусорщик транзакций,
								//которая переводит транзакции, не оплаченные в срок, в статус T_MONEY_NOT_R
define('WAIT_TIME',1800); //время ожидания оплаты


class trans{
	var $t_msg;
	var $num_from_ip = 5; //кол-во заказов с одного IP
	var	$is_true=0;//перем-ая, показывающая загрузили ли мы информацию о транзакции
	var	$user_ip;  // ip клиента
	var $sid;
	var $in_account; // входящий номер счета
	var $sum; // входящая сумма
	var $cur_id; // Идентификатор валюты
	var $order_id; //номер счета  в системе Webmoney
	var $status; //текущее состояние транзакции
	var $current_rate; //текущий курс обмена
	var $time_end; //время окончания действия транзакции
	var $time_start; //время начала транзакции.
	var $trans_id; // Номер  транзакции
	var	$db;
	var $is_proceed = 0; // 0 - не отпустили услугу, 1 - отпустили
	var $trans_ok = 1; // 1 - транзакция может прод. 0 - не может продолжать работу.
	var $PinT_id = 0; //тип карты (пина)
	var $email;
	var $is_aval_flag = 0; // флаг
	var $pin_des; //описание типа пина

	function	trans ($db){
		$this->db = $db;
		$this->user_ip = encode_ip(check_user_ip());
		
			

	}

	//Изменение статуса транзакции.
	function change_tran_status($new_status){
		/*
		Возможное статусы транзакции
		T_CREATED - транзакция создана
		T_INVOICE_SENT - инвойс выписан
		T_MONEY_NOT_R  - деньги по инвойсу не получены в срок
		T_MONEY_R  - деньги по инвойсу получены
		T_INVOICE_KILLED - инвойс удален
		T_ERROR - ошибка транзакции
		T_PIN_GIVEN  - отдали товар
		*/
		
		if(!($new_status) || (!$this->sid)) error_msg("Внутренняя ошибка");
		$query = mysql_query("UPDATE transactions SET status ='$new_status' WHERE session_id = '$this->sid'") OR die(mysql_error());
		$rez = mysql_query("SELECT descr FROM t_status WHERE status = '$new_status'");
		$new_status_msg = mysql_fetch_row($rez);
		$this->send_t_msg("Изменен статус Транзации № $this->trans_id на [$new_status_msg[0]]");
		$this->status = $new_status;
	}
	
	
	
	// создание новой транзакции.
	function create_trans($PinT_id,$cur_id, $in_account,$sum,$email=0){
		//проверим на допустимое количество отправленных счетов с одного Ip
		 $this->num_tr_byip();
		//добавляем транзакцию в БД.
		$this->cur_id = $cur_id;
		$this->in_account = $in_account;
		$this->sum = $sum;
		$this->email = $email;
		$time_wait = WAIT_TIME;
					
		$sid = $this->sid();
		$status = 20; //20 - 'Инициализирована новая транзакция'
		$sql = "INSERT INTO transactions (PinT_id,session_id,in_account,cur_id,sum,session_ip,status,time_start,time_end,email) values('$PinT_id','$sid','$in_account','$cur_id', '$sum','$this->user_ip','$status',unix_timestamp(),unix_timestamp()+ '$time_wait','$email')";

		if(!$query = mysql_query($sql)) die(mysql_error());
		$this->trans_id = mysql_insert_id();		
		//удалаяем из сессий текущую.
	//	$query = mysql_query("DELETE  from sessions WHERE session_id = '$sid'");
		$this->send_t_msg("Транзакция №$this->trans_id создана!");
	}

	function num_tr_byip(){
		$sql = "SELECT count(*) FROM transactions WHERE session_ip = '$this->user_ip' AND status = 0";
		$rez = mysql_query($sql) OR die(mysql_error());

		$row = mysql_fetch_row($rez);
//		print("row is $row[0]");

		if ($row[0] > $this->num_from_ip) error_msg("Вами уже было сделано несколько заказов!");
				
	}

	function send_invoice(){

	$wm_z = 'Z498072289702';
	$wm_r = 'R994925331415';
	$wm_e = 'E871619364539';

		//проверяем, были ли извлечены данные о транзакции.
//		if(!($this->is_true)) $this->get_trans($this->sid);//
		//узнаем, в какой валюте будет invoice
	//	$query = mysql_query("SELECT cur_sname FROM currencies WHERE cur_id = '$this->in_cur_id'") OR die(mysql_error());
	//	$db_array = mysql_fetch_row($query);
		
	//	if(($db_array[0] == 'wmz') || ($db_array[0] == 'wmr')){  //если invoice в ПС webmoney

			//определяем в какой валюте выписывать счет.
	//		if($db_array[0] == 'wmz') $wmconst__shop_wmpurse = $wm_z; //WebmoneyZ
	//		if($db_array[0] == 'wmr') $wmconst__shop_wmpurse = $wm_r; //WebmoneyR
	//		if($db_array[0] == 'wme') $wmconst__shop_wmpurse = $wm_e; //WebmoneyE
		
			$wmconst__shop_wmpurse = $wm_z;
			$wmid   = $this->in_account;
			$summ   = $this->sum;
			$inv_id = $this->trans_id;
			$dsc    = "e-base.ru: Электронные товары в Беларуси!";
			$adr    = "Заказ: http://www.e-base.ru/check.php?sid=$this->sid";

			// Вызов сервисной функции модуля wm
			list($wminvc_n, $err) = InvCreate($wmid, $summ, $inv_id, $dsc, $adr);
 


			if ($wminvc_n>0)
				{ 
				$this->send_t_msg("Счет №$this->trans_id выписан успешно ,№ заказа WebMoney: $wminvc_n"); 
				$query = mysql_query("UPDATE transactions SET status ='0',order_id = '$wminvc_n' WHERE trans_id = '$this->trans_id'") OR die(mysql_error());
				
				}
			else
				{ 
				//сохраняем сообщение
				$this->send_t_msg("Ошибка выписки инвойса №$this->trans_id : $err"); 
			}


//		}
	
	return array($wminvc_n,$err);
	}


	//**********************************************************************************
	// ******  Проверка состояния выписанного счета   ************************************
	//***********************************************************************************
	
function check_order_status($sid){
		$this->sid = $sid;
		
		$this->get_trans($this->sid); //извлекаем данные о транзакции из БД
		$webmoney_answer = InvCheck(0, $this->in_account, $this->order_id);
	//	$webmoney_answer = 2;		
		if ( ($webmoney_answer == 2) && ($this->status == 0) ){ //когда ждем оплаты 
			$this->send_t_msg("Получили оплату");				// и webmoney говорит "счет оплачен"
			$this->change_tran_status(T_MONEY_R);
			
		}
		elseif ( ($webmoney_answer == -1) && ($this->status == T_INVOICE_SENT) ){//когда ждем оплаты 
			$this->send_t_msg("Инвойс удален");						//и wm говорит "счет удален"
			$this->change_tran_status(T_INVOICE_KILLED);
			
		}
		elseif (($webmoney_answer == -2) && ($this->status == T_INVOICE_SENT) ) { //если глюки у webmoney
			$this->send_t_msg("Ошибка проверки состояния инвойса №$this->trans_id : $err"); 
			$this->status = T_ERROR;
		}
		elseif ( ($webmoney_answer == 2) && ($this->status == T_MONEY_NOT_R) ){ //когда уже время оплаты истекло,
			$this->send_t_msg("Получили оплату");				// а деньги пришли
			$this->change_tran_status(T_MONEY_R_AFTER);
		}
				
		return array($webmoney_answer,$this->order_id,$this->in_account,$this->status,$this->time_start,$this->time_end,$this->sum,$this->is_proceed); 
		//возвращаем информацию

	}
	
	
	
	
	
	
	//Извлечение данных о существующей транзакции
	function	get_trans(){
		$sid = $this->sid;
		$sql = "SELECT t.email,t.PinT_id,t.trans_id, t.cur_id,t.in_account,t.sum,t.status,t.order_id,t.time_start,t.time_end FROM transactions AS t WHERE session_id = '$sid' limit 1";
		$query = mysql_query($sql) OR die(mysql_error());
		if(!mysql_num_rows($query)) error_msg("Ошибка!");
		$db_array = mysql_fetch_array($query);
		$this->cur_id = $db_array['cur_id'];
		$this->in_account = $db_array['in_account'];
		$this->sum = $db_array['sum'];
		$this->order_id = $db_array['order_id'];
		$this->status = $db_array['status'];
		$this->time_end = $db_array['time_end'];
		$this->time_start = $db_array['time_start'];
		$this->trans_id = $db_array['trans_id'];
		$this->email = $db_array['email'];
		$this->PinT_id = $db_array['PinT_id'];
		$this->is_true = 1;
		if($db_array['pin_id'] >0) $this->is_proceed = 1;
		else  $this->is_proceed = 0;
//		$this->check_unpayed_trans(); //установим статус "неоплаченные в срок" (-1) тем, кто не оплатил.
		
		

	}

	/*
	Функция, проверяющая истекло ли время действия транзакции,
	у которой не выписан invoice(т.е $status = 20)
	*/
	function check_trans_time(){
		if( ($this->status == 20) && ( ($this->time_start+$this->wait_trans) < time() ) ){ //если время ожидания вышло..		
					$this->trans_ok = 0;
		}
	}
	/*
	Функция, устанавливающая статус транзакциям,
	которым был выслан invoice и он был не оплачен 
	в течении определнного времени , в -1 (т.е. 
	неоплаченные в срок)
	*/

	function check_unpayed_trans(){
		//делаем проверку каждые 5 min
		$query = mysql_query("SELECT time_trans_clr FROM config") OR die(msql_error());
		$row = mysql_fetch_row($query);
		if( ($row[0] + UPDATE_TRANS_TIME) <  time()  ) {
			
			$t_mnr = T_MONEY_NOT_R;
			$t_is = T_INVOICE_SENT;
			$sql = "UPDATE transactions SET status = '$t_mnr' WHERE time_end  < unix_timestamp() AND status = '$t_is'";
			$query  = mysql_query($sql) OR die(mysql_error());
			$query = mysql_query("UPDATE config SET time_trans_clr = unix_timestamp()") OR die(mysql_error());
		}
			
	}
	
	
	
	function	get_trans_status(){
		return $this->trans_ok;
	}
	
	function get_trans_id(){
	return $this->trans_id;
	}
	
	
	
	function	get_timing(){
		return array($this->time_start,$this->time_end);
	}
	function	get_status(){
		return	$this->status;
	}

	function sid(){
		 $this->sid =  md5(uniqid(rand(), true));
		 return $this->sid;
	}
	
	function get_sid(){
	return $this->sid;
	}
/*---------------------------------
----   Создание сообщения    -----
----  $t_message - тело мессаги
-----  
--------------------------------
*/
	function	send_t_msg($t_message){
		$sid = $this->sid;	
		if(!$sid) error_msg("Внутрення ошибка");
		$sql = "INSERT INTO t_messages (session_id,session_ip,t_message,t_time) values ('$sid','$this->user_ip','$t_message', unix_timestamp())";
		$query = mysql_query($sql) OR die(mysql_error());

	}
	/*
	Функция, которая проверяет можно ли создавать новую транзакцию 
	с указанными типом товара($PinT_id) в зависимости количества высланных
	счетов на данный товар и количества товаров в наличии
	т.е. сумма, высланных счетов ($PinT_id) < сумма товаров типа PinT_id
	Аргумент: id типа товара
	возврашает True or False
	*/
	function is_can_create($PinT_id){
		$this->is_aval_flag = 0; //флаг, показывающий, есть ли вообще пины такого типа, 
								// без разницы выслали на них счета или нет.
		//проверяем значение флага is_active, работаем с данным типом валюты или нет
		$sql = "SELECT PinT_id,PinT_des FROM pin_types WHERE PinT_id = '$PinT_id' AND is_active = 1";
		if(!$rez = mysql_query($sql)) die(mysql_error());
		if($nn = mysql_num_rows($rez)){
			$arr = mysql_fetch_array($rez);
			$pin_des = $arr['PinT_des'];
			$sql = "SELECT  count(trans_id) FROM transactions WHERE PinT_id = '$PinT_id' AND (status = 0 OR status = 1)";
			$rez1 = mysql_query($sql) OR die(mysql_error());
			$row = mysql_fetch_row($rez1);
			$t_count = $row[0];

		
			$sql2 = "SELECT  count(pin_id) FROM pin_list WHERE PinT_id = '$PinT_id' AND used = 0";
			$rez2 = mysql_query($sql2) OR die(mysql_error());
			$row = mysql_fetch_row($rez2);
			$p_count = $row[0];
			if($p_count>0) $this->is_aval_flag = 1;
			if($p_count > $t_count)	return true;
			else return false;
				
		}
		else return false;
		

	}

	function get_pin(){
		
		$sql = "SELECT pin_id,pin_content FROM pin_list WHERE used = 0 AND pinT_id = '$this->PinT_id' limit 1"; //достаем из базы pin
		$rez = mysql_query($sql) OR die(mysql_error());
		if(mysql_num_rows($rez) == 0){
			$this->send_t_msg("Отсутствуют пины!!!");
			return 0;
		}else{
			$row = mysql_fetch_row($rez);
			$pin_content = $row[1];
			$pin_id = $row[0];
			$sid = $this->sid;
			$sql = "UPDATE pin_list SET used = 1 WHERE pin_id = '$pin_id';";//говорим, что пин уже заюзан
			$sql2 = "UPDATE transactions SET pin_id = '$pin_id'  WHERE session_id = '$sid';";
			$rez = mysql_query($sql) or die(mysql_error());
			$rez2 = mysql_query($sql2) or die(mysql_error());
			$this->send_t_msg("пин №$pin_id пошел в печать!");
			$this->change_tran_status(T_PIN_GIVEN);
			//пошлем его по webmoney mail
			$msg = "Ваши заказ $this->pin_des  $pin_content.\r\n  Спасибо за покупку!\r\n\r\n          С уважением, администрация e-Base.ru";
			$a = SendMsg($this->in_account,$msg);
			$this->send_t_msg("Послали пин по Webmoney-почте: $this->in_account, ответ: $a");
			if( mail("$this->email", "Заказ на www.e-Base.ru", $msg,
				     "From: support@e-base.ru\r\n"
				    ."Reply-To: support@e-base.ru\r\n")) 	$this->send_t_msg("Послали пин на e-mail: $this->email");
			else{
					$this->send_t_msg("Не смогли послать по электронной почте");
			}
			
			return $pin_content;
		}
	}

	//если время прошло.
	function get_pin_after(){
	
		if( $this->is_can_create($this->PinT_id) == true){
			return ($this->get_pin() );
		}
		else return 0;
	}

	
	function get_is_aval_flag(){
		return $this->is_aval_flag;
	}
	

}




?>