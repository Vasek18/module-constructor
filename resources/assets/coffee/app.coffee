# todo работа с textarea
$(document).on "click", "a.you-can-change", ->
	a = $(this)
	val = a.text()
	name = a.attr('data-name')
	pattern = a.attr('data-pattern')
	formtype = a.attr('data-formtype')
	form = a.parents('form')
	ajax = if a.hasClass('ajax') then 'ajax' else ''

	if (!formtype or formtype != 'textarea')
		a.replaceWith("<input type='text' class='form-control you-can-change #{ajax}' name='#{name}'' pattern='#{pattern}' value='#{val}'>")
	if formtype == 'textarea'
		a.replaceWith("<textarea class='form-control you-can-change #{ajax}' name='#{name}'' pattern='#{pattern}'>'#{val}'</textarea>")

	input = form.find("[name='#{name}']")
	input.focus()
	input.val(val) # помещение курсора в конец

	return false

# todo patterns bubbles
$(document).on "blur", "input.you-can-change, textarea.you-can-change", ->
	input = $(this)
	val = input.val()
	name = input.attr('name')
	pattern = input.attr('pattern')
	form = input.parents('form')
	ajax = if input.hasClass('ajax') then true else false


	action = form.attr('action')
	method = form.attr('method')
	if ajax
		$.ajax(
			url: action,
			data: form.serializeArray(),
			type: method,
			success: () ->
				input.replaceWith("<a class='you-can-change' data-name='#{name}'' data-pattern='#{pattern}'>#{val}</a>")

				return false
		)
	else
		form.submit()

	return false