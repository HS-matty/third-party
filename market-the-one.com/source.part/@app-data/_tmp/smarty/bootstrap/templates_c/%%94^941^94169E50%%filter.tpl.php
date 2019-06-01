<?php /* Smarty version 2.6.14, created on 2017-05-15 20:55:35
         compiled from /%40ui/%40element/form/filter.tpl */ ?>
<?php echo '

<script type="text/javascript">
	
	$(\'.datepicker\').datepicker();
		
		
		
	function _test(){
		alert(\'test\');
	}
		
				  	  
</script>

'; ?>


		
<?php $this->assign('form', $this->_tpl_vars['grid']->getParam('filter_form')); ?>


	  
		<form class="form-inline" method="GET" name="<?php echo $this->_tpl_vars['form']->getName(); ?>
">
			<?php if ($this->_tpl_vars['form']->title_): ?><legend><?php echo $this->_tpl_vars['form']->title; ?>
</legend><?php endif; ?>
				<div class="well">
	
				
				<?php $_from = $this->_tpl_vars['form']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
					<?php if ($this->_tpl_vars['field']->type == 'select'): ?>
					
					<?php elseif ($this->_tpl_vars['field']->class == 'date'): ?>
						
					
					
					<div  id="datetime_picker_<?php echo $this->_tpl_vars['field']->name; ?>
" class="input-append date" data-provide="datepicker" data-date="05-04-2017" data-date-format="dd-mm-yyyy" >
						<input id="_date" class="input-medium" size="16" type="text" name="<?php echo $this->_tpl_vars['field']->name; ?>
" value="<?php echo $this->_tpl_vars['field']->value; ?>
" placeholder="<?php echo $this->_tpl_vars['field']->getTitle(); ?>
">
						<span class="add-on" ><i class="icon-calendar"></i></span>
					  </div>
					
						<?php echo '

						<script type="text/javascript">
								
						$(\'#datetime_picker_';  echo $this->_tpl_vars['field']->name;  echo '\').datepicker({
							format: \'dd-mm-yyyy\'
						})
											  
						</script>

						'; ?>


					
					 
					<?php elseif ($this->_tpl_vars['field']->type == 'checkbox'): ?>
					
					
					<?php else: ?>
					
						<input type="text" name="<?php echo $this->_tpl_vars['field']->getName(); ?>
" class="input-medium" placeholder="<?php echo $this->_tpl_vars['field']->getTitle(); ?>
" value= "<?php echo $this->_tpl_vars['field']->getValue(); ?>
">
						
					<?php endif; ?>
					
				<?php endforeach; endif; unset($_from); ?>
				

			<input type="hidden" name="post" value="1">
  
			<button type="submit" class="btn">Submit</button>
		</div>
	</form>
	  
	  
	  
	  
		<!--form class="form-inline" method="GET" name="<?php echo $this->_tpl_vars['ui_element']->getName(); ?>
">
			
				<fieldset  style="padding-left:10px;background-color:#F4F4F4" >
			
				<?php $_from = $this->_tpl_vars['ui_element']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
				
					<?php if ($this->_tpl_vars['field']->type == 'select'): ?>
					<label><?php echo $this->_tpl_vars['field']->title; ?>
:</label>
						<select class="input-medium" id  = "<?php echo $this->_tpl_vars['field']->name; ?>
" name="<?php echo $this->_tpl_vars['field']->name;  if ($this->_tpl_vars['field']->is_multiple): ?>[]<?php endif; ?>" <?php if ($this->_tpl_vars['field']->is_multiple): ?> multiple <?php if ($this->_tpl_vars['field']->size): ?>size="<?php echo $this->_tpl_vars['field']->size; ?>
" <?php else: ?> size="20"<?php endif; ?> <?php endif; ?> <?php if ($this->_tpl_vars['field']->is_test): ?>onChange="test(this.value)<?php endif; ?>">
							<option style="font-weight:bold;font-style:italic">...</option>
						<?php $_from = $this->_tpl_vars['field']->getElements(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['option']):
?>
							<option <?php if ($this->_tpl_vars['field']->getValue($this->_tpl_vars['option']->value) == $this->_tpl_vars['option']->value): ?> selected <?php endif; ?> value="<?php echo $this->_tpl_vars['option']->value; ?>
"><?php echo $this->_tpl_vars['option']->title; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
						</select>
						<br />
					
					<?php elseif ($this->_tpl_vars['field']->type == 'date'): ?>
					<label><?php echo $this->_tpl_vars['field']->title; ?>
:</label>
					<div id="<?php echo $this->_tpl_vars['field']->name; ?>
" class="input-append date"  data-date="01-08-2013" data-date-format="dd-mm-yyyy">
						<input class="input-medium" size="16" type="text" name="<?php echo $this->_tpl_vars['field']->name; ?>
" value="<?php echo $this->_tpl_vars['field']->value; ?>
" >
						<span class="add-on"><i class="icon-calendar"></i></span>
					  </div>

						<br />
						
					<?php elseif ($this->_tpl_vars['field']->type == 'file'): ?> 
					<div class="control-group ">
					<label class="control-label" for="inputEmail"><?php echo $this->_tpl_vars['field']->getTitle(); ?>
 <?php if ($this->_tpl_vars['field']->getParam('is_required')): ?><font color="red">*</font><?php endif; ?></label>
						<div class="controls">
							<span class="btn btn-file">
					
								<input class="input-medium" type="file" name="<?php echo $this->_tpl_vars['field']->name; ?>
" id="image" />
							</span>
				
						</div>
					</div>
					
		
					<?php elseif ($this->_tpl_vars['field']->type == 'checkbox'): ?>
					<label class="checkbox">
					<input class="input-medium" type="checkbox" name="<?php echo $this->_tpl_vars['field']->name; ?>
" value="1" <?php if (( $this->_tpl_vars['field']->default_value == 1 && ! $this->_tpl_vars['post'] ) || $this->_tpl_vars['field']->value === 1): ?> checked <?php endif; ?>> <?php echo $this->_tpl_vars['field']->title; ?>

					</label>
					<?php else: ?>

					<label><?php if ($this->_tpl_vars['field']->getParam('is_required')): ?><font color="red">*</font><?php endif;  echo $this->_tpl_vars['field']->title; ?>
:</label>
					<div class="control-group <?php if ($this->_tpl_vars['field']->getErrorFlag()): ?> error<?php endif; ?>">
						<div class="controls">
							<input class="input-medium" <?php if ($this->_tpl_vars['field']->view->type == 'password'): ?> type="password" <?php else: ?> type="text" <?php endif; ?> name = "<?php echo $this->_tpl_vars['field']->name; ?>
" value= "<?php echo $this->_tpl_vars['field']->getValue(); ?>
" placeholder="" id="inputError">
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
				
				<input type="hidden" name="post" value="1">
					<br /><button type="submit" class="btn">Submit</button>
		  </fieldset>
		  
		</form-->
		



