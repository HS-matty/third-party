{if $qr} <table width="100%"><tr bgcolor="ffffff" height="40"><td  align="center">
Pages : {section name=page loop=$qr->getTotalPages()}

{assign var="index" value=$smarty.section.page.index } 
 
{if $index == $qr->PageIndex}<b>{$index+1}</b>{else}
<a href="?page={$index}&{$qr->getHTMLRanges()}{$Grid->getHTMLUrlParams()}">{$index+1}</a>{/if} {/section}
<br>Total: <b>{$qr->getTotalRows()}</b> records.
</td></tr>
</table>
{/if}