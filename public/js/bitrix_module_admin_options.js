// показ модального окна с доп. настройками
// todo вывод уже установленных значений
$('#admin_options_dop_settings_window').on('show.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var row = button.parents(".row.option");
	var type_id = row.find("[name $= _type]").val();
	var modal_form = $('#admin_options_dop_settings_window form');
	var option_number = row.find('[name=option_number]').val();

	// запоминаем номер строки
	modal_form.find('[name=option_number]').val(option_number);

	// скрываем все поля
	modal_form.find('.form-group').hide();

	// показываем поля доступные для этого типа поля
	modal_form.find('[data-for_type_ids *= "' + type_id + '"]').show();
});
$('#admin_options_dop_settings_window').on('show.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var row = button.parents(".row.option");
	var type_id = row.find("[name $= _type]").val();

	// скрываем все поля
	$("#admin_options_dop_settings_window").find('.form-group').hide();

	// показываем поля доступные для этого типа поля
	$("#admin_options_dop_settings_window").find('[data-for_type_ids *= "' + type_id + '"]').show();
});

// сохранение значений полей
$('#admin_options_dop_settings_window .save').on('click', function(event){
	var form = $('#admin_options_dop_settings_window form');
	var option_number = form.find('[name=option_number]').val();
	var row = $(".row.option:has([name=option_number][value=" + option_number + "])");

	// сохраняем поля на странице
	var height = form.find("[name=option_height]").val();
	row.find("[name$=_height]").val(height);
	var width = form.find("[name=option_width]").val();
	row.find("[name$=_width]").val(width);

	$("#admin_options_dop_settings_window").modal("hide");
	form.trigger("reset");

	return false;
});