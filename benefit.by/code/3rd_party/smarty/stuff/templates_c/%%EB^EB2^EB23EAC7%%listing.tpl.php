<?php /* Smarty version 2.6.14, created on 2008-02-14 01:04:29
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/default/listing.tpl */ ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('form.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['Form']->Action == 'view'): ?>
<br />
<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/comments/?id=<?php echo $this->_tpl_vars['Listing']->getItemId(); ?>
">Комментарии</a> | <a href="?listing_id=<?php echo $this->_tpl_vars['Listing']->getItemId(); ?>
&cart=1">В корзину</a>
<?php endif; ?>