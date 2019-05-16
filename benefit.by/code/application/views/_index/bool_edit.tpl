
<tr>
<td align="right" width="130">{$f->Title}{if $f->IsRequired}<font color="red">*</font>{/if}:</td>
<td><select name="{$f->ID}" style="width:100px">

<option value="2" {if $f->Value == 1} selected {/if}> 
Да</option>
<option value="1" {if $f->Value == 0} selected {/if}> 
Нет</option>

</select>
	{if $f->Errors}
							{foreach from=$f->Errors item=e}
								<br><span class="error_message">{$e}</span>
							{/foreach}
	{/if}
</td>
</tr>