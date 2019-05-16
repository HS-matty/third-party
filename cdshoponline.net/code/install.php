<?
	//соединиться с БД
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	mysql_query("CREATE TABLE Users (Login CHAR(20), Password CHAR(15), Email CHAR(30), Country CHAR(40), City CHAR(40), Address CHAR(50), Phone CHAR(20), Fullname CHAR(40))") or die (mysql_error());
	mysql_query("CREATE TABLE Orders (User CHAR(20), Payment CHAR(20), Comment CHAR(20), OrderTime CHAR(30), OID INT PRIMARY KEY AUTO_INCREMENT)") or die (mysql_error());
	mysql_query("CREATE TABLE OrderedCarts (GID INT, Quantity INT, OID INT)") or die (mysql_error());
	mysql_query("CREATE TABLE GoodsList (CID INT, ID INT PRIMARY KEY AUTO_INCREMENT, Name CHAR(200), Description TEXT, Popularity FLOAT, Price FLOAT, Picture CHAR(40), LeftInWarehouse INT, SmallPic CHAR(40), Votes INT, Sold INT)") or die (mysql_error());
	mysql_query("CREATE TABLE Categories (CID INT PRIMARY KEY AUTO_INCREMENT, Name CHAR(30), Parent INT, GoodsCount INT)") or die (mysql_error());
	mysql_query("CREATE TABLE Carts (User CHAR(20), GID INT, Quantity INT)") or die (mysql_error());

	//создать и удалить категорию и товар (чтобы не было ни товара, ни категории с ключами 0)
	mysql_query("INSERT INTO Categories VALUES (0,'',0,0)") or die (mysql_error());
	$id = mysql_insert_id();
	mysql_query("DELETE FROM Categories WHERE CID=$id") or die (mysql_error());

	mysql_query("INSERT INTO GoodsList VALUES (0,0,'','',0,0,'',0,'',0,0)") or die (mysql_error());
	$id = mysql_insert_id();
	mysql_query("DELETE FROM GoodsList WHERE ID=$id") or die (mysql_error());


?>
Installation completed successfully ))<br>
Run <a href="index.php">index.php</a>