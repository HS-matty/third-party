
<html lang="ru">
<head>
	<title>{$title}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/select2.css">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/select2-bootstrap.css">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/notify.min.css">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/daterangepicker-bs3.min.css">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/main.css">
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/select2.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/select2_locale_ru.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/notify.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/moment.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/daterangepicker.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/main.js"></script>
</head>
<body>

	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img src="{$host_name}/public/images/logo.png" alt="AutoPAY" id="logo"></a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li {if $action == 'dashboard'} class="active" {/if}><a href="{$host_name}/autopay/Dashboard">Счета</a></li>
					<li {if $action == 'payments'} class="active" {/if}><a href="{$host_name}/autopay/Payments">История платежей</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Баланс <span class="badge">{$user->balance} RUR</span></a></li>
					<li class="dropdown" id="events-popup">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">События <span class="badge">{$payments_count}</span> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							{assign var=payments_rows value=$rowset_payments->rows}	
							{foreach from=$payments_rows item=prow}
							<li class="success"><a href="#"><span class="label label-default">{$prow.datetime}</span> Операция #{$prow.id} ({$prow.contractor_title}:{$prow.sum} RUR) выполнена успешно <button type="button" class="close">×</button></a></li-->
							{/foreach}
							<!--li class="success"><a href="#"><span class="label label-default">23:16</span> Операция #48151623 выполнена успешно <button type="button" class="close">×</button></a></li>
							<!--li class="danger"><a href="#"><span class="label label-default">23:16</span> Операция #48151622 НЕ выполнена! <button type="button" class="close">×</button></a></li>
							<li class="info"><a href="#"><span class="label label-default">23:16</span> [МТС (+375-33) 687-08-38] баланс менее 10 000 <button type="button" class="close">×</button></a></li>
							<li class="info"><a href="#"><span class="label label-default">23:16</span> [ByFly 215100109431] баланс менее 35 000 <button type="button" class="close">×</button></a></li-->
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Профиль<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="disabled"><a>{$user->email} #({$user->id})</a></li>
							<li><a href="{$host_name}/auth/logout">Выйти</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>


	<div class="container">
{if  $sub_page}	{include file="$sub_page"}		
		{else} 
		
		<h2>Page not found ..</h2>
		{/if}
		
</div>



	<div id="footer">
		<div class="container">
			<p class="text-muted">2014 © AutoPAY — автоматическая оплата ваших счётов
			<br/> < <a href="http://web-sys.us">web-sys 2.2</a> ></p>

		</div>
	</div>
	
</body>
</html>
