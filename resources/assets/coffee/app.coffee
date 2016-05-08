$('.draggable').draggable()

$(document).on "mouseup", ".draggable", ->
	i = 0
	$('.draggable .sort-val').each( () ->
#		console.log this
		$(this).val(i)
		i++
	)
	return


#transliterate = (
#	() ->
#		rus = "щ   ш  ч  ц  ю  я  ё  ж  ъ  ы  э  а б в г д е з и й к л м н о п р с т у ф х ь".split('/ +/g')
#		eng = "shh sh ch cz yu ya yo zh '' y' e' a b v g d e z i j k l m n o p r s t u f x '".split('/ +/g')
#		return (text, engToRus) -> {
#			x
#			for (x = 0; x < rus.length; x++)
#				text = text.split(engToRus ? eng[x] : rus[x]).join(engToRus ? rus[x] : eng[x]);
#				text = text.split(engToRus ? eng[x].toUpperCase() : rus[x].toUpperCase()).join(engToRus ? rus[x].toUpperCase() : eng[x].toUpperCase());
#
#			return text
#)();
#var txt = "Съешь ещё этих мягких французских булок, да выпей же чаю!";
#alert(transliterate(txt));
#alert(transliterate(transliterate(txt), true));
