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


	if (transform.indexOf('onlylatin') != -1)
		input.val(val.replace(/[^a-zA-Z]/g, ''))

	return

# запускаем бутстраповские поповеры
$('[data-toggle="popover"]').popover()

# по клику на таб добавляем хеш
$(document).on "shown.bs.tab", 'a[data-toggle="tab"]', ->
	hash = $(this).attr 'data-hash'

	if hash
		window.location.hash = hash;
	else
		window.location.hash = '';

	return


# если есть хеш, то показываем нужную вкладку активной
hash = window.location.hash.replace(/#/, '')
if (hash)
	if $(".tab-pane##{hash}").length
		# заголовок
		$("[data-toggle='tab']").parent('li').removeClass 'active'
		$("[data-toggle='tab'][href='##{hash}']").parent('li').addClass 'active'

		# содержание
		$(".tab-pane").removeClass 'active'
		$(".tab-pane##{hash}").addClass 'active'


# копирование текста из инпута в инпут
$(document).ready(->
	$("[data-copy_from]").each((index, element) ->
		elToListenID = $(element).attr('data-copy_from')
		elToChange = $(element)

		$(document).on "change", "##{elToListenID}", () ->
			val = $(this).val()
			elToChange.val(val)
			elToChange.change()

			return

		return
	)
	return
)