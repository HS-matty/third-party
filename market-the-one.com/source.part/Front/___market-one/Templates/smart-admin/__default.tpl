
{foreach from=$window->workspace item=ui_element}
	
	{assign value=$ui_element->getType() var=type }

	
	{$page->setCurrentUiElement($ui_element)}
	

	{assign var=file value = "/@ui/@element/$type.tpl"}

	
	{if $type} {include file=$file} {/if}
	
	
{/foreach}
