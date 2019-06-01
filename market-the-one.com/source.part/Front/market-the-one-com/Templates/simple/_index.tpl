<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{$window->title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="web-sys v1.2">
    <meta name="author" content="Sergey-Volchek@matty (matt1@open.by)">


	 
	{literal} 
	
	<script>
		function goUrl(url){
			window.location.href = url;
		}
	</script>

	
    <style>
	
		
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
	  
	  .icon-whatever {
			background:url('..img/someicon.png') 0 0; 
		}

		#ui_form { padding:25px;color:green}	
		
		.caret1 {
			position: absolute !important; top: 0; right: 0;
		}

		.dropdown-toggle.disabled {
			padding-right: 40px;
		}
	  
    </style>
	
	{/literal}
  </head>

  
  
  
  <body align="center">
	
	<table id="navigation" style="width:70%;background:#409ecd" border="1" align="center"> 
	
	{if $user->getType() == 'user_backend'}
		{assign var="current_menu_element" value=$window->menu->getCurrentElement()}	
		
		
		<tr style="height:40px">
			{if $window->menu->count() > 1}
			
			<td align="left" border=1 width="150px"><img title="web-sys" src="{$host_name}/public/images/web-sys-logo-small-transparent.gif" >
			<select id="menu-app-select" name="app" style="padding-bottom:0px" onChange="goUrl(this.value)" onfocus="" onkeypress="">
					{foreach from=$window->menu->getElements() key=key item=menu_item}
						{assign var=current_menu_group value=$menu_item->group_id}
						{if $current_menu_group != $prev_menu_group}  <option></option> {/if}
						
						
						<option value="{$host_name}/app/{$menu_item->value}" {if $current_menu_element->getName() == $menu_item->getName()} selected{/if} >{$menu_item->title}</option>
						
						 {assign var=prev_menu_group value=$current_menu_group}
					
					{/foreach}
					
			</select>
			</td>
			<td align="left" style="color:white;padding-left:10px">
				{if $current_menu_element}
					{assign var="current_sub_menu_element" value=$current_menu_element->getCurrentElement()}
					
							{foreach from=$current_menu_element->getElements() item=sub_menu_item}
								{assign var=current_menu_group value=$menu_item->group_id}
								{if $current_menu_group != $prev_menu_group}  | {/if}
									
									{if $sub_menu_item->hasElements()}
									
									
										<span style="padding-right:10px"><select name="" onChange="goUrl(this.value)">
											<option value="{$host_name}/{$sub_menu_item->getAppPath()}"><b>{$sub_menu_item->getTitle()}</b></option>
											
											{foreach from=$sub_menu_item->getElements() item=sub_menu_item_dropdown }
												<option value="{$host_name}/{$sub_menu_item_dropdown->getAppPath() }"> &nbsp {$sub_menu_item_dropdown->getTitle()}</option>
											{/foreach}
										</select></span>
									
									{else}
										{if $sub_menu_item->getAppPath()}
											<a   style="padding-right:10px" href="{$host_name}/{$sub_menu_item->getAppPath()}/"> {$sub_menu_item->title}</a> 
										{else}
											<a   style="padding-right:10px" href="{$host_name}/app/{$current_menu_element->getName()}/{$sub_menu_item->title}/"> {$sub_menu_item->title}</a> 
										{/if}
										
									{/if}
										
							{/foreach}
					
					
				{/if}
			</td>
			
			<td width="150px">
			
				{if !$user->getId()}
                     <a href="{$host_name}/login">Login</a>
				 {else}
					<select onChange="goUrl(this.value)">
						    <!-- optgroup label="CITY 2"-->
						<option value="#"> {if $user->email}{$user->email}{else}{$user->login}{/if}</option>
						<option value="{$host_name}/app/User/Profile/View"><a href=""><i class="icon-user"></i> &nbsp  Profile</option>
						<option value="{$host_name}/app/User/Settings/View"><a href=""><i class="icon-cog"></i>&nbsp Settings</a></option>
                         <option value="{$host_name}/logout">&nbsp Logout</option>
					</select>
				{/if}
			
			</td>
			
			
			
			{/if}
		</tr>
		
	{/if}
		
	
	</table>
	
	<br />
	
	<table id="workspace" style="width:70%;background;height:600px" border="1" align="center">
	
		<tr>
			<td style="text-align:left;padding:20px" valign="top">
			
						{if $sub_page_html}
							{$sub_page_html}
						{elseif  $sub_page}	
							<h3>Not Found</h3>
						{else} 
					
					{/if}
			</td>
		</tr>
	
	</table>
	
    <div class="container-fluid" style="padding-left:100px;padding-right:50px">
			
		<div class="container" style="background:#fcfcfc;min-height:600px;padding-left:50px;padding-right:20px">
		
			<div style="height:40px">
				{if $success_flag === 1}
				<div class="alert alert-success">
					Success!
				</div>
				{/if}
				
				{if $error_message}
				<div class="alert alert-error">
					{$error_message}
				</div>
				{/if}
			
			</div>
		
		{if $page->console->hasElements() && false}

			<ul>
			{foreach from=$page->console item=message}
				<li>{$message}</li>
			{/foreach}
			</ul>
		{/if}
	

	  {if $user->getType() == 'user_backend'}
		<div id="workspace" style="width:100%;height:100%;">
			
			<div id="">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#">Home</a>
					</li>
					<!--li><a href="#">Test</a></li>
					<li><a href="#">test2</a></li-->
				</ul>
			</div>
		{/if}

					{if $sub_page_html}
						{$sub_page_html}
					{elseif  $sub_page}	
						
					{else} 
					
					{/if}
							
			
		</div>
	{if $log->getDebugLevel()}
		<div style="width:100px;height:200px">
			
			{include file="/@sys/debug.tpl"}	
			
		</div>
	{/if}
    </div> <!-- /container -->
	
	

	{if $_show_dev_form}
	<div class="_container" style="font-size:12px;0px;padding-left:40px;padding-top:10px;padding-bottom:10px;;background-color:#E7E9E7">
		<h4>Dev:</h4>
		<form method="post" name="dev" action="{$hostname}/app/Dev/create_ui_db">
		<table>
			<tr><td>Entity name: &nbsp <input type="input" name="entity_name" value="{$dev->entity_name}"></td></tr>
				<tr><td>Create table : &nbsp <input type="checkbox" name="is_create_table" checked ></td></tr>
				<tr><td>Create grid : &nbsp <input type="checkbox" name="is_create_grid" checked ></td></tr>
				<tr><td>Create forms : &nbsp <input type="checkbox" name="is_forms" checked ></td></tr>
			</tr>
		</table>
		
		<input type="hidden" name="post" value="1">
		<input type="hidden" name="back_url" value="{$request_uri}">
		<input type="submit" value="submit">
		</form>
	</div>
	{/if}



	
			




	<div class="navbar navbar-fixed-bottom" style="background-color:#ffffff">
		<div style="padding-bottom:5px;text-align:center;font-size:11px;font-weight:bold" id="footer">
			< <a href="http://web-sys.radmaster.net"> web-sys</a> > <br />
			<!--img src="{$host_name}/public/images/web-sys-logo-2.gif" border="0" title="web-sys v1.2" -->
		</div>
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	



	


  </body>
</html>
