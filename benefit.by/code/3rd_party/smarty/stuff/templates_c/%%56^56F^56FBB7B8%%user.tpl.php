<?php /* Smarty version 2.6.14, created on 2007-11-03 01:26:17
         compiled from z:/home/barefoot_zend/www/application/views/frontend/admin/user.tpl */ ?>
Listings - total: <b><?php echo $this->_tpl_vars['Stats']['total']; ?>
</b>, active: <b><?php echo $this->_tpl_vars['Stats']['is_active']; ?>
</b>, expired: <b><?php echo $this->_tpl_vars['Stats']['is_expired']; ?>
</b>, <a href="<?php echo $this->_tpl_vars['HostName']; ?>
/admin/listings/?user_id=<?php echo $this->_tpl_vars['user_id']; ?>
&post=1">see list</a>
<br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('form.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>