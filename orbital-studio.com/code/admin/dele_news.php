<?
include('../functions.php');
db_connect("localhost");
mysql_select_db("orb_news") or die('couldnt choose db!');
$sql="DELETE from news where news_id=$news_id";
$result=mysql_query($sql) or die('couldnt delete');
echo "<META HTTP-EQUIV=\"refresh\" content=\"1;URL=index.php\">";
?>

