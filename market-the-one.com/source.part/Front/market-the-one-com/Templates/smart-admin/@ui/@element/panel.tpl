
		{assign var=panel value=$ui_element}
		{foreach from=$panel->getElements() value=panel_element}
			{assign var=action value=$panel_element->getAction('onClick') }
			<a href="{$action->value}"><button name="{$panel_element->name}" type="button" class="btn btn-default">{$panel_element->title}</button></a>
		{/foreach}
		
