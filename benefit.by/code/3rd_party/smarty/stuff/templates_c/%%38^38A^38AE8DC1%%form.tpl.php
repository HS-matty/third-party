<?php /* Smarty version 2.6.14, created on 2008-01-11 01:08:36
         compiled from z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/form.tpl */ ?>


<?php if ($this->_tpl_vars['success'] == 2): ?>
<div style="color:red">success!</div>
<?php elseif ($this->_tpl_vars['success'] == 1): ?>
<div style="color:red">not success!</div>
<?php endif; ?>

	<form method="post" enctype="multipart/form-data" name="<?php echo $this->_tpl_vars['Form']->FormName; ?>
">
		<input type="hidden" name="FormName" value="<?php echo $this->_tpl_vars['Form']->FormName; ?>
">
		<input type="hidden" name="post" value="1">
		
						<?php if ($this->_tpl_vars['Form']->FormTitle): ?><h5><?php echo $this->_tpl_vars['Form']->FormTitle; ?>
</h5><?php endif; ?>
						
				
						<table width= <?php if ($this->_tpl_vars['Form']->FormWidth): ?>"<?php echo $this->_tpl_vars['Form']->FormWidth; ?>
"<?php else: ?>"100%"<?php endif; ?> cellpadding="3" cellspacing="0">
				
							
							
							

		<?php $_from = $this->_tpl_vars['Form']->getXMLFormContent(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
		
		 
		 			<?php if ($this->_tpl_vars['f']->Type == 'int' || $this->_tpl_vars['f']->Type == 'float'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('int_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['f']->Type == 'list'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('list-menu_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['f']->Type == 'bool'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('bool_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['f']->Type == 'string'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('string_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['f']->Type == 'file'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('file_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['f']->Type == 'date'): ?> 
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('date_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php elseif ($this->_tpl_vars['f']->Type == 'captcha'): ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('captcha.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php else: ?>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Page']->getIndexTmpl('int_edit.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<?php endif; ?>

		
		<?php endforeach; endif; unset($_from); ?>
		<tr  align=left><td>

	</td><td><input type="submit" name="go" value="Send"></td>	</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
		
	


