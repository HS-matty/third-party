<?php /* Smarty version 2.6.14, created on 2007-12-12 22:44:43
         compiled from z:/home/barefoot_zend/www/application/views/frontend/oodle/index.tpl */ ?>



<form method="post" action="" name="f1" id="f1">
<input type="hidden" name="post" value=1>
<table width="100%" cellpadding="3" cellspacing="0">
									<tr>
										<td colspan="7" class="tableHeading">Oodle</td>
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
										
										
										
										
										<td width="60"></td>
										<td width="100">

										</td>
										<td width="75"></td>
										<td></td>
									</tr>
									<tr>
										<td>Params:</td>
										<td>
											<select name="param">
												<option <?php if ($this->_tpl_vars['param'] == 'all'): ?> selected <?php endif; ?> value="all">All</option>
												<option <?php if ($this->_tpl_vars['param'] == 'today'): ?> selected <?php endif; ?> value="today">Today</option>
												<option <?php if ($this->_tpl_vars['param'] == '7'): ?> selected <?php endif; ?> value="7">10 days</option>
												<option <?php if ($this->_tpl_vars['param'] == '30'): ?> selected <?php endif; ?> value="30">30 days</option>
												

											</select>
										</td>
										<td></td>
										<td>
											
										</td>
										<td></td>
										<td width="100"></td>
									<input type="hidden" name="confirm" id="confirm" value="0">
										<td><input type="submit" value="Submit" /></td>
									</tr>
								</table></form>
								
								
								<?php if ($this->_tpl_vars['response']): ?>Following items will be added:<br />
								<ul>
								<li>Total: <?php echo $this->_tpl_vars['response']['total']; ?>
</li>
								</ul>
									<a href="#" onClick="document.getElementById('confirm').value = 1;document.getElementById('f1').submit();">proceed</a>	
								<?php endif; ?>
							
								
								
								