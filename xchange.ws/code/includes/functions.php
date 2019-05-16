<?

function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

//функция создает сессию и пишет ее в базу. Возвращает session_id

function create_session($p_id,$user_ip){

	$session_id = md5(uniqid(rand(), true));
	$sql = "INSERT into sessions(session_id,session_ip,session_start,partner_id) values 				 	('$session_id','$user_ip',UNIX_TIMESTAMP(),'$p_id')";
	if(!$result = mysql_query($sql)) die();
	return $session_id;
}


function check_user_ip(){
	if ((getenv('HTTP_X_FORWARDED_FOR') != '')) return (getenv('HTTP_X_FORWARDED_FOR'));
	else return getenv('REMOTE_ADDR');
	
}

function kill_inactive_sessions ($session_lifetime){

	$sql = "DELETE FROM sessions WHERE session_start<unix_timestamp()-$session_lifetime";
	if(!$result = mysql_query($sql)) die(mysql_error());

}

function error_msg($msg){
	if(!isset($msg)) $msg = "";
	print("<div align='center'><font color='red'>Error!</font><br>$msg<br>");
	exit;
}

/*  данной функцией мы расчитываем 
 *  максимальный размер обмена и время ожидания 
 *  для каждой  сделки
 */
function max_change($out_cur_id,$out_money_left,&$db){

	$sum_time = array(); // массив, где будут находится [0] - максим. сумма,[1] - время ожидания.
	if( (!$out_cur_id) || (!$out_money_left) ) error_msg("Не хватает параметров!");

	if(!$db) error_msg("There is no connection to db!");
// делаем запрос 
	$sql = "SELECT sum(out_sum) AS total_sum FROM transactions WHERE out_cur_id = '$out_cur_id' AND status = 1";
	if(!$query = mysql_query("$sql"))	die(mysql_error());

	$row = mysql_fetch_row($query) OR die();
	if($row[0] > $out_money_left) {
		create_msg("общибка опять!",0,0);
		$max_sum = 0;
		$max_time = 0;
	}else{
	
	$max_sum = $out_money_left;
	$max_time = 30;

	
	
	}
		
return	array($max_sum,$max_time);
}

/*
Функция создает системные сообщения и 
пишет  их в бд.

*/

function	create_msg($msg,$type){

	if(!$type) $type = COMMON;
	
	$sql = "INSERT INTO messages (msg_type_id,msg_time,msg_body) values ('$type','unix_timestamp()','$msg')";
	if(!$query = mysql_query($sql)) die(mysql_error());

}

function	check_admin_session($u_sid){
	$cur_ip = encode_ip(check_user_ip());
	$u_sid = substr(htmlspecialchars($u_sid),0,32);
	$query = mysql_query("SELECT u_ip,time_login,time_logout FROM users_sessions WHERE u_sid = '$u_sid'") OR die();
	if(!mysql_num_rows($query)) die();
	else {
		$db_array = mysql_fetch_array($query);	
		if( ($db_array['time_logout'] != 0) || ($db_array['time_login']+1800<time() ) ) {
			$cur_ip = decode_ip($cur_ip);
			create_msg("Old sid login attempt! ses_ip: user_ip: $cur_ip" ,3);
			die();

		}
		
		if($db_array['u_ip'] != $cur_ip) {
			$db_array['u_ip'] = decode_ip($db_array['u_ip']);
			$cur_ip = decode_ip($cur_ip);
			$u_ip = $db_array['u_ip'];
			create_msg("ADMIN IP ALERT! ses_ip: $u_ip, user_ip: $cur_ip" ,3);
			die();
		}
		
		return $u_sid;
	}
	
}







?>