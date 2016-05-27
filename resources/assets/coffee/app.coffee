$('.draggable').draggable()

$(document).on "mouseup", ".draggable", ->
	$('.draggable .sort-val').each((i, el) ->
		$(this).val(i)
		return
	)
	return

$(document).on "change", "[data-transform]", ->
	input = $(this)
	val = $(this).val()
	transform = input.attr('data-transform').split(',')

	if (transform.indexOf('uppercase') != -1)
		input.val(val.toUpperCase())

	return