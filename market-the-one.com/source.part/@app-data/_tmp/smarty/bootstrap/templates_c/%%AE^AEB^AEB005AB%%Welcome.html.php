<?php /* Smarty version 2.6.14, created on 2017-05-12 13:48:34
         compiled from file:D:%5Cdev%5Cweb-server-root%5Ccms/Static/Mail/Letter/Welcome.html */ ?>
<html>
	<h2>Welcome to <a href="http://market-the-one.com">market-the-one.com</a></h2>


	Your information:
	<ul>
		<li>name: <?php echo $this->_tpl_vars['user_to']->getFieldValue('nickname'); ?>
 </li>
		<li>email: <?php echo $this->_tpl_vars['user_to']->getFieldValue('email'); ?>
 </li>
	</ul>
<br>
	 Change password: <a href="http://market-the-one.com/change_password?token=<?php echo $this->_tpl_vars['change_password_token']; ?>
">http://market-the-one.com/login</a>
	 
	 
	 <br><br>
	 
	 -- </br>
	 Siarhei Vauchok
	 </br>
	 Cell: +375 33 3125 434
	 </br>
	 Skype: sbajan
	 </br>
	 Page: <a href="market-the-one.com">http://matty.market-the-one.com</a>
	 </br>
	 
	 <br></br>
	 <!--a href="market-the-one.com">market-the-one.com</a-->


</html>