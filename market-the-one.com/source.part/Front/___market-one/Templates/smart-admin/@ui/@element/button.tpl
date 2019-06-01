{assign var=action value=$ui_element->getAction('click') }

{if $action && !$action->value->type}<a href="{$action->getValue()}">{/if}
<button class="btn btn-small" type="button" {if $action && $action->value->type == 'Dialog'} onClick="javascript: $('#{$action->getValue()}'.modal();" data-toggle="modal" data-target="#{$action->getValue()}" {/if}name="{$ui_element->getName()}">{$ui_element->getTitle()}</button>
{if $action && !$action->value->type} </a>{/if}

