<? //������� ��������

function showGood($a,$cat,$brief) { //������ ������� � ��������� ������ $a, ��� ���������, �����...
					//$cat -- ������, ������� ������� ������ ������� -- ��� ���� � ���������, � ������� ��������� �����
					//$brief: ���� true, ������ �������� �������������� ������ ��� ��������

	echo "<p><table width=95% border=0 cellspacing=1 cellpadding=2 bgcolor=#E1E6FC>\n";

	echo "<tr bgcolor=#D1D9F8>\n<td colspan=3><font color=#3551C7>".$cat."</font></td>\n</tr>\n";

	echo "<tr bgcolor=#FFFFFF>\n<td rowspan=";
	echo $brief ? "2" : "3"; //������� ����� ����������
	echo " width=1% align=center valign=top>\n";
	//������ �������� ���������� ������

	if ($brief) { //���� ���������� ��������� ����������-������ - ����������, ���������� �� ���
		if ($a[8] && file_exists("goods_pictures/".$a[8])) {
			echo "<a href=\"index.php?GID=".$a[1]."\"><img src=\"goods_pictures/".$a[8]."\" border=0 alt=\"Click for more information\">\n";
			echo "<font class=average>more info...</font></a>\n";
		}
		else //������ ��� - ���������, �� � ����������� �������. �������: ���������� �� ���
		  if ($a[6] && file_exists("goods_pictures/".$a[6])) {
			echo "<a href=\"index.php?GID=".$a[1]."\"><img src=\"goods_pictures/".$a[6]."\" border=0 height=75 alt=\"Click for more information\">\n";
			echo "<font class=average>more info...</font></a>\n";
		  }
		  else { //��� �� ����������, �� ������...
			echo "<a href=\"index.php?GID=".$a[1]."\"><img src=\"images/no_image.jpg\" border=0 alt=\"Click for more information\">\n";
			echo "<font class=average>more info...</font></a>\n";
		  };
	}
	else { //���� �������� ������� ���������� -- ��������� ����� �����, ��� � � ����. ������
		if ($a[6] && file_exists("goods_pictures/".$a[6]))
			echo "<img src=\"goods_pictures/".$a[6]."\">\n";
		else //������ ��� - ���������� ������� ��������, �� � ����������� �������. �������: ���������� �� ���
		  if ($a[8] && file_exists("goods_pictures/".$a[8]))
			echo "<img src=\"goods_pictures/".$a[8]."\" border=0>\n";
		  else //��� �� ����������, �� ������...
			echo "<img src=\"images/no_image.jpg\" border=0>\n";
	};
	echo "</td>\n";

	echo "<td width=80%>\n";
	echo $brief ? "<a class=cat href=\"index.php?GID=".$a[1]."\">".$a[2]."</a>\n" : " <font class=cat><b>".$a[2]."</b></font>\n";
	if ($a[7]<=0 || $a[5]<=0) { //���� ����������� �� ������, �� �� ������ ������ �� ���������� ������ � �������
		echo "<font color=brown> (is absent.)</font></td>\n</td>\n";
		$f=1;
	}
	else {
		$f=2;
		echo "</td><td bgcolor=#FFFFFF align=center><a href=\"javascript:open_window('cart.php?add=".$a[1]."',400,300);\"><img src=\"images/cart.jpg\" border=0 alt=\"to the shopping basket\"></a></td>\n";
	};

	if (!$brief) {
		echo "<tr bgcolor=#FFFFFF><td colspan=$f><b>description:</b><br>";
		if (!$a[3]);
		else echo $a[3];
		echo "</td></tr>\n";
	};

	echo "<tr bgcolor=#FFFFFF><td colspan=$f><b>Price: <font class=cat color=red>";
	echo $a[5] ? $a[5]."$" : "n/a";
	echo "</font></b></td></tr>\n";

	echo "</table></p>\n\n";

};


