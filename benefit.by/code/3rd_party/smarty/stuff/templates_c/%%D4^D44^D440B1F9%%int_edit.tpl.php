<?php /* Smarty version 2.6.14, created on 2007-12-19 17:02:53
         compiled from z:/home/benefitby/www/application/views/_index/int_edit.tpl */ ?>
<?php if ($this->_tpl_vars['f']->Hidden): ?>
<input name= "<?php echo $this->_tpl_vars['f']->ID; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['f']->Value; ?>
">
<?php elseif ($this->_tpl_vars['f']->Datasource): ?>
<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->IsRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td>
<div id="<?php echo $this->_tpl_vars['f']->ID; ?>
_user_value" style="float:left;">
<?php if ($this->_tpl_vars['f']->PostedValue):  echo $this->_tpl_vars['f']->PostedValue;  elseif ($this->_tpl_vars['f']->ViewValue):  echo $this->_tpl_vars['f']->ViewValue;  elseif ($this->_tpl_vars['f']->ViewValues): ?>
<?php $_from = $this->_tpl_vars['f']->ViewValues; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
<?php echo $this->_tpl_vars['vv']; ?>
 
<?php endforeach; endif; unset($_from); ?>
<?php elseif ($this->_tpl_vars['f']->Value):  echo $this->_tpl_vars['f']->Value;  else: ?>empty<?php endif; ?></div>
&nbsp&nbsp&nbsp<a class="link" href="#" onClick="window.open('<?php echo $this->_tpl_vars['f']->Datasource->Link; ?>
?id=<?php echo $this->_tpl_vars['f']->ID; ?>
', 'popup', 'width=800,height=600,scrollbars=1');">browse</a>


<input id="<?php echo $this->_tpl_vars['f']->ID; ?>
" name= "<?php echo $this->_tpl_vars['f']->ID; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['f']->Value; ?>
">
<input id="<?php echo $this->_tpl_vars['f']->ID; ?>
_puser_value" name= "<?php echo $this->_tpl_vars['f']->ID; ?>
_puser_value" type="hidden" value="<?php echo $this->_tpl_vars['f']->ID_puser_value; ?>
">

	<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
</tr>


<?php else: ?>
<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->IsRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td><input name="<?php echo $this->_tpl_vars['f']->ID; ?>
" type="text" value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
">
	<?php if ($this->_tpl_vars['f']->Errors): ?>
							<?php $_from = $this->_tpl_vars['f']->Errors; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
								<br><span class="error_message"><?php echo $this->_tpl_vars['e']; ?>
</span>
							<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?></td>
</tr>
<?php endif; ?>