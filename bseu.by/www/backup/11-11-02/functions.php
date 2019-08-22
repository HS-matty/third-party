<?




function create_root(){
		$query=mysql_query("SELECT * FROM categories WHERE parent=0") or die(mysql_error()) ;
		$row_num=mysql_num_rows($query);
		for ($i=0; $i<$row_num;$i++){
			$db_array=mysql_fetch_array($query) or die(mysql_error());
			$root_array=array('$db_array[Name]=>$db_array[CID]');
#			$cat_name=$db_array['Name'];
#			$cid_=$db_array['CID'];
#			eval("\$navigation_left .= \"".$tpl->get("navigation")."\";"); 
			
			
		
			}
	}

function connectdb(){
	$db=mysql_connect() or die (mysql_error());
	$db_name='my_shop';
	mysql_select_db("$db_name") or die (mysql_error());
}





?>

		
