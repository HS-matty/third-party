<? //����������/��������� ���������

	include("functions.php");

	//����������� � ��
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	//�������� �� ����������������� ������
	session_start();
	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //������������������� ������! Alarm!
		exit;
	};

?>

<html>

<head>
<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>���������</title>
<script>
function confirmDelete() {
	temp = window.confirm('������� ��������� � ��� �� ������������\n(��� ������ ����� ���������� � ������)?');
	if (temp) { //�������
		window.location='category.php?c_id=<?=$c_id;?>&del=1';
	};
};
</script>
</head>

<body bgcolor=#D2D2FF>

<?
	function deleteSubCategories($parent) { //������� ��� ��������� � ������������ $parent'��
		//������ ��� �� ������������
		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$parent.";") or die (mysql_error());
		while ($row = mysql_fetch_row($q)) {
			deleteSubCategories($row[0]);
		};
		$q = mysql_query("DELETE FROM Categories WHERE Parent=".$parent.";") or die (mysql_error());

		//��� ������ ���� ��������� ����������� � ������ (������ ����� ���-�� ����� temporary folder)
		$q = mysql_query("UPDATE GoodsList SET CID=0 WHERE CID=".$parent) or die (mysql_error());
	};

	function category_Moves_To_Its_SubDirectories($cid, $new_parent) {
		//������� ���������� true, ���� �������� ����������� � �����-�� �� �� ������������

		$a = false;
		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$cid." ORDER BY Name;") or die (mysql_error());
		while ($row = mysql_fetch_row($q)) {
			if ($row[0]==$new_parent) $a = true;
			else $a = category_Moves_To_Its_SubDirectories($row[0],$new_parent);
		};
		return $a;
	};

	function fillTheList($parent,$level,$add2list,$c) {
				//������������ ������ "���������" ��������� � ��� �������, � ������� ��� ���� � ������
				//��� ���������� ��� ������ ����� ��������� � ���� ������ (����� ��������� CID � Parent ����� ������)
				//���� $add2list!=0 �� ����� ��������� ������ �����������
				//������� ���������� processCategories() � admin.php

		$q = mysql_query("SELECT * FROM Categories WHERE Parent=".$parent." ORDER BY Name;") or die (mysql_error());

		$a = array(); //������ "���������"
		while ($row = mysql_fetch_row($q)) {
			//�������� ��� ��������� � �������
			if ($add2list) {
				echo "<option value=\"".$row[0]."\"";
				if ($c==$row[0]) echo " selected>";
				else echo ">";
				for ($j=0; $j<$level; $j++) echo "&nbsp;&nbsp;";
				echo $row[1]."</option>\n";
			};
			//��������
			$a[count($a)] = $row;
			//���������� ��� ������������ ������
			$b = fillTheList($row[0],$level+1,$add2list,$c);
			//�������� $b[] � ����� $a[]
			for ($j=0; $j<count($b); $j++) {
				$a[count($a)] = $b[$j];
			};
		};
		return $a;
	};

	if (!isset($w)) $w=-1;

	if (isset($save) && $name) { //��������� ������ � ���� ������ � ������� ����

		if (!isset($must_delete)) { //�������� ����� ������
			$q = mysql_query("INSERT INTO Categories VALUES (0,'".str_replace("<","&lt;",$name)."',".$parent.",0)") or die (mysql_error());
		}
		else { //�������� ������������ -- �.�. �������� ��� �/��� ��������� � ������ ���������, ��� ������� ������� � option'��

			if ($must_delete != $parent) { //���� ��������� �� ��������� "���� � ����"

				//����� �������� 2 ��������: ���� ��������� ��������� � �����-�� �� �� ������������, ���� ���
				//� ������ ������ �� ������ ����������� ������������ ������ ��������� �� ������� �����
				
				if (category_Moves_To_Its_SubDirectories($must_delete, $parent)) { //1�� ������

					//��������� ��� ������������ 1��� ������ ������������� ���������

					//��� ����� ������� �������� ������� �������� ������ ��������� � $r[2]
					$q = mysql_query("SELECT * FROM Categories WHERE CID=$must_delete") or die (mysql_error());
					$r = mysql_fetch_row($q);

					//����������� ��� ������������ 1��� ������ ������ ��������� �� ������� ����
					$q = mysql_query("UPDATE Categories SET Parent=".$r[2]." WHERE Parent=".$must_delete) or die (mysql_error());

					//����������� ������������� ���������
					$q = mysql_query("UPDATE Categories SET Name='".str_replace("<","&lt;",$name)."', Parent=".$parent." WHERE CID=".$must_delete) or die (mysql_error());

				}
				else //����������� ������������ ��� ��������� �� ������������
					$q = mysql_query("UPDATE Categories SET Name='".str_replace("<","&lt;",$name)."', Parent=".$parent." WHERE CID=".$must_delete) or die (mysql_error());

			};
		};

		//����� ���������� �������� ���-�� ������� ��� ������ ���������
		update_Goods_Count_Value_For_Categories(0);

		//������ ������� ����
		echo "<script>\n";
		echo "window.opener.location.reload();\n";
		echo "window.close();\n";
		echo "</script>\n</body>\n</html>";
	}
	else { //�������� ����� �������������� ���������

		if (isset($c_id)) { //��������������...
			$q = mysql_query("SELECT * FROM Categories WHERE CID=".$c_id) or die (mysql_error());
			$row = mysql_fetch_row($q);
			if (!$row) { //������! ��������� �� ����������!
				echo "<center><font color=red>��������� �� ������� � ���� ������!";
				echo "<br>������� ������ \"��������\" � ��������, ������� ������������ ��� ������ \"�������������\"</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">������� ����</a></center></body>\n</html>";
				exit;
			};
			$title = "��������� <b>".$row[1]."</b>";
			$n = $row[1];

			if (isset($del)) { //������� ������...
				//������� ���� ������
				$q = mysql_query("DELETE FROM Categories WHERE CID=".$c_id) or die (mysql_error());
				//������ ��� �� ������������
				deleteSubCategories($c_id);
				//������� ����
				echo "<script>\n";
				echo "window.opener.location.reload();\n";
				echo "window.close();";
				echo "</script>\n</body>\n</html>";
			};
		}
		else { //�������� ����� ���������
			$title = "������� ����� ���������";
			$n = "";
		};

?>

<center><font color=purple><?=$title; ?></font></center>
<form action="category.php" method=post>
<table width=100% border=0>

<tr>
<td align=right>
<?
	if (!isset($c_id)) echo "��������:";
	else echo "����������� �:";
?>
</td>
<td width=5%></td>
<td>
<select name="parent"> <!-- �������� �������� ������ -- CID ������ ��������� -->
<option value="0">������</option>
<? //��������� ������ ���� ��������� ��� ����������� � ������
	fillTheList(0,0,1,$w);
?>
</select>
</td>
</tr>

<tr>
<td align=right>�������� ���������:</td>
<td></td>
<td><input type="text" name="name" value="<?=str_replace("\"","''",$n); ?>" size=13></td>
</tr>

</table>
<p><center>
<input type="submit" value="���������" width=5>
<input type="hidden" name="save" value="1">
<input type="button" value="������" onClick="window.close();">
<?	//���� ����������� ������, �� ������ ������ ���� UPDATE ������ INSERT
	if (isset($c_id)) {
		echo "<input type=\"hidden\" name=\"must_delete\" value=\"".$c_id."\">\n";
		echo "<input type=\"button\" value=\"�������\" onClick=\"confirmDelete();\"";
	};
?>
</center></p>
</form>

</body>

</html>
<? }; ?>