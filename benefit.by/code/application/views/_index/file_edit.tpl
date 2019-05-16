

<tr>
<td align="right" width="130" valign="top">{$f->Title}{if $f->IsRequired}<font color="red">*</font>{/if}:</td>
<td>


{if $f->FileType == 'image'}
	{if $f->Value}<a href="{$HostName}{$f->FilePath}{$f->Value}" target="_blank">просмотреть</a>
<br>
<div class="form_item_title">Удалить изображение</div>
<input type="checkbox" name="{$f->ID}_image_delete" value="checkbox" />

{else} не загружено
{/if}

	
{/if}




<div class="form_item_title"></div> <input name="{$f->ID}" type="file" />
	{if $f->Errors}
		{foreach from=$f->Errors item=e}
			<div class="form_item_error">{$e}</div>
		{/foreach}
	{/if}
</div>
</td></tr>