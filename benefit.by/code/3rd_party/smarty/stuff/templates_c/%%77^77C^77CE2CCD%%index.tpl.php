<?php /* Smarty version 2.6.14, created on 2008-02-21 13:41:33
         compiled from Z:%5Chome%5Cbenefitby%5Cwww/application/views/_index/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'Z:\\home\\benefitby\\www/application/views/_index/index.tpl', 137, false),array('modifier', 'truncate', 'Z:\\home\\benefitby\\www/application/views/_index/index.tpl', 237, false),)), $this); ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Benefit</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['HostName']; ?>
/public/styles/style.css" type="text/css" />
<script src="<?php echo $this->_tpl_vars['HostName']; ?>
/public/scripts/prototype.js" type="text/javascript" language="javascript"></script>
 <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/jquery/jquery.js"></script> 
 <script type="text/javascript" src="<?php echo $this->_tpl_vars['HostName']; ?>
/3rd_party/jquery/interface.js"></script> 
  
<?php echo '
<script type="text/javascript">


function login(){


//showDiv(\'yourAccount\'); hideDiv(\'login\')
var Login = document.getElementById(\'username\').value;
var Pass = document.getElementById(\'password\').value;




$.get(
  '; ?>
"<?php echo $this->_tpl_vars['StartLink']; ?>
/auth/login/?login=" + Login + "&password=" + Pass; <?php echo ',
  {
    type: "test-request",

  },
  login_proceed
);

 
}



function login_proceed(answer){
  	 if(answer == \'ok\') {
   			 
   			 showDiv(\'yourAccount\'); 
   			 hideDiv(\'login\');
   				
   			
   			
   			 
   			 
   			 }else if(answer == \'not_active\'){
   		 		$("notactive_message").html("Аккунт не активирован");
   			 }
   			 else $("login_message").html(\'неправильный логин/пароль\'); 

}
$("#listings").load("';  echo $this->_tpl_vars['HostName'];  echo '/admin/node/listings",{'; ?>
cid: <?php echo $this->_tpl_vars['cid']; ?>
,post:1<?php echo '});


function main(id)
{
	if (id==\'kredit_text\') 
		{
		$(\'kredit_text\').show();
		$(\'depozit_text\').hide();
		}
	else
		{
		$(\'depozit_text\').show();
		$(\'kredit_text\').hide();
		}
}
</script>
'; ?>

</head>
<body>

	<div id="wrapper" align="center">
		<div id="header">
		<form action="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/login/" method="post">
			<div id="signup">
			<?php if ($this->_tpl_vars['User']->isLogined('RegisteredUser')): ?>
			<div id="exit"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/logout/">Выйти</a></div>
			<?php else: ?>
				Авторизация 
				
				<input type="text" id="username" value="Имя" name ="login" class="input" /> <input type="Password" id="password" name="password" value="Пароль" class="input" />
				<input type="submit" class="sign" value=""  /> 
				<input type="hidden" name="post" value="1">
				<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/auth/register/">Регистрация</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php endif; ?>
			</div>
			</form>
			<div id="logo">
			<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/logo.png" border="0" /></a>
			</div>
		</div>
		<div id="navigation_menu">
			<div id="menu6"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/services/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu6.gif" border="0" /></a></div>
			<div id="menu5"><a href=""><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu5.png" border="0" /></a></div>
			<div id="menu4"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/questions/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu4.gif" border="0" /></a></div>
			<div id="menu3"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/why_benefit/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu3.png" border="0" /></a></div>
			<div id="menu2"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/conditions/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu2.gif" border="0" /></a></div>
			<div id="menu1"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/services/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu1.gif" border="0" /></a></div>
			
			
			
			
			
		</div>
	

	
		<div id="left_menu">
		<?php if ($this->_tpl_vars['User']->isLogined('RegisteredUser')): ?>
		<div id="left_menu1"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/person_room.gif" border="0" /></div>
			<?php if ($this->_tpl_vars['User']->isLogined('PartnerUser')): ?>
			<div class="menu_s"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/user/add_item/" class="menu_s_link">Добавить запись</a></div>
			<div class="menu_s"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/user/items/" class="menu_s_link">Все записи</a></div>
			<?php endif; ?>
			<div class="menu_s"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/user/edit/" class="menu_s_link">Редактировать данные</a></div>
			

		<?php endif; ?>
		<?php if ($this->_tpl_vars['search']): ?>
			<div id="search">
			<div id="search_top">
			<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/search_text.gif" id="search_text" />
			</div>
			<div id="search_bottom" name='sum'>
			<!-- form method="post">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="padding-top: 10px;">сумма</td>
					</tr>
					
					
					<tr>
						<td><input type="text" id="sum" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['params']['sum'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"name="sum" />
							<select id="val">
							<option selected="selected" value="usd">USD</option>
							<option value="wmz">WMZ</option>
							<option value="rub">RUB</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="search_text" name="term">срок кредита</td>
					</tr>
					<tr>
						<td>
						<select name="term" class="search">
							<option <?php if ($this->_tpl_vars['params']['term'] == 18): ?> selected="selected"<?php endif; ?> value="18">18 месяцев</option>
							<option <?php if ($this->_tpl_vars['params']['term'] == 24): ?> selected="selected"<?php endif; ?> value="24">24 месяца</option>
							<option <?php if ($this->_tpl_vars['params']['term'] == 36): ?> selected="selected"<?php endif; ?> value="36">36 месяцев</option>
						</select>
						</td>
					</tr>
					<tr>
						<td class="search_text">цель кредита</td>
					</tr>
					<tr>
						<td>
						<select class="search">
							<option selected="selected" value="1">потребительские цели</option>
							<option value="2">строительство жилья</option>
							<option value="3">пропить</option>
						</select>
						</td>
					</tr>
					<tr>
						<td style="padding-top: 15px;">
							<input type="button" id="button_first" value="подобрать" />
							<input type="submit" id="button_second" value="поиск" />
							<input type="hidden" name="post" value=1>
						</td>
					</tr>
				</table></form-->
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['View']->getIndexTmpl('calculator/form.tpl'), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>	
		</div>
			
			<?php else: ?>
			<!--div id="depozit" ><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/deposit/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/depozit.jpg" border="0" /></a></div>
			<div id="kredit" ><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/credit/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/kredit.gif" border="0" /></a></div-->
			<?php if (! $this->_tpl_vars['User']->isLogined('RegisteredUser') || true): ?>
			<div style="margin-bottom: 30px;">
			<?php $_from = $this->_tpl_vars['services']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['s']):
?>
			<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/service/<?php echo $this->_tpl_vars['s']['alias']; ?>
/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/ico.jpg" border="0" alt="<?php echo $this->_tpl_vars['s']['short_description']; ?>
"></a>
			<?php endforeach; endif; unset($_from); ?>
		</div><?php endif; ?>
			
			<div id="left_menu1"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/review/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/menu1.gif" border="0" /></a></div>
			<div id="left_menu1"><a href="#"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/menu2.gif" border="0" /></a></div>
			<div id="left_menu1"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/adviser/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/menu3.gif" border="0" /></a></div>
<div id="left_menu1" style="text-align:right;padding-right:20px">


<?php if ($this->_tpl_vars['User']->Searches->getItems('default')): ?>
<h4><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/user/cart/">Корзина</h4>
<ul>
<?php $_from = $this->_tpl_vars['User']->Searches->getItems('default',1); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/item/?listing_id=<?php echo $this->_tpl_vars['c']['listing_id']; ?>
"><?php echo $this->_tpl_vars['c']['short_description']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<br /><br /><br />
<?php endif; ?></div>
			<?php endif; ?>
		</div>
		
		<div id="main_content">
			<div id="kredit_text">
			<?php if ($this->_tpl_vars['path']): ?>
			<div align="right"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/">Главная</a>
			<?php $_from = $this->_tpl_vars['path']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['p']):
?>
			 &raquo;	<a href="<?php echo $this->_tpl_vars['HostName']; ?>
/content/node/<?php echo $this->_tpl_vars['p']['category_id']; ?>
/"><?php echo $this->_tpl_vars['p']['short_description']; ?>
</a> 
			<?php endforeach; endif; unset($_from); ?>
			<?php if ($this->_tpl_vars['Record'] && $this->_tpl_vars['RecordAction']): ?>
				&raquo; <a href="<?php echo $this->_tpl_vars['HostName']; ?>
/content/record/<?php echo $this->_tpl_vars['Record']->Data['listing_id']; ?>
/"><?php echo $this->_tpl_vars['Record']->Data['short_description']; ?>
</a> 
			<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['Record'] && ! $this->_tpl_vars['UsePath']): ?>

			
			<?php if ($this->_tpl_vars['Record']->Data['main_image']): ?><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/items/thumbs/<?php echo $this->_tpl_vars['Record']->Data['main_image']; ?>
" style="float:left;padding-right:20px"><?php endif;  echo $this->_tpl_vars['Record']->getBody(); ?>

			
				<?php if ($this->_tpl_vars['Record']->getType() == 'category'): ?>
					<ul>
					<?php $_from = $this->_tpl_vars['Record']->getChildNodes(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['n']):
?>
					<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/content/node/<?php echo $this->_tpl_vars['n']->getId(); ?>
/"><?php echo $this->_tpl_vars['n']->getTitle(); ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
					<?php $this->assign('Items', $this->_tpl_vars['Record']->getItems()); ?>
					</ul>
					<?php if ($this->_tpl_vars['Items']): ?>
					<h1>Записи</h1>
					<ul>
					<?php $_from = $this->_tpl_vars['Items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
					<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/content/record/<?php echo $this->_tpl_vars['i']['listing_id']; ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['i']['short_description'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100, "", true) : smarty_modifier_truncate($_tmp, 100, "", true)); ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
					<?php endif; ?>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['Path']): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['Path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php else: ?>
			<h1>No page</h1>
			<?php endif; ?>
			</div>
			<?php if ($this->_tpl_vars['NewsNode']): ?>
			<div id="anons">
				<?php $_from = $this->_tpl_vars['NewsNode']->getItems(null,3); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['n']):
?>
				<div id="anons1">
				<div class="title_anons"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/content/record/<?php echo $this->_tpl_vars['n']['listing_id']; ?>
/"><?php echo $this->_tpl_vars['n']['short_description']; ?>
</a></div>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['n']['long_description'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100, "", true) : smarty_modifier_truncate($_tmp, 100, "", true)); ?>

				</div>
				<?php endforeach; endif; unset($_from); ?>
			</div>
			<?php endif; ?>
		</div>
		<div id="bottom">
			<div id="copyright">
			Все права защищены ооо "бенифит бай"
			</div>
			<div id="meshki">
			<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/meshki.gif" />
			</div>
		</div>
	</div>
</body>
</html>