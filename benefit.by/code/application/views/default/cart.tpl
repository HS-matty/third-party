
{if $Items}
<table cellpadding=3 border=1 width=30%>
	{foreach from=$Items item=c}
	<tr><td>{$c.company|strip_tags|escape}</td><td width="30%"><a href="{$HostName}/go/item/?listing_id={$c.listing_id}">{$c.short_description|strip_tags|escape}</a></td>
	<td><a href="?id={$c.listing_id}&delete=1">Удалить</a></td>
	</tr>
	{/foreach}
	</table>
	
	
{else}
Корзина пуста
{/if}
