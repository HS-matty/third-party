<div>
{if $f->Hidden}
<input name= "{$f->ID}" type="hidden" value="{$f->Value}">
{else}
<div class="form_item_title">{$f->Title}</div>
<input name="{$f->ID}" type="text" value="{$f->Value}">
{/if}
</div>