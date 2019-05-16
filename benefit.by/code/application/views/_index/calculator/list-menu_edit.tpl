{assign var="title" value=$f->Type->ListValueTitle}
{assign var="key" value=$f->Type->ListKeyTitle}
<tr>
<td align="right" class="search"><div class="search_text">{$f->Title}{if $f->isRequired}<font color="red">*</font>{/if}:</div>

<select name="{$f->ID}" id="{$f->ID}" {$f->JavaScript} class="search" style="width: 200px;">

<option value="">выбор...</option>
{foreach from=$f->ListValue item=item}
<option value="{$item.$key}" {if $f->getValue() == $item.$key} selected {/if}> {$item.$title}</option>
{/foreach}

</select>
	{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
	{/if}
</td>
</tr>