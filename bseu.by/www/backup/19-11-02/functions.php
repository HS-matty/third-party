<?





function connectdb(){
	$db=mysql_connect() or die (mysql_error());
	$db_name='my_shop';
	mysql_select_db("$db_name") or die (mysql_error());
}

function cart_status($cart){

		$z=count($cart);
		if (!$z) return 'empty';
		elseif ($z==1) return "$z item";
		else return "$z items";
	}