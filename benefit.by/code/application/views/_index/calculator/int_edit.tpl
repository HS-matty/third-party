{if $f->isHidden}
<input name= "{$f->ID}" type="hidden" value="{$f->Value}">
{elseif $f->isPrimaryKey}

	{if $f->Parent->Action == 'update'}
		<input name= "{$f->ID}" type="hidden" value="{$f->getValue()}">
	{/if}
{elseif $f->Datasource}
<tr>
<td align="right">{$f->Title}{if $f->isRequired}<font color="red">*</font>{/if}:</td>
<td>
<div id="{$f->ID}_user_value" style="float:left;">
{if $f->PostedValue}{$f->PostedValue}{elseif $f->ViewValue}{$f->ViewValue}{elseif $f->ViewValues}
{foreach from=$f->ViewValues item=vv}
{$vv} 
{/foreach}
{elseif $f->getValue()}{$f->getValue()}{else}empty{/if}</div>
&nbsp&nbsp&nbsp<a class="link" href="#" onClick="window.open('{$f->Datasource->Link}?id={$f->ID}', 'popup', 'width=800,height=600,scrollbars=1');">browse</a>


<input id="{$f->ID}" name= "{$f->ID}" type="hidden" value="{$f->Value}">
<input id="{$f->ID}_puser_value" name= "{$f->ID}_puser_value" type="hidden" value="{$f->ID_puser_value}">

	{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
	{/if}</td>
</tr>


{else}
<tr>
<td align="left">{$f->Title}{if $f->isRequired}<font color="red">*</font>{/if}:<br>
<input id="sum" name="{$f->ID}" type="text" value="{$f->getValue()}">
	{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<span class="error_message">{$e}</span>
							{/foreach}
	{/if}</td>
</tr>
{/if}