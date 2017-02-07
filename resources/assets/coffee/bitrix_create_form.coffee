# урл обязательно должен быть полным
$(document).on "change", '[name="PARTNER_URI"]', () ->
	input = $(this)
	url = input.val()
	httpServicePartOfString = url.substr(0, 7)
	httpsServicePartOfString = url.substr(0, 8)

	servicePartHttp = 'http://'
	servicePartHttps = 'https://'

	# проверяем наличие служебной части урла
	if httpServicePartOfString != servicePartHttp
		if httpsServicePartOfString != servicePartHttps
			# если нет её, то добавляем сами
			url = servicePartHttp + url
			input.val(url)