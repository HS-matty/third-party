<?php /* Smarty version 2.6.14, created on 2017-05-15 20:59:58
         compiled from /App/Front/%40Ui/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/App/Front/@Ui/form.tpl', 38, false),)), $this); ?>

				

			
			
			
				<?php if ($this->_tpl_vars['form']->getPrimaryKeyField()): ?>
					
					<?php $this->assign('primary_key_field', $this->_tpl_vars['form']->getPrimaryKeyField()); ?>
						
				<?php endif; ?>
				
				

				<table border=0>
				
				<?php $_from = $this->_tpl_vars['form']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>

				
				
						<?php $this->assign('value', $this->_tpl_vars['field']->getValue()); ?>
																	
						  
					
											
							<tr>
								<td   class="form_td_title" style="text-align:right;vertical-align:top;padding-right:0px"><b><?php echo $this->_tpl_vars['field']->getTitle(); ?>
:</b> </td>
								
								
								<td  style="padding-top:5px;padding-left:10px;vertical-align:top;">
						
								
									<?php if ($this->_tpl_vars['value']->getParam('class') == 'url'): ?>
									
										<?php if ($this->_tpl_vars['value']->getParam('url_type') == 'redirect'): ?>
											
											
											<a href="<?php echo $this->_tpl_vars['host_name']; ?>
/redirect/?url=<?php echo ((is_array($_tmp=$this->_tpl_vars['field']->getValueString())) ? $this->_run_mod_handler('escape', true, $_tmp, 'url') : smarty_modifier_escape($_tmp, 'url')); ?>
" target="_blank"><?php echo $this->_tpl_vars['field']->getValueString(); ?>
</a>
											
										<?php else: ?>
											<a href="<?php echo $this->_tpl_vars['field']->getValueString(); ?>
&<?php echo $this->_tpl_vars['field']->getParam('url_params'); ?>
" target="_blank"><?php echo $this->_tpl_vars['field']->getValueString(); ?>
</a>
										<?php endif; ?>
										
									<?php elseif ($this->_tpl_vars['field']->getType() == 'image'): ?>
								
										<img src="<?php echo $this->_tpl_vars['field']->getValue(); ?>
" alt="<?php echo $this->_tpl_vars['field']->getTitle(); ?>
">
									
									<?php else:  echo $this->_tpl_vars['field']->getValueString();  endif; ?>
									
								</td>
								
							</tr>
						
					
				
				<?php endforeach; endif; unset($_from); ?>
				
				
				</table>