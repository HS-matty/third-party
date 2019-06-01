
			<fieldset>
			
							{foreach from=$ui_element->getFields() value=field}
								<div class="row">
								{if $field->getParam('is_primary_key')}
									<section class="col col-6">
										<label class="label"><strong>{$field->getTitle()}</strong> </label>
		
										<strong>{$field->getValue()}</strong>
	
									</section>
								{else}
								
								
								{assign var=template_file value=$tpl->getTemplate($field->type,'edit',$field->type_db)}
								<section class="col col-6">
									<label class="label"><strong>{$field->getTitle()}</strong> {if $field->getParam('is_required')}<font color="red">*</font>{/if} </label>
									<label class="input {if $field->getErrorFlag()}state-error {elseif $ui_element->getParam('is_submited')} state-success {/if}">
										{include file=$template_file}
									</label>
									<em id="name-error" class="invalid">
										{if $field->getErrorFlag()}
											{foreach from=$field->getErrorMessageList() key=key item=message}
											{$message}<br>
											{/foreach}
										{/if}
									
										</em>
									
								</section>
							
					
								
								{/if}
								
								
								
								
								</div>
							{/foreach}
							
							
							<input type="hidden" name="post" value="1">
							{if $ui_element->id}<input type="hidden" name="form_id" value="{$ui_element->id}">{/if}
							</fieldset>


		
				<!--table border=0>
				
				
				{foreach from=$ui_element->getFields() value=field}

					
						{if $field->getParam('is_primary_key')}
						<tr>
								<td  class="form_td_title" style="text-align:right;vertical-align:top;padding-right:19px"><b>{$field->getTitle()}:</b> </td>
								<td style="padding-top:5px;padding-left:0px;vertical-align:top;">{$field->getValueString()}</td>
						</tr>
						<input type="hidden" name="_{$field->getName()}" value="{$field->getValue()}">
					
						{elseif !$field->edit->is_allowed == 1}
							
					  <tr>
						<td class="form_td_title"><b>{$field->getTitle()}</b>: {if $field->getParam('is_required')}<font color="red">*</font>{/if} </td>
							<td class="form_td_input">  
							{assign var=template_file value=$tpl->getTemplate($field->type,'edit',$field->type_db)}
							
							
					
							
							
							
							  {if $field->getErrorFlag()}
									{foreach from=$field->getErrorMessageList() key=key item=message}<br>
										<span class="help-inline" style="color:red"><em>{$message}</em></span>
								{/foreach}
						  {/if}
						</td>
					</tr>
					 
								
						  
					
					
						{elseif !$field->view->is_not_allowed == 1}
							
							<tr>
								<td  style="text-align:right;vertical-align:top;padding-right:0px" class="form_td_title"><b>{$field->getTitle()}:</b> </td>
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
				</table-->
		
