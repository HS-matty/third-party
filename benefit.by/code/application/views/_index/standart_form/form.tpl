
{$Page->setIndexPath('standart_form/')}
<h4>{$Form->getFormTitle()}</h4>

{if $success === 1}
<div style="color:red">success!</div>
{elseif $success === 0}
<div style="color:red">not success!</div>
{/if}

	<form method="post" enctype="multipart/form-data" name="{$Form->getFormId()}">
		<input type="hidden" name="FormName" value="{$Form->getFormId()}">
		<input type="hidden" name="post" value="1">
		
						{if $Form->FormTitle}<h5>{$Form->FormTitle}</h5>{/if}
						
				
						<table width= {if $Form->FormWidth}"{$Form->FormWidth}"{else}"100%"{/if} cellpadding="3" cellspacing="0">
				
							
							
							

		{foreach from=$Form->getFields() item=f}
		

		 			{assign var=type value=$f->Type->getTypeString()}
		 			{if ($type == 'int' ||  $type == 'float')} 
					{include file=$Page->getIndexTmpl('int_edit.tpl')}
					{elseif $type == 'list'} 
					{include file=$Page->getIndexTmpl('list-menu_edit.tpl')}
					{elseif $type == 'bool'} 
					{include file=$Page->getIndexTmpl('bool_edit.tpl')}
					{elseif $type == 'string'} 
					{include file=$Page->getIndexTmpl('string_edit.tpl')}
					{elseif $type == 'file'} 
					{include file=$Page->getIndexTmpl('file_edit.tpl')}
					{elseif $type == 'date'} 
					{include file=$Page->getIndexTmpl('date_edit.tpl')}
					{elseif $type == 'enum'} 
					{include file=$Page->getIndexTmpl('enum_edit.tpl')}
					{elseif $type== 'captcha'}
					{include file=$Page->getIndexTmpl('captcha.tpl')}
					
						

		{/if}

		{if $f->View->Group}<tr><td colspan=2><HR /><br /></td></tr>
		{/if}
		
		{/foreach}
		<tr  align=left><td>

	</td><td><input type="submit" name="go" value="Send"></td>	</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
		
	



