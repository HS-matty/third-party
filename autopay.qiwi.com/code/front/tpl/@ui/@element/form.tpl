<form class="form-horizontal"  method="post" style="padding-top:40px" enctype="multipart/form-data">

		
		<h3>{$ui_element->getTitle()}</h3>
	
		{foreach from=$ui_element->getFields() value=field}

		
			{if $field->type == 'input'}
			
			  <div class="control-group {if $field->getErrorFlag()} error {/if}">
				<label class="control-label" for="inputEmail">{$field->getTitle()} {if $field->getParam('is_required')}<font color="red">*</font>{/if}</label>
				<div class="controls">
							
				  <input name ="{$field->getName()}" {if $field->view->type == 'password'} type="password" {else} type="text" {/if} value="{$field->getValue()}" id="{$field->getName()}" placeholder="">
		
				  {if $field->getErrorFlag()}
							{foreach from=$field->getErrorMessageList() key=key item=message}
								<span class="help-inline">{$message}</span>
						{/foreach}
				  {/if}
				</div>
			</div>		  
				
				
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
		   
		  </div>
		  <input type="hidden" name="post" value="1">
		</form>