function loading() {

}

function date_range(date_range_value)
{
	var date = [];
	date['start'] = date_range_value.substr(0, 10);
	if (date_range_value.length > 10) date['end'] = date_range_value.substr(-10); else date['end'] = date['start'];
	return date;
}

function period_select_value() {
	var period_val = $('#period').val(),
		$value_area = $('#value-area > div');
	switch (period_val) {
		case 'month': {
			$value_area.html('<input type="number" class="form-control" id="value" placeholder="Введите день месяца" min="1" max="31" step="1">');
		} break;
		case 'week': {
			$value_area.html(' \
				<select class="form-control" id="value" placeholder="Выберите день недели"> \
					<option></option> \
					<option value="1">Понедельник</option> \
					<option value="2">Вторник</option> \
					<option value="3">Среда</option> \
					<option value="4">Четверг</option> \
					<option value="5">Пятница</option> \
					<option value="6">Суббота</option> \
					<option value="7">Воскресенье</option> \
			');
		} break;
		case 'day': {
			$value_area.html('<input type="time" class="form-control" id="value" placeholder="Выберите время">');
		} break;
	}
}


$(function() {

	var row_id = null,
		amount = null;
	$('#accounts > tbody').on('click', 'a', function() {
		row_id = $(this).parents('tr').attr('data-id');
	});
	$('#accounts > tbody').on('click', '.pay', function() {
		amount = $(this).attr('data-amount');
		if (amount < 0) amount = Math.abs(amount);
		else amount = 0;
		$('#pay-window').modal('show');
	});
	$('#pay-window').on('shown.bs.modal', function() {
		var $amount = $('#amount');
		$amount.focus();
		$amount.val(amount);
	});
	$('#pay-window-form-button').click(function() {
		$(this).parents('.modal-content').find('form').submit();
	});
	$('#pay-window-form').submit(function() {
		var amount_val = $('#amount').val(),
			$button = $('#pay-window-form-button');
		if (amount_val <= 0) {
			notify('Введите значение больше нуля!');
			return;
		}
		loading(true);
		$button.button('loading');
		$fieldset = $('#pay-window-form-form > fieldset');
		$fieldset.attr('disabled', '');
		$.ajax({
			type: 'GET',
			url: '/autopay-datasource/doPayment',
			dataType: 'json',
			data: {
				service_id: row_id,
				amount: amount_val
			},
			complete: function(xhr, status) {
				loading(false);
				$button.button('reset');
				$fieldset.removeAttr('disabled');
				if (status != 'success') alert(status);
			},
			success: function(response) {
				if (response == 1) {
					notify('Оперция выполнена успешно!', 'success');
					$('#pay-window').modal('hide');
					setTimeout(function() {
						window.location.reload();
					}, 100);
				}
				else alert('Проверьте правильно полей!');
			}
		});
		return false;
	});
	
	$.ajax({
		type: 'GET',
		url: '/autopay-datasource/types',
		dataType: 'json',
		complete: function(xhr, status) {
			//loading(false);
			//if (status != 'success') alert(status);
		},
		success: function(response) {
			//if (response.status == 1) {
			$.each(response, function(index, value) {
				$('#type').append(new Option(value['title_ru'], value['id']));
			});
			//}
			//else alert(response.message);
		}
	});
	
	$('#type').change(function() {
		$('#provider').html('<option></option>');
		$.ajax({
			type: 'GET',
			url: '/autopay-datasource/contractors',
			data: {
				type_id: $(this).val()
			},
			dataType: 'json',
			complete: function(xhr, status) {
				loading(false);
				//if (status != 'success') alert(status);
			},
			success: function(response) {
				//if (response.status == 1) {
				$.each(response, function(index, value) {
					$('#provider').append(new Option(value['title'], value['id']));
				});
				$('#provider').removeAttr('disabled');
				//}
				//else alert(response.message);
			}
		});
		//$('#provider').removeAttr('disabled');
	});
	$('#provider').change(function() {
		$('#phone').removeAttr('disabled');
	});
	$('#phone').change(function() {
		$('#password').removeAttr('disabled');
	});
	$('#account-add-form-button').click(function() {
		$(this).parents('.modal-content').find('form').submit();
	});
	$('#account-add-form').submit(function() {
		var $button = $('#account-add-form-button');
		loading(true);
		$button.button('loading');
		$fieldset = $('#account-add-form > fieldset');
		$fieldset.attr('disabled', '');
		$.ajax({
			type: 'POST',
			url: '/autopay-datasource/addpayment',
			dataType: 'json',
			data: {
				type: $('#type').val(),
				contractor: $('#provider').val(),
				phone_number: $('#phone').val(),
				password: $('#password').val(),
			},
			complete: function(xhr, status) {
				loading(false);
				$button.button('reset');
				$fieldset.removeAttr('disabled');
				if (status != 'success') alert(status);
			},
			success: function(response) {
				if (response == 1) {
					notify('Счёт добавлен!', 'success');
					$('#account-add').modal('hide');
					setTimeout(function() {
						window.location.reload();
					}, 100);
				}
				else alert('Проверьте правильно полей!');
			}
		});
		return false;
	});
	
	$('#accounts > tbody').on('click', '.autopay', function() {
		$('#autopay-window').modal('show');
		var $period = $('#period'),
			$value = $('#value'),
			$fieldset = $('#autopay-window-form > fieldset');
		$period.val('');
		$value.val('');
		$fieldset.attr('disabled', '');
		$.ajax({
			type: 'GET',
			url: '/autopay-datasource/getSchedule',
			dataType: 'json',
			data: {
				service_id: row_id
			},
			complete: function(xhr, status) {
				loading(false);
				$fieldset.removeAttr('disabled');
				if (status != 'success') alert(status);
			},
			success: function(response) {
				if (response != null) {
					$period.val(response.period);
					$value.val(response.date);
				}
			}
		});
	});
	$('#period').change(function() {
		period_select_value();
	});
	$('#autopay-window-form-button').click(function() {
		$(this).parents('.modal-content').find('form').submit();
	});
	$('#autopay-window-form').submit(function() {
		var $button = $('#autopay-window-form-button');
		loading(true);
		$button.button('loading');
		$fieldset = $('#autopay-window-form > fieldset');
		$fieldset.attr('disabled', '');
		$.ajax({
			type: 'GET',
			url: '/autopay-datasource/addSchedule',
			dataType: 'json',
			data: {
				service_id: row_id, 
				period: $('#period').val(),
				date: $('#value').val()
			},
			complete: function(xhr, status) {
				loading(false);
				$button.button('reset');
				$fieldset.removeAttr('disabled');
				if (status != 'success') alert(status);
			},
			success: function(response) {
				if (response == 1) {
					notify('Настройки сохранены успешно!', 'success');
					$('#autopay-window').modal('hide');
				}
				else alert('Проверьте правильно полей!');
			}
		});
		return false;
	});
	
	$('#accounts > tbody').on('click', '.info', function() {
		$('#info-window').modal('show');
	});
	
	$('#account-add-button').click(function() {
		$('#account-add').modal('show');
	});
	
	$('#events-popup').on('click', 'ul li .close', function() {
		$(this).parent().parent().remove();
		var $events_counter = $('#events-popup > a > span'),
			events_counter_value = parseInt($events_counter.text());
		if (events_counter_value > 0) $events_counter.text(events_counter_value - 1);
		return false;
	});
	
	if ($('#type, #provider').length) $('#type, #provider').select2({allowClear: true});

	if ($('#date-range').length)
	{
		var date_val = date_range($('#date-range').val());
		$('#date-range').daterangepicker({
			startDate: date_val['start'],
			endDate: date_val['end'],
			minDate: $('#date-range').attr('min'),
			maxDate: moment(),
			showDropdowns: true,
			ranges: {
				'Сегодня': [moment(), moment()],
				'Вчера': [moment().subtract('days', 1), moment().subtract('days', 1)],
				'Последнии 7 дней': [moment().subtract('days', 6), moment()],
				'Последнии 30 дней': [moment().subtract('days', 29), moment()]
			},
			buttonClasses: ['btn btn-default'],
			applyClass: 'btn-sm btn-success',
			cancelClass: 'btn-sm',
			format: 'YYYY-MM-DD',
			separator: '/',
			locale: {
				applyLabel: '<span class="glyphicon glyphicon-ok"></span> Применить',
				cancelLabel: '<span class="glyphicon glyphicon-ban-circle"></span>',
				fromLabel: 'От',
				toLabel: 'До',
				customRangeLabel: 'ВЫБРАТЬ',
				daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июля', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
				firstDay: 1
			}
		});
	}

});