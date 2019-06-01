		
{literal}
<style>

		.form_td_title {
			text-align:right;
			vertical-align:top;
			padding-right:0px;
			padding-top:5px;
		}
		.form_td_value{
			vertical-align:top;
			padding-top:0;
		}
</style>
{/literal}

		

		
		<table border=0 width="600px">
						
				<tr><td>
				{if $ui_element->getSuccessStatus() ==1}
				<span style="color:green;padding-left:40px"><b>Success!</b></span>
				{elseif $ui_element->getErrorFlag()}
				
					<div style="color:red;padding-left:40px">
						<strong> .. validation not passed</strong>
						{foreach from=$ui_element->getErrorMessageList() value=error_message}
						
						<ul>
							<li>{$error_message}</li>
						</ul>
						 
						
						{/foreach}
					</div>
				{else}
				<span class="alert" style="visibility:hidden"> .. </span>
				{/if}
			
			</td></tr>
			</table>
			

		
		
		<form class="form-horizontal"  id="ui-form" method="get" style="__padding-top:40px;background:#EEF8FD;width:600px" enctype="multipart/form-data">
			<fieldset>
				<legend>{$ui_element->getTitle()}:</legend>
				
				<table border=0	 >
				
				{foreach from=$ui_element->getFields() value=field}

					
					{if $field->type == 'input'}
						{if $field->edit->is_allowed == 1}
							
					  <tr>
						<td style="text-align:right;vertical-align:top;padding-right:0px;padding-top:5px"><b>{$field->getTitle()}</b>: {if $field->getParam('is_required')}<font color="red">*</font>{/if} </td>
						<td style="vertical-align:top;padding-top:0"> <input name ="{$field->getName()}" {if $field->view->type == 'password'} type="password" {else} type="text" {/if} value="{$field->getValue()}" id="{$field->getName()}" placeholder="">
							  {if $field->getErrorFlag()}
									{foreach from=$field->getErrorMessageList() key=key item=message}<br>
										<span class="help-inline" style="color:red">{$message}</span>
								{/foreach}
						  {/if}
						</td>
					</tr>
					 
								
						  
					
					
						{elseif $field->view->is_allowed == 1}
							
							<tr>
								<td  style="text-align:right;vertical-align:top;padding-right:0px"><b>{$field->getTitle()}:</b> </td>
								<td>{$field->getValueString()}</td>
							</tr>
						
						{/if}			
						
						
					{elseif $field->type == 'select'}
					
					
						{assign var=tpl_file value=$tpl->preparePath("/@ui/@element/form/@el/select-edit.tpl")}
						
						{include file=$tpl_file}
						
						
						
					{elseif $field->type == 'file'}
				
							<div class="control-group {if $field->getErrorFlag()} error {/if}">
							<label class="control-label" for="inputEmail">{$field->getTitle()} {if $field->getParam('is_required')}<font color="red">*</font>{/if}</label>
								<div class="controls">
									<span class="btn btn-file">
							
										<input type="file" name="{$field->name}" id="image" />
									</span>
									{if $field->getErrorFlag()} 
													{foreach from=$field->getErrorMessageList() key=key item=message}
														<span class="help-inline">{$message}</span>
														
												{/foreach}
										  {/if}
						
								</div>
							</div>
							
			
				
				
				{/if}
				
				{/foreach}
				
				<tr>
					<td  colspan="2" style="padding:10px;text-align:center">
						<button type="submit" class="btn">Отправить</button>
						<input type="hidden" name="post" value="1">
					</td>
				</tr>
				</table>
					</fieldset>
				  </form>
		
