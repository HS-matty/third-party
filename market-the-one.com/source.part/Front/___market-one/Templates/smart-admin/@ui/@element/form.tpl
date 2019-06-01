{assign value=$ui_element->getActionType() var=action_type }
{assign var=action_file value = "/@ui/@element/form/$action_type.tpl"}


{assign value=$ui_element->getPrimaryKeyField()  var=primary_key_field}
{if $primary_key_field}
	{assign value=$primary_key_field->getValue()  var=primary_key_field_value}
{/if}



	
	
{literal}
<style>

		.form_td_title {
			text-align:right;
			vertical-align:top;
			padding-right:10px;
			padding-top:5px;
			height:50px;
			
		}
		
		
		.form_td_value{
			vertical-align:top;
			padding-top:0;
		}
		
		
		.form_td_input{
			vertical-align:top;
			padding-top:0;
		}
		
		.form_td_input input{
			width: 300px;
		}
		
		
</style>
{/literal}

		

		
		<table border=0 width="600px" >
						
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
			<br />

		{if $ui_element->style->show_navigation_buttons}
		<div  style="width:600px;;vertical-align:;text-align:left;bottom;padding:0" >
		
			
			<table height="5" border=0 width="100%" style="padding:0;margin:0;vertical-align:bottom" >
				
				
			
				<tr  style="vertical-align:bottom" >
					<td style="vertical-align:bottom;padding:0;text-align:left" >
						{if $ui_element->getActionType() == 'add'} &nbsp {else}
						<a href="{$ui_element->current_url}/View/?id={$primary_key_field_value}" {if $ui_element->getActionType() == 'view'}style="text-decoration:underline;font-weight:bold"{/if} >view</a> 
						{if !$ui_element->getParam('is_not_editable')}| <a href="{$ui_element->current_url}/Edit/?id={$primary_key_field_value}" {if $ui_element->getActionType() == 'edit'}style="text-decoration:underline;font-weight:bold"{/if} >edit</a>{/if}
						{/if}
					</td>
					<td style="vertical-align:bottom;padding:0;text-align:right"> <a href="{$ui_element->current_url}/Close"><img src="{$host_name}/public/icons/close-(16-16).png"></a></td>
				</tr>
				
			</table>
		</div>
		{/if}
		
		
		
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
									<div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Delete"><i class="fa fa-times"></i></a></div>
									<span class="widget-icon"> <a href="#"><i class="fa fa-pencil"></i> </a> <a href="#"><i class="fa fa-eye"></i> </a></span>
									
				
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
				
										<form class="smart-form">
											<header>
												Standard Form Header
											</header>
				
											<fieldset>
												
									
												<section>
													<label class="label">Default text input with maxlength</label>
													<label class="input">
														<!--input type="text" maxlength="10"-->
														test
													</label>
													<div class="note">
														<strong>Maxlength</strong> is automatically added via the "maxlength='#'" attribute
													</div>
												</section>
																				
											
											
											</fieldset>
											
										
											<footer>
												<button type="submit" class="btn btn-primary">
													Submit
												</button>
												<button type="button" class="btn btn-default" onclick="window.history.back();">
													Back
												</button>
											</footer>
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
		
		
		
		
		
		<form class="form-horizontal"  id="ui-form" method="post" __style="padding-left:20px;__padding-top:40px;background:#EEF8FD;width:600px" enctype="multipart/form-data" class="test">
			<fieldset>
				<legend>{$ui_element->getTitle()}:</legend>
						
						{if $action_type} 
				{if $debug_template}{$action_file}{/if}
							{include file=$action_file} 
						{else}

							action not set: {$action_type}
						{/if}
				
				</fieldset>
		</form>
		
		