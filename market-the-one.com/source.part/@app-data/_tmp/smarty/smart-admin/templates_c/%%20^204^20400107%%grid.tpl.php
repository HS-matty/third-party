<?php /* Smarty version 2.6.14, created on 2017-05-06 14:39:04
         compiled from /%40ui/%40element/grid.tpl */ ?>

<?php $this->assign('grid', $this->_tpl_vars['ui_element']); ?>
<?php $this->assign('buttons', $this->_tpl_vars['ui_element']->buttons); ?>

	<?php $this->assign('grid_filter_form', $this->_tpl_vars['ui_element']->getParam('filter_form')); ?>
		
		<?php if ($this->_tpl_vars['grid_filter_form']): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "/@ui/@element/form/filter.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>

		
		<?php $this->assign('rowset', $this->_tpl_vars['ui_element']->data->rowset); ?>
		<?php $this->assign('rows', $this->_tpl_vars['rowset']->rows); ?>	
	<div class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable" id="wid-id-1" role="widget"  data-widget-editbutton="true" data-widget-deletebutton="true">
								<!-- widget options:
								usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
				
								data-widget-colorbutton="false"
								data-widget-editbutton="false"
								data-widget-togglebutton="false"
								data-widget-deletebutton="false"
								data-widget-fullscreenbutton="false"
								data-widget-custombutton="false"
								data-widget-collapsed="true"
								data-widget-sortable="false"
				
								-->
								<header role="heading"><!--div class="jarviswidget-ctrls" role="menu">  
									<a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div><div class="widget-toolbar" role="menu"><a data-toggle="dropdown" class="dropdown-toggle color-box selector" href="javascript:void(0);"></a><ul class="dropdown-menu arrow-box-up-right color-select pull-right"><li><span class="bg-color-green" data-widget-setstyle="jarviswidget-color-green" rel="tooltip" data-placement="left" data-original-title="Green Grass"></span></li><li><span class="bg-color-greenDark" data-widget-setstyle="jarviswidget-color-greenDark" rel="tooltip" data-placement="top" data-original-title="Dark Green"></span></li><li><span class="bg-color-greenLight" data-widget-setstyle="jarviswidget-color-greenLight" rel="tooltip" data-placement="top" data-original-title="Light Green"></span></li><li><span class="bg-color-purple" data-widget-setstyle="jarviswidget-color-purple" rel="tooltip" data-placement="top" data-original-title="Purple"></span></li><li><span class="bg-color-magenta" data-widget-setstyle="jarviswidget-color-magenta" rel="tooltip" data-placement="top" data-original-title="Magenta"></span></li><li><span class="bg-color-pink" data-widget-setstyle="jarviswidget-color-pink" rel="tooltip" data-placement="right" data-original-title="Pink"></span></li><li><span class="bg-color-pinkDark" data-widget-setstyle="jarviswidget-color-pinkDark" rel="tooltip" data-placement="left" data-original-title="Fade Pink"></span></li><li><span class="bg-color-blueLight" data-widget-setstyle="jarviswidget-color-blueLight" rel="tooltip" data-placement="top" data-original-title="Light Blue"></span></li><li><span class="bg-color-teal" data-widget-setstyle="jarviswidget-color-teal" rel="tooltip" data-placement="top" data-original-title="Teal"></span></li><li><span class="bg-color-blue" data-widget-setstyle="jarviswidget-color-blue" rel="tooltip" data-placement="top" data-original-title="Ocean Blue"></span></li><li><span class="bg-color-blueDark" data-widget-setstyle="jarviswidget-color-blueDark" rel="tooltip" data-placement="top" data-original-title="Night Sky"></span></li><li><span class="bg-color-darken" data-widget-setstyle="jarviswidget-color-darken" rel="tooltip" data-placement="right" data-original-title="Night"></span></li><li><span class="bg-color-yellow" data-widget-setstyle="jarviswidget-color-yellow" rel="tooltip" data-placement="left" data-original-title="Day Light"></span></li><li><span class="bg-color-orange" data-widget-setstyle="jarviswidget-color-orange" rel="tooltip" data-placement="bottom" data-original-title="Orange"></span></li><li><span class="bg-color-orangeDark" data-widget-setstyle="jarviswidget-color-orangeDark" rel="tooltip" data-placement="bottom" data-original-title="Dark Orange"></span></li><li><span class="bg-color-red" data-widget-setstyle="jarviswidget-color-red" rel="tooltip" data-placement="bottom" data-original-title="Red Rose"></span></li><li><span class="bg-color-redLight" data-widget-setstyle="jarviswidget-color-redLight" rel="tooltip" data-placement="bottom" data-original-title="Light Red"></span></li><li><span class="bg-color-white" data-widget-setstyle="jarviswidget-color-white" rel="tooltip" data-placement="right" data-original-title="Purity"></span></li><li><a href="javascript:void(0);" class="jarviswidget-remove-colors" data-widget-setstyle="" rel="tooltip" data-placement="bottom" data-original-title="Reset widget color to default">Remove</a></li></ul></div-->
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2><?php echo $this->_tpl_vars['ui_element']->getName(); ?>
</h2>
				
								<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
				
								<!-- widget div-->
								<div role="content">
				
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
				
									</div>
									<!-- end widget edit box -->
				
									<!-- widget content -->
									<div class="widget-body no-padding">
				
										<div id="datatable_fixed_column_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="dt-toolbar">
										<div class="col-xs-12 col-sm-6 hidden-xs"><div id="datatable_fixed_column_filter" class="dataTables_filter">
										
										
										</div></div>
										<div class="col-sm-6 col-xs-12 hidden-xs"><div class="toolbar"><div class="text-right"></div></div></div></div>
										
										
										
										<table id="datatable_fixed_column" class="table table-striped table-bordered dataTable no-footer has-columns-hidden" width="100%" role="grid" aria-describedby="datatable_fixed_column_info" style="width: 100%;">
					
									        <thead>
										
									<?php $_from = $this->_tpl_vars['ui_element']->row->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['el']):
