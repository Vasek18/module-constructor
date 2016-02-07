$('#admin_options_dop_settings_window').on('show.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var row = button.parents(".row.option");
	var type_id = row.find("[name $= _type]").val();

	// скрываем все поля
	$("#admin_options_dop_settings_window").find('.form-group').hide();

	// показываем поля доступные для этого типа поля
	$("#admin_options_dop_settings_window").find('[data-for_type_ids *= "' + type_id + '"]').show();
});