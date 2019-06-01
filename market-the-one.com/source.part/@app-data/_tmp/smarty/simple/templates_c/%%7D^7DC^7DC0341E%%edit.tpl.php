<?php /* Smarty version 2.6.14, created on 2017-04-27 19:49:22
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/simple/%40ui/%40element/form/%40el/select/edit.tpl */ ?>
	 	<select id = "<?php echo $this->_tpl_vars['field']->name; ?>
" name="<?php echo $this->_tpl_vars['field']->name;  if ($this->_tpl_vars['field']->is_multiple): ?>[]<?php endif; ?>">
			<option style="font-weight:bold;font-style:italic" value=""> &nbsp </option>
				<?php $_from = $this->_tpl_vars['field']->options->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['option']):
?>
					<option <?php if ($this->_tpl_vars['field']->getValue() == $this->_tpl_vars['option']->value): ?> selected <?php endif; ?> value="<?php echo $this->_tpl_vars['option']->value; ?>
"><?php echo $this->_tpl_vars['option']->title; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
							
	</select>
						
					