<?php /* Smarty version 2.6.14, created on 2014-05-10 12:57:14
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/front/tpl/%40ui/%40element/form/%40el/select.tpl */ ?>

			  <div class="control-group <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?> error <?php endif; ?>">
				<label class="control-label" for="inputEmail"><?php echo $this->_tpl_vars['field']->getTitle(); ?>
 <?php if ($this->_tpl_vars['field']->getParam('is_required')): ?><font color="red">*</font><?php endif; ?></label>
				<div class="controls">
							
					<select id  = "<?php echo $this->_tpl_vars['field']->name; ?>
" name="<?php echo $this->_tpl_vars['field']->name;  if ($this->_tpl_vars['field']->is_multiple): ?>[]<?php endif; ?>" <?php if ($this->_tpl_vars['field']->is_multiple): ?> multiple <?php if ($this->_tpl_vars['field']->size): ?>size="<?php echo $this->_tpl_vars['field']->size; ?>
" <?php else: ?> size="20"<?php endif; ?> <?php endif; ?> <?php if ($this->_tpl_vars['field']->is_test): ?>onChange="test(this.value)<?php endif; ?>">
							<option style="font-weight:bold;font-style:italic" value="">...</option>
						<?php $_from = $this->_tpl_vars['field']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['option']):
?>
							<option <?php if ($this->_tpl_vars['field']->getValue() == $this->_tpl_vars['option']->value): ?> selected <?php endif; ?> value="<?php echo $this->_tpl_vars['option']->value; ?>
">&nbsp<?php echo $this->_tpl_vars['option']->title; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					</select>
		
				  <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?>
							<?php $_from = $this->_tpl_vars['field']->getErrorMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?>
								<span class="help-inline"><?php echo $this->_tpl_vars['message']; ?>
</span>
						<?php endforeach; endif; unset($_from); ?>
				  <?php endif; ?>
				</div>
			</div>		  
				

