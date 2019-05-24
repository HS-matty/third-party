s
<!-- console start -->
	{if $window->workspace->output->hasElements()}
	<ul>
	{foreach from=$window->workspace->output->getElements() item=output_element}
			<li>{$output_element->title}:  {$output_element->getValue()}</li>
			{if $output_element->getElements()}
				<ul>
					{foreach from=$output_element value=output_sub_element}
						<li>{$output_sub_element->name}-{$output_sub_element->title} {$output_sub_element->getValue()}</li>
							{if $output_sub_element->hasElements()}
								<ul>
									{foreach from=$output_sub_element value=output_sub_sub_element} <!-- =)))) -->
												<li>{$output_sub_sub_element->name}-{$output_sub_sub_element->title} {$output_sub_sub_element->getValue()}</li>
									{/foreach}
								</ul>
								
							{/if}
					{/foreach}
				</ul>
			{/if}
			
	{/foreach}
	</ul>
	{/if}
	
	{if $window->workspace->panel}
		{assign var=panel value=$window->workspace->panel}
		{foreach from=$panel->getElements() value=panel_element}
			{assign var=action value=$panel_element->getAction('onClick') }
			<a href="{$action->value}"><button name="{$panel_element->name}" type="button" class="btn btn-default">{$panel_element->title}</button></a>
		{/foreach}
		
	{/if}
	
<!-- console end -->
	
	
    
 
    
    
 <!-- form-->   

	{if $window->workspace->filter}
<form method="post">
	<legend>{ $window->workspace->filter->getTitle()}</legend>
  <fieldset>
	
		{foreach from=$window->workspace->filter value=item}
		<label><b>{$item->title}:</b></label>
			{if $item->type == 'input'}
					<input type="text" name = "{$item->name}" placeholder="">
					<span class="help-block"></span>
			{elseif $item->type == 'select'}
				<select name="{$item->name}{if $item->multiple}[]{/if}" {if $item->multiple} multiple size="30"{/if}>
				{foreach from=$item->getElements() value="option"}
					<option {if $item->value == $option->value} selected {/if} value="{$option->value}">{$option->title}</option>
				{/foreach}
				</select>
				<br />
			
			{elseif $item->type == 'date'}
			<div id="{$item->name}" class="input-append date"  data-date="01-06-2013" data-date-format="dd-mm-yyyy">
				<input class="span2" size="16" type="text" name="{$item->name}" value="01-06-2013">
				<span class="add-on"><i class="icon-calendar"></i></span>
			  </div>

				<br />
			
			{/if}
			
			
		{/foreach}
		
		
  

		<input type="hidden" name="post" value="1">
		<button type="submit" class="btn">Submit</button>
  </fieldset>
</form>
	{/if}
	
	

	
	{if $window->workspace->grid}
		{assign var=grid value=$window->workspace->grid}
		<table class="table">
			<thead>
				<tr>
					{foreach from=$grid->header->getElements() item=el}
						<th>{$el->getValue()}</th>
					{/foreach}
				<tr>
			</thead>
			{foreach from=$grid->data->getElements() item=row}
			<tr>
				{foreach from=$row item=row_element}
					<td>{$row_element->value}</td>
				{/foreach}
			</tr>
			{/foreach}
			
			
			
			
		</table>
		
	{/if}
	
	{if $window->workspace->output->image}
		<img src="{$host_name}/public/images/_tmp/{$window->workspace->output->image->getValue()}" border="0">
	{/if}




<br /><br />