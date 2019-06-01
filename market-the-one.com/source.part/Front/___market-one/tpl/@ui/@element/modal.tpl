{assign value=$page->getCurrentUiElement() var=ui_element} 
<div id="{$ui_element->getName()}" class="modal hide  " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">{$ui_element->getTitle()}</h3>
  </div>
  <div class="modal-body">
    <p>{$ui_element->body}</p>
  </div>
  <div class="modal-footer">
  
	<button {if $ui_element->footer->element_buttonCancel->actions->click->value} onClick = "javascript:{$ui_element->footer->element_buttonCancel->actions->click->value}"{/if} class="btn" data-dismiss="modal" aria-hidden="true">{$ui_element->footer->element_buttonCancel->title}</button>
    <button {if $ui_element->footer->element_buttonSave->actions->click->value} onClick = "javascript: {$ui_element->footer->element_buttonSave->actions->click->value}"{/if} class="btn btn-primary">{$ui_element->footer->element_buttonSave->title}</button>
	
  </div>
</div>

