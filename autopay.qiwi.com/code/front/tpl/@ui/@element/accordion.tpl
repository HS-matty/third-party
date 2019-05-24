
 <form method="post" name="{$ui_element->name}" id="form-ajax">
      <div class="span9">
	 	<div class="accordion" id="form_accordion">
		  {foreach from=$ui_element->getElements() key=key value=el}
		  <div class="accordion-group">
			<div class="accordion-heading">
			  <a class="accordion-toggle" data-toggle="collapse" data-parent="#form_accordion" href="#collapse_{$key}">
				{$el->getTitle()}
			  </a>
			</div>
			<div id="collapse_{$key}" class="accordion-body collapse ">
			  <div class="accordion-inner">
				{if $el->type == 'text'}
				
					{$el->getValue()}
					
				{else if $type == 'form'}
				
				{foreach from=$el->getElements() key=key value=field}
					
					<label class="checkbox inline">
						<input type="checkbox" name="{$field->name}" id="{$field->name}" value="1" {if $field->value} checked {/if}> {$field->title}
					</label>
				
				{/foreach}
				{/if}
			  </div>
			</div>
		  </div>
		  {/foreach}
		  
		</div>
			<button type="submit" id="form-submit" class="btn">Save</button>
		
	  </div>
 </form>
