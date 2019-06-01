		

				<table border=0>
				
				{foreach from=$ui_element->getFields() value=field}

											
						  
					
					
						{if !$field->view->is_allowed == 1}
						
							<tr>
								<td   class="form_td_title" style="text-align:right;vertical-align:top;padding-right:0px"><b>{$field->getTitle()}:</b> </td>
								<td  style="padding-top:5px;padding-left:10px;vertical-align:top;">{$field->getValueString()}</td>
							</tr>
						
						{/if}			
				
				{/foreach}
				
				
				</table>
		
		
