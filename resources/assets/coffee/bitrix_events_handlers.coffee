# Подстановка нужных параметров при выборе события
$(document).on "change", "[name^=event]", () ->
	el = $(this)
	event = el.val()

	datalist = $("#" + el.attr("list"))
	datalistOption = datalist.find("[value=#{event}]")
	params = datalistOption.attr("data-params")

	row = el.parents(".option")
	paramsField = row.find("[name^=params]")

	if params
		paramsField.val(params)

	return
	