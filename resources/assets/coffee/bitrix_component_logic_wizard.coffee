$(document).on "change", ".wizard input", () ->
	form = $('.wizard')
	url = form.attr('action')
	#	console.table form.serializeArray()

	$.get url, form.serializeArray(), (answer) ->
		console.log answer
		return

	return false