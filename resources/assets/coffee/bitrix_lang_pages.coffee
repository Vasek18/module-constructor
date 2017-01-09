# чтобы нельзя было отправить форму по ентеру
$(document).on "submit", ".langs-form", () ->
	return false

# переделка работы формы на аякс, сложность в том, что нам важно на какую кнопку нажали
$(document).on "click", ".langs-form button", () ->
	button = $(this)
	row = button.parents('tr')

	form = button.parents('form')
	url = form.attr('action')
	method = form.attr('method')

	allButtons = form.find('button')
	allButtons.prop('disabled', true) # блокируем кнопки, потому что мы должны явно передавать позицию фразы в тексте, это убивает ассинхронность # todo избавиться от этого

	data = form.serializeArray()
	data.push({name: button.attr('name'), value: button.attr('value')})

	$.ajax url,
		method: method
		data: data
		error: (jqXHR, textStatus, errorThrown) ->
			location.reload() # всё равно пришлось бы перезагружать
			return
		success: (data, textStatus, jqXHR) ->
			# row.remove() # просто удаляем строку
			location.reload() # пока так
			return

	return false