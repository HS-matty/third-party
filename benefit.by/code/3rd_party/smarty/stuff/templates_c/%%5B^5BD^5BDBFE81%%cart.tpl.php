<?php /* Smarty version 2.6.14, created on 2008-02-11 00:09:43
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/default/cart.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'strip_tags', 'Z:\\home\\benefitby\\www/application/views/default/cart.tpl', 5, false),array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/default/cart.tpl', 5, false),)), $this); ?>
﻿
<?php if ($this->_tpl_vars['Items']): ?>
<table cellpadding=3 border=1 width=30%>
	<?php $_from = $this->_tpl_vars['Items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
	<tr><td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['c']['company'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td><td width="30%"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/item/?listing_id=<?php echo $this->_tpl_vars['c']['listing_id']; ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['c']['short_description'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
	<td><a href="?id=<?php echo $this->_tpl_vars['c']['listing_id']; ?>
&delete=1">Удалить</a></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	</table>
	
	
<?php else: ?>
Корзина пуста
<?php endif; ?>