<?
if(!defined('WE_ARE_HERE'))  die();

include("wm.inc");
include("wmconst.inc");
define('UPDATE_TRANS_TIME',30);
define('ADD_TIME',60);//�����, ������� ������ ����� ����, ��� ����������� ��� ����������


class trans{
	
	var	$is_true=0;//�����-��, ������������ ��������� �� �� ���������� � ����������
	var	$user_ip;  // ip �������
	var	$sid;     // session_id ������� 
	var $in_cur_id; // id �������� ������
	var $in_account; // �������� ����� �����
	var $in_sum; // �������� �����
	var $out_cur_id; // �����. id
	var $out_account;
	var $out_sum;
	var $status; //������� ��������� ����������
	var $current_rate; //������� ���� ������
	var $time_end; //����� ��������� �������� ����������
	var $time_start; //����� ������ ����������.
	var $trans_id; // id ����������
	var	$db;
	var $wait_trans = 60; //����� ����� ����������, ���� �� ������� ����.
	var $trans_ok = 1; // 1 - ���������� ����� ����. 0 - �� ����� ���������� ������.

	function	trans ($db){
		$this->db = $db;
		$this->user_ip = encode_ip(check_user_ip());
		
			

	}

	
	// �������� ����� ����������.
	function create_trans($sid,$in_cur_id = 0, $in_account = 0,$in_sum = 0, $out_cur_id = 0, $out_account = 0,$out_sum = 0,$current_rate = 0,&$time_wait){
		//��������� ���������� � ��.
		$status = 20; //20 - '���������������� ����� ����������'
		$sql = "INSERT INTO transactions (session_id,in_cur_id,in_account,in_sum,out_cur_id,out_account,out_sum,session_ip,status,current_rate,time_start,time_end) values('$sid', '$in_cur_id', '$in_account', '$in_sum', '$out_cur_id', '$out_account','$out_sum','$this->user_ip','$status','$current_rate',unix_timestamp(),unix_timestamp()+'$time_wait')";
		if(!$query = mysql_query($sql)) die(mysql_error());
		$id = mysql_insert_id();		
		//�������� �� ������ �������.
		$query = mysql_query("DELETE  from sessions WHERE session_id = '$sid'");

		$this->send_t_msg("���������� �$id �������!",$sid);


	}

	function send_invoice($sid){
	$wm_z = 'Z498072289702';
	$wm_r = 'R994925331415';
	$wm_e = 'E871619364539';

		//���������, ���� �� ��������� ������ � ����������.
		if(!($this->is_true)) $this->get_trans($sid);//
		//������, � ����� ������ ����� invoice
		$query = mysql_query("SELECT cur_sname FROM currencies WHERE cur_id = '$this->in_cur_id'") OR die(mysql_error());
		$db_array = mysql_fetch_row($query);
		
		if(($db_array[0] == 'wmz') || ($db_array[0] == 'wmr')){  //���� invoice � �� webmoney

			//���������� � ����� ������ ���������� ����.
			if($db_array[0] == 'wmz') $wmconst__shop_wmpurse = $wm_z; //WebmoneyZ
			if($db_array[0] == 'wmr') $wmconst__shop_wmpurse = $wm_r; //WebmoneyR
			if($db_array[0] == 'wme') $wmconst__shop_wmpurse = $wm_e; //WebmoneyE

			$wmid   = $this->in_account;
			$summ   = $this->in_sum;
			$inv_id = $this->trans_id;
			$dsc    = "e-base.ru online exchange";
			$adr    = "http://www.e-base.ru/change.php?sid=$sid";

			// ����� ��������� ������� ������ wm
			list($wminvc_n, $err) = InvCreate($wmid, $summ, $inv_id, $dsc, $adr);
 


			if ($wminvc_n>0)
				{ 
				$this->send_t_msg("���� �$this->trans_id ������� ������� ,� ����� WebMoney: $wminvc_n",$sid); 
				print("<br>id  = $this->trans_id");
			
				$query = mysql_query("UPDATE transactions SET status ='0',time_end = (unix_timestamp() - '$this->time_start') + '$this->time_end' WHERE trans_id = '$this->trans_id'") OR die(mysql_error());

				}
			else
				{ 
				//��������� ���������
				$this->send_t_msg("������ ������� ����� �$this->trans_id : $err",$sid); 
				//������� ����������


			}


		}
	
	return $err;
	}


	//���������� ������ � ������������ ����������
	function	get_trans(&$sid){

		$sql = "SELECT t.trans_id, t.in_cur_id,t.in_account,t.in_sum,t.out_cur_id,t.out_account,t.out_sum,t.status,t.current_rate,t.time_start,t.time_end FROM transactions AS t WHERE session_id = '$sid'limit 1";
		$query = mysql_query($sql) OR die(mysql_error());
		$db_array = mysql_fetch_array($query);
		$this->in_cur_id = $db_array['in_cur_id'];
		$this->in_account = $db_array['in_account'];
		$this->in_sum = $db_array['in_sum'];
		$this->out_cur_id = $db_array['out_cur_id'];
		$this->out_account = $db_array['out_account'];
		$this->out_sum = $db_array['out_sum'];
		$this->status = $db_array['status'];
		$this->current_rate = $db_array['current_rate'];
		$this->time_end = $db_array['time_end'];
		$this->time_start = $db_array['time_start'];
		$this->trans_id = $db_array['trans_id'];
		$this->is_true = 1;
		$this->check_trans_time(); //��������, ������� �� ����� �������� ���������� ��� ������� invoice
		$this->check_unpayed_trans(); //��������� ������ "������������ � ����" (-1) ���, ��� �� �������.
		
		

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

			$sql = "UPDATE transactions SET status = '-1' WHERE time_end + 60 < unix_timestamp() AND status='0'";
			$query  = mysql_query($sql) OR die(mysql_error());
			$query = mysql_query("UPDATE config SET time_trans_clr = unix_timestamp()") OR die(mysql_error());
		}
			
	}
	
	
	
	function	get_trans_status(){
		return $this->trans_ok;
	}
	
	function get_in_cur() {
		return array($this->in_cur_id,$this->in_account,$this->in_sum);
	}
	
	function get_out_cur() {
		return array($this->out_cur_id, $this->out_account, $this->out_sum);
	}
	
	function	get_rate(){
		return $this->current_rate;
	}
	
	function	get_timing(){
		return array($this->time_start,$this->time_end);
	}
	function	get_status(){
		return	$this->status;
	}
	

	function test(){
	die();

	}

	function	send_t_msg($t_message,&$sid){
	
		
		$sql = "INSERT INTO t_messages (session_id,session_ip,t_message,t_time) values ('$sid','$this->user_ip','$t_message', unix_timestamp())";
		$query = mysql_query($sql) OR die(mysql_error());

	}




}




?>