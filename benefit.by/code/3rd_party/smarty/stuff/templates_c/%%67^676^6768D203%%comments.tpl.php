<?php /* Smarty version 2.6.14, created on 2008-02-10 03:15:50
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/default/comments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'Z:\\home\\benefitby\\www/application/views/default/comments.tpl', 5, false),array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/default/comments.tpl', 5, false),)), $this); ?>
﻿Комментарии для записи <a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/item/?listing_id=<?php echo $this->_tpl_vars['Listing']->getItemId(); ?>
"><?php echo $this->_tpl_vars['Listing']->Data['short_description']; ?>
</a><br /><br />
<?php if ($this->_tpl_vars['Items']): ?>
<table cellpadding=3 border=1 width=100%>
	<?php $_from = $this->_tpl_vars['Items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
	<tr><td width="30%"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['c']['short_description'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['c']['long_description'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)); ?>
</td></tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
	
	
<?php else: ?>
Нет комментариев
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('standart_form/form.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>