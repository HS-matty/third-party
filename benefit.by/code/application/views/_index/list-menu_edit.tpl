
{assign var="title" value=$f->ListValueTitle}
{assign var="key" value=$f->ListKeyTitle}




<tr>
<td align="right" width="130">{$f->Title}{if $f->IsRequired}<font color="red">*</font>{/if}:</td>
<td><select name="{$f->ID}" id="{$f->ID}" {$f->JavaScript} style="width:250px">

<option value="0">Список</option>
{foreach from=$f->ListValue item=item}
<option value="{$item.$key}" {if $f->Value == $item.$key} selected {/if}> {$item.$title}</option>
{/foreach}

</select>
	{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
	{/if}
</td>
</tr>