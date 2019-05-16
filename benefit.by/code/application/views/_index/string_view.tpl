<div>
{if $f->Datasource}
<div class="form_item_title">{$f->Title} :</div>
<div id="{$f->ID}_user_value" style="float:left;"><b>{if $f->ViewValue}{$f->ViewValue}{elseif $f->ViewValues}
{foreach from=$f->ViewValues item=vv}
{$vv} 
{/foreach}
</b>
{/if}

{else}
<div class="form_item_title">{$f->Title}: </div>
<b>{if $f->View == 'date'}{$f->Value|date_format:"%d-%m-%y"}{else}{$f->Value}{/if}</b>

{/if}
</div>