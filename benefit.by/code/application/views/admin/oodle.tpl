<form method="post" action="">
<input type="hidden" name="post" value=1>
<table width="100%" cellpadding="3" cellspacing="0">
									<tr>
										<td colspan="7" class="tableHeading">Search</td>
									</tr>
									<tr>
										<td width="60">Category:</td>
										<td width="180"><select name="cid" style="width: 134px;">
				<option value="{$rootcid}">All</option>
{foreach from=$Cats.a_tree item=flevel}
<option value="{$flevel.k_item}" {if $Params.cid== $flevel.k_item} selected {/if}>{$flevel.s_name}</option>
	{if $flevel.a_tree}
	{foreach from=$flevel.a_tree item=slevel}
	<option value="{$slevel.k_item}" class="sub" {if $Params.cid== $slevel.k_item} selected {/if}>&nbsp;&nbsp;&nbsp;{$slevel.s_name}</option>
	{/foreach}
	{/if}
{/foreach}
										
	
	</select></td>
										
										
										
										
										<td width="60">Email</td>
										<td width="100">
<input type="text" name="email" value="{$Params.email|escape}">
										</td>
										<td width="75"></td>
										<td></td>
									</tr>
									<tr>
										<td>Flag:</td>
										<td><select name="flag">
						<option value="none" selected="selected">none</option>
					<option {if $Params.flag=="misclassified"} selected {/if} value="misclassified">misclassified</option>
					<option {if $Params.flag=="forbidden"} selected {/if} value="forbidden">forbidden</option>
					<option {if $Params.flag=="spam"} selected {/if}>spam</option>
										</select></td>
										<td></td>
										<td>

										</td>
										<td></td>
										<td width="100"></td>
										<td><input type="submit" value="Search" /></td>
									</tr>
								</table></form>
{include file=$View->getIndexTmpl('grid.tpl')}