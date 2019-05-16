<?php /* Smarty version 2.6.14, created on 2008-03-02 13:18:30
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/calculator/form.tpl */ ?>
﻿<?php echo $this->_tpl_vars['Page']->setIndexPath('calculator/'); ?>


					
	<form method="post" enctype="multipart/form-data" name="<?php echo $this->_tpl_vars['Form']->getFormId(); ?>
">
	
		<input type="hidden" name="post" value="1">
		
				
						
				
						<table width="200" height="100%" cellpadding="0" cellspacing="0" border="0">
				
				
							
							
							

		<?php $_from = $this->_tpl_vars['Form']->getFields(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
		

		 			<?php $this->assign('type', $this->_tpl_vars['f']->Type->getTypeString()); ?>
		 			<?php if (( $this->_tpl_vars['type'] == 'int' || $this->_tpl_vars['type'] == 'float' )): ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('int_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['type'] == 'list'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('list-menu_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['type'] == 'bool'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('bool_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['type'] == 'string'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('string_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['type'] == 'file'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('file_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['type'] == 'date'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('date_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['type'] == 'enum'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('enum_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['type'] == 'captcha'): ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('captcha.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					
						

		<?php endif; ?>

<?php if ($this->_tpl_vars['f']->View->Group): ?><hr><?php endif; ?>
	
		
		<?php endforeach; endif; unset($_from); ?>
		<tr>
						<td colspan=2 style="padding-top: 15px">
							<input type="button" id="button_first" value="подобрать" />
							<input type="submit" id="button_second" value="поиск" />
							<input type="hidden" name="post" value=1>
							
						</td>
					</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
	
	


