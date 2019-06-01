<?php /* Smarty version 2.6.14, created on 2017-05-06 14:39:05
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


	  
	  
	  <div class="well">
	  <form class="form-inline" role="form">
											
											<fieldset>
											
											<?php $_from = $this->_tpl_vars['form']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field']):
?>
											
											<?php if ($this->_tpl_vars['field']->type == 'select'): ?>
					
											<?php elseif ($this->_tpl_vars['field']->class == 'date'): ?>
														<div class="form-group">
															<div class="input-group">
																<input class="form-control hasDatepicker" id="to" type="text" placeholder="<?php echo $this->_tpl_vars['field']->getTitle(); ?>
" name="<?php echo $this->_tpl_vars['field']->name; ?>
"  value="<?php echo $this->_tpl_vars['field']->getValue(); ?>
">
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
															</div>
														</div>
											<?php else: ?>
											
												<div class="form-group">
													<label class="sr-only" for=""><?php echo $this->_tpl_vars['field']->getName(); ?>
</label>
													<input  class="form-control" id="" placeholder="<?php echo $this->_tpl_vars['field']->getTitle(); ?>
" value= "<?php echo $this->_tpl_vars['field']->getValue(); ?>
" name="<?php echo $this->_tpl_vars['field']->name; ?>
">
												</div>
											<?php endif; ?>
											<?php endforeach; endif; unset($_from); ?>
												
												<button type="submit" class="btn btn-default">
													Search
												</button>
											</fieldset>
										<input type="hidden" name="post" value="1">
											
						</form>
	  
	  
	  	
			
		</div>
		
		
		