?>
													
														
								
												<?php if (! $this->_tpl_vars['el']->getParam('is_disabled')): ?>
											<th data-class="expand" _class="expand sorting_asc" tabindex="0" aria-controls="datatable_fixed_column" rowspan="1" colspan="1" aria-sort="ascending" aria-label="">
												<a href="?post=1&order_by=<?php if ($this->_tpl_vars['el']->table):  echo $this->_tpl_vars['el']->table; ?>
.<?php endif;  echo $this->_tpl_vars['el']->name; ?>
&direction=<?php echo $this->_tpl_vars['next_direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string']; ?>
" style="font-size:12px"><?php echo $this->_tpl_vars['el']->title; ?>

													 <i class="fa fa-unsorted"></i>
												</a>
											</th>
												<?php endif; ?>
									<?php endforeach; endif; unset($_from); ?>
														
													</th>
										
											
													
									        </thead>
				
									        <tbody>
									            
												
											
			<?php if ($this->_tpl_vars['rows']): ?>
			
				<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
				
				 <?php $this->assign('primary_key_name', $this->_tpl_vars['grid']->getParam('primary_key_name')); ?>
				 
				  <?php $this->assign('_row', $this->_tpl_vars['grid']->getRow($this->_tpl_vars['key'])); ?>
				  
				  
				 
				<tr role="row" class="odd" style="<?php echo $this->_tpl_vars['_row']->style->getValueHtml(); ?>
" onmouseover="this.style.background='#EFEFEF';this.style.cursor='pointer'" onmouseout = "this.style.background=''" onclick="document.location = '<?php echo $this->_tpl_vars['grid']->getParam('row_url'); ?>
?id=<?php echo $this->_tpl_vars['row'][$this->_tpl_vars['primary_key_name']]; ?>
';">
					<?php if ($this->_tpl_vars['grid']->show_all_fields): ?>
							<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field_value']):
?>
							 <td><?php echo $this->_tpl_vars['field_value']; ?>
</td>
							<?php endforeach; endif; unset($_from); ?>
					
					<?php else: ?>
						
						<?php $_from = $this->_tpl_vars['grid']->row->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
							<?php $this->assign('field_name', $this->_tpl_vars['field']->getName()); ?>
						
							
							<?php $this->assign('inherit_field', $this->_tpl_vars['_row']->getField($this->_tpl_vars['field_name'])); ?>
							<?php $this->assign('field_value', $this->_tpl_vars['inherit_field']->getValue()); ?>
							
							
							
							
						
							 <?php if ($this->_tpl_vars['grid']->row->getField($this->_tpl_vars['key'])): ?><td>
							 
								<?php if ($this->_tpl_vars['field']->getType() == 'url'): ?>
									<?php if ($this->_tpl_vars['field_value']): ?><a href="<?php echo $this->_tpl_vars['field_value']; ?>
