
{assign var="title" value=$f->ListValueTitle}
{assign var="key" value=$f->ListKeyTitle}
<div class="form_item_title">
{$f->Title}</div>
<select name="{$f->ID}" style="width:250px">
<option value="0">List...</option>
{foreach from=$f->ListValue item=item}
<option value="{$item.$key}" {if $f->Value == $item.$key} selected {/if}> {$item.$title}</option>
{/foreach}
</select>

