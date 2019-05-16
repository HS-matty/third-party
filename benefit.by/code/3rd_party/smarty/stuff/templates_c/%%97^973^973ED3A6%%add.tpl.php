<?php /* Smarty version 2.6.14, created on 2008-02-14 00:26:39
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/default/add.tpl */ ?>
﻿<form method="get" action="<?php echo $this->_tpl_vars['HostName']; ?>
/user/item/">
<select name="type">
<?php $_from = $this->_tpl_vars['services']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
<option value="<?php echo $this->_tpl_vars['s']['category_id']; ?>
"><?php echo $this->_tpl_vars['s']['short_description']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select> <input type="submit" class="button" value="выбрать">
</form>