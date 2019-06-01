<?php /* Smarty version 2.6.14, created on 2017-05-06 14:39:23
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/smart-admin/%40ui/%40element/form/edit.tpl */ ?>

			<fieldset>
			
							<?php $_from = $this->_tpl_vars['ui_element']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
								<div class="row">
								<?php if ($this->_tpl_vars['field']->getParam('is_primary_key')): ?>
									<section class="col col-6">
										<label class="label"><strong><?php echo $this->_tpl_vars['field']->getTitle(); ?>
</strong> </label>
		
										<strong><?php echo $this->_tpl_vars['field']->getValue(); ?>
</strong>
	
									</section>
								<?php else: ?>
								
								
								<?php $this->assign('template_file', $this->_tpl_vars['tpl']->getTemplate($this->_tpl_vars['field']->type,'edit',$this->_tpl_vars['field']->type_db)); ?>
								<section class="col col-6">
									<label class="label"><strong><?php echo $this->_tpl_vars['field']->getTitle(); ?>
</strong> <?php if ($this->_tpl_vars['field']->getParam('is_required')): ?><font color="red">*</font><?php endif; ?> </label>
									<label class="input <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?>state-error <?php elseif ($this->_tpl_vars['ui_element']->getParam('is_submited')): ?> state-success <?php endif; ?>">
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['template_file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</label>
									<em id="name-error" class="invalid">
										<?php if ($this->_tpl_vars['field']->getErrorFlag()): ?>
											<?php $_from = $this->_tpl_vars['field']->getErrorMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?>
											<?php echo $this->_tpl_vars['message']; ?>
<br>
											<?php endforeach; endif; unset($_from); ?>
										<?php endif; ?>
									
										</em>
									
								</section>
							
					
								
								<?php endif; ?>
								
								
								
								
								</div>
							<?php endforeach; endif; unset($_from); ?>
							
							
							<input type="hidden" name="post" value="1">
							<?php if ($this->_tpl_vars['ui_element']->id): ?><input type="hidden" name="form_id" value="<?php echo $this->_tpl_vars['ui_element']->id; ?>
"><?php endif; ?>
							</fieldset>


		
				<!--table border=0>
				
				
				<?php $_from = $this->_tpl_vars['ui_element']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>

					
						<?php if ($this->_tpl_vars['field']->getParam('is_primary_key')): ?>
						<tr>
								<td  class="form_td_title" style="text-align:right;vertical-align:top;padding-right:19px"><b><?php echo $this->_tpl_vars['field']->getTitle(); ?>
:</b> </td>
								<td style="padding-top:5px;padding-left:0px;vertical-align:top;"><?php echo $this->_tpl_vars['field']->getValueString(); ?>
</td>
						</tr>
						<input type="hidden" name="_<?php echo $this->_tpl_vars['field']->getName(); ?>
" value="<?php echo $this->_tpl_vars['field']->getValue(); ?>
">
					
						<?php elseif (! $this->_tpl_vars['field']->edit->is_allowed == 1): ?>
							
					  <tr>
						<td class="form_td_title"><b><?php echo $this->_tpl_vars['field']->getTitle(); ?>
</b>: <?php if ($this->_tpl_vars['field']->getParam('is_required')): ?><font color="red">*</font><?php endif; ?> </td>
							<td class="form_td_input">  
							<?php $this->assign('template_file', $this->_tpl_vars['tpl']->getTemplate($this->_tpl_vars['field']->type,'edit',$this->_tpl_vars['field']->type_db)); ?>
							
							
					
							
							
							
							  <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?>
									<?php $_from = $this->_tpl_vars['field']->getErrorMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?><br>
										<span class="help-inline" style="color:red"><em><?php echo $this->_tpl_vars['message']; ?>
</em></span>
								<?php endforeach; endif; unset($_from); ?>
						  <?php endif; ?>
						</td>
					</tr>
					 
								
						  
					
					
						<?php elseif (! $this->_tpl_vars['field']->view->is_not_allowed == 1): ?>
							
							<tr>
								<td  style="text-align:right;vertical-align:top;padding-right:0px" class="form_td_title"><b><?php echo $this->_tpl_vars['field']->getTitle(); ?>
:</b> </td>
								<td><?php echo $this->_tpl_vars['field']->getValueString(); ?>
</td>
							</tr>
						
						<?php endif; ?>			
				
				<?php endforeach; endif; unset($_from); ?>
				
				<tr>
					<td  colspan="2" style="padding:10px;text-align:center">
						<?php if ($this->_tpl_vars['ui_element']->id): ?><input type="hidden" name="form_id" value="<?php echo $this->_tpl_vars['ui_element']->id; ?>
"><?php endif; ?>
						<input type="hidden" name="post" value="1">
						<button type="submit" class="btn">Send</button>
					
						
					</td>
				</tr>
				</table-->
		