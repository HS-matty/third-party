<?php /* Smarty version 2.6.14, created on 2014-05-10 12:57:14
         compiled from /%40ui/%40element/grid.tpl */ ?>
<?php $this->assign('grid', $this->_tpl_vars['ui_element']); ?>
		
		<h4><?php echo $this->_tpl_vars['grid']->getTitle(); ?>
</h4>
		
	
		<?php $this->assign('rowset', $this->_tpl_vars['ui_element']->data->rowset); ?>
		<?php $this->assign('rows', $this->_tpl_vars['rowset']->rows); ?>	
	<?php if ($this->_tpl_vars['rowset']->count_rows_total > 0): ?>
		<table class="table" style="background-color:#F4F4F4">
			<thead>
				<tr >
					<?php $_from = $this->_tpl_vars['grid']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['el']):
?>
						<?php if ($this->_tpl_vars['el']->getParam('is_enabled')): ?><th><a href="?post=1&order_by=<?php if ($this->_tpl_vars['el']->table):  echo $this->_tpl_vars['el']->table; ?>
.<?php endif;  echo $this->_tpl_vars['el']->name; ?>
&direction=<?php echo $this->_tpl_vars['next_direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string']; ?>
" style="font-size:12px"><?php echo $this->_tpl_vars['el']->title; ?>
</a></th><?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					
					<?php if ($this->_tpl_vars['grid']->row_option_select): ?>
						<th> <input type="checkbox" name="choose-all" value="1"> </th>
					<?php endif; ?>
					
				<tr>
			</thead>
	
			
			<?php if ($this->_tpl_vars['rows']): ?>
				<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
				
				<tr onmouseover="this.style.background='#EFEFEF';this.style.cursor='pointer'" onmouseout = "this.style.background=''">
					<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field_value']):
?>
						<td><?php echo $this->_tpl_vars['field_value']; ?>
</td>
					<?php endforeach; endif; unset($_from); ?>
					
					<?php if ($this->_tpl_vars['grid']->row_option_select): ?>
						<?php $this->assign('id', $this->_tpl_vars['row']->value->id); ?>
						<th> <input type="checkbox" name="rows[]" value="<?php echo $this->_tpl_vars['id']; ?>
" style=""> </th>
					<?php endif; ?>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
		<?php endif; ?>
			
			
		</table>
		<?php if ($this->_tpl_vars['rowset']->count_pages_total > 1): ?>
		<div class="pagination pagination-centered mini">
		<ul>
			<?php $this->assign('prev_page', $this->_tpl_vars['current_page']-1); ?>
			<?php $this->assign('next_page', $this->_tpl_vars['current_page']+1); ?>
			
			<li <?php if ($this->_tpl_vars['current_page'] == 0): ?> class="disabled"<?php else:  endif; ?>><a href="<?php if ($this->_tpl_vars['current_page'] == 0): ?>#<?php else: ?>?page=<?php echo $this->_tpl_vars['prev_page']; ?>
&post=1&order_by=<?php echo $this->_tpl_vars['order_by']; ?>
&direction=<?php echo $this->_tpl_vars['direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string']; ?>
"<?php endif; ?>">&laquo;</a></li>
			<?php $this->assign('current_page_view', $this->_tpl_vars['current_page']+1); ?>
			<?php if ($this->_tpl_vars['rowset']->count_pages_total > 30): ?><li class="active"><a href="#"><?php echo $this->_tpl_vars['current_page_view']; ?>
</a></li>
					
			<?php else: ?>
				<?php unset($this->_sections['page']);
$this->_sections['page']['name'] = 'page';
$this->_sections['page']['loop'] = is_array($_loop=$this->_tpl_vars['rowset']->count_pages_total) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
			
					<li <?php if ($this->_tpl_vars['index'] == $this->_tpl_vars['current_page']): ?> class="active" <?php endif; ?>><a href="?page=<?php echo $this->_tpl_vars['index']; ?>
&post=1&order_by=<?php echo $this->_tpl_vars['order_by']; ?>
&direction=<?php echo $this->_tpl_vars['direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string']; ?>
"><?php echo $this->_tpl_vars['index']+1; ?>
</a></li>
				<?php endfor; endif; ?>
				
			<?php endif; ?>
			
			<li <?php if ($this->_tpl_vars['current_page'] == ( $this->_tpl_vars['rowset']->count_pages_total - 1 )): ?> class="disabled"<?php else:  endif; ?>><a href="<?php if ($this->_tpl_vars['current_page'] == $this->_tpl_vars['rowset']->count_pages_total): ?>#<?php else: ?>?page=<?php echo $this->_tpl_vars['next_page']; ?>
&post=&order_by=<?php echo $this->_tpl_vars['order_by']; ?>
&direction=<?php echo $this->_tpl_vars['direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string']; ?>
"<?php endif; ?>">&raquo;</a></li>
			
    
		</ul>	
		</div>
	<?php endif; ?>
		<div class="pagination pagination-centered mini">
			
			<center><small><br>Total: <b><?php echo $this->_tpl_vars['ui_element']->data->rowset->count_rows_total; ?>
</b> row<?php if ($this->_tpl_vars['rowset']->count_rows_total == 1):  else: ?>s<?php endif; ?> @ <?php echo $this->_tpl_vars['rowset']->count_pages_total; ?>
 pages</small></center>
			<br />
  
		</div>
	
									

	