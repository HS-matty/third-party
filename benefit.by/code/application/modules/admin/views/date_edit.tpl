<div class="form_item_title">{$f->Title}:</div>
<INPUT TYPE="text" name ="{$f->ID}" id="{$f->ID}" value="{$f->Value|date_format:"%d/%m/%Y"}">
<A HREF="#"
  onClick="cal.select(document.forms['{$Form->FormName}'].{$f->ID},'{$f->ID}_anchor','dd/MM/yyyy'); return false;"
   NAME="{$f->ID}_anchor" ID="{$f->ID}_anchor">select</A>
   
   
   	{if $f->Errors}
		{foreach from=$f->Errors item=e}
			<div class="form_item_error">{$e}</div>
		{/foreach}
	{/if}