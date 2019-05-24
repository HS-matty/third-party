<!DOCTYPE html>
<html lang="ru">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{$host_name}/public/lib/bootstrap/assets/css/notify.min.css">
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{$host_name}/public/lib/bootstrap/assets/js/notify.min.js"></script>
</head>
<body>

	<div id="wrap">

		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="admin">AutoPAY</a>
				</div>
			</div>
		</div>

		<div class="container" style="margin-top:80px">
		
			<div class="row">
				
				<div style="margin:0 auto;width:680px">
					
					<p><img src="{$host_name}/public/images/logo_big.png" class="img-responsive"></p>
					
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>AutoPAY - позволит вам:</h2>
					</div>
					<div class="panel-body">
						<ul>
							<li><h3>Просмотреть баланс всех ваших счетах.</h3></li>
							<li><h3>Быть всегда в курсе о них.</h3></li>
							<li><h3>Уменьшить время и упростить их оплату.</h3></li>
							<li><h3>Оплатить все счета в одном кабинете всего лишь одним кликом!</h3></li>
						</ul>
					</div>
				</div>
				
				<div style="margin:0 auto;width:185px"><button type="button" class="btn btn-success btn-lg start"><span class="glyphicon glyphicon-play"></span> Начать работу!</button></div>

			</div>
			
		</div>

	</div>		
				
				
				
				
<div class="modal fade" id="auth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal-sm">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Авторизация</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="auth-form">
				<fieldset>
					<div class="form-group">
						<label for="login" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" id="login" placeholder="Введите Email" value="test@autoplay">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Пароль</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="password" placeholder="Введите пароль" value="12345">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-success btn-block" id="auth-button" data-loading-text="Авторизация..."><span class="glyphicon glyphicon-log-in"></span> Войти</button>
						</div>
					</div>
				</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
{literal}
<script>
	var is_logged = false,
		home_dir = '/autopay/Dashboard';
		
	function loading() {
		
	}

	$('.start').click(function() {
		if ( ! is_logged) $('#auth').modal('show');
		else window.location.pathname = home_dir;
	});
	
	$('#auth').on('shown.bs.modal', function() {
		$('#login').focus();
	});
	
	$('#auth-form').on('keypress', '#login, #password', function() {
		$(this).parent(2).removeClass('has-error');
	});
	
	$('#auth-form').submit(function() {
		var $button = $('#auth-button'),
			$login = $('#login'),
			$password = $('#password'),
			login_val = $login.val(),
			password_val = $password.val();
		if (login_val && password_val) {
			loading(true);
			$button.button('loading');
			$fieldset = $('#auth-form > fieldset');
			$fieldset.attr('disabled', '')
			$.ajax({
				type: 'POST',
				url: '/auth/loginx',
				dataType: 'json',
				data: {login: login_val, password: password_val},
				complete: function(xhr, status) {
					loading(false);
					$button.button('reset');
					$fieldset.removeAttr('disabled');
					if (status != 'success') alert(status);
				},
				success: function(response) {
					if (response == 1) window.location.pathname = home_dir;
					else notify('Не верный логин или пароль');
				}
			});
		}
		else {
			if ( ! login_val) {
				$login.parent(2).addClass('has-error');
				if (password_val) notify('Введите Email!');
				$login.focus();
			}
			if ( ! password_val) {
				$password.parent(2).addClass('has-error');
				if (login_val) {
					notify('Введите пароль!');
					$password.focus();
				}
			}
			if ( ! login_val && ! password_val) notify('Введите Email и пароль!');
		}
		return false;
	});
</script>
{/literal}