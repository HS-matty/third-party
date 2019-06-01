<!--
			  <div class="control-group {if $field->getErrorFlag()} error {/if}">
				<label class="control-label" for="inputEmail">{$field->getTitle()} {if $field->getParam('is_required')}<font color="red">*</font>{/if}</label>
				<div class="controls">
							
					<select id  = "{$field->name}" name="{$field->name}{if $field->is_multiple}[]{/if}" {if $field->is_multiple} multiple {if $field->size}size="{$field->size}" {else} size="20"{/if} {/if} {if $field->is_test}onChange="test(this.value){/if}">
							<option style="font-weight:bold;font-style:italic" value="">...</option>
						{foreach from=$field->getElements() value="option"}
							<option {if $field->getValue() == $option->value} selected {/if} value="{$option->value}">&nbsp{$option->title}</option>
						{/foreach}
					</select>
		
				  {if $field->getErrorFlag()}
							{foreach from=$field->getErrorMessageList() key=key item=message}
								<span class="help-inline">{$message}</span>
						{/foreach}
				  {/if}
				</div>
			</div>		  
				
-->

