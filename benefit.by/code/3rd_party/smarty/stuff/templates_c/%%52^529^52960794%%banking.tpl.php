<?php /* Smarty version 2.6.14, created on 2008-02-21 13:41:38
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/default/banking.tpl */ ?>
<?php $this->assign('qr', $this->_tpl_vars['Grid']->qr); ?>

<?php if ($this->_tpl_vars['User']->isLogined('RegisteredUser')): ?>
<table width="100%" border="0">
	<tr>
				<td>
				<a href="#" class="page">&lt;</a><a href="#" class="page">&lt;</a> <a href="#" class="page">1</a> <a href="#" class="page">2</a> <a href="#" class="page">3</a> <a href="#" class="page">4</a> <a href="" class="page">5</a> <a href="#" class="page">&gt;</a><a href="#" class="page">&gt;</a>
				</td>
				<td class="pager_info">	
					<?php if (! $this->_tpl_vars['qr']->getTotalRows()): ?> Ничего не найдено 
						
					<?php else: ?>	Показано с 														<?php echo $this->_tpl_vars['qr']->getCurrentPageRowsIndexStart(); ?>
 по <?php echo $this->_tpl_vars['qr']->getCurrentPageRowsIndexEnd(); ?>
 | Всего <?php echo $this->_tpl_vars['qr']->getTotalRows(); ?>

					<br /> Страницы: 
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

				<?php endif; ?>
				</td>
				</tr>
			</table>
			<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['l']):
?>
			<table border="0" cellpadding="0" cellspacing="0" id="special">
			<tr>
				<td>
					<?php $_from = $this->_tpl_vars['Grid']->Fields; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
				<div class="special_title"><a href="" class="special_title"><?php echo $this->_tpl_vars['l'][$this->_tpl_vars['id']];  echo $this->_tpl_vars['f']->Postfix; ?>
</a></div>
				<?php endforeach; endif; unset($_from); ?>
				</td>
			</tr>
			</table>
			<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
<table class="table_sr" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center" background="<?php echo $this->_tpl_vars['HostName']; ?>
/images/table/title_bg.gif"><h3>Сравнение</h3></td>
				</tr>
				<tr>
				<?php $_from = $this->_tpl_vars['Grid']->getListHeader(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['title'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['title']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['h']):
        $this->_foreach['title']['iteration']++;
?>
						<?php if (($this->_foreach['title']['iteration'] == $this->_foreach['title']['total']) == true): ?><td class="table_header_r"><div id="table_header"><?php echo $this->_tpl_vars['h']['title']; ?>
</div></td>
						<?php else: ?>
						<td class="table_header"><div id="table_header"><?php echo $this->_tpl_vars['h']['title']; ?>
</div></td>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
			
				<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rows'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rows']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['l']):
        $this->_foreach['rows']['iteration']++;
?>
				<tr>
						<?php $_from = $this->_tpl_vars['Grid']->Fields; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['body'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['body']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['f']):
        $this->_foreach['body']['iteration']++;
?>
							<?php $this->assign('id', $this->_tpl_vars['f']->ID); ?>
						<?php $this->assign('DbField', $this->_tpl_vars['f']->DbField); ?>
					
						<?php if ($this->_foreach['rows']['iteration']%2 != 0): ?><td <?php if ($this->_foreach['body']['iteration']%4 == 0): ?>class="table_body_1_r"<?php else: ?>class="table_body_1"<?php endif; ?> width="70">
						<?php else: ?>
						<td <?php if ($this->_foreach['body']['iteration']%4 == 0): ?>class="table_body_2_r"<?php else: ?>class="table_body_2"<?php endif; ?> width="70">
						<?php endif; ?>
						<?php if ($this->_tpl_vars['f']->Link && $this->_tpl_vars['f']->Type != 'additional'): ?>
						<a href="<?php echo $this->_tpl_vars['f']->Link; ?>
?
						<?php $_from = $this->_tpl_vars['f']->LinkParams; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
 $this->assign('df', $this->_tpl_vars['p']['DataField']);  echo $this->_tpl_vars['p']['Title']; ?>
=<?php echo $this->_tpl_vars['l'][$this->_tpl_vars['df']]; ?>
&<?php endforeach; endif; unset($_from); ?>"><?php echo $this->_tpl_vars['l'][$this->_tpl_vars['id']]; ?>
 <?php echo $this->_tpl_vars['f']->Postfix; ?>
 </a>
						<?php elseif ($this->_tpl_vars['f']->Type == 'additional'): ?>

					
						<a href="<?php echo $this->_tpl_vars['f']->Link;  if ($this->_tpl_vars['f']->LinkParams): ?>?<?php $_from = $this->_tpl_vars['f']->LinkParams; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
 $this->assign('df', $this->_tpl_vars['p']['DataField']);  echo $this->_tpl_vars['p']['Title']; ?>
=<?php if ($this->_tpl_vars['p']['Value']):  echo $this->_tpl_vars['p']['Value'];  else:  echo $this->_tpl_vars['l'][$this->_tpl_vars['df']];  endif; ?>&<?php endforeach; endif; unset($_from);  endif;  echo $this->_tpl_vars['qr']->getHTMLRanges();  echo $this->_tpl_vars['Grid']->getHTMLUrlParams(); ?>
"><?php echo $this->_tpl_vars['f']->Title; ?>
</a>
						
							<?php else:  echo $this->_tpl_vars['l'][$this->_tpl_vars['id']];  echo $this->_tpl_vars['f']->Postfix; ?>
 <?php endif; ?>
						&nbsp;
					</td>
						<?php endforeach; endif; unset($_from); ?>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
					<tr ><td  colspan=5 align="center">	<?php if (! $this->_tpl_vars['qr']->getTotalRows()): ?> Ничего не найдено 
					<?php if ($this->_tpl_vars['vary']): ?>
							 , Вы можете <?php if ($this->_tpl_vars['vary']['vary_direction'] == 'up'): ?> увеличить <?php else: ?> уменьшить <?php endif; ?> поле <?php echo $this->_tpl_vars['vary']['field_title']; ?>
 на <?php echo $this->_tpl_vars['vary']['points']; ?>
 пункта
							 для получения результата.
 						<?php endif; ?>
					
					<?php else: ?>	Показано с 														<?php echo $this->_tpl_vars['qr']->getCurrentPageRowsIndexStart(); ?>
 по <?php echo $this->_tpl_vars['qr']->getCurrentPageRowsIndexEnd(); ?>
 | Всего <?php echo $this->_tpl_vars['qr']->getTotalRows(); ?>
 
					<br /> Страницы: 
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
</td></tr>
				<?php endif; ?>
				<tr>
					<td class="table_bottom" colspan="5"><input type="submit" class="button_back" value="вернуться назад" /></td>
				</tr>
			</table>
		
		<?php endif; ?>