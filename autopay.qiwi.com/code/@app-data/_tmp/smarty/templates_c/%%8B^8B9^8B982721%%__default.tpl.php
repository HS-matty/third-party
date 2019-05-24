<?php /* Smarty version 2.6.14, created on 2014-05-10 12:02:31
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/front/tpl/__default.tpl */ ?>
<?php $_from = $this->_tpl_vars['window']->workspace; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['ui_element']):
?>
	
	<?php $this->assign('type', $this->_tpl_vars['ui_element']->getType()); ?>

	
	<?php $this->assign('file', "/@ui/@element/".($this->_tpl_vars['type']).".tpl"); ?>

	<?php if ($this->_tpl_vars['debug']->getDebugLevel()): ?>
	<ul>
		<li><?php echo $this->_tpl_vars['type']; ?>
: <?php echo $this->_tpl_vars['file']; ?>
</li>
	</ul>
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['type']): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?>
	
<?php endforeach; endif; unset($_from); ?>