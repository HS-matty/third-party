<?
/*
/	MAIN TRANSACTION CLASS by rabbit
/	last updated 28 ������ 2004 �. 17:09:30
/
*/
if(!defined('WE_ARE_HERE'))  die();

require("wm.inc");
require("wmconst.inc");
define('UPDATE_TRANS_TIME',120); // �����, ����� ������� ����� ���������� �������-�������� ����������,
								//������� ��������� ����������, �� ���������� � ����, � ������ T_MONEY_NOT_R
define('WAIT_TIME',1800); //����� �������� ������


class trans{
	var $t_msg;
	var $num_from_ip = 5; //���-�� ������� � ������ IP
	var	$is_true=0;//�����-��, ������������ ��������� �� �� ���������� � ����������
	var	$user_ip;  // ip �������
	var $sid;
	var $in_account; // �������� ����� �����
	var $sum; // �������� �����
	var $cur_id; // ������������� ������
	var $order_id; //����� �����  � ������� Webmoney
	var $status; //������� ��������� ����������
	var $current_rate; //������� ���� ������
	var $time_end; //����� ��������� �������� ����������
	var $time_start; //����� ������ ����������.
	var $trans_id; // �����  ����������
	var	$db;
	var $is_proceed = 0; // 0 - �� ��������� ������, 1 - ���������
	var $trans_ok = 1; // 1 - ���������� ����� ����. 0 - �� ����� ���������� ������.
	var $PinT_id = 0; //��� ����� (����)
	var $email;
	var $is_aval_flag = 0; // ����
	var $pin_des; //�������� ���� ����

	function	trans ($db){
		$this->db = $db;
		$this->user_ip = encode_ip(check_user_ip());
		
			

	}

	//��������� ������� ����������.
	function change_tran_status($new_status){
		/*
		��������� ������� ����������
		T_CREATED - ���������� �������
		T_INVOICE_SENT - ������ �������
		T_MONEY_NOT_R  - ������ �� ������� �� �������� � ����
		T_MONEY_R  - ������ �� ������� ��������
		T_INVOICE_KILLED - ������ ������
		T_ERROR - ������ ����������
		T_PIN_GIVEN  - ������ �����
		*/
		
		if(!($new_status) || (!$this->sid)) error_msg("���������� ������");
		$query = mysql_query("UPDATE transactions SET status ='$new_status' WHERE session_id = '$this->sid'") OR die(mysql_error());
		$rez = mysql_query("SELECT descr FROM t_status WHERE status = '$new_status'");
		$new_status_msg = mysql_fetch_row($rez);
		$this->send_t_msg("������� ������ ��������� � $this->trans_id �� [$new_status_msg[0]]");
		$this->status = $new_status;
	}
	
	
	
	// �������� ����� ����������.
	function create_trans($PinT_id,$cur_id, $in_account,$sum,$email=0){
		//�������� �� ���������� ���������� ������������ ������ � ������ Ip
		 $this->num_tr_byip();
		//��������� ���������� � ��.
		$this->cur_id = $cur_id;
		$this->in_account = $in_account;
		$this->sum = $sum;
		$this->email = $email;
		$time_wait = WAIT_TIME;
					
		$sid = $this->sid();
		$status = 20; //20 - '���������������� ����� ����������'
		$sql = "INSERT INTO transactions (PinT_id,session_id,in_account,cur_id,sum,session_ip,status,time_start,time_end,email) values('$PinT_id','$sid','$in_account','$cur_id', '$sum','$this->user_ip','$status',unix_timestamp(),unix_timestamp()+ '$time_wait','$email')";

		if(!$query = mysql_query($sql)) die(mysql_error());
		$this->trans_id = mysql_insert_id();		
		//�������� �� ������ �������.
	//	$query = mysql_query("DELETE  from sessions WHERE session_id = '$sid'");
		$this->send_t_msg("���������� �$this->trans_id �������!");
	}

	function num_tr_byip(){
		$sql = "SELECT count(*) FROM transactions WHERE session_ip = '$this->user_ip' AND status = 0";
		$rez = mysql_query($sql) OR die(mysql_error());

		$row = mysql_fetch_row($rez);
//		print("row is $row[0]");

		if ($row[0] > $this->num_from_ip) error_msg("���� ��� ���� ������� ��������� �������!");
				
	}

