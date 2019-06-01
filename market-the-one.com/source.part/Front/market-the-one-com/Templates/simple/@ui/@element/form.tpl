<!-- BOOTSTRAP UI-ELEMENT-Form -->

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
		<form class="form-horizontal"  id="ui-form" method="post" style="padding-left:20px;__padding-top:40px;background:#EEF8FD;width:600px" enctype="multipart/form-data" class="test">
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
		

	
