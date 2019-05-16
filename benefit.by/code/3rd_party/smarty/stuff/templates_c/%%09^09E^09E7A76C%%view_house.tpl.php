<?php /* Smarty version 2.6.14, created on 2007-11-06 13:45:55
         compiled from z:/home/barefoot_zend/www/application/views/frontend/directory/view_house.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'z:/home/barefoot_zend/www/application/views/frontend/directory/view_house.tpl', 25, false),array('modifier', 'money_format', 'z:/home/barefoot_zend/www/application/views/frontend/directory/view_house.tpl', 31, false),array('modifier', 'nl2br', 'z:/home/barefoot_zend/www/application/views/frontend/directory/view_house.tpl', 55, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['itemjs'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				


					<div id="fullListingContent">
						<table width="100%" cellpadding="0" cellspacing="0" style="padding-top: 5px;">
							<tr>
								<td valign="top" width="40%">
																<div id="infoTitle"><?php echo $this->_tpl_vars['Item']['short_description']; ?>
&nbsp;&nbsp;<?php if (! $this->_tpl_vars['UserActions']->IsAuth): ?>
																
																	<?php if ($this->_tpl_vars['Item']['flag'] == 'none'): ?><a href="javascript:;" class="smallLink" id="flagLink" onmouseover="showFlagBubble(<?php echo $this->_tpl_vars['Item']['listing_id']; ?>
);">[Flag]</a>
						
						<?php else: ?>
						<a href="javascript:;" class="smallLink" id="flagLink" >[Flagged]</a>
						<?php endif; ?>
																
																
																<?php endif; ?></div>

								<?php if ($this->_tpl_vars['Item']['path_str']): ?>	<?php echo $this->_tpl_vars['Item']['path_str'];  else:  echo $this->_tpl_vars['Category'][1]['short_description'];  endif; ?>	<br />
								
												<?php if ($this->_tpl_vars['Contact']): ?>	<br /><a href="#contactForm" class="blueLink">Contact</a><br /><br /><?php endif; ?>

									<?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br />
									<?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['city'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
, <?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['state'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['zip'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

									<br /><br />
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td width="150px">Price:</td>
											<td><?php echo ((is_array($_tmp=$this->_tpl_vars['Item']['price'])) ? $this->_run_mod_handler('money_format', true, $_tmp, "%i") : smarty_modifier_money_format($_tmp, "%i")); ?>
</td>
										</tr>
										<tr>
											<td>Bedrooms:</td>
											<td><?php echo $this->_tpl_vars['Item']['bedrooms']; ?>
</td>
										</tr>
										<tr>
											<td>Bathrooms:</td>
											<td><?php echo $this->_tpl_vars['Item']['bathrooms']; ?>
</td>
										</tr>
										<tr>
											<td>Square Feet:</td>
											<td><?php echo $this->_tpl_vars['Item']['square_footage']; ?>
</td>
										</tr>
																				
																				
									
									</table>
								</td>
								<td align="right"><?php if ($this->_tpl_vars['map']):  echo $this->_tpl_vars['map']->printMap();  endif; ?></td>
							</tr>
						</table>
						<div class="infoWindowDesc">

							<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['Item']['long_description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
							
							<br /><br />
	<?php if ($this->_tpl_vars['Item']['image1'] || $this->_tpl_vars['Item']['image2'] || $this->_tpl_vars['Item']['image3'] || $this->_tpl_vars['Item']['image4']): ?>
													
							<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
								<?php if ($this->_tpl_vars['Item']['image1']): ?>

									<td valign="top">
										<a href="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/<?php echo $this->_tpl_vars['Item']['image1']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['Item']['image1']; ?>
" alt="" class="infoImage" /> </a>
									</td>
								<?php endif; ?>
								<?php if ($this->_tpl_vars['Item']['image2']): ?>
								
									<td valign="top">
									<a href="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/<?php echo $this->_tpl_vars['Item']['image2']; ?>
" target="_blank">	<img src="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['Item']['image2']; ?>
" alt="" class="infoImage" /></a>
									</td>
								<?php endif; ?>
							<?php if ($this->_tpl_vars['Item']['image3']): ?>
									<td valign="top">
								<a href="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/<?php echo $this->_tpl_vars['Item']['image3']; ?>
" target="_blank">		<img src="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['Item']['image3']; ?>
" alt="" class="infoImage" /> </a>
									</td>
								<?php endif; ?>
								<?php if ($this->_tpl_vars['Item']['image4']): ?>
									<td valign="top">
							<a href="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/<?php echo $this->_tpl_vars['Item']['image4']; ?>
" target="_blank">			<img src="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['Item']['image4']; ?>
" alt="" class="infoImage" /></a>
									</td>
								<?php endif; ?>
									
								</tr>
							</table><?php endif; ?>
	<?php if ($this->_tpl_vars['Contact']): ?>
							<div class="contactInfo">
							
							
							
							
								<a name="contactForm"></a><h3>Contact</h3>
								
		<?php echo $this->_tpl_vars['Item']['first_name']; ?>
 <?php echo $this->_tpl_vars['Item']['last_name']; ?>

		<?php if ($this->_tpl_vars['Item']['share_email']): ?><br> <?php echo $this->_tpl_vars['Item']['email'];  endif; ?>
		<?php if ($this->_tpl_vars['Item']['share_phone']): ?><br><?php echo $this->_tpl_vars['Item']['phone_number'];  endif; ?>
		
														
							
								<br /><br />
								<div id="response<?php echo $this->_tpl_vars['Item']['listing_id']; ?>
" style="padding-left:30px;color:#ff0000"></div>
								<form name="contact" action="">
									<table cellpadding="3" cellspacing="0">
										
										<tr>
											<td><strong>Name</strong></td>
											<td colspan="3"><input id="name" name="name" type="text" size="30" /></td>
										</tr>
										<tr>
											<td><strong>Email</strong></td>
											<td colspan="3"><input id="email" name="email" type="text" size="30" /></td>
										</tr>
										<tr>
											<td valign="top"><strong>Message</strong></td>
											<td colspan="3"><textarea id="message"  name="message" cols="38" rows="4"></textarea></td>
										</tr>
										<tr>
											<td></td>
											<td width="80"><img src="<?php echo $this->_tpl_vars['StartLink']; ?>
/image.php" alt="" /></td>
											<td width="134"><input size="8" id="security" name="security" /></td>
											<td><input type="button" value="Send Message" onclick=" sendMessage(<?php echo $this->_tpl_vars['Item']['listing_id']; ?>
,1);" /></td>
											
										</tr>
									
									</table>
								</form>
							</div>
						<?php endif; ?>
						</div>
					</div>

			

		<div style="display:none" id="listing<?php echo $this->_tpl_vars['Item']['listing_id']; ?>
_small_popup">
						<?php echo $this->_tpl_vars['Item']['small_popup']; ?>

						
						</div>
						
						<div style="display:none"   id="listing<?php echo $this->_tpl_vars['Item']['listing_id']; ?>
_large_popup">
						<?php echo $this->_tpl_vars['Item']['large_popup']; ?>

						
						</div>
		