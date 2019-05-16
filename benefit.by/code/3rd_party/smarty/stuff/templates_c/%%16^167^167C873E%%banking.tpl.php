<?php /* Smarty version 2.6.14, created on 2008-01-17 18:09:44
         compiled from z:%5Chome%5Cbenefitby%5Cwww/application/views/default/banking.tpl */ ?>
﻿<div>
<?php if ($this->_tpl_vars['User']->isLogined('RegisteredUser')): ?>
	<tr>
				<td width="300">
				<a href="#" class="page">&lt;</a><a href="#" class="page">&lt;</a> <a href="#" class="page">1</a> <a href="#" class="page">2</a> <a href="#" class="page">3</a> <a href="#" class="page">4</a> <a href="" class="page">5</a> <a href="#" class="page">&gt;</a><a href="#" class="page">&gt;</a>
				</td>
				<td class="pager_info">
				Показано с 1 по 5 | Всего 55
				</td>
				</tr>
			</table>
				<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
			<table width="595" cellpadding="0" cellspacing="0" id="special">
			<tr>
				<td>
				<div class="special_image"><a href=""><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/special/special_1.gif" class="banner_image"></a></div>
				<div class="special_title_image"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/special/special_5.gif"> <a href="" class="special_title_image"><?php echo $this->_tpl_vars['i']['company']; ?>
</a></div>
				<div class="special_title"><a href="" class="special_title"><?php echo $this->_tpl_vars['i']['short_description']; ?>
</a></div>
				<div class="special_text"><?php echo $this->_tpl_vars['i']['long_description']; ?>
</div>
				</td>
			</tr>
			</table>
			<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
<table class="table_sr" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="5" align="center" background="<?php echo $this->_tpl_vars['HostName']; ?>
/images/table/title_bg.gif"><h3>Сравнения по <?php if ($this->_tpl_vars['alias'] == 'credit'): ?>кредитам<?php else: ?>депозитам<?php endif; ?></h3></td>
				</tr>
				
			<?php $_from = $this->_tpl_vars['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
				<tr>
					<td class="table_body_1" width="205"><a href=""><?php echo $this->_tpl_vars['i']['short_description']; ?>
</a></td>
					<td class="table_body_1" width="205"><?php echo $this->_tpl_vars['i']['company']; ?>
</td>
					<td class="table_body_1" width="205">Потребительский</td>
					<td class="table_body_1" width="125"><?php echo $this->_tpl_vars['i']['term']; ?>
 месяцев</td>
					<td class="table_body_1_r" width="70"><?php echo $this->_tpl_vars['i']['rate']; ?>
%</td>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
				<tr>
					<td class="table_bottom" colspan="5"><input type="submit" class="button_back" value="вернуться назад" /></td>
				</tr>
			</table>
			
			</div>
		
		<?php endif; ?>