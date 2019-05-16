<?php /* Smarty version 2.6.14, created on 2007-11-06 00:38:16
         compiled from z:/home/barefoot_zend/www/application/views/frontend/_index/grid.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'z:/home/barefoot_zend/www/application/views/frontend/_index/grid.tpl', 71, false),)), $this); ?>
<?php if ($this->_tpl_vars['Grid']): ?>
<div id="grid" <?php if ($this->_tpl_vars['Grid']->GridAlign): ?>style="text-align:<?php echo $this->_tpl_vars['Grid']->GridAlign; ?>
"<?php endif; ?>>


<?php $this->assign('qr', $this->_tpl_vars['Grid']->qr); ?>







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
    foreach ($_from as $this->_tpl_vars['l']):
?>

<tr bgcolor="#EFEFEF" onmouseout = "this.style.background='#EFEFEF'" onmouseover="this.style.background='#F7F7F7'" style="text-align:left" height="25px">
	<?php $_from = $this->_tpl_vars['Grid']->Fields; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
		
		<?php if ($this->_tpl_vars['f']->isVisible): ?>
					<?php $this->assign('id', $this->_tpl_vars['f']->ID); ?>
					<?php $this->assign('DbField', $this->_tpl_vars['f']->DbField); ?>
					
					<?php if ($this->_tpl_vars['f']->Type == 'bool'): ?>
					
						
							<td><?php if ($this->_tpl_vars['l'][$this->_tpl_vars['id']] == 0): ?> No
							<?php elseif ($this->_tpl_vars['l'][$this->_tpl_vars['id']] == 1): ?>Yes<?php else: ?>Error<?php endif; ?> 	<?php if ($this->_tpl_vars['f']->Link): ?>(
								<a href="<?php echo $this->_tpl_vars['f']->Link;  if ($this->_tpl_vars['f']->LinkParams): ?>?<?php $_from = $this->_tpl_vars['f']->LinkParams; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
 $this->assign('df', $this->_tpl_vars['p']['DataField']);  echo $this->_tpl_vars['p']['Title']; ?>
=<?php echo $this->_tpl_vars['l'][$this->_tpl_vars['df']]; ?>
&<?php endforeach; endif; unset($_from);  echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams();  endif;  if ($this->_tpl_vars['qr']->PageIndex): ?>&page=<?php echo $this->_tpl_vars['qr']->PageIndex;  endif; ?>">change</a>)
							<?php endif; ?></td>
					
					
					<?php elseif ($this->_tpl_vars['f']->Type == 'date'): ?>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['l'][$this->_tpl_vars['id']])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%y") : smarty_modifier_date_format($_tmp, "%d-%m-%y")); ?>
</td>
					<?php elseif ($this->_tpl_vars['f']->Type == 'video'): ?>
						<td><?php if ($this->_tpl_vars['l'][$this->_tpl_vars['id']]): ?><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/directory/watch_thumb/image.jpeg?id=<?php echo $this->_tpl_vars['l'][$this->_tpl_vars['id']]; ?>
" height="96" width="96"><?php endif; ?></td>
					<?php elseif ($this->_tpl_vars['f']->Type == 'timedate'): ?>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['l'][$this->_tpl_vars['id']])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%y, %H:%M ") : smarty_modifier_date_format($_tmp, "%d-%m-%y, %H:%M ")); ?>
</td>
					<?php elseif ($this->_tpl_vars['f']->Type == 'additional'): ?>

					
					
						<td><a href="<?php echo $this->_tpl_vars['f']->Link;  if ($this->_tpl_vars['f']->LinkParams): ?>?<?php $_from = $this->_tpl_vars['f']->LinkParams; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
 $this->assign('df', $this->_tpl_vars['p']['DataField']);  echo $this->_tpl_vars['p']['Title']; ?>
=<?php if ($this->_tpl_vars['p']['Value']):  echo $this->_tpl_vars['p']['Value'];  else:  echo $this->_tpl_vars['l'][$this->_tpl_vars['df']];  endif; ?>&<?php endforeach; endif; unset($_from);  endif;  echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams(); ?>
"><?php echo $this->_tpl_vars['f']->Title; ?>
</a></td>
						
					<?php else: ?>
						
						
				
							<td><?php if ($this->_tpl_vars['f']->Link): ?>
						<a href="<?php echo $this->_tpl_vars['f']->Link; ?>
?
						<?php $_from = $this->_tpl_vars['f']->LinkParams; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
 $this->assign('df', $this->_tpl_vars['p']['DataField']);  echo $this->_tpl_vars['p']['Title']; ?>
=<?php echo $this->_tpl_vars['l'][$this->_tpl_vars['df']]; ?>
&<?php endforeach; endif; unset($_from); ?>"><?php echo $this->_tpl_vars['l'][$this->_tpl_vars['id']]; ?>
 </a>
							<?php else:  echo $this->_tpl_vars['l'][$this->_tpl_vars['id']];  endif; ?>
							
						
										<?php if ($this->_tpl_vars['f']->Ordering): ?>
										
										
										<a href="<?php echo $this->_tpl_vars['f']->Ordering->UpLink; ?>
&<?php echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams(); ?>
&id=<?php echo $this->_tpl_vars['l']['cid']; ?>
"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/up.gif" title="up"></a>
										<a href="<?php echo $this->_tpl_vars['f']->Ordering->DownLink; ?>
&<?php echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams(); ?>
&id=<?php echo $this->_tpl_vars['l']['cid']; ?>
"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/down.gif" title="down"></a>
										
							
							<?php endif; ?>
							</td>
					
				<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	
	
	
	
	
	
<?php endforeach; endif; unset($_from); ?>
										
										
										
										
							
										</table>
									</div>
							  </td>

							</tr>
						</table>
	
</div>

<?php else: ?>
<h4>Grid not loaded</h4>
<?php endif; ?>


