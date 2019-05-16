<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Benefit</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<link rel="stylesheet" href="{$HostName}/public/styles/style.css" type="text/css" />
<script src="{$HostName}/public/scripts/prototype.js" type="text/javascript" language="javascript"></script>
 <script type="text/javascript" src="{$HostName}/3rd_party/jquery/jquery.js"></script> 
 <script type="text/javascript" src="{$HostName}/3rd_party/jquery/interface.js"></script> 
  
{literal}
<script type="text/javascript">


function login(){


//showDiv('yourAccount'); hideDiv('login')
var Login = document.getElementById('username').value;
var Pass = document.getElementById('password').value;




$.get(
  {/literal}"{$StartLink}/auth/login/?login=" + Login + "&password=" + Pass; {literal},
  {
    type: "test-request",

  },
  login_proceed
);

 
}



function login_proceed(answer){
  	 if(answer == 'ok') {
   			 
   			 showDiv('yourAccount'); 
   			 hideDiv('login');
   				
   			
   			
   			 
   			 
   			 }else if(answer == 'not_active'){
   		 		$("notactive_message").html("Аккунт не активирован");
   			 }
   			 else $("login_message").html('неправильный логин/пароль'); 

}
$("#listings").load("{/literal}{$HostName}{literal}/admin/node/listings",{{/literal}cid: {$cid},post:1{literal}});


