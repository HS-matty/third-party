<?php /* Smarty version 2.6.14, created on 2008-01-30 16:12:37
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/list-menu_edit.tpl */ ?>
﻿
<?php $this->assign('title', $this->_tpl_vars['f']->ListValueTitle); ?>
<?php $this->assign('key', $this->_tpl_vars['f']->ListKeyTitle); ?>




<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->IsRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td><select name="<?php echo $this->_tpl_vars['f']->ID; ?>
" id="<?php echo $this->_tpl_vars['f']->ID; ?>
" <?php echo $this->_tpl_vars['f']->JavaScript; ?>
 style="width:250px">

<option value="0">Список</option>
<?php $_from = $this->_tpl_vars['f']->ListValue; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<option value="<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['key']]; ?>
" <?php if ($this->_tpl_vars['f']->Value == $this->_tpl_vars['item'][$this->_tpl_vars['key']]): ?> selected <?php endif; ?>> <?php echo $this->_tpl_vars['item'][$this->_tpl_vars['title']]; ?>
</option>
<?php endforeach; endif; unset($_from); ?>

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