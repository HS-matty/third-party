<?php /* Smarty version 2.6.14, created on 2014-05-10 12:00:44
         compiled from /%40ui/%40element/form.tpl */ ?>
<form class="form-horizontal"  method="post" style="padding-top:40px" enctype="multipart/form-data">

		
		<h3><?php echo $this->_tpl_vars['ui_element']->getTitle(); ?>
</h3>
	
		<?php $_from = $this->_tpl_vars['ui_element']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>

		
			<?php if ($this->_tpl_vars['field']->type == 'input'): ?>
			
			  <div class="control-group <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?> error <?php endif; ?>">
				<label class="control-label" for="inputEmail"><?php echo $this->_tpl_vars['field']->getTitle(); ?>
 <?php if ($this->_tpl_vars['field']->getParam('is_required')): ?><font color="red">*</font><?php endif; ?></label>
				<div class="controls">
							
				  <input name ="<?php echo $this->_tpl_vars['field']->getName(); ?>
" <?php if ($this->_tpl_vars['field']->view->type == 'password'): ?> type="password" <?php else: ?> type="text" <?php endif; ?> value="<?php echo $this->_tpl_vars['field']->getValue(); ?>
" id="<?php echo $this->_tpl_vars['field']->getName(); ?>
" placeholder="">
		
				  <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?>
							<?php $_from = $this->_tpl_vars['field']->getErrorMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?>
								<span class="help-inline"><?php echo $this->_tpl_vars['message']; ?>
</span>
						<?php endforeach; endif; unset($_from); ?>
				  <?php endif; ?>
				</div>
			</div>		  
				
				
			<?php elseif ($this->_tpl_vars['field']->type == 'select'): ?>
			
				<?php $this->assign('tpl_file', $this->_tpl_vars['tpl']->preparePath("/@ui/@element/form/@el/select.tpl")); ?>
				
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tpl_file'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php elseif ($this->_tpl_vars['field']->type == 'file'): ?>
		
					<div class="control-group <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?> error <?php endif; ?>">
					<label class="control-label" for="inputEmail"><?php echo $this->_tpl_vars['field']->getTitle(); ?>
 <?php if ($this->_tpl_vars['field']->getParam('is_required')): ?><font color="red">*</font><?php endif; ?></label>
						<div class="controls">
							<span class="btn btn-file">
					
								<input type="file" name="<?php echo $this->_tpl_vars['field']->name; ?>
" id="image" />
							</span>
							<?php if ($this->_tpl_vars['field']->getErrorFlag()): ?> 
											<?php $_from = $this->_tpl_vars['field']->getErrorMessageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['message']):
?>
												<span class="help-inline"><?php echo $this->_tpl_vars['message']; ?>
</span>
												
										<?php endforeach; endif; unset($_from); ?>
								  <?php endif; ?>
				
						</div>
					</div>
					
	
		
		
		<?php endif; ?>
		
		<?php endforeach; endif; unset($_from); ?>
		 <div class="control-group">
			<div class="controls">
				<button type="submit" class="btn">Отправить</button>
			</div>
		  </div>
		   
		  </div>
		  <input type="hidden" name="post" value="1">
		</form>