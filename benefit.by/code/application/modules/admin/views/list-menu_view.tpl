
{assign var="title" value=$f->ListValueTitle}
{assign var="key" value=$f->ListKeyTitle}
<div class="form_item_title">
{$f->Title}:</div>


{foreach from=$f->ListValue item=item}
{if $f->Value == $item.$key}<b>{$item.$title}</b> {/if}
{/foreach}

