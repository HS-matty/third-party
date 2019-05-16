<?php /* Smarty version 2.6.14, created on 2008-02-14 01:12:55
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'Z:\\home\\benefitby\\www/application/views/_index/form.tpl', 82, false),)), $this); ?>
﻿	<?php if ($this->_tpl_vars['Form']->Action == 'insert' || $this->_tpl_vars['Form']->Action == 'update'): ?>


<?php if ($this->_tpl_vars['success'] == 2): ?>
<div style="color:red">Сохранено!</div>
<?php elseif ($this->_tpl_vars['success'] == 1): ?>
<div style="color:red">Не сохранено!</div>
<?php endif; ?>
<div>
	<form method="post" enctype="multipart/form-data" name="<?php echo $this->_tpl_vars['Form']->FormName; ?>
">
		<input type="hidden" name="FormName" value="<?php echo $this->_tpl_vars['Form']->FormName; ?>
">
		<input type="hidden" name="post" value="1">
		
						<?php if ($this->_tpl_vars['Form']->FormTitle): ?><h5><?php echo $this->_tpl_vars['Form']->FormTitle; ?>
</h5><?php endif; ?>
						

						<table width="100%" cellpadding="3" cellspacing="0" border="0">
				
							
							
							

		<?php $_from = $this->_tpl_vars['Form']->getXMLFormContent(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
			<?php if ($this->_tpl_vars['f']->View->Group): ?><FIELDSET>
		<?php endif; ?>
		 
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

	<?php if ($this->_tpl_vars['f']->View->Group): ?><tr><td><br /><br /><HR /></td></tr>
		<?php endif; ?>
		
		<?php endforeach; endif; unset($_from); ?>
		<tr  align="left"><td>

	</td><td><input type="submit" class="button" name="go" value="Отправить"><br><br>
	<?php if ($this->_tpl_vars['formname'] == 'login'): ?>
		<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/forgot_password/">Забыли пароль?</a>
	<?php endif; ?>	
	</td>	</tr>
	</table>

						<!--	<input type="button" value="Post Ad" onCLick="postForm()"/>-->
						
						

		</form>
		
	</DIV>
	
	<?php else: ?>
	<div>

<table>
	<?php $_from = $this->_tpl_vars['Form']->getXMLFormContent(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?>
				<?php if ($this->_tpl_vars['f']->Type == 'bool'): ?> 
					<tr><td>
				<?php echo $this->_tpl_vars['f']->Title; ?>
</td>
					<td><b><?php if ($this->_tpl_vars['f']->Value == 1): ?>Да
<?php else: ?>Нет<?php endif; ?> </b>
</td></tr>
					<?php elseif ($this->_tpl_vars['f']->Type == 'file'): ?> 
				
					<?php elseif (! $this->_tpl_vars['f']->PrimaryKey): ?>
				<tr><td><?php echo $this->_tpl_vars['f']->Title; ?>
: </td><td>
<b><?php if ($this->_tpl_vars['f']->View == 'date'):  echo ((is_array($_tmp=$this->_tpl_vars['f']->Value)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%y") : smarty_modifier_date_format($_tmp, "%d-%m-%y"));  elseif ($this->_tpl_vars['f']->ViewValue):  echo $this->_tpl_vars['f']->ViewValue;  else:  echo $this->_tpl_vars['f']->getViewValue();  endif; ?></b>
</td></tr>

					<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
	</table>
	</div>
<?php endif; ?>

