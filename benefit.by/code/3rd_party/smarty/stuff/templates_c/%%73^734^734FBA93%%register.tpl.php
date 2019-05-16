<?php /* Smarty version 2.6.14, created on 2008-01-11 00:37:07
         compiled from z:%5Chome%5Cbenefitby%5Cwww/application/views/auth/register.tpl */ ?>
﻿			
					<!-- InstanceBeginEditable name="content" -->
					<form method="post" action="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/register/">
						<div id="postPage">
							<h3>Регистрация</h3>
						
							<table width="100%" cellpadding="3" cellspacing="0">
								<tr>
									<?php $this->assign('f', $this->_tpl_vars['Form']->getField('first_name')); ?>
									<td align="right" width="120">Имя</td>
									<td><input type="text" name="first_name"  value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
"/>
										<?php if ($this->_tpl_vars['f']->Errors): ?>
									<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from);  endif; ?>
									</td>
								</tr>
								<tr>
																<?php $this->assign('f', $this->_tpl_vars['Form']->getField('last_name')); ?>
									<td align="right">Фамилия</td>
									<td><input type="text" name="last_name"   value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
"/>
										<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from);  endif; ?>
									</td>

								</tr>
								<tr>
								<?php $this->assign('f', $this->_tpl_vars['Form']->getField('email')); ?>
									<td align="right"><span class="red">*</span>Email</td>
									<td><input type="text"  name="email"  value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
"/>
													<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from);  endif; ?></td>
								</tr>
								<tr>
								<?php $this->assign('f', $this->_tpl_vars['Form']->getField('phone_number')); ?>
									<td align="right">Телефон</td>

									<td><input type="text" name="phone_number"  value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
" />
										<?php if ($this->_tpl_vars['f']->Errors): ?>	<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from);  endif; ?>
									</td>
								</tr>
								<tr>
									<?php $this->assign('f', $this->_tpl_vars['Form']->getField('password')); ?>
									<td align="right"><span class="red">*</span>Пароль</td>
									<td><input type="password" name="password"  />
									<?php if ($this->_tpl_vars['f']->Errors): ?>	<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from);  endif; ?></td>
								</tr>
								<tr>
									<?php $this->assign('f', $this->_tpl_vars['Form']->getField('confirm_password')); ?>
									
									<td align="right"><span class="red">*</span>Повторение пароля</td>

									<td><input type="password" name="confirm_password"  />
									
									<?php if ($this->_tpl_vars['f']->Errors): ?>	<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from);  endif; ?></td>
								</tr>
							</table>
							<br />
							<h5>&nbsp;</h5>
							<br />
							<div align="center">
							<input type="hidden" name="post" value="1">
								<input name="register_button" id="register_button" type="submit" value="Submit"/>							</div>

						</div>
						</form>
					<!-- InstanceEndEditable -->
			
			