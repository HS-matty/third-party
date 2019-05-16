<?php /* Smarty version 2.6.14, created on 2007-11-02 23:52:44
         compiled from z:/home/barefoot_zend/www/application/views/frontend/directory/search_item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'z:/home/barefoot_zend/www/application/views/frontend/directory/search_item.tpl', 42, false),array('modifier', 'money_format', 'z:/home/barefoot_zend/www/application/views/frontend/directory/search_item.tpl', 118, false),)), $this); ?>
<div id="searchForm">
<form method="get" action="">
<input type="hidden" value="<?php echo $this->_tpl_vars['GET']['type']; ?>
" name='type'>



<!-- New Table -->


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
" <?php if ($this->_tpl_vars['GET']['cid'] == $this->_tpl_vars['flevel']['k_item']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['flevel']['s_name']; ?>
</option>
	<?php if ($this->_tpl_vars['flevel']['a_tree']): ?>
	<?php $_from = $this->_tpl_vars['flevel']['a_tree']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['slevel']):
?>
	<option value="<?php echo $this->_tpl_vars['slevel']['k_item']; ?>
" class="sub" <?php if ($this->_tpl_vars['GET']['cid'] == $this->_tpl_vars['slevel']['k_item']): ?> selected <?php endif; ?>>&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['slevel']['s_name']; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
										
	
	</select></td>
										
										
										
										
										<td width="60">Max price</td>
										<td width="100">
<input type="text" name="price" value="<?php echo $this->_tpl_vars['GET']['price']; ?>
">
										</td>
										<td width="75"></td>
										<td></td>
									</tr>
									<tr>
										<td>Search terms:</td>
										<td><input type="text" name="search" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['GET']['search'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></td>
										<td>Zip Code(s):</td>
										<td>
<input type="text" name="zip"  value="<?php echo $this->_tpl_vars['GET']['zip']; ?>
">
										</td>
										<td></td>
										<td width="100"></td>
										<td><input type="submit" value="Search" /></td>
									</tr>
								</table>




<!-- end New Table -->







</form>

</div><br>
<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="732" valign="top" id="resultSet">
									<div class="pagination">
										<table width="100%" cellpadding="0" cellspacing="0">
											<tr>
												<td align="left">
			<?php if (! $this->_tpl_vars['qr']->getTotalRows()): ?> No listings were found. Please search again. </td><?php else: ?>															<?php echo $this->_tpl_vars['qr']->getCurrentPageRowsIndexStart(); ?>
-<?php echo $this->_tpl_vars['qr']->getCurrentPageRowsIndexEnd(); ?>
 of <?php echo $this->_tpl_vars['qr']->getTotalRows(); ?>

												</td>
												<td>

												
												
												
												
													<?php if ($this->_tpl_vars['qr']->PageIndex > 0): ?><a href="?page=<?php echo $this->_tpl_vars['qr']->PageIndex-1; ?>
&<?php echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams(); ?>
">&lt;&lt; prev</a>&nbsp;<?php endif; ?>

			
<?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['qr']->getTotalPages()) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['page']['show'] = true;
$this->_sections['page']['max'] = $this->_sections['page']['loop'];
$this->_sections['page']['step'] = 1;
$this->_sections['page']['start'] = $this->_sections['page']['step'] > 0 ? 0 : $this->_sections['page']['loop']-1;
if ($this->_sections['page']['show']) {
    $this->_sections['page']['total'] = $this->_sections['page']['loop'];
    if ($this->_sections['page']['total'] == 0)
        $this->_sections['page']['show'] = false;
} else
    $this->_sections['page']['total'] = 0;
if ($this->_sections['page']['show']):

            for ($this->_sections['page']['index'] = $this->_sections['page']['start'], $this->_sections['page']['iteration'] = 1;
                 $this->_sections['page']['iteration'] <= $this->_sections['page']['total'];
                 $this->_sections['page']['index'] += $this->_sections['page']['step'], $this->_sections['page']['iteration']++):
$this->_sections['page']['rownum'] = $this->_sections['page']['iteration'];
$this->_sections['page']['index_prev'] = $this->_sections['page']['index'] - $this->_sections['page']['step'];
$this->_sections['page']['index_next'] = $this->_sections['page']['index'] + $this->_sections['page']['step'];
$this->_sections['page']['first']      = ($this->_sections['page']['iteration'] == 1);
$this->_sections['page']['last']       = ($this->_sections['page']['iteration'] == $this->_sections['page']['total']);
?>

<?php $this->assign('index', $this->_sections['page']['index']); ?> 
 
<?php if ($this->_tpl_vars['index'] == $this->_tpl_vars['qr']->PageIndex): ?><b><?php echo $this->_tpl_vars['index']+1; ?>
</b><?php else: ?>
<a href="?page=<?php echo $this->_tpl_vars['index']; ?>
&<?php echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams(); ?>
"><?php echo $this->_tpl_vars['index']+1; ?>
</a><?php endif; ?> <?php endfor; endif; ?>
						
											
																	
	
		<?php if ($this->_tpl_vars['qr']->PageIndex < $this->_tpl_vars['qr']->getLastIndex()): ?><a href="?page=<?php echo $this->_tpl_vars['qr']->PageIndex+1; ?>
&<?php echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams(); ?>
">next &gt;&gt;</a><?php endif; ?>
		

												</td>
											<?php endif; ?>
											</tr>
										</table>
									</div>
									<div id="results">
										<table width="96%" cellpadding="2" cellspacing="0">
											<?php $_from = $this->_tpl_vars['Grid']->getList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['l']):
?>
				<tr>
													<td valign='top' align='center' width="25" height="33" ><img src="<?php echo $this->_tpl_vars['StartLink']; ?>
/images/map_pin_<?php echo $this->_tpl_vars['Alphabet'][$this->_tpl_vars['key']]; ?>
.png" width="24" height="33" alt="" />
	</td>
												<td valign="top">
													<?php if ($this->_tpl_vars['l']['longitude'] && $this->_tpl_vars['l']['latitude']): ?>
													<a href="#" onClick="map.openInfoWindowHtml(new GLatLng(<?php echo $this->_tpl_vars['l']['latitude']; ?>
,<?php echo $this->_tpl_vars['l']['longitude']; ?>
 ),document.getElementById('listing<?php echo $this->_tpl_vars['l']['listing_id']; ?>
_small_popup').innerHTML);return false;"><?php echo $this->_tpl_vars['l']['short_description']; ?>
</a><?php else:  echo $this->_tpl_vars['l']['short_description'];  endif; ?>
													
													
													<div class="smallText"><?php echo $this->_tpl_vars['l']['address']; ?>
, <?php echo $this->_tpl_vars['l']['city']; ?>
, <?php echo $this->_tpl_vars['l']['state']; ?>
</div>

												</td>
												<td align="right" valign="top" nowrap="nowrap">
													<strong><?php echo ((is_array($_tmp=$this->_tpl_vars['l']['price'])) ? $this->_run_mod_handler('money_format', true, $_tmp, "%i") : smarty_modifier_money_format($_tmp, "%i")); ?>
</strong><br />
													<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/item/?item_id=<?php echo $this->_tpl_vars['l']['listing_id']; ?>
" class="smallLink">Full Listing</a> | <a href="javascript:;" onclick="showSaveBubble(this,<?php echo $this->_tpl_vars['l']['listing_id']; ?>
);" class="smallLink">Save</a>
												</td>
											</tr>
											<?php endforeach; endif; unset($_from); ?>
										</table>
									</div>
							  </td>
								<td valign="top" width="483">
									<div id="mapSmall">
										 <?php if ($this->_tpl_vars['map']):  echo $this->_tpl_vars['map']->printMap();  endif; ?>
												</div>
	
							  </td>
							</tr>
						</table>


    						
						<?php $_from = $this->_tpl_vars['Items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
						<div style="display:none" id="listing<?php echo $this->_tpl_vars['i']['listing_id']; ?>
_small_popup">
						<?php echo $this->_tpl_vars['i']['small_popup']; ?>

						
						</div>
						
						<div style="display:none"   id="listing<?php echo $this->_tpl_vars['i']['listing_id']; ?>
_large_popup">
						<?php echo $this->_tpl_vars['i']['large_popup']; ?>

						
						</div>
						
						<?php endforeach; endif; unset($_from); ?>
						
						
 
 