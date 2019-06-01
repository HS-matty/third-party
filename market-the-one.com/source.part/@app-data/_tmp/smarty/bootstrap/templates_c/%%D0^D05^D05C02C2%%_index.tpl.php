<?php /* Smarty version 2.6.14, created on 2017-05-16 15:14:33
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/bootstrap/_index.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $this->_tpl_vars['window']->title; ?>
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="web-sys v1.2">
    <meta name="author" content="Sergey-Volchek@matty (matt1@open.by)">


	<?php echo '<!--style>.dropdown-menu:after {left:17px}</style-->
	
	
	'; ?>

    <!-- Le styles -->
    <link href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
	 <link href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/datepicker.css" rel="stylesheet">
	 
	 
	 
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
	
    <style>
		<?php echo '
		
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
	  
	  .icon-whatever {
			background:url(\'..img/someicon.png\') 0 0; 
		}

		#ui_form { padding:25px;color:green}	
		
		.caret1 {
			position: absolute !important; top: 0; right: 0;
		}

		.dropdown-toggle.disabled {
			padding-right: 40px;
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
		  
		  
		  <?php if ($this->_tpl_vars['user']->getType() == 'user_backend'): ?>
		  
            <ul class="nav">
			
			<?php $this->assign('current_menu_element', $this->_tpl_vars['window']->menu->getCurrentElement()); ?>			
			
				<?php if ($this->_tpl_vars['window']->menu->count() > 1): ?>
				<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img title="web-sys" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/images/web-sys-logo-small-transparent.gif">&nbsp<b class="caret"></b></a>
			
				
                <ul class="dropdown-menu">
				<?php $_from = $this->_tpl_vars['window']->menu->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['menu_item']):
?>
					<?php $this->assign('current_menu_group', $this->_tpl_vars['menu_item']->group_id); ?>
				<?php if ($this->_tpl_vars['current_menu_group'] != $this->_tpl_vars['prev_menu_group']): ?>  <li class="divider"></li> <?php endif; ?>
					<li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/<?php echo $this->_tpl_vars['menu_item']->value; ?>
/"><?php echo $this->_tpl_vars['menu_item']->title; ?>
 </a></li>
				 
				  
				  <?php $this->assign('prev_menu_group', $this->_tpl_vars['current_menu_group']); ?>
				  
				<?php endforeach; endif; unset($_from); ?>
                  
    
                </ul>
              </li>
			  <?php endif; ?>
			  <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/<?php echo $this->_tpl_vars['current_menu_element']->getName(); ?>
" class="brand">&nbsp <?php echo $this->_tpl_vars['current_menu_element']->title; ?>
 : </a></li>
			
			<?php if ($this->_tpl_vars['current_menu_element']): ?>
			
			<?php $this->assign('current_sub_menu_element', $this->_tpl_vars['current_menu_element']->getCurrentElement()); ?>
			
			<?php $_from = $this->_tpl_vars['current_menu_element']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['sub_menu_item']):
?>
					
				<?php if ($this->_tpl_vars['sub_menu_element_group_id'] != $this->_tpl_vars['sub_menu_item']->group_id): ?>
					<li class="divider-vertical"></li>
				<?php endif; ?>
				
				<?php if ($this->_tpl_vars['sub_menu_item']->getName() == 'Stats'):  endif; ?>
				
				
				
              <li <?php if (! $this->_tpl_vars['current_menu_element']->sub_menu_not_active && $this->_tpl_vars['sub_menu_item']->name == $this->_tpl_vars['current_sub_menu_element']->name): ?>class="dropdown active"<?php else: ?> class="dropdown"<?php endif; ?> 
			  <?php if ($this->_tpl_vars['sub_menu_item']->hasElements()): ?> class="dropdown"<?php endif; ?>>
				
				<?php if ($this->_tpl_vars['sub_menu_item']->getMenuPath()): ?>
					<a   href="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['sub_menu_item']->getMenuPath(); ?>
/"> <?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
</a> 
				<?php elseif ($this->_tpl_vars['sub_menu_item']->getAppPath()): ?>
					<a   href="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['sub_menu_item']->getAppPath(); ?>
/"> <?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
</a> 
				<?php else: ?>
				<a   href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/<?php echo $this->_tpl_vars['current_menu_element']->getName(); ?>
/<?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
/"> <?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
</a> 
				<?php endif; ?>
				
				
				
				
				<?php if ($this->_tpl_vars['sub_menu_item']->hasElements()): ?>
			 
			
			   <ul class="dropdown-menu">
					<?php $_from = $this->_tpl_vars['sub_menu_item']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['sub_menu_item_dropdown']):
?>
                  <li><a href="#"><?php echo $this->_tpl_vars['sub_menu_item_dropdown']->getTitle(); ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
                  <!--li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">Separated link</a></li-->
                  
                </ul>
			<?php endif; ?>
			  </li>
				<?php $this->assign('sub_menu_element_group_id', $this->_tpl_vars['sub_menu_item']->group_id); ?>
			 
			 <?php endforeach; endif; unset($_from); ?>
              <?php endif; ?>
              
            </ul>
          </div><!--/.nav-collapse -->
		  
		  <?php endif; ?>
	  
			
			<ul class="nav pull-right">
				<?php if (! $this->_tpl_vars['user']->getId() == 'user_frontend'): ?>
                     <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/login">Login</a></li>
				 <?php else: ?>
					 <li> <a href="#">Balance: <?php if ($this->_tpl_vars['user']->balance == 0): ?>0.1<?php else:  echo $this->_tpl_vars['user']->balance;  endif; ?>$</a></li>
					<li class="divider-vertical"></li>
                     <li class="dropdown">
                       <a href="" class="dropdown-toggle" data-toggle="dropdown"><?php if ($this->_tpl_vars['user']->email):  echo $this->_tpl_vars['user']->email;  else:  echo $this->_tpl_vars['user']->login;  endif; ?> <b class="caret"></b></a>
                       <ul class="dropdown-menu">
					       <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/User/Profile/View"><i class="icon-user"></i> Profile</a></li>
						   <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/User/Settings/View"><i class="icon-cog"></i>Settings</a></li>
                         <li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/logout"><i class="icon-share-alt"></i> Logout</a></li>
                       </ul>
                     </li>
				<?php endif; ?>
             </ul>
		
		
        </div>
		
      </div>
	
    </div>


	
    <div class="container-fluid" style="padding-left:100px;padding-right:50px">

		
		<div class="container" style="background:#fcfcfc;min-height:600px;padding-left:50px;padding-right:20px">
		
	
	

		
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
		
		<?php if ($this->_tpl_vars['page']->console->hasElements() && false): ?>

			<ul>
			<?php $_from = $this->_tpl_vars['page']->console; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?>
				<li><?php echo $this->_tpl_vars['message']; ?>
</li>
			<?php endforeach; endif; unset($_from); ?>
			</ul>
		<?php endif; ?>
	

	  <?php if ($this->_tpl_vars['user']->getType() == 'user_backend'): ?>
		<div id="workspace" style="width:100%;height:100%;">
			
			<div id="">
				<ul class="nav nav-tabs">
				<?php if ($this->_tpl_vars['temp_turned_off'] && $this->_tpl_vars['window']->Tab->hasElements()): ?>
					<?php $_from = $this->_tpl_vars['window']->Tab->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['tab_element']):
?>
					
						
					
						<li <?php if ($this->_tpl_vars['tab_element']->getName() == $this->_tpl_vars['current_sub_menu_element']->getName()): ?> class="active" <?php endif; ?>>
							<a href="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['tab_element']->getAppPath(); ?>
"><?php echo $this->_tpl_vars['tab_element']->getName(); ?>
 :  <?php echo $this->_tpl_vars['current_sub_menu_element']->getName(); ?>
</a>
						</li>
						<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
				
					
					
					
					<!--li><a href="#">Test</a></li>
					<li><a href="#">test2</a></li-->
				</ul>
			</div>
		<?php endif; ?>

					<?php if ($this->_tpl_vars['sub_page_html']): ?>
						<?php echo $this->_tpl_vars['sub_page_html']; ?>

					<?php elseif ($this->_tpl_vars['sub_page']): ?>	
						
					<?php else: ?> 
					
					<?php endif; ?>
							
			
		</div>
	<?php if ($this->_tpl_vars['log']->getDebugLevel()): ?>
		<div style="width:100px;height:200px">
			
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "/@sys/debug.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
			
		</div>
	<?php endif; ?>
    </div> <!-- /container -->
	
	

	<?php if ($this->_tpl_vars['_show_dev_form']): ?>
	<div class="_container" style="font-size:12px;0px;padding-left:40px;padding-top:10px;padding-bottom:10px;;background-color:#E7E9E7">
		<h4>Dev:</h4>
		<form method="post" name="dev" action="<?php echo $this->_tpl_vars['hostname']; ?>
/app/Dev/create_ui_db">
		<table>
			<tr><td>Entity name: &nbsp <input type="input" name="entity_name" value="<?php echo $this->_tpl_vars['dev']->entity_name; ?>
"></td></tr>
				<tr><td>Create table : &nbsp <input type="checkbox" name="is_create_table" checked ></td></tr>
				<tr><td>Create grid : &nbsp <input type="checkbox" name="is_create_grid" checked ></td></tr>
				<tr><td>Create forms : &nbsp <input type="checkbox" name="is_forms" checked ></td></tr>
			</tr>
		</table>
		
		<input type="hidden" name="post" value="1">
		<input type="hidden" name="back_url" value="<?php echo $this->_tpl_vars['request_uri']; ?>
">
		<input type="submit" value="submit">
		</form>
	</div>
	<?php endif; ?>



	
			




	<div class="navbar navbar-fixed-bottom" style="background-color:#ffffff">
		<div style="padding-bottom:5px;text-align:center;font-size:11px;font-weight:bold" id="footer">
			< <a href="http://web-sys.radmaster.net"> web-sys</a> > <br />
			<!--img src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/images/web-sys-logo-2.gif" border="0" title="web-sys v1.2" -->
		</div>
	</div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	



	


  </body>
</html>