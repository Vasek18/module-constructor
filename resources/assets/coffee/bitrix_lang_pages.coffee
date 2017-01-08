## чтобы нельзя было отправить форму по ентеру
#$(document).on "submit", ".langs-form", () ->
#	return false
#
## переделка работы формы на аякс, сложность в том, что нам важно на какую кнопку нажали
#$(document).on "click", ".langs-form button", () ->
#	button = $(this)
#
#	form = button.parents('form')
#	url = form.attr('action')
#	method = form.attr('method')
#
#	data = form.serializeArray()
#	data.push({name: button.attr('name'), value: button.attr('value')})
#
#	$.ajax url,
#		method: method
#		data: data
#		error: (jqXHR, textStatus, errorThrown) ->
#			console.log 'fail'
#			return
#		success: (data, textStatus, jqXHR) ->
#			console.log 'success'
#			# todo
#			return
#
#	return false