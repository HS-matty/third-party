<?php /* Smarty version 2.6.14, created on 2008-01-13 15:41:26
         compiled from z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/standart_form/file_edit.tpl */ ?>
﻿

<tr>
<td align="right" width="130" valign="top"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->isRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td>


<?php if ($this->_tpl_vars['f']->FileType == 'image'): ?>
	<?php if ($this->_tpl_vars['f']->Value): ?><a href="<?php echo $this->_tpl_vars['HostName'];  echo $this->_tpl_vars['f']->FilePath;  echo $this->_tpl_vars['f']->Value; ?>
" target="_blank">View image</a>
<br>
<div class="form_item_title">delete image</div>
<input type="checkbox" name="<?php echo $this->_tpl_vars['f']->ID; ?>
_image_delete" value="checkbox" />

<?php else: ?> no image loaded
<?php endif; ?>

	
<?php endif; ?>




<div class="form_item_title"></div> <input name="<?php echo $this->_tpl_vars['f']->ID; ?>
" type="file" />
	<?php if ($this->_tpl_vars['f']->Errors): ?>
		<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
			<div class="form_item_error"><?php echo $this->_tpl_vars['e']; ?>
</div>
		<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
</div>
</td></tr>