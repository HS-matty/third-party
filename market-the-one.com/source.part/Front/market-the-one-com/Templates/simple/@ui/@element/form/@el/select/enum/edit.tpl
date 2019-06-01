
	<select id = "{$field->name}" name="{$field->name}">
			<option style="font-weight:bold;font-style:italic" value=""> &nbsp </option>
				{foreach from=$field->options->getElements() value="option"}
					<option {if $field->getValue() == $option->value} selected {/if} value="{$option->value}">{$option->value}</option>
				{/foreach}
							
	</select>
						
					