<!DOCTYPE html>
<html lang="en">
  <head>
    <title>{$window->title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="web-sys v1.2">
    <meta name="author" content="Sergey-Volchek@matty (matt1@open.by)">


	{literal}<!--style>.dropdown-menu:after {left:17px}</style-->{/literal}
    <!-- Le styles -->
    <link href="{$host_name}/public/lib/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
	 <link href="{$host_name}/public/lib/bootstrap/assets/css/datepicker.css" rel="stylesheet">
    <style>
		{literal}
		
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
	  
	  .icon-whatever {
			background:url('..img/someicon.png') 0 0; 
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
		  
		  
		  {if $user->id}
		  
            <ul class="nav">
				
				<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img title="web-sys" src="{$host_name}/public/images/web-sys-logo-small-transparent.gif">&nbsp<b class="caret"></b></a>
				{assign var="current_menu_element" value=$window->menu->getCurrentElement()}
				
                <ul class="dropdown-menu">
				{foreach from=$window->menu->getElements() key=key item=menu_item}
					{assign var=current_menu_group value=$menu_item->group_id}
				{if $current_menu_group != $prev_menu_group}  <li class="divider"></li> {/if}
				   <li><a href="{$host_name}/{$menu_item->value}/">{$menu_item->title} </a></li>
				 
				  
				  {assign var=prev_menu_group value=$current_menu_group}
				  
				{/foreach}
                  
    
                </ul>
              </li>
			  
			  <li><a href="#" class="brand">&nbsp {$current_menu_element->title} : </a></li>
			
			{if $current_menu_element}
			{assign var="current_sub_menu_element" value=$current_menu_element->getCurrentElement()}
			
			{foreach from=$current_menu_element->getElements() item=sub_menu_item}
				
				{if $sub_menu_element_group_id != $sub_menu_item->group_id}
					<li class="divider-vertical"></li>
				{/if}
              <li {if $sub_menu_item->value == $current_sub_menu_element->value}class="dropdown active"{else} class="dropdown"{/if}><a href="{$host_name}/{$current_menu_element->getValue()}/{$sub_menu_item->value}/">{$sub_menu_item->title}</a>
			  
			   <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
				
			  </li>
				{assign var="sub_menu_element_group_id" value=$sub_menu_item->group_id}
			  
			 {/foreach}
              {/if}
              
            </ul>
          </div><!--/.nav-collapse -->
		  {/if}
	  
			
			<ul class="nav pull-right">
				{if !$user->id}
                     <li><a href="{$host_name}/auth/login">Login</a></li>
				 {else}
					<li class="divider-vertical"></li>
                     <li class="dropdown">
                       <a href="" class="dropdown-toggle" data-toggle="dropdown">{if $user->email}{$user->email}{else}{$user->login}{/if} <b class="caret"></b></a>
                       <ul class="dropdown-menu">
                         <li><a href="{$host_name}/auth/logout">Logout</a></li>
                       </ul>
                     </li>
				{/if}
                   </ul>
			
        </div>
		
      </div>
    </div>

	
    <div class="container-fluid" style="padding-left:50px	">
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
		
		{if $page->console->hasElements()}
			<ul>
			{foreach from=$page->console item=message}
				<li>{$message}</li>
			{/foreach}
			</ul>
		{/if}
		

		<div id="workspace" style="width:100%;height:100%;padding-left:30x;">
		
			
		
		{if  $sub_page}	{include file="$sub_page"}		
		{else} 
		{/if}
		</div>
	
    </div> <!-- /container -->
	
	
	
	
	{if $debug->getDebugLevel()}
<div class="container">
	<h3>Common log</h3>
	
		<ol>
		{foreach from=$debug->getMessageList() item=msg}
			<li>{$msg}</li>
		{/foreach}
		</ol>


	<h3>SQL log</h3>
	
		<ol>
		{foreach from=$debug->getMessageList('sql') item=msg_sql}
			<li>{$msg_sql}</li>
		{/foreach}
		</ol>
		<br />
		<br />
		<br />
		
</div>
	
{/if}

	
			




	<div class="navbar navbar-fixed-bottom" style="background-color:#ffffff">
		<div style="padding-bottom:5px;text-align:center;font-size:11px;font-weight:bold" id="footer">
			< <a href="http://web-sys.us"> web-sys</a> > <br />
			<!--img src="{$host_name}/public/images/web-sys-logo-2.gif" border="0" title="web-sys v1.2" -->
		</div>
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

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
	{literal} <script>$('#date_start').datepicker();</script> {/literal}	
	{literal} <script>$('#date_end').datepicker();</script> {/literal}	

	{literal}
		<script>

		{/literal}
			var hostname = "{$hostname}";
		{literal}
 
 
    $("#form-submit").click(function(e){
	
	  e.preventDefault();
			
            $.ajax({
            type: "POST",
			url:  hostname + "/sys-grid/update/",
			data: $('#form-ajax').serialize(),
            success: function(msg){
					console.log(msg);
                     //$("#thanks").html(msg)
                    //$("#form-content").modal('hide');    
                 },
			error: function(){
				console.log("failure");
				}
			});
	});



		function test(id,next_element_id){
		
			$("#category_id").empty();
			$.getJSON(hostname + '/sys-datasource?id=' + id, function(data) {
				 
				
				 $("#category_id").append('<option value="">All</option>');
				 
				  $.each(data, function(key, val) {
						$("#category_id").append('<option value="'+ val[0] + '" id="field' + key + '">' + val[1] + '</option>');
					
				  });
			
			
			});
				 
				
				
		}


		
	</script>



  


		
		
		
	{/literal}
	
  </body>
</html>
