{literal}

<script type="text/javascript">
	
	$('.datepicker').datepicker();
		
		
		
	function _test(){
		alert('test');
	}
		
				  	  
</script>

{/literal}

		
{assign var=form value=$grid->getParam('filter_form')}


	  
		<form class="form-inline" method="GET" name="{$form->getName()}">
			{if $form->title_}<legend>{$form->title}</legend>{/if}
				<div class="well">
	
				
				{foreach from=$form->getFields() value=field}
					{if $field->type == 'select'}
					
					{elseif $field->class == 'date'}
						
					
					
					<div  id="datetime_picker_{$field->name}" class="input-append date" data-provide="datepicker" data-date="05-04-2017" data-date-format="dd-mm-yyyy" >
						<input id="_date" class="input-medium" size="16" type="text" name="{$field->name}" value="{$field->value}" placeholder="{$field->getTitle()}">
						<span class="add-on" ><i class="icon-calendar"></i></span>
					  </div>
					
						{literal}

						<script type="text/javascript">
								
						$('#datetime_picker_{/literal}{$field->name}{literal}').datepicker({
							format: 'dd-mm-yyyy'
						})
											  
						</script>

						{/literal}

					
					 
					{elseif $field->type == 'checkbox'}
					
					
					{else}
					
						<input type="text" name="{$field->getName()}" class="input-medium" placeholder="{$field->getTitle()}" value= "{$field->getValue()}">
						
					{/if}
					
				{/foreach}
				

			<input type="hidden" name="post" value="1">
  
			<button type="submit" class="btn">Submit</button>
		</div>
	</form>
	  
	  
	  
	  
		<!--form class="form-inline" method="GET" name="{$ui_element->getName()}">
			
				<fieldset  style="padding-left:10px;background-color:#F4F4F4" >
			
				{foreach from=$ui_element->getFields() value=field}
				
					{if $field->type == 'select'}
					<label>{$field->title}:</label>
						<select class="input-medium" id  = "{$field->name}" name="{$field->name}{if $field->is_multiple}[]{/if}" {if $field->is_multiple} multiple {if $field->size}size="{$field->size}" {else} size="20"{/if} {/if} {if $field->is_test}onChange="test(this.value){/if}">
							<option style="font-weight:bold;font-style:italic">...</option>
						{foreach from=$field->getElements() value="option"}
							<option {if $field->getValue($option->value) == $option->value} selected {/if} value="{$option->value}">{$option->title}</option>
						{/foreach}
						</select>
						<br />
					
					{elseif $field->type == 'date'}
					<label>{$field->title}:</label>
					<div id="{$field->name}" class="input-append date"  data-date="01-08-2013" data-date-format="dd-mm-yyyy">
						<input class="input-medium" size="16" type="text" name="{$field->name}" value="{$field->value}" >
						<span class="add-on"><i class="icon-calendar"></i></span>
					  </div>

						<br />
						
					{elseif $field->type == 'file'} 
					<div class="control-group ">
					<label class="control-label" for="inputEmail">{$field->getTitle()} {if $field->getParam('is_required')}<font color="red">*</font>{/if}</label>
						<div class="controls">
							<span class="btn btn-file">
					
								<input class="input-medium" type="file" name="{$field->name}" id="image" />
							</span>
				
						</div>
					</div>
					
		
					{elseif $field->type == 'checkbox'}
					<label class="checkbox">
					<input class="input-medium" type="checkbox" name="{$field->name}" value="1" {if ($field->default_value == 1 && !$post) || $field->value === 1 } checked {/if}> {$field->title}
					</label>
					{else}

					<label>{if $field->getParam('is_required')}<font color="red">*</font>{/if}{$field->title}:</label>
					<div class="control-group {if $field->getErrorFlag()} error{/if}">
						<div class="controls">
							<input class="input-medium" {if $field->view->type=='password'} type="password" {else} type="text" {/if} name = "{$field->name}" value= "{$field->getValue()}" placeholder="" id="inputError">
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
		  
		</form-->
		




