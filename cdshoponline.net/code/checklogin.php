<? //проверка на санкционированный доступ

	if (isset($log)) { //проверить, есть ли такой пользователь в базе данных
		$q = mysql_query("SELECT Login, Password FROM Users WHERE Login='$log'") or die (mysql_error());
		$row = mysql_fetch_row($q);
		if (!$row || !isset($pass) || $row[1] != $pass) { //если пользователь не найден в базе данных или пароль из БД не совпадает
					//c введенным, то удалить переменные log и pass (т.е. перейти в режим анонимного пользователя)
			session_unregister("log");
			session_unregister("pass");
			unset($log);
			unset($pass);
		};
	};
?>