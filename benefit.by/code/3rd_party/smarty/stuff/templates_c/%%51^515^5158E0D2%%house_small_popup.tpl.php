<?php /* Smarty version 2.6.14, created on 2007-10-30 19:07:57
         compiled from z:/home/barefoot_zend/www/application/views/frontend//directory/house_small_popup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'z:/home/barefoot_zend/www/application/views/frontend//directory/house_small_popup.tpl', 1, false),array('modifier', 'wordwrap', 'z:/home/barefoot_zend/www/application/views/frontend//directory/house_small_popup.tpl', 1, false),array('modifier', 'money_format', 'z:/home/barefoot_zend/www/application/views/frontend//directory/house_small_popup.tpl', 14, false),)), $this); ?>
											<div id="infoTitleSmall"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['short_description'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 50, "<br />\n") : smarty_modifier_wordwrap($_tmp, 50, "<br />\n")); ?>
</div>
											<div id="infoWindowSmallContent">
												<table width="100%" cellpadding="0" cellspacing="0" style="padding-top: 5px;">
													<tr>
														<td valign="top">
														<p>
															<?php echo $this->_tpl_vars['category_short_description']; ?>

															<br />
															</p>
														<?php echo $this->_tpl_vars['address']; ?>

									<?php echo $this->_tpl_vars['city']; ?>
, <?php echo $this->_tpl_vars['state']; ?>
 <?php echo $this->_tpl_vars['zip']; ?>

															
															<br /><br />
															<?php echo ((is_array($_tmp=$this->_tpl_vars['price'])) ? $this->_run_mod_handler('money_format', true, $_tmp, "%i") : smarty_modifier_money_format($_tmp, "%i")); ?>
<br />
															<?php echo $this->_tpl_vars['bedrooms']; ?>
br/<?php echo $this->_tpl_vars['bathrooms']; ?>
ba<br />
															<?php echo $this->_tpl_vars['square_footage']; ?>
 sq. ft.
														</td>
														<td valign="top">
															<?php if ($this->_tpl_vars['image1']): ?><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/cat_items/thumbs/<?php echo $this->_tpl_vars['image1']; ?>
" alt="" class="infoImage" /><?php endif; ?>
															<br /><br />
															<a href="javascript:;" onclick="insertNewText('(<?php echo $this->_tpl_vars['latitude']; ?>
,<?php echo $this->_tpl_vars['longitude']; ?>
)','listing<?php echo $this->_tpl_vars['listing_id']; ?>
_large_popup')" class="smallInfoLink">Maximize ...</a><br>
															<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/item/?item_id=<?php echo $this->_tpl_vars['listing_id']; ?>
" class="smallInfoLink">Full Listing ...</a>
														</td>
													</tr>
												</table>
											</div>
										</div>