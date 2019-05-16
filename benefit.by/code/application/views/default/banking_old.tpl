<div>

{assign var="qr" value=$Grid->qr}

{if $User->isLogined('RegisteredUser')}
<table>
	<tr>
				<td width="300">
				<a href="#" class="page">&lt;</a><a href="#" class="page">&lt;</a> <a href="#" class="page">1</a> <a href="#" class="page">2</a> <a href="#" class="page">3</a> <a href="#" class="page">4</a> <a href="" class="page">5</a> <a href="#" class="page">&gt;</a><a href="#" class="page">&gt;</a>
				</td>
				<td class="pager_info">
					{if !$qr->getTotalRows()} Ничего не найдено{else}	Показано с 														{$qr->getCurrentPageRowsIndexStart()} по {$qr->getCurrentPageRowsIndexEnd()} | Всего {$qr->getTotalRows()}
					<br /> Страницы: 
					{section name=page loop=$qr->getTotalPages()}

{assign var="index" value=$smarty.section.page.index } 
 
{if $index == $qr->PageIndex}<b>{$index+1}</b>{else}
<a href="?page={$index}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">{$index+1}</a>{/if} {/section}

				{/if}
				</td>
				</tr>
			</table>
			{foreach from=$items item=l}
			<table width="595" cellpadding="0" cellspacing="0" id="special">
			<tr>
				<td>
					{foreach from=$Grid->Fields item=f}
				<div class="special_title"><a href="" class="special_title">{$l.$id}{$f->Postfix}</a></div>
				{/foreach}
				</td>
			</tr>
			</table>
			{/foreach}
{else}
<table class="table_sr" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="5" align="center" background="{$HostName}/images/table/title_bg.gif"><h3>Сравнение</h3></td>
				</tr>
				
				{foreach from=$items item=l}
				<tr>
						{foreach from=$Grid->Fields item=f}
							{assign var="id" value=$f->ID}
						{assign var="DbField" value=$f->DbField}
					<td class="table_body_1_r" width="70">{$l.$id}{$f->Postfix}</td>
						{/foreach}
				</tr>
				{/foreach}
					<tr ><td  colspan=5 align="center">	{if !$qr->getTotalRows()} Ничего не найдено{else}	Показано с 														{$qr->getCurrentPageRowsIndexStart()} по {$qr->getCurrentPageRowsIndexEnd()} | Всего {$qr->getTotalRows()} 
					<br /> Страницы: 
					{section name=page loop=$qr->getTotalPages()}

{assign var="index" value=$smarty.section.page.index } 
 
{if $index == $qr->PageIndex}<b>{$index+1}</b>{else}
<a href="?page={$index}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">{$index+1}</a>{/if} {/section}
</td></tr>
				{/if}
				<tr>
					<td class="table_bottom" colspan="5"><input type="submit" class="button_back" value="вернуться назад" /></td>
				</tr>
			</table>
			
			</div>
		
		{/if}