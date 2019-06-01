<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{$window->title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="web-sys v1.2">
    <meta name="author" content="Sergey-Volchek@matty (matt1@open.by)">


	{literal}<!--style>.dropdown-menu:after {left:17px}</style-->
	
	
	{/literal}
    <!-- Le styles -->
    <link href="{$host_name}/public/lib/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
	 <link href="{$host_name}/public/lib/bootstrap/assets/css/datepicker.css" rel="stylesheet">
	 
	 
	 
		<script src="{$host_name}/public/lib/bootstrap/assets/js/jquery.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-transition.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-alert.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-modal.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-dropdown.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-scrollspy.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-tab.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-tooltip.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-popover.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-button.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-collapse.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-carousel.js"></script>
    <script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-typeahead.js"></script>
	<script src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap-datepicker.js"></script>
	
    <style>
		{literal}
		
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
	  {/literal}
    </style>
    <link href="{$host_name}/public/lib/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{$host_name}/public/lib/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{$host_name}/public/lib/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{$host_name}/public/lib/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="{$host_name}/public/lib/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <!-- link rel="shortcut icon" href="{$host_name}/public/lib/bootstrap/assets/ico/favicon.png" -->
  </head>

  
  
  <body>
	
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
		
    
          <div class="nav-collapse collapse" style="padding-left:2	0px">
		  
		  
		  {if $user->getType() == 'user_backend'}
		  
            <ul class="nav">
			
			{assign var="current_menu_element" value=$window->menu->getCurrentElement()}			
			
				{if $window->menu->count() > 1}
				<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img title="web-sys" src="{$host_name}/public/images/web-sys-logo-small-transparent.gif">&nbsp<b class="caret"></b></a>
			
				
                <ul class="dropdown-menu">
				{foreach from=$window->menu->getElements() key=key item=menu_item}
					{assign var=current_menu_group value=$menu_item->group_id}
				{if $current_menu_group != $prev_menu_group}  <li class="divider"></li> {/if}
				   <li><a href="{$host_name}/app/{$menu_item->value}/">{$menu_item->title} </a></li>
				 
				  
				  {assign var=prev_menu_group value=$current_menu_group}
				  
				{/foreach}
                  
    
                </ul>
              </li>
			  {/if}
			  <li><a href="{$host_name}/app/{$current_menu_element->getName()}" class="brand">&nbsp {$current_menu_element->title} : </a></li>
			
			{if $current_menu_element}
			
			{assign var="current_sub_menu_element" value=$current_menu_element->getCurrentElement()}
			
			{foreach from=$current_menu_element->getElements() item=sub_menu_item}
					
				{if $sub_menu_element_group_id != $sub_menu_item->group_id}
					<li class="divider-vertical"></li>
				{/if}
				
				{if $sub_menu_item->getName() == 'Stats'}{/if}
				
				
				
              <li {if !$current_menu_element->sub_menu_not_active && $sub_menu_item->name == $current_sub_menu_element->name }class="dropdown active"{else} class="dropdown"{/if} 
			  {if $sub_menu_item->hasElements()} class="dropdown"{/if}>
				
				{if $sub_menu_item->getAppPath()}
					<a   href="{$host_name}/{$sub_menu_item->getAppPath()}/"> {$sub_menu_item->title}</a> 
				{else}
				<a   href="{$host_name}/app/{$current_menu_element->getName()}/{$sub_menu_item->title}/"> {$sub_menu_item->title}</a> 
				{/if}
				
				
				
				
				{if $sub_menu_item->hasElements()}
			 
			
			   <ul class="dropdown-menu">
					{foreach from=$sub_menu_item->getElements() item=sub_menu_item_dropdown }
                  <li><a href="#">{$sub_menu_item_dropdown->getTitle()}</a></li>
					{/foreach}
                  <!--li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li-->
                  
                </ul>
			{/if}
			  </li>
				{assign var="sub_menu_element_group_id" value=$sub_menu_item->group_id}
			 
			 {/foreach}
              {/if}
              
            </ul>
          </div><!--/.nav-collapse -->
		  {/if}
	  
			
			<ul class="nav pull-right">
				{if !$user->getId()}
                     <li><a href="{$host_name}/login">Login</a></li>
				 {else}
					<li class="divider-vertical"></li>
                     <li class="dropdown">
                       <a href="" class="dropdown-toggle" data-toggle="dropdown">{if $user->email}{$user->email}{else}{$user->login}{/if} <b class="caret"></b></a>
                       <ul class="dropdown-menu">
					       <li><a href="{$host_name}/app/User/Profile/View"><i class="icon-user"></i> Profile</a></li>
                         <li><a href="{$host_name}/logout"><i class="icon-share-alt"></i> Logout</a></li>
                       </ul>
                     </li>
				{/if}
             </ul>
			
        </div>
		
      </div>
    </div>

		
	
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
