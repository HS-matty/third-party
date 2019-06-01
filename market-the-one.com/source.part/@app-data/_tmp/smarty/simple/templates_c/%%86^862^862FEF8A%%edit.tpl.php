<?php /* Smarty version 2.6.14, created on 2017-04-27 20:18:52
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/simple/%40ui/%40element/form/%40el/input/edit.tpl */ ?>



<input  name ="<?php echo $this->_tpl_vars['field']->getName(); ?>
" <?php if ($this->_tpl_vars['field']->view->type == 'password'): ?> type="password" <?php else: ?> type="text" <?php endif; ?> value="<?php echo $this->_tpl_vars['field']->getValue(); ?>
" id="<?php echo $this->_tpl_vars['field']->getName(); ?>
" placeholder="">