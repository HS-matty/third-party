
<form method="post" action="">
<input type="hidden" name="post" value=1>
<table cellpadding="3" cellspacing="0" border="0">
									<tr>
										<td colspan="3" class="tableHeading"><h3>Поиск</h3></td>
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
									
										<td >Тип</td>
										<td >
					<select name="service">
					
					{foreach from=$services item=s}
					<option {if $s.category_id == $service} selected {/if} value="{$s.category_id}">{$s.short_description}</option>
					{/foreach}
					
										</select>
										
										</td>
										<td><input type="submit" value="Найти" class="button" /></td>
									</tr>

								</table></form>


{include file=$View->getIndexTmpl('grid.tpl')}