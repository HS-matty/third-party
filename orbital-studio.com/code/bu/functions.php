<?

#----------------
#переменные-----
#---------------
global $news_id;
global $db;


#---------------------
#коннектимся к bd ----
#---------------------
function db_connect($dbname)
{ 
 $db=mysql_pconnect($dbname) ;
	if (!$db){
	echo "Error!!!";
	exit;
	}			
}

function error_msg()
	{
	echo "<b>error was";
	echo mysql_error();
}
?>

