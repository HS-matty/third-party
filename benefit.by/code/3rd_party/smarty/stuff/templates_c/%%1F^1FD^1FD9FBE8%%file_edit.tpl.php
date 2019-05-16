<?php /* Smarty version 2.6.14, created on 2008-01-30 16:13:35
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/file_edit.tpl */ ?>
﻿

<tr>
<td align="right" width="130" valign="top"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->IsRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td>


<?php if ($this->_tpl_vars['f']->FileType == 'image'): ?>
	<?php if ($this->_tpl_vars['f']->Value): ?><a href="<?php echo $this->_tpl_vars['HostName'];  echo $this->_tpl_vars['f']->FilePath;  echo $this->_tpl_vars['f']->Value; ?>
" target="_blank">просмотреть</a>
<br>
<div class="form_item_title">Удалить изображение</div>
<input type="checkbox" name="<?php echo $this->_tpl_vars['f']->ID; ?>
_image_delete" value="checkbox" />

<?php else: ?> не загружено
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