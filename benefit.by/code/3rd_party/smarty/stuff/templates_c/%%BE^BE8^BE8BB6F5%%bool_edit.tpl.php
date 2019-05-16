<?php /* Smarty version 2.6.14, created on 2007-12-25 23:02:45
         compiled from z:/home/benefitby/www/application/views/_index/bool_edit.tpl */ ?>

<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->IsRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td><select name="<?php echo $this->_tpl_vars['f']->ID; ?>
" style="width:100px">

<option value="2" <?php if ($this->_tpl_vars['f']->Value == 1): ?> selected <?php endif; ?>> 
Yes</option>
<option value="1" <?php if ($this->_tpl_vars['f']->Value == 0): ?> selected <?php endif; ?>> 
No</option>

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