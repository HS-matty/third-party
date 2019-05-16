<?php
	class ActionsLog{
	
		public function Log($Id,$Msg){
			
			global $Db;
			$Sql = "INSERT INTO bus_actionslog (id,log_msg) VALUES ('$Id','$Msg')";
			
			$Db->query($Sql);
			
		
		
		}
		
		public function &GetLogRecords($Id,$Word){
			global $Db;
			$Sql = "SELECT * FROM bus_actionslog WHERE id=$Id AND log_msg LIKE '%$Word%' ORDER BY log_timedate DESC";
			$Db->query($Sql);
			if($Db->rows()) return $Db->fetch_all_array();
			return 0;
		
		}
	
	}


?>