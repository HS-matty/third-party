<?php /* Smarty version 2.6.14, created on 2008-01-24 16:02:10
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/standart_form/string_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/_index/standart_form/string_edit.tpl', 22, false),)), $this); ?>
﻿
<?php if ($this->_tpl_vars['f']->Hidden): ?>
<input name= "<?php echo $this->_tpl_vars['f']->ID; ?>
" type="hidden" value="<?php echo $this->_tpl_vars['f']->Value; ?>
">
<?php elseif ($this->_tpl_vars['f']->View->Type == 'editor'): ?>
<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->isRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td>
<?php echo $this->_tpl_vars['f']->View->ViewObject->Create(); ?>
</td></tr>

<?php else: ?>
<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->isRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td>

	<?php if ($this->_tpl_vars['f']->View->Type == 'text'):  echo $this->_tpl_vars['f']->getValue(); ?>
 
	<?php else: ?>
		<?php if ($this->_tpl_vars['f']->EnumList): ?>
			<?php if ($this->_tpl_vars['f']->EnumNewStyle): ?>
				<select name="<?php echo $this->_tpl_vars['f']->ID; ?>
" class="inp2"  >
				<option value="" >List...</option>
				<?php $_from = $this->_tpl_vars['f']->EnumList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['e']):
?>
					<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['e'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['f']->Value == $this->_tpl_vars['e']): ?> selected <?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
				
				</select>
			<?php else: ?>
				<select name="<?php echo $this->_tpl_vars['f']->ID; ?>
" class="inp2"  >
				<option value="" >List...</option>
				<?php $_from = $this->_tpl_vars['f']->EnumList; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['e']):
?>
					<option value="<?php echo $this->_tpl_vars['e']; ?>
" <?php if ($this->_tpl_vars['f']->Value == $this->_tpl_vars['e']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['e']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
				
				</select>
			<?php endif; ?>
		<?php else: ?>
			<?php if ($this->_tpl_vars['f']->View->Type == 'textarea'): ?>
			<textarea class="inp3"  style="width:600px;" rows ="7" name="<?php echo $this->_tpl_vars['f']->ID; ?>
"><?php echo $this->_tpl_vars['f']->getValue(1); ?>
</textarea>
			<?php else: ?>
			<input name="<?php echo $this->_tpl_vars['f']->ID; ?>
" style="width:300px" <?php if ($this->_tpl_vars['f']->View->Type == 'password'): ?> type="password" <?php else: ?> type="text"  value="<?php echo $this->_tpl_vars['f']->getValue(); ?>
" <?php endif; ?>>
			<?php endif; ?>
		<?php endif; ?>

	<?php endif; ?>
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
<?php endif; ?>