<? //�������� �� ����������������� ������

	if (isset($log)) { //���������, ���� �� ����� ������������ � ���� ������
		$q = mysql_query("SELECT Login, Password FROM Users WHERE Login='$log'") or die (mysql_error());
		$row = mysql_fetch_row($q);
		if (!$row || !isset($pass) || $row[1] != $pass) { //���� ������������ �� ������ � ���� ������ ��� ������ �� �� �� ���������
					//c ���������, �� ������� ���������� log � pass (�.�. ������� � ����� ���������� ������������)
			session_unregister("log");
			session_unregister("pass");
			unset($log);
			unset($pass);
		};
	};
?>