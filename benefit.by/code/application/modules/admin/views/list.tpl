
<div id="list">
{if $List}
<table  bgcolor="#Ffffff" border=0 width="100%" >
<tr bgcolor="#666666" style="color:#ffffff" >
{foreach from=$List->getListHeader() item=h}
<td><strong>{$h.title} {if $h.orderby}
<a href="?order={$h.ID}&direction=asc"><img src="{$HostName}/images/up.gif" title="up"></a>
<a href="?order={$h.ID}&direction=desc"><img src="{$HostName}/images/down.gif" title="down"></a>{/if}</strong></td>

{/foreach}
</tr>

{foreach from=$List->getList() item=l}
<tr bgcolor="{cycle values="#eeeeee,#E8E8E8"}" height="20px">
	{foreach from=$List->Fields item=f}
		{assign var="DbField" value=$f->DbField}
		
		{if $f->Type=='bool'}
		
			
				<td>{if $l.$id == 0} No
				{elseif $l.$id == 1}Yes{else}Error{/if}</td>
		
		
			
			{elseif $f->Type == 'additional'}

		
			<td><a href="{$f->Link}{if $f->LinkParams}?{foreach  from=$f->LinkParams item=p}{assign var="df" value=$p.DataField}{$p.Title}={$l.$df}&{/foreach}{/if}">{$f->Title} </a></td>
			
		{else}
			{assign var="id" value=$f->ID}
			
	
				<td>{if $f->Link}
			<a href="{$f->Link}?
			{foreach  from=$f->LinkParams item=p}{assign var="df" value=$p.DataField}{$p.Title}={$l.$df}&{/foreach}">{$l.$id} </a>
				{else}{$l.$id}{/if}</td>
		
	{/if}
	{/foreach}
	
	
	
	
	
	
{/foreach}
</table>

{include file=$Page->getQr()}

{else}
<h4>List not loaded</h4>
{/if}
</div>

