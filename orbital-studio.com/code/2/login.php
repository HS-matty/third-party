<?

session_start();
$our_pass="sony210";


if (!session_is_registered("login")  ){

	if(isset($pass) && ($pass)){


		substr($pass, 0, 20);
		$pass = trim(str_replace("'","",stripslashes($pass)));
		if($pass==$our_pass) 
		{
			session_register("login");
			header("Location: 1.html");
			}


		else {
			sh_html();
			exit;
			}
	}

	else {
		sh_html();
		}
	
	
}
else print "you've already logined!";







function sh_html(){

print "<form name='check_password' method='post' action='login.php'>";
print "<br>  Enter password: <input type='password' name='pass' size='20' maxlength='40'>";
print " <br><input type='submit' name='Submit' value='Submit'></form>";
	}

?>