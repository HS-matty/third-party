{if $f->Hidden}
<input name= "{$f->ID}" type="hidden" value="{$f->Value}">


{else}
<tr>
<td align="right" width="130">{$f->Title}{if $f->IsRequired}<font color="red">*</font>{/if}:</td>
<td>

	{if $f->View->Type == 'text'}{$f->getValue()} 
	{else}
				{if $f->EnumList}
		<select name="{$f->ID}" class="inp2"  >
		<option value="" >List...</option>
		{foreach from=$f->EnumList item=e}
			<option value="{$e}" {if $f->Value == $e} selected {/if}>{$e}</option>
		{/foreach}
		
		</select>
		{else}
			{if $f->View->Type == 'textarea'}
			<textarea class="inp3"  style="width:600px;" rows ="7" name="{$f->ID}">{$f->getValue(1)}</textarea>
			{else}
			<input name="{$f->ID}" style="width:300px" {if $f->View->Type == 'password'} type="password" {else} type="text"  value="{$f->getValue()}" {/if}>
			{/if}
		{/if}

	{/if}
	{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
	{/if}
</td>
</tr>
{/if}