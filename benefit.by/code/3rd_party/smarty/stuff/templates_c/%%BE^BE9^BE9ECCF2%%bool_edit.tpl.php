<?php /* Smarty version 2.6.14, created on 2008-02-04 16:37:14
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/standart_form/bool_edit.tpl */ ?>
﻿
<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->isRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td><select name="<?php echo $this->_tpl_vars['f']->ID; ?>
" style="width:100px" <?php if ($this->_tpl_vars['f']->isLocked): ?> disabled <?php endif; ?>>

<option value="1" <?php if ($this->_tpl_vars['f']->getValue() == 1): ?> selected <?php endif; ?>> 
Да</option>
<option value="0" <?php if ($this->_tpl_vars['f']->getValue() == 0): ?> selected <?php endif; ?>> 
Нет</option>

</select>
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