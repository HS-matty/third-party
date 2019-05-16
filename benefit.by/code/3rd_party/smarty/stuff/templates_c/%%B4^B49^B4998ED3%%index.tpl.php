<?php /* Smarty version 2.6.14, created on 2007-11-06 02:04:43
         compiled from z:/home/barefoot_zend/www/application/views/frontend/admin/index.tpl */ ?>
		
												
													



<div id="grid" >









<table width="100%" cellpadding="0" cellspacing="0">
							<tr>

								<td width="732" valign="top" id="resultSet">
									<div class="pagination">
										<table width="100%" cellpadding="0" cellspacing="0">
											<tr>
												<td align="left">
			 Stats </td>											</tr>
										</table>
									</div>

									<div id="results">
										<table width="96%" cellpadding="2" cellspacing="0">
										<tr><td width="70px"><h3>Users</h3></td><td></td></tr>
										<tr><td><strong>Total</strong></td><td><?php echo $this->_tpl_vars['UsersStats']['total']; ?>
</td></tr>
										<tr><td>Active</td><td><?php echo $this->_tpl_vars['UsersStats']['is_active']; ?>
</td></tr>
										<tr><td width="70px"><h3>Listings</h3></td><td></td></tr>
										<tr><td><strong>Total</strong></td><td><strong><?php echo $this->_tpl_vars['ItemsStats']['total']; ?>
</strong></td></tr>
										<tr><td>Active</td><td><?php echo $this->_tpl_vars['ItemsStats']['is_active']; ?>
</td></tr>
										<tr><td>Expired</td><td><?php echo $this->_tpl_vars['ItemsStats']['is_expired']; ?>
</td></tr>
										<tr><td>Closed</td><td><?php echo $this->_tpl_vars['ItemsStats']['is_closed']; ?>
</td></tr>
																				
										
										
										
							
										</table>
									</div>
								</td></tr></table>
								</div>

