# удаление с подтверждением в модалке
$(document).on "click", ".deletetion-with-confirm", ->
	a = $(this)
	href = a.attr('href')
	modal = $('#delete-confirm-modal')
	newLink = modal.find('.delete')

	modal.modal('show')
	newLink.attr('href', href)

	return false