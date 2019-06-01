			<!--
			<form class="form-horizontal"  method="post" style="__padding-top:40px;background:#EEF8FD;width:600px" enctype="multipart/form-data">
			<fieldset>
				<legend>Personal information:</legend>
				
				{foreach from=$ui_element->getFields() value=field}

					
					{if $field->edit->type == 'input'}
						{if $field->edit->is_allowed == 1}
							
					  <div class="control-group {if $field->getErrorFlag()} error {/if}">
						<label class="control-label" >{$field->getTitle()}: {if $field->getParam('is_required')}<font color="red">*</font>{/if}</label>
						<div class="controls">			
						  <input name ="{$field->getName()}" {if $field->view->type == 'password'} type="password" {else} type="text" {/if} value="{$field->getValue()}" id="{$field->getName()}" placeholder="">
				
				
						  {if $field->getErrorFlag()}
									{foreach from=$field->getErrorMessageList() key=key item=message}<br>
										{$message}
								{/foreach}
						  {/if}
						  
						 
						</div>
					</div>		
						{elseif $field->view->is_allowed == 1}
						 <div class="control-group" >
							<label class="control-label">{$field->getTitle()}: </label>
							<div class="controls" style="padding:0px;margin:0px" >{$field->getValueString()}</div>
						</div>
						{/if}			
						
						
					{elseif $field->type == 'select'}
					
						{assign var=tpl_file value=$tpl->preparePath("/@ui/@element/form/@el/select.tpl")}
						
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
				 <div class="control-group">
					<div class="controls">
						<button type="submit" class="btn">Отправить</button>
					</div>
				  </div>
				   
				 
				  <input type="hidden" name="post" value="1">
				
					</fieldset>
				  </form>
		
		-->
		
		
		<!-- NEW FORM-->