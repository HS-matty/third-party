<div>
<div class="form_item_title">{$f->Title}</div>


{if $f->FileType == 'image'}
	{if $f->Value}<img height=100 width=100 src="{$HostName}{$f->FilePath}{$f->Value}">
<br>
{else} no image loaded

{/if}
	<br>
{/if}





</div>