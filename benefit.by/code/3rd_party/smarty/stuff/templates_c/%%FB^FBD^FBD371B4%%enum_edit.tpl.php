<?php /* Smarty version 2.6.14, created on 2008-02-05 01:32:52
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/standart_form/enum_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/_index/standart_form/enum_edit.tpl', 11, false),)), $this); ?>
﻿

<tr>
<td align="right" width="130"><?php echo $this->_tpl_vars['f']->Title;  if ($this->_tpl_vars['f']->isRequired): ?><font color="red">*</font><?php endif; ?>:</td>
<td>

			<select name="<?php echo $this->_tpl_vars['f']->ID; ?>
" class="inp2"  >
				<option value="" >List...</option>
				<?php $_from = $this->_tpl_vars['f']->Type->ListValues; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['e']):
?>
				
					<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" <?php if ($this->_tpl_vars['f']->getValue() == $this->_tpl_vars['key']): ?> selected <?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['e'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
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