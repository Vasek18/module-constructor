# показ модального окна с доп. настройками
$('.options .modal').on 'show.bs.modal', (event) ->
	button = $(event.relatedTarget)
	row = button.parents(".row.option")
	type_id = row.find("[name *= _type]").val()
	modal_form = row.next(button.attr('data-target'))

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

$(document).on "click", ".add-dop-row", () ->
	row = $(this).parents('.row.overlast-row')
	number = $('.row.option:visible').length

	rowTemplate = $('.template-for-js').html()
	newRow = rowTemplate.replace(/__change_me_i_am_number__/g, number)

	row.before(newRow)

	false