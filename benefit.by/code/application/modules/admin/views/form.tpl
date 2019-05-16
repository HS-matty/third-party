

{if $success == 2}
<div style="color:red">success!</div>
{elseif $success == 1}
<div style="color:red">not success!</div>
{/if}

	<form method="post" enctype="multipart/form-data" name="{$Form->FormName}">
		<input type="hidden" name="FormName" value="{$Form->FormName}">
		<input type="hidden" name="post" value="1">
		
						{if $Form->FormTitle}<h5>{$Form->FormTitle}</h5>{/if}
						
				
						<table width= {if $Form->FormWidth}"{$Form->FormWidth}"{else}"100%"{/if} cellpadding="3" cellspacing="0">
				
							
							
							

		{foreach from=$Form->getXMLFormContent() item=f}
		
		 
		 			{if $f->Type == 'int' ||  $f->Type == 'float' } 
					{include file=$Page->getIndexTmpl('int_edit.tpl')}
					{elseif $f->Type == 'list'} 
					{include file=$Page->getIndexTmpl('list-menu_edit.tpl')}
					{elseif $f->Type == 'bool'} 
					{include file=$Page->getIndexTmpl('bool_edit.tpl')}
					{elseif $f->Type == 'string'} 
					{include file=$Page->getIndexTmpl('string_edit.tpl')}
					{elseif $f->Type == 'file'} 
					{include file=$Page->getIndexTmpl('file_edit.tpl')}
					{elseif $f->Type == 'date'} 
					{include file=$Page->getIndexTmpl('date_edit.tpl')}
					{elseif $f->Type== 'captcha'}
					{include file=$Page->getIndexTmpl('captcha.tpl')}
					{else}
					{include file=$Page->getIndexTmpl('int_edit.tpl')}

		{/if}

		
		{/foreach}
		<tr  align=left><td>

	</td><td><input type="submit" name="go" value="Send"></td>	</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
		
	



