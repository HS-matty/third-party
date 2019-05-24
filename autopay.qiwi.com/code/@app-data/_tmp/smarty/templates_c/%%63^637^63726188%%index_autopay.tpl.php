<?php /* Smarty version 2.6.14, created on 2014-05-18 13:26:59
         compiled from Z:%5Cweb-server-root%5Ccms/front/tpl/index_autopay.tpl */ ?>

<html lang="ru">
<head>
	<title><?php echo $this->_tpl_vars['title']; ?>
</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/select2.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/select2-bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/notify.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/daterangepicker-bs3.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/css/main.css">
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/select2_locale_ru.js"></script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/notify.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/daterangepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/lib/bootstrap/assets/js/main.js"></script>
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
				<a class="navbar-brand" href="#"><img src="<?php echo $this->_tpl_vars['host_name']; ?>
/public/images/logo.png" alt="AutoPAY" id="logo"></a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?php if ($this->_tpl_vars['action'] == 'dashboard'): ?> class="active" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/autopay/Dashboard">Счета</a></li>
					<li <?php if ($this->_tpl_vars['action'] == 'payments'): ?> class="active" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/autopay/Payments">История платежей</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Баланс <span class="badge"><?php echo $this->_tpl_vars['user']->balance; ?>
 RUR</span></a></li>
					<li class="dropdown" id="events-popup">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">События <span class="badge"><?php echo $this->_tpl_vars['payments_count']; ?>
</span> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php $this->assign('payments_rows', $this->_tpl_vars['rowset_payments']->rows); ?>	
							<?php $_from = $this->_tpl_vars['payments_rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['prow']):
?>
							<li class="success"><a href="#"><span class="label label-default"><?php echo $this->_tpl_vars['prow']['datetime']; ?>
</span> Операция #<?php echo $this->_tpl_vars['prow']['id']; ?>
 (<?php echo $this->_tpl_vars['prow']['contractor_title']; ?>
:<?php echo $this->_tpl_vars['prow']['sum']; ?>
 RUR) выполнена успешно <button type="button" class="close">×</button></a></li-->
							<?php endforeach; endif; unset($_from); ?>
							<!--li class="success"><a href="#"><span class="label label-default">23:16</span> Операция #48151623 выполнена успешно <button type="button" class="close">×</button></a></li>
							<!--li class="danger"><a href="#"><span class="label label-default">23:16</span> Операция #48151622 НЕ выполнена! <button type="button" class="close">×</button></a></li>
							<li class="info"><a href="#"><span class="label label-default">23:16</span> [МТС (+375-33) 687-08-38] баланс менее 10 000 <button type="button" class="close">×</button></a></li>
							<li class="info"><a href="#"><span class="label label-default">23:16</span> [ByFly 215100109431] баланс менее 35 000 <button type="button" class="close">×</button></a></li-->
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Профиль<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="disabled"><a><?php echo $this->_tpl_vars['user']->email; ?>
 #(<?php echo $this->_tpl_vars['user']->id; ?>
)</a></li>
							<li><a href="<?php echo $this->_tpl_vars['host_name']; ?>
/auth/logout">Выйти</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>


	<div class="container">
<?php if ($this->_tpl_vars['sub_page']): ?>	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['sub_page']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>		
		<?php else: ?> 
		
		<h2>Page not found ..</h2>
		<?php endif; ?>
		
</div>



	<div id="footer">
		<div class="container">
			<p class="text-muted">2014 © AutoPAY — автоматическая оплата ваших счётов
			<br/> < <a href="http://web-sys.us">web-sys 2.2</a> ></p>

		</div>
	</div>
	
</body>
</html>