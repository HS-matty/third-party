Комментарии для записи <a href="{$HostName}/go/item/?listing_id={$Listing->getItemId()}">{$Listing->Data.short_description}</a><br /><br />
{if $Items}
<table cellpadding=3 border=1 width=100%>
	{foreach from=$Items item=c}
	<tr><td width="30%">{$c.short_description|strip_tags|escape}</td><td>{$c.long_description|strip_tags}</td></tr>
	{/foreach}
	</table>
	
	
{else}
Нет комментариев
{/if}
{include file=$View->getIndexTmpl('standart_form/form.tpl')}