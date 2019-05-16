<?php /* Smarty version 2.6.14, created on 2008-02-08 13:52:14
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/auth/forgot_password.tpl */ ?>
﻿
<?php if ($this->_tpl_vars['success']): ?>
	<h3>Восстановление пароля</h3>
	<br />
	<h1>Пароль выслан на вам на емаил</h1>
<?php else: ?>

<form method="POST" enctype="multipart/form-data"  id="add_form">

					<!-- InstanceBeginEditable name="content" -->
						<div id="postPage">
							<h3>Восстановление пароля</h3>
							<br />
						
							<table width="100%" cellpadding="3" cellspacing="0">
	<tr>
									<?php $this->assign('f', $this->_tpl_vars['Form']->getField('email')); ?>
									<td width="46%" align="right" >Email:</td>
									<td colspan=2><input value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
" type="text" name="email" />	<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
	
								</tr>
							
							<tr style="vertical-align: middle;" height="50px">
								<td align="right">Code:</td>
						<td align="left" width="100">
						<?php $this->assign('f', $this->_tpl_vars['Form']->getField('captcha')); ?>
			<input style="align:left;vertical-align: middle;padding:0" type="text" name="captcha" size="10" value="" >
				<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
			</td><td>
			<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/image.php" border=0 style="padding:0">
								
						</td>
							</tr>
							</table>
							
								<div align="center">	<input type="submit" class="button" value="Отправить"></div>
							</div>

					
					<!-- InstanceEndEditable -->
					<input type="hidden" name="post" value="1">
					</form>
					
					<?php endif; ?>