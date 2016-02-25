// показ модального окна с доп. настройками
$('.option .modal').on('show.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var row = button.parents(".row.option");
	var type_id = row.find("[name *= _type]").val();
	var modal_form = row.find('.modal');

	// скрываем все поля
	modal_form.find('.form-group').hide();
	// показываем поля доступные для этого типа поля
	modal_form.find('[data-for_type_ids *= "' + type_id + '"]').show();
	// блокируем исключающиеся варианты, если нужно
	modal_form.find(".only-one input:not([type=radio])").prop("disabled", true);
	modal_form.find(".only-one input[type=radio]:first").click();
});


// блокировка и разблокировка вариантов опшионов у свойств-списков
$(document).on("change", ".option .modal .only-one [type=radio]", function() {
	var item = $(this).parents(".item");
	var items = $(".only-one .item");
	items.each(function(){
		$(this).find("input:not([type=radio])").prop("disabled", true);
	});
	item.find("input:not([type=radio])").prop("disabled", false);
});