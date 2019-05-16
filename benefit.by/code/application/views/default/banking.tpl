{assign var="qr" value=$Grid->qr}

{if $User->isLogined('RegisteredUser')}
<table width="100%" border="0">
	<tr>
				<td>
				<a href="#" class="page">&lt;</a><a href="#" class="page">&lt;</a> <a href="#" class="page">1</a> <a href="#" class="page">2</a> <a href="#" class="page">3</a> <a href="#" class="page">4</a> <a href="" class="page">5</a> <a href="#" class="page">&gt;</a><a href="#" class="page">&gt;</a>
				</td>
				<td class="pager_info">	
					{if !$qr->getTotalRows()} Ничего не найдено 
						
					{else}	Показано с 														{$qr->getCurrentPageRowsIndexStart()} по {$qr->getCurrentPageRowsIndexEnd()} | Всего {$qr->getTotalRows()}
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
			<table border="0" cellpadding="0" cellspacing="0" id="special">
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
<table class="table_sr" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center" background="{$HostName}/images/table/title_bg.gif"><h3>Сравнение</h3></td>
				</tr>
				<tr>
				{foreach from=$Grid->getListHeader() item=h name=title}
						{if $smarty.foreach.title.last==true}<td class="table_header_r"><div id="table_header">{$h.title}</div></td>
						{else}
						<td class="table_header"><div id="table_header">{$h.title}</div></td>
						{/if}
					{/foreach}
				</tr>
			
				{foreach from=$items item=l name=rows}
				<tr>
						{foreach from=$Grid->Fields item=f name=body}
							{assign var="id" value=$f->ID}
						{assign var="DbField" value=$f->DbField}
					
						{if $smarty.foreach.rows.iteration%2!=0}<td {if $smarty.foreach.body.iteration%4==0}class="table_body_1_r"{else}class="table_body_1"{/if} width="70">
						{else}
						<td {if $smarty.foreach.body.iteration%4==0}class="table_body_2_r"{else}class="table_body_2"{/if} width="70">
						{/if}
						{if $f->Link && $f->Type != 'additional'}
						<a href="{$f->Link}?
						{foreach  from=$f->LinkParams item=p}{assign var="df" value=$p.DataField}{$p.Title}={$l.$df}&{/foreach}">{$l.$id} {$f->Postfix} </a>
						{elseif $f->Type == 'additional'}

					
						<a href="{$f->Link}{if $f->LinkParams}?{foreach  from=$f->LinkParams item=p}{assign var="df" value=$p.DataField}{$p.Title}={if $p.Value}{$p.Value}{else}{$l.$df}{/if}&{/foreach}{/if}{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">{$f->Title}</a>
						
							{else}{$l.$id}{$f->Postfix} {/if}
						&nbsp;
					</td>
						{/foreach}
				</tr>
				{/foreach}
					<tr ><td  colspan=5 align="center">	{if !$qr->getTotalRows()} Ничего не найдено 
					{if $vary}
							 , Вы можете {if $vary.vary_direction == 'up'} увеличить {else} уменьшить {/if} поле {$vary.field_title} на {$vary.points} пункта
							 для получения результата.
 						{/if}
					
					{else}	Показано с 														{$qr->getCurrentPageRowsIndexStart()} по {$qr->getCurrentPageRowsIndexEnd()} | Всего {$qr->getTotalRows()} 
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
		
		{/if}