<? //����������/��������� ���������

	include("functions.php");

	//����������� � ��
	include ("cfg/connect.inc");
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die (mysql_error());
	mysql_select_db($DB_NAME) or die (mysql_error());

	//�������� �� ������a���������� ������
	session_start();
	include("checklogin.php");
	if (!isset($log) || strcmp($log,"MANAGER")) { //������������������� ������! Alarm!
		exit;
	};

	if (!isset($ID)) $ID=0;
	if (!isset($cat)) $cat = 0;
	if (!isset($name)) $name = "";
	if (!isset($popularity)) $popularity = 0;
	if (!isset($price)) $price = 0;
	if (!isset($count)) $count = 0;
	if (!isset($picture)) $picture = "none";
	if (!isset($icon)) $icon = "none";
	if (!isset($description)) $description = "";

?>

<html>

<head>
<link rel=STYLESHEET href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>������</title>
<script>
function confirmDelete($question, $where) {
	temp = window.confirm($question);
	if (temp) { //�������
		window.location=$where;
	};
};
</script>
</head>

<body bgcolor=#FFFFE2>

<?	function showGoodsForm($cat, $name, $popularity, $price, $description, $picture, $count, $title, $ID, $icon) { //������� ����� ��������������/�������� ������� ?>

<center><b><font><?=$title; ?></font></b></center>

<form enctype="multipart/form-data" action="goods.php" method=post>

<table width=100% border=0>

<tr>
<td align=right>���������:</td>
<td>
<select name="cid">
<option value="0">������</option>
<? fillTheCList(0,0,$cat); ?>
</select>
</td>
</tr>

<tr>
<td align=right>��������:</td>
<td><input type="text" name="name" value="<?=str_replace("\"","''",$name); ?>"></td>
</tr>

<?	if ($ID) { ?>
<tr>
<td align=right>�������:</td>
<td><b><?=$popularity; ?></b></td>
</tr>
<? }; ?>

<tr>
<td align=right>����, $<br>(������ �����):</td>
<td><input type="text" name="price" value=<?=$price; ?>></td>
</tr>

<tr>
<td align=right>������� �� ������, ��.:</td>
<td><input type="text" name="count" value="
<?
	if ($count<0) echo "0\"></td>\n";
	else echo $count."\"></td>\n";
?>
</tr>

<tr><td>&nbsp;</td></tr>

<tr>
<td align=right>������� ���������� ������:</td>
<td><input type="file" name="picture"></td>
<tr><td></td><td>
<?
	if ($picture && $picture != "none" && file_exists("goods_pictures/".$picture)) {
		echo "<font class=average>����������:</font> <a class=small href=\"goods_pictures/".$picture."\">$picture</a>\n";
		echo "<br><a href=\"javascript:confirmDelete('������� ���������� ������?','goods.php?ID=$ID&picture_remove=yes');\">�������</a>\n";
	}
	else echo "<br><font class=average color=brown>(���������� �� ��������)</font><br><br>";
?>
</td>
</tr>

<tr>
<td align=right>��������� ���������� ������ (������):</td>
<td><input type="file" name="icon"></td>
<tr><td></td><td>
<?
	if ($icon && $icon != "none" && file_exists("goods_pictures/".$icon)) {
		echo "<font class=average>����������:</font> <a class=small href=\"goods_pictures/".$icon."\">$icon</a>\n";
		echo "<br><a href=\"javascript:confirmDelete('������� ����������-������ ������?','goods.php?ID=$ID&icon_remove=yes');\">�������</a>\n";
	}
	else echo "<br><font class=average color=brown>(���������� �� ��������)</font>";
?>
</td>
</tr>


<tr><td>&nbsp;</td></tr>

<tr>
<td align=right>��������<br>(HTML-���):</td>
<td><textarea name="description" rows=10 cols=25><?=$description; ?></textarea></td>
</tr>

