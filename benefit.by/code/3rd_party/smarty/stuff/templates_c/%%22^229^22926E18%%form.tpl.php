<?php /* Smarty version 2.6.14, created on 2008-02-08 14:40:05
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/standart_form/form.tpl */ ?>
﻿
<?php echo $this->_tpl_vars['Page']->setIndexPath('standart_form/'); ?>

<h4><?php echo $this->_tpl_vars['Form']->getFormTitle(); ?>
</h4>

<?php if ($this->_tpl_vars['success'] === 1): ?>
<div style="color:red">success!</div>
<?php elseif ($this->_tpl_vars['success'] === 0): ?>
<div style="color:red">not success!</div>
<?php endif; ?>

	<form method="post" enctype="multipart/form-data" name="<?php echo $this->_tpl_vars['Form']->getFormId(); ?>
">
		<input type="hidden" name="FormName" value="<?php echo $this->_tpl_vars['Form']->getFormId(); ?>
">
		<input type="hidden" name="post" value="1">
		
						<?php if ($this->_tpl_vars['Form']->FormTitle): ?><h5><?php echo $this->_tpl_vars['Form']->FormTitle; ?>
</h5><?php endif; ?>
						
				
						<table width= <?php if ($this->_tpl_vars['Form']->FormWidth): ?>"<?php echo $this->_tpl_vars['Form']->FormWidth; ?>
"<?php else: ?>"100%"<?php endif; ?> cellpadding="3" cellspacing="0">
				
							
							
							

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

		<?php if ($this->_tpl_vars['f']->View->Group): ?><tr><td colspan=2><HR /><br /></td></tr>
		<?php endif; ?>
		
		<?php endforeach; endif; unset($_from); ?>
		<tr  align=left><td>

	</td><td><input type="submit" name="go" value="Send"></td>	</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
		
	


