<? //����������������� ���� ������: ����������/�������������� �������, ���������, �������������
	session_start();

	//����������� � ��
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //������������������� ������! Alarm! ������� �� index.php
		exit;
	};

function processCategories($list, $parent,$level) { //������ ������� � �����������

	for ($i=0; $i<count($list); $i++)
	 if ($list[$i][2] == $parent) {

		//�������� ��� ��������� � �������
		echo "<tr><td>";
		for ($j=0; $j<$level; $j++) echo "&nbsp;&nbsp;";
		echo "&nbsp;<a";
		if ($level) echo " class=\"standard\"";
		echo " href=\"javascript:open_window('category.php?c_id=".$list[$i][0]."&w=".$list[$i][2]."',350,180);\">".str_replace("<","&lt;",$list[$i][1])."</a> (".$list[$i][3].")</td>\n"; //w -- CID �������� ������������� ���������
		echo "<td align=right><font color=red>[</font><a class=small href=\"admin.php?CID=".$list[$i][0]."&path=1\">=></a><font color=red>]</font></td></tr>\n";
		//���������� ��� ������������ ������
		processCategories($list, $list[$i][0],$level+1);
	 };

};

?>
<html>

<head>

<script> //java-������, ����������� ����� ���� ��� ��������������� ���������, �������, � �.�.
	function confirmDelete(oid) {
		temp = window.confirm('������� �����?');
		if (temp) { //�������
			window.location='admin.php?delete='+oid;
		};
	};
	function open_window(link,w,h) {
		var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
		newWin = window.open(link,'newWin',win);
	};
</script>

<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>�������������</title>
</head>

<body><center>
<h1>�������������</h1>

<?	//����� �� �� ���� ������ ���������
	$q = mysql_query("SELECT * FROM Categories ORDER BY Name;") or die (mysql_error());
	$cats = array(); $i=0;
	while ($row = mysql_fetch_row($q)) $cats[$i++] = $row;

	if (!isset($path) || $path<0 || $path>3) $path=0;

	if (isset($sys_save)) { //��������� ��������� ���������
		$f = fopen("cfg/settings.inc","w");
		fputs($f,"<?\n\t\$courseN = $curse1;\n");
		fputs($f,"\t\$courseB = $curse2;\n");
		fputs($f,"\t\$NSP = $tax;\n");
		fputs($f,"\t\$shopname = \"$shop_name\";\n");
		fputs($f,"\t\$shopurl = \"$shop_url\";\n?>");
		$path=0;
	};

	if ($path==0) { //�������� ������ ������� � ������ ��������

		if (isset($done)) { //���� ������ ������ "�����(�) ���������" -- ������� �� �� ������� Orders � ��������� �������
					//��������������� ������� �� ������ (LeftInWareHouse--)
			$vars = get_defined_vars();
			foreach ($vars as $key => $val)
			  if(strstr($key, "sel_") !== false) {
				$q = mysql_query("SELECT * FROM Orders WHERE OID=$val") or die (mysql_error());
				$row = mysql_fetch_row($q);
				$q = mysql_query("SELECT * FROM OrderedCarts WHERE OID=$val") or die (mysql_error());
				while ($r = mysql_fetch_row($q))
					mysql_query("UPDATE GoodsList SET LeftInWareHouse=LeftInWareHouse-$r[1], Sold=Sold+$r[1] WHERE ID=$r[0]") or die (mysql_error());
				mysql_query("DELETE FROM OrderedCarts WHERE OID=$val") or die (mysql_error());
				mysql_query("DELETE FROM Orders WHERE OID=$val") or die (mysql_error());
			  };
			
		}
		else if (isset($delete) && $delete) { //������� ����� ��� ���������� ������� ������� �� ������ (LeftInWareHouse)
				$q = mysql_query("DELETE FROM OrderedCarts WHERE OID=$delete") or die (mysql_error());
				mysql_query("DELETE FROM Orders WHERE OID=$delete") or die (mysql_error());
		};

?>

[ <a href="admin.php?path=1">������������� ������ � ���������</a> ]<br>
[ <a href="admin.php?path=2">����������</a> ]<br>
[ <a href="admin.php?path=3">��������� ���������</a> ]<br>

<? //������� �� ���� ������ ��� ������
	$q = mysql_query("SELECT * FROM Orders") or die (mysql_error());
	$result=array(); $i=0;
	while ($row = mysql_fetch_row($q)) $result[$i++] = $row;
	if ($i) {
?>
<form method=post action="admin.php">
<p><b><font>����� ������:</font></b></p>
<table width=95% border=0 cellspacing=1 cellpadding=2 bgcolor=#DDDDDD>
<tr bgcolor=#CCCCCC>
<td><b>��������</b></td><td><b>E-mail</b></td><td><b>�����</b></td><td><b>�������</b></td><td><b>���������� ������</b></td>
<td><b>��������� ������</b></td><td><b>����� ������</b></td><td><b>����� ������</b></td><td><b>�����������</b></td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
<?
	for ($i=0; $i<count($result); $i++) {
		$p = mysql_query("SELECT * FROM Users WHERE Login='".addslashes($result[$i][0])."';") or die(mysql_error());
		if (!$r = mysql_fetch_row($p)) { //���� ������������ �� ������ � ������� �������������, �� ������� ��� �����
			$p = mysql_query("DELETE FROM Orders WHERE User='".addslashes($result[$i][0])."'") or die (mysql_error());
		}
		else {
			echo "<tr bgcolor=#F3F3F3>\n";
			echo "<td>$r[7]</td>\n";
			echo "<td><a href=\"mailto:$r[2]\">$r[2]</a></td>\n";
			echo "<td>$r[3], $r[4], $r[5]</td>\n";
			echo "<td>$r[6]</td>\n<td>\n";
			//�������� ������ � ������� ���������
			$p = mysql_query("SELECT * FROM OrderedCarts WHERE OID='".$result[$i][4]."'") or die (mysql_error());
			$sum=0;
			while ($r = mysql_fetch_row($p)) {
				$s = mysql_query("SELECT * FROM GoodsList WHERE ID=$r[0]") or die (mysql_error());
				$k = mysql_fetch_row($s);
				echo "$k[2] ($r[1] ��.";
				if ($k[7]<$r[1]) { //�� ������ �������� ������, ��� ��������!
					echo " <font color=red>// ";
					echo ($k[7]<0) ? "0" : $k[7];
					echo " �� ������ //</font> )<br>\n";
				}
				else echo ")<br>\n";
				$sum += $r[1]*$k[5];
			};
			echo "</td>\n";
			echo "<td>$sum$</td>\n";
			echo "<td>".$result[$i][1]."</td>\n";
			echo "<td>".$result[$i][3]."</td>\n";
			echo "<td>".str_replace("<","&lt;",$result[$i][2])."</td>\n";
			echo "<td><input type=\"checkbox\" name=\"sel_".$result[$i][4]."\" value=\"".$result[$i][4]."\"></td>\n";
			echo "<td><a href=\"javascript:confirmDelete(".$result[$i][4].");\"><img src=\"images/remove.jpg\" border=0 alt=\"�������� �����\"></a></td>\n";
			echo "</tr>\n";
		};
	};
?>
<tr bgcolor=#E5E5E5>
<td colspan=10 align=right>
<input type="submit" value="�����(�) ���������">
<input type="hidden" name="done" value="1">
</td>
<td>&nbsp;</td>
</tr>
</table>
</form>
<? }
   else echo "<br><br><font>&lt;����� ������� ���></font>";
?>

<? } else if ($path==1) { //������������� ���� ������: ���������, ������, ������������ ?>



[ <a href="admin.php">����� ������</a> ]<br>
[ <a href="admin.php?path=2">����������</a> ]<br>
[ <a href="admin.php?path=3">��������� ���������</a> ]<br>

<p>
<table width=300 height=40 bgcolor=#D2FFD2 border=0>
<tr><td align=center>
<a href="index.php">>> ��������� � ������� &lt;&lt;</a>
</td></tr>
</table>
</p>

<table width=100% border=0>

<tr>
<td width=20% bgcolor=#D2D2FF align=center><b>���������</b></td>
<td width=33% bgcolor=#F5F5B2 align=center><b>������</b></td>
<td width=25% bgcolor=#FFDCDC align=center><b>������������</b></td>
</tr>



<tr>
<td bgcolor=#E2E2FF><!-- �������������� ������ ��������� ������� -->
<table width=100%>
<tr>
<td><b>������</b> (<?
	//��������� ������� ������� ��������� � �����
	$q = mysql_query("SELECT * FROM GoodsList WHERE CID=0;") or die (mysql_error());
	$i=0;
	while ($row = mysql_fetch_row($q)) $i++;
	echo $i;
?>
)</td>
<td align=right><font color=red>[</font><a class=small href="admin.php?CID=0&path=1">=></a><font color=red>]</font></td>
</tr>
<?	//�������� ��� ���������
	processCategories($cats,0,0);
	echo "</table>\n";
	echo "<br><center>[ <a href=\"javascript:open_window('category.php?w=-1',350,180);\">��������</a> ]</center><br>";
?>
</td>




<td bgcolor=#FFFFE2 align=center><!-- �������������� ������� ������� -->
<?

	//�������� ���� � ��������� � �� �������� ��� ���������
	$row = array();
	if (!isset($CID) || !$CID) {
		$CID = 0;
		$row[1] = "������";
	}
	else { //���� ��� �������� ���������� CID ���������, � ����� ��������� ���, �� ����� ��������� � ������
		$q = mysql_query("SELECT * FROM Categories WHERE CID='".$CID."';") or die (mysql_error());
		$row = mysql_fetch_row($q);
		if (!$row) {
			$CID = 0;
			$row[1] = "������";
		};
	};
	echo "<br><center><b>".$row[1].":</b></center><br>\n";

	if (!$CID) { //��������������
		echo "<font color=red>��� ������, ����������� � ����e, �� ����� ����� �������������!</font><br><br>\n";
	};

	//������� �� �� ��� ������ ������� ���������
	$q = mysql_query("SELECT * FROM GoodsList WHERE CID='".$CID."'  ORDER BY Name;") or die (mysql_error());
	$result = array();
	$i=0;
	while ($row = mysql_fetch_row($q)) $result[$i++] = $row;

	if (!$i) echo "<center>&lt;�����></center>";
	else { //�������� ������
		echo "<table border=1 cellspacing=0 cellpadding=3 bordercolor=#C3BD7C bordercolordark=#FFFFE2 width=70%>\n";
		echo "<tr bgcolor=#F5F5C5 align=center><td>��������</td><td>�������</td><td>����, $</td>";
		echo "<td>������� �� ������, ��.</td><td>����</td><td>������</td><td>�������, ��.</td></tr>\n";
		for ($i=0; $i<count($result); $i++) {
			echo "<tr><td>\n";
			echo "<a href=\"javascript:open_window('goods.php?ID=".$result[$i][1]."',550,570);\">".$result[$i][2]."</a>";
			echo "</td>\n";

			echo "<td align=right>\n";
			echo $result[$i][4];
			echo "</td>\n";

			echo "<td align=right>\n";
			echo $result[$i][5];
			echo "</td>\n";

			echo "<td align=right>\n";
			//������� ������ �� ������ -- ���� 0, �� �������� ������� ������
			if ($result[$i][7]<=0) echo "<font color=red>0</font>";
			else echo $result[$i][7];
			echo "</td>\n";


			echo "<td align=center>\n";
			if ($result[$i][6] && file_exists("goods_pictures/".$result[$i][6]))
				echo "����";
			else echo "<font color=red>���</font>";
			echo "</td>\n";
			echo "<td align=center>\n";
			if ($result[$i][8] && file_exists("goods_pictures/".$result[$i][8]))
				echo "����";
			else echo "<font color=red>���</font>";
			echo "</td>\n";

			echo "<td align=right>".$result[$i][10]."</td>\n</tr>\n";
		};
		echo "</table>\n";
	};
	echo "<br><center>[ <a href=\"javascript:open_window('goods.php?cat=".$CID."',550,570);\">��������</a> ]</center><br>";

?>
</td>




<td bgcolor=#FFECEC><!-- ������ ������������� -->
<?

	if (!isset($letter)) $letter="A";
	if (!$letter) echo "��� ������������:<br><br>";
	else echo "<b>".$letter.":</b><br><br>";

	$q = mysql_query("SELECT * FROM Users WHERE Login LIKE '".$letter."%' ORDER BY Login;") or die (mysql_error());
	$i=0;
	while ($row = mysql_fetch_row($q)) {
		echo "&nbsp<a href=\"javascript:open_window('user.php?uLogin=".str_replace("\"","&quot;",addslashes($row[0]))."',270,350);\">";
		echo str_replace("<","&lt;",str_replace("\"","&quot;",$row[0]))."</a><br>\n";
		$i++;
	};
	if ($i==0) echo "<center>&lt;�����></center><br>";
	echo "<br><center>������� ���������:<br>[ ";


	//���������
	for ($j="A", $i=0; $i<26; $j++, $i++) 
	  if ($j != $letter) echo "<a href=\"admin.php?letter=".$j."&path=1\" class=\"small\">".$j."</a> |\n";
	  else echo $j." |\n";
	echo "<a href=\"admin.php?path=1&letter=\">���</a> ]</center>\n";


?>
</td>
</tr>
</table>

<? } else if ($path==2) { //�������� ����������
	echo "[ <a href=\"admin.php\">����� ������</a> ]<br>";
	echo "[ <a href=\"admin.php?path=1\">������������� ������ � ���������</a> ]<br>";
	echo "[ <a href=\"admin.php?path=3\">��������� ���������</a> ]<br><br>";

	echo "<p><b><font>����� <u>����������</u> ������:</font></b></p>";
	$q = mysql_query("SELECT Name, Popularity, Votes, Sold FROM GoodsList ORDER BY Popularity DESC") or die (mysql_error());
	echo "<table bgcolor=#E1E6FC cellspacing=1 cellpadding=3>\n";
	echo "<tr bgcolor=#D1D9F8><td>������������</td><td><b>������������</b></td><td>������� �� �����</td><td>�������, ��.</td></tr>";
	$i=0;
	while ($i<10 && $row = mysql_fetch_row($q)) {
		echo "<tr bgcolor=#FFFFFF>\n";
		echo "<td>".$row[0]."</td>\n";
		echo "<td align=right><b>".$row[1]."</b></td>\n";
		echo "<td align=right>".$row[2]."</td>\n";
		echo "<td align=right>".$row[3]."</td>\n";
		echo "</tr>\n";
		$i++;
	};
	echo "</table>\n";

	echo "<p><b><font>����� <u>�����������</u> ������:</font></b></p>";
	$q = mysql_query("SELECT Name, Popularity, Votes, Sold FROM GoodsList ORDER BY Sold DESC") or die (mysql_error());
	echo "<table bgcolor=#E1E6FC cellspacing=1 cellpadding=3>\n";
	echo "<tr bgcolor=#D1D9F8><td>������������</td><td>������������</td><td>������� �� �����</td><td><b>�������, ��.</b></td></tr>";
	$i=0;
	while ($i<10 && $row = mysql_fetch_row($q)) {
		echo "<tr bgcolor=#FFFFFF>\n";
		echo "<td>".$row[0]."</td>\n";
		echo "<td align=right>".$row[1]."</td>\n";
		echo "<td align=right>".$row[2]."</td>\n";
		echo "<td align=right><b>".$row[3]."</b></td>\n";
		echo "</tr>\n";
		$i++;
	};
	echo "</table>\n";
} else {

	include("cfg/settings.inc")

?>

[ <a href="admin.php">����� ������</a> ]<br>
[ <a href="admin.php?path=1">������������� ������ � ���������</a> ]<br>
[ <a href="admin.php?path=2">����������</a> ]<br>

<form action="admin.php?path=3" method=post>
<table>

<tr>
<td align=right>���� ������� ���<br>������ ���������:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=curse1 value="<?=$courseN; ?>"> ������</td>
</tr>

<tr>
<td align=right>���� ������� ���<br>������ ������������:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=curse2 value="<?=$courseB; ?>"> ������</td>
</tr>



<tr>
<td align=right>�����:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=tax value="<?=$NSP; ?>"> %</td>
</tr>

<tr>
<td align=right>�������� ��������:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=shop_name value="<?=$shopname; ?>"></td>
</tr>

<tr>
<td align=right>URL ��������:</td>
<td width=10>&nbsp;</td>
<td><input type=text name=shop_url value="<?=$shopurl; ?>"></td>
</tr>

</table><br>

<input type=submit value=���������>
<input type=hidden name=sys_save value=1>

</form>


<? }; ?>
<p>
<table width=300 height=40 bgcolor=#D2FFD2 border=0>
<tr><td align=center>
<a href="index.php">>> ��������� � ������� &lt;&lt;</a>
</td></tr>
</table>
</p>

</center></body>

</html>