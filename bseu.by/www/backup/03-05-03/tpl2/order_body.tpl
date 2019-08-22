<form name="check login" method="post" action="order.php?login=1">
  <p>if you have already registered you can enter your login and password</p>
  <p>
    Login<input type="text" name="login_entered"><br>
	Password<input type='password' name="password_entered"><br>
<input type='submit' name='submit' value='submit'>
</form>
if not, please fill the registratin form. <br>

<form name="registrarion" method="post" action="order.php">
   First name <input type="first_name" name="textfield"><br>
   Last name <input type="last_name" name="textfield"><br>
   Address <input type="text" name="address"><br>
   login <input type="text" name="reg_login"><br>
   Enter password<input type="password" name="reg_pass_1"><br>
   Retype passowrd<input type="password" name="reg_pass_2"><br>
 <input type='submit' name='submit' value='register'>

</form>