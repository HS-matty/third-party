
<!-- SMART-ADMIN UI-ELEMENT-Form -->
{assign value=$ui_element->getActionType() var=action_type }
{assign var=action_file value = "$template_base_path/@ui/@element/form/$action_type.tpl"}


{assign value=$ui_element->getPrimaryKeyField()  var=primary_key_field}
{if $primary_key_field}
	{assign value=$primary_key_field->getValue()  var=primary_key_field_value}
{/if}



	
{if $ui_element->getStatus() == 'success'}
<div class="alert alert-block alert-success">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> Check validation!</h4>

</div>
{elseif $ui_element->getErrorFlag}

{else}
<div class="alert alert-block alert-success" style="visibility:hidden">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> Check validation!</h4>

</div>

{/if}


		
		<!--table border=0 width="600px" >
						
				<tr><td><br />
				{if $ui_element->getStatus() == 'success'}
				<span style="background:green;color:white;padding-left:0px"><b>Success!</b></span>
				{elseif $ui_element->getErrorFlag()}
				
					<div style="color:red;padding-left:40px">
						<strong> .. validation not passed</strong>
						{foreach from=$ui_element->getErrorMessageList() value=error_message}
						
						<ul>
							<li>{$error_message}</li>
						</ul>
						 
						
						{/foreach}
					</div>
				{else}
				<span class="alert" style="visibility:hidden"> .. </span>
				{/if}
			
			</td></tr>
			</table>
			<br /-->


		
		
		<div class="row">
				
						<!-- NEW COL START -->
						<article class="col-sm-12 col-md-12 col-lg-6 sortable-grid ui-sortable">
				
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-sortable" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" role="widget">
								<!-- widget options:
								usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
				
								data-widget-colorbutton="false"
								data-widget-editbutton="false"
								data-widget-togglebutton="false"
								data-widget-deletebutton="false"
								data-widget-fullscreenbutton="false"
								data-widget-custombutton="false"
								data-widget-collapsed="true"
								data-widget-sortable="false"
				
								-->
								<header role="heading">
								{if $ui_element->style->show_navigation_buttons}
									<div class="jarviswidget-ctrls" role="menu">  
										<a href="{$ui_element->current_url}/Close" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="Close" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a>
									</div>
								
									<span class="widget-icon"> 
									{if $ui_element->getActionType() == 'view'} 
										
											<a href="{$ui_element->current_url}/Edit/?id={$primary_key_field_value}"> <i class="fa fa-pencil" title="Edit"></i> </a> 
									{elseif $ui_element->getActionType() == 'edit'} 											
											<a href="{$ui_element->current_url}/View/?id={$primary_key_field_value}"><i class="fa fa-eye" title="View"></i> </a>
									
									{else}
										&nbsp
									{/if}
									</span>
								{/if}
								
				
								<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
				
								<!-- widget div-->
								<div role="content">
				
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
				
									</div>
									<!-- end widget edit box -->
				
									<!-- widget content -->
									<div class="widget-body no-padding">
				
										<form class="smart-form" method="post" name="{$ui_element->getName()}">
											<header>
												{$ui_element->getTitle()}
											</header>
				
				
				
										{if $action_type} 
											{if $debug_template}{$action_file}{/if}
											{include file=$action_file} 
										{else}

										action not set: {$action_type}
										{/if}
				
											
										{if $ui_element->getActionType() != 'view'} 
											<footer>
												<button type="submit" class="btn btn-primary">
													Submit
												</button>
												<!--button type="button" class="btn btn-default" onclick="window.history.back();">
													Back
												</button-->
											</footer>
										{/if}
										</form>
				
									</div>
									<!-- end widget content -->
				
								</div>
								<!-- end widget div -->
				
							</div>
							<!-- end widget -->
				
						</article>
						<!-- END COL -->
				
						<!-- NEW COL START -->
						
				
					</div>
		
		
		
		
		

		