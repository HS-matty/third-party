<?php /* Smarty version 2.6.14, created on 2007-12-08 00:00:39
         compiled from z:/home/barefoot_zend/www/application/views/frontend/admin/listings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'z:/home/barefoot_zend/www/application/views/frontend/admin/listings.tpl', 28, false),)), $this); ?>
<form method="post" action="">
<input type="hidden" name="post" value=1>
<table width="100%" cellpadding="3" cellspacing="0">
									<tr>
										<td colspan="7" class="tableHeading">Search</td>
									</tr>
									<tr>
										<td width="60">Category:</td>
										<td width="180"><select name="cid" style="width: 134px;">
				<option value="<?php echo $this->_tpl_vars['rootcid']; ?>
">All</option>
<?php $_from = $this->_tpl_vars['Cats']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['flevel']):
?>
<option value="<?php echo $this->_tpl_vars['flevel']['k_item']; ?>
" <?php if ($this->_tpl_vars['Params']['cid'] == $this->_tpl_vars['flevel']['k_item']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['flevel']['s_name']; ?>
</option>
	<?php if ($this->_tpl_vars['flevel']['a_tree']): ?>
	<?php $_from = $this->_tpl_vars['flevel']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['slevel']):
?>
	<option value="<?php echo $this->_tpl_vars['slevel']['k_item']; ?>
" class="sub" <?php if ($this->_tpl_vars['Params']['cid'] == $this->_tpl_vars['slevel']['k_item']): ?> selected <?php endif; ?>>&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['slevel']['s_name']; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
										
	
	</select></td>
										
										
										
										
										<td width="60">Email</td>
										<td width="100">
<input type="text" name="email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['Params']['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
										</td>
										<td width="75"></td>
										<td></td>
									</tr>
									<tr>
										<td>Flag:</td>
										<td><select name="flag">
						<option value="none" selected="selected">none</option>
					<option <?php if ($this->_tpl_vars['Params']['flag'] == 'misclassified'): ?> selected <?php endif; ?> value="misclassified">misclassified</option>
					<option <?php if ($this->_tpl_vars['Params']['flag'] == 'forbidden'): ?> selected <?php endif; ?> value="forbidden">forbidden</option>
					<option <?php if ($this->_tpl_vars['Params']['flag'] == 'spam'): ?> selected <?php endif; ?>>spam</option>
										</select></td>
										<td></td>
										<td>

										</td>
										<td></td>
										<td width="100"></td>
										<td><input type="submit" value="Search" /></td>
									</tr>
								</table></form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('grid.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>