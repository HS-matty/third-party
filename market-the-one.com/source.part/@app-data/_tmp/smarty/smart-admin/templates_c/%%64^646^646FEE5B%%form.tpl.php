<?php /* Smarty version 2.6.14, created on 2017-05-03 20:01:22
         compiled from D:%5Cdev%5Cweb-server-root%5Ccms/Front/market-the-one-com/Templates/smart-admin/%40ui/%40element/form.tpl */ ?>

<!-- SMART-ADMIN UI-ELEMENT-Form -->
<?php $this->assign('action_type', $this->_tpl_vars['ui_element']->getActionType()); ?>
<?php $this->assign('action_file', ($this->_tpl_vars['template_base_path'])."/@ui/@element/form/".($this->_tpl_vars['action_type']).".tpl"); ?>


<?php $this->assign('primary_key_field', $this->_tpl_vars['ui_element']->getPrimaryKeyField()); ?>
<?php if ($this->_tpl_vars['primary_key_field']): ?>
	<?php $this->assign('primary_key_field_value', $this->_tpl_vars['primary_key_field']->getValue()); ?>
<?php endif; ?>



	
<?php if ($this->_tpl_vars['ui_element']->getStatus() == 'success'): ?>
<div class="alert alert-block alert-success">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> Check validation!</h4>

</div>
<?php elseif ($this->_tpl_vars['ui_element']->getErrorFlag): ?>

<?php else: ?>
<div class="alert alert-block alert-success" style="visibility:hidden">
	<a class="close" data-dismiss="alert" href="#">×</a>
	<h4 class="alert-heading"><i class="fa fa-check-square-o"></i> Check validation!</h4>

</div>

<?php endif; ?>


		
		<!--table border=0 width="600px" >
						
				<tr><td><br />
				<?php if ($this->_tpl_vars['ui_element']->getStatus() == 'success'): ?>
				<span style="background:green;color:white;padding-left:0px"><b>Success!</b></span>
				<?php elseif ($this->_tpl_vars['ui_element']->getErrorFlag()): ?>
				
					<div style="color:red;padding-left:40px">
						<strong> .. validation not passed</strong>
						<?php $_from = $this->_tpl_vars['ui_element']->getErrorMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error_message']):
?>
						
						<ul>
							<li><?php echo $this->_tpl_vars['error_message']; ?>
</li>
						</ul>
						 
						
						<?php endforeach; endif; unset($_from); ?>
					</div>
				<?php else: ?>
				<span class="alert" style="visibility:hidden"> .. </span>
				<?php endif; ?>
			
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
								<?php if ($this->_tpl_vars['ui_element']->style->show_navigation_buttons): ?>
									<div class="jarviswidget-ctrls" role="menu">  
										<a href="<?php echo $this->_tpl_vars['ui_element']->current_url; ?>
/Close" class="button-icon jarviswidget-delete-btn" rel="tooltip" title="Close" data-placement="bottom" data-original-title="Close"><i class="fa fa-times"></i></a>
									</div>
								
									<span class="widget-icon"> 
									<?php if ($this->_tpl_vars['ui_element']->getActionType() == 'view'): ?> 
										
											<a href="<?php echo $this->_tpl_vars['ui_element']->current_url; ?>
/Edit/?id=<?php echo $this->_tpl_vars['primary_key_field_value']; ?>
"> <i class="fa fa-pencil" title="Edit"></i> </a> 
									<?php elseif ($this->_tpl_vars['ui_element']->getActionType() == 'edit'): ?> 											
											<a href="<?php echo $this->_tpl_vars['ui_element']->current_url; ?>
/View/?id=<?php echo $this->_tpl_vars['primary_key_field_value']; ?>
"><i class="fa fa-eye" title="View"></i> </a>
									
									<?php else: ?>
										&nbsp
									<?php endif; ?>
									</span>
								<?php endif; ?>
								
				
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
				
										<form class="smart-form" method="post" name="<?php echo $this->_tpl_vars['ui_element']->getName(); ?>
">
											<header>
												<?php echo $this->_tpl_vars['ui_element']->getTitle(); ?>

											</header>
				
				
				
										<?php if ($this->_tpl_vars['action_type']): ?> 
											<?php if ($this->_tpl_vars['debug_template']):  echo $this->_tpl_vars['action_file'];  endif; ?>
											<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['action_file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
										<?php else: ?>

										action not set: <?php echo $this->_tpl_vars['action_type']; ?>

										<?php endif; ?>
				
											
										<?php if ($this->_tpl_vars['ui_element']->getActionType() != 'view'): ?> 
											<footer>
												<button type="submit" class="btn btn-primary">
													Submit
												</button>
												<!--button type="button" class="btn btn-default" onclick="window.history.back();">
													Back
												</button-->
											</footer>
										<?php endif; ?>
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
		
		
		
		
		

		