<?php /* Smarty version 2.6.14, created on 2017-04-27 20:49:57
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/simple/_index.tpl */ ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $this->_tpl_vars['window']->title; ?>
</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="web-sys v1.2">
    <meta name="author" content="Sergey-Volchek@matty (matt1@open.by)">


	 
	<?php echo ' 
	
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
			background:url(\'..img/someicon.png\') 0 0; 
		}

		#ui_form { padding:25px;color:green}	
		
		.caret1 {
			position: absolute !important; top: 0; right: 0;
		}

		.dropdown-toggle.disabled {
			padding-right: 40px;
		}
	  
    </style>
	
	'; ?>

  </head>

  
  
  
  <body align="center">
	
	<table id="navigation" style="width:70%;background:#409ecd" border="1" align="center"> 
	
	<?php if ($this->_tpl_vars['user']->getType() == 'user_backend'): ?>
		<?php $this->assign('current_menu_element', $this->_tpl_vars['window']->menu->getCurrentElement()); ?>	
		
		
		<tr style="height:40px">
			<?php if ($this->_tpl_vars['window']->menu->count() > 1): ?>
			
			<td align="left" border=1 width="150px"><img title="web-sys" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/images/web-sys-logo-small-transparent.gif" >
			<select id="menu-app-select" name="app" style="padding-bottom:0px" onChange="goUrl(this.value)" onfocus="" onkeypress="">
					<?php $_from = $this->_tpl_vars['window']->menu->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['menu_item']):
?>
						<?php $this->assign('current_menu_group', $this->_tpl_vars['menu_item']->group_id); ?>
						<?php if ($this->_tpl_vars['current_menu_group'] != $this->_tpl_vars['prev_menu_group']): ?>  <option></option> <?php endif; ?>
						
						
						<option value="<?php echo $this->_tpl_vars['host_name']; ?>
/app/<?php echo $this->_tpl_vars['menu_item']->value; ?>
" <?php if ($this->_tpl_vars['current_menu_element']->getName() == $this->_tpl_vars['menu_item']->getName()): ?> selected<?php endif; ?> ><?php echo $this->_tpl_vars['menu_item']->title; ?>
</option>
						
						 <?php $this->assign('prev_menu_group', $this->_tpl_vars['current_menu_group']); ?>
					
					<?php endforeach; endif; unset($_from); ?>
					
			</select>
			</td>
			<td align="left" style="color:white;padding-left:10px">
				<?php if ($this->_tpl_vars['current_menu_element']): ?>
					<?php $this->assign('current_sub_menu_element', $this->_tpl_vars['current_menu_element']->getCurrentElement()); ?>
					
							<?php $_from = $this->_tpl_vars['current_menu_element']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['sub_menu_item']):
?>
								<?php $this->assign('current_menu_group', $this->_tpl_vars['menu_item']->group_id); ?>
								<?php if ($this->_tpl_vars['current_menu_group'] != $this->_tpl_vars['prev_menu_group']): ?>  | <?php endif; ?>
									
									<?php if ($this->_tpl_vars['sub_menu_item']->hasElements()): ?>
									
									
										<span style="padding-right:10px"><select name="" onChange="goUrl(this.value)">
											<option value="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['sub_menu_item']->getAppPath(); ?>
"><b><?php echo $this->_tpl_vars['sub_menu_item']->getTitle(); ?>
</b></option>
											
											<?php $_from = $this->_tpl_vars['sub_menu_item']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['sub_menu_item_dropdown']):
?>
												<option value="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['sub_menu_item_dropdown']->getAppPath(); ?>
"> &nbsp <?php echo $this->_tpl_vars['sub_menu_item_dropdown']->getTitle(); ?>
</option>
											<?php endforeach; endif; unset($_from); ?>
										</select></span>
									
									<?php else: ?>
										<?php if ($this->_tpl_vars['sub_menu_item']->getAppPath()): ?>
											<a   style="padding-right:10px" href="<?php echo $this->_tpl_vars['host_name']; ?>
/<?php echo $this->_tpl_vars['sub_menu_item']->getAppPath(); ?>
/"> <?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
</a> 
										<?php else: ?>
											<a   style="padding-right:10px" href="<?php echo $this->_tpl_vars['host_name']; ?>
/app/<?php echo $this->_tpl_vars['current_menu_element']->getName(); ?>
/<?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
/"> <?php echo $this->_tpl_vars['sub_menu_item']->title; ?>
</a> 
										<?php endif; ?>
										
									<?php endif; ?>
										
							<?php endforeach; endif; unset($_from); ?>
					
					
				<?php endif; ?>
			</td>
			
			<td width="150px">
			
				<?php if (! $this->_tpl_vars['user']->getId()): ?>
                     <a href="<?php echo $this->_tpl_vars['host_name']; ?>
/login">Login</a>
				 <?php else: ?>
					<select onChange="goUrl(this.value)">
						    <!-- optgroup label="CITY 2"-->
						<option value="#"> <?php if ($this->_tpl_vars['user']->email):  echo $this->_tpl_vars['user']->email;  else:  echo $this->_tpl_vars['user']->login;  endif; ?></option>
						<option value="<?php echo $this->_tpl_vars['host_name']; ?>
/app/User/Profile/View"><a href=""><i class="icon-user"></i> &nbsp  Profile</option>
						<option value="<?php echo $this->_tpl_vars['host_name']; ?>
/app/User/Settings/View"><a href=""><i class="icon-cog"></i>&nbsp Settings</a></option>
                         <option value="<?php echo $this->_tpl_vars['host_name']; ?>
/logout">&nbsp Logout</option>
					</select>
				<?php endif; ?>
			
			</td>
			
			
			
			<?php endif; ?>
		</tr>
		
	<?php endif; ?>
		
	
	</table>
	
	<br />
	
	<table id="workspace" style="width:70%;background;height:600px" border="1" align="center">
	
		<tr>
			<td style="text-align:left;padding:20px" valign="top">
			
						<?php if ($this->_tpl_vars['sub_page_html']): ?>
							<?php echo $this->_tpl_vars['sub_page_html']; ?>

						<?php elseif ($this->_tpl_vars['sub_page']): ?>	
							<h3>Not Found</h3>
						<?php else: ?> 
					
					<?php endif; ?>
			</td>
		</tr>
	
	</table>
	
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
					<li class="active">
						<a href="#">Home</a>
					</li>
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