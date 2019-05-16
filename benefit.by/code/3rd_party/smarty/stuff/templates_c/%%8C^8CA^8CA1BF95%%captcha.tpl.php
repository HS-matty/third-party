<?php /* Smarty version 2.6.14, created on 2007-10-30 19:11:11
         compiled from z:/home/barefoot_zend/www/application/views/frontend/_index/captcha.tpl */ ?>
							<tr style="vertical-align: middle;" height="50px">
								<td align="right">Code<?php if ($this->_tpl_vars['f']->IsRequired): ?><font color="red">*</font><?php endif; ?>:</td>
						<td  >
						<table><tr><td>
						<?php $this->assign('f', $this->_tpl_vars['Form']->getField('captcha')); ?>
			<input style="vertical-align: middle;padding:0" type="text" name="captcha" size="10" value="" ></td><td>
			<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/image.php" border=0 style="padding:0">
									<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
						</td></tr></table>
						</td>
							</tr>