$('.draggable').draggable()

$(document).on "mouseup", ".draggable", ->
	i = 0
	$('.draggable .sort-val').each( () ->
#		console.log this
		$(this).val(i)
		i++
	)
	return