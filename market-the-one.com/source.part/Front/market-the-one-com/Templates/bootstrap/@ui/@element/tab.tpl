	<ul class="nav nav-tabs">
		<h3>{$ui_element->title}</h3>
			
	{foreach from=$ui_element value=_el}
				<li {if $_el->name == $ui_element->current_element->name} class = "active" {/if}><a href="{$_el->link}">{$_el->title}</a></li>
	 
	{/foreach}
	</ul>
	