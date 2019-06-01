

{if $page->console->hasElements()}

		<ul>
		{foreach from=$page->console item=message}
			<li>{$message}</li>
		{/foreach}
		</ul>
{/if}
