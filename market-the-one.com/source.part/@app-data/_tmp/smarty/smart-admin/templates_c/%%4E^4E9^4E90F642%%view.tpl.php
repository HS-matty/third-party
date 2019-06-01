<?php /* Smarty version 2.6.14, created on 2017-05-06 14:39:20
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/smart-admin/%40ui/%40element/form/view.tpl */ ?>
		


				
											<fieldset>
												
									<?php $_from = $this->_tpl_vars['ui_element']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
										<?php if (! $this->_tpl_vars['field']->view->is_allowed == 1): ?>
												<section>
													<label class="label"><strong><?php echo $this->_tpl_vars['field']->getTitle(); ?>
:</strong></label>
													<label class="input">
																	<?php echo $this->_tpl_vars['field']->getValueString(); ?>

													</label>
													<?php if ($this->_tpl_vars['field']->note): ?>
														<div class="note">
															<?php echo $this->_tpl_vars['field']->note->getValue(); ?>

														</div>
													<?php endif; ?>
												</section>
										<?php endif; ?>										
									<?php endforeach; endif; unset($_from); ?>
											
											</fieldset>