function ShowNavigator($a, $offset, $q, $path) { //���������� ��������� [] 1 2 3 4 � [����]
						//$a - ���-�� ��������� � �������, ������� "����������"
						//$offset - ������� ����� �� ������� (������������ ������ � $offset'��� �� $offset+$q'��)
						//$q - ���-�� ������� �� ��������
						//$path - ������ �� �������� (��������: "index.php?CID=1&"). & ����� ��� �������� $offset'a

		
		if ($a > $q) { //���� ��� ������ �� ���������� �� ��������

			//[����]
			if ($offset>0) echo "<a href=\"".$path."offset=".($offset-$q)."\">[prev]</a> &nbsp;";

			//�������� ������
			$k = $offset / $q;

			//�������� �� ����� 5 ���������� ������ �����
			$min = $k - 5;
			if ($min < 0) { $min = 0; }
			else {
				if ($min >= 1) { //�������� ������ �� 1-�� ��������
					echo "<a href=\"".$path."offset=0\">[1-".$q."]</a> &nbsp;";
					if ($min != 1) { echo "... &nbsp;"; };
				};
			};

			for ($i = $min; $i<$k; $i++) {
				$m = $i*$q + $q;
				if ($m > $a) $m = $a;

				echo "<a href=\"".$path."offset=".($i*$q)."\">[".($i*$q+1)."-".$m."]</a> &nbsp;";
			};

			//�������� # ������� ��������
			$min = $offset+$q;
			if ($min > $a) $min = $a;
			echo "[".($k*$q+1)."-".$min."] &nbsp;"; //# ������� ��������

			//�������� �� ����� 5 ���������� ������ ������
			$min = $k + 6;
			if ($min > $a/$q) { $min = $a/$q; };
			for ($i = $k+1; $i<$min; $i++) {
				$m = $i*$q+$q;
				if ($m > $a) $m = $a;

				echo "<a href=\"".$path."offset=".($i*$q)."\">[".($i*$q+1)."-".$m."]</a> &nbsp;";
			};

			if ($min*$q < $a) { //��������� �����...
				if ($min*$q < $a-$q) echo " ... &nbsp;";
				echo "<a href=\"".$path."offset=".($a-$a%$q)."\">[".($a-$a%$q+1)."-".$a."]</a> ";
			};

			//[����]
			if ($offset<$a-$q) echo "<a href=\"".$path."offset=".($offset+$q)."\">[next]</a>";

		};
};

function showSubCategories($categories, $i) { //�������� ��� ������������ ��������� � �������� $cidi � $categories

	echo "<p>\n<a href=\"index.php?CID=".$categories[$i][0]."\" class=cat>".$categories[$i][1]."</a>\n";
	echo "[<b>".$categories[$i][3]."</b>]:<br>\n";
	//������ �������� �� ������������ 1��� �p����
	$pl = false; //$pl ����� ��� ����, ����� ������ ������� '|' ����� ����, ��� �������� 1�� �����
	for ($j=0; $j<count($categories); $j++)
	  if ($categories[$j][2] == $categories[$i][0])
	  {
		if ($pl) echo "| ";
		else {
			$pl=true;
			echo "&nbsp;&nbsp;";
		};
		echo "<a class=standard href=\"index.php?CID=".$categories[$j][0]."\">".$categories[$j][1]."</a>\n";
	  };
	echo "</p>\n";

};



	include("head.incl"); //������� � ����� ����� ��� ������������������ �������������

	//�������� �������: ����� ������ ���������, ������ � �.�.
?>
<table border=0 width=100% cellspacing=5 cellpadding=5>

<tr><td width=120 valign=top>
<table border=0 cellspacing=2 width=120>
<?

	$path = calculatePath($categories, $CID); //��������� ���� �� ��������� ���������
	processCategories($categories,0,$path,$CID);
?>
</table><br><br>

<!-- ��������� ������� ������ ��������� �����. ������ �������� � �.�. -->

<!-- ������ ������� -->

</td>
<td valign=top width=90%>

