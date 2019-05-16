<? 
include('functions.php');
include('header.php');
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">";
db_connect("localhost");

mysql_select_db("orb_news") or die (mysql_error());

$result=mysql_query("SELECT * from news ");
 $row_num=mysql_num_rows($result);


for ($i=0; $i<$row_num; $i++)
	{
		$db_array=mysql_fetch_array($result) or die (error_msg());		
		
	$db_array["news_text"] = str_replace("<BR>","\n", $db_array["news_text"]);
	$db_array['author']=stripslashes($db_array['author']);
	$db_array['headline']=stripslashes($db_array['headline']);
	$db_array['news_text']=stripslashes($db_array['news_text']);		
echo "<div align='center'><table width='70%' border='0' cellspacing='0' cellpadding='0'> <tr bgcolor='#BABDDE'> <td width='20%'>";
echo "<div align='center'>$db_array[created]</div>";
echo "</td><td><div align='center'>$db_array[headline]</div></td><td width='30%'>";
echo "<div align='center'>$db_array[author]</div>";
echo "</td></tr><tr><td colspan='3'>$db_array[news_text]<br><br></td></tr></table></body></html></div>";
		
		

			
	}
	
include('footer.php');
?>