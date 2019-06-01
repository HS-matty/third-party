<?php /* Smarty version 2.6.14, created on 2017-05-16 15:14:33
         compiled from /%40ui/%40element/form.tpl */ ?>
<!-- BOOTSTRAP UI-ELEMENT-Form -->

<?php $this->assign('action_type', $this->_tpl_vars['ui_element']->getActionType()); ?>
<?php $this->assign('action_file', "/@ui/@element/form/".($this->_tpl_vars['action_type']).".tpl"); ?>


<?php $this->assign('primary_key_field', $this->_tpl_vars['ui_element']->getPrimaryKeyField()); ?>
<?php if ($this->_tpl_vars['primary_key_field']): ?>
	<?php $this->assign('primary_key_field_value', $this->_tpl_vars['primary_key_field']->getValue()); ?>
<?php endif; ?>



	
	
<?php echo '
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
'; ?>


		

		
		<table border=0 width="600px" >
						
				<tr><td><br />
				<?php if ($this->_tpl_vars['ui_element']->getStatus() == 'success'): ?>
				<span style="background:green;color:white;padding-left:0px"><b>Success!</b></span>
				<?php elseif ($this->_tpl_vars['ui_element']->getErrorFlag()): ?>
				
					<div style="color:red;padding-left:40px">
						<strong></strong>
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
			<br />

		<?php if ($this->_tpl_vars['ui_element']->style->show_navigation_buttons): ?>
		<div  style="width:600px;;vertical-align:;text-align:left;bottom;padding:0" >
		
			
			<table height="5" border=0 width="100%" style="padding:0;margin:0;vertical-align:bottom" >
				
				
			
				<tr  style="vertical-align:bottom" >
					<td style="vertical-align:bottom;padding:0;text-align:left" >
						<?php if ($this->_tpl_vars['ui_element']->getActionType() == 'add'): ?> &nbsp <?php else: ?>
						<a href="<?php echo $this->_tpl_vars['ui_element']->current_url; ?>
/View/?id=<?php echo $this->_tpl_vars['primary_key_field_value']; ?>
" <?php if ($this->_tpl_vars['ui_element']->getActionType() == 'view'): ?>style="text-decoration:underline;font-weight:bold"<?php endif; ?> >view</a> 
						<?php if (! $this->_tpl_vars['ui_element']->getParam('is_not_editable')): ?>| <a href="<?php echo $this->_tpl_vars['ui_element']->current_url; ?>
/Edit/?id=<?php echo $this->_tpl_vars['primary_key_field_value']; ?>
" <?php if ($this->_tpl_vars['ui_element']->getActionType() == 'edit'): ?>style="text-decoration:underline;font-weight:bold"<?php endif; ?> >edit</a><?php endif; ?>
						<?php endif; ?>
					</td>
					<td style="vertical-align:bottom;padding:0;text-align:right"> <a href="<?php echo $this->_tpl_vars['ui_element']->current_url; ?>
/Close"><img src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/icons/close-(16-16).png"></a></td>
				</tr>
				
			</table>
		</div>
		<?php endif; ?>
		<form class="form-horizontal"  id="ui-form" method="post" style="padding-left:20px;__padding-top:40px;background:#EEF8FD;width:600px" enctype="multipart/form-data" class="test">
			<fieldset>
				<legend><?php echo $this->_tpl_vars['ui_element']->getTitle(); ?>
:</legend>
						
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
				
				</fieldset>
		</form>
		

	