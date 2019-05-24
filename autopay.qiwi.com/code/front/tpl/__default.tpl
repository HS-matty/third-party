{foreach from=$window->workspace item=ui_element}
	
	{assign value=$ui_element->getType() var=type }

	
	{assign var=file value = "/@ui/@element/$type.tpl"}

	{if $debug->getDebugLevel()}
	<ul>
		<li>{$type}: {$file}</li>
	</ul>
	{/if}
	
	{if $type} {include file=$file} {/if}
	
{/foreach}
