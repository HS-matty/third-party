<?php /* Smarty version 2.6.14, created on 2008-01-20 20:30:21
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/admin/users.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/admin/users.tpl', 10, false),)), $this); ?>
﻿
<form method="post" action="">
<input type="hidden" name="post" value=1>
<table width="100%" cellpadding="3" cellspacing="0">
									<tr>
										<td colspan="8" class="tableHeading">Search</td>
									</tr>
									<tr>
										<td >Email:</td>
										<td ><input type="text" name="email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['Params']['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
										
										
										
										
										<td >Is active</td>
										<td >
					<select name="is_active">
						<option  value="">All</option>
											<option <?php if ($this->_tpl_vars['Params']['is_active'] == '2'): ?> selected <?php endif; ?> value="2">Yes</option>
					<option <?php if ($this->_tpl_vars['Params']['is_active'] == '1'): ?> selected <?php endif; ?>>No</option>
										</select>
										
										</td>
										<td >Тип</td>
										<td >
					<select name="is_active">
						<option  value="">All</option>
											<option <?php if ($this->_tpl_vars['Params']['type'] == 'client'): ?> selected <?php endif; ?> value="2">Client</option>
					<option <?php if ($this->_tpl_vars['Params']['is_active'] == '1'): ?> selected <?php endif; ?>>Partner</option>
										</select>
										
										</td>
										<td width="75"></td>
										<td><input type="submit" value="Search" /></td>
									</tr>

								</table></form>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('grid.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>