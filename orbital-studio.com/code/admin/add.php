<? 
include("../functions.php");

db_connect("localhost");
global $news_id;
mysql_select_db("orb_news") or die('couldnt choose db!');

if (!isset($author) || !isset($headline) || !isset($news_text)){
include("admin_header.php");
	?>
<title> Admin page--->Добавляем новость</title>
<BODY>
<form action="add.php" method="post" class="unnamed1">
<table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr> 
      <td width="20%" bgcolor="#009900"> 
        <div align="center" class="menu">заголовок новости</div>
      </td>
      <td> 
        <input type="text" name="headline" value="" size="40" maxlength="50">
      </td>
    </tr>
    <tr> 
      <td width="20%" bgcolor="#009900"> 
        <div align="center" class="menu">автор</div>
      </td>
      <td> 
        <input type="text" name="author" maxlength="20" size="15">
      </td>
    </tr>
    <tr>
      <td width="20%" bgcolor="#009900">
        <div align="center" class="menu">текст новости</div>
      </td>
      <td>
        <textarea name="news_text" ROWS="10" COLS="50"></textarea>
      </td>
    </tr>
  </table>
    <div align=center><INPUT TYPE="submit" value='добавить новость'></div>
</form>
</BODY>
</HTML>
	<?
include("admin_footer.php");	
	exit;}


$author=addslashes(htmlspecialchars("$author"));
$headline=addslashes(htmlspecialchars("$headline"));
$news_text=addslashes(htmlspecialchars("$news_text"));
$news_text = str_replace("\n", "<BR>", $news_text);
$created=date("d-m-y H:i");

$sql= "insert into news (author, headline,news_text,created,modified) 
values ('$author', '$headline', '$news_text','$created','0')";

$result=mysql_query($sql) or die('couldnt fetch');
echo "<META HTTP-EQUIV=\"refresh\" content=\"1;URL=index.php\">";






?>