" target="_blank">link</a><?php else: ?> &nbsp <?php endif; ?>
								<?php else: ?>
									<?php echo $this->_tpl_vars['field_value']; ?>
 
								<?php endif; ?>
							 
							 
							 
							 
							 
							 </td><?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['grid']->row_option_select): ?>
						<?php $this->assign('id', $this->_tpl_vars['row']->value->id); ?>
						<th> <input type="checkbox" name="rows[]" value="<?php echo $this->_tpl_vars['id']; ?>
" style=""> </th>
					<?php endif; ?>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>												
												
			</tbody>
		</table>
			
				

											
					
								<?php $this->assign('prev_page', $this->_tpl_vars['current_page']-1); ?>
								<?php $this->assign('next_page', $this->_tpl_vars['current_page']+1); ?>
						
								<div class="dt-toolbar-footer">
											<div class="col-sm-6 col-xs-12 hidden-xs">
												<div class="dataTables_info" id="datatable_fixed_column_info" role="status" aria-live="polite">
													Showing 1 to 10 of <?php echo $this->_tpl_vars['ui_element']->data->rowset->count_rows_total; ?>
 entries ( @<?php echo $this->_tpl_vars['rowset']->count_pages_total; ?>
 pages) 
												</div>
											</div>
										<?php if ($this->_tpl_vars['rowset']->count_pages_total > 1): ?>
										<div class="col-xs-12 col-sm-6">
											<div class="dataTables_paginate paging_simple_numbers" id="datatable_fixed_column_paginate">
											<ul class="pagination">
												
												<?php $this->assign('current_page_view', $this->_tpl_vars['current_page']+1); ?>
										<?php if ($this->_tpl_vars['rowset']->count_pages_total > 30): ?>
			
												<li class="active"><a href="#"><?php echo $this->_tpl_vars['current_page_view']; ?>
</a></li>
										<?php else: ?>
												
												<li class="paginate_button previous <?php if ($this->_tpl_vars['current_page'] == 0): ?>disabled<?php endif; ?>" id="datatable_fixed_column_previous">
													<a href="<?php if ($this->_tpl_vars['current_page'] == 0): ?>#<?php else: ?>?page=<?php echo $this->_tpl_vars['prev_page']; ?>
&post=1&order_by=<?php echo $this->_tpl_vars['order_by']; ?>
&direction=<?php echo $this->_tpl_vars['direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string'];  endif; ?>" aria-controls="datatable_fixed_column" data-dt-idx="0" tabindex="0">&laquo; Previous</a>
												</li>
												
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
			
																									
													<li class="paginate_button <?php if ($this->_tpl_vars['index'] == $this->_tpl_vars['current_page']): ?> active<?php endif; ?>">
														<a href="?page=<?php echo $this->_tpl_vars['index']; ?>
&post=1&order_by=<?php echo $this->_tpl_vars['order_by']; ?>
&direction=<?php echo $this->_tpl_vars['direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string']; ?>
" aria-controls="datatable_fixed_column" data-dt-idx="1" tabindex="0"><?php echo $this->_tpl_vars['index']+1; ?>
</a>
													</li>
												<?php endfor; endif; ?>
												
																						
												<li class="paginate_button next <?php if ($this->_tpl_vars['current_page'] == ( $this->_tpl_vars['rowset']->count_pages_total - 1 )): ?> disabled<?php endif; ?>" id="datatable_fixed_column_next" >
													<a href="<?php if ($this->_tpl_vars['current_page'] == $this->_tpl_vars['rowset']->count_pages_total): ?>#<?php else: ?>?page=<?php echo $this->_tpl_vars['next_page']; ?>
&post=&order_by=<?php echo $this->_tpl_vars['order_by']; ?>
&direction=<?php echo $this->_tpl_vars['direction']; ?>
&<?php echo $this->_tpl_vars['form_params_string'];  endif; ?>" aria-controls="datatable_fixed_column" data-dt-idx="0" tabindex="0" <?php if ($this->_tpl_vars['current_page'] == ( $this->_tpl_vars['rowset']->count_pages_total - 1 )): ?> class="disabled"<?php endif; ?>>Next &raquo;</a>
												</li>
										<?php endif; ?>
											</ul>
											</div>
										</div>
									<?php endif; ?>
									
									</div>
							
						
				
				
							</div>
									<!-- end widget content -->
				
					</div>
								<!-- end widget div -->
				
				</div>
