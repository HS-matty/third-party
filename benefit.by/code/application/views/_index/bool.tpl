<div>

<div class="form_item_title">{$f->Title} </div>
<select name="{$f->ID}" style="width:100px">

<option value="1" {if $f->Value == 1} selected {/if}> 
Yes</option>
<option value="0" {if $f->Value == 0} selected {/if}> 
No</option>

</select>


</div>