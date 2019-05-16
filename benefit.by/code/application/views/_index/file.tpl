<div>
<div class="form_item_title">{$f->Title}</div>


{if $f->FileType == 'image'}
	{if $f->Value}<img height=100 width=100 src="{$HostName}{$f->FilePath}{$f->Value}">
<br>
<div class="form_item_title">delete image</div>
<input type="checkbox" name="{$f->ID}_image_delete" value="checkbox" />
{else} no image loaded
{/if}
	<br>
{/if}




<div class="form_item_title">upload</div> <input name="{$f->ID}" type="file" />

</div>