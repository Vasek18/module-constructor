// активация readonly формы
$('.activate-form').on('click', function(event){
	var form = $('form.readonly');

	form.find("[readonly]").removeAttr("readonly");
	form.append('<button class="btn btn-primary">Сохранить</button>')

	return false;
});