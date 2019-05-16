{include file=$View->getIndexTmpl('form.tpl')}
{if $Form->Action == 'view'}
<br />
<a href="{$HostName}/go/comments/?id={$Listing->getItemId()}">Комментарии</a> | <a href="?listing_id={$Listing->getItemId()}&cart=1">В корзину</a>
{/if}