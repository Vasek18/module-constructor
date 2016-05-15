window.translit = (str, saveCase) ->
	arr = {
		'а': 'a',
		'б': 'b',
		'в': 'v',
		'г': 'g',
		'д': 'd',
		'е': 'e',
		'ё': 'yo',
		'ж': 'g',
		'з': 'z',
		'и': 'i',
		'й': 'y',
		'к': 'k',
		'л': 'l',
		'м': 'm',
		'н': 'n',
		'о': 'o',
		'п': 'p',
		'р': 'r',
		'с': 's',
		'т': 't',
		'у': 'u',
		'ф': 'f',
		'х': 'ch',
		'ц': 'c',
		'ч': 'ch',
		'ш': 'sh',
		'щ': 'sch',
		'ъ': '',
		'ь': '',
		'ы': 'y',
		'э': 'e',
		'ю': 'yu',
		'я': 'ya',
		'А': 'A',
		'Б': 'B',
		'В': 'V',
		'Г': 'G',
		'Д': 'D',
		'Е': 'E',
		'Ё': 'YO',
		'Ж': 'G',
		'З': 'Z',
		'И': 'I',
		'Й': 'Y',
		'К': 'K',
		'Л': 'L',
		'М': 'M',
		'Н': 'N',
		'О': 'O',
		'П': 'P',
		'Р': 'R',
		'С': 'S',
		'Т': 'T',
		'У': 'U',
		'Ф': 'F',
		'Х': 'CH',
		'Ц': 'C',
		'Ч': 'CH',
		'Ш': 'SH',
		'Щ': 'SCH',
		'Ъ': '',
		'Ь': '',
		'Ы': 'y',
		'Ю': 'YU',
		'Я': 'YA',
		'Э': 'E',
		'#': '',
		' ': '_',
		'(': '_',
		')': '_',
		',': '_',
		'!': '_'
		'?': '_'
	};

	replacer = (a) ->
		return if arr[a]? then arr[a] else a

	newStr = str.replace(/./g, replacer)
	newStr = newStr.replace(/__+/g, '_')

	unless saveCase
		newStr = newStr.toLowerCase()

	return newStr


# привязываемся к событию изменения поля с которого будем брать транслитерацию
$(document).ready( ->
	$("[data-translit_from]").each( (index, element) ->
		elToListenID = $(element).attr('data-translit_from')
		$("##{elToListenID}").attr('data-translit_to', $(element).attr('id'))

		$(document).on "change", "##{elToListenID}", () ->
			val = $(this).val()
			elToChangeID = $(this).attr('data-translit_to')
			$("##{elToChangeID}").val(translit(val))

		return
	)
	return
)