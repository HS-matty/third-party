
<form method="post" action="">
<input type="hidden" name="post" value=1>
<table width="100%" cellpadding="3" cellspacing="0">
									<tr>
										<td colspan="8" class="tableHeading">Search</td>
									</tr>
									<tr>
										<!--td >Email:</td>
										<td ><input type="text" name="email" value="{$Params.email|escape}"></td>
										
										
										
										
										<td >Is active</td>
										<td >
					<select name="is_active">
						<option  value="">All</option>
											<option {if $Params.is_active=="2"} selected {/if} value="2">Yes</option>
					<option {if $Params.is_active=="1"} selected {/if}>No</option>
										</select>
										
										</td-->
										<td >Компания</td>
										<td >
					<select name="user_id">
					<option>All</option>
					{foreach from=$users item=u}
					<option {if $u.bluser_id == $Params.user_id} selected {/if} value="{$u.bluser_id}">{$u.company}</option>
					{/foreach}
					</select>
										
										</td>
										<td >Тип</td>
										<td >
					<select name="service">
					
					{foreach from=$services item=s}
					<option {if $s.category_id == $Params.service} selected {/if} value="{$s.category_id}">{$s.short_description}</option>
					{/foreach}
					
										</select>
										
										</td>
										<td width="75"></td>
										<td><input type="submit" value="Search" /></td>
									</tr>

								</table></form>


{include file=$View->getIndexTmpl('grid.tpl')}