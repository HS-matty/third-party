<div>
{if $f->Hidden}
<input name= "{$f->ID}" type="hidden" value="{$f->Value}">
{else}
<div class="form_item_title">{$f->Title}</div>

	{if $f->EnumList}
		<select name="{$f->ID}" style="width:100px;" >
		<option value="" >Choose...</option>
		{foreach from=$f->EnumList item=e}
			<option value="{$e}" {if $f->Value == $e} selected {/if}>{$e}</option>
		{/foreach}
		
		</select>
	{else}
	<input name="{$f->ID}" type="text" value="{$f->Value}">
	{/if}
{/if}
</div>