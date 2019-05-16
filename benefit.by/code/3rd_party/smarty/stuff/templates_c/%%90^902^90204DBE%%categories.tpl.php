<?php /* Smarty version 2.6.14, created on 2007-12-13 23:47:38
         compiled from z:/home/benefitby/www/application/views/admin/categories.tpl */ ?>
<p>
<?php $_from = $this->_tpl_vars['TreePath']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/categories/?category_id=<?php echo $this->_tpl_vars['p']['category_id']; ?>
"><?php echo $this->_tpl_vars['p']['short_description']; ?>
 </a> / 
<?php endforeach; endif; unset($_from); ?>
</p>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('grid.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>