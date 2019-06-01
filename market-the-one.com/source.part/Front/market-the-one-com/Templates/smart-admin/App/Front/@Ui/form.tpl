
				

			
			
			
				{if $form->getPrimaryKeyField()}
					
					{assign value= $form->getPrimaryKeyField() var=primary_key_field}
						
				{/if}
				
				

				<table border=0>
				
				{foreach from=$form->getFields() value=field}

				
				
						{assign value=$field->getValue() var=value }
																	
						  
					
											
							<tr>
								<td   class="form_td_title" style="text-align:right;vertical-align:top;padding-right:0px"><b>{$field->getTitle()}:</b> </td>
								
								
								<td  style="padding-top:5px;padding-left:10px;vertical-align:top;">
						
								
									{if $value->getParam('class') == 'url'}
									
										{if $value->getParam('url_type') == 'redirect'}
											
											
											<a href="{$host_name}/redirect/?url={$field->getValueString()|escape:'url'}" target="_blank">{$field->getValueString()}</a>
											
										{else}
											<a href="{$field->getValueString()}&{$field->getParam('url_params')}" target="_blank">{$field->getValueString()}</a>
										{/if}
										
									{elseif  $field->getType() == 'image'}
								
										<img src="{$field->getValue()}" alt="{$field->getTitle()}">
									
									{else}{$field->getValueString()}{/if}
									
								</td>
								
							</tr>
						
					
				
				{/foreach}
				
				
				</table>