<?php /* Smarty version 2.6.14, created on 2014-05-08 13:54:10
         compiled from D:%5Cdev%5Cweb-server-root%5Cdev-studio/front/tpl/_index.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $this->_tpl_vars['window']->title; ?>
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="web-sys v1.2">
    <meta name="author" content="Sergey-Volchek@matty (matt1@open.by)">


	<?php echo '<!--style>.dropdown-menu:after {left:17px}</style-->'; ?>

    <!-- Le styles -->
    <link href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
	 <link href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/datepicker.css" rel="stylesheet">
    <style>
		<?php echo '
		
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
	  
	  .icon-whatever {
			background:url(\'..img/someicon.png\') 0 0; 
		}

		
		
		
		
	  '; ?>

    </style>
    <link href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <!-- link rel="shortcut icon" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/ico/favicon.png" -->
  </head>

  
  
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
		
    
          <div class="nav-collapse collapse" style="padding-left:2	0px">
		  
		  
		  <?php if ($this->_tpl_vars['user']->id): ?>
		  
            <ul class="nav">
				
				<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img title="web-sys" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/images/web-sys-logo-small-transparent.gif">&nbsp<b class="caret"></b></a>
				<?php $this->assign('current_menu_element', $this->_tpl_vars['window']->menu->getCurrentElement()); ?>
				
                <ul class="dropdown-menu">
				<?php $_from = $this->_tpl_vars['window']->menu->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['menu_item']):
?>
					<?php $this->assign('current_menu_group', $this->_tpl_vars['menu_item']->group_id); ?>
				<?php if ($this->_tpl_vars['current_menu_group'] != $this->_tpl_vars['prev_menu_group']): ?>  <li class="divider"></li> <?php endif; ?>
				   <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['menu_item']->value; ?>
/"><?php echo $this->_tpl_vars['menu_item']->title; ?>
 </a></li>
				 
				  
				  <?php $this->assign('prev_menu_group', $this->_tpl_vars['current_menu_group']); ?>
				  
				<?php endforeach; endif; unset($_from); ?>
                  
    
                </ul>
              </li>
			  
			  <li><a href="#" class="brand">&nbsp <?php echo $this->_tpl_vars['current_menu_element']->title; ?>
 : </a></li>
			
			<?php if ($this->_tpl_vars['current_menu_element']): ?>
			<?php $this->assign('current_sub_menu_element', $this->_tpl_vars['current_menu_element']->getCurrentElement()); ?>
			
			<?php $_from = $this->_tpl_vars['current_menu_element']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['sub_menu_item']):
?>
				
				<?php if ($this->_tpl_vars['sub_menu_element_group_id'] != $this->_tpl_vars['sub_menu_item']->group_id): ?>
					<li class="divider-vertical"></li>
				<?php endif; ?>
              <li <?php if ($this->_tpl_vars['sub_menu_item']->value == $this->_tpl_vars['current_sub_menu_element']->value): ?>class="dropdown active"<?php else: ?> class="dropdown"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['current_menu_element']->getValue(); ?>
-<?php echo $this->_tpl_vars['sub_menu_item']->value; ?>
/"><?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
</a>
			  
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
				<?php $this->assign('sub_menu_element_group_id', $this->_tpl_vars['sub_menu_item']->group_id); ?>
			  
			 <?php endforeach; endif; unset($_from); ?>
              <?php endif; ?>
              
            </ul>
          </div><!--/.nav-collapse -->
		  <?php endif; ?>
	  
			
			<ul class="nav pull-right">
				<?php if (! $this->_tpl_vars['user']->id): ?>
                     <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/auth/login">Login</a></li>
				 <?php else: ?>
					<li class="divider-vertical"></li>
                     <li class="dropdown">
                       <a href="" class="dropdown-toggle" data-toggle="dropdown"><?php if ($this->_tpl_vars['user']->email):  echo $this->_tpl_vars['user']->email;  else:  echo $this->_tpl_vars['user']->login;  endif; ?> <b class="caret"></b></a>
                       <ul class="dropdown-menu">
                         <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/auth/logout">Logout</a></li>
                       </ul>
                     </li>
				<?php endif; ?>
                   </ul>
			
        </div>
		
      </div>
    </div>

	
    <div class="container-fluid" style="padding-left:50px	">
		<div style="height:40px">
			<?php if ($this->_tpl_vars['success_flag'] === 1): ?>
			<div class="alert alert-success">
				Success!
			</div>
			<?php endif; ?>
			
			<?php if ($this->_tpl_vars['error_message']): ?>
			<div class="alert alert-error">
				<?php echo $this->_tpl_vars['error_message']; ?>

			</div>
			<?php endif; ?>
			
		</div>
		
		<?php if ($this->_tpl_vars['page']->console->hasElements()): ?>
			<ul>
			<?php $_from = $this->_tpl_vars['page']->console; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?>
				<li><?php echo $this->_tpl_vars['message']; ?>
</li>
			<?php endforeach; endif; unset($_from); ?>
			</ul>
		<?php endif; ?>
		
		<div id="workspace" style="width:100%;height:100%;padding:30px;">
		
			
		
		<?php if ($this->_tpl_vars['sub_page']): ?>	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['sub_page']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>		
		<?php else: ?> 
		<?php endif; ?>
		</div>

	
    </div> <!-- /container -->
	
	
	<?php if ($this->_tpl_vars['debug']->getDebugLevel()): ?>
<div class="container">
	<h3>Common log</h3>
	
		<ol>
		<?php $_from = $this->_tpl_vars['debug']->getMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['msg']):
?>
			<li><?php echo $this->_tpl_vars['msg']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
		</ol>


	<h3>SQL log</h3>
	
		<ol>
		<?php $_from = $this->_tpl_vars['debug']->getMessageList('sql'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['msg_sql']):
?>
			<li><?php echo $this->_tpl_vars['msg_sql']; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
		</ol>
		<br />
		<br />
		<br />
		
</div>
	
<?php endif; ?>

	
			




	<div class="navbar navbar-fixed-bottom" style="background-color:#ffffff">
		<div style="padding-bottom:5px;text-align:center;font-size:11px;font-weight:bold" id="footer">
			<a href="http://web-sys.us"> web-sys</a> <br />
			<!-- img src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/images/web-sys-logo.gif" border="0" title="web-sys v1.2" -->
		</div>
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

		<script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/jquery.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-transition.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-alert.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-modal.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-tab.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-popover.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-button.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-collapse.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-carousel.js"></script>
    <script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-typeahead.js"></script>
	<script src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap-datepicker.js"></script>
	<?php echo ' <script>$(\'#date_start\').datepicker();</script> '; ?>
	
	<?php echo ' <script>$(\'#date_end\').datepicker();</script> '; ?>
	

	<?php echo '
		<script>

		'; ?>

			var hostname = "<?php echo $this->_tpl_vars['hostname']; ?>
";
		<?php echo '
 
 
    $("#form-submit").click(function(e){
	
	  e.preventDefault();
			
            $.ajax({
            type: "POST",
			url:  hostname + "/sys-grid/update/",
			data: $(\'#form-ajax\').serialize(),
            success: function(msg){
					console.log(msg);
                     //$("#thanks").html(msg)
                    //$("#form-content").modal(\'hide\');    
                 },
			error: function(){
				console.log("failure");
				}
			});
	});



		function test(id,next_element_id){
		
			$("#category_id").empty();
			$.getJSON(hostname + \'/sys-datasource?id=\' + id, function(data) {
				 
				
				 $("#category_id").append(\'<option value="">All</option>\');
				 
				  $.each(data, function(key, val) {
						$("#category_id").append(\'<option value="\'+ val[0] + \'" id="field\' + key + \'">\' + val[1] + \'</option>\');
					
				  });
			
			
			});
				 
				
				
		}


		
	</script>



  


		
		
		
	'; ?>

	
  </body>
</html>