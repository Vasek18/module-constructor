# распаршивание описания на переменные
$(document).on "change", "#MAIL_EVENT_VARS", ->
	input = $(this)
	val = $(this).val()

#	vals = val.match(/#(.+)#\s*-\s*([^#]+)/gi)
#	console.log (vals)
#	console.log (vals[0])
#	console.log (vals[1])

	reg = /#(.+)#\s*-\s*([^#]+)/gi

	i = 0
	while (result = reg.exec(val))
		code = result[1]
		name = result[2]

		if code
			unless ($("[name*='MAIL_EVENT_VARS_CODES'").eq(i).length)
				$('.vals-list').append("<div class='form-group'>
				<div class='col-md-6'>
				<input class='form-control' type='text' placeholder='Название' name='MAIL_EVENT_VARS_NAMES[]' id='MAIL_EVENT_VARS_NAME_#{i}'>
				</div>
                        <div class='col-md-6'>
                            <input class='form-control' type='text' placeholder='Код' name='MAIL_EVENT_VARS_CODES[]' id='MAIL_EVENT_VARS_CODE_{#i}'>
                        </div>
				</div>")

			$("[name*='MAIL_EVENT_VARS_CODES'").eq(i).val(code)

		if name
			if ($("[name*='MAIL_EVENT_VARS_NAMES'").eq(i).length)
				$("[name*='MAIL_EVENT_VARS_NAMES'").eq(i).val(name)

		i++


	#arr = val.split('\r')
	#for own i, pair of arr
	#	console.log pair

	return