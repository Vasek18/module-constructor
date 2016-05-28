$(document).on "click", ".available-vals a", ->
	textarea = $('[name=body]')
	text = textarea.val()
	variable = $(this).attr('data-var')
	textarea.val text + "#" + variable + "#"

	return false