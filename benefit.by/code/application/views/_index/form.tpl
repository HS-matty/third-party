	{if $Form->Action == 'insert' || $Form->Action == 'update'}


{if $success == 2}
<div style="color:red">Сохранено!</div>
{elseif $success == 1}
<div style="color:red">Не сохранено!</div>
{/if}
<div>
	<form method="post" enctype="multipart/form-data" name="{$Form->FormName}">
		<input type="hidden" name="FormName" value="{$Form->FormName}">
		<input type="hidden" name="post" value="1">
		
						{if $Form->FormTitle}<h5>{$Form->FormTitle}</h5>{/if}
						

						<table width="100%" cellpadding="3" cellspacing="0" border="0">
				
							
							
							

		{foreach from=$Form->getXMLFormContent() item=f}
			{if $f->View->Group}<FIELDSET>
		{/if}
		 
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

	{if $f->View->Group}<tr><td><br /><br /><HR /></td></tr>
		{/if}
		
		{/foreach}
		<tr  align="left"><td>

	</td><td><input type="submit" class="button" name="go" value="Отправить"><br><br>
	{if $formname == 'login'}
		<a href="{$HostName}/auth/forgot_password/">Забыли пароль?</a>
	{/if}	
	</td>	</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
		
	</DIV>
	
	{else}
	<div>

<table>
	{foreach from=$Form->getXMLFormContent() item=f}
				{if $f->Type == 'bool'} 
					<tr><td>
				{$f->Title}</td>
					<td><b>{if $f->Value == 1}Да
{else}Нет{/if} </b>
</td></tr>
					{elseif $f->Type == 'file'} 
				
					{elseif !$f->PrimaryKey}
				<tr><td>{$f->Title}: </td><td>
<b>{if $f->View == 'date'}{$f->Value|date_format:"%d-%m-%y"}{elseif $f->ViewValue}{$f->ViewValue}{else}{$f->getViewValue()}{/if}</b>
</td></tr>

					{/if}
	{/foreach}
	</table>
	</div>
{/if}