</table>
<p><center>
<input type="submit" value="���������" width=5>
<input type="hidden" name="save" value=<?=$ID; ?>>
<input type="button" value="������" onClick="window.close();">
<?	if ($ID) echo "<input type=button value=\"�������\" onClick=\"confirmDelete('������� �����?','goods.php?ID=".$ID."&del=1');\">"; ?>
</center></p>
</form>

<?	};

	function fillTheCList($parent,$level,$c) {
				//������������ ������ "���������" ��������� � ��� �������, � ������� ��� ���� � ������
				//��� ���������� ��� ������ ����� ��������� � ���� ������ (����� ��������� CID � Parent ����� ������)

		$q = mysql_query("SELECT * FROM Categories WHERE Parent='".$parent."' ORDER BY Name;") or die (mysql_error());

		$a = array(); //������ "���������"
		while ($row = mysql_fetch_row($q)) {
			//�������� ��� ��������� � ������
			echo "<option value=\"".$row[0]."\"";
			if ($c==$row[0]) echo " selected>";
			else echo ">";
			for ($j=0; $j<$level; $j++) echo "&nbsp;&nbsp;";
			echo $row[1]."</option>\n";
			//��������
			$a[count($a)] = $row;
			//���������� ��� ������������ ������
			$b = fillTheCList($row[0],$level+1,$c);
			//�������� $b[] � ����� $a[]
			for ($j=0; $j<count($b); $j++) {
				$a[count($a)] = $b[$j];
			};
		};
		return $a;
	};


	if (isset($save)) { //��������� ����� � ���� ������
		//������� ��������� ������������ ����� ������
		$row = array();
		if (!$name) {
			showGoodsForm($cat, $name, $popularity, $price, $description, $picture, $count, "<font color=red>�� ������� <u>��������</u> ������</font>",$ID, $icon);
			exit;
		};

		if (!$price || $price < 0) $price = 0; //���� � ������� ������ �� ������ �� ����� ���� ��������������
		if (!$count || $count < 0) $count = 0; 

		if ($picture && $picture != "none") { //upload'��� �������� ������, ����� ���� ������� �� ��� � $picture_name �� �����
					//��� ��������� ������, ����� ��������� ������� ���������� ���� � �� �� ��������
			$rr = rand() % 1000;
			$picture_name = $rr."_".$picture_name;
			$r = copy(trim($picture), "goods_pictures/".str_replace(" ","_",$picture_name));
			$picture_name = str_replace(" ","_",$picture_name);
			if (!$r) { //�������...
				echo "<center><font color=red>����� �������� � ���� ������!";
				echo "<br>�� �� ������� �������� ���������� ������ �� ������. ��������� �������: ��� ���������� ����� �� ������� ���� �� ��� �� ���������� ���������� 'goods_pictures'.</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">������� ����</a></center></body>\n</html>";
				exit;
			};
		};

		//���������� � �������
		if ($icon && $icon != "none") {

			$rr = rand() % 1000;
			$icon_name = $rr."_".$icon_name;
			$r = copy(trim($icon), "goods_pictures/".str_replace(" ","_",$icon_name));
			$icon_name = str_replace(" ","_",$icon_name);
			if (!$r) { //�������...
				echo "<center><font color=red>����� �������� � ���� ������!";
				echo "<br>�� �� ������� �������� ����������-������ ������ �� ������. ��������� �������: ��� ���������� ����� �� ������� ���� �� ��� �� ���������� ���������� 'goods_pictures'.</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">������� ����</a></center></body>\n</html>";
				exit;
			};
		};



		//���������
		if ($save) { //���� $save != 0, �� �������� �������������� ������

			$q = mysql_query("SELECT * FROM GoodsList WHERE ID=".$save) or die (mysql_error());
			$row = mysql_fetch_row($q);

			//���� ������� ������������ ����������/������ � ����� "����������", �� �����b�� ���� �������� � ������ � ���� ������
			if ($picture && $picture != "none") {
				//������� ������ ����������
				if ($row[6] != "none" && file_exists("goods_pictures/".$row[6]))
					unlink("goods_pictures/".$row[6]);

				if ($icon && $icon != "none") { //���� �� ������� ��� ������?
					//������� ������ ������
					if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
						unlink("goods_pictures/".$row[8]);
					//�������� ���������� � ������ � ��
					$q = mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Picture='$picture_name', Description='$description', LeftInWarehouse=$count, SmallPic='$icon_name' WHERE ID=$save") or die (mysql_error());
				}
				else mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Picture='$picture_name', Description='$description', LeftInWarehouse=$count WHERE ID=$save") or die (mysql_error());

			}
			else { //��� ����� �������� �� �������
				if ($icon && $icon != "none") {
					//������� ������ ������
					if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
						unlink("goods_pictures/".$row[8]);
					//�������� ���������� � ������ � ��
					$q = mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Description='$description', LeftInWarehouse=$count, SmallPic='$icon_name' WHERE ID=$save") or die (mysql_error());
				}
				else mysql_query("UPDATE GoodsList SET CID=$cid, Name='".str_replace("<","&lt;",$name)."', Price=$price, Description='$description', LeftInWarehouse=$count WHERE ID=$save") or die (mysql_error());

			};

		}
		else { //�������� ����� ����� � ���� ������

			$q = mysql_query("INSERT INTO GoodsList VALUES ($cid, 0,'".str_replace("<","&lt;",$name)."','$description', 0, $price,'$picture_name', $count, '$icon_name', 0, 0);") or die (mysql_error());

		};

		update_Goods_Count_Value_For_Categories(0); //�������� �������� GoodsCount ��� ���������

		//������� ����
		echo "<script>\n";
		echo "window.opener.location.reload();\n";
		echo "window.close();\n";
		echo "</script>\n</body>\n</html>";
		exit;
	}
	else {
		$row = array();
		if ($ID) { //����� ����� �� ���� ������

			//���������, ���������� �� ����� �����
			$q = mysql_query("SELECT * FROM GoodsList WHERE ID=".$ID) or die (mysql_error());
			$row = mysql_fetch_row($q);
			if (!$row) { //������ �� ����������
				echo "<center><font color=red>����� �� ������ � ���� ������!";
				echo "<br>������� ������ \"��������\" � ��������, ������� ������������ ��� ������ \"�������������\"</font>\n<br><br>\n";
				echo "<a href=\"javascript:window.close();\">������� ����</a></center></body>\n</html>";
				exit;
			};

			if (isset($picture_remove)) { //������� ���������� ������
				if ($row[6] != "none" && file_exists("goods_pictures/".$row[6]))
					unlink("goods_pictures/".$row[6]);
				$picture = "none";
			};

			if (isset($icon_remove)) { //������� ���������� ������
				if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
					unlink("goods_pictures/".$row[8]);
				$icon = "none";
			};

			if (isset($del)) { //������� �����
				//������� -- ��� ����������
				if ($row[6] != "none" && file_exists("goods_pictures/".$row[6]))
					unlink("goods_pictures/".$row[6]);

				//������ ������
				if ($row[8] != "none" && file_exists("goods_pictures/".$row[8]))
					unlink("goods_pictures/".$row[8]);

				//������ ��� �����
				$q = mysql_query("DELETE FROM GoodsList WHERE ID=".$ID) or die (mysql_error());

				update_Goods_Count_Value_For_Categories(0); //�������� ���������

				//������� ����
				echo "<script>\n";
				echo "window.opener.location.reload();\n";
				echo "window.close();\n";
				echo "</script>\n</body>\n</html>";
				exit;
			};

			$cat = $row[0];
			$name = $row[2];
			$popularity = $row[4];
			$price = $row[5];
			$picture = $row[6];
			$icon = $row[8];
			$count = $row[7];
			$description = $row[3];
			//���� ����� �� ����, �� ����� ����������
			$title = $row[2];
		}
		else { //�������� ������ ������
			$title = "����� �����";
		};
	};
	showGoodsForm($cat, $name, $popularity, $price, $description, $picture, $count, $title,$ID, $icon);

?>

</body>

</html>