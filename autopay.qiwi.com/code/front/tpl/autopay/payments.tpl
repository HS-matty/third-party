<form class="form-inline" id="filter">
		<fieldset>
			<div class="row">
				<div class="form-group col-sm-2">
					<label for="date-range">Дата</label>
					<input type="text" class="form-control input-sm" id="date-range" min="2014-02-23" value="2014-05-18" maxlength="21" autocomplete="off">
				</div>
				<div class="form-group col-sm-2">
					<button type="submit" class="btn btn-success btn-sm" id="filter-sumbit" data-loading-text="Подождите..."><span class="glyphicon glyphicon-ok"></span> Применить</button>
				</div>
			</div>
		</fieldset>
		</form>
		<table class="table table-bordered table-hover table-striped" id="accounts">
			<thead>
				<tr>
					<th>№</th>
					<th>Дата и время</th>
					<th>Тип</th>
					<th>Получатель</th>
					<th>Сумма (RUR)</th>
					<th>Статус</th>
				</tr>
			</thead>
			{assign var=rows value=$rowset_payments->rows}	
			
			<tbody>
			{foreach from=$rows item=row}
				<tr>
					<td>{$row.id}</td>
					<td>{$row.datetime}</td>
					<td>{$row.type}</td>
					<td>{$row.contractor_title}</td>
					<td>{$row.sum}</td>
					<td>{if $row.status == 'success'}Операция выполнена успешно{else}{$row.status}{/if}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>

	
		