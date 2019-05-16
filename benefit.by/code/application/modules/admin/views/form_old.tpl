
{if $Form->isActive}
	{if $Form->Action == 'insert' || $Form->Action == 'update'}



		<h4>{$Form->Action} {$Form->FormTitle}</h4><br />
		<form method="post" enctype="multipart/form-data">

		<input type="hidden" name="sid" value="{$Sid}">

		<table width="{if $Form->FormWidth}{$Form->FormWidth}{else}70%{/if}" class="realty" border="0">
		  <tr>
		    <td><div align="center"></div></td>
		  </tr>


		{foreach from=$Form->getXMLFormContent() item=f}
		 <tr><td> 
		 
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
					{else}
					{include file=$Page->getIndexTmpl('int_edit.tpl')}

		{/if}
		</td></tr>
		{/foreach}


		<tr><td><br><div align="center"><input type="submit" value="Submit"></div></td></tr>
		</table>
		<input type="hidden" name="post" value="form1">

		</form>
		
		{else}
		
				<table width="70%" class="realty" border="0">
		  <tr>
		    <td><div align="center"></div></td>
		  </tr>


		{foreach from=$Form->getXMLFormContent() item=f}
		 <tr><td> 
		 
		 		
					{if $f->Type == 'bool'} 
					{include file=$Page->getIndexTmpl('bool_view.tpl')}
					{elseif $f->Type == 'file'} 
					{include file=$Page->getIndexTmpl('file_view.tpl')}
					{else}
					{include file=$Page->getIndexTmpl('string_view.tpl')}

		{/if}
		</td></tr>
		{/foreach}
		<tr><td></div></td></tr>
		</table>
		
		{/if}

{/if}