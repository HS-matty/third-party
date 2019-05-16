<?php /* Smarty version 2.6.14, created on 2007-10-30 19:11:15
         compiled from z:/home/barefoot_zend/www/application/views/frontend/directory/index.tpl */ ?>

				
					<table cellpadding="0" cellspacing="0" class="categoriesList">
						<tr>
							<td valign="top" width="290">
								<div class="categoryHeading"><h2>Housing</h2></div>
								
								

								<div  class="categorySet">
							<?php $_from = $this->_tpl_vars['Housing']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['h']):
?>
									<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/search/?cid=<?php echo $this->_tpl_vars['h']['k_item']; ?>
" <?php if ($this->_tpl_vars['h']['a_tree']): ?>onmouseover="showSubs(<?php echo $this->_tpl_vars['h']['k_item']; ?>
,this);"<?php endif; ?>><?php echo $this->_tpl_vars['h']['s_name']; ?>
 <?php if (! $this->_tpl_vars['h']['a_tree']): ?></a><?php else: ?> ...</a>
									
										
						
					<div id="sub<?php echo $this->_tpl_vars['h']['k_item']; ?>
" style="display: none;position: absolute; background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/bg_02.gif); background-repeat:repeat-y;    width:261px" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'"  >
	<div style="background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_pic_01.gif); background-repeat:no-repeat; background-position:top; padding:20px 45px 20px 35px; width:181px ">		
																										<h3><?php echo $this->_tpl_vars['h']['s_name']; ?>
</h3>
							<?php $_from = $this->_tpl_vars['h']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['housing'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['housing']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sh']):
        $this->_foreach['housing']['iteration']++;
?>
								<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/search/?cid=<?php echo $this->_tpl_vars['sh']['k_item']; ?>
"><?php echo $this->_tpl_vars['sh']['s_name']; ?>
</a><br />
							<?php endforeach; endif; unset($_from); ?>
								<?php if ($this->_foreach['housing']['total'] < 3): ?><br /><br /><?php endif; ?>
					</div>
					<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/bottop_pic_02.gif" alt="" style="margin:0; display:block" />		
					</div>				
									
									<?php endif; ?>
									
									
									<br />
						<?php endforeach; endif; unset($_from); ?>
								</div>
								<div class="categoryFooter"></div>
								<br />
								
								<div class="categoryHeading"><h2>Items for Sale</h2></div>
									<div class="categorySet">
							<?php $_from = $this->_tpl_vars['SaleItems']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['h']):
?>
									<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/search/?cid=<?php echo $this->_tpl_vars['h']['k_item']; ?>
" <?php if ($this->_tpl_vars['h']['a_tree']): ?>onmouseover="showSubs(<?php echo $this->_tpl_vars['h']['k_item']; ?>
,this);" <?php endif; ?>><?php echo $this->_tpl_vars['h']['s_name']; ?>
	<?php if (! $this->_tpl_vars['h']['a_tree']): ?> </a><?php else: ?> ...</a>
								
										
						<div id="sub<?php echo $this->_tpl_vars['h']['k_item']; ?>
" style="display: none;position: absolute; background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/bg_02.gif); background-repeat:repeat-y; width:261px" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'"  >
	<div style="background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_pic_01.gif); background-repeat:no-repeat; background-position:top; padding:20px 45px 20px 35px; width:181px ">	
																										<h3><?php echo $this->_tpl_vars['h']['s_name']; ?>
</h3>
							<?php $_from = $this->_tpl_vars['h']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['items'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['items']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sh']):
        $this->_foreach['items']['iteration']++;
?>
								<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/search/?cid=<?php echo $this->_tpl_vars['sh']['k_item']; ?>
"><?php echo $this->_tpl_vars['sh']['s_name']; ?>
</a><br />
							<?php endforeach; endif; unset($_from); ?>
							<?php if ($this->_foreach['items']['total'] < 3): ?><br /> <br /><?php endif; ?>
									</div>
					<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/bottop_pic_02.gif" alt="" style="margin:0; display:block" />			
					</div>							
									
									<?php endif; ?>
									
									
									<br />
						<?php endforeach; endif; unset($_from); ?>
								</div>
								<div class="categoryFooter"></div>
							</td>
							<td valign="top">
								<div class="categoryHeading"><h2>Jobs</h2></div>
								<div class="categorySet" style="vertical-align: top;">
							<?php $_from = $this->_tpl_vars['Jobs']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['h']):
?>
									<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/search/?cid=<?php echo $this->_tpl_vars['h']['k_item']; ?>
" <?php if ($this->_tpl_vars['h']['a_tree']): ?>onmouseover="showSubs(<?php echo $this->_tpl_vars['h']['k_item']; ?>
,this);"<?php endif; ?>><?php echo $this->_tpl_vars['h']['s_name'];  if (! $this->_tpl_vars['h']['a_tree']): ?></a> <?php else: ?> ...</a>
									
										
						
					<div id="sub<?php echo $this->_tpl_vars['h']['k_item']; ?>
" style="display: none; padding-bottom:0px; position: absolute; background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/bg_02.gif); background-repeat:repeat-y; width:261px" onmouseover = "this.style.display = ''" onmouseout = "this.style.display = 'none'"  >
	<div style="background-image:url(<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_pic_01.gif); background-repeat:no-repeat; background-position:top; padding:20px 45px 20px 35px; width:181px ">	
							<h3><?php echo $this->_tpl_vars['h']['s_name']; ?>
</h3>
							<?php $_from = $this->_tpl_vars['h']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['jobs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['jobs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sh']):
        $this->_foreach['jobs']['iteration']++;
?>
								<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/search/?cid=<?php echo $this->_tpl_vars['sh']['k_item']; ?>
"><?php echo $this->_tpl_vars['sh']['s_name']; ?>
</a><br />
							<?php endforeach; endif; unset($_from); ?>
							<?php if ($this->_foreach['jobs']['total'] < 3): ?><br /><br /><br />
<?php endif; ?>
					</div><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/bottop_pic_02.gif" alt=""/></div>						
									
									<?php endif; ?>
									
									
									<br />
						<?php endforeach; endif; unset($_from); ?>
								</div>
								<div class="categoryFooter"></div>
							</td>
						</tr>
					</table>
					
				
			

			