
<div class="row">
      <div class="span3">
		<form method="POST" name="{$ui_element->name}" enctype="multipart/form-data">
			{if $ui_element->title}<legend>{$ui_element->title}</legend>{/if}
				<fieldset  style="padding-left:10px;background-color:#F4F4F4" >
			
				{foreach from=$ui_element->getFields() value=field}
				
					{if $field->type == 'select'}
					<label>{$field->title}:</label>
						<select id  = "{$field->name}" name="{$field->name}{if $field->is_multiple}[]{/if}" {if $field->is_multiple} multiple {if $field->size}size="{$field->size}" {else} size="20"{/if} {/if} {if $field->is_test}onChange="test(this.value){/if}">
							<option style="font-weight:bold;font-style:italic">...</option>
						{foreach from=$field->getElements() value="option"}
							<option {if $field->getValue($option->value) == $option->value} selected {/if} value="{$option->value}">{$option->title}</option>
						{/foreach}
						</select>
						<br />
					
					{elseif $field->type == 'date'}
					<label>{$field->title}:</label>
					<div id="{$field->name}" class="input-append date"  data-date="01-08-2013" data-date-format="dd-mm-yyyy">
						<input class="span2" size="16" type="text" name="{$field->name}" value="{$field->value}">
						<span class="add-on"><i class="icon-calendar"></i></span>
					  </div>

						<br />
						
					{elseif $field->type == 'file'} 
					<div class="control-group ">
					<label class="control-label" for="inputEmail">{$field->getTitle()} {if $field->getParam('is_required')}<font color="red">*</font>{/if}</label>
						<div class="controls">
							<span class="btn btn-file">
					
								<input type="file" name="{$field->name}" id="image" />
							</span>
				
						</div>
					</div>
					
		
					{elseif $field->type == 'checkbox'}
					<label class="checkbox">
					<input type="checkbox" name="{$field->name}" value="1" {if ($field->default_value == 1 && !$post) || $field->value === 1 } checked {/if}> {$field->title}
					</label>
					{else}

					<label><b>{if $field->getParam('is_required')}<font color="red">*</font>{/if}{$field->title}:</b></label>
					<div class="control-group {if $field->getErrorFlag()} error{/if}">
						<div class="controls">
							<input {if $field->view->type=='password'} type="password" {else} type="text" {/if} name = "{$field->name}" value= "{$field->getValue()}" placeholder="" id="inputError">
								  {if $field->getErrorFlag()} 
											{foreach from=$field->getErrorMessageList() key=key item=message}
												<span class="help-inline">{$message}</span>
												
										{/foreach}
								  {/if}
						</div>
					</div>
				
					{/if}
					
					
				{/foreach}
				
				<input type="hidden" name="post" value="1">
					<br /><button type="submit" class="btn">Submit</button>
		  </fieldset>
		  
		</form>
		
	  </div>
	  

</div>
