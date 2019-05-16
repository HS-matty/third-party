{if $Grid}
<div id="grid" {if $Grid->GridAlign}style="text-align:{$Grid->GridAlign}"{/if}>


{assign var="qr" value=$Grid->qr}







<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td width="732" valign="top" id="resultSet">
									<div class="pagination">
										<table width="100%" cellpadding="0" cellspacing="0">
											<tr>
												<td align="left">
			{if !$qr->getTotalRows()} No listings were found. Please search again. </td>{else}															{$qr->getCurrentPageRowsIndexStart()}-{$qr->getCurrentPageRowsIndexEnd()} of {$qr->getTotalRows()}
												</td>
												<td>

												
												
												
												
													{if $qr->PageIndex > 0}<a href="?page={$qr->PageIndex-1}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">&lt;&lt; prev</a>&nbsp;{/if}

			
{section name=page loop=$qr->getTotalPages()}

{assign var="index" value=$smarty.section.page.index } 
 
{if $index == $qr->PageIndex}<b>{$index+1}</b>{else}
<a href="?page={$index}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">{$index+1}</a>{/if} {/section}
						
											
																	
	
		{if $qr->PageIndex < $qr->getLastIndex()}<a href="?page={$qr->PageIndex+1}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">next &gt;&gt;</a>{/if}
		

												</td>
											{/if}
											</tr>
										</table>
									</div>
									<div id="results">
										<table width="96%" cellpadding="2" cellspacing="0">
										
										{foreach from=$Grid->getList() item=l}

<tr bgcolor="#EFEFEF" onmouseout = "this.style.background='#EFEFEF'" onmouseover="this.style.background='#F7F7F7'" style="text-align:left" height="25px">
	{foreach from=$Grid->Fields item=f}
		
		{if $f->isVisible}
					{assign var="id" value=$f->ID}
					{assign var="DbField" value=$f->DbField}
					
					{if $f->Type=='bool'}
					
						
							<td>{if $l.$id == 0} No
							{elseif $l.$id == 1}Yes{else}Error{/if} 	{if $f->Link}(
								<a href="{$f->Link}{if $f->LinkParams}?{foreach  from=$f->LinkParams item=p}{assign var="df" value=$p.DataField}{$p.Title}={$l.$df}&{/foreach}{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}{/if}{if $qr->PageIndex}&page={$qr->PageIndex}{/if}">change</a>)
							{/if}</td>
					
					
					{elseif $f->Type == 'date'}
						<td>{$l.$id|date_format:"%d-%m-%y"}</td>
					{elseif $f->Type == 'video'}
						<td>{if $l.$id}<img src="{$HostName}/directory/watch_thumb/image.jpeg?id={$l.$id}" height="96" width="96">{/if}</td>
					{elseif $f->Type == 'timedate'}
						<td>{$l.$id|date_format:"%d-%m-%y, %H:%M "}</td>
					{elseif $f->Type == 'additional'}

					
					
						<td><a href="{$f->Link}{if $f->LinkParams}?{foreach  from=$f->LinkParams item=p}{assign var="df" value=$p.DataField}{$p.Title}={if $p.Value}{$p.Value}{else}{$l.$df}{/if}&{/foreach}{/if}{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">{$f->Title}</a></td>
						
					{else}
						
						
				
							<td>{if $f->Link}
						<a href="{$f->Link}?
						{foreach  from=$f->LinkParams item=p}{assign var="df" value=$p.DataField}{$p.Title}={$l.$df}&{/foreach}">{$l.$id} </a>
							{else}{$l.$id}{/if}
							
						
										{if $f->Ordering}
										
										
										<a href="{$f->Ordering->UpLink}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}&id={$l.cid}"><img src="{$HostName}/images/up.gif" title="up"></a>
										<a href="{$f->Ordering->DownLink}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}&id={$l.cid}"><img src="{$HostName}/images/down.gif" title="down"></a>
										
							
							{/if }
							</td>
					
				{/if}
		{/if}
	{/foreach}
	
	
	
	
	
	
{/foreach}
										
										
										
										
							
										</table>
									</div>
							  </td>

							</tr>
						</table>
	
</div>

{else}
<h4>Grid not loaded</h4>
{/if}



