<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Market-The-One</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="{$host_name}/public/lib/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
	{literal}
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 70px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
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
                                   <link rel="shortcut icon" href="{$host_name}/public/lib/bootstrap/assets/ico/_favicon.png">
  </head>

  <body>

  
	
  
    <div class="container">

      <div class="masthead">
        <h3 class="muted"><a href="http://invoice.ebase.in"></a></h3>
		
      </div>

     <div class="hero-unit">
		<h2>Market-The-One.com!</h2>
			
			<br>
	<ul>
	 {if $user->type == 'user_backend'}
				<li><a href="{$host_name}/app/Dashboard">Dashboard</a></li>
	 {else}
			
				<li><a href="{$host_name}/login">Login</a></li>
				<li><a href="{$host_name}/register">Register</a></li>
		
		{/if}
		</ul>
	</div>

	
		
{if  $sub_page}	{include file="$sub_page"}			
		{else} 
			
		No Page
	{/if}
	

      <div class="footer">
        <p style="text-align:center">&copy; Market-The-One.com</p>
      </div>

    </div> <!-- /container -->

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

  </body>
</html>

	
	
