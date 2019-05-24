<?php /* Smarty version 2.6.14, created on 2014-05-18 12:53:15
         compiled from Z:%5Cweb-server-root%5Ccms/front/tpl/autopay/Payments.tpl */ ?>
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
			<?php $this->assign('rows', $this->_tpl_vars['rowset_payments']->rows); ?>	
			
			<tbody>
			<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['row']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
					<td><?php echo $this->_tpl_vars['row']['datetime']; ?>
</td>
					<td><?php echo $this->_tpl_vars['row']['type']; ?>
</td>
					<td><?php echo $this->_tpl_vars['row']['contractor_title']; ?>
</td>
					<td><?php echo $this->_tpl_vars['row']['sum']; ?>
</td>
					<td><?php if ($this->_tpl_vars['row']['status'] == 'success'): ?>Операция выполнена успешно<?php else:  echo $this->_tpl_vars['row']['status'];  endif; ?></td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>

	
		