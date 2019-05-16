<?php /* Smarty version 2.6.14, created on 2008-02-14 00:26:28
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/default/services.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/default/services.tpl', 10, false),)), $this); ?>
﻿
<form method="post" action="">
<input type="hidden" name="post" value=1>
<table cellpadding="3" cellspacing="0" border="0">
									<tr>
										<td colspan="3" class="tableHeading"><h3>Поиск</h3></td>
									</tr>
									<tr>
										<!--td >Email:</td>
										<td ><input type="text" name="email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['Params']['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
										
										
										
										
										<td >Is active</td>
										<td >
					<select name="is_active">
						<option  value="">All</option>
											<option <?php if ($this->_tpl_vars['Params']['is_active'] == '2'): ?> selected <?php endif; ?> value="2">Yes</option>
					<option <?php if ($this->_tpl_vars['Params']['is_active'] == '1'): ?> selected <?php endif; ?>>No</option>
										</select>
										
										</td-->
									
										<td >Тип</td>
										<td >
					<select name="service">
					
					<?php $_from = $this->_tpl_vars['services']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
					<option <?php if ($this->_tpl_vars['s']['category_id'] == $this->_tpl_vars['service']): ?> selected <?php endif; ?> value="<?php echo $this->_tpl_vars['s']['category_id']; ?>
"><?php echo $this->_tpl_vars['s']['short_description']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
					
										</select>
										
										</td>
										<td><input type="submit" value="Найти" class="button" /></td>
									</tr>

								</table></form>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('grid.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>