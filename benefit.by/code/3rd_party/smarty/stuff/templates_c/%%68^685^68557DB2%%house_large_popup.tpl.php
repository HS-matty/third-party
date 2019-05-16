<?php /* Smarty version 2.6.14, created on 2007-11-06 17:19:53
         compiled from z:/home/barefoot_zend/www/application/views/frontend//directory/house_large_popup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'z:/home/barefoot_zend/www/application/views/frontend//directory/house_large_popup.tpl', 2, false),array('modifier', 'wordwrap', 'z:/home/barefoot_zend/www/application/views/frontend//directory/house_large_popup.tpl', 2, false),array('modifier', 'money_format', 'z:/home/barefoot_zend/www/application/views/frontend//directory/house_large_popup.tpl', 20, false),array('modifier', 'nl2br', 'z:/home/barefoot_zend/www/application/views/frontend//directory/house_large_popup.tpl', 43, false),)), $this); ?>

<div id="infoTitle"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['short_description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 50, "<br />\n") : smarty_modifier_wordwrap($_tmp, 50, "<br />\n")); ?>
 <?php if ($this->_tpl_vars['flag'] == 'none'): ?><a href="javascript:;" class="smallLink" id="flagLink<?php echo $this->_tpl_vars['listing_id']; ?>
" onmouseover="showFlagBubble(<?php echo $this->_tpl_vars['listing_id']; ?>
,this);">[Flag]</a>
						
						<?php else: ?>
						<a href="javascript:;" class="smallLink" id="flagLink" >[Flagged]</a>
						<?php endif; ?></div>
											<div id="infoWindowFullContent_<?php echo $this->_tpl_vars['listing_id']; ?>
" class="infoWindowFullContent">
												<table width="100%" cellpadding="0" cellspacing="0" style="padding-top: 5px;">
													<tr>
														<td valign="top" width="40%">
															<?php echo $this->_tpl_vars['category_short_description']; ?>
<br />
															<a href="#contactForm" class="blueLink" onClick="forceScrollBottom('infoWindowFullContent_<?php echo $this->_tpl_vars['listing_id']; ?>
')" >Contact</a>
															<br /><br />
								<?php echo $this->_tpl_vars['address']; ?>
<br />
									<?php echo $this->_tpl_vars['city']; ?>
, <?php echo $this->_tpl_vars['state']; ?>
 <?php echo $this->_tpl_vars['zip']; ?>

															<br /><br />
															<table width="100%" cellpadding="0" cellspacing="0">
																<tr>
																	<td>Price:</td>
																	<td><?php echo ((is_array($_tmp=$this->_tpl_vars['price'])) ? $this->_run_mod_handler('money_format', true, $_tmp, "%i") : smarty_modifier_money_format($_tmp, "%i")); ?>
</td>
																</tr>
																<tr>
																	<td>Bedrooms:</td>
																	<td><?php echo $this->_tpl_vars['bedrooms']; ?>
</td>
																</tr>
																<tr>
																	<td>Bathrooms:</td>
																	<td><?php echo $this->_tpl_vars['bathrooms']; ?>
</td>
																</tr>
																<tr>
																	<td>Square Feet:</td>
																	<td>	<?php echo $this->_tpl_vars['square_footage']; ?>
</td>
																</tr>
															</table>
														</td>
														<td align="right">	<?php if ($this->_tpl_vars['image1']): ?><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['image1']; ?>
" alt="" class="infoImage" /><?php endif; ?></td>
													</tr>
												</table>
												<div class="infoWindowDesc">
													<table width="100%" cellpadding="0" cellspacing="0">
														<tr>
															<td valign="top" width="60%">
															<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['long_description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

															</td>
															<td valign="top" align="right">
													
	<?php if ($this->_tpl_vars['image2']): ?><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['image2']; ?>
" alt="" class="infoImage" /><br /><br /><?php endif; ?>
		<?php if ($this->_tpl_vars['image3']): ?><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['image3']; ?>
" alt="" class="infoImage" /><br /><br /><?php endif; ?>
			<?php if ($this->_tpl_vars['image4']): ?><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['image4']; ?>
" alt="" class="infoImage" /><br /><br /><?php endif; ?>
															</td>
														</tr>
													</table>
													<div class="contactInfo">
														<a name="contactForm"></a><h3>Contact</h3>
													
														<?php if ($this->_tpl_vars['first_name'] || $this->_tpl_vars['last_name']):  echo $this->_tpl_vars['first_name']; ?>
 <?php echo $this->_tpl_vars['last_name']; ?>
<br /><?php endif; ?>
													<?php if ($this->_tpl_vars['share_email']): ?>	<a href="<?php echo $this->_tpl_vars['email']; ?>
"><?php echo $this->_tpl_vars['email']; ?>
</a>
														<br />
													<?php endif; ?>
												
												<?php if ($this->_tpl_vars['share_phone']):  echo $this->_tpl_vars['phone']; ?>
	<br /><?php endif; ?>
													
																						<br />
								<div id="response<?php echo $this->_tpl_vars['listing_id']; ?>
" style="padding-left:30px;color:#ff0000"></div>
								<form name="contact" action="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/item/">
								
									<table cellpadding="3" cellspacing="0">
										
										<tr>
											<td><strong>Name</strong></td>
											<td colspan="3"><input id="name<?php echo $this->_tpl_vars['listing_id']; ?>
" name="name" type="text" size="30" /></td>
										</tr>
										<tr>
											<td><strong>Email</strong></td>
											<td colspan="3"><input id="email<?php echo $this->_tpl_vars['listing_id']; ?>
" name="email" type="text" size="30" /></td>
										</tr>
										<tr>
											<td valign="top"><strong>Message</strong></td>
											<td colspan="3"><textarea id="message<?php echo $this->_tpl_vars['listing_id']; ?>
"  name="message" cols="38" rows="4"></textarea></td>
										</tr>
										<tr>
											<td></td>
											<td width="80"><img src="<?php echo $this->_tpl_vars['StartLink']; ?>
/image.php" alt="" /></td>
											<td width="134"><input size="8" id="security<?php echo $this->_tpl_vars['listing_id']; ?>
" name="security" /></td>
											<td><input type="button" value="Send Message" onclick="sendMessage(<?php echo $this->_tpl_vars['listing_id']; ?>
);" /></td>
											
										</tr>
									
									</table>
								</form>
							</div>

													</div>
												</div>
											</div>
	