<?php /* Smarty version 2.6.14, created on 2017-05-16 15:54:36
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/bootstrap/__default.tpl */ ?>

<?php $_from = $this->_tpl_vars['window']->workspace; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['ui_element']):
?>
	
	<?php $this->assign('type', $this->_tpl_vars['ui_element']->getType()); ?>

	
	<?php echo $this->_tpl_vars['page']->setCurrentUiElement($this->_tpl_vars['ui_element']); ?>

	

	<?php $this->assign('file', "/@ui/@element/".($this->_tpl_vars['type']).".tpl"); ?>

	
	<?php if ($this->_tpl_vars['type']): ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?>
	
	
<?php endforeach; endif; unset($_from); ?>