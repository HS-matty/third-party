

<tr>
<td align="right" width="130">{$f->Title}{if $f->isRequired}<font color="red">*</font>{/if}:</td>
<td>

			<select name="{$f->ID}" class="inp2"  >
				<option value="" >List...</option>
				{foreach from=$f->Type->ListValues key=key item=e}
				
					<option value="{$key|escape}" {if $f->getValue() == $key} selected {/if}>{$e|escape}</option>
				{/foreach}
				
				</select>

	{if $f->Errors}
	
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
	{/if}
</td>
</tr>
