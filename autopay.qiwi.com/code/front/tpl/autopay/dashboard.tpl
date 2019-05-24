
<table class="table table-bordered table-hover table-striped" id="accounts">
			<thead>
				<tr>
					<th>Получатель</th>
					<th>Описание</th>
					<th>Баланс</th>
					<th width="332">Опции</th>
				</tr>
			</thead>
			<tbody>
				{assign var=rows value=$rowset->rows}	
				{foreach from=$rows item=row}
				<tr data-id="{$row.service_id}">
					<td>{$row.contractor_title}</td>
					<td>{$row.phone_number}</td>
					<td><span class="label {if $row.balance <=0}label-danger{else}label-success{/if}">{if $row.balance >0}+{/if}{$row.balance}</span></td>
					<td>
						<a class="btn btn-success btn-xs pay" title="Перейти к оплате" data-amount="{$row.balance}"><span class="glyphicon glyphicon-ok"></span> Оплатить</a>
						<a class="btn btn-warning btn-xs autopay" title="Открыть настройки автооплаты"><span class="glyphicon glyphicon-repeat"></span> Авто оплата</a>
						<a class="btn btn-info btn-xs info" title="Открыть настройки информирования"><span class="glyphicon glyphicon-info-sign"></span> Информирование</a>
					</td>
				</tr>
				{/foreach}
				
			</tfoot>
		</table>


		<button type="button" class="btn btn-danger btn-lg" id="account-add-button"><span class="glyphicon glyphicon-plus"></span> Добавить счёт</button>
		
	</div>		
				
				
				
<div class="modal fade" id="account-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Добавление счёта</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="account-add-form">
				<fieldset>
					<div class="form-group">
						<label for="type" class="col-sm-2 control-label">Тип</label>
						<div class="col-sm-10">
							<select class="form-control" id="type" data-placeholder="Выберите тип">
								<option></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="provider" class="col-sm-2 control-label">Провайдер</label>
						<div class="col-sm-10">
							<select class="form-control" id="provider" data-placeholder="Выберите провайдера" disabled="">
								<option></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="col-sm-2 control-label">Номер телефона</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="phone" placeholder="Введите номер телефона" disabled="">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">Пароль</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="password" placeholder="Введите пароль от вашего кабинета" disabled="">
						</div>
					</div>
				</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Отмена</button>
				<button type="button" class="btn btn-success" id="account-add-form-button"><span class="glyphicon glyphicon-floppy-disk"></span> Добавить</button>
			</div>
		</div>
	</div>
</div>				
				


<div class="modal fade" id="pay-window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Оплата</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="pay-window-form">
				<fieldset>
					<div class="form-group">
						<label for="amount" class="col-sm-2 control-label">Сумма</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" id="amount" placeholder="Введите сумму" step="1" min="0">
						</div>
					</div>
				</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Отмена</button>
				<button type="button" class="btn btn-success" id="pay-window-form-button"><span class="glyphicon glyphicon-usd"></span> Оплатить</button>
			</div>
		</div>
	</div>
</div>
				


<div class="modal fade" id="autopay-window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Автооплата</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="autopay-window-form">
				<fieldset>
					<div class="form-group">
						<label for="period" class="col-sm-2 control-label">Период</label>
						<div class="col-sm-10">
							<select class="form-control" id="period">
								<option></option>
								<option value="day">Раз в сутки</option>
								<option value="week">Раз в неделю</option>
								<option value="month">Раз в месяц</option>
							</select>
						</div>
					</div>
					<div class="form-group" id="value-area">
						<label for="value" class="col-sm-2 control-label">Значение</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" id="value" placeholder="Введите день месяца" min="1" max="31" step="1" disabled="">
						</div>
					</div>
				</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Отмена</button>
				<button type="button" class="btn btn-success" id="autopay-window-form-button"><span class="glyphicon glyphicon-floppy-disk"></span> Применить</button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="info-window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Информирование</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
				<fieldset>
					<div class="form-group">
						<label for="period" class="col-sm-2 control-label">Условие</label>
						<div class="col-sm-10">
							<select class="form-control" id="period">
								<option value="day">Баланс менее</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="value" class="col-sm-2 control-label">Значение</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="value" placeholder="Введите значение">
						</div>
					</div>
					<div class="form-group">
						<label for="sms" class="col-sm-2 control-label">СМС</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control" id="sms">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="checkbox" class="form-control" id="email">
						</div>
					</div>
				</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Отмена</button>
				<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Применить</button>
			</div>
		</div>
	</div>