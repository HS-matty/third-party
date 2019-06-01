


{assign var=grid value=$ui_element}
{assign var=buttons value=$ui_element->buttons}
	{assign var=grid_filter_form value=$ui_element->getParam('filter_form')}

		{if $grid_filter_form}
				{include file="/@ui/@element/form/filter.tpl"}
		{/if}

		
		{assign var=rowset value=$ui_element->data->rowset}
		{assign var=rows value=$rowset->rows}	
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
									<h2>{$ui_element->getName()}</h2>
				
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
										
									{foreach from=$ui_element->row->getFields() item=el}
													
														
								
												{if !$el->getParam('is_disabled')}
											<th data-class="expand" _class="expand sorting_asc" tabindex="0" aria-controls="datatable_fixed_column" rowspan="1" colspan="1" aria-sort="ascending" aria-label="">
												<a href="?post=1&order_by={if $el->table}{$el->table}.{/if}{$el->name}&direction={$next_direction}&{$form_params_string}" style="font-size:12px">{$el->title}
													 <i class="fa fa-unsorted"></i>
												</a>
											</th>
												{/if}
									{/foreach}
														
													</th>
										
											
													
									        </thead>
				
									        <tbody>
									            
												
											
			{if $rows}
			
				{foreach from=$rows key=key item=row}
				
				 {assign var=primary_key_name value=$grid->getParam('primary_key_name')}
				 
				  {assign var=_row value=$grid->getRow($key)}
				  
				  
				 
				<tr role="row" class="odd" style="{$_row->style->getValueHtml()}" onmouseover="this.style.background='#EFEFEF';this.style.cursor='pointer'" onmouseout = "this.style.background=''" onclick="document.location = '{$grid->getParam('row_url')}?id={$row.$primary_key_name}';">
					{if $grid->show_all_fields}
							{foreach from=$row item=field_value}
							 <td>{$field_value}</td>
							{/foreach}
					
					{else}
						
						{foreach from=$grid->row->getFields() key=key item=field}
							{assign var="field_name" value=$field->getName()}
						
							
							{assign var="inherit_field" value=$_row->getField($field_name)}
							{assign var="field_value" value=$inherit_field->getValue()}
							
							
							
							
						
							 {if $grid->row->getField($key)}<td>
							 
								{if $field->getType() == 'url'}
									{if $field_value}<a href="{$field_value}" target="_blank">link</a>{else} &nbsp {/if}
								{else}
									{$field_value} 
								{/if}
							 
							 
							 
							 
							 
							 </td>{/if}
						{/foreach}
					{/if}
					
					{if $grid->row_option_select}
						{assign var="id" value=$row->value->id}
						<th> <input type="checkbox" name="rows[]" value="{$id}" style=""> </th>
					{/if}
				</tr>
				{/foreach}
			{/if}												
												
			</tbody>
		</table>
			
				

										
					
								{assign var=prev_page value=$current_page-1}
								{assign var=next_page value=$current_page+1}
						
								<div class="dt-toolbar-footer">
											<div class="col-sm-6 col-xs-12 hidden-xs">
												<div class="dataTables_info" id="datatable_fixed_column_info" role="status" aria-live="polite">
													Showing 1 to 10 of {$ui_element->data->rowset->count_rows_total} entries ( @{$rowset->count_pages_total} pages) 
												</div>
											</div>
										{if $rowset->count_pages_total > 1}
										<div class="col-xs-12 col-sm-6">
											<div class="dataTables_paginate paging_simple_numbers" id="datatable_fixed_column_paginate">
											<ul class="pagination">
												
												{assign var=current_page_view value=$current_page+1}
										{if $rowset->count_pages_total > 30}
			
												<li class="active"><a href="#">{$current_page_view}</a></li>
										{else}
												
												<li class="paginate_button previous {if $current_page == 0}disabled{/if}" id="datatable_fixed_column_previous">
													<a href="{if $current_page == 0}#{else}?page={$prev_page}&post=1&order_by={$order_by}&direction={$direction}&{$form_params_string}{/if}" aria-controls="datatable_fixed_column" data-dt-idx="0" tabindex="0">&laquo; Previous</a>
												</li>
												
												{section name=page loop=$rowset->count_pages_total} 
												{assign var="index" value=$smarty.section.page.index }
			
																									
													<li class="paginate_button {if $index == $current_page} active{/if}">
														<a href="?page={$index}&post=1&order_by={$order_by}&direction={$direction}&{$form_params_string}" aria-controls="datatable_fixed_column" data-dt-idx="1" tabindex="0">{$index+1}</a>
													</li>
												{/section}
												
																						
												<li class="paginate_button next {if $current_page == ($rowset->count_pages_total - 1)} disabled{/if}" id="datatable_fixed_column_next" >
													<a href="{if $current_page == $rowset->count_pages_total}#{else}?page={$next_page}&post=&order_by={$order_by}&direction={$direction}&{$form_params_string}{/if}" aria-controls="datatable_fixed_column" data-dt-idx="0" tabindex="0" {if $current_page == ($rowset->count_pages_total - 1)} class="disabled"{/if}>Next &raquo;</a>
												</li>
										{/if}
											</ul>
											</div>
										</div>
									{/if}
									
									</div>
							
						
				
				
							</div>
									<!-- end widget content -->
				
					</div>
								<!-- end widget div -->
				
				</div>

