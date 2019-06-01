{assign var=grid value=$ui_element}
{assign var=buttons value=$ui_element->buttons}
		
		<h4>{$grid->getTitle()}</h4>
		{if $buttons}
				<div class="btn-group dropup">
					{foreach from=$buttons->getElements() item=el}
					<a href="{$el->link}"><button type="button" class="btn btn-primary">{$el->getTitle()}</button></a>
					{/foreach}
				</div><br /><br />
		{/if}
		{assign var=rowset value=$ui_element->data->rowset}
		{assign var=rows value=$rowset->rows}	
	{if $rowset->count_rows_total > 0}
	
		<table class="table" style="background-color:#F4F4F4">
			<thead>
				<tr >
					{foreach from=$grid->row->getFields() item=el}
						{if !$el->getParam('is_disabled')}<th><a href="?post=1&order_by={if $el->table}{$el->table}.{/if}{$el->name}&direction={$next_direction}&{$form_params_string}" style="font-size:12px">{$el->title}</a></th>{/if}
					{/foreach}
					
					{if $grid->row_option_select}
						<th> <input type="checkbox" name="choose-all" value="1"> </th>
					{/if}
					
				<tr>
			</thead>
	
			
			{if $rows}
			
				{foreach from=$rows key=key item=row}
				
				 {assign var=primary_key_name value=$grid->getParam('primary_key_name')}
				 
				  {assign var=_row value=$grid->getRow($key)}
				  
				  
				 
				<tr style="{$_row->style->getValueHtml()}" onmouseover="this.style.background='#EFEFEF';this.style.cursor='pointer'" onmouseout = "this.style.background=''" onclick="document.location = '{$grid->getParam('row_url')}?id={$row.$primary_key_name}';">
					{if $grid->show_all_fields}
							{foreach from=$row item=field_value}
							 <td>{$field_value}</td>
							{/foreach}
					
					{else}
						
						{foreach from=$grid->row->getFields() key=key item=field}
							{assign var="field_name" value=$field->getName()}
						
							
							{assign var="field_value" value=$row[$field_name]}
						
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
		{/if}
			
			
		</table>
		{if $rowset->count_pages_total > 1}
		<div class="pagination pagination-centered mini">
		<ul>
			{assign var=prev_page value=$current_page-1}
			{assign var=next_page value=$current_page+1}
			
			<li {if $current_page == 0} class="disabled"{else}{/if}><a href="{if $current_page == 0}#{else}?page={$prev_page}&post=1&order_by={$order_by}&direction={$direction}&{$form_params_string}"{/if}">&laquo;</a></li>
			{assign var=current_page_view value=$current_page+1}
			{if $rowset->count_pages_total > 30}<li class="active"><a href="#">{$current_page_view}</a></li>
					
			{else}
				{section name=page loop=$rowset->count_pages_total} 
				{assign var="index" value=$smarty.section.page.index }
			
					<li {if $index == $current_page} class="active" {/if}><a href="?page={$index}&post=1&order_by={$order_by}&direction={$direction}&{$form_params_string}">{$index+1}</a></li>
				{/section}
				
			{/if}
			
			<li {if $current_page == ($rowset->count_pages_total - 1)} class="disabled"{else}{/if}><a href="{if $current_page == $rowset->count_pages_total}#{else}?page={$next_page}&post=&order_by={$order_by}&direction={$direction}&{$form_params_string}"{/if}">&raquo;</a></li>
			
    
		</ul>	
		</div>
	{/if}
		<div class="pagination pagination-centered mini">
			
			<center><small><br>Total: <b>{$ui_element->data->rowset->count_rows_total}</b> row{if $rowset->count_rows_total == 1}{else}s{/if} @ {$rowset->count_pages_total} pages</small></center>
			<br />
  
		</div>
	
		
<!--div style="width:200px;height:400px"--> <!--/div-->

