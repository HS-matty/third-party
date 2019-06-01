


<input  name ="{$field->getName()}" {if $field->view->type == 'password'} type="password" {else} type="text" {/if} value="{$field->getValue()}" id="{$field->getName()}" placeholder="">
