<?php /* Smarty version 2.6.14, created on 2017-05-15 20:55:30
         compiled from /%40ui/%40element/form/view.tpl */ ?>
		

				<table border=0>
				
				<?php $_from = $this->_tpl_vars['ui_element']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>

											
						  
					
					
						<?php if (! $this->_tpl_vars['field']->view->is_allowed == 1): ?>
						
							<tr>
								<td   class="form_td_title" style="text-align:right;vertical-align:top;padding-right:0px"><b><?php echo $this->_tpl_vars['field']->getTitle(); ?>
:</b> </td>
								<td  style="padding-top:5px;padding-left:10px;vertical-align:top;"><?php echo $this->_tpl_vars['field']->getValueString(); ?>
</td>
							</tr>
						
						<?php endif; ?>			
				
				<?php endforeach; endif; unset($_from); ?>
				
				
				</table>
		
		