downloadAsInputName = "download_as"
downloadAsInput = $("[name=#{downloadAsInputName}]")
downloadAsInputUpdateVal = "update"
downloadAsInputFreshVal = "fresh"
downloadAsInputForTestVal = "for_test"

updateDescriptionInput = $("[name=description]")
updatePhpInput = $("[name=updater]")
filesEncodingInput = $("[name=files_encoding]")
filesEncodingInputUtfVal = "utf-8"
filesEncodingInputWindows1251Val = "windows-1251"
filesInput = $("[name^=files]")


$(document).on "change", "[name^=#{downloadAsInputName}]", () ->
	downloadAsInput = $(this)
	downloadAs = downloadAsInput.val()
	changeForm(downloadAs)

	return

$(document).ready ->
	changeForm(downloadAsInput.val())

	return

$(document).on "click", ".check-all", () ->
	filesInput.prop('checked', true) # отмечаем все файлы

	return false

changeForm = (downloadAs) ->
	if downloadAs == downloadAsInputFreshVal
		updateDescriptionInput.parents('.form-group').hide()
		updatePhpInput.parents('.form-group').hide()
		filesEncodingInput.val(filesEncodingInputWindows1251Val)
		filesInput.prop('checked', true) # отмечаем все файлы

	if downloadAs == downloadAsInputUpdateVal
		updateDescriptionInput.parents('.form-group').show()
		updatePhpInput.parents('.form-group').show()
		filesEncodingInput.val(filesEncodingInputWindows1251Val)

		filesInput.prop('checked', false)
		filesInput.filter('[data-changed="true"]').prop('checked', true) # отмечаем только изменённые файлы

	if downloadAs == downloadAsInputForTestVal
		updateDescriptionInput.parents('.form-group').hide()
		updatePhpInput.parents('.form-group').hide()
		filesEncodingInput.val(filesEncodingInputUtfVal)
		filesInput.prop('checked', true) # отмечаем все файлы