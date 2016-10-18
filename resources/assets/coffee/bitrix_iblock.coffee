
# показ модального окна с доп. настройками
$('.prop .modal').on 'show.bs.modal', (event) ->
	button = $(event.relatedTarget)
	row = button.parents("tr")
	type_id = row.find("[name *= TYPE]").val()
	modal_form = $(button.attr('data-target'))

	# скрываем все поля
	modal_form.find('.form-group').hide()
	# показываем поля доступные для этого типа поля
	modal_form.find('[data-for_type_ids ~= "' + type_id + '"]').show()
	# блокируем исключающиеся варианты, если нужно
	modal_form.find(".only-one input:not([type=radio])").prop("disabled", true)
	if (!modal_form.find(".only-one input[type=radio]:checked").length)
		modal_form.find(".only-one input[type=radio]:first").click()
	else
		modal_form.find(".only-one input[type=radio]:checked").parents(".item").find("input:not([type=radio])").prop("disabled",
			false)

	return


# блокировка и разблокировка вариантов опшионов у свойств - списков
$(document).on "change", ".options .modal .only-one [type=radio]", () ->
	item = $(this).parents(".item")
	items = $(".only-one .item")
	items.each(() ->
		$(this).find("input:not([type=radio])").prop("disabled", true)
	)
	item.find("input:not([type=radio])").prop("disabled", false)

	return