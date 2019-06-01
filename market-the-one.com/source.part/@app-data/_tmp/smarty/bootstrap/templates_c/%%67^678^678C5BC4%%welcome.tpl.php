<?php /* Smarty version 2.6.14, created on 2017-05-04 20:05:58
         compiled from %40mail/welcome.tpl */ ?>
<html>
	<h2>Welcome to <a href="http://market-the-one.com">market-the-one.com</a></h2>


	<?php echo $this->_tpl_vars['var_list']; ?>

	Your information:
	<ul>
		<li>name: <?php echo $this->_tpl_vars['user_to']->getFieldValue('name'); ?>
 </li>
		<li>email: <?php echo $this->_tpl_vars['user_to']->getFieldValue('email'); ?>
 </li>
	</ul>
<br>
	 Login: <a href="http://market-the-one.com/login">http://market-the-one.com/login</a>
	 
	 
	 <br><br>
	 
	 
	 <a href="market-the-one.com">market-the-one.com</a>


</html>