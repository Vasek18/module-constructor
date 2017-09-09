# показ разных доп. настроек для разных типов полей
$(document).on "change", ".js-change-fields-visibility", () ->
	selectedType = $(this).val();

	# скрываем все поля
	$('[data-for_types]').hide()

	# показываем поля доступные для этого типа поля
	$('[data-for_types ~= "' + selectedType + '"]').show()

	return
