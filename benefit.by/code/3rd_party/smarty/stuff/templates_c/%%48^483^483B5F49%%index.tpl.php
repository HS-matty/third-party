<?php /* Smarty version 2.6.14, created on 2008-01-04 16:38:17
         compiled from z:/home/benefitby/www/application/views/_index/index.tpl */ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Benefit</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['HostName']; ?>
/public/styles/style.css" type="text/css" />
<script src="<?php echo $this->_tpl_vars['HostName']; ?>
/public/scripts/prototype.js" type="text/javascript" language="javascript"></script>
<?php echo '
<script type="text/javascript">
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
			<div id="signup">
				Авторизация 
				<input type="text" value="Имя" class="input" /> <input type="Password" value="Пароль" class="input" />
				<input type="submit" class="sign" value=" " /> 
				<a href="#">Регистрация</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
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
			<div id="menu4"><a href=""><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu4.gif" border="0" /></a></div>
			<div id="menu3"><a href=""><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu3.png" border="0" /></a></div>
			<div id="menu2"><a href=""><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu2.gif" border="0" /></a></div>
			<div id="menu1"><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/go/services/"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/top_menu1.gif" border="0" /></a></div>
		</div>
		<div id="left_menu">
			<div id="depozit" onclick="main('depozit_text');"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/depozit.jpg" border="0" /></div>
			<div id="kredit" onclick="main('kredit_text');"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/kredit.gif" border="0" /></div>
			<div id="left_menu1"><a href="#"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/menu1.gif" border="0" /></a></div>
			<div id="left_menu1"><a href="#"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/menu2.gif" border="0" /></a></div>
			<div id="left_menu1"><a href="#"><img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/menu3.gif" border="0" /></a></div>
			<div id="contacts">
				<div id="phone">
				8 029 1 084 084<br />
				8 029 7 084 084<br />
				8 017 2 084 084<br />
				</div>
				<div id="mail">
				info@benefit.by<br />
				ICQ: 393-050-900 
				</div>
			</div>
		</div>
		<div id="main_content">
			<div id="kredit_text">
			
			<?php if ($this->_tpl_vars['Record']): ?>
			
			<h1><?php echo $this->_tpl_vars['Record']->getTitle(); ?>
</h1>
			<?php echo $this->_tpl_vars['Record']->getBody(); ?>

			
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
					</ul>
					<h3>реклама</h3>
					<ul>
					<?php $_from = $this->_tpl_vars['Record']->getItems(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?>
					<li><a href="<?php echo $this->_tpl_vars['HostName']; ?>
/content/record/<?php echo $this->_tpl_vars['i']['listing_id']; ?>
/"><?php echo $this->_tpl_vars['i']['short_description']; ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
					</ul>
				<?php endif; ?>
			<?php else: ?>
			<h1>No page</h1>
			<?php endif; ?>
			</div>
			
			<div id="depozit_text" style="display:none;">
			<h1>Первые полтора года латвийская виза</h1>
			<p>Первые полтора года латвийская виза была для белорусов бесплатной. В 2006 году посольством было выдано 25 тыс. виз белорусским гражданам, по итогам 2007 года эта цифра будет еще больше. С 21 декабря Латвия вступает в Шенгенское соглашение. Соответственно стоимость визы для посещения этой страны, как и других государств-членов, будет составлять 60 евро. Шенген не допускает возможности льготного оформления виз кроме нескольких категорий граждан: детей до 6 лет, участников научных, образовательных и культурных обменов, научных руководителей и студентов, которые въезжают в страны Шенгенской группы для обучения либо для повышения квалификации. Туристы не входят в категории граждан, которые могут получать визы на льготных основаниях.</p>

<p>В посольстве считают, что повышение стоимости визы не сильно повлияет на туристическое сотрудничество Беларуси и Латвии. "Кто действительно захочет посетить Латвию, сделает это и за 60 евро", - пояснили в дипломатическом представительстве, при этом признав, что в первое время возможен некоторый спад туристической активности. "Мы, конечно, заинтересованы, чтобы к нам ехало больше туристов, но вся работа ведется по шенгенским нормативным актам, и мы должны их придерживаться", - отметили дипломаты.</p>

<p>Они сообщили также, что в настоящее время идет согласование двустороннего белорусско-латвийского соглашения об упрощенном пересечении границы приграничным населением после вступления Латвии в Шенген.</p>
			</div>
			<div id="anons">
				<?php if ($this->_tpl_vars['NewsNode']): ?>
				<?php $_from = $this->_tpl_vars['NewsNode']->getItems(null,3); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['n']):
?>
				<div id="anons1">
			
				<div class="title_anons"><?php echo $this->_tpl_vars['n']['short_description']; ?>
</div>
				<?php echo $this->_tpl_vars['n']['long_description']; ?>

				</div>
				<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
			</div>
		</div>
		<div id="bottom">
			<div id="copyright">
			Все права защищены ооо "бенифит бай"
			</div>
			<div id="meshki">
			<img src="<?php echo $this->_tpl_vars['HostName']; ?>
/images/meshki.png" />
			</div>
		</div>
	</div>
</body>
</html>