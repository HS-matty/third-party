{$Page->setIndexPath('calculator/')}

					
	<form method="post" enctype="multipart/form-data" name="{$Form->getFormId()}">
	
		<input type="hidden" name="post" value="1">
		
				
						
				
						<table width="200" height="100%" cellpadding="0" cellspacing="0" border="0">
				
				
							
							
							

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

{if $f->View->Group}<hr>{/if}
	
		
		{/foreach}
		<tr>
						<td colspan=2 style="padding-top: 15px">
							<input type="button" id="button_first" value="подобрать" />
							<input type="submit" id="button_second" value="поиск" />
							<input type="hidden" name="post" value=1>
							
						</td>
					</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
	
	



