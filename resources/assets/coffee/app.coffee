$('.draggable').draggable()

$(document).on "mouseup", ".draggable", ->
	$('.draggable .sort-val').each((i, el) ->
		$(this).val(i)
		return
	)
	return