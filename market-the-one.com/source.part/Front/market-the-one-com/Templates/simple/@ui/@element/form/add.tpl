
				<table border=0>
	
				{foreach from=$ui_element->getFields() value=field}

					
					
						{if !$field->edit->is_allowed == 1}
							
					  <tr>
						<td class="form_td_title"><b>{$field->getTitle()}</b>: {if $field->getParam('is_required')}<font color="red">*</font>{/if} </td>
							<td class="form_td_value">  
							{assign var=template_file value=$tpl->getTemplate($field->type,'edit',$field->type_db)}
							
							
							
								{include file=$template_file} 
							
								{if $debug_template}{$template_file}{/if}
							
							  {if $field->getErrorFlag()}
									{foreach from=$field->getErrorMessageList() key=key item=message}<br>
										<span class="help-inline" style="color:red">{$message}</span>
								{/foreach}
						  {/if}
						</td>
					</tr>
					 
								
						  
					
					
						{elseif !$field->view->is_not_allowed == 1}
							
							<tr>
								<td  style="text-align:right;vertical-align:top;padding-right:0px"><b>{$field->getTitle()}:</b> </td>
								<td>{$field->getValueString()}</td>
							</tr>
						
						{/if}			
				
				{/foreach}
				
				<tr>
					<td  colspan="2" style="padding:10px;text-align:center">
						{if $ui_element->id}<input type="hidden" name="form_id" value="{$ui_element->id}">{/if}
						<input type="hidden" name="post" value="1">
						<button type="submit" class="btn">Send</button>
					
						
					</td>
				</tr>
				</table>
		
