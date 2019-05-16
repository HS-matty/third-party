<?
include("../functions.php");
db_connect("localhost");
global $news_id;
mysql_select_db("orb_news") or die('couldnt choose db!');

if (isset($news_text_edited) || isset($headline_edited)){
$headline_edited=addslashes($headline_edited);
$news_text_edited=addslashes($news_text_edited);
$news_text_edited = str_replace("\n", "<BR>", $news_text_edited);
$modified=date("d-m-Y H:i");
$sql="UPDATE news SET headline = '$headline_edited' , news_text='$news_text_edited', modified='$modified'  WHERE (news_id='$news_id')";
	if (!$sql_result=mysql_query($sql)){
			echo "<h1>couldn't connect to server!</h1>";
			exit;
			}
			echo "<META HTTP-EQUIV=\"refresh\" content=\"1;URL=index.php\">";
	exit;
	}

if (isset($news_id)){
echo "<title> Admin page--->Редактируем новость</title>";	

	show_edit_news($news_id);
	
	exit;
	}

	
	function show_edit_news($news_id){
		include('admin_header.php');
		$sql="select * from news where news_id=$news_id";
		$sql_result=mysql_query($sql) or die(errormsg());
		$db_array=mysql_fetch_array($sql_result);
		$db_array["news_text"] = str_replace("<BR>","\n", $db_array["news_text"]);
		$db_array['author']=stripslashes($db_array['author']);
		$db_array['headline']=stripslashes($db_array['headline']);
		$db_array['news_text']=stripslashes($db_array['news_text']);


?>


<div align=center>  <table width="100%" border="0" cellspacing="1" cellpadding="1" height="10" >
<form name="edit_form" method="post" action="edit.php">
    <tr> 
      <td width="20%" bgcolor="#009900"> 
        <div align="center" class="menu">заголовок новости</div>
      </td>
      <td> 
        <input type="text" name=headline_edited size=30 maxlength='50' 
		<?
echo     " value=\"$db_array[headline]\" maxlength='50'>";
echo     "</td></tr><tr><td width=\"20%\" bgcolor=\"#009900\">"; 
echo     "<div align=\"center\" class=\"menu\">автор</div>";
echo	" </td><td>";
echo	  "$db_array[author]</b><br></td>";
echo     "</tr> <tr> <td width=\"20%\" bgcolor=\"#009900\">";

echo     "<div align=\"center\" class=\"menu\">текст новости</div>";
echo     " </td><td>";
echo "<textarea name='news_text_edited' ROWS='15' COLS='50'";
echo ">$db_array[news_text]</textarea><br>";
echo "<INPUT TYPE='submit' value='изменить'>";
echo "<INPUT TYPE='hidden' name='news_id' value=\"$db_array[news_id]\">";
echo "</td></tr></form></table></div><br>";
									
include('admin_footer.php');							
							
									
												
							
							
	
			


								}
	?>