	function send_invoice(){

	$wm_z = 'Z498072289702';
	$wm_r = 'R994925331415';
	$wm_e = 'E871619364539';

		//���������, ���� �� ��������� ������ � ����������.
//		if(!($this->is_true)) $this->get_trans($this->sid);//
		//������, � ����� ������ ����� invoice
	//	$query = mysql_query("SELECT cur_sname FROM currencies WHERE cur_id = '$this->in_cur_id'") OR die(mysql_error());
	//	$db_array = mysql_fetch_row($query);
		
	//	if(($db_array[0] == 'wmz') || ($db_array[0] == 'wmr')){  //���� invoice � �� webmoney

			//���������� � ����� ������ ���������� ����.
	//		if($db_array[0] == 'wmz') $wmconst__shop_wmpurse = $wm_z; //WebmoneyZ
	//		if($db_array[0] == 'wmr') $wmconst__shop_wmpurse = $wm_r; //WebmoneyR
	//		if($db_array[0] == 'wme') $wmconst__shop_wmpurse = $wm_e; //WebmoneyE
		
			$wmconst__shop_wmpurse = $wm_z;
			$wmid   = $this->in_account;
			$summ   = $this->sum;
			$inv_id = $this->trans_id;
			$dsc    = "e-base.ru: ����������� ������ � ��������!";
			$adr    = "�����: http://www.e-base.ru/check.php?sid=$this->sid";

			// ����� ��������� ������� ������ wm
			list($wminvc_n, $err) = InvCreate($wmid, $summ, $inv_id, $dsc, $adr);
 


			if ($wminvc_n>0)
				{ 
				$this->send_t_msg("���� �$this->trans_id ������� ������� ,� ������ WebMoney: $wminvc_n"); 
				$query = mysql_query("UPDATE transactions SET status ='0',order_id = '$wminvc_n' WHERE trans_id = '$this->trans_id'") OR die(mysql_error());
				
				}
			else
				{ 
				//��������� ���������
				$this->send_t_msg("������ ������� ������� �$this->trans_id : $err"); 
			}


//		}
	
	return array($wminvc_n,$err);
	}


	//**********************************************************************************
	// ******  �������� ��������� ����������� �����   ************************************
	//***********************************************************************************
	
function check_order_status($sid){
		$this->sid = $sid;
		
		$this->get_trans($this->sid); //��������� ������ � ���������� �� ��
		$webmoney_answer = InvCheck(0, $this->in_account, $this->order_id);
	//	$webmoney_answer = 2;		
		if ( ($webmoney_answer == 2) && ($this->status == 0) ){ //����� ���� ������ 
			$this->send_t_msg("�������� ������");				// � webmoney ������� "���� �������"
			$this->change_tran_status(T_MONEY_R);
			
		}
		elseif ( ($webmoney_answer == -1) && ($this->status == T_INVOICE_SENT) ){//����� ���� ������ 
			$this->send_t_msg("������ ������");						//� wm ������� "���� ������"
			$this->change_tran_status(T_INVOICE_KILLED);
			
		}
		elseif (($webmoney_answer == -2) && ($this->status == T_INVOICE_SENT) ) { //���� ����� � webmoney
			$this->send_t_msg("������ �������� ��������� ������� �$this->trans_id : $err"); 
			$this->status = T_ERROR;
		}
		elseif ( ($webmoney_answer == 2) && ($this->status == T_MONEY_NOT_R) ){ //����� ��� ����� ������ �������,
			$this->send_t_msg("�������� ������");				// � ������ ������
			$this->change_tran_status(T_MONEY_R_AFTER);
		}
				
		return array($webmoney_answer,$this->order_id,$this->in_account,$this->status,$this->time_start,$this->time_end,$this->sum,$this->is_proceed); 
		//���������� ����������

	}
	
	
	
	
	
	
	//���������� ������ � ������������ ����������
	function	get_trans(){
		$sid = $this->sid;
		$sql = "SELECT t.email,t.PinT_id,t.trans_id, t.cur_id,t.in_account,t.sum,t.status,t.order_id,t.time_start,t.time_end FROM transactions AS t WHERE session_id = '$sid' limit 1";
		$query = mysql_query($sql) OR die(mysql_error());
		if(!mysql_num_rows($query)) error_msg("������!");
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
//		$this->check_unpayed_trans(); //��������� ������ "������������ � ����" (-1) ���, ��� �� �������.
		
		

	}

