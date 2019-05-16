<?php /* Smarty version 2.6.14, created on 2007-10-30 21:52:11
         compiled from z:/home/barefoot_zend/www/application/views/frontend/page/contact.tpl */ ?>
<div id="postPage">
							<h3>Contact Us</h3>
							
							Please do not hesitate to contact us with absolutely anything. The phone number given below is 
							my cell phone number. Or you can send me an email or fill out the form below and I'll do my best 
							to respond as quickly as possible. 
							<br>Thanks! - Hunter
							<br><br>
							Hunter Jensen<br>
							Founder, Barefoot Listings<br>
							<a href="mailto:contact@barefootlistings.com">contact@barefootlistings.com</a><br>

							858.442.0734
							<br><br>
							<h3>Send a Message to Barefoot Listings</h3>
							<form action="" method="post">
								<table style="padding-left: 0px;" cellpadding="5" cellspacing="0">
									<tbody>
									<tr>
										<?php $this->assign('f', $this->_tpl_vars['Form']->getField('name')); ?>
										<td style="text-align: right;">Name</td>
										<td><input size="40" name="name" type="text" value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
">
											<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
							<?php endif; ?>
										</td>

									</tr>
									<tr>
										<?php $this->assign('f', $this->_tpl_vars['Form']->getField('email')); ?>
										<td style="text-align: right;"><span class="red">*</span>Email</td>
										<td><input size="40" name="email" type="text" value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
">
											<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
							<?php endif; ?>
										</td>

									</tr>
										<?php $this->assign('f', $this->_tpl_vars['Form']->getField('phone_number')); ?>
									<tr>
										<td style="text-align: right;">Phone</td>
										<td>
										<input type="text" name="phone_number" value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
" size="40" />
																									<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
										
										</td>
									</tr>
											<?php $this->assign('f', $this->_tpl_vars['Form']->getField('subject')); ?>
									<tr>
										<td style="text-align: right;">Subject</td>
										<td>
										<input type="text" name="subject" value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
" size="30" />
													<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
										
										</td>
									</tr>
										<?php $this->assign('f', $this->_tpl_vars['Form']->getField('text')); ?>
									<tr>
										<td style="text-align: right;" valign="top"><span class="red">*</span>Message</td>

										<td><textarea cols="50" rows="5" name="text"><?php echo $this->_tpl_vars['f']->getValue(); ?>
</textarea>
											<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
										</td>
									</tr>
								<tr>
								<?php $this->assign('f', $this->_tpl_vars['Form']->getField('captcha')); ?>
										<td style="text-align: right;"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/image.php" border=0 style="padding:0"></td>
										<td>	<input style="vertical-align: middle;padding:0" type="text" name="captcha" size="10" value="" >
									
													<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
										
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: right;"><input value="Send Message" type="submit"></td>
									</tr>
								</tbody></table>
								<input type="hidden" name="post" value=1>
							</form>
						</div>