<?
	if (isset($killuser)) //�������� �� �������� ������������
		echo "<center><b>You were deleted from the registration list!</b></center><br><br>\n";

	if (isset($forgotpw)) { //������ ������? ������� ��� �� ����� �������
		
		$q = mysql_query("SELECT * FROM Users WHERE Login='$forgotpw'") or die (mysql_error());

		if ($row = mysql_fetch_row($q)) { //��������� ������
			$tt = mysql_query("SELECT Email FROM Users WHERE Login='MANAGER'");
			$ro = mysql_fetch_row($tt);
			mail($row[2], "Your password", "Hello!\n\nYour password: $row[1]\n\n $shopname.\n$shopurl", "From: $shopname<$ro[0]>;\nContent-Type: text/plain; charset=\"windows-1251\"");
			echo "<center><b>Your password sent &lt;".$row[2]."></b></center><br><br>\n";

		}
		else { //����� �� ������ � ���� ������
			echo "<center><b>There is no such user (".stripslashes($forgotpw).")!</b></center><br>";
			$logging = "yes"; //�������� ����� ����� ��� ���
		};

	};

	if (isset($vote)) { //������������� �� ����� -- �������� � ���� ������������
		$q = mysql_query("UPDATE GoodsList SET Popularity=(Popularity*Votes+$mark)/(Votes+1), Votes=Votes+1 WHERE ID=".$vote) or die (mysql_error());
		$GID = $vote; //��� ����, ����� ��������� � ������ ���������� � ������
	};

	if (isset($GID) && $GID) { //�������� ���������� � ������

		$q = mysql_query("SELECT * FROM GoodsList WHERE ID=$GID") or die (mysql_error());
		$a = mysql_fetch_row($q);

		$path = calculatePath($categories, $a[0]);

		//�������� ���������, � ������� ����� �����
		$s="";
		for ($i=1; $i<count($path); $i++)
			$s .= "<a href=\"index.php?CID=$path[$i]\">".$categories[categoryIndexInArray($categories, $path[$i])][1]."</a> : ";
		echo "<b>\n".$s."</b><br>";

		//������ ���� �� ���� ���� �������� � ��������� ������
		$s="<font class=average>";
		for ($k=1; $k<count($path); $k++)
			$s .= $categories[categoryIndexInArray($categories, $path[$k])][1]."/";
		//� ��� �����
		showGood($a,$s,false);

		//������ �������� ����������� -- ������ ������
?>
</td>

<td width=100 valign=top>
<center>
<form action="index.php" method=get>
<table border=0 cellspacing=1 cellpadding=2 bgcolor=#E1E6FC>
<tr><td align=center>Rate it!</td></tr>
<tr bgcolor=white><td>
<input type="radio" name="mark" value="5">excellent<br>
<input type="radio" name="mark" value="3" checked>good<br>
<input type="radio" name="mark" value="2">so-so<br>
<input type="radio" name="mark" value="1">bad<br>
<input type="radio" name="mark" value="0">very bad
</td></tr>
</table><br>
<input type="hidden" name="vote" value="<?=$GID; ?>">
<input type="submit" class="bluebutton" value="Rate!">
</form>
</center>
<?

	} else

	if (isset($logging) || isset($enter) && !isset($log)) { //�������� ����� ����� � ������� ?>

<center>
<p>if you're not registered yet, please fill the <a href="register.php">registartion form</a>!</p>
<?
	if (isset($wrongLoginOrPw) && $wrongLoginOrPw) {
		echo "<p><font color=red>�������� ����� ��� ������</font></p>";
	};
?>
<form action="index.php" method=post>
<table border=0>
<tr>
<td align=right>login:</td>
<td><input type="text" name="user_login" size=10></td>
</tr>
<tr>
<td align=right>password:</td>
<td><input name="user_pw" type="password" size=10></td>
</tr>
<tr><td colspan=2 align=center>
<input type="hidden" name="enter" value="1">
<input type="submit" value="ENTER">
</td></tr>
</table>
</form>
<br><br><br>

<form action="index.php" method=post>
<table><tr><td>
<font class=average><u>Forgot password?</u> Enter your login: </font></td><td><input class=ss type="text" name="forgotpw">
<input type="submit" class=bluebutton value="Send">
</td></tr></table>
</form>

</center>

<?
	} else

	if (isset($searchstring)) { //���������� ����� � �������� �������� ������

		//������� ������ �� �����
		$searchstring = trim(str_replace("'","",stripslashes($searchstring)));
		$search = explode(" ",$searchstring);

		$result=array();
		$r = array();
		$i=0;
		$k=0;
		if ($searchstring) {
			//������� ���� ���������, � ��������� ������� ���������� ��������� ������
			$s = "SELECT * FROM Categories WHERE Name LIKE '%".$search[0]."%' ";
			for ($i=1; $i<count($search); $i++) $s .= "AND Name LIKE '%".$search[$i]."%' ";
			$s.="ORDER BY Name";
			$q = mysql_query($s);
			$i=0;
			while ($row = mysql_fetch_row($q)) $result[$i++] = $row;

			//������ �������� � �������
			//����� � ����� ������
			$s = "SELECT * FROM GoodsList WHERE Name LIKE '%".$search[0]."%' OR Description LIKE '%".$search[0]."%' ";
			for ($j=1; $j<count($search); $j++) $s .= "AND Name LIKE '%".$search[$j]."%' OR Description LIKE '%".$search[0]."%' ";
			$s.="ORDER BY Popularity DESC";
			$q = mysql_query($s);
			$k=0;
			while ($row = mysql_fetch_row($q)) $r[$k++] = $row;

		};

		//�������� ������� ������� �������
		if (count($r))
		  if (count($result))
			echo "<div align=left><p>Your query is <b>".$searchstring."</b>. Found: <b>".count($r)."</b> goods and <b>".count($result)."</b> categories</p><br></div>\n\n";
		  else
			echo "<div align=left><p>Your query is <b>".$searchstring."</b>. Found <b>".count($r)."</b> goods</p><br></div>\n\n";
		else {
		  if (count($result))
			echo "<div align=left><p>Your query is: <b>".$searchstring."</b>. Found: <b>".count($result)."</b> categories</p><br></div>\n\n";
		  else
			echo "<div align=left><p>Your query is: <b>".$searchstring."</b>. Nothing is found</p></div><br>\n\n";

//		  echo "<font color=gray>// ������ ��������� ���������� ��������� � ��� ��� �������� ������ //</font></center><br><br>";
		};

		if ($i) { //�������� ��������� ���������
			echo "<p>\n";
			for ($i=0; $i<count($result); $i++) {

				//��������� ���� � ���������
				$path = calculatePath($categories, $result[$i][0]);

				//�������� ����
				for ($j=1; $j<count($path)-1; $j++) 
					echo "<a class=\"standard\" href=\"index.php?CID=$path[$j]\">".$categories[categoryIndexInArray($categories, $path[$j])][1]."</a> : ";
				//�������� ��������� ��������� � $path ������ ������� � ��� ':' � �����
				echo "<a href=\"index.php?CID=$path[$j]\">".$categories[categoryIndexInArray($categories, $path[$j])][1]."</a>";
				echo "</b></font>";

				echo "<br>\n\n";
			};
			echo "</p>";

		};


		if ($k) { //�������� ��������� ������

			echo "<center>\n";

			if (!isset($offset)) $offset=0;
			//��������� ����������� ������� $offset
			if ($offset>count($r) || $offset<0 || $offset%10) $offset=0;

			$min = $offset+10;
			if ($min > count($r)) $min = count($r);

			//�������� ��������� ����� �������� ��������� �������
			showNavigator(count($r), $offset, 10, "index.php?searchstring=".$searchstring."&");

			for ($j=$offset; $j<$min; $j++) {

				//��������� ���� � ���������, � ������� ����� �����, � �������� �����
				$path = calculatePath($categories, $r[$j][0]);

				$s="<font class=average>";
				for ($k=1; $k<count($path); $k++)
					$s .= $categories[categoryIndexInArray($categories, $path[$k])][1]."/";

				showGood($r[$j],$s,true);
			};

			//�������� ��������� ����� �������� ��������� �������
			showNavigator(count($r), $offset, 10, "index.php?searchstring=".$searchstring."&");


			echo "</center>\n";

		};

	}
	else {

		if ($CID) { //�������� ������ ��������� ���������

			//������� ���� ��������� � ���� � ���
			echo "<p>\n";
			//��������� -- �������� ������� ��������� � ���� � ���
			$s="";
			for ($i=1; $i<count($path)-1; $i++)
				$s .= "<a class=\"cat\" href=\"index.php?CID=$path[$i]\">".$categories[categoryIndexInArray($categories, $path[$i])][1]."</a> : ";
			$s .= $categories[categoryIndexInArray($categories, $CID)][1];

			echo "<font class=\"cat\"><b>\n".$s.":<br></b></font>";

			//�.�. � ��������� ������� ������ ������� ���� � ���������, � ������� �� �����, �� ��������� ����� ���������
			//���� ���� (������� ������), � ����� ������ ��� ��� ������� ������ ���� ���������
			$s="<font class=average>";
			for ($i=1; $i<count($path); $i++)
				$s .= $categories[categoryIndexInArray($categories, $path[$i])][1]."/";

			//������ �������� �� ������������ 1��� �p����
			echo "</p><p>";
			for ($j=0; $j<count($categories); $j++)
			  if ($categories[$j][2] == $categories[categoryIndexInArray($categories, $CID)][0])
			  {
				echo "&nbsp;&nbsp;<a class=standard href=\"index.php?CID=".$categories[$j][0]."\">".$categories[$j][1]."</a>\n";
				echo "(".$categories[$j][3].")<br>\n";
			  };
			echo "</p>\n";


			//������ �������� ������
			$q = mysql_query("SELECT * FROM GoodsList WHERE CID='".$CID."' ORDER BY Popularity DESC") or die (mysql_error());
			$i=0;
			$result = array();
			while ($row = mysql_fetch_row($q)) {
				$result[$i] = $row;
				$i++;
			};

			if (!$i) { //���� ���-�� ������� � ��������� -- 0, �� �������� �������� ���������� ������ �� �� ������������

				//������� ����������, ���� �� � ��� ������������
				while ($i<count($categories) && $categories[$i][2] != $CID) $i++;
				if ($i == count($categories)) //���
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&lt; There are no goods here. >";
				else { //�������� ������ ������������

					$s = "SELECT * FROM GoodsList WHERE ";
					$pl = false; //���� ��� ����, ����� �� ������ 'OR' � ������� ����� ������ �������

					for ($i=0; $i<count($categories); $i++)
					  if ($categories[$i][2] == $CID) {

						if ($pl) $s .="OR ";
						else $pl = true;
						$s .= "CID=".$categories[$i][0]." ";
					  };

					$q = mysql_query($s."ORDER BY Popularity DESC") or die (mysql_error());
					$i=0;
					$pl=false;
					while ($i<5 && $row = mysql_fetch_row($q)) { //�������� �� ����� 5 �������
						if (!$pl) {
							echo "<br>Recommended:";
							$pl=true;
						}
						else echo "<br>";

						//��������� ���� � ���������, � ������� ����� �����, � �������� �����
						$path = calculatePath($categories, $row[0]);

						$s="<font class=average>";						for ($k=1; $k<count($path); $k++)
							$s .= $categories[categoryIndexInArray($categories, $path[$k])][1]."/";

						showGood($row,$s,true);
						$i++;
					};
				};
			}
			else { //$i != 0 -- ���������� ������ ���� ��������� + ���������

				if (!isset($offset)) $offset=0;
				//��������� ����������� ������� $offset
				if ($offset>count($result) || $offset<0 || $offset%10) $offset=0;

				$min = $offset+10;
				if ($min > count($result)) $min = count($result);

				echo "<center>\n";

				//�������� ��������� ����� �������� ��������� �������
				showNavigator(count($result), $offset, 10, "index.php?CID=".$CID."&");

				//�������� ������
				for ($i=$offset; $i<$min; $i++)
					showGood($result[$i],$s,true);

				showNavigator(count($result), $offset, 10, "index.php?CID=".$CID."&");

				echo "</center>\n";
			};

		}
		else { //�������� ��������� �������� -- ��������� ����� + ����������� ������ ���� ��������� + �����������

//			echo "������������";
//			if (isset($log)) echo ", <b>".stripslashes($log)."</b>";
//			echo "!<br>+ ����� �����������.........<br><br>\n";

			//��������� �������� � ������� -- � 2 �������, ������� ���� ��������� ���-�� �������� ��������� -- �������� � ���� �������,
			//�������� -- � ������
			$k=0;
			for ($i=0; $i<count($categories); $i++)
			  if (!$categories[$i][2]) $k++;

			echo "<table width=100% border=0>\n<tr><td width=50%>";
			$j=0;
			for ($i=0; $j<$k/2; $i++)
			  if (!$categories[$i][2]) { //���� ��� �������� ���������...
				showSubCategories($categories,$i);
				$j++;
			  };

			echo "</td>\n<td valign=top>\n";

			for (; $i<count($categories); $i++)
			  if (!$categories[$i][2]) //���� ��� �������� ���������...
				showSubCategories($categories,$i);

			echo "</td>\n</tr>\n</table>\n";
?>
</td>
<td width=100 valign=top>

<!-- ����� ������� ����� ��� ����. �����������, ����������� � ��. -->

<!-- ����� -->

<?

		};
	};

	echo "</td></tr>\n</table>\n";
	showNavigation($shopname);
?>



</body>
</html>