	/*
	�������, ����������� ������� �� ����� �������� ����������,
	� ������� �� ������� invoice(�.� $status = 20)
	*/
	function check_trans_time(){
		if( ($this->status == 20) && ( ($this->time_start+$this->wait_trans) < time() ) ){ //���� ����� �������� �����..		
					$this->trans_ok = 0;
		}
	}
	/*
	�������, ��������������� ������ �����������,
	������� ��� ������ invoice � �� ��� �� ������� 
	� ������� ������������ ������� , � -1 (�.�. 
	������������ � ����)
	*/

	function check_unpayed_trans(){
		//������ �������� ������ 5 min
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
----   �������� ���������    -----
----  $t_message - ���� �������
-----  
--------------------------------
*/
	function	send_t_msg($t_message){
		$sid = $this->sid;	
		if(!$sid) error_msg("��������� ������");
		$sql = "INSERT INTO t_messages (session_id,session_ip,t_message,t_time) values ('$sid','$this->user_ip','$t_message', unix_timestamp())";
		$query = mysql_query($sql) OR die(mysql_error());

	}
	/*
	�������, ������� ��������� ����� �� ��������� ����� ���������� 
	� ���������� ����� ������($PinT_id) � ����������� ���������� ���������
	������ �� ������ ����� � ���������� ������� � �������
	�.�. �����, ��������� ������ ($PinT_id) < ����� ������� ���� PinT_id
	��������: id ���� ������
	���������� True or False
	*/
	function is_can_create($PinT_id){
		$this->is_aval_flag = 0; //����, ������������, ���� �� ������ ���� ������ ����, 
								// ��� ������� ������� �� ��� ����� ��� ���.
		//��������� �������� ����� is_active, �������� � ������ ����� ������ ��� ���
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
		
		$sql = "SELECT pin_id,pin_content FROM pin_list WHERE used = 0 AND pinT_id = '$this->PinT_id' limit 1"; //������� �� ���� pin
		$rez = mysql_query($sql) OR die(mysql_error());
		if(mysql_num_rows($rez) == 0){
			$this->send_t_msg("����������� ����!!!");
			return 0;
		}else{
			$row = mysql_fetch_row($rez);
			$pin_content = $row[1];
			$pin_id = $row[0];
			$sid = $this->sid;
			$sql = "UPDATE pin_list SET used = 1 WHERE pin_id = '$pin_id';";//�������, ��� ��� ��� ������
			$sql2 = "UPDATE transactions SET pin_id = '$pin_id'  WHERE session_id = '$sid';";
			$rez = mysql_query($sql) or die(mysql_error());
			$rez2 = mysql_query($sql2) or die(mysql_error());
			$this->send_t_msg("��� �$pin_id ����� � ������!");
			$this->change_tran_status(T_PIN_GIVEN);
			//������ ��� �� webmoney mail
			$msg = "���� ����� $this->pin_des  $pin_content.\r\n  ������� �� �������!\r\n\r\n          � ���������, ������������� e-Base.ru";
			$a = SendMsg($this->in_account,$msg);
			$this->send_t_msg("������� ��� �� Webmoney-�����: $this->in_account, �����: $a");
			if( mail("$this->email", "����� �� www.e-Base.ru", $msg,
				     "From: support@e-base.ru\r\n"
				    ."Reply-To: support@e-base.ru\r\n")) 	$this->send_t_msg("������� ��� �� e-mail: $this->email");
			else{
					$this->send_t_msg("�� ������ ������� �� ����������� �����");
			}
			
			return $pin_content;
		}
	}

	//���� ����� ������.
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