{literal}

<script type="text/javascript">
	
	$('.datepicker').datepicker();
		
		
		
	function _test(){
		alert('test');
	}
		
				  	  
</script>

{/literal}

		
{assign var=form value=$grid->getParam('filter_form')}


	  
	  
	  <div class="well">
	  <form class="form-inline" role="form">
											
											<fieldset>
											
											{foreach from=$form->getFields() value=field}
											
											{if $field->type == 'select'}
					
											{elseif $field->class == 'date'}
														<div class="form-group">
															<div class="input-group">
																<input class="form-control hasDatepicker" id="to" type="text" placeholder="{$field->getTitle()}" name="{$field->name}"  value="{$field->getValue()}">
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
														</div>
											{else}
											
												<div class="form-group">
													<label class="sr-only" for="">{$field->getName()}</label>
													<input  class="form-control" id="" placeholder="{$field->getTitle()}" value= "{$field->getValue()}" name="{$field->name}">
												</div>
											{/if}
											{/foreach}
												
												<button type="submit" class="btn btn-default">
													Search
												</button>
											</fieldset>
										<input type="hidden" name="post" value="1">
											
						</form>
	  
	  
	  	
			
		</div>
		
		
		

