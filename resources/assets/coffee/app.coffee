#$('.draggable').draggable()
#
#$(document).on "mouseup", ".draggable", ->
#	$('.draggable .sort-val').each((i, el) ->
#		row = $(this).parents('.draggable');
#
#		# меняем сортировку
#		$(this).val(i)
#
#		return
#	)
#
#	return

$(document).on "change", "[data-transform]", ->
	input = $(this)
	val = $(this).val()
	transform = input.attr('data-transform').split(',')

	if (transform.indexOf('uppercase') != -1)
		input.val(val.toUpperCase())

	return

$(document).on "click", ".human_ajax_deletion", ->
	button = $(this)
	item = $(this).parents('.deletion_wrapper')
	method = button.attr('data-method');
	url = button.attr('href');

	$.ajax(
		url: url,
		data: "",
		type: method,
		success: (answer) ->
			return
	)

	item.remove()

	return false

$('[data-toggle="popover"]').popover()