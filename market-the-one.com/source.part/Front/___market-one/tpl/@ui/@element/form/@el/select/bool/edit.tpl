	 {* if $field->is_multiple} multiple {if $field->size}size="{$field->size}" {else} size="20"{/if} {/if} {if $field->is_test}onChange="test(this.value)"{/if *}
	<select id = "{$field->name}" name="{$field->name}{if $field->is_multiple}[]{/if}">
			<option style="font-weight:bold;font-style:italic" value=""> &nbsp </option>
				{foreach from=$field->options->getElements() value="option"}
					<option {if $field->getValueInt() === $option->getValueInt()} selected {/if} value="{$option->getValueInt()}">{$option->title}</option>
				{/foreach}
							
			</select>
						
					