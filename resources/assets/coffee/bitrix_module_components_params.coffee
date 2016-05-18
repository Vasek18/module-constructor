# показ модального окна с доп. настройками
$('.option .modal').on 'show.bs.modal', (event) ->
	button = $(event.relatedTarget)
	row = button.parents(".row.option")
	type = row.find("[name *= _type]").val()
	modal_form = row.find('.modal')

	# скрываем все поля
	modal_form.find('.form-group').hide()
	# показываем поля доступные для этого типа поля
	modal_form.find('[data-for_types ~= "' + type + '"]').show()
	modal_form.find('[data-for_types = ""]').show() # и пустые тоже
	# блокируем исключающиеся варианты, если нужно
	modal_form.find(".only-one input:not([type=radio])").prop("disabled", true)
	if (!modal_form.find(".only-one input[type=radio]:checked"))
		modal_form.find(".only-one input[type=radio]:first").change()
	else
		modal_form.find(".only-one input[type=radio]:checked").parents(".item").find("input:not([type=radio])").prop("disabled",
			false)

	return

# блокировка и разблокировка вариантов опшионов у свойств - списков
$(document).on "change", ".option .modal .only-one [type=radio]", () ->
	item = $(this).parents(".item")
	items = $(".only-one .item")
	items.each(() ->
		$(this).find("input:not([type=radio])").prop("disabled", true)
	)
	item.find("input:not([type=radio])").prop("disabled", false)

	return