# при удалении удаляем элемент со страницы, а аяксом делаем сам запрос
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