function main(id)
{
	if (id=='kredit_text') 
		{
		$('kredit_text').show();
		$('depozit_text').hide();
		}
	else
		{
		$('depozit_text').show();
		$('kredit_text').hide();
		}
}
</script>
{/literal}
</head>
<body>

	<div id="wrapper" align="center">
		<div id="header">
		<form action="{$HostName}/auth/login/" method="post">
			<div id="signup">
			{if $User->isLogined('RegisteredUser')}
			<a href="{$HostName}/auth/logout/">Выйти</a>&nbsp;&nbsp;&nbsp;&nbsp;
			{else}
				Авторизация 
				
				<input type="text" id="username" value="Имя" name ="login" class="input" /> <input type="Password" id="password" name="password" value="Пароль" class="input" />
				<input type="submit" class="sign" value=""  /> 
				<input type="hidden" name="post" value="1">
				<a href="{$HostName}/auth/register/">Регистрация</a> | <a href="{$HostName}/auth/forgot_password/">Забыли пароль</a>&nbsp;&nbsp;&nbsp;&nbsp;
				{/if}
			</div>
			</form>
			<div id="logo">
			<a href="{$HostName}/"><img src="{$HostName}/images/logo.png" border="0" /></a>
			</div>
		</div>
		<div id="navigation_menu">
			<div id="menu6"><a href="{$HostName}/go/services/"><img src="{$HostName}/images/top_menu6.gif" border="0" /></a></div>
			<div id="menu5"><a href=""><img src="{$HostName}/images/top_menu5.png" border="0" /></a></div>
			<div id="menu4"><a href="{$HostName}/go/questions/"><img src="{$HostName}/images/top_menu4.gif" border="0" /></a></div>
			<div id="menu3"><a href="{$HostName}/go/why_benefit/"><img src="{$HostName}/images/top_menu3.png" border="0" /></a></div>
			<div id="menu2"><a href="{$HostName}/go/conditions/"><img src="{$HostName}/images/top_menu2.gif" border="0" /></a></div>
			<div id="menu1"><a href="{$HostName}/go/services/"><img src="{$HostName}/images/top_menu1.gif" border="0" /></a></div>
			
			
			
			
			
		</div>
	

	
		<div id="left_menu" >
		{if $User->isLogined('RegisteredUser')}
		<div id="left_menu1"><img src="{$HostName}/images/person_room.gif" border="0" /></div>
			<div class="menu_s"><a href="{$HostName}/user/add_item/" class="menu_s_link">Добавить запись</a></div>
			<div class="menu_s"><a href="{$HostName}/user/items/" class="menu_s_link">Все записи</a></div>
			<div class="menu_s"><a href="{$HostName}/user/edit/" class="menu_s_link">Редактировать данные</a></div>
			

		{/if}
		{if $search}
			<div id="search">
			<div id="search_top">
			<img src="{$HostName}/images/search_text.gif" id="search_text" />
			</div>
			<div id="search_bottom" name='sum'>
			<form method="post">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td style="padding-top: 10px;">сумма</td>
					</tr>
					<tr>
						<td><input type="text" id="sum" value="{$params.sum|escape}"name="sum" />
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
							<option {if $params.term == 18} selected="selected"{/if} value="18">18 месяцев</option>
							<option {if $params.term == 24} selected="selected"{/if} value="24">24 месяца</option>
							<option {if $params.term == 36} selected="selected"{/if} value="36">36 месяцев</option>
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
				</table></form>
		</div>	
		</div>
			
			{else}
			<!-- div id="depozit" ><a href="{$HostName}/go/deposit/"><img src="{$HostName}/images/depozit.jpg" border="0" /></a></div>
			<div id="kredit" ><a href="{$HostName}/go/credit/"><img src="{$HostName}/images/kredit.gif" border="0" /></a></div-->
			{if  !$User->isLogined('RegisteredUser')}
			<div >
			<ul>
			{foreach from=$services item=s}
			<li><a href="{$HostName}/service/{$s.alias}/">{$s.short_description}</a></li>
			{/foreach}
			</ul>
		</div>{/if}
			
			<div id="left_menu1"><a href="{$HostName}/go/review/"><img src="{$HostName}/images/menu1.gif" border="0" /></a></div>
			<div id="left_menu1"><a href="#"><img src="{$HostName}/images/menu2.gif" border="0" /></a></div>
			<div id="left_menu1"><a href="{$HostName}/go/adviser/"><img src="{$HostName}/images/menu3.gif" border="0" /></a></div>
			
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
			{/if}
		</div>
		
		<div id="main_content">
			<div id="kredit_text">
			{if $path}
			<a href="{$HostName}/">Главная</a> 
			{foreach from=$path item=p}
			 /	<a href="{$HostName}/content/node/{$p.category_id}/">{$p.short_description}</a> 
			{/foreach}
			{if $Record && $RecordAction }
				/ <a href="{$HostName}/content/record/{$Record->Data.listing_id}/">{$Record->Data.short_description}</a> 
			{/if}
			{/if}
			{if $Record && !$UsePath}
			
			<h1>{$Record->getTitle()}</h1>
			{if $Record->Data.main_image}<img src="{$HostName}/images/items/thumbs/{$Record->Data.main_image}" style="float:left;padding-right:20px">{/if}{$Record->getBody()}
			
				{if $Record->getType() =='category'}
					<ul>
					{foreach from=$Record->getChildNodes() item=n}
					<li><a href="{$HostName}/content/node/{$n->getId()}/">{$n->getTitle()}</a></li>
					{/foreach}
					{assign var="Items" value=$Record->getItems()}
					</ul>
					{if $Items}
					<h3>Записи</h3>
					<ul>
					{foreach from=$Items item=i}
					<li><a href="{$HostName}/content/record/{$i.listing_id}/">{$i.short_description|truncate:100:"":true}</a></li>
					{/foreach}
					</ul>
					{/if}
				{/if}
			{elseif $Path}
				{include file="$Path"}
			{else}
			<h1>No page</h1>
			{/if}
			</div>
			
			
			<div id="anons">
				{if $NewsNode}
				{foreach from=$NewsNode->getItems(null,3) item=n}
				<div id="anons1">
			
				<div class="title_anons"><a href="{$HostName}/content/record/{$n.listing_id}/">{$n.short_description}</a></div>
				{$n.long_description|truncate:100:"":true}
				</div>
				{/foreach}
				{/if}
			</div>
		</div>
		<div id="bottom">
			<div id="copyright">
			Все права защищены ооо "бенифит бай"
			</div>
			<div id="meshki">
			<img src="{$HostName}/images/meshki.png" />
			</div>
		</div>
	</div>
</body>
</html>