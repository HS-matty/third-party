<? //���������� � ������������

	//�������� �� ����������������� ������
	session_start();

	//����������� � ��
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //������������������� ������! Alarm!
		exit;
	};

	if (!isset($uLogin)) $uLogin="";
?>

<html>

<head>
<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>������������</title>
<script>
function confirmDelete() {
	temp = window.confirm('������� ������������?');
	if (temp) { //�������
		window.location='user.php?uLogin=<?=$uLogin;?>&del=1';
	};
};
</script>
</head>

<body bgcolor=#FFECEC>
<center>

<?
	if (isset($del) && strcmp($uLogin,"MANAGER")) { //�������
		//������� ��������� ����������� �� ���� ������ ������������
		$q = mysql_query("SELECT * FROM Users WHERE Login='".$uLogin."';") or die (mysql_error());
		$row = mysql_fetch_row($q);
		$q = mysql_query("SELECT Email FROM Users WHERE Login='MANAGER'") or die (mysql_error());
		$r = mysql_fetch_row($q);

		include("cfg/settings.inc");
		mail($row[2],"��� ������� ������ :(","������������!\n\n�� ���� ��������� �������� ��� ������� ��� ������ �� ������ ����� ����������! �� ���� �������� ����������� �� $r[0]\n\n� ���������, $shopname.\n$shopurl", "From: $shopname<$r[0]>;\nContent-Type: text/plain; charset=\"windows-1251\"");

		$q = mysql_query("DELETE FROM Users WHERE Login='$uLogin';") or die (mysql_error());
		//������� ����
		echo "<script>\n";
		echo "window.opener.location.reload();\n";
		echo "window.close();";
		echo "</script>\n</body>\n</html>";
		exit;
	};

	$q = mysql_query("SELECT * FROM Users WHERE Login='$uLogin';") or die (mysql_error());
	$row = mysql_fetch_row($q);
	if (!$row) { //������������ �� ����������
		echo "<font color=red>������������ �� ������ � ���� ������!";
		echo "<br>������� ������ \"��������\" � ��������, ������� ������������ ��� ������ \"�������������\"</font>\n<br><br>\n";
		echo "<a href=\"javascript:window.close();\">������� ����</a></center></body>\n</html>";
		exit;
	};

?>

<table border=0 cellspacing=3 width=100%>

<tr>
<td align=right width=40%>�����:</td>
<td><b><?=str_replace("<","&lt;",$row[0]); ?></b></td>
</tr>

<tr>
<td align=right>������:</td>
<td><b><?=str_replace("<","&lt;",$row[1]); ?></b></td>
</tr>

<tr>
<td align=right>������:</td>
<td><b><?=str_replace("<","&lt;",$row[1]); ?></b></td>
</tr>

<tr>
<td align=right>E-mail:</td>
<td><a href="mailto:<?=str_replace("<","&lt;",$row[2]); ?>"><?=str_replace("<","&lt;",$row[2]); ?></a></td>
</tr>

<tr>
<td align=right>������ ���:</td>
<td><b><?=str_replace("<","&lt;",$row[7]); ?></b></td>
</tr>

<tr>
<td align=right>������:</td>
<td><b><?=str_replace("<","&lt;",$row[3]); ?></b></td>
</tr>

<tr>
<td align=right>�����:</td>
<td><b><?=str_replace("<","&lt;",$row[4]); ?></b></td>
</tr>

<tr>
<td align=right>�����:</td>
<td><b><?=str_replace("<","&lt;",$row[5]); ?></b></td>
</tr>

<tr>
<td align=right>�������:</td>
<td><b><?=str_replace("<","&lt;",$row[6]); ?></b></td>
</tr>

</table>

<form>
<input type="button" value="�������" onClick="window.close();">
<?
	if (strcmp($row[0],"MANAGER")) echo "<input type=\"button\" value=\"�������\" onClick=\"confirmDelete();\">\n";
?>
</form>

</center>
</body>

</html>