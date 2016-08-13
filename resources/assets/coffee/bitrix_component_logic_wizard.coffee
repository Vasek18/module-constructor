$(document).on "change", ".wizard input", () ->
	form = $('.wizard')
	url = form.attr('action')
	#	console.table form.serializeArray()

	$.get url, form.serializeArray(), (answer) ->
		if answer.component_php?
			$("#component_php").val(answer.component_php)
			window.editor_component.getSession().setValue(answer.component_php)

		if answer.class_php?
			$("#class_php").val(answer.class_php)
			window.editor_class.getSession().setValue(answer.class_php)
			$('#class_php_wrap').collapse('show')
		return

	return false