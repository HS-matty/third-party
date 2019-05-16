<title> Admin page--->Главная</title>
<?




include("../functions.php");
db_connect("localhost");
global $news_id;
mysql_select_db("orb_news") or die('couldnt choose db!');



##########################
#показываем список новостей
###########################

$sql='select  * from news';
$sql_result=mysql_query($sql);
$row_num=mysql_num_rows($sql_result);


echo "<form name='form' method='post' action='index.php'>"; 

?>
<body bgcolor="#FFFFFF" text="#000000">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#009900"> 
    <td width="30%" class="menu"> 
      <div align="center" class="menu">заголовок новости</div>
    </td>
    <td class="menu" width="15%"> 
      <div align="center">автор</div>
    </td>
    <td class="menu" width="15%"> 
      <div align="center">дата созд.</div>
    </td>
    <td class="menu" width="15%"> 
      <div align="center">дата изм.</div>
    </td>
    <td class="menu"> 
      <div align="center">действия</div>
    </td>
  </tr>
<?

for ($i=0; $i<$row_num; $i++)
			{
				$db_array=mysql_fetch_array($sql_result);
				$db_array['headline']=stripslashes($db_array['headline']);



	echo	"<tr bgcolor=\"#F2F2F2\">"; 
	echo    "<td class='menu2'>$db_array[headline]</td>";
	echo    "<td class='menu2' align='center'>$db_array[author]</td>";
    echo	"<td class='menu2' align='center'>$db_array[created]</td>";
    if (!$db_array['modified']){
		echo "<td class='menu2' align='center'>not modified</td>";
	}else{
	echo		"<td class='menu2' align='center'>$db_array[modified]</td>";
			}
	echo    "<td class='menu2' align='center'> ";
	echo    "<a href=\"dele_news.php?news_id=$db_array[news_id]\">удалить</a> || ";
	echo    "<a href=\"edit.php?news_id=$db_array[news_id]\">изменить</a></td></tr>";
}



include('admin_footer.php